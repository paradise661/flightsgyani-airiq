<?php

namespace App\Service\Sabre\Request;

use App\Models\InternationalFlight\FlightBooking;
use App\Models\InternationalFlight\FlightBookingDetail;
use App\Service\Sabre\BSPCommissionService;
use App\Service\Sabre\SabreBasic;
use App\Service\XMLSerializer;

class TicketIssueRQ extends SabreBasic
{

    public function doRequest($booking)
    {
        $bodyXML = $this->generateBody($booking);
        $requestXML = $this->generateEnvelopeXmlWithSecurityHeaderFromBody('AirTicketRQ', $bodyXML);
        if (is_dir('../storage/app/public/international/' . session()->get('flight_search'))) {
            $checkfile = '../storage/app/public/international/' . session()->get('flight_search') . '/AirTicketIssueRQ.txt';
            if (file_exists($checkfile)) {
                $file = '../storage/app/public/international/' . session()->get('flight_search') . '/AirTicketIssueRQ' . time() . '.txt';
            } else {
                $file = $checkfile;
            }
            file_put_contents($file, $requestXML);
        } else {
            mkdir('../storage/app/public/international/' . session()->get('flight_search'), 0755, true);
            $file = '../storage/app/public/international/' . session()->get('flight_search') . '/AirTicketIssueRQ.txt';
            file_put_contents($file, $requestXML);
        }
        $responseXML = $this->doSoapRequest($requestXML);
        $checkfile = '../storage/app/public/international/' . session()->get('flight_search') . '/AirTicketIssueRS.txt';
        if (file_exists($checkfile)) {
            $file = '../storage/app/public/international/' . session()->get('flight_search') . '/AirTicketIssueRS' . time() . '.txt';
        } else {
            $file = $checkfile;
        }
        file_put_contents($file, $responseXML);
        $tickets = $this->formatResponse($responseXML);
        return $tickets;
    }

    public function generateBody($booking)
    {
        $adults = FlightBookingDetail::where(['flight_booking_id' => $booking->id, 'pax_type' => 'ADT'])->get();
        $childs = FlightBookingDetail::where(['flight_booking_id' => $booking->id, 'pax_type' => 'CHLD'])->get();
        $infants = FlightBookingDetail::where(['flight_booking_id' => $booking->id, 'pax_type' => 'INFT'])->get();
        $body = [
            'AirTicketRQ' => [
                '_attributes' => [
                    'xmlns' => 'http://services.sabre.com/sp/air/ticket/v1',
                    'version' => '1.2.0'
                ],
                'DesignatePrinter' => [
                    'Printers' => [
                        'Hardcopy' => [
                            '_attributes' => [
                                'LNIATA' => $this->lniata
                            ]
                        ],
                        'InvoiceItinerary' => [
                            '_attributes' => [
                                'LNIATA' => $this->lniata
                            ]
                        ],
                        'Ticket' => [
                            '_attributes' => [
                                'CountryCode' => 'IN'
                            ]
                        ]
                    ]
                ],
                'Itinerary' => [
                    '_attributes' => [
                        'ID' => $booking->pnr_id
                    ]
                ],
                'Ticketing' => [
                    'FlightQualifiers' => [
                        'VendorPrefs' => [
                            'Airline' => [
                                '_attributes' => [
                                    'Code' => $booking->airline
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
                ],
                'PostProcessing' => [
                    '_attributes' => [
                        'acceptNegotiatedFare' => 'true',
                        'acceptPriceChanges' => 'true',
                        'actionOnPQExpired' => 'Q'
                    ],
                    'EndTransaction' => [
                        'Source' => [
                            '_attributes' => [
                                'ReceivedFrom' => 'SWS'
                            ]
                        ]
                    ]
                ]
            ]
        ];

        if ($this->getBSPCommission($booking)) {
            $body['AirTicketRQ']['Ticketing']['MiscQualifiers']['Commission'] = [
                '_attributes' => [
                    'Percent' => $this->getBSPCommission($booking)
                ]
            ];

            $body['AirTicketRQ']['Ticketing']['MiscQualifiers']['Ticket'] = [
                '_attributes' => [
                    'Type' => 'ETR'
                ]
            ];
        } else {
            $body['AirTicketRQ']['Ticketing']['MiscQualifiers']['Ticket'] = [
                '_attributes' => [
                    'Type' => 'ETR'
                ]
            ];
        }

        $index = 1;
        $space = '';
        if ($adults->count() > 0) {
            $body['AirTicketRQ']['Ticketing']['PricingQualifiers']['PriceQuote']['Record' . $space] = [
                '_attributes' => [
                    'Number' => $index
                ]
            ];
            $space = $space . ' ';
            $index++;
        }
        if ($childs->count() > 0) {
            $body['AirTicketRQ']['Ticketing']['PricingQualifiers']['PriceQuote']['Record' . $space] = [
                '_attributes' => [
                    'Number' => $index
                ]
            ];
            $space = $space . ' ';
            $index++;
        }
        if ($infants->count() > 0) {
            $body['AirTicketRQ']['Ticketing']['PricingQualifiers']['PriceQuote']['Record' . $space] = [
                '_attributes' => [
                    'Number' => $index
                ]
            ];
            $space = $space . ' ';
            $index++;
        }

        $bodyXML = XMLSerializer::generateValidXmlFromArray($body);
        return $bodyXML;
    }

    public function getBSPCommission($booking)
    {

        $commissionService = new BSPCommissionService();
        $commission = $commissionService->calculateCommission($booking);
        return $commission;

    }

    public function formatResponse($response)
    {
        $doc = new \DOMDocument();
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
        $formattedResponse = [];
        $tickets = $doc->getElementsByTagName('Summary');
        foreach ($tickets as $ticket) {
            $number = $ticket->getElementsByTagName('DocumentNumber')->item(0)->nodeValue;
            $timestamp = $ticket->getElementsByTagName('LocalIssueDateTime')->item(0)->nodeValue;
            $pnr = $ticket->getElementsByTagName('Reservation')->item(0)->nodeValue;
            $firstname = $ticket->getElementsByTagName('FirstName')->item(0)->nodeValue;
            $lastname = $ticket->getElementsByTagName('LastName')->item(0)->nodeValue;
            $currency = $ticket->getElementsByTagName('TotalAmount')->item(0)->getAttribute('currencyCode');
            $amount = $ticket->getElementsByTagName('TotalAmount')->item(0)->nodeValue;
            array_push($formattedResponse, [
                'number' => $number,
                'time' => $timestamp,
                'pnr' => $pnr,
                'fname' => $firstname,
                'lname' => $lastname,
                'currency' => $currency,
                'amount' => $amount
            ]);
        }
        return $formattedResponse;
    }
}
