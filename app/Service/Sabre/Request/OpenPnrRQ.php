<?php

namespace App\Service\Sabre\Request;

use App\Model\InternationalFlight\FlightBooking;
use App\Service\Sabre\SabreBasic;
use App\Service\XMLSerializer;
use DOMDocument;

class OpenPnrRQ extends SabreBasic
{
    public function doRequest($pnr, $action = null)
    {
//        dd($pnr);


        $body = $this->generateBody($pnr);
        $xmlstr = $this->generateEnvelopeXmlWithSecurityHeaderFromBody('GetReservationRQ', $body);
        if (is_dir('../storage/app/public/international/' . session()->get('flight_search'))) {
            $checkfile = '../storage/app/public/international/' . session()->get('flight_search') . '/OpenPnrRQ.txt';
            if (file_exists($checkfile)) {
                $file = '../storage/app/public/international/' . session()->get('flight_search') . '/OpenPnrRQ' . time() . '.txt';
            } else {
                $file = $checkfile;
            }
            file_put_contents($file, $xmlstr);
        } else {
            mkdir('../storage/app/public/international/' . session()->get('flight_search'), 0755, true);
            $file = '../storage/app/public/international/' . session()->get('flight_search') . '/OpenPnrRQ.txt';
            file_put_contents($file, $xmlstr);
        }
        $response = $this->doSoapRequest($xmlstr);
        $checkfile = '../storage/app/public/international/' . session()->get('flight_search') . '/OpenPnrRS.txt';
        if (file_exists($checkfile)) {
            $file = '../storage/app/public/international/' . session()->get('flight_search') . '/OpenPnrRS' . time() . '.txt';
        } else {
            $file = $checkfile;
        }
        file_put_contents($file, $response);

        if ($action == 'Details') {
            return $this->getDetails($response);
        }

        return $this->formatResponse($response);
    }

    public function generateBody($pnr)
    {

        $get_reservation = [
            "GetReservationRQ" => [
                '_attributes' => [
                    'xmlns' => "http://webservices.sabre.com/pnrbuilder/v1_19",
                    'Version' => "1.19.0"
                ],
                "Locator" => $pnr,
                "RequestType" => "Stateful",
                "ReturnOptions" => [
                    "SubjectAreas" => [
                        "SubjectArea" => "ACTIVE",
                        "SubjectArea " => "ANCILLARY",
                        "SubjectArea  " => "FARETYPE",
                        "SubjectArea   " => "FQTV",
                        "SubjectArea    " => "HEADER",
                        "SubjectArea     " => "PRICE_QUOTE",
                        "SubjectArea      " => "TICKETING"
                    ],
                    "ViewName" => "Default",
                    "ResponseFormat" => "STL"
                ]
            ]
        ];

        $xml_body = XMLSerializer::generateValidXmlFromArray($get_reservation);
        return $xml_body;
    }

    public function getDetails($response)
    {
        $doc = new DOMDocument();
        $doc->loadXML($response);
        $response_array = XMLSerializer::XMLtoArray($response);
        $fault = $this->checkSoapFault($response_array);
        if ($fault) {
            return false;
        }
        $passengerNode = $doc->getElementsByTagName('Passengers')->item(0);
        $passengers = $passengerNode->getElementsByTagName('Passenger');
        foreach ($passengers as $passenger) {
            $last_name = $passenger->getElementsByTagName('LastName')->item(0)->nodeValue;
            $first_name = $passenger->getElementsByTagName('FirstName')->item(0)->nodeValue;

        }
    }

    public function formatResponse($response)
    {

//        $response = $this->tempResponse();
        $doc = new DOMDocument();
        $doc->loadXML($response);
        $response_array = XMLSerializer::XMLtoArray($response);
        $fault = $this->checkSoapFault($response_array);
        if ($fault) {
            return false;
        }

        return true;
    }

}
