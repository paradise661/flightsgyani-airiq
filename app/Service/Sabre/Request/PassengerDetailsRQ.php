<?php

namespace App\Service\Sabre\Request;

use App\Models\InternationalFlight\SearchFlight;
use App\Service\Sabre\SabreBasic;
use App\Service\XMLSerializer;
use Carbon\Carbon;
use DOMDocument;

class PassengerDetailsRQ extends SabreBasic
{

    public function __construct()
    {
        parent::__construct();
    }

    public function splitName($name)
    {
        $parts = array();

        while (strlen(trim($name)) > 0) {
            $name = trim($name);
            $string = preg_replace('#.*\s([\w-]*)$#', '$1', $name);
            $parts[] = $string;
            $name = trim(preg_replace('#' . $string . '#', '', $name));
        }

        if (empty($parts)) {
            return false;
        }

        $parts = array_reverse($parts);
        $name = array();
        $name['first_name'] = $parts[0];
        $name['middle_name'] = (isset($parts[2])) ? $parts[1] : '';
        $name['last_name'] = (isset($parts[2])) ? $parts[2] : (isset($parts[1]) ? $parts[1] : '');

        return $name;
    }

    public function doRequest($airline, $contact, $adults, $childs, $infants)
    {
        $body = $this->generateBody($airline, $contact, $adults, $childs, $infants);
        $xmlStr = $this->generateEnvelopeXmlWithSecurityHeaderFromBody("PassengerDetailsRQ", $body);
//            dd($xmlStr);
        if (is_dir('../storage/app/public/international/' . session()->get('flight_search'))) {
            $checkfile = '../storage/app/public/international/' . session()->get('flight_search') . '/PassengerDetailsRQ.txt';
            if (file_exists($checkfile)) {
                $file = '../storage/app/public/international/' . session()->get('flight_search') . '/PassengerDetailsRQ' . time() . '.txt';
            } else {
                $file = $checkfile;
            }
            file_put_contents($file, $xmlStr);
        } else {
            mkdir('../storage/app/public/international/' . session()->get('flight_search'), 0755, true);
            $file = '../storage/app/public/international/' . session()->get('flight_search') . '/PassengerDetailsRQ.txt';
            file_put_contents($file, $xmlStr);
        }
//        dd($xmlStr);

        $responseXml = $this->doSoapRequest($xmlStr);

        if (is_dir('../storage/app/public/international/' . session()->get('flight_search'))) {
            $checkfile = '../storage/app/public/international/' . session()->get('flight_search') . '/PassengerDetailsRS.txt';
            if (file_exists($checkfile)) {
                $file = '../storage/app/public/international/' . session()->get('flight_search') . '/PassengerDetailsRS' . time() . '.txt';
            } else {
                $file = $checkfile;
            }

        } else {
            mkdir('../storage/app/public/international/' . session()->get('flight_search'), 0755, true);
            $file = '../storage/app/public/international/' . session()->get('flight_search') . '/PassengerDetailsRS.txt';
            file_put_contents($file, $responseXml);
        }
        file_put_contents($file, $responseXml);
        if (!$responseXml) {
            return false;
        }

        $formatted_response = $this->formatResponse($responseXml);
        return $formatted_response;
    }

    public function generateBody($airline, $contact, $adults, $childs = null, $infants = null)
    {

        $search = SearchFlight::findorfail(session()->get('flight_search'));
        $bodyArray = [
            'PassengerDetailsRQ'=>[
                '_attributes'=>[
                    'xmlns'=>'http://services.sabre.com/sp/pd/v3_4',
                    'version'=>'3.4.0',
                    'ignoreOnError'=>'true',
                    'haltOnError'=>'true'
                ],
                'PostProcessing'=>[
                    '_attributes'=>[
                        'ignoreAfter'=>'true'
                    ],
                    'RedisplayReservation'=>[
                        '_attributes'=>[
                            'waitInterval'=>'5000'
                        ]
                    ],
                    'EndTransactionRQ'=>[
                        'EndTransaction'=>[
                            '_attributes'=>[
                                'Ind'=>'true'
                            ]
                        ],
                        'Source'=>[
                            '_attributes'=>[
                                'ReceivedFrom'=>'FG'
                            ]
                        ]
                    ]
                ],
                'PriceQuoteInfo'=>[

                ],
                'SpecialReqDetails'=>[
                    'AddRemarkRQ'=>[
                        'RemarkInfo'=>[
                            'FOP_Remark'=>[
                                '_attributes'=>[
                                    'Type'=>'CASH'
                                ]
                            ]
                        ]
                    ],
                    'SpecialServiceRQ'=>[
                        'SpecialServiceInfo'=>[

                        ]
                    ]
                ],
                'TravelItineraryAddInfoRQ'=>[
                    'AgencyInfo'=>[
                        'Address'=>[
                            'AddressLine'=>$this->addressline,
                            'CityName'=>$this->cityname,
                            'CountryCode'=>$this->countrycode,
                            'VendorPrefs'=>[
                                'Airline'=>[
                                    '_attributes'=>[
                                        'Hosted'=>'false'
                                    ]
                                ]
                            ]
                        ],
                        'Ticketing'=>[
                            '_attributes'=>[
                                'TicketType'=>'7TAW'
                            ]
                        ]
                    ],
                    'CustomerInfo'=>[
                        'ContactNumbers'=>[
                            'ContactNumber'=>[
                                '_attributes'=>[
                                    'LocationCode'=>$search->arrival,
                                    'NameNumber'=>'1.1',
                                    'Phone'=>$contact['phone'],
                                    'PhoneUseType'=>'A'
                                ]
                            ]
                        ],
                        'Email'=>[
                            '_attributes'=>[
                                'Address'=>$contact['email'],
                                'NameNumber'=>'1.1',
                                'ShortText'=>'AirlineTicket',
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $space = '';
        $index = 1;
        $record = 1;
        $serviceSpace = '';
        $loyaltySpace = '';
        if($adults->count() > 0){
            foreach($adults as $adult){
                if(isset($adult->freq_flier_code) && isset($adult->freq_flier_airline)){
                    $bodyArray['PassengerDetailsRQ']['TravelItineraryAddInfoRQ']['CustomerInfo']['CustLoayalty'.$loyaltySpace] = [
                        '_attributes'=>[
                            'MemberShipID'=>$adult->freq_flier_code,
                            'NameNumber'=>$index.'.1',
                            'ProgramID'=>$adult->freq_flier_airline,
                            'SegmentNumber'=>'A',
                            'TravellingCarrierCode'=>$airline
                        ]
                    ];
                    $loyaltySpace = $loyaltySpace.' ';
                }
                $bodyArray['PassengerDetailsRQ']['PriceQuoteInfo']['Link'.$space] = [
                    '_attributes'=>[
                        'nameNumber'=>$index.'.1',
                        'record'=>$record
                    ]
                ];

                $bodyArray['PassengerDetailsRQ']['TravelItineraryAddInfoRQ']['CustomerInfo']['PersonName'.$space]=[
                    '_attributes'=>[
                        'NameNumber'=>$index.'.1',
                        'Infant'=>'false',
                        'PassengerType'=>'ADT'
                    ],
                    'GivenName'=>$adult->pax_first_name . ' ' . $adult->pax_mid_name,
                    'Surname'=>$adult->pax_last_name
                ];
                if(isset($adult->doc_number)){
                    if($adult->doc_type == 'Passport'){
                        $bodyArray['PassengerDetailsRQ']['SpecialReqDetails']['SpecialServiceRQ']['SpecialServiceInfo']['AdvancePassenger'.$space] = [
                            '_attributes'=>[
                                'SegmentNumber'=>'A'
                            ],
                            'Document'=>[
                                '_attributes'=>[
                                    'ExpirationDate'=>Carbon::parse($adult->doc_expiry_date)->format('Y-m-d'),
                                    'Number'=>$adult->doc_number,
                                    'Type'=>'P'
                                ],
                                'IssueCountry'=>$adult->doc_issued_by,
                                'NationalityCountry'=>$adult->nationality
                            ],
                            'PersonName'=>[
                                '_attributes'=>[
                                    'DateOfBirth'=>Carbon::parse($adult->dob)->format('Y-m-d'),
                                    'Gender'=>$adult->pax_gender,
                                    'NameNumber'=>$index.'.1',
                                    'DocumentHolder'=>'true'
                                ],
                                'GivenName'=>$adult->pax_first_name . ' ' . $adult->pax_mid_name,
                                'Surname'=>$adult->pax_last_name
                            ],
                            'VendorPrefs'=>[
                                'Airline'=>[
                                    '_attributes'=>[
                                        'Hosted'=>'false'
                                    ]
                                ]
                            ]
                        ];

                    } else {
                        $bodyArray['PassengerDetailsRQ']['SpecialReqDetails']['SpecialServiceRQ']['SpecialServiceInfo']['SecureFlight'.$space] = [
                            '_attributes'=>[
                                'SegmentNumber'=>'A'
                            ],
                            'PersonName'=>[
                                '_attributes'=>[
                                    'DateOfBirth'=>Carbon::parse($adult->dob)->format('Y-m-d'),
                                    'Gender'=>$adult->pax_gender,
                                    'NameNumber'=>$index.'.1'
                                ],
                                'GivenName'=>$adult->pax_first_name . ' ' . $adult->pax_mid_name,
                                'Surname'=>$adult->pax_last_name
                            ]
                        ];
                    }
                } else {
                    $bodyArray['PassengerDetailsRQ']['SpecialReqDetails']['SpecialServiceRQ']['SpecialServiceInfo']['SecureFlight'.$space] = [
                        '_attributes'=>[
                            'SegmentNumber'=>'A'
                        ],
                        'PersonName'=>[
                            '_attributes'=>[
                                'DateOfBirth'=>Carbon::parse($adult->dob)->format('Y-m-d'),
                                'Gender'=>$adult->pax_gender,
                                'NameNumber'=>$index.'.1'
                            ],
                            'GivenName'=>$adult->pax_first_name . ' ' . $adult->pax_mid_name,
                            'Surname'=>$adult->pax_last_name
                        ]
                    ];
                }

                $space = $space.' ';
                $index++;
            }
            $record++;
        }
        if($childs->count() > 0){
            foreach($childs as $child){
                if(isset($child->freq_flier_code) && isset($child->freq_flier_airline)){
                    $bodyArray['PassengerDetailsRQ']['TravelItineraryAddInfoRQ']['CustomerInfo']['CustLoayalty'.$loyaltySpace] = [
                        '_attributes'=>[
                            'MemberShipID'=>$child->freq_flier_code,
                            'NameNumber'=>$index.'.1',
                            'ProgramID'=>$child->freq_flier_airline,
                            'SegmentNumber'=>'A',
                            'TravellingCarrierCode'=>$airline
                        ]
                    ];
                    $loyaltySpace = $loyaltySpace.' ';
                }
                $bodyArray['PassengerDetailsRQ']['PriceQuoteInfo']['Link'.$space] = [
                    '_attributes'=>[
                        'nameNumber'=>$index.'.1',
                        'record'=>$record
                    ]
                ];
                if(isset($child->doc_number)){
                    if($child->doc_type == 'Passport'){
                        $bodyArray['PassengerDetailsRQ']['SpecialReqDetails']['SpecialServiceRQ']['SpecialServiceInfo']['AdvancePassenger'.$space] = [
                            '_attributes'=>[
                                'SegmentNumber'=>'A'
                            ],
                            'Document'=>[
                                '_attributes'=>[
                                    'ExpirationDate'=>Carbon::parse($child->doc_expiry_date)->format('Y-m-d'),
                                    'Number'=>$child->doc_number,
                                    'Type'=>'P'
                                ],
                                'IssueCountry'=>$child->doc_issued_by,
                                'NationalityCountry'=>$child->nationality
                            ],
                            'PersonName'=>[
                                '_attributes'=>[
                                    'DateOfBirth'=>Carbon::parse($child->dob)->format('Y-m-d'),
                                    'Gender'=>$child->pax_gender,
                                    'NameNumber'=>$index.'.1',
                                    'DocumentHolder'=>'true'
                                ],
                                'GivenName'=>$child->pax_first_name . ' ' . $child->pax_mid_name,
                                'Surname'=>$child->pax_last_name
                            ],
                            'VendorPrefs'=>[
                                'Airline'=>[
                                    '_attributes'=>[
                                        'Hosted'=>'false'
                                    ]
                                ]
                            ]
                        ];
                    } else {
                        $bodyArray['PassengerDetailsRQ']['SpecialReqDetails']['SpecialServiceRQ']['SpecialServiceInfo']['SecureFlight'.$space] = [
                            '_attributes'=>[
                                'SegmentNumber'=>'A'
                            ],
                            'PersonName'=>[
                                '_attributes'=>[
                                    'DateOfBirth'=>Carbon::parse($child->dob)->format('Y-m-d'),
                                    'Gender'=>$child->pax_gender,
                                    'NameNumber'=>$index.'.1'
                                ],
                                'GivenName'=>$child->pax_first_name . ' ' . $child->pax_mid_name,
                                'Surname'=>$child->pax_last_name
                            ]
                        ];
                    }
                } else {
                    $bodyArray['PassengerDetailsRQ']['SpecialReqDetails']['SpecialServiceRQ']['SpecialServiceInfo']['SecureFlight'.$space] = [
                        '_attributes'=>[
                            'SegmentNumber'=>'A'
                        ],
                        'PersonName'=>[
                            '_attributes'=>[
                                'DateOfBirth'=>Carbon::parse($child->dob)->format('Y-m-d'),
                                'Gender'=>$child->pax_gender,
                                'NameNumber'=>$index.'.1'
                            ],
                            'GivenName'=>$child->pax_first_name . ' ' . $child->pax_mid_name,
                            'Surname'=>$child->pax_last_name
                        ]
                    ];
                }

                $bodyArray['PassengerDetailsRQ']['TravelItineraryAddInfoRQ']['CustomerInfo']['PersonName'.$space]=[
                    '_attributes'=>[
                        'Infant'=>'false',
                        'NameNumber'=>$index.'.1',
                        'PassengerType'=>'CNN',
                        'NameReference'=>$this->generateNameReferenceForChild($child->dob)
                    ],
                    'GivenName'=>$child->pax_first_name . ' ' . $child->pax_mid_name,
                    'Surname'=>$child->pax_last_name
                ];
                $space = $space.' ';
                $serviceSpace = $serviceSpace.' ';
                $index++;
            }
            $record++;
        }
        if($infants->count() > 0){
            $adtIndex = 1;
            foreach($infants as $infant){
                $bodyArray['PassengerDetailsRQ']['PriceQuoteInfo']['Link'.$space] = [
                    '_attributes'=>[
                        'nameNumber'=>$index.'.1',
                        'record'=>$record
                    ]
                ];
                if(isset($infant->doc_number)){
                    if($infant->doc_type == 'Passport'){
                        $bodyArray['PassengerDetailsRQ']['SpecialReqDetails']['SpecialServiceRQ']['SpecialServiceInfo']['AdvancePassenger'.$space] = [
                            '_attributes'=>[
                                'SegmentNumber'=>'A'
                            ],
                            'Document'=>[
                                '_attributes'=>[
                                    'ExpirationDate'=>Carbon::parse($infant->doc_expiry_date)->format('Y-m-d'),
                                    'Number'=>$infant->doc_number,
                                    'Type'=>'P'
                                ],
                                'IssueCountry'=>$infant->doc_issued_by,
                                'NationalityCountry'=>$infant->nationality
                            ],
                            'PersonName'=>[
                                '_attributes'=>[
                                    'DateOfBirth'=>Carbon::parse($infant->dob)->format('Y-m-d'),
                                    'Gender'=>$infant->pax_gender.'I',
                                    'NameNumber'=>$adtIndex.'.1',
                                    'DocumentHolder'=>'true'
                                ],
                                'GivenName'=>$infant->pax_first_name . ' ' . $infant->pax_mid_name,
                                'Surname'=>$infant->pax_last_name
                            ],
                            'VendorPrefs'=>[
                                'Airline'=>[
                                    '_attributes'=>[
                                        'Hosted'=>'false'
                                    ]
                                ]
                            ]
                        ];
                    } else {
                        $bodyArray['PassengerDetailsRQ']['SpecialReqDetails']['SpecialServiceRQ']['SpecialServiceInfo']['SecureFlight'.$space] = [
                            '_attributes'=>[
                                'SegmentNumber'=>'A'
                            ],
                            'PersonName'=>[
                                '_attributes'=>[
                                    'DateOfBirth'=>Carbon::parse($infant->dob)->format('Y-m-d'),
                                    'Gender'=>$infant->pax_gender,
                                    'NameNumber'=>$index.'.1'
                                ],
                                'GivenName'=>$infant->pax_first_name . ' ' . $infant->pax_mid_name,
                                'SurName'=>$infant->pax_last_name
                            ]
                        ];
                    }
                } else {
                    $bodyArray['PassengerDetailsRQ']['SpecialReqDetails']['SpecialServiceRQ']['SpecialServiceInfo']['SecureFlight'.$space] = [
                        '_attributes'=>[
                            'SegmentNumber'=>'A'
                        ],
                        'PersonName'=>[
                            '_attributes'=>[
                                'DateOfBirth'=>Carbon::parse($infant->dob)->format('Y-m-d'),
                                'Gender'=>$infant->pax_gender,
                                'NameNumber'=>$index.'.1'
                            ],
                            'GivenName'=>$infant->pax_first_name . ' ' . $infant->pax_mid_name,
                            'SurName'=>$infant->pax_last_name
                        ]
                    ];
                }

                $bodyArray['PassengerDetailsRQ']['TravelItineraryAddInfoRQ']['CustomerInfo']['PersonName'.$space]=[
                    '_attributes'=>[
                        'Infant'=>'true',
                        'NameNumber'=>$index.'.1',
                        'PassengerType'=>'INF',
                        'NameReference'=>$this->generateNameReferenceForInfant($infant->dob)
                    ],
                    'GivenName'=>$infant->pax_first_name . ' ' . $infant->pax_mid_name,
                    'Surname'=>$infant->pax_last_name
                ];
                $space = $space.' ';
                $index++;
            }
        }
        $index = 1;

        if($adults->count() > 0){
            foreach($adults as $adult){

                if(isset($adult->doc_number) && $adult->doc_type != 'Passport'){
                    $bodyArray['PassengerDetailsRQ']['SpecialReqDetails']['SpecialServiceRQ']['SpecialServiceInfo']['Service'.$serviceSpace] =[
                        '_attributes'=>[
                            'SSR_Code'=>'OSI',
                        ],
                        'PersonName'=>[
                            '_attributes'=>[
                                'NameNumber'=>$index.'.1'
                            ]

                        ],
                        'Text'=>$adult->doc_type.'Number '.$adult->doc_number,
                        'VendorPrefs'=>[
                            'Airline'=>[
                                '_attributes'=>[
                                    'Code'=>$airline,
                                    'Hosted'=>'false'
                                ],

                            ]
                        ]
                    ];
                    $serviceSpace = $serviceSpace.' ';
                }

                if(isset($adult->ssr_meal_code)){

                    $bodyArray['PassengerDetailsRQ']['SpecialReqDetails']['SpecialServiceRQ']['SpecialServiceInfo']['Service '.$serviceSpace] = [
                        '_attributes'=>[
                            'SegmentNumber'=>'A',
                            'SSR_Code'=>$adult->ssr_meal_code
                        ],
                        'PersonName'=>[
                            '_attributes'=>[
                                'NameNumber'=>$index.'.1'
                            ]
                        ],
                        'VendorPrefs'=>[
                            'Airline'=>[
                                '_attributes'=>[
                                    'Hosted'=>'false'
                                ]
                            ]
                        ]
                    ];
                    $serviceSpace = $serviceSpace.' ';
                }
//                dd($body);

                if(isset($adult->ssr_request)){
                    $bodyArray['PassengerDetailsRQ']['SpecialReqDetails']['SpecialServiceRQ']['SpecialServiceInfo']['Service  '.$serviceSpace] = [
                        '_attributes'=>[
                            'SegmentNumber'=>'A',
                            'SSR_Code'=>$adult->ssr_request
                        ],
                        'PersonName'=>[
                            '_attributes'=>[
                                'NameNumber'=>$index.'.1'
                            ]
                        ],
                        'VendorPrefs'=>[
                            'Airline'=>[
                                '_attributes'=>[
                                    'Hosted'=>'false'
                                ]
                            ]
                        ]
                    ];
                    $serviceSpace = $serviceSpace.' ';
                }

                $index++;
            }
        }

        if($childs->count() > 0){
            foreach($childs as $child){
                $bodyArray['PassengerDetailsRQ']['SpecialReqDetails']['SpecialServiceRQ']['SpecialServiceInfo']['Service'.$serviceSpace]=[
                    '_attributes'=>[
                        'SegmentNumber'=>'A',
                        'SSR_Code'=>'CHLD'
                    ],
                    'PersonName'=>[
                        '_attributes'=>[
                            'NameNumber'=>$index.'.1'
                        ]
                    ],
                    'VendorPrefs'=>[
                        'Airline'=>[
                            '_attributes'=>[
                                'Hosted'=>'false'
                            ]
                        ]
                    ]
                ];

                $serviceSpace = $serviceSpace.' ';
                if(isset($child->doc_number) && $child->doc_type != 'Passport'){
                    $bodyArray['PassengerDetailsRQ']['SpecialReqDetails']['SpecialServiceRQ']['SpecialServiceInfo']['Service'.$serviceSpace] =[
                        '_attributes'=>[
                            'SSR_Code'=>'OSI',
                        ],
                        'PersonName'=>[
                            '_attributes'=>[
                                'NameNumber'=>$index.'.1'
                            ]

                        ],
                        'Text'=>$child->doc_type.'Number '.$child->doc_number,
                        'VendorPrefs'=>[
                            'Airline'=>[
                                '_attributes'=>[
                                    'Code'=>$airline,
                                    'Hosted'=>'false'
                                ],

                            ]
                        ]


                    ];
                    $serviceSpace = $serviceSpace.' ';
                }
                if(isset($child->ssr_meal_code)){
                    $bodyArray['PassengerDetailsRQ']['SpecialReqDetails']['SpecialServiceRQ']['SpecialServiceInfo']['Service'.$serviceSpace] = [
                        '_attributes'=>[
                            'SegmentNumber'=>'A',
                            'SSR_Code'=>$child->ssr_meal_code
                        ],
                        'PersonName'=>[
                            '_attributes'=>[
                                'NameNumber'=>$index.'.1'
                            ]
                        ],
                        'VendorPrefs'=>[
                            'Airline'=>[
                                '_attributes'=>[
                                    'Hosted'=>'false'
                                ]
                            ]
                        ]
                    ];
                    $serviceSpace = $serviceSpace.' ';
                }
                if(isset($child->ssr_request)){
                    $bodyArray['PassengerDetailsRQ']['SpecialReqDetails']['SpecialServiceRQ']['SpecialServiceInfo']['Service'.$serviceSpace] = [
                        '_attributes'=>[
                            'SegmentNumber'=>'A',
                            'SSR_Code'=>$child->ssr_request
                        ],
                        'PersonName'=>[
                            '_attributes'=>[
                                'NameNumber'=>$index.'.1'
                            ]
                        ],
                        'VendorPrefs'=>[
                            'Airline'=>[
                                '_attributes'=>[
                                    'Hosted'=>'false'
                                ]
                            ]
                        ]
                    ];
                    $serviceSpace = $serviceSpace.' ';
                }
                $index++;
            }
        }
        $adtIndex = 1;
        if($infants->count() > 0){
            foreach ($infants as $infant){
                $bodyArray['PassengerDetailsRQ']['SpecialReqDetails']['SpecialServiceRQ']['SpecialServiceInfo']['Service'.$serviceSpace]=[
                    '_attributes'=>[
                        'SSR_Code'=>'INFT'
                    ],
                    'PersonName'=>[
                        '_attributes'=>[
                            'NameNumber'=>$adtIndex.'.1',
                        ]
                    ],

                    'Text'=>$infant->pax_last_name.'/'.$infant->pax_first_name . ' ' . $infant->pax_mid_name.'/'.$this->generateBirthDate($infant->dob),
                    'VendorPrefs'=>[
                        'Airline'=>[
                            '_attributes'=>[
                                'Hosted'=>'false'
                            ]
                        ]
                    ]
                ];

                $serviceSpace = $serviceSpace.' ';
                if(isset($infant->doc_number) && $infant->doc_type != 'Passport'){
                    $bodyArray['PassengerDetailsRQ']['SpecialReqDetails']['SpecialServiceRQ']['SpecialServiceInfo']['Service'.$serviceSpace] =[
                        '_attributes'=>[
                            'SSR_Code'=>'OSI',
                        ],
                        'PersonName'=>[
                            '_attributes'=>[
                                'NameNumber'=>$adtIndex.'.1'
                            ]
                        ],
                        'Text'=>$infant->doc_type.'Number '.$infant->doc_number,
                        'VendorPrefs'=>[
                            'Airline'=>[
                                '_attributes'=>[
                                    'Code'=>$airline,
                                    'Hosted'=>'false'
                                ],
                            ]
                        ]
                    ];
                    $serviceSpace = $serviceSpace.' ';
                }
                if(isset($infant->ssr_meal_code)){
                    $bodyArray['PassengerDetailsRQ']['SpecialReqDetails']['SpecialServiceRQ']['SpecialServiceInfo']['Service'.$serviceSpace] = [
                        '_attributes'=>[
                            'SegmentNumber'=>'A',
                            'SSR_Code'=>$infant->ssr_meal_code
                        ],
                        'PersonName'=>[
                            '_attributes'=>[
                                'NameNumber'=>$adtIndex.'.1'
                            ]
                        ],
                        'VendorPrefs'=>[
                            'Airline'=>[
                                '_attributes'=>[
                                    'Hosted'=>'false'
                                ]
                            ]
                        ]
                    ];
                    $serviceSpace = $serviceSpace.' ';
                }

                if(isset($infant->ssr_request)){
                    $bodyArray['PassengerDetailsRQ']['SpecialReqDetails']['SpecialServiceRQ']['SpecialServiceInfo']['Service'.$serviceSpace] = [
                        '_attributes'=>[
                            'SegmentNumber'=>'A',
                            'SSR_Code'=>$infant->ssr_request
                        ],
                        'PersonName'=>[
                            '_attributes'=>[
                                'NameNumber'=>$adtIndex.'.1'
                            ]
                        ],
                        'VendorPrefs'=>[
                            'Airline'=>[
                                '_attributes'=>[
                                    'Hosted'=>'false'
                                ]
                            ]
                        ]
                    ];
                    $serviceSpace = $serviceSpace.' ';
                }

                $adtIndex++;
            }
        }

        $bodyArray['PassengerDetailsRQ']['SpecialReqDetails']['SpecialServiceRQ']['SpecialServiceInfo']['Service'.$serviceSpace.' ']=[
            '_attributes'=>[
                'SSR_Code'=>'CTCM',
            ],
            'PersonName'=>[
                '_attributes'=>[
                    'NameNumber'=>'1.1'
                ]
            ],
            //'Text'=>$contact['phone'],
'Text'=>'014418644',
            'VendorPrefs'=>[
                'Airline'=>[
                    '_attributes'=>[
                        'Hosted'=>'false'
                    ]
                ]
            ]
        ];
        $bodyArray['PassengerDetailsRQ']['SpecialReqDetails']['SpecialServiceRQ']['SpecialServiceInfo']['Service'.$serviceSpace.'  ']=[
            '_attributes'=>[
                'SSR_Code'=>'CTCE',
            ],
            'PersonName'=>[
                '_attributes'=>[
                    'NameNumber'=>'1.1'
                ]
            ],
            //'Text'=>'reservation//flightsgyani.com',
            'Text'=>str_replace('@','//',$contact['email']),
            'VendorPrefs'=>[
                'Airline'=>[
                    '_attributes'=>[
                        'Hosted'=>'false'
                    ]
                ]
            ]
        ];
//        dd($body_array);
        $body_xml = XMLSerializer::generateValidXmlFromArray($bodyArray);
        return $body_xml;

    }

    private function generateNameReferenceForChild($date)
    {
        $obj = Carbon::parse($date);
        $year = $obj->diffInYears(Carbon::now());
        if($year<10){
            return "C0".$year;
        } else {
            return "C".$year;
        }

    }

    private function generateNameReferenceForInfant($date)
    {
        $obj = Carbon::parse($date);
        $month = $obj->diffInMonths(Carbon::now());
        if($month < 10) {
            return "I0".$month;
        } else {
            return "I".$month;
        }

    }

    private function generateBirthDate($date)
    {
        $obj = Carbon::parse($date);
        return $obj->format('dMy');
    }

    public function formatResponse($response)
    {
//        $response = $this->tempResponse();
        $doc = new DOMDocument();
        $doc->loadXML($response);
        $xml_array = XMLSerializer::XMLtoArray($response);

        $soap_fault_body = $this->checkSoapFault($xml_array);

        if ($soap_fault_body) {
            return false;
        }

        $status = $this->checkResponseStatus($doc);
//        dd($status);
        if (!$status) {
            return false;
        }
        $formatted_response = [];
        $pnr = $doc->getElementsByTagName('ItineraryRef')->item(0)->getAttributeNode('ID')->value;
        $reservations = $doc->getElementsByTagName('ReservationItems')->item(0);
        $items = $reservations->getElementsByTagName('Item');
        $flights = [];
        foreach ($items as $item) {
            $rph = $item->getAttribute('RPH');
            $flights[$rph] = [];
            $flightsegments = $item->getElementsByTagName('FlightSegment');
            foreach ($flightsegments as $segment) {
                $arrivaldatetime = $segment->getAttribute('ArrivalDateTime');
                $depardatetime = $segment->getAttribute('DepartureDateTime');
                $elapstime = $segment->getAttribute('ElapsedTime');
                $flightnumber = $segment->getAttribute('FlightNumber');
                $destinationdetails = $segment->getElementsByTagName('DestinationLocation')->item(0);
                $destination = $destinationdetails->getAttribute('LocationCode');
                if ($destinationdetails->hasAttribute('Terminal')) {
                    $destterminal = $destinationdetails->getAttribute('Terminal');
                } else {
                    $destterminal = 'Not Available';
                }
                $aerotype = $segment->getElementsByTagName('Equipment')->item(0)->getAttribute('AirEquipType');
                $markairline = $segment->getElementsByTagName('MarketingAirline')->item(0)->getAttribute('Code');
                $origindetails = $segment->getElementsByTagName('OriginLocation')->item(0);
                $origin = $origindetails->getAttribute('LocationCode');
                if ($origindetails->hasAttribute('Terminal')) {
                    $originterminal = $origindetails->getAttribute('Terminal');
                } else {
                    $originterminal = 'Not Available';
                }
                array_push($flights[$rph], [
                    'origin' => $origin,
                    'destination' => $destination,
                    'originter' => $originterminal,
                    'destinter' => $destterminal,
                    'departdate' => $this->getFlightDate($depardatetime)[0],
                    'departtime' => $this->getFlightDate($depardatetime)[1],
                    'arrivaldate' => $this->getFlightDate($arrivaldatetime)[0],
                    'arrivaltime' => $this->getFlightDate($arrivaldatetime)[1],
                    'airtype' => $aerotype
                ]);
            }
        }
        $pricing = $doc->getElementsByTagName('PriceQuoteTotals')->item(0);
        $basefare = $pricing->getElementsByTagName('BaseFare')->item(0)->getAttribute('Amount');
        $tax = $pricing->getElementsByTagName('Tax')->item(0)->getAttribute('Amount');
        $total = $pricing->getElementsByTagName('TotalFare')->item(0)->getAttribute('Amount');
        $formatted_response['pnr'] = $pnr;
        $formatted_response['flights'] = $flights;
        $formatted_response['pricing'] = [
            'basefare' => $basefare,
            'tax' => $tax,
            'total' => $total
        ];
        return $formatted_response;

    }

    public function tempResponse()
    {
        return <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<soap-env:Envelope xmlns:soap-env="http://schemas.xmlsoap.org/soap/envelope/">
	<soap-env:Header>
		<eb:MessageHeader xmlns:eb="http://www.ebxml.org/namespaces/messageHeader" eb:version="1.0" soap-env:mustUnderstand="1">
			<eb:From>
				<eb:PartyId eb:type="urn:x12.org.IO5:01">webservices.sabre.com</eb:PartyId>
			</eb:From>
			<eb:To>
				<eb:PartyId eb:type="urn:x12.org.IO5:01">4e0bc8399496d694</eb:PartyId>
			</eb:To>
			<eb:CPAId>SE1J</eb:CPAId>
			<eb:ConversationId>4e0bc8399496d694</eb:ConversationId>
			<eb:Service eb:type="SabreXML">PassengerDetailsRQ</eb:Service>
			<eb:Action>PassengerDetailsRS</eb:Action>
			<eb:MessageData>
				<eb:MessageId>qiak6t80w</eb:MessageId>
				<eb:Timestamp>2019-04-28T11:09:57</eb:Timestamp>
				<eb:RefToMessageId>4e0bc8399496d694</eb:RefToMessageId>
			</eb:MessageData>
		</eb:MessageHeader>
		<wsse:Security xmlns:wsse="http://schemas.xmlsoap.org/ws/2002/12/secext">
			<wsse:BinarySecurityToken valueType="String" EncodingType="wsse:Base64Binary">Shared/IDL:IceSess\/SessMgr:1\.0.IDL/Common/!ICESMS\/ACPCRTD!ICESMSLB\/CRT.LB!1556449643625!1607!13</wsse:BinarySecurityToken>
		</wsse:Security>
	</soap-env:Header>
	<soap-env:Body>
		<PassengerDetailsRS xmlns="http://services.sabre.com/sp/pd/v3_3">
			<ApplicationResults xmlns="http://services.sabre.com/STL_Payload/v02_01" status="Complete">
				<Success timeStamp="2019-04-28T06:09:57.671-05:00"/>
				<Warning type="BusinessLogic" timeStamp="2019-04-28T06:09:57.435-05:00">
					<SystemSpecificResults>
						<Message code="WARN.SWS.HOST.WARNING_RESPONSE">EndTransactionLLSRQ: TTY REQ PEND</Message>
					</SystemSpecificResults>
				</Warning>
			</ApplicationResults>
			<ItineraryRef ID="VNJMAA"/>
			<TravelItineraryReadRS>
				<TravelItinerary>
					<CustomerInfo>
						<Address>
							<AddressLine type="O">FAST INTL TRAVEL</AddressLine>
							<AddressLine type="O">12</AddressLine>
							<AddressLine type="O">KATHMANDU NP</AddressLine>
							<AddressLine type="O">00977</AddressLine>
						</Address>
						<ContactNumbers>
							<ContactNumber LocationCode="KTM" Phone="3265128745-A-1.1" RPH="001"/>
						</ContactNumbers>
						<PaymentInfo>
							<Payment>
								<Form RPH="001">
									<Text>CASH</Text>
								</Form>
							</Payment>
						</PaymentInfo>
						<PersonName WithInfant="false" NameNumber="01.01" PassengerType="ADT" RPH="1">
							<Email Comment="AIRLINETICKET">TEST@TEST.COM</Email>
							<GivenName>SUGAM</GivenName>
							<Surname>PARAJULI</Surname>
						</PersonName>
					</CustomerInfo>
					<ItineraryInfo>
						<ItineraryPricing>
							<PriceQuote RPH="1">
								<MiscInformation>
									<SignatureLine ExpirationDateTime="00:00" Source="SYS" Status="ACTIVE">
										<Text>SE1J SE1J*AWS 1639/28APR19</Text>
									</SignatureLine>
									<TicketingFees Disclaimer="ONE OR MORE FORM OF PAYMENT FEES MAY APPLY"/>
									<TicketingFees Disclaimer="ACTUAL TOTAL WILL BE BASED ON FORM OF PAYMENT USED"/>
									<TicketingFees Disclaimer="FEE CODE     DESCRIPTION                         FEE">
										<FeeInformation Amount="0" DisplayOnOutputInd="X" FunctionCode="FCA" ServiceType="OB" CurrenyCode="" Description="">- ANY CC</FeeInformation>
										<FeeInformation Amount="399" FunctionCode="FCA" ServiceType="OB" CurrenyCode="" Description="">- ANY CC</FeeInformation>
										<FeeInformation Amount="0" DisplayOnOutputInd="X" FunctionCode="FDA" ServiceType="OB" CurrenyCode="" Description="">- ANY CC</FeeInformation>
									</TicketingFees>
								</MiscInformation>
								<PricedItinerary DisplayOnly="false" InputMessage="WPA9WP1ADTXOTE-NQRQ" RPH="1" StatusCode="A" TaxExempt="false" ValidatingCarrier="9W">
									<AirItineraryPricingInfo>
										<ItinTotalFare>
											<BaseFare Amount="8200" CurrencyCode="NPR"/>
											<Taxes>
												<Tax Amount="8124" TaxCode="XT"/>
												<TaxBreakdownCode TaxPaid="false">0NQ</TaxBreakdownCode>
												<TaxBreakdownCode TaxPaid="false">791NP</TaxBreakdownCode>
												<TaxBreakdownCode TaxPaid="false">1000B6</TaxBreakdownCode>
												<TaxBreakdownCode TaxPaid="false">1131YR</TaxBreakdownCode>
												<TaxBreakdownCode TaxPaid="false">5202YQ</TaxBreakdownCode>
											</Taxes>
											<TotalFare Amount="16324" CurrencyCode="NPR"/>
											<Totals>
												<BaseFare Amount="8200"/>
												<Taxes>
													<Tax Amount="8124"/>
												</Taxes>
												<TotalFare Amount="16324"/>
											</Totals>
										</ItinTotalFare>
										<PassengerTypeQuantity Code="ADT" Quantity="01"/>
										<PTC_FareBreakdown>
											<Endorsements>
												<Endorsement type="PRICING_PARAMETER">
													<Text>WPA9WP1ADTXOTE-NQRQ</Text>
												</Endorsement>
												<Endorsement type="WARNING">
													<Text>VALIDATING CARRIER SPECIFIED - 9W</Text>
												</Endorsement>
												<Endorsement type="SYSTEM_ENDORSEMENT">
													<Text>NON ENDO</Text>
												</Endorsement>
											</Endorsements>
											<FareBasis Code="K2OWNP"/>
											<FareCalculation>
												<Text>KTM 9W DEL72.56NUC72.56END ROE112.997859</Text>
											</FareCalculation>
											<FareSource>ATPC</FareSource>
											<FlightSegment ConnectionInd="O" DepartureDateTime="05-04T17:15" FlightNumber="259" ResBookDesigCode="K" SegmentNumber="1" Status="OK">
												<BaggageAllowance Number="20K"/>
												<FareBasis Code="K2OWNP"/>
												<MarketingAirline Code="9W" FlightNumber="259"/>
												<OriginLocation LocationCode="KTM"/>
												<ValidityDates>
													<NotValidAfter>2019-05-04</NotValidAfter>
													<NotValidBefore>2019-05-04</NotValidBefore>
												</ValidityDates>
											</FlightSegment>
											<FlightSegment>
												<OriginLocation LocationCode="DEL"/>
											</FlightSegment>
										</PTC_FareBreakdown>
									</AirItineraryPricingInfo>
								</PricedItinerary>
								<ResponseHeader>
									<Text>FARE - PRICE RETAINED</Text>
									<Text>FARE USED TO CALCULATE DISCOUNT</Text>
									<Text>FARE NOT GUARANTEED UNTIL TICKETED</Text>
								</ResponseHeader>
								<PriceQuotePlus DomesticIntlInd="I" PricingStatus="M" VerifyFareCalc="false" ItineraryChanged="false" ManualFare="false" NegotiatedFare="false" SystemIndicator="S" NUCSuppresion="false" SubjToGovtApproval="false" IT_BT_Fare="BT" DisplayOnly="false" DiscountAmount="0">
									<PassengerInfo>
										<PassengerData NameNumber="01.01">PARAJULI/SUGAM</PassengerData>
									</PassengerInfo>
									<TicketingInstructionsInfo/>
								</PriceQuotePlus>
							</PriceQuote>
							<PriceQuoteTotals>
								<BaseFare Amount="8200.00"/>
								<Taxes>
									<Tax Amount="8124.00"/>
								</Taxes>
								<TotalFare Amount="16324.00"/>
							</PriceQuoteTotals>
						</ItineraryPricing>
						<ReservationItems>
							<Item RPH="1">
								<FlightSegment AirMilesFlown="0507" ArrivalDateTime="05-04T18:50" DayOfWeekInd="6" DepartureDateTime="2019-05-04T17:15" ElapsedTime="01.50" eTicket="true" FlightNumber="0259" NumberInParty="01" ResBookDesigCode="K" SegmentNumber="0001" SmokingAllowed="false" SpecialMeal="false" Status="HK" StopQuantity="00" IsPast="false">
									<DestinationLocation LocationCode="DEL" Terminal="TERMINAL 3" TerminalCode="3"/>
									<Equipment AirEquipType="73H"/>
									<MarketingAirline Code="9W" FlightNumber="0259"/>
									<Meal Code="S"/>
									<OriginLocation LocationCode="KTM"/>
									<SupplierRef ID="DC9W"/>
									<UpdatedArrivalTime>05-04T18:50</UpdatedArrivalTime>
									<UpdatedDepartureTime>05-04T17:15</UpdatedDepartureTime>
								</FlightSegment>
							</Item>
						</ReservationItems>
						<Ticketing RPH="01" TicketTimeLimit="TAW/"/>
					</ItineraryInfo>
					<ItineraryRef AirExtras="false" ID="VNJMAA" InhibitCode="U" PartitionID="AA" PrimeHostID="1B">
						<Header>PRICE QUOTE RECORD - MODIFIED</Header>
						<Source AAA_PseudoCityCode="SE1J" CreateDateTime="2019-04-28T06:09" CreationAgent="AWS" HomePseudoCityCode="SE1J" PseudoCityCode="SE1J" ReceivedFrom="SWS TESTING" LastUpdateDateTime="2019-04-28T06:09" SequenceNumber="1"/>
					</ItineraryRef>
					<RemarkInfo/>
					<SpecialServiceInfo RPH="001" Type="GFX">
						<Service SSR_Code="SSR" SSR_Type="DOCS">
							<Airline Code="9W"/>
							<PersonName NameNumber="01.01">PARAJULI/SUGAM</PersonName>
							<Text>HK1/P/NP/154239874/NP/20FEB1992/M/19JUN2024/PARAJULI/SUGAM /H</Text>
						</Service>
					</SpecialServiceInfo>
					<OpenReservationElements>
						<OpenReservationElement id="3" type="FP" displayIndex="1"/>
					</OpenReservationElements>
				</TravelItinerary>
			</TravelItineraryReadRS>
		</PassengerDetailsRS>
	</soap-env:Body>
</soap-env:Envelope>
XML;


    }

    private function generateDateOfBirth($date)
    {
        $carbonobject = Carbon::parse($date);
//        $dob = $carbon->isoFormat('DDMMMYY');
        $dob = $carbonobject->toDateString();
//        dd($dob);
        return $dob;
    }
}
