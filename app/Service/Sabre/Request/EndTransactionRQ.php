<?php

namespace App\Service\Sabre\Request;

use App\Service\Sabre\SabreBasic;
use App\Service\XMLSerializer;
use DOMDocument;

class EndTransactionRQ extends SabreBasic
{
    public function doRequest()
    {
        $body = $this->generateBody();
        $xmlstr = $this->generateEnvelopeXmlWithSecurityHeaderFromBody('EndTransactionLLSRQ', $body);
        if (is_dir('../storage/app/public/international/' . session()->get('flight_search'))) {
            $checkfile = '../storage/app/public/international/' . session()->get('flight_search') . '/EndTransactionRQ.txt';
            if (file_exists($checkfile)) {
                $file = '../storage/app/public/international/' . session()->get('flight_search') . '/EndTransactionRQ' . time() . '.txt';
            } else {
                $file = $checkfile;
            }
            file_put_contents($file, $xmlstr);
        } else {
            mkdir('../storage/app/public/international/' . session()->get('flight_search'), 0755, true);
            $file = '../storage/app/public/international/' . session()->get('flight_search') . '/EndTransactionRQ.txt';
            file_put_contents($file, $xmlstr);
        }
        $response = $this->doSoapRequest($xmlstr);
        $checkfile = '../storage/app/public/international/' . session()->get('flight_search') . '/EndTransactionRS.txt';
        if (file_exists($checkfile)) {
            $file = '../storage/app/public/international/' . session()->get('flight_search') . '/EndTransactionRS' . time() . '.txt';
        } else {
            $file = $checkfile;
        }
        file_put_contents($file, $response);
        return $this->formatResponse($response);
    }

    public function generateBody()
    {
        $body_array = [
            "EndTransactionRQ" => [
                "_attributes" => [
                    "xmlns" => "http://webservices.sabre.com/sabreXML/2011/10",
                    "xmlns:xs" => "http://www.w3.org/2001/XMLSchema",
                    "xmlns:xsi" => "http://www.w3.org/2001/XMLSchema-instance",
                    "Version" => "2.0.9"
                ],
                "EndTransaction" => [
                    "_attributes" => [
                        "Ind" => "true"
                    ]
                ],
                "Source" => [
                    "_attributes" => [
                        "ReceivedFrom" => "SWS TEST"
                    ]
                ]

            ]
        ];

        $body = XMLSerializer::generateValidXmlFromArray($body_array);
        return $body;
    }

    public function formatResponse($response)
    {
        $doc = new DOMDocument();
        $doc->loadXML($response);
        $response_array = XMLSerializer::XMLtoArray($response);
        $fault = $this->checkSoapFault($response_array);
        if ($fault) {
            return false;
        }
        $status = $this->checkResponseStatus($doc);
        if (!$status) {
            return false;
        }
        return true;
    }
}
