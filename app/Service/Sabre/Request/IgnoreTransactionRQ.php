<?php

namespace App\Service\Sabre\Request;

use App\Service\Sabre\SabreBasic;
use App\Service\XMLSerializer;
use DOMDocument;

class IgnoreTransactionRQ extends SabreBasic
{
    public function doRequest()
    {
        $body = $this->generateBody();
        $xml_str = $this->generateEnvelopeXmlWithSecurityHeaderFromBody('IgnoreTransactionLLSRQ', $body);
        if (is_dir('../storage/app/public/international/' . session()->get('flight_search'))) {
            $checkfile = '../storage/app/public/international/' . session()->get('flight_search') . '/IgnoreTransactionRQ.txt';
            if (file_exists($checkfile)) {
                $file = '../storage/app/public/international/' . session()->get('flight_search') . '/IgnoreTransactionRQ' . time() . '.txt';
            } else {
                $file = $checkfile;
            }
            file_put_contents($file, $xml_str);
        } else {
            mkdir('../storage/app/public/international/' . session()->get('flight_search'), 0755, true);
            $file = '../storage/app/public/international/' . session()->get('flight_search') . '/IgnoreTransactionRQ.txt';
            file_put_contents($file, $xml_str);
        }
        $response = $this->doSoapRequest($xml_str);
        $checkfile = '../storage/app/public/international/' . session()->get('flight_search') . '/IgnoreTransactionRS.txt';
        if (file_exists($checkfile)) {
            $file = '../storage/app/public/international/' . session()->get('flight_search') . '/IgnoreTransactionRS' . time() . '.txt';
        } else {
            $file = $checkfile;
        }
        file_put_contents($file, $response);
        if (!$response) {
            return false;
        }
        $formatted_response = $this->formatResponse($response);
        return $formatted_response;
    }

    public function generateBody()
    {
        $body = [
            'IgnoreTransactionRQ' => [
                '_attributes' => [
                    'xmlns' => 'http://webservices.sabre.com/sabreXML/2011/10',
                    'xmlns:xs' => 'http://www.w3.org/2001/XMLSchema',
                    'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
                    'Version' => '2.0.0'
                ]
            ]
        ];
        $body_xml = XMLSerializer::generateValidXmlFromArray($body);
        return $body_xml;
    }

    public function formatResponse($response)
    {
//        dd($response);
        $doc = new DOMDocument();
        $xml = $doc->loadXML($response);
        $xml_array = XMLSerializer::XMLtoArray($response);
        $fault = $this->checkSoapFault($xml_array);
        if ($fault) {
            return false;
        }
        $status = $this->checkResponseStatus($doc);
        if (!$status) {
            return false;
        }
        $status = $doc->getElementsByTagName('ApplicationResults')->item(0)->getAttribute('status');
        if ($status != 'Complete') {
            return false;
        }
        return true;
    }
}
