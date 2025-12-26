<?php

namespace App\Service\AirIq;

use App\Models\InternationalFlight\FlightBooking;
use App\Models\InternationalFlight\FlightBookingDetail;
use App\Models\InternationalFlight\FlightTicket;
use Exception;
use Illuminate\Support\Facades\Http;

class AirIqFlight
{
    private static $url = 'https://omairiq.azurewebsites.net';
    private static $username = '9555202202';
    private static $password = '1122333';
    private static $api_key = 'NTMzNDUwMDpBSVJJUSBURVNUIEFQSToxODkxOTMwMDM1OTk2OmpTMm0vUU1HVmQvelovZi81dFdwTEE9PQ==';

    public static function generateToken()
    {
        try {
            $response = Http::withHeaders([
                'api-key' => self::$api_key,
            ])->post(self::$url . "/login", [
                'Username' => self::$username,
                'Password' => self::$password,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                session()->put('airiq_token', $data['token']);
                session()->put('airiq_user', $data['user']);
                return $data;
            } else {
                return null;
            }
        } catch (Exception $error) {
            return null;
        }
    }

    public static function getFlights($search)
    {
        if (!session('airiq_token')) {
            self::generateToken();
        }

        try {
            $response = Http::withHeaders([
                'api-key' => self::$api_key,
                'Authorization' => session('airiq_token'),
            ])->post(self::$url . "/search", [
                "origin" => $search->departure,
                "destination" => $search->destination,
                "departure_date" => date('Y/m/d', strtotime($search->flight_date)),
                "adult" => $search->adults,
                "child" => $search->childs,
                "infant" => $search->infants,
                // "airline_code" => "6E"
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data;
            } else {
                return [];
            }
        } catch (Exception $error) {
            return [];
        }
    }

    public static function formatStructure(array $items, $search): array
    {
        return array_map(function ($item, $index) use ($search) {

            $price = $item['price'] ?? 0;
            $infantPrice = $item['infant_price'] ?? 0;

            // if ($search->nationality === 'NP') {
            $price = $price * 1.6;
            $infantPrice = $infantPrice * 1.6;
            // }
            $totalPrice = ($price  * ($search->adults + $search->childs)) + ($infantPrice * $search->infants);

            $breakdown[] =
                [
                    'type'         => 'ADT',
                    'qty'          => $search->adults ?? null,
                    'basefare'     => "NPR " . $price,
                    'tax'          => 'NPR 0',
                    'total'        => "NPR " . $price,
                    'refund'       => null,
                    'farecodes'    => [],
                    'taxbreakdown' => [],
                    'mbasefare'    => "NPR " . $price,
                    'markup'       => 0,
                    'mtotal'       => "NPR " . $price,

                ];

            if ($search->childs > 0) {
                $breakdown[] =
                    [
                        'type'         => 'CNN',
                        'qty'          => $search->childs ?? null,
                        'basefare'     => "NPR " . $price,
                        'tax'          => 'NPR 0',
                        'total'        => "NPR " . $price,
                        'refund'       => null,
                        'farecodes'    => [],
                        'taxbreakdown' => [],
                        'mbasefare'    => "NPR " . $price,
                        'markup'       => 0,
                        'mtotal'       => "NPR " . $price,

                    ];
            }

            if ($search->infants > 0) {
                $breakdown[] =
                    [
                        'type'         => 'INF',
                        'qty'          => $search->infants ?? null,
                        'basefare'     => "NPR " . $infantPrice,
                        'tax'          => 'NPR 0',
                        'total'        => "NPR " . $infantPrice,
                        'refund'       => null,
                        'farecodes'    => [],
                        'taxbreakdown' => [],
                        'mbasefare'    => "NPR " . $infantPrice,
                        'markup'       => 0,
                        'mtotal'       => "NPR " . $infantPrice,

                    ];
            }


            $baggage[] =
                [
                    'pax'        => 'ADT',
                    'type'       => 'Weight',
                    'unit'       => isset($item['cabin_baggage']) ? $item['cabin_baggage'] . ' kg' : null,
                    'description' => null,
                    'detail'     => []
                ];
            if ($search->childs > 0) {
                $baggage[] =
                    [
                        'pax'        => 'CNN',
                        'type'       => 'Weight',
                        'unit'       => isset($item['cabin_baggage']) ? $item['cabin_baggage'] . ' kg' : null,
                        'description' => null,
                        'detail'     => []
                    ];
            }

            if ($search->infants > 0) {
                $baggage[] =
                    [
                        'pax'        => 'INF',
                        'type'       => 'Weight',
                        'unit'       => isset($item['cabin_baggage']) ? $item['cabin_baggage'] . ' kg' : null,
                        'description' => null,
                        'detail'     => []
                    ];
            }

            return [
                'apiprovider' => 'airiq',
                'ticketid' => $item['ticket_id'] ?? null,
                'flight' => [
                    [
                        'sectors' => [
                            [
                                'departdate' => $item['departure_date'] ?? null,
                                'arrivaldate' => $item['arival_date'] ?? null,
                                'departtime' => $item['departure_time'] ?? null,
                                'arrivaltime' => $item['arival_time'] ?? null,
                                'departure' => $item['origin'] ?? null,
                                'depterminal' => null,
                                'arrivalterminal' => null,
                                'arrival' => $item['destination'] ?? null,
                                'departport' => null,
                                'arrivalport' => null,
                                'flightnumber' => $item['flight_number'] ?? null,
                                'stops' => $item['flight_route'] === 'Non-Stop' ? '0' : $item['flight_route'],
                                'class' => null,
                                'resbook' => null,
                                'flighttime' => self::getFlightDuration($item['departure_time'], $item['arival_time'])['minutes'] ?? null,
                                'elapstime' => self::getFlightDuration($item['departure_time'], $item['arival_time'])['formatted'] ?? null,
                                'operatingairline' => $item['airline'] ?? null,
                                'marketingairline' => $item['airline'] ?? null,
                                'valadatingairline' => $item['airline'] ?? null,
                            ]
                        ],
                        'time' => self::getFlightDuration($item['departure_time'], $item['arival_time'])['minutes'] ?? null
                    ]
                ],
                'pricing' => [
                    'basefare'    => "NPR " . $totalPrice,
                    'tax'         => 'NPR 0',
                    'total'       => "NPR " . $totalPrice,
                    'markedfare'  => "NPR " . $totalPrice,
                    'mbasefare'   => "NPR " . $totalPrice,
                ],
                'breakdown' => $breakdown,
                'farepenalty' => [],
                'baggage' => $baggage,
                'airline' => $item['airline'] ?? null,
                'rph' => (string) ($index + 1),
                'detail' => [
                    [
                        'seat'             => $item['pax'] ?? null,
                        'bag'              => isset($item['cabin_baggage']) ? $item['cabin_baggage'] . ' kg Weight' : null,
                        'origin'           => $item['origin'] ?? null,
                        'orgport'          => null,
                        'orgterminal'      => null,
                        'destination'      => $item['destination'] ?? null,
                        'destport'         => null,
                        'desterminal'      => null,
                        'stops'            => $item['flight_route'] === 'Non-Stop' ? '0' : $item['flight_route'],
                        'origintime'       => $item['departure_time'] ?? null,
                        'origindate'       => $item['departure_date'] ?? null,
                        'destinationdate'  => $item['arival_date'] ?? null,
                        'destinationtime'  => $item['arival_time'] ?? null,
                        'airline'          => $item['airline'] ?? null,
                        'totaltime'        => self::getFlightDuration($item['departure_time'], $item['arival_time'])['formatted'] ?? null,
                        'refundable'       => null
                    ]
                ]
            ];
        }, $items, array_keys($items));
    }

    public static function getFlightDuration(string $departure, string $arrival): array
    {
        $dep = \Carbon\Carbon::createFromFormat('H:i', $departure);
        $arr = \Carbon\Carbon::createFromFormat('H:i', $arrival);

        // Handle overnight flights
        if ($arr->lessThan($dep)) {
            $arr->addDay();
        }

        $diffInMinutes = $dep->diffInMinutes($arr);

        $hours = floor($diffInMinutes / 60);
        $minutes = $diffInMinutes % 60;

        $formatted = trim(
            ($hours > 0 ? "$hours Hr" : '') .
                ($minutes > 0 ? " $minutes mins" : '')
        );

        return [
            'minutes' => $diffInMinutes,
            'formatted' => $formatted
        ];
    }

    public static function bookFlight($booking)
    {
        try {
            $flightDetails = json_decode($booking->flights);
            $adults = FlightBookingDetail::where(['flight_booking_id' => $booking->id, 'pax_type' => 'ADT'])->get();
            $childs = FlightBookingDetail::where(['flight_booking_id' => $booking->id, 'pax_type' => 'CHLD'])->get();
            $infants = FlightBookingDetail::where(['flight_booking_id' => $booking->id, 'pax_type' => 'INFT'])->get();

            $adultInfo = [];
            foreach ($adults as $adt) {
                $adultInfo[] = [
                    "title" => $adt->pax_title == 'Mr.' ? 'Mstr.' : $adt->pax_title,
                    "first_name" => $adt->pax_first_name,
                    "last_name" => $adt->pax_last_name,
                    "passport_number" => $adt->doc_number,
                    "dob" => date('Y/m/d', strtotime($adt->dob)),
                    "passport_expirydate" => date('Y/m/d', strtotime($adt->doc_expiry_date)),
                    "passport_issuing_country_code" => $adt->doc_issued_by,
                    "nationality" => $adt->nationality
                ];
            }

            $childInfo = [];
            foreach ($childs as $chd) {
                $childInfo[] = [
                    "title" => $adt->pax_title == 'Mr.' ? 'Mstr.' : $adt->pax_title,
                    "first_name" => $chd->pax_first_name,
                    "last_name" => $chd->pax_last_name,
                    "passport_number" => $chd->doc_number,
                    "dob" => date('Y/m/d', strtotime($chd->dob)),
                    "passport_expirydate" => date('Y/m/d', strtotime($chd->doc_expiry_date)),
                    "passport_issuing_country_code" => $chd->doc_issued_by,
                    "nationality" => $chd->nationality
                ];
            }

            $infantsInfo = [];
            foreach ($infants as $key => $inf) {
                $infantsInfo[] = [
                    "title" => $adt->pax_title == 'Mr.' ? 'Mstr.' : $adt->pax_title,
                    "first_name" => $inf->pax_first_name,
                    "last_name" => $inf->pax_last_name,
                    "dob" => date('Y/m/d', strtotime($inf->dob)),
                    "travel_with" => $key + 1
                ];
            }

            $data = [
                "ticket_id" => $flightDetails->ticketid,
                "total_pax" => $adults->count() + $childs->count() + $infants->count(),
                "adult" => $adults->count(),
                "child" => $childs->count(),
                "infant" => $infants->count(),
                "adult_info" => $adultInfo,
                "child_info" => $childInfo,
                "infant_info" => $infantsInfo
            ];

            $response = Http::withHeaders([
                'api-key' => self::$api_key,
                'Authorization' => session('airiq_token'),
            ])->post(self::$url . "/book", $data);

            if ($response->successful()) {
                $data = $response->json();
                if ($data['code'] == 200) {
                    $booking->update([
                        'airiq_booking_details' => json_encode(["booking_id" => $data['booking_id'], "airline_code" => $data['airline_code']]),
                        'api_provider' => session('apiprovider')
                    ]);
                }
                return true;
            } else {
                return false;
            }
        } catch (Exception $error) {
            return false;
        }
    }

    public static function getTicketDetails($booking)
    {
        try {
            $bookingDetails = json_decode($booking->airiq_booking_details ?? '');
            $bookingID = $bookingDetails->booking_id;

            $response = Http::withHeaders([
                'api-key' => self::$api_key,
                'Authorization' => session('airiq_token'),
            ])->get(self::$url . "/ticket?booking_id=" . $bookingID);
            if ($response->successful()) {
                $data = $response->json();
                if ($data['code'] == 200) {
                    $result = $data['data'];
                    // if ($booking->currency === 'NPR') {
                    $result['total_amount'] = $result['total_amount'] * 1.6;
                    // }

                    $booking->update([
                        'pnr_id' => $data['data']['pnr'] ?? null,
                        'ticket_status' => 1,
                        'ticket_details' => json_encode($result),
                        'for_payment' => 1
                    ]);

                    $tickets = FlightBookingDetail::where(['flight_booking_id' => $booking->id])->get();

                    foreach ($tickets as $c => $ticket) {
                        $ticketData = new FlightTicket();
                        $ticketData->flight_booking_id = $booking->id;
                        $ticketData->first_name = $ticket->pax_first_name;
                        $ticketData->last_name = $ticket->pax_last_name;
                        $ticketData->ticket_number = $data['data']['booking_id'] ?? null;
                        $ticketData->rph = $c + 2;
                        $ticketData->status = true;
                        $ticketData->saveOrFail();
                    }
                }
                return true;
            } else {
                return false;
            }
        } catch (Exception $error) {
            return false;
        }
    }
}
