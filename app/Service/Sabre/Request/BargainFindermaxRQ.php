<?php

namespace App\Service\Sabre\Request;

use App\Models\InternationalFlight\SearchFlight;
use App\Service\Sabre\SabreBasic;
use App\Service\XMLSerializer;

class BargainFindermaxRQ extends SabreBasic
{

    public function doRequest()
    {
        $body = $this->generateBody();
//        dd($body);
        $xmlStr = $this->generateEnvelopeXmlWithSecurityHeaderFromBody('BargainFinderMaxRQ', $body);
        if (is_dir(storage_path('app/public/international/' . session()->get('flight_search')))) {
            $checkfile = '../storage/app/public/international/' . session()->get('flight_search') . '/BargainFinderMaxRQ.txt';
            if (file_exists($checkfile)) {
                $file = storage_path('app/public/international/' . session()->get('flight_search') . '/BargainFinderMaxRQ' . time() . '.txt');
            } else {
                $file = $checkfile;
            }
            file_put_contents($file, $xmlStr);
        } else {
            mkdir(storage_path('app/public/international/' . session()->get('flight_search')), 0755, true);
            $file = storage_path('app/public/international/' . session()->get('flight_search') . '/BargainFinderMaxRQ.txt');
            file_put_contents($file, $xmlStr);
        }
//        dd($xmlStr);
        $response = $this->doSoapRequest($xmlStr);
        $checkfile = storage_path('app/public/international/' . session()->get('flight_search') . '/BargainFinderMaxRS.txt');
        if (file_exists($checkfile)) {
            $file = storage_path('app/public/international/' . session()->get('flight_search') . '/BargainFinderMaxRS' . time() . '.txt');
        } else {
            $file = $checkfile;
        }
        file_put_contents($file, $response);
        if (!$response) {
            session()->put('error', 'No Response From Server.');
            return false;
        }
        $status = $this->checkResponse($response);
        if ($status) {
            return $status;
        } else {
            return false;
        }
    }

    public function generateBody()
    {
        $search = SearchFlight::findorfail(session()->get('flight_search'));
//        dd($search);
        $timestamp = date("Y-m-d") . "T" . date("H-i-s") . "Z";
        $bfx_array = [
            'OTA_AirLowFareSearchRQ' => [
                '_attributes' => [
                    'Version' => '4.3.0',
                    'ResponseType' => 'OTA',
                    'ResponseVersion' => '4.3.0',
                    'xmlns' => 'http://www.opentravel.org/OTA/2003/05'
                ],
                'POS' => [
                    'Source' => [
                        '_attributes' => [
                            'PseudoCityCode' => $this->citycode,
                        ],
                        'RequestorID' => [
                            '_attributes' => [
                                'Type' => '1',
                                'ID' => '1'
                            ],
                            'CompanyName' => [
                                '_attributes' => [
                                    'Code' => $this->companycode,
                                ]
                            ]
                        ]
                    ]
                ],
            ]
        ];


        if (isset($search->sectors)) {
            $sector_rph = 1;
            $sector_space = '';

            $bfx_array['OTA_AirLowFareSearchRQ']['OriginDestinationInformation' . $sector_space] = [
                '_attributes' => [
                    'RPH' => $sector_rph
                ],
                'DepartureDateTime' => $search->flight_date->toDateString() . 'T00:00:00',
                'OriginLocation' => [
                    '_attributes' => [
                        'LocationCode' => $search->arrival
                    ]
                ],
                'DestinationLocation' => [
                    '_attributes' => [
                        'LocationCode' => $search->destination
                    ]
                ]
            ];
            foreach (json_decode($search->sectors, true) as $sector) {
                $sector_rph++;
                $sector_space = $sector_space . ' ';
                $bfx_array['OTA_AirLowFareSearchRQ']['OriginDestinationInformation' . $sector_space] = [
                    '_attributes' => [
                        'RPH' => $sector_rph + 1
                    ],
                    'DepartureDateTime' => \Carbon\Carbon::parse($sector['date'])->toDateString() . 'T00:00:00',
                    'OriginLocation' => [
                        '_attributes' => [
                            'LocationCode' => $sector['depart']
                        ]
                    ],
                    'DestinationLocation' => [
                        '_attributes' => [
                            'LocationCode' => $sector['arrival']
                        ]
                    ]
                ];
//                $sector_rph++;
//                $sector_space = $sector_space.' ';
            }

        } else {
            if (isset($search->return_date)) {


                $bfx_array['OTA_AirLowFareSearchRQ']['OriginDestinationInformation'] = [
                    '_attributes' => [
                        'RPH' => 1
                    ],
                    'DepartureDateTime' => $search->flight_date->toDateString() . 'T00:00:00',
                    'OriginLocation' => [
                        '_attributes' => [
                            'LocationCode' => $search->arrival
                        ]
                    ],
                    'DestinationLocation' => [
                        '_attributes' => [
                            'LocationCode' => $search->destination
                        ]
                    ]
                ];
                $bfx_array['OTA_AirLowFareSearchRQ']['OriginDestinationInformation '] = [
                    '_attributes' => [
                        'RPH' => 2
                    ],
                    'DepartureDateTime' => $search->return_date->toDateString() . 'T00:00:00',
                    'OriginLocation' => [
                        '_attributes' => [
                            'LocationCode' => $search->destination
                        ]
                    ],
                    'DestinationLocation' => [
                        '_attributes' => [
                            'LocationCode' => $search->arrival
                        ]
                    ]
                ];

            } else {
                $bfx_array['OTA_AirLowFareSearchRQ']['OriginDestinationInformation'] = [
                    '_attributes' => [
                        'RPH' => 1
                    ],
                    'DepartureDateTime' => $search->flight_date->toDateString() . 'T00:00:00',
                    'OriginLocation' => [
                        '_attributes' => [
                            'LocationCode' => $search->arrival
                        ]
                    ],
                    'DestinationLocation' => [
                        '_attributes' => [
                            'LocationCode' => $search->destination
                        ]
                    ]
                ];

            }
        }


        $travel_preferences_array = [
            '_attributes' => [
                'ValidInterlineTicket' => 'true'
            ]
        ];
        if (isset($search->airline)) {
            $airline = [
                '_attributes' => [
                    'Code' => $search->airline,
                    'PreferLevel' => 'Preferred',
                    'Type' => 'Marketing'
                ]
            ];
            $travel_preferences_array['VendorPref'] = $airline;
        }
        $travel_preferences_array['VendorPrefApplicability'] = [
            '_attributes' => [
                'Value' => 'AtLeastOneSegment',
                'Type' => 'Marketing'
            ]
        ];

        if (isset($search->class)) {
            $class = [
                '_attributes' => [
                    'PreferLevel' => 'Preferred',
                    'Cabin' => $search->class
                ]
            ];

        } else {
            $class = [
                '_attributes' => [
                    'PreferLevel' => 'Preferred',
                    'Cabin' => 'Y'
                ]
            ];
        }

        $travel_preferences_array['CabinPref'] = $class;

        if (isset($search->sectors)) {
            if ($search->nationality == 'NP' && $search->arrival == 'KTM') {
                $travel_preferences_array['TPA_Extensions'] = [
                    'ExcludeVendorPref' => [
                        '_attributes' => [
                            'Code' => 'H1'
                        ]
                    ],
                    'ExcludeVendorPref ' => [
                        '_attributes' => [
                            'Code' => 'X1'
                        ]
                    ],
                    'TripType' => [
                        '_attributes' => [
                            'Value' => 'Other'
                        ]
                    ],
                    'LongConnectTime' => [
                        '_attributes' => [
                            'Min' => '120',
                            'Max' => '1200',
                            'Enable' => 'true'
                        ]
                    ],
                    'ExemptTax' => [
                        '_attributes' => [
                            'TaxCode' => 'NQ'
                        ]
                    ],
                    'ExcludeCallDirectCarriers' => [
                        '_attributes' => [
                            'Enabled' => 'true'
                        ]
                    ]


                ];
            } else {
                $travel_preferences_array['TPA_Extensions'] = [
                    'ExcludeVendorPref' => [
                        '_attributes' => [
                            'Code' => 'H1'
                        ]
                    ],
                    'ExcludeVendorPref ' => [
                        '_attributes' => [
                            'Code' => 'X1'
                        ]
                    ],

                    'TripType' => [
                        '_attributes' => [
                            'Value' => 'Other'
                        ]
                    ],
                    'LongConnectTime' => [
                        '_attributes' => [
                            'Min' => '120',
                            'Max' => '1200',
                            'Enable' => 'true'
                        ]
                    ],

                    'ExcludeCallDirectCarriers' => [
                        '_attributes' => [
                            'Enabled' => 'true'
                        ]
                    ]


                ];
            }
        } else {
            if ($search->nationality == 'NP' && $search->arrival == 'KTM') {
                $travel_preferences_array['TPA_Extensions'] = [
                    'ExcludeVendorPref' => [
                        '_attributes' => [
                            'Code' => 'H1'
                        ]
                    ],
                    'ExcludeVendorPref ' => [
                        '_attributes' => [
                            'Code' => 'X1'
                        ]
                    ],
                    'TripType' => [
                        '_attributes' => [
                            'Value' => ($search->return_date) ? 'Return' : 'OneWay'
                        ]
                    ],
                    'LongConnectTime' => [
                        '_attributes' => [
                            'Min' => '120',
                            'Max' => '1200',
                            'Enable' => 'true'
                        ]
                    ],
                    'ExemptTax' => [
                        '_attributes' => [
                            'TaxCode' => 'NQ'
                        ]
                    ],
                    'ExcludeCallDirectCarriers' => [
                        '_attributes' => [
                            'Enabled' => 'true'
                        ]
                    ]
                ];
            } else {
                $travel_preferences_array['TPA_Extensions'] = [
                    'ExcludeVendorPref' => [
                        '_attributes' => [
                            'Code' => 'H1'
                        ]
                    ],
                    'ExcludeVendorPref ' => [
                        '_attributes' => [
                            'Code' => 'X1'
                        ]
                    ],
                    'TripType' => [
                        '_attributes' => [
                            'Value' => ($search->return_date) ? 'Return' : 'OneWay'
                        ]
                    ],
                    'LongConnectTime' => [
                        '_attributes' => [
                            'Min' => '120',
                            'Max' => '1200',
                            'Enable' => 'true'
                        ]
                    ],
                    'ExcludeCallDirectCarriers' => [
                        '_attributes' => [
                            'Enabled' => 'true'
                        ]
                    ]
                ];
            }
        }
        $travel_preferences_array['Baggage'] = [
            '_attributes' => [
                'RequestType' => 'A',
                'Description' => 'true'
            ]
        ];
        $traveller_info_array = [
            'SeatsRequested' => $search->adults + $search->childs,
            'AirTravelerAvail' => [
            ]
        ];
        if ($search->adults > 0) {
            $data = [
                '_attributes' => [
                    'Code' => 'ADT',
                    'Quantity' => $search->adults
                ],
                'TPA_Extensions' => [
                    'VoluntaryChanges' => [
                        '_attributes' => [
                            'Match' => 'Info'
                        ]
                    ]
                ]
            ];
            $traveller_info_array['AirTravelerAvail']['PassengerTypeQuantity'] = $data;
        }
        if ($search->childs > 0) {

            $data = [
                '_attributes' => [
                    'Code' => 'CNN',
                    'Quantity' => $search->childs
                ],
                'TPA_Extensions' => [
                    'VoluntaryChanges' => [
                        '_attributes' => [
                            'Match' => 'Info'
                        ]
                    ]
                ]
            ];
            $traveller_info_array['AirTravelerAvail']['PassengerTypeQuantity '] = $data;
        }
        if ($search->infants > 0) {
//            dd($search);
            $data = [
                '_attributes' => [
                    'Code' => 'INF',
                    'Quantity' => $search->infants
                ],
                'TPA_Extensions' => [
                    'VoluntaryChanges' => [
                        '_attributes' => [
                            'Match' => 'Info'
                        ]
                    ]
                ]
            ];
            $traveller_info_array['AirTravelerAvail']['PassengerTypeQuantity  '] = $data;
        }
        $currency = [
            '_attributes' => [
                'CurrencyCode' => $search->currency
            ]
        ];

        $tpa_extensions = [
            'IntelliSellTransaction' => [
                'RequestType' => [
                    '_attributes' => [
                        'Name' => '50ITINS'
                    ]
                ]
            ]
        ];
//        if(!isset($search->return_date)){
//            $bfx_array['OTA_AirLowFareSearchRQ']['OriginDestinationInformation'] = $destination_array;
//        }
        $bfx_array['OTA_AirLowFareSearchRQ']['TravelPreferences'] = $travel_preferences_array;
        $bfx_array['OTA_AirLowFareSearchRQ']['TravelerInfoSummary'] = $traveller_info_array;
        $bfx_array['OTA_AirLowFareSearchRQ']['TravelerInfoSummary']['PriceRequestInformation'] = $currency;
        $bfx_array['OTA_AirLowFareSearchRQ']['TPA_Extensions'] = $tpa_extensions;

        $body = XMLSerializer::generateValidXmlFromArray($bfx_array);
        return $body;
    }

    public function checkResponse($response)
    {
//        $response = $this->tempResponse();
        $doc = new \DOMDocument();
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
        return $doc;
    }

    public function formatResponse($doc)
    {
//        dd($doc);
        if (!$doc) {
            return false;
        }
        $formatted_response = [];
        $flights = [];

        $iteneraies = $doc->getElementsByTagName('PricedItinerary');
        foreach ($iteneraies as $itinerary) {
//            $extensions = $itinerary->getElementsByTagName('TPA_Extensions')->firstChild;
//
            $validating_carrier = $itinerary->getElementsByTagName('ValidatingCarrier')->item(0)->getAttribute('Code');
//            dd($validating_carrier);
            $rph = $itinerary->getAttribute('SequenceNumber');
            $flights[$rph] = [];
            $flights[$rph]['flight'] = [];
            $destination_options = $itinerary->getElementsByTagName('OriginDestinationOption');

            foreach ($destination_options as $option) {
                $flight = [];
                $f_count = 0;
                $flight_segments = $option->getElementsByTagName('FlightSegment');
                foreach ($flight_segments as $segment) {
                    $f_count++;
                    $departure_time = $segment->getAttribute('DepartureDateTime');
                    $arrival_time = $segment->getAttribute('ArrivalDateTime');
                    $stops = $segment->getAttribute('StopQuantity');
                    $flight_number = $segment->getAttribute('FlightNumber');
                    $class = $segment->getAttribute('ResBookDesigCode');
                    $flight_time = $segment->getAttribute('ElapsedTime');
                    $departure = $segment->getElementsByTagName('DepartureAirport')->item(0)->getAttribute('LocationCode');
                    if ($segment->getElementsByTagName('DepartureAirport')->item(0)->hasAttribute('TerminalID')) {
                        $depterminal = $segment->getElementsByTagName('DepartureAirport')->item(0)->getAttribute('TerminalID');
                    } else {
                        $depterminal = null;
                    }
                    $arrival = $segment->getElementsByTagName('ArrivalAirport')->item(0)->getAttribute('LocationCode');
                    if ($segment->getElementsByTagName('ArrivalAirport')->item(0)->hasAttribute('TerminalID')) {
                        $arrivalterminal = $segment->getElementsByTagName('ArrivalAirport')->item(0)->getAttribute('TerminalID');
                    } else {
                        $arrivalterminal = null;
                    }
                    $operating_airline = $segment->getElementsByTagName('OperatingAirline')->item(0)->getAttribute('Code');
                    $operating_airline_flight = $segment->getElementsByTagName('OperatingAirline')->item(0)->getAttribute('FlightNumber');
                    $marketing_airline = $segment->getElementsByTagName('MarketingAirline')->item(0)->getAttribute('Code');
                    array_push($flight, [
                        'departdate' => $this->getFlightDate($departure_time)[0],
                        'arrivaldate' => $this->getFlightDate($arrival_time)[0],
                        'departtime' => $this->getFlightDate($departure_time)[1],
                        'arrivaltime' => $this->getFlightDate($arrival_time)[1],
                        'departure' => $departure,
                        'depterminal' => $depterminal,
                        'arrivalterminal' => $arrivalterminal,
                        'arrival' => $arrival,
                        'departport' => $this->getAirportName($departure),
                        'arrivalport' => $this->getAirportName($arrival),
                        'flightnumber' => $flight_number,
                        'stops' => $stops,
                        'class' => $this->getFlightClassFromCode($class),
                        'resbook' => $class,
                        'flighttime' => $flight_time,
                        'elapstime' => $this->generateFlightTime($flight_time),
                        'operatingairline' => $operating_airline,
                        'marketingairline' => $marketing_airline
                    ]);
                }
                array_push($flights[$rph]['flight'], $flight);
            }
//           dd($flight);
//            array_push($flights[$rph]['flight'],$flight);
//           dd($flights);
            $pricing = $itinerary->getElementsByTagName('ItinTotalFare');
            $totalprice = [];
            foreach ($pricing as $price) {
                $totalbasefare = $price->getElementsByTagName('EquivFare')->item(0)->getAttribute('Amount');
                $totalbasefarecurrency = $price->getElementsByTagName('EquivFare')->item(0)->getAttribute('CurrencyCode');
                $fareconstructionamount = $price->getElementsByTagName('FareConstruction')->item(0)->getAttribute('Amount');
                $fareconstructioncurrency = $price->getElementsByTagName('FareConstruction')->item(0)->getAttribute('CurrencyCode');
                $totaltaxcode = $price->getElementsByTagName('Tax')->item(0)->getAttribute('TaxCode');
                $totaltaxamount = $price->getElementsByTagName('Tax')->item(0)->getAttribute('Amount');
                $totaltaxcurrency = $price->getElementsByTagName('Tax')->item(0)->getAttribute('CurrencyCode');
                $totalfare = $price->getElementsByTagName('TotalFare')->item(0)->getAttribute('Amount');
                $totalfarecurrency = $price->getElementsByTagName('TotalFare')->item(0)->getAttribute('CurrencyCode');
                $totalprice['basefare'] = $totalbasefarecurrency . ' ' . $totalbasefare;
                $totalprice['tax'] = $totaltaxcurrency . ' ' . $totaltaxamount;
                $totalprice['total'] = $totalfarecurrency . ' ' . $totalfare;
            }
            $flights[$rph]['pricing'] = $totalprice;
            $flights[$rph]['breakdown'] = [];
            $flights[$rph]['farepenalty'] = [];
            $flights[$rph]['baggage'] = [];

            $breakdowns = $itinerary->getElementsByTagName('PTC_FareBreakdown');
            foreach ($breakdowns as $breakdown) {
                $farebasiscodes = $breakdown->getElementsByTagName('FareBasisCode');
                $farecodes = [];
                foreach ($farebasiscodes as $farebasiscode) {
                    $dept = $farebasiscode->getAttribute('FareComponentBeginAirport');
                    $arr = $farebasiscode->getAttribute('FareComponentEndAirport');
                    $airline = $farebasiscode->getAttribute('GovCarrier');
                    $farecode = $farebasiscode->nodeValue;
                    array_push($farecodes, [
                        'start' => $dept,
                        'end' => $arr,
                        'air' => $airline,
                        'code' => $farecode
                    ]);
                }
                $pax_type = $breakdown->getElementsByTagName('PassengerTypeQuantity')->item(0)->getAttribute('Code');
                $pax_qty = $breakdown->getElementsByTagName('PassengerTypeQuantity')->item(0)->getAttribute('Quantity');
                $passengerfare = $breakdown->getElementsByTagName('PassengerFare')->item(0);
                $basefare = $passengerfare->getElementsByTagName('EquivFare')->item(0)->getAttribute('Amount');
                $basefarecurrency = $passengerfare->getElementsByTagName('EquivFare')->item(0)->getAttribute('CurrencyCode');
//                dd($passengerfare->getElementsByTagName('TotalTax')->item(0)->getAttribute('CurrencyCode'));
                $taxnode = $passengerfare->getElementsByTagName('TotalTax');

                if ($taxnode->count() > 0) {
                    $taxamount = $passengerfare->getElementsByTagName('TotalTax')->item(0)->getAttribute('Amount');
                    $taxcurrency = $passengerfare->getElementsByTagName('TotalTax')->item(0)->getAttribute('CurrencyCode');
                } else {
                    $taxamount = 0;
                    $taxcurrency = $basefarecurrency;
                }

                $totalfare = $passengerfare->getElementsByTagName('TotalFare')->item(0)->getAttribute('Amount');
                $totalfarecurrency = $passengerfare->getElementsByTagName('TotalFare')->item(0)->getAttribute('CurrencyCode');
                $baggage = $passengerfare->getElementsByTagName('BaggageInformation')->item(0);
                if ($baggage) {
                    $bagallowence = $baggage->getElementsByTagName('Allowance')->item(0);
                    if ($bagallowence->hasAttribute('Pieces')) {
                        $allowencetype = 'Pieces';
                        $allowence = $bagallowence->getAttribute('Pieces');
                    }
                    if ($bagallowence->hasAttribute('Description1')) {
                        $description1 = $bagallowence->getAttribute('Description1');
                    } else {
                        $description1 = false;
                    }
                    if ($bagallowence->hasAttribute('Weight')) {
                        $allowencetype = 'Weight';
                        $allowence = $bagallowence->getAttribute('Weight') . ' ' . $bagallowence->getAttribute('Unit');
                    }
                } else {
                    $allowencetype = 'None';
                    $allowence = 0;
                    $description1 = false;
                }

                $taxBreakdowns = $passengerfare->getElementsByTagName('TaxSummary');
                $taxes = [];
                foreach ($taxBreakdowns as $taxBreakdown) {
                    $breakdownTaxCode = $taxBreakdown->getAttribute('TaxCode');
                    $breakdownTaxAmount = $taxBreakdown->getAttribute('Amount');
                    $breakdownTaxCurrency = $taxBreakdown->getAttribute('CurrencyCode');
                    array_push($taxes, [
                        'code' => $breakdownTaxCode,
                        'amount' => $breakdownTaxCurrency . ' ' . $breakdownTaxAmount
                    ]);
                }

                $penalties = $passengerfare->getElementsByTagName('Penalty');
                foreach ($penalties as $penalty) {
                    $type = $penalty->getAttribute('Type');
                    $applicable = $penalty->getAttribute('Applicability');
                    if ($type == 'Exchange') {
                        $status = $penalty->getAttribute('Changeable');
                    } elseif ($type == 'Refund') {
                        $status = $penalty->getAttribute('Refundable');
                    }
                    if ($status == 'true') {
                        $amount = $penalty->getAttribute('Amount');
                        $decimal = $penalty->getAttribute('DecimalPlaces');
                        $currency = $penalty->getAttribute('CurrencyCode');
                    } else {
                        $amount = 00;
                        $decimal = 00;
                        $currency = $totalbasefarecurrency;
                    }

                    array_push($flights[$rph]['farepenalty'], [
                        'paxtype' => $pax_type,
                        'penaltytype' => $type,
                        'applicable' => $applicable,
                        'status' => $status,
                        'amount' => $currency . ' ' . $amount . '.' . $decimal,
                    ]);
                }
                $fare_infos = $breakdown->getElementsByTagName('FareInfo');
                $seat = $this->getAvailableSeat($fare_infos);
                array_push($flights[$rph]['baggage'], [
                    'pax' => $pax_type,
                    'type' => $allowencetype,
                    'unit' => $allowence,
                    'description' => $description1,
                    'detail' => $seat
                ]);
                $refundable = $breakdown->getElementsByTagName('Endorsements')->item(0)->getAttribute('NonRefundableIndicator');

                array_push($flights[$rph]['breakdown'], [
                    'type' => $pax_type,
                    'qty' => $pax_qty,
                    'basefare' => $basefarecurrency . ' ' . $basefare,
                    'tax' => $taxcurrency . ' ' . $taxamount,
                    'total' => $totalfarecurrency . ' ' . $totalfare,
                    'refund' => $refundable,
                    'farecodes' => $farecodes,
                    'taxbreakdown' => $taxes
                ]);
            }
            $flights[$rph]['airline'] = $validating_carrier;
            $flights[$rph]['rph'] = $rph;
            $classinfo = $itinerary->getElementsByTagName('FareInfo');
            $segmentclass = [];
            foreach ($classinfo as $info) {
                $cabin = $info->getElementsByTagName('Cabin')->item(0)->getAttribute('Cabin');
                $meals = $info->getElementsByTagName('Meal')->item(0);
//                dd($meal);

                if (!$meals) {
                    $meal = false;
                } else {
                    $meal = $meals->getAttribute('Code');
                }
                array_push($segmentclass, [
                    'cabin' => $cabin,
                    'meal' => $meal
                ]);
            }
            $flight[$rph]['class'] = $segmentclass;

        }
//        dd($this->addDetail($flights));
        return $this->addDetail($flights);
    }

    public function getAvailableSeat($fareinfos)
    {
        $seat = [];
        foreach ($fareinfos as $fareinfo) {
            $available = $fareinfo->getElementsByTagName('SeatsRemaining')->item(0)->getAttribute('Number');
            $cabin = $fareinfo->getElementsByTagName('Cabin')->item(0)->getAttribute('Cabin');
            $meal = $fareinfo->getElementsByTagName('Meal')->item(0);
            if ($meal) {
                $meal_code = $fareinfo->getElementsByTagName('Meal')->item(0)->getAttribute('Code');
            } else {
                $meal_code = false;
            }

            array_push($seat, [
                'available' => $available,
                'cabin' => $cabin,
                'meal' => $meal_code
            ]);
        }
        return $seat;
    }

    public function addDetail($flights)
    {

        $temp = [];
        foreach ($flights as $flight) {
            $count = 0;
            $flight['detail'] = [];
            $refundable = $flight['breakdown'][0]['refund'];
            foreach ($flight['flight'] as $f) {
                $s = 100;
                $totaltime = 0;
                $f_count = count($f);
                $origin = $f[0]['departure'];
                $orgairport = $this->getAirportName($f[0]['departure']);
                $origindate = $f[0]['departdate'];
                $origintime = $f[0]['departtime'];
                $originterminal = $f[0]['depterminal'];
                $airline = $flight['airline'];
                $destinationtime = $f[$f_count - 1]['arrivaltime'];
                $destinationdate = $f[$f_count - 1]['arrivaldate'];
                $destination = $f[$f_count - 1]['arrival'];
                $desairport = $this->getAirportName($f[$f_count - 1]['arrival']);
                $arrivalterminal = $f[$f_count - 1]['arrivalterminal'];
                $stops = $f_count - 1;
                foreach ($f as $foo) {

                    $seat = $this->getSeat($flight, $count);
                    if ($seat < $s) {
                        $s = $seat;
                    }
                    $bag = $this->getBaggage($flight);

                    $totaltime = $totaltime + $foo['flighttime'];
                    $foo['flighttime'] = $this->generateFlightTime($foo['flighttime']);
                    $count++;

                }
                $startTime = new Carbon($origindate . ' ' . $origintime);
                $endTime = new Carbon($destinationdate . ' ' . $destinationtime);
                $totaltime = $startTime->diffInMinutes($endTime);

                array_push($flight['detail'], [
                    'seat' => $s,
                    'bag' => $bag,
                    'origin' => $origin,
                    'orgport' => $orgairport,
                    'orgterminal' => $originterminal,
                    'destination' => $destination,
                    'destport' => $desairport,
                    'desterminal' => $arrivalterminal,
                    'stops' => $stops,
                    'origintime' => $origintime,
                    'origindate' => $origindate,
                    'destinationdate' => $destinationdate,
                    'destinationtime' => $destinationtime,
                    'airline' => $airline,
                    'totaltime' => $this->generateFlightTime($totaltime),
                    'refundable' => $refundable
                ]);
            }
            array_push($temp, $flight);
        }

        return $temp;
    }

    public function getSeat($flight, $count)
    {
        $seats = [];
        foreach ($flight['baggage'] as $bag) {
            array_push($seats, $bag['detail'][$count]['available']);

        }
        return collect($seats)->min();
    }

    public function getBaggage($flight)
    {
//        dd($flight);
        $unit = $flight['baggage'][0]['unit'];
        $type = $flight['baggage'][0]['type'];
        if ($flight['baggage'][0]['description']) {
            $description = $flight['baggage'][0]['description'];
        } else {
            $description = '';
        }
        return $unit . ' ' . $type . ' ' . $description;
//        return $flight['baggage'][0]['unit'].' '.$flight['baggage'][0]['type'].' '.($flight['baggage'][0]['description'])?$flight['baggage'][0]['description']:'';
    }

    public function getAirlines($doc)
    {
        if (!$doc) {
            return false;
        }
        $airlinelist = [];
        $aires_list = $doc->getElementsByTagName('AirlineOrderList');
//        dd($aires_list);
        if (!isset($aires_list)) {
            return false;
        }
        $aires = $aires_list->item(0);
        $airs = $aires->getElementsByTagName('AirlineOrder');
        if (!$airs) {
            return false;
        }
        foreach ($airs as $air) {
            $name = $air->getAttribute('Code');
            array_push($airlinelist, $name);
        }
        return $airlinelist;
    }
}
