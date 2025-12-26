<?php

namespace App\Service\Sabre\Request;

use App\Models\InternationalFlight\SearchFlight;
use App\Service\Sabre\SabreBasic;
use App\Service\XMLSerializer;
use DOMDocument;

class EnhancedAirBookRQ extends SabreBasic
{

    public function doRequest($flight)
    {
        $body = $this->generateBody($flight);
        $xmlStr = $this->generateEnvelopeXmlWithSecurityHeaderFromBody('EnhancedAirBookRQ', $body);
        if (is_dir('../storage/app/public/international/' . session()->get('flight_search'))) {
            $checkfile = '../storage/app/public/international/' . session()->get('flight_search') . '/EnhancedAirBookRQ.txt';
            if (file_exists($checkfile)) {
                $file = '../storage/app/public/international/' . session()->get('flight_search') . '/EnhancedAirBookRQ' . time() . '.txt';
            } else {
                $file = $checkfile;
            }
            file_put_contents($file, $xmlStr);
        } else {
            if (!mkdir($concurrentDirectory = '../storage/app/public/international/' . session()->get('flight_search'), 0755, true) && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }
            $file = '../storage/app/public/international/' . session()->get('flight_search') . '/EnhancedAirBookRQ.txt';
            file_put_contents($file, $xmlStr);
        }
        $response = $this->doSoapRequest($xmlStr);
        if (!$response) {
            return false;
        }
        $checkfile = '../storage/app/public/international/' . session()->get('flight_search') . '/EnhancedAirBookRS.txt';
        if (file_exists($checkfile)) {
            $file = '../storage/app/public/international/' . session()->get('flight_search') . '/EnhancedAirBookRS' . time() . '.txt';
        } else {
            $file = $checkfile;
        }
        file_put_contents($file, $response);
        $formatted_response = $this->formatResponse($response);
        return $formatted_response;
    }

    public function generateBody($flights)
    {
        $search = SearchFlight::findorfail(session()->get('flight_search'));
        $body = [
            'EnhancedAirBookRQ' => [
                '_attributes' => [
                    'xmlns' => 'http://services.sabre.com/sp/eab/v3_10',
                    'version' => '3.10.0',
                    'IgnoreOnError' => 'true',
                    'HaltOnError' => 'true',
                    'haltOnInvalidMCT' => 'false'
                ],
                'OTA_AirBookRQ' => [
                    'RetryRebook'=>[
                        '_attributes'=>[
                            'Option'=>'true'
                        ]
                    ],
                    'HaltOnStatus' => [
                        '_attributes' => [
                            'Code' => 'UC'
                        ]
                    ],
                    'HaltOnStatus ' => [
                        '_attributes' => [
                            'Code' => 'LL'
                        ]
                    ],
                    'HaltOnStatus  ' => [
                        '_attributes' => [
                            'Code' => 'UL'
                        ]
                    ],
                    'HaltOnStatus   ' => [
                        '_attributes' => [
                            'Code' => 'UN'
                        ]
                    ],
                    'HaltOnStatus    ' => [
                        '_attributes' => [
                            'Code' => 'NO'
                        ]
                    ],
                    'HaltOnStatus     ' => [
                        '_attributes' => [
                            'Code' => 'HL'
                        ]
                    ],
                    'OriginDestinationInformation' => [

                    ],
                    'RedisplayReservation' => [
                        '_attributes' => [
                            'NumAttempts' => '5',
                            'WaitInterval' => '5000'
                        ]
                    ]
                ],
                'OTA_AirPriceRQ' => [
                    'PriceRequestInformation' => [
                        '_attributes' => [
                            'Retain' => 'true'
                        ],
                        'OptionalQualifiers' => [
                            'FlightQualifiers' => [
                                'VendorPrefs' => [

                                ]
                            ],
                            'PricingQualifiers' => [

                            ]
                        ]
                    ]
                ],
                'PostProcessing' => [
                    '_attributes' => [
                        'IgnoreAfter' => 'false'
                    ],
                    'RedisplayReservation' => []
                ],
                'PreProcessing' => [
                    '_attributes' => [
                        'IgnoreBefore' => 'false'
                    ]
                ]
            ]
        ];
        $space = '';
        foreach ($flights as $flight) {
            foreach ($flight['sectors'] as $f) {
               //$marketing_airline = $f['marketingairline'];
		$valadatingairline=$f['valadatingairline'];                
$temp = [
                    '_attributes' => [
                        'DepartureDateTime' => $f['departdate'] . 'T' . $f['departtime'],
                        'ArrivalDateTime' => $f['arrivaldate'] . 'T' . $f['arrivaltime'],
                        'FlightNumber' => $f['flightnumber'],
                        'NumberInParty' => $search->adults + $search->childs,
                        'ResBookDesigCode' => $f['resbook'],
                        'Status' => 'NN'
                    ],
                    'DestinationLocation' => [
                        '_attributes' => [
                            'LocationCode' => $f['arrival']
                        ]
                    ],
                    'Equipment' => [
                        '_attributes' => [
                            'AirEquipType' => '73H'
                        ]
                    ],
                    'MarketingAirline' => [
                        '_attributes' => [
                            'Code' => $f['marketingairline'],
                            'FlightNumber' => $f['flightnumber']
                        ]
                    ],
                    'OriginLocation' => [
                        '_attributes' => [
                            'LocationCode' => $f['departure']
                        ]
                    ]
                ];
                $body['EnhancedAirBookRQ']['OTA_AirBookRQ']['OriginDestinationInformation']['FlightSegment' . $space] = $temp;
                $body['EnhancedAirBookRQ']['OTA_AirPriceRQ']['PriceRequestInformation']['OptionalQualifiers']['FlightQualifiers']['VendorPrefs'] = [
                    'Airline' => [
                        '_attributes' => [
                            'Code' => $valadatingairline
                        ]
                    ]
                ];
                $space = $space . ' ';
            }
        }
        if ($search->nationality == 'NP') {
            /*$body['EnhancedAirBookRQ']['OTA_AirPriceRQ']['PriceRequestInformation']['OptionalQualifiers']['PricingQualifiers']['Taxes'] = [
                'TaxExempt'=>[
                    '_attributes'=>[
                        'Code'=>'NQ'
                    ]
                ]
            ];*/
            $body['EnhancedAirBookRQ']['OTA_AirPriceRQ']['PriceRequestInformation']['OptionalQualifiers']['PricingQualifiers']['PassengerStatus'] = 'NT/NP';

        }
        if ($search->adults > 0) {
            $body['EnhancedAirBookRQ']['OTA_AirPriceRQ']['PriceRequestInformation']['OptionalQualifiers']['PricingQualifiers']['PassengerType'] = [
                '_attributes' => [
                    'Code' => 'ADT',
                    'Force' => 'true',
                    'Quantity' => $search->adults
                ]
            ];
        }
        if ($search->childs > 0) {
            $body['EnhancedAirBookRQ']['OTA_AirPriceRQ']['PriceRequestInformation']['OptionalQualifiers']['PricingQualifiers']['PassengerType '] = [
                '_attributes' => [
                    'Code' => 'CNN',
                    'Force' => 'true',
                    'Quantity' => $search->childs
                ]
            ];
        }
        if ($search->infants > 0) {
            $body['EnhancedAirBookRQ']['OTA_AirPriceRQ']['PriceRequestInformation']['OptionalQualifiers']['PricingQualifiers']['PassengerType  '] = [
                '_attributes' => [
                    'Code' => 'INF',
                    'Force' => 'true',
                    'Quantity' => $search->infants
                ]
            ];
        }

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
        $status = $this->checkResponseStatus($doc);
        if (!$status) {

            return false;
        }
        $formatted_response = [];
        $flights = [];
        $air_book = $doc->getElementsByTagName('OTA_AirBookRS')->item(0);
        $destination_options = $air_book->getElementsByTagName('OriginDestinationOption');
        foreach ($destination_options as $option) {
            $segments = $option->getElementsByTagName('FlightSegment');
            foreach ($segments as $segment) {
                $arrivaldatetime = $segment->getAttribute('ArrivalDateTime');
                $departuredatetime = $segment->getAttribute('DepartureDateTime');
                $flightnumber = $segment->getAttribute('FlightNumber');
                $class = $segment->getAttribute('ResBookDesigCode');
                $destination = $segment->getElementsByTagName('DestinationLocation')->item(0)->getAttribute('LocationCode');
                $marketingairline = $segment->getElementsByTagName('MarketingAirline')->item(0)->getAttribute('Code');
                $marketingairlineflight = $segment->getElementsByTagName('MarketingAirline')->item(0)->getAttribute('FlightNumber');
                $location = $segment->getElementsByTagName('OriginLocation')->item(0)->getAttribute('LocationCode');
                array_push($flights, [
                    'location' => $location,
                    'destination' => $destination,
                    'departdate' => $this->getFlightDate($departuredatetime)[0],
                    'departtime' => $this->getFlightDate($departuredatetime)[1],
                    'arrivaldate' => $this->getFlightDate($arrivaldatetime)[0],
                    'arrivaltime' => $this->getFlightDate($arrivaldatetime)[1],
                    'class' => $class,
                    'flightno' => $flightnumber,
                    'marketingairline' => $marketingairline,
                    'marketingflightno' => $marketingairlineflight
                ]);
            }
        }
        $bag_info = '';
        $travelitinenary = $doc->getElementsByTagName('TravelItineraryReadRS')->item(0);
        $pricing = $travelitinenary->getElementsByTagName('ItineraryPricing')->item(0);
        $pricequote = $pricing->getElementsByTagName('PriceQuote')->item(0);
//        dd($pricequote);
        $information = $pricequote->getElementsByTagName('MiscInformation')->item(0);
//        $baggage = $information->getElementsByTagName('BaggageFees')->item(0);
//        dd($baggage);
//        $text = $baggage->getElementsByTagName('Text');
//        foreach($text as $t){
//            $bag_info = $bag_info .'<br>'.$t->value();
//        }
        $totalpricequote = $pricing->getElementsByTagName('PriceQuoteTotals')->item(0);
        $basefare = $totalpricequote->getElementsByTagName('BaseFare')->item(0)->getAttribute('Amount');
        $tax = $totalpricequote->getElementsByTagName('Taxes')->item(0);
        $totaltax = $tax->getElementsByTagName('Tax')->item(0)->getAttribute('Amount');
        $totalfare = $totalpricequote->getElementsByTagName('TotalFare')->item(0)->getAttribute('Amount');

        array_push($formatted_response, [
            'flights' => $flights,
            'basefare' => $basefare,
            'tax' => $totaltax,
            'totalfare' => $totalfare,
//            'baggage'=>$bag_info
        ]);
        return $formatted_response;
//        dd($formatted_response);
    }


}
