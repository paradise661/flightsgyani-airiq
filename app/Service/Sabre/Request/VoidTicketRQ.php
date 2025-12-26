<?php

namespace App\Service\Sabre\Request;

use App\Service\Sabre\SabreBasic;
use App\Service\XMLSerializer;
use DOMDocument;

class VoidTicketRQ extends SabreBasic
{

    public function doRequest($rph)
    {
        $body = $this->generateBody($rph);
        $strxml = $this->generateEnvelopeXmlWithSecurityHeaderFromBody('VoidTicketLLSRQ', $body);
        if (is_dir('../storage/app/public/international/' . session()->get('flight_search'))) {
            $file = '../storage/app/public/international/' . session()->get('flight_search') . '/VoidTicketRQ.txt';
            file_put_contents($file, $strxml);
        } else {
            mkdir('../storage/app/public/international/' . session()->get('flight_search'), 0755, true);
            $file = '../storage/app/public/international/' . session()->get('flight_search') . '/VoidTicketRQ.txt';
            file_put_contents($file, $strxml);
        }
        $response_xml = $this->doSoapRequest($strxml);
        $file = '../storage/app/public/international/' . session()->get('flight_search') . '/VoidTicketRS.txt';
        file_put_contents($file, $response_xml);
        $response = $this->formatResponse($response_xml);
        return $response;
    }

    public function generateBody($rph)
    {

        $body = [
            'VoidTicketRQ' => [
                '_attributes' => [
                    'xmlns' => 'http://webservices.sabre.com/sabreXML/2011/10',
                    'xmlns:xs' => 'http://www.w3.org/2001/XMLSchema',
                    'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
                    'Version' => '2.0.2'
                ],
                'Ticketing' => [
                    '_attributes' => [
                        'RPH' => $rph
                    ]
                ]
            ]
        ];


        $body_xml = XMLSerializer::generateValidXmlFromArray($body);
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
        return true;
    }
}
