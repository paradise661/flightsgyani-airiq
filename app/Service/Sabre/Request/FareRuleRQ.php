<?php

namespace App\Service\Sabre\Request;

use App\Service\Sabre\SabreBasic;
use App\Service\XMLSerializer;
use Carbon\Carbon;

class FareRuleRQ extends SabreBasic
{

    public function doRequest($code, $date)
    {
        $body = $this->generateBody($code, $date);
        $xmlstr = $this->generateEnvelopeXmlWithSecurityHeaderFromBody('OTA_AirRulesLLSRQ', $body);
        if (is_dir('../storage/app/public/international/' . session()->get('flight_search'))) {
            $checkfile = '../storage/app/public/international/' . session()->get('flight_search') . '/FareRuleRQ.txt';
            if (file_exists($checkfile)) {
                $file = '../storage/app/public/international/' . session()->get('flight_search') . '/FareRuleRQ' . time() . '.txt';
            } else {
                $file = $checkfile;
            }
            file_put_contents($file, $xmlstr);
        } else {
            mkdir('../storage/app/public/international/' . session()->get('flight_search'), 0755, true);
            $file = '../storage/app/public/international/' . session()->get('flight_search') . '/FareRuleRQ.txt';
            file_put_contents($file, $xmlstr);
        }
        $response = $this->doSoapRequest($xmlstr);
        $checkfile = '../storage/app/public/international/' . session()->get('flight_search') . '/FareRuleRS.txt';
        if (file_exists($checkfile)) {
            $file = '../storage/app/public/international/' . session()->get('flight_search') . '/FareRuleRS' . time() . '.txt';
        } else {
            $file = $checkfile;
        }
        file_put_contents($file, $response);
        if (!$response) {
            return false;
        }
        return $this->formatResponse($response);
    }

    public function generateBody($code, $date)
    {

        $body = [
            'OTA_AirRulesRQ' => [
                '_attributes' => [
                    'xmlns' => 'http://webservices.sabre.com/sabreXML/2011/10',
                    'xmlns:xs' => 'http://www.w3.org/2001/XMLSchema',
                    'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
                    'Version' => '2.2.0',
                    'ReturnHostCommand' => 'true'
                ],
                'OriginDestinationInformation' => [
                    'FlightSegment' => [
                        '_attributes' => [
                            'DepartureDateTime' => $this->formatDate($date),
                        ],
                        'DestinationLocation' => [
                            '_attributes' => [
                                'LocationCode' => $code['end']
                            ]
                        ],
                        'MarketingCarrier' => [
                            '_attributes' => [
                                'Code' => $code['air'],
                            ]
                        ],
                        'OriginLocation' => [
                            '_attributes' => [
                                'LocationCode' => $code['start']
                            ]
                        ]
                    ]
                ],
                'RuleReqInfo' => [
                    'FareBasis' => [
                        '_attributes' => [
                            'Code' => $code['code']
                        ]
                    ]
                ]
            ]
        ];


        $body_array = XMLSerializer::generateValidXmlFromArray($body);
        return $body_array;
    }

    public function formatDate($date)
    {
        return Carbon::parse($date)->format('m-d');
    }

    public function formatResponse($response)
    {
        $doc = new \DOMDocument();
        $doc->loadXML($response);
        $res_array = XMLSerializer::XMLtoArray($response);
        $fault = $this->checkSoapFault($res_array);
        if ($fault) {
            return false;
        }
        $status = $this->checkResponseStatus($doc);
        if (!$status) {
            return false;
        }
        $rules = $doc->getElementsByTagName('Paragraph');
        $formatted_response = [];
        foreach ($rules as $rule) {
            $title = $rule->getAttribute('Title');
            $text = $rule->getElementsByTagName('Text')->item(0)->nodeValue;
            array_push($formatted_response, [
                'title' => $title,
                'text' => $text
            ]);
        }
        return $formatted_response;
    }
}
