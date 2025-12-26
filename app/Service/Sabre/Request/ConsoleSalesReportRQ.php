<?php

namespace App\Service\Sabre\Request;

use App\Service\XMLSerializer;
use Illuminate\Support\Facades\Config;

class ConsoleSalesReportRQ
{

    public function __construct()
    {
        $this->pcc = Config::get('sabre.pcc');
        $this->url = Config::get('sabre.url');

    }

    public function doRequest($token)
    {
        $requestXML = $this->generateBody($token);
        if (is_dir(storage_path('app/public/international/daily'))) {
            $file = storage_path('app/public/international/daily/SalesReportRQ-' . date('Y-m-d') . '.txt');
            file_put_contents($file, $requestXML);
        } else {
            mkdir(storage_path('app/public/international/daily', 0755, true));
            $file = storage_path('app/public/international/daily/SalesReportRQ-' . date('Y-m-d') . '.txt');
            file_put_contents($file, $requestXML);
        }
        $client = new \SoapClient(null, array(
            'location' => $this->url,
            'uri' => $this->url,
            'trace' => 1,
            'exceptions' => true,
            'use' => 'wse'
        ));
        $responseXML = $client->__doRequest($requestXML, $this->url, $this->url, '1');
        $file = storage_path('app/public/international/daily/SalesReportRS-' . date('Y-m-d') . '.txt');
        file_put_contents($file, $responseXML);
        return $this->formatResponse($requestXML);

    }

    public function generateBody($token)
    {
        $timestamp = date("Y-m-d") . "T" . date("H-i-s") . "Z";
        $pcc = config('sabre.pcc');
        $date = date('Y-m-d');
        $conversationId = substr(md5(time()), 1, 16);
        return <<<XML
<?xml version='1.0' encoding='utf-8'?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
	<SOAP-ENV:Header>
		<eb:MessageHeader xmlns:eb="http://www.ebxml.org/namespaces/messageHeader">
			<eb:From>
				<eb:PartyId eb:type="urn:x12.org.IO5:01">c5cffd9b061c2789</eb:PartyId>
			</eb:From>
			<eb:To>
				<eb:PartyId eb:type="urn:x12.org.IO5:01">webservices.sabre.com</eb:PartyId>
			</eb:To>
			<eb:ConversationId>$conversationId</eb:ConversationId>
			<eb:Service eb:type="SabreXML">DailySalesReportLLSRQ</eb:Service>
			<eb:Action>DailySalesReportLLSRQ</eb:Action>
			<eb:CPAID>$pcc</eb:CPAID>
			<eb:MessageData>
				<eb:MessageId>c5cffd9b061c2789</eb:MessageId>
				<eb:Timestamp>$timestamp</eb:Timestamp>
				<eb:TimeToLive>$timestamp</eb:TimeToLive>
			</eb:MessageData>
		</eb:MessageHeader>
		<wsse:Security xmlns:wsse="http://schemas.xmlsoap.org/ws/2002/12/secext">
			<wsse:BinarySecurityToken valueType="String" EncodingType="wsse:Base64Binary">$token</wsse:BinarySecurityToken>
		</wsse:Security>
	</SOAP-ENV:Header>
	<SOAP-ENV:Body>
		<DailySalesReportRQ xmlns="http://webservices.sabre.com/sabreXML/2011/10" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ReturnHostCommand="false" TimeStamp="2019-08-13T11:03:43" Version="2.0.0" >
			<SalesReport PseudoCityCode="$pcc" StartDate="$date" />
		</DailySalesReportRQ>
	</SOAP-ENV:Body>
</SOAP-ENV:Envelope>
XML;

    }

    public function formatResponse($responseXML)
    {
        $doc = new \DOMDocument();
        $doc->loadXML($responseXML);
        $application_status = $doc->getElementsByTagName('ApplicationResults')->item(0);

        if ($application_status) {
            $status = $application_status->getAttribute('status');

            if ($status != 'Complete') {
                return false;
            }
        }

        $response_array = XMLSerializer::XMLtoArray($responseXML);
        $soap_fault_body = array_get($response_array, "SOAP-ENV:ENVELOPE.SOAP-ENV:BODY.SOAP-ENV:FAULT", false);
        if ($soap_fault_body) {
            return false;
        }

        $formattedResponse = [];
        $datas = $doc->getElementsByTagName('IssuanceData');
        foreach ($datas as $data) {
            $record = [];
            $record['commission'] = $data->getAttribute('Commission');
            $record['time'] = $data->getAttribute('IssueTime');
            $record['pnr'] = $data->getAttribute('ItineraryRef');
            $payments = $data->getElementsByTagName('Payment');
            foreach ($payments as $payment) {
                $amounts = $payment->getElementsByTagName('Form');
                foreach ($amounts as $amount) {
                    $price = $amount->getAttribute('Amount');
                    $currency = $amount->getAttribute('CurrencyCode');
//                    array_push($record,[
//                        'amount'=>$price,
//                        'currency'=>$currency,
//                    ]);
                    $record['amount'] = $price;
                    $record['currency'] = $currency;
                }
            }
            $passengers = $data->getElementsByTagName('PersonName');
            foreach ($passengers as $passenger) {
                $pax = $passenger->nodeValue;
//                array_push($record,[
//                    'pax'=>$pax
//                ]);
                $record['pax'] = $pax;
            }
            $tickets = $data->getElementsByTagName('TicketingInfo');
            foreach ($tickets as $ticket) {
                $infos = $ticket->getElementsByTagName('Ticketing');
                foreach ($infos as $info) {
                    $ticket_no = $info->getAttribute('eTicketNumber');
//                    array_push($record,[
//                        'ticket'=>$ticket_no
//                    ]);
                    $record['ticket'] = $ticket_no;
                }
            }
            array_push($formattedResponse, $record);
        }
        return $formattedResponse;
    }


}
