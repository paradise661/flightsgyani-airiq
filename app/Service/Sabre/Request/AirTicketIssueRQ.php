<?php

namespace App\Service\Sabre\Request;

use App\Models\InternationalFlight\SearchFlight;
use App\Service\Sabre\SabreBasic;
use App\Service\XMLSerializer;
use DOMDocument;

class AirTicketIssueRQ extends SabreBasic
{
    public function doRequest($airline, $adults, $childs, $infants, $commission)
    {
        $body = $this->generateBody($airline, $adults, $childs, $infants, $commission);
        $xmlstr = $this->generateEnvelopeXmlWithSecurityHeaderFromBody('AirTicketLLSRQ', $body);
        if (is_dir('../storage/app/public/international/' . session()->get('flight_search'))) {
            $checkfile = '../storage/app/public/international/' . session()->get('flight_search') . '/AirTicketIssueRQ.txt';
            if (file_exists($checkfile)) {
                $file = '../storage/app/public/international/' . session()->get('flight_search') . '/AirTicketIssueRQ' . time() . '.txt';
            } else {
                $file = $checkfile;
            }
            file_put_contents($file, $xmlstr);
        } else {
            mkdir('../storage/app/public/international/' . session()->get('flight_search'), 0755, true);
            $file = '../storage/app/public/international/' . session()->get('flight_search') . '/AirTicketIssueRQ.txt';
            file_put_contents($file, $xmlstr);
        }
        $response = $this->doSoapRequest($xmlstr);
        $checkfile = '../storage/app/public/international/' . session()->get('flight_search') . '/AirTicketIssueRS.txt';
        if (file_exists($checkfile)) {
            $file = '../storage/app/public/international/' . session()->get('flight_search') . '/AirTicketIssueRS' . time() . '.txt';
        } else {
            $file = $checkfile;
        }
        file_put_contents($file, $response);
        if (!$response) {
            return false;
        }
        return $this->formatResponse($response);
    }

    public function generateBody($airline, $adults, $childs, $infants, $commission)
    {
        $search = SearchFlight::findorfail(session()->get('flight_search'));
//        $timestamp = date("Y-m-d") . "T" . date("H-i-s").'-06:00';
//        dd($timestamp);
        $body = [
            'AirTicketRQ' => [
                '_attributes' => [
                    'xmlns' => 'http://webservices.sabre.com/sabreXML/2011/10',
                    'xmlns:xs' => 'http://www.w3.org/2001/XMLSchema',
                    'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
                    'NumResponses' => '1',
                    'Version' => '2.12.0'
                ],
                'OptionalQualifiers' => [
                    'FlightQualifiers' => [
                        'VendorPrefs' => [
                            'Airline' => [
                                '_attributes' => [
                                    'Code' => $airline
                                ]
                            ]
                        ]
                    ],
                    'FOP_Qualifiers' => [
                        'BasicFOP' => [
                            '_attributes' => [
                                'Type' => 'CASH'
                            ]
                        ]
                    ],
                    'MiscQualifiers' => [


                    ],
                    'PricingQualifiers' => [
                        'PriceQuote' => [

                        ]
                    ]
                ]
            ]
        ];

        if ($commission) {

            $body['AirTicketRQ']['OptionalQualifiers']['MiscQualifiers']['Commission'] = [
                '_attributes' => [
                    'Percent' => $commission
                ]
            ];

            $body['AirTicketRQ']['OptionalQualifiers']['MiscQualifiers']['Ticket'] = [
                '_attributes' => [
                    'Type' => 'ETR'
                ]
            ];


        } else {
            $body['AirTicketRQ']['OptionalQualifiers']['MiscQualifiers']['Ticket'] = [
                '_attributes' => [
                    'Type' => 'ETR'
                ]
            ];
        }

        $index = 1;
        $space = '';
        if ($adults->count() > 0) {
            $body['AirTicketRQ']['OptionalQualifiers']['PricingQualifiers']['PriceQuote']['Record' . $space] = [
                '_attributes' => [
                    'Number' => $index
                ]
            ];
            $space = $space . ' ';
            $index++;
        }
        if ($childs->count() > 0) {
            $body['AirTicketRQ']['OptionalQualifiers']['PricingQualifiers']['PriceQuote']['Record' . $space] = [
                '_attributes' => [
                    'Number' => $index
                ]
            ];
            $space = $space . ' ';
            $index++;
        }
        if ($infants->count() > 0) {
            $body['AirTicketRQ']['OptionalQualifiers']['PricingQualifiers']['PriceQuote']['Record' . $space] = [
                '_attributes' => [
                    'Number' => $index
                ]
            ];
            $space = $space . ' ';
            $index++;
        }


        $body_xml = XMLSerializer::generateValidXmlFromArray($body);
        return $body_xml;
    }

    public function formatResponse($response)
    {
//        return $this->tempResponse();
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

    public function tempResponse()
    {
        return true;
    }
}
