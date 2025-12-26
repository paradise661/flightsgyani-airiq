<?php

namespace App\Service\Sabre\Request;

use App\Service\Sabre\SabreBasic;
use App\Service\XMLSerializer;

class SessionCloseRQ extends SabreBasic
{
    public function doRequest()
    {
        $body = $this->generateBody();
        $xmlStr = $this->generateEnvelopeXmlWithSecurityHeaderFromBody('SessionCloseRQ', $body);
        if (is_dir('../storage/app/public/international/' . session()->get('flight_search'))) {
            $checkfile = '../storage/app/public/international/' . session()->get('flight_search') . '/SessionCloseRQ.txt';
            if (file_exists($checkfile)) {
                $file = '../storage/app/public/international/' . session()->get('flight_search') . '/SessionCloseRQ' . time() . '.txt';
            } else {
                $file = $checkfile;
            }
            file_put_contents($file, $xmlStr);
        } else {
            mkdir('../storage/app/public/international/' . session()->get('flight_search'), 0755, true);
            $file = '../storage/app/public/international/' . session()->get('flight_search') . '/SessionCloseRQ.txt';
            file_put_contents($file, $xmlStr);
        }
        $raw_response = $this->doSoapRequest($xmlStr);
        $checkfile = '../storage/app/public/international/' . session()->get('flight_search') . '/SessionCloseRS.txt';
        if (file_exists($checkfile)) {
            $file = '../storage/app/public/international/' . session()->get('flight_search') . '/SessionCloseRS' . time() . '.txt';
        } else {
            $file = $checkfile;
        }
        file_put_contents($file, $raw_response);
        return $this->formatResponse($raw_response);
    }

    public function generateBody()
    {
        $body_array = [
            'SessionCloseRQ' => [
                'POS' => [
                    'Source' => [
                        '_attributes' => [
                            'PseudoCityCode' => $this->pcc
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
        $doc = new \DOMDocument();
        $doc->loadXML($response);
        $xml_array = XMLSerializer::XMLtoArray($response);
        $fault = $this->checkSoapFault($xml_array);
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
