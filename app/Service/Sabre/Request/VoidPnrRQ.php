<?php

namespace App\Service\Sabre\Request;

use App\Service\Sabre\SabreBasic;
use App\Service\XMLSerializer;
use DOMDocument;

class VoidPnrRQ extends SabreBasic
{


    public function doRequest()
    {
        $body = $this->generateBody();
        $xmlstr = $this->generateEnvelopeXmlWithSecurityHeaderFromBody('OTA_CancelLLSRQ', $body);
        if (is_dir('../storage/app/public/international/' . session()->get('flight_search'))) {
            $checkfile = '../storage/app/public/international/' . session()->get('flight_search') . '/VoidPnrRQ.txt';
            if (file_exists($checkfile)) {
                $file = '../storage/app/public/international/' . session()->get('flight_search') . '/VoidPnrRQ' . time() . '.txt';
            } else {
                $file = $checkfile;
            }
            file_put_contents($file, $xmlstr);
        } else {
            mkdir('../storage/app/public/international/' . session()->get('flight_search'), 0755, true);
            $file = '../storage/app/public/international/' . session()->get('flight_search') . '/VoidPnrRQ.txt';
            file_put_contents($file, $xmlstr);
        }
        $raw_response = $this->doSoapRequest($xmlstr);
        $checkfile = '../storage/app/public/international/' . session()->get('flight_search') . '/VoidPnrRS.txt';
        if (file_exists($checkfile)) {
            $file = '../storage/app/public/international/' . session()->get('flight_search') . '/VoidPnrRS' . time() . '.txt';
        } else {
            $file = $checkfile;
        }
        file_put_contents($file, $raw_response);
        if (!$raw_response) {
            return false;
        }
        $response = $this->formatResponse($raw_response);
        return $response;

    }

    public function generateBody()
    {
        $body_array = [
            'OTA_CancelRQ' => [
                '_attributes' => [
                    'xmlns' => 'http://webservices.sabre.com/sabreXML/2011/10',
                    'xmlns:xs' => 'http://www.w3.org/2001/XMLSchema',
                    'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
                    'Version' => '2.0.2'
                ],
                'Segment' => [
                    '_attributes' => [
                        'Type' => 'entire'
                    ]
                ]
            ]
        ];

        $xml_body = XMLSerializer::generateValidXmlFromArray($body_array);
        return $xml_body;
    }

    public function formatResponse($response)
    {
        $doc = new DOMDocument();
        $doc->loadXML($response);
        $response_array = XMLSerializer::XMLtoArray($response);
        $soap_fault = $this->checkSoapFault($response_array);
        if ($soap_fault) {
            return false;
        }
        $status = $this->checkResponseStatus($doc);
        if (!$status) {
            return false;
        }

        return true;

    }
}
