<?php

namespace App\Service\Sabre\Request;

use App\Service\Sabre\SabreBasic;
use App\Service\XMLSerializer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SalesReportRQ extends SabreBasic
{
    public function doRequest($date)
    {
        $bodyXML = $this->generateBody($date);
//        $response = $this->tempResponse();
//        return $this->formatResponse($response);
        $requestXML = $this->generateEnvelopeXmlWithSecurityHeaderFromBody('DailySalesReportLLSRQ', $bodyXML);
        if (is_dir(storage_path('/app/public/international/admin'))) {
            $file = storage_path('/app/public/international/admin/SalesReportRQ-' . Auth::user()->name . '-' . time() . '.txt');
            file_put_contents($file, $requestXML);
        } else {
            mkdir(storage_path('/app/public/international/admin'), 0755, true);
            $file = storage_path('/app/public/international/admin/SalesReportRQ-' . Auth::user()->name . '-' . time() . '.txt');
            file_put_contents($file, $requestXML);
        }
        $responseXML = $this->doSoapRequest($requestXML);
        $file = storage_path('/app/public/international/admin/SalesReportRS-' . Auth::user()->name . '-' . time() . '.txt');
        file_put_contents($file, $responseXML);
        return $this->formatResponse($responseXML);

    }

    public function generateBody($date)
    {
        $timestamp = date("Y-m-d") . "T" . date("H:i:s");
//        dd($timestamp);
        $body = [
            'DailySalesReportRQ' => [
                '_attributes' => [
                    'xmlns' => 'http://webservices.sabre.com/sabreXML/2011/10',
                    'xmlns:xs' => 'http://www.w3.org/2001/XMLSchema',
                    'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
                    'ReturnHostCommand' => 'false',
                    'TimeStamp' => $timestamp,
                    'Version' => '2.0.0'
                ],
                'SalesReport' => [
                    '_attributes' => [
                        'PseudoCityCode' => $this->pcc,
                        'StartDate' => Carbon::parse($date)->format('Y-m-d')
                    ]
                ]
            ]
        ];

        $body_xml = XMLSerializer::generateValidXmlFromArray($body);
        return $body_xml;
    }

    public function formatResponse($responseXML)
    {
        $doc = new \DOMDocument();
        $doc->loadXML($responseXML);
        $response_array = XMLSerializer::XMLtoArray($responseXML);
        $fault = $this->checkSoapFault($response_array);
        if ($fault) {
            return false;
        }
        $formattedResponse = [];

        $datas = $doc->getElementsByTagName('IssuanceData');
        foreach ($datas as $data) {
            $record = [];
            $commission = $data->getAttribute('Commission');
            if (!isset($commission)) {
                $record['commission'] = 0;
            } else {
                $record['commission'] = $commission;
            }
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

    public function tempResponse()
    {
        return <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<soap-env:Envelope xmlns:soap-env="http://schemas.xmlsoap.org/soap/envelope/">
    <soap-env:Header>
        <eb:MessageHeader xmlns:eb="http://www.ebxml.org/namespaces/messageHeader" eb:version="1.0" soap-env:mustUnderstand="1">
            <eb:From>
                <eb:PartyId eb:type="urn:x12.org.IO5:01">webservices.sabre.com</eb:PartyId>
            </eb:From>
            <eb:To>
                <eb:PartyId eb:type="urn:x12.org.IO5:01">info@fastintl.com</eb:PartyId>
            </eb:To>
            <eb:CPAId>SE1J</eb:CPAId>
            <eb:ConversationId>111@fastintl.com</eb:ConversationId>
            <eb:Service eb:type="SabreXML">Sales Report</eb:Service>
            <eb:Action>DailySalesReportLLSRS</eb:Action>
            <eb:MessageData>
                <eb:MessageId>518432204859290151</eb:MessageId>
                <eb:Timestamp>2019-08-11T05:41:26</eb:Timestamp>
                <eb:RefToMessageId>mid:11110info@fastintl.com</eb:RefToMessageId>
            </eb:MessageData>
        </eb:MessageHeader>
        <wsse:Security xmlns:wsse="http://schemas.xmlsoap.org/ws/2002/12/secext">
            <wsse:BinarySecurityToken valueType="String" EncodingType="wsse:Base64Binary">Shared/IDL:IceSess\/SessMgr:1\.0.IDL/Common/!ICESMS\/ACPCRTD!ICESMSLB\/CRT.LB!-2986432167428963443!236067!0</wsse:BinarySecurityToken>
        </wsse:Security>
    </soap-env:Header>
    <soap-env:Body>
        <DailySalesReportRS xmlns="http://webservices.sabre.com/sabreXML/2011/10" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:stl="http://services.sabre.com/STL/v01" Version="2.0.0">
            <stl:ApplicationResults status="Complete">
                <stl:Success timeStamp="2019-08-11T00:41:25-05:00"/>
            </stl:ApplicationResults>
            <SalesReport>
                <CreationDetails>
                    <Source AgencyName="FAST INTERNATIONA" CreateDateTime="2019-07-28" PseudoCityCode="SE1J"/>
                </CreationDetails>
                <IssuanceData AgentSine="AWS" Commission="164" DocumentType="T" DomesticInternational="I" IndicatorTwo="ET" IssueTime="1731" ItineraryRef="LTTJBH" StockItemCount="1" TicketPrinter="1" TicketStock="IN">
                    <Payment>
                        <Form Amount="16092" CurrencyCode="NPR">CA</Form>
                    </Payment>
                    <PersonName>SHRESTHA/SAROJ KUMAR</PersonName>
                    <TicketingInfo>
                        <Ticketing Ind="ETR" UsedCount="1" eTicketNumber="5893458388891"/>
                    </TicketingInfo>
                </IssuanceData>
                <IssuanceData AgentSine="AWS" Commission="205" DocumentType="T" DomesticInternational="I" IndicatorOne="V" IndicatorTwo="ET" IssueTime="1727" ItineraryRef="LTTJBH" StockItemCount="1" TicketPrinter="1" TicketStock="IN">
                    <Payment>
                        <Form Amount="16051" CurrencyCode="NPR">CA</Form>
                    </Payment>
                    <PersonName>SHRESTHA/SAROJ KUMAR</PersonName>
                    <TicketingInfo>
                        <Ticketing Ind="ETR" UsedCount="1" eTicketNumber="5893458388890"/>
                    </TicketingInfo>
                </IssuanceData>
                <IssuanceData AgentSine="AWS" Commission="205" DocumentType="T" DomesticInternational="I" IndicatorOne="V" IndicatorTwo="ET" IssueTime="1723" ItineraryRef="LTTJBH" StockItemCount="1" TicketPrinter="1" TicketStock="IN">
                    <Payment>
                        <Form Amount="16051" CurrencyCode="NPR">CA</Form>
                    </Payment>
                    <PersonName>SHRESTHA/SAROJ KUMAR</PersonName>
                    <TicketingInfo>
                        <Ticketing Ind="ETR" UsedCount="1" eTicketNumber="5893458388889"/>
                    </TicketingInfo>
                </IssuanceData>
            </SalesReport>
        </DailySalesReportRS>
    </soap-env:Body>
</soap-env:Envelope>
XML;

    }
}
