<?php

namespace App\Service\Sabre\Request;

use App\Service\Sabre\SabreBasic;
use App\Service\XMLSerializer;
use DOMDocument;

class DesignatePrinter1RQ extends SabreBasic
{
    public function doRequest()
    {
        $body = $this->generateBody();
        $xmlstr = $this->generateEnvelopeXmlWithSecurityHeaderFromBody('DesignatePrinterLLSRQ', $body);
        if (is_dir('../storage/app/public/international/' . session()->get('flight_search'))) {
            $checkfile = '../storage/app/public/international/' . session()->get('flight_search') . '/DesignatePrinter1RQ.txt';
            if (file_exists($checkfile)) {
                $file = '../storage/app/public/international/' . session()->get('flight_search') . '/DesignatePrinter1RQ' . time() . '.txt';
            } else {
                $file = $checkfile;
            }
            file_put_contents($file, $xmlstr);
        } else {
            mkdir('../storage/app/public/international/' . session()->get('flight_search'), 0755, true);
            $file = '../storage/app/public/international/' . session()->get('flight_search') . '/DesignatePrinter1RQ.txt';
            file_put_contents($file, $xmlstr);
        }
        $xml_response = $this->doSoapRequest($xmlstr);
//        dd($xml_response);

        $checkfile = '../storage/app/public/international/' . session()->get('flight_search') . '/DesignatePrinter1RS.txt';
        if (file_exists($checkfile)) {
            $file = '../storage/app/public/international/' . session()->get('flight_search') . '/DesignatePrinter1RS' . time() . '.txt';
        } else {
            $file = $checkfile;
        }
        file_put_contents($file, $xml_response);
        if (!$xml_response) {
            return false;
        }
        return $this->formatResponse($xml_response);
    }

    public function generateBody()
    {
        $timestamp = date("Y-m-d") . "T" . date("H-i-s") . "Z";
        $body_array = [
            'DesignatePrinterRQ' => [
                '_attributes' => [
                    'xmlns' => 'http://webservices.sabre.com/sabreXML/2011/10',
                    'xmlns:xs' => 'http://www.w3.org/2001/XMLSchema',
                    'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',

                    'Version' => '2.0.1'
                ],
                'Printers' => [
                    'Ticket' => [
                        '_attributes' => [
                            'CountryCode' => 'IN'
                        ]
                    ]
                ]
            ],
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
