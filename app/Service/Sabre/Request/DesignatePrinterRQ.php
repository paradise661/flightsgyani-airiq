<?php

namespace App\Service\Sabre\Request;

use App\Service\Sabre\SabreBasic;
use App\Service\XMLSerializer;
use DOMDocument;

class DesignatePrinterRQ extends SabreBasic
{
    public function doRequest()
    {
        $body = $this->generateBody();
        $xmlstr = $this->generateEnvelopeXmlWithSecurityHeaderFromBody('DesignatePrinterLLSRQ', $body);
        if (is_dir('../storage/app/public/international/' . session()->get('flight_search'))) {
            $checkfile = '../storage/app/public/international/' . session()->get('flight_search') . '/DesignatePrinterRQ.txt';
            if (file_exists($checkfile)) {
                $file = '../storage/app/public/international/' . session()->get('flight_search') . '/DesignatePrinterRQ' . time() . '.txt';
            } else {
                $file = $checkfile;
            }
            file_put_contents($file, $xmlstr);
        } else {
            mkdir('../storage/app/public/international/' . session()->get('flight_search'), 0755, true);
            $file = '../storage/app/public/international/' . session()->get('flight_search') . '/DesignatePrinterRQ.txt';
            file_put_contents($file, $xmlstr);
        }
        $response = $this->doSoapRequest($xmlstr);
        if (!$response) {
            return false;
        }
        $checkfile = '../storage/app/public/international/' . session()->get('flight_search') . '/DesignatePrinterRS.txt';
        if (file_exists($checkfile)) {
            $file = '../storage/app/public/international/' . session()->get('flight_search') . '/DesignatePrinterRS' . time() . '.txt';
        } else {
            $file = $checkfile;
        }
        file_put_contents($file, $response);
        $formatted_response = $this->formatResponse($response);
        return $formatted_response;

    }

    public function generateBody()
    {
        $timestamp = date("Y-m-d") . "T" . date("H-i-s") . "Z";
//        dd($this->lniata);
        $body_array = [

            'DesignatePrinterRQ ' => [
                '_attributes' => [
                    'xmlns' => 'http://webservices.sabre.com/sabreXML/2011/10',
                    'xmlns:xs' => 'http://www.w3.org/2001/XMLSchema',
                    'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
                    'ReturnHostCommand' => 'false',
                    'Version' => '2.0.1'
                ],
                'Printers' => [
                    'Hardcopy' => [
                        '_attributes' => [
                            'LNIATA' => $this->lniata
                        ]
                    ]
                ]
            ],
            'DesignatePrinterRQ  ' => [
                '_attributes' => [
                    'xmlns' => 'http://webservices.sabre.com/sabreXML/2011/10',
                    'xmlns:xs' => 'http://www.w3.org/2001/XMLSchema',
                    'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
                    'ReturnHostCommand' => 'false',
                    'Version' => '2.0.1'
                ],
                'Printers' => [
                    'InvoiceItinerary' => [
                        '_attributes' => [
                            'LNIATA' => $this->lniata
                        ]
                    ]
                ]
            ]
        ];
        $body_xml = XMLSerializer::generateValidXmlFromArray($body_array);
        return $body_xml;
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
