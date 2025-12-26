<?php

namespace App\Service\Sabre;

use App\Models\InternationalFlight\Airport;
use App\Service\XMLSerializer;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use SoapClient;

class SabreBasic
{

    public $pcc, $url, $username, $password, $message_id, $from, $citycode, $companycode, $addressline, $cityname, $countrycode,
        $postal, $streetnumber,$token,$lniata;

    public function __construct()
    {
        $this->token = session()->get('sabre_token');
        $this->pcc = Config::get('sabre.pcc');
        $this->url = Config::get('sabre.url');
        $this->username = Config::get('sabre.username');
        $this->password = Config::get('sabre.password');
        if (session()->has('conversation_id')) {
            $this->message_id = session()->get('conversation_id');
        } else {
            $this->message_id = $this->generateConversationId();
        }

        $this->from = Config::get('sabre.from');
        $this->lniata = Config::get('sabre.lniata');
        $this->citycode = Config::get('sabre.citycode');
        $this->companycode = 'TN';
        $this->addressline = Config::get('sabre.addressline');
        $this->cityname = Config::get('sabre.cityname');
        $this->countrycode = Config::get('sabre.countrycode');
        $this->postal = Config::get('sabre.postal');
        $this->streetnumber = Config::get('sabre.streetnumber');
    }

    protected function generateConversationId()
    {
        $id = substr(md5(time()), 1, 16);
//        dd($id);
        session()->put('conversation_id', $id);
        return $id;
    }

    static function generateFlightTime($minutes)
    {
        $hr = floor($minutes / 60);
        $mins = $minutes % 60;
        if ($hr > 0) {
            return $hr . ' Hr ' . $mins . ' mins';
        } else {
            return $mins . ' mins';
        }
    }

    public function createSoapClient()
    {
        $client = new SoapClient(null, array(
            'location' => ' https://sws-crt.cert.havail.sabre.com',
            'uri' => ' https://sws-crt.cert.havail.sabre.com',
            'trace' => 1,
            'exceptions' => true,
            'use' => 'wse'
        ));

        return $client;
    }

    public function getMealFromCode($code)
    {
        $meals = [
            'B' => 'BREAKFAST',
            'BP' => 'BERMUDA',
            'C' => 'ALCOHOL BEV/COMP',
            'CB' => 'CARIBBEAN PLAN',
            'CBA' => 'COMP DRINKS',
            'CP' => 'CONTINENTAL BFST',
            'D' => 'DINNER',
            'EDL' => 'COLD BREAKFAST',
            'EP' => 'EUROPEAN',
            'F' => 'FOOD FOR PURCHASE',
            'FDL' => 'COLD BRUNCH',
            'FP' => 'FAMILY PLAN',
            'H' => 'HOT MEAL',
            'K' => 'CONTINENTAL BFAST',
            'L' => 'LUNCH',
            'M' => 'MEALS',
            'MA' => 'MOD AMERICAN',
            'O' => 'COLD MEAL',
            'P' => 'ALCOHOL BEVERAGE ON PURCHASE',
            'S' => 'SNACK',
            'G' => 'FOOD AND BEVERAGE ON PURCHASE',
            'R' => 'REFRESHMENT - COMPLIMENTARY',
            'V' => 'REFRESHMENT FOR PURCHASE',
            'N' => 'NO MEAL SERVICE'
        ];
        if (isset($meals[$code])) {
            return $meals[$code];
        } else {
            return $code;
        }
    }

    protected function generateEnvelopeXmlWithSecurityHeaderFromBody($action, $body)
    {
        $timestamp = date("Y-m-d") . "T" . date("H-i-s") . "Z";
        $xmlStr = <<<XML
<?xml version='1.0' encoding='utf-8'?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
	<SOAP-ENV:Header>
		<eb:MessageHeader xmlns:eb="http://www.ebxml.org/namespaces/messageHeader">
                    <eb:From>
                        <eb:PartyId eb:type="urn:x12.org.IO5:01">$this->message_id</eb:PartyId>
                    </eb:From>
                    <eb:To>
                        <eb:PartyId eb:type="urn:x12.org.IO5:01">webservices.sabre.com</eb:PartyId>
                    </eb:To>
                    <eb:ConversationId>$this->message_id</eb:ConversationId>
                    <eb:Service eb:type="SabreXML">$action</eb:Service>
                    <eb:Action>$action</eb:Action>
                    <eb:CPAID>$this->pcc</eb:CPAID>
                    <eb:MessageData>
                        <eb:MessageId>$this->message_id</eb:MessageId>
                        <eb:Timestamp>$timestamp</eb:Timestamp>
                        <eb:TimeToLive>$timestamp</eb:TimeToLive>
                    </eb:MessageData>
                </eb:MessageHeader>
		<wsse:Security xmlns:wsse="http://schemas.xmlsoap.org/ws/2002/12/secext">
			<wsse:BinarySecurityToken valueType="String" EncodingType="wsse:Base64Binary">$this->token</wsse:BinarySecurityToken>
		</wsse:Security>
		</SOAP-ENV:Header>
	<SOAP-ENV:Body>
   $body
   </SOAP-ENV:Body>
</SOAP-ENV:Envelope>
XML;

        return $xmlStr;
    }

    protected function doSoapRequest($xmlStr)
    {
        $client = new SoapClient(null, array(
            'location' => $this->url,
            'uri' => $this->url,
            'trace' => 1,
            'exceptions' => true,
            'use' => 'wse'
        ));
        $response = $client->__doRequest($xmlStr, $this->url, $this->url, '1');
        $simple = "$response";
        return $simple;

    }

    protected function getFlightDate($string)
    {
        $date = explode('T', $string);
        return $date;
    }

    protected function checkResponseStatus($doc)
    {
        $application_status = $doc->getElementsByTagName('ApplicationResults')->item(0);

        if ($application_status) {
            $status = $application_status->getAttribute('status');

            if ($status == 'Complete') {
                return true;
            } else {
                $this->setErrorMessage($doc);
                return false;
            }
        }
        return true;

    }

    protected function setErrorMessage($doc)
    {
        $text = '';
        $result = $doc->getElementsByTagName('ApplicationResults')->item(0);
        $error = $result->getElementsByTagName('Error')->item(0);
        if ($error) {
            $messages = $error->getElementsByTagName('Message');
            foreach ($messages as $message) {
                $text = $text . '<br>' . $message->nodeValue;

            }
            Session::flash('warning', $text);
        }


    }

    protected function checkSoapFault($xml_array)
    {
        $soap_fault_body = Arr::get($xml_array, "SOAP-ENV:ENVELOPE.SOAP-ENV:BODY.SOAP-ENV:FAULT", false);
        if ($soap_fault_body) {
            Log::error("Soap Fault occured in " . get_class($this) . "\n" . XMLSerializer::generateValidXmlFromArray($soap_fault_body));
//            $this->logger->debug("Soap Fault occured in ".get_class($this)."\n".XMLSerializer::generateValidXmlFromArray($soap_fault_body));
            return true;
        }

        return false;
    }

    protected function getAirportName($code)
    {
        $airport = Airport::where('code', $code)->first();
        if (!$airport) {
            return 'Not Available';
        }
        return $airport->airport;
    }

    protected function getFlightClassFromCode($code)
    {
        $details =
            ['A' => 'First Class Discounted',
                'B' => 'Economy/Coach',
                'C' => 'Business Class',
                'D' => 'Business Class Discounted',
                'E' => 'Economy',
                'F' => 'First Class',
                'G' => 'Conditional Reservation',
                'H' => 'Economy',
                'I' => 'Business',
                'J' => 'Business Class Premium',
                'K' => 'Economy',
                'L' => 'Economy',
                'M' => 'Economy',
                'N' => 'Economy',
                'O' => 'Economy',
                'P' => 'First Class Premium',
                'Q' => 'Economy/Coach Discounted',
                'R' => 'First Class Suite',
                'S' => 'Economy',
                'T' => 'Economy',
                'U' => 'Shuttle Service',
                'V' => 'Economy',
                'W' => 'Economy',
                'X' => 'Economy',
                'Y' => 'Economy',
                'Z' => 'Business Class'
            ];

        return $details[$code];
    }
}

