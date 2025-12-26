<?php

namespace App\Service\AirIq;

use App\Models\InternationalFlight\FlightBookingDetail;
use App\Models\InternationalFlight\SearchFlight;
use DateTime;
use Exception;
use Illuminate\Support\Facades\File;

class AirIqHelper
{
    public static function getAvailabilityRequest($search, $agent)
    {
        $sector = [
            [
                "DepartureStation" => $search->departure,
                "ArrivalStation" => $search->destination,
                "FlightDate" => date('Ymd', strtotime($search->flight_date)), // eg. 20230319
                "FarecabinOption" => "E",
                "FareType" => "",
                "OnlyDirectFlight" => false
            ]
        ];

        if ($search->return_date) {
            array_push($sector, [
                "DepartureStation" => $search->destination,
                "ArrivalStation" => $search->departure,
                "FlightDate" => date('Ymd', strtotime($search->return_date)), // eg. 20230319
                "FarecabinOption" => "E",
                "FareType" => "",
                "OnlyDirectFlight" => false
            ]);
        }

        $data = [
            "TripType" => $search->return_date ? 'R' : 'O',
            // "TripType" => "Y",
            "AirlineID" => "",
            "AgentInfo" => [
                "AgentId" => $agent['agentId'],
                "UserName" => $agent['username'],
                "AppType" => "API",
                "Version" => "V1.0"
            ],
            "AvailInfo" => $sector,
            "PassengersInfo" => [
                "AdultCount" => $search->adults ?? 1,
                "ChildCount" => $search->childs ?? 0,
                "InfantCount" => $search->infants ?? 0
            ]
        ];
        // $jsonData = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        // file_put_contents(public_path('airiq/availabilityreq.json'), $jsonData);
        return $data;
    }

    public static function flights()
    {
        // $path = __DIR__ . '/flights.json';
        $path = __DIR__ . '/pricing.json';
        $json = File::get($path);
        $data = json_decode($json, true);

        return $data;
        // $items = $data['ItineraryFlightList'][0]['Items'];
        // dd($data['ItineraryFlightList']);
        // return self::transformFlightItems($data);
    }

    // public static function transformFlightItems($data, $search)
    // {
    //     $currencyRate = 1.6;
    //     $currency = 'NPR';
    //     $dollarRate = getCurrencyRate();
    //     if (!($search->nationality == 'NP' || $search->nationality == 'IN')) {
    //         $currencyRate = $currencyRate / $dollarRate;
    //         $currency = 'USD';
    //     }

    //     $trackId = $data['Trackid'] ?? null;
    //     $type = 'International';
    //     $items = $data['ItineraryFlightList'][0]['Items'] ?? [];
    //     if (count($data['ItineraryFlightList'] ?? []) === 2) {
    //         $type = 'DomesticRoundTrip';
    //         $items = self::mergeRoundTripFlights($data['ItineraryFlightList']);
    //     }

    //     $results = [];

    //     $classMap = [
    //         "E" => "Economy",
    //         "P" => "Premium Economy",
    //         "B" => "Bussiness class",
    //         "F" => "First class"
    //     ];

    //     foreach ($items as $item) {
    //         $flightDetails = $item['FlightDetails'] ?? [];
    //         $fareData = $item['Fares'][0] ?? [];

    //         $groupedSectors = collect($flightDetails)->groupBy('ItinRef')->toArray();

    //         $flights = [];
    //         foreach ($groupedSectors as $itinRef => $sectors) {
    //             $segments = [];
    //             foreach ($sectors as $seg) {
    //                 $departTime = new DateTime($seg['DepartureDateTime']);
    //                 $arriveTime = new DateTime($seg['ArrivalDateTime']);
    //                 $interval = $departTime->diff($arriveTime);
    //                 $hours = $interval->days * 24 + $interval->h;
    //                 $mins = $interval->i;
    //                 $elapsedFormatted = "{$hours} Hr {$mins} mins";

    //                 $segments[] = [
    //                     "departdate" => date('Y-m-d', strtotime($seg['DepartureDateTime'])),
    //                     "arrivaldate" => date('Y-m-d', strtotime($seg['ArrivalDateTime'])),
    //                     "departtime" => date('H:i', strtotime($seg['DepartureDateTime'])),
    //                     "arrivaltime" => date('H:i', strtotime($seg['ArrivalDateTime'])),
    //                     "departure" => $seg['Origin'],
    //                     "depterminal" => $seg['DepartureTerminal'] ?? '',
    //                     "arrivalterminal" => $seg['ArrivalTerminal'] ?? '',
    //                     "arrival" => $seg['Destination'],
    //                     "departport" => $seg['Origin'],
    //                     "arrivalport" => $seg['Destination'],
    //                     "flightnumber" => $seg['FlightNumber'],
    //                     "flightid" => $seg['FlightID'],
    //                     "stops" => $seg['Stops'],
    //                     "class" => $classMap[$seg['Class']] ?? $seg['Class'],
    //                     "resbook" => $seg['FareBasisCode'],
    //                     "flighttime" => $seg['FlyingTime'],
    //                     "elapstime" => $elapsedFormatted,
    //                     "operatingairline" => $seg['OperatingCarrier'],
    //                     "marketingairline" => $seg['PlatingCarrier'],
    //                     "valadatingairline" => $seg['PlatingCarrier'],
    //                 ];
    //             }

    //             $flights[] = [
    //                 "sectors" => $segments,
    //                 "time" => $segments[0]['departdate'] . ' to ' . end($segments)['arrivaldate'],
    //             ];
    //         }

    //         // ---------- Pricing Calculation with Quantities ----------
    //         $totalBaseFare = 0;
    //         $originalBaseFare = 0;
    //         $totalTax = 0;
    //         $totalGross = 0;
    //         $originalGross = 0;
    //         $discount = 0;

    //         $breakdown = [];
    //         $farepenalty = [];
    //         $baggageMap = [];

    //         foreach ($fareData['Faredescription'] ?? [] as $fare) {
    //             $paxType = $fare['Paxtype'];
    //             $multiplier = 1;

    //             if ($paxType === 'ADT') {
    //                 $multiplier = $search->adults ?? 1;
    //             } elseif ($paxType === 'CHD') {
    //                 $multiplier = $search->childs ?? 1;
    //             } elseif ($paxType === 'INF') {
    //                 $multiplier = $search->infants ?? 1;
    //             }

    //             $bAmt = (float) ($fare['BaseAmount'] ?? 0) * $multiplier * $currencyRate;
    //             $tAmt = (float) ($fare['TotalTaxAmount'] ?? 0) * $multiplier * $currencyRate;
    //             $gAmt = (float) ($fare['GrossAmount'] ?? 0) * $multiplier * $currencyRate;

    //             $originalBaseFare += (float) ($fare['BaseAmount'] ?? 0);
    //             $originalGross += (float) ($fare['GrossAmount'] ?? 0);

    //             $totalBaseFare += $bAmt;
    //             $totalTax += $tAmt;
    //             $totalGross += $gAmt;

    //             // Farecodes
    //             $farecodes = [];
    //             foreach ($flightDetails as $seg) {
    //                 $farecodes[] = [
    //                     'start' => $seg['Origin'] ?? null,
    //                     'end' => $seg['Destination'] ?? null,
    //                     'air' => $seg['OperatingCarrier'] ?? null,
    //                     'code' => $seg['FareBasisCode'] ?? null,
    //                 ];
    //             }

    //             // Tax breakdown
    //             $taxBreakdown = [];
    //             if (!empty($fare['Taxes']) && is_array($fare['Taxes'])) {
    //                 foreach ($fare['Taxes'] as $taxItem) {
    //                     $taxBreakdown[] = [
    //                         'code' => $taxItem['Code'] ?? $taxItem['TaxCode'] ?? null,
    //                         'amount' => (float) ($taxItem['Amount'] ?? 0) * $multiplier * $currencyRate,
    //                     ];
    //                 }
    //             }

    //             $markup = 0;
    //             $mtotal = $gAmt + $markup;

    //             $breakdown[] = [
    //                 'type' => $fare['Paxtype'] ?? null,
    //                 'qty' => $multiplier,
    //                 'basefare' => "$currency $bAmt",
    //                 'tax' => "$currency $tAmt",
    //                 'total' => "$currency $gAmt",
    //                 'refund' => $flightDetails[0]['Refundable'] ?? 'false',
    //                 'farecodes' => $farecodes,
    //                 'taxbreakdown' => $taxBreakdown,
    //                 'mbasefare' => $currency . ' ' . ($bAmt + $markup),
    //                 'markup' => $markup,
    //                 'mtotal' => "$currency $mtotal",
    //             ];

    //             // Penalties
    //             foreach (['Refund', 'Exchange'] as $ptype) {
    //                 foreach (['Before', 'After'] as $when) {
    //                     $penaltyAmount = $fare[$ptype . $when . 'Amount'] ?? null;
    //                     $status = $fare[$ptype . $when . 'Status'] ?? null;

    //                     if ($status !== null && $penaltyAmount !== null) {
    //                         $farepenalty[] = [
    //                             'paxtype' => $fare['Paxtype'],
    //                             'penaltytype' => $ptype,
    //                             'applicable' => $when,
    //                             'status' => $status,
    //                             'amount' => $currency . ' ' . (float) $penaltyAmount,
    //                         ];
    //                     }
    //                 }
    //             }

    //             // Baggage
    //             $description = $fare['BaggageInfo'] ?? ($fare['Baggage'] ?? ($flightDetails[0]['Baggage'] ?? 'N/A'));
    //             if (!isset($baggageMap[$fare['Paxtype']])) {
    //                 $detail = [];
    //                 foreach ($flightDetails as $seg) {
    //                     $detail[] = [
    //                         'available' => $seg['AvailableSeats'] ?? null,
    //                         'cabin' => $seg['CabinClass'] ?? null,
    //                         'meal' => $seg['Meal'] ?? false,
    //                     ];
    //                 }
    //                 $baggageMap[$fare['Paxtype']] = [
    //                     'pax' => $fare['Paxtype'],
    //                     'type' => 'Pieces',
    //                     'unit' => '1',
    //                     'description' => $description,
    //                     'detail' => $detail,
    //                 ];
    //             }
    //         }

    //         $markedFare = $totalGross + $discount;

    //         $pricing = [
    //             'basefare' => "$currency $totalBaseFare",
    //             'tax' => "$currency $totalTax",
    //             'total' => "$currency $totalGross",
    //             'markedfare' => "$currency $markedFare",
    //             'markedfarewithoutdiscount' => "$currency $markedFare",
    //             'mbasefare' => "$currency $totalBaseFare",
    //             'discount' => "$currency $discount",
    //             'discountAmount' => $discount,
    //         ];

    //         // Flight details summary
    //         $detailMain = [];
    //         $itinGroups = collect($groupedSectors)->sortKeys()->toArray();
    //         foreach ($itinGroups as $itinRef => $sectors) {
    //             if (count($sectors) > 0) {
    //                 $firstSeg = $sectors[0];
    //                 $lastSeg = end($sectors);

    //                 $departTime = new DateTime($firstSeg['DepartureDateTime']);
    //                 $arriveTime = new DateTime($lastSeg['ArrivalDateTime']);
    //                 $interval = $departTime->diff($arriveTime);
    //                 $hours = $interval->days * 24 + $interval->h;
    //                 $mins = $interval->i;
    //                 $totalTimeFormatted = "{$hours} Hr {$mins} mins";

    //                 $description = $fareData['Faredescription'][0]['BaggageInfo']
    //                     ?? ($fareData['Faredescription'][0]['Baggage'] ?? ($flightDetails[0]['Baggage'] ?? 'N/A'));

    //                 $detailMain[] = [
    //                     "seat" => $firstSeg['AvailableSeats'] ?? null,
    //                     "bag" => $description,
    //                     "origin" => $firstSeg['Origin'] ?? null,
    //                     "orgport" => null,
    //                     "orgterminal" => $firstSeg['DepartureTerminal'] ?? '0',
    //                     "destination" => $lastSeg['Destination'] ?? null,
    //                     "destport" => null,
    //                     "desterminal" => $lastSeg['ArrivalTerminal'] ?? '0',
    //                     "stops" => count($sectors) - 1,
    //                     "origintime" => date('H:i:s', strtotime($firstSeg['DepartureDateTime'])),
    //                     "origindate" => date('Y-m-d', strtotime($firstSeg['DepartureDateTime'])),
    //                     "destinationdate" => date('Y-m-d', strtotime($lastSeg['ArrivalDateTime'])),
    //                     "destinationtime" => date('H:i:s', strtotime($lastSeg['ArrivalDateTime'])),
    //                     "airline" => $firstSeg['OperatingCarrier'] ?? null,
    //                     "totaltime" => $totalTimeFormatted,
    //                     "refundable" => $firstSeg['Refundable'] ?? 'false',
    //                 ];
    //             }
    //         }

    //         $summary = [
    //             "TotalBaseAmount" => (int) $originalBaseFare,
    //             "TotalGrossAmount" => (int) $originalGross
    //         ];

    //         $flightItem = ['intl' => $item];
    //         if ($type == 'DomesticRoundTrip') {
    //             $summary = $item['Summary'] ?? [];
    //             $flightItem = ['Departure' => $item['Dep'], 'Arrival' => $item['Arr']];
    //         }

    //         $results[] = [
    //             "trackid" => $trackId,
    //             'apiprovider' => 'airiq',
    //             'type' => $type,
    //             "flight" => $flights,
    //             "pricing" => $pricing,
    //             "breakdown" => $breakdown,
    //             "farepenalty" => $farepenalty,
    //             "baggage" => array_values($baggageMap),
    //             "airline" => $flightDetails[0]['PlatingCarrier'] ?? '',
    //             "rph" => $fareData['FlightId'] ?? '',
    //             "detail" => $detailMain,
    //             "airiqpricing" => $summary,
    //             "airiqflights" => $flightItem
    //         ];
    //     }

    //     return $results;
    // }

    public static function transformFlightItems($data, $search)
    {
        $currencyRate = 1.6;
        $currency = 'NPR';
        $dollarRate = getCurrencyRate();
        if (!($search->nationality == 'NP' || $search->nationality == 'IN')) {
            $currencyRate = $currencyRate / $dollarRate;
            $currency = 'USD';
        }

        $trackId = $data['Trackid'] ?? null;
        $type = 'International';
        $items = $data['ItineraryFlightList'][0]['Items'] ?? [];
        if (count($data['ItineraryFlightList'] ?? []) === 2) {
            $type = 'DomesticRoundTrip';
            $items = self::mergeRoundTripFlights($data['ItineraryFlightList']);
        }

        // We'll collect only the cheapest per (depart, arrive, airline) key
        $bestByKey = [];

        $classMap = [
            "E" => "Economy",
            "P" => "Premium Economy",
            "B" => "Bussiness class",
            "F" => "First class"
        ];

        foreach ($items as $item) {
            $flightDetails = $item['FlightDetails'] ?? [];
            $fareData = $item['Fares'][0] ?? [];

            // -------- Build flights/sectors --------
            $groupedSectors = collect($flightDetails)->groupBy('ItinRef')->toArray();

            $flights = [];
            foreach ($groupedSectors as $itinRef => $sectors) {
                $segments = [];
                foreach ($sectors as $seg) {
                    $departTime = new DateTime($seg['DepartureDateTime']);
                    $arriveTime = new DateTime($seg['ArrivalDateTime']);
                    $interval = $departTime->diff($arriveTime);
                    $hours = $interval->days * 24 + $interval->h;
                    $mins = $interval->i;
                    $elapsedFormatted = "{$hours} Hr {$mins} mins";

                    $segments[] = [
                        "departdate" => date('Y-m-d', strtotime($seg['DepartureDateTime'])),
                        "arrivaldate" => date('Y-m-d', strtotime($seg['ArrivalDateTime'])),
                        "departtime" => date('H:i', strtotime($seg['DepartureDateTime'])),
                        "arrivaltime" => date('H:i', strtotime($seg['ArrivalDateTime'])),
                        "departure" => $seg['Origin'],
                        "depterminal" => $seg['DepartureTerminal'] ?? '',
                        "arrivalterminal" => $seg['ArrivalTerminal'] ?? '',
                        "arrival" => $seg['Destination'],
                        "departport" => $seg['Origin'],
                        "arrivalport" => $seg['Destination'],
                        "flightnumber" => $seg['FlightNumber'],
                        "flightid" => $seg['FlightID'],
                        "stops" => $seg['Stops'],
                        "class" => $classMap[$seg['Class']] ?? $seg['Class'],
                        "resbook" => $seg['FareBasisCode'],
                        "flighttime" => $seg['FlyingTime'],
                        "elapstime" => $elapsedFormatted,
                        "operatingairline" => $seg['OperatingCarrier'],
                        "marketingairline" => $seg['PlatingCarrier'],
                        "valadatingairline" => $seg['PlatingCarrier'],
                    ];
                }

                $flights[] = [
                    "sectors" => $segments,
                    "time" => $segments[0]['departdate'] . ' to ' . end($segments)['arrivaldate'],
                ];
            }

            // ---------- Pricing Calculation with Quantities ----------
            $totalBaseFare = 0;
            $originalBaseFare = 0;
            $totalTax = 0;
            $totalGross = 0;
            $originalGross = 0;
            $discount = 0;

            $breakdown = [];
            $farepenalty = [];
            $baggageMap = [];

            foreach ($fareData['Faredescription'] ?? [] as $fare) {
                $paxType = $fare['Paxtype'];
                $multiplier = 1;

                if ($paxType === 'ADT') {
                    $multiplier = $search->adults ?? 1;
                } elseif ($paxType === 'CHD') {
                    $multiplier = $search->childs ?? 1;
                } elseif ($paxType === 'INF') {
                    $multiplier = $search->infants ?? 1;
                }

                $bAmt = (float) ($fare['BaseAmount'] ?? 0) * $multiplier * $currencyRate;
                $tAmt = (float) ($fare['TotalTaxAmount'] ?? 0) * $multiplier * $currencyRate;
                $gAmt = (float) ($fare['GrossAmount'] ?? 0) * $multiplier * $currencyRate;

                $originalBaseFare += (float) ($fare['BaseAmount'] ?? 0);
                $originalGross += (float) ($fare['GrossAmount'] ?? 0);

                $totalBaseFare += $bAmt;
                $totalTax += $tAmt;
                $totalGross += $gAmt;

                // Farecodes
                $farecodes = [];
                foreach ($flightDetails as $seg) {
                    $farecodes[] = [
                        'start' => $seg['Origin'] ?? null,
                        'end' => $seg['Destination'] ?? null,
                        'air' => $seg['OperatingCarrier'] ?? null,
                        'code' => $seg['FareBasisCode'] ?? null,
                    ];
                }

                // Tax breakdown
                $taxBreakdown = [];
                if (!empty($fare['Taxes']) && is_array($fare['Taxes'])) {
                    foreach ($fare['Taxes'] as $taxItem) {
                        $taxBreakdown[] = [
                            'code' => $taxItem['Code'] ?? $taxItem['TaxCode'] ?? null,
                            'amount' => (float) ($taxItem['Amount'] ?? 0) * $multiplier * $currencyRate,
                        ];
                    }
                }

                $markup = 0;
                $mtotal = $gAmt + $markup;

                $breakdown[] = [
                    'type' => $fare['Paxtype'] ?? null,
                    'qty' => $multiplier,
                    'basefare' => "$currency $bAmt",
                    'tax' => "$currency $tAmt",
                    'total' => "$currency $gAmt",
                    'refund' => $flightDetails[0]['Refundable'] ?? 'false',
                    'farecodes' => $farecodes,
                    'taxbreakdown' => $taxBreakdown,
                    'mbasefare' => $currency . ' ' . ($bAmt + $markup),
                    'markup' => $markup,
                    'mtotal' => "$currency $mtotal",
                ];

                // Penalties
                foreach (['Refund', 'Exchange'] as $ptype) {
                    foreach (['Before', 'After'] as $when) {
                        $penaltyAmount = $fare[$ptype . $when . 'Amount'] ?? null;
                        $status = $fare[$ptype . $when . 'Status'] ?? null;

                        if ($status !== null && $penaltyAmount !== null) {
                            $farepenalty[] = [
                                'paxtype' => $fare['Paxtype'],
                                'penaltytype' => $ptype,
                                'applicable' => $when,
                                'status' => $status,
                                'amount' => $currency . ' ' . (float) $penaltyAmount,
                            ];
                        }
                    }
                }

                // Baggage
                $description = $fare['BaggageInfo'] ?? ($fare['Baggage'] ?? ($flightDetails[0]['Baggage'] ?? 'N/A'));
                if (!isset($baggageMap[$fare['Paxtype']])) {
                    $detail = [];
                    foreach ($flightDetails as $seg) {
                        $detail[] = [
                            'available' => $seg['AvailableSeats'] ?? null,
                            'cabin' => $seg['CabinClass'] ?? null,
                            'meal' => $seg['Meal'] ?? false,
                        ];
                    }
                    $baggageMap[$fare['Paxtype']] = [
                        'pax' => $fare['Paxtype'],
                        'type' => 'Pieces',
                        'unit' => '1',
                        'description' => $description,
                        'detail' => $detail,
                    ];
                }
            }

            $markedFare = $totalGross + $discount;

            $pricing = [
                'basefare' => "$currency $totalBaseFare",
                'tax' => "$currency $totalTax",
                'total' => "$currency $totalGross",
                'markedfare' => "$currency $markedFare",
                'markedfarewithoutdiscount' => "$currency $markedFare",
                'mbasefare' => "$currency $totalBaseFare",
                'discount' => "$currency $discount",
                'discountAmount' => $discount,
            ];

            // -------- Flight details summary --------
            $detailMain = [];
            $itinGroups = collect($groupedSectors)->sortKeys()->toArray();
            foreach ($itinGroups as $itinRef => $sectors) {
                if (count($sectors) > 0) {
                    $firstSeg = $sectors[0];
                    $lastSeg = end($sectors);

                    $departTime = new DateTime($firstSeg['DepartureDateTime']);
                    $arriveTime = new DateTime($lastSeg['ArrivalDateTime']);
                    $interval = $departTime->diff($arriveTime);
                    $hours = $interval->days * 24 + $interval->h;
                    $mins = $interval->i;
                    $totalTimeFormatted = "{$hours} Hr {$mins} mins";

                    $description = $fareData['Faredescription'][0]['BaggageInfo']
                        ?? ($fareData['Faredescription'][0]['Baggage'] ?? ($flightDetails[0]['Baggage'] ?? 'N/A'));

                    $detailMain[] = [
                        "seat" => $firstSeg['AvailableSeats'] ?? null,
                        "bag" => $description,
                        "origin" => $firstSeg['Origin'] ?? null,
                        "orgport" => null,
                        "orgterminal" => $firstSeg['DepartureTerminal'] ?? '0',
                        "destination" => $lastSeg['Destination'] ?? null,
                        "destport" => null,
                        "desterminal" => $lastSeg['ArrivalTerminal'] ?? '0',
                        "stops" => count($sectors) - 1,
                        "origintime" => date('H:i:s', strtotime($firstSeg['DepartureDateTime'])),
                        "origindate" => date('Y-m-d', strtotime($firstSeg['DepartureDateTime'])),
                        "destinationdate" => date('Y-m-d', strtotime($lastSeg['ArrivalDateTime'])),
                        "destinationtime" => date('H:i:s', strtotime($lastSeg['ArrivalDateTime'])),
                        "airline" => $firstSeg['OperatingCarrier'] ?? null,
                        "totaltime" => $totalTimeFormatted,
                        "refundable" => $firstSeg['Refundable'] ?? 'false',
                    ];
                }
            }

            $summary = [
                "TotalBaseAmount" => (int) $originalBaseFare,
                "TotalGrossAmount" => (int) $originalGross
            ];

            $flightItem = ['intl' => $item];
            if ($type == 'DomesticRoundTrip') {
                $summary = $item['Summary'] ?? [];
                $flightItem = ['Departure' => $item['Dep'], 'Arrival' => $item['Arr']];
            }

            // ---------- Build final entry ----------
            $entry = [
                "trackid" => $trackId,
                'apiprovider' => 'airiq',
                'type' => $type,
                "flight" => $flights,
                "pricing" => $pricing,
                "breakdown" => $breakdown,
                "farepenalty" => $farepenalty,
                "baggage" => array_values($baggageMap),
                "airline" => $flightDetails[0]['PlatingCarrier'] ?? '',
                "rph" => $fareData['FlightId'] ?? '',
                "detail" => $detailMain,
                "airiqpricing" => $summary,
                "airiqflights" => $flightItem
            ];

            // ---------- UNIQUE FILTER (by depart, arrive, airline; keep cheapest total) ----------
            // Find earliest depart and latest arrival across ALL segments in this item
            $depMinTs = null;
            $arrMaxTs = null;
            $airlineKey = null;

            foreach ($flightDetails as $seg) {
                $dTs = strtotime($seg['DepartureDateTime'] ?? '');
                if ($dTs) {
                    $depMinTs = is_null($depMinTs) ? $dTs : min($depMinTs, $dTs);
                }
                $aTs = strtotime($seg['ArrivalDateTime'] ?? '');
                if ($aTs) {
                    $arrMaxTs = is_null($arrMaxTs) ? $aTs : max($arrMaxTs, $aTs);
                }
                if ($airlineKey === null) {
                    $airlineKey = $seg['OperatingCarrier'] ?? ($seg['PlatingCarrier'] ?? null);
                }
            }

            // Build a stable key only if all parts present; otherwise fall back to flight numbers
            if ($depMinTs !== null && $arrMaxTs !== null && $airlineKey !== null) {
                $uniqueKey = date('Y-m-d H:i', $depMinTs) . '|' . date('Y-m-d H:i', $arrMaxTs) . '|' . $airlineKey;
            } else {
                $fnJoin = implode('-', array_map(function ($s) {
                    return $s['FlightNumber'] ?? ''; }, $flightDetails));
                $uniqueKey = 'FALLBACK|' . $fnJoin . '|' . ($airlineKey ?? '');
            }

            // Compare by numeric total gross (already currency-adjusted)
            $priceNumber = (float) $totalGross;

            if (!isset($bestByKey[$uniqueKey]) || $priceNumber < $bestByKey[$uniqueKey]['price']) {
                $bestByKey[$uniqueKey] = [
                    'price' => $priceNumber,
                    'entry' => $entry,
                ];
            }
        }

        // Return only the cheapest per unique key, preserving your output format
        $results = array_values(array_map(function ($v) {
            return $v['entry'];
        }, $bestByKey));

        return $results;
    }


    public static function mergeRoundTripFlights(array $rawFlights)
    {
        $departures = $rawFlights[0]['Items'] ?? [];
        $returns = $rawFlights[1]['Items'] ?? [];

        $totalPairs = min(count($departures), count($returns));

        $merged = [];

        for ($i = 0; $i < $totalPairs; $i++) {
            $departure = $departures[$i];
            $return = $returns[$i];

            $flightDetails = array_merge(
                $departure['FlightDetails'] ?? [],
                $return['FlightDetails'] ?? []
            );

            // Group and sum fares per Paxtype
            $fareDescriptions = [];
            $allFares = array_merge($departure['Fares'] ?? [], $return['Fares'] ?? []);

            foreach ($allFares as $fare) {
                foreach ($fare['Faredescription'] ?? [] as $desc) {
                    // dd($desc);
                    $pax = $desc['Paxtype'];
                    if (!isset($fareDescriptions[$pax])) {
                        $fareDescriptions[$pax] = $desc;
                    } else {
                        $fareDescriptions[$pax]['BaseAmount'] += $desc['BaseAmount'];
                        $fareDescriptions[$pax]['TotalTaxAmount'] += $desc['TotalTaxAmount'];
                        $fareDescriptions[$pax]['GrossAmount'] += $desc['GrossAmount'];
                        $fareDescriptions[$pax]['NetAmount'] += $desc['NetAmount'];
                        // $fareDescriptions[$pax]['Commission'] += $desc['Commission'] ?? 0;
                        $fareDescriptions[$pax]['Incentive'] += $desc['Incentive'];
                        $fareDescriptions[$pax]['Servicecharge'] += $desc['Servicecharge'];
                        $fareDescriptions[$pax]['TDS'] += $desc['TDS'];
                        $fareDescriptions[$pax]['Discount'] += $desc['Discount'];
                        $fareDescriptions[$pax]['PLBAmount'] += $desc['PLBAmount'];
                        $fareDescriptions[$pax]['SF'] += $desc['SF'];
                        $fareDescriptions[$pax]['SFGST'] += $desc['SFGST'];
                    }
                }
            }

            // Normalize numeric values
            foreach ($fareDescriptions as &$desc) {
                foreach ($desc as $key => $value) {
                    if (is_numeric($value)) {
                        $desc[$key] = (float) $value;
                    }
                }
            }

            // Calculate Base and Gross totals for Departure
            $totalDepartureBaseAmount = 0.0;
            $totalDepartureGrossAmount = 0.0;
            foreach ($departure['Fares'] ?? [] as $fare) {
                foreach ($fare['Faredescription'] ?? [] as $desc) {
                    $totalDepartureBaseAmount += (float) $desc['BaseAmount'];
                    $totalDepartureGrossAmount += (float) $desc['GrossAmount'];
                }
            }

            // Calculate Base and Gross totals for Return
            $totalReturnBaseAmount = 0.0;
            $totalReturnGrossAmount = 0.0;
            foreach ($return['Fares'] ?? [] as $fare) {
                foreach ($fare['Faredescription'] ?? [] as $desc) {
                    $totalReturnBaseAmount += (float) $desc['BaseAmount'];
                    $totalReturnGrossAmount += (float) $desc['GrossAmount'];
                }
            }

            // Final merged structure
            $merged[] = [
                'FlightDetails' => $flightDetails,
                'Fares' => [
                    [
                        'Currency' => $allFares[0]['Currency'] ?? 'INR',
                        'FareType' => $allFares[0]['FareType'] ?? '',
                        'FlightId' => $allFares[0]['FlightId'] ?? '',
                        'Faredescription' => array_values($fareDescriptions),
                    ]
                ],
                'Summary' => [
                    'TotalDepartureBaseAmount' => (int) $totalDepartureBaseAmount,
                    'TotalDepartureGrossAmount' => (int) $totalDepartureGrossAmount,
                    'TotalReturnBaseAmount' => (int) $totalReturnBaseAmount,
                    'TotalReturnGrossAmount' => (int) $totalReturnGrossAmount,
                ],
                'Dep' => $departure,
                'Arr' => $return
            ];
        }

        return $merged;
    }


    // public static function mergeRoundTripFlights(array $rawFlights)
    // {
    //     $departures = $rawFlights[0]['Items'] ?? [];
    //     $returns = $rawFlights[1]['Items'] ?? [];

    //     $totalPairs = min(count($departures), count($returns));

    //     $merged = [];

    //     for ($i = 0; $i < $totalPairs; $i++) {
    //         $departure = $departures[$i];
    //         $return = $returns[$i];

    //         $flightDetails = array_merge(
    //             $departure['FlightDetails'] ?? [],
    //             $return['FlightDetails'] ?? []
    //         );

    //         // Group and sum fares per Paxtype
    //         $fareDescriptions = [];

    //         $allFares = array_merge($departure['Fares'] ?? [], $return['Fares'] ?? []);

    //         foreach ($allFares as $fare) {
    //             foreach ($fare['Faredescription'] ?? [] as $desc) {
    //                 $pax = $desc['Paxtype'];
    //                 if (!isset($fareDescriptions[$pax])) {
    //                     $fareDescriptions[$pax] = $desc;
    //                 } else {
    //                     $fareDescriptions[$pax]['BaseAmount'] += $desc['BaseAmount'];
    //                     $fareDescriptions[$pax]['TotalTaxAmount'] += $desc['TotalTaxAmount'];
    //                     $fareDescriptions[$pax]['GrossAmount'] += $desc['GrossAmount'];
    //                     $fareDescriptions[$pax]['Commission'] += $desc['Commission'];
    //                     $fareDescriptions[$pax]['Incentive'] += $desc['Incentive'];
    //                     $fareDescriptions[$pax]['Servicecharge'] += $desc['Servicecharge'];
    //                     $fareDescriptions[$pax]['TDS'] += $desc['TDS'];
    //                     $fareDescriptions[$pax]['Discount'] += $desc['Discount'];
    //                     $fareDescriptions[$pax]['PLBAmount'] += $desc['PLBAmount'];
    //                     $fareDescriptions[$pax]['SF'] += $desc['SF'];
    //                     $fareDescriptions[$pax]['SFGST'] += $desc['SFGST'];
    //                 }
    //             }
    //         }

    //         // Normalize numeric values (optional if all are already numbers)
    //         foreach ($fareDescriptions as &$desc) {
    //             foreach ($desc as $key => $value) {
    //                 if (is_numeric($value)) {
    //                     $desc[$key] = (float) $value;
    //                 }
    //             }
    //         }

    //         // Final merged fare structure
    //         $merged[] = [
    //             'FlightDetails' => $flightDetails,
    //             'Fares' => [
    //                 [
    //                     'Currency' => $allFares[0]['Currency'] ?? 'INR',
    //                     'FareType' => $allFares[0]['FareType'] ?? '',
    //                     'FlightId' => $allFares[0]['FlightId'] ?? '',
    //                     'Faredescription' => array_values($fareDescriptions),
    //                 ]
    //                 ],
    //                 'Summary' => [
    //                     'DepartureFares' => $departure['Fares'] ?? [],
    //                     'ArrivalFares' => $return['Fares'] ?? [],
    //                 ]
    //         ];
    //     }

    //     return $merged;
    // }


    static function formatElapsedTime(int $minutes): string
    {
        $hours = floor($minutes / 60);
        $mins = $minutes % 60;
        return trim(sprintf('%s Hr %s mins', $hours, $mins));
    }

    static function airportName(string $code): string
    {
        $map = [
            'KTM' => 'Tribhuvan',
            'DEL' => 'Indira Gandhi International',
            'DXB' => 'Dubai',
            // Add more airport codes as needed
        ];

        return $map[$code] ?? $code;
    }

    public static function getPricingRequest($flight, $agent)
    {
        $search = SearchFlight::findorfail(session()->get('flight_search'));
        if (!$search) {
            return false;
        }

        $departureFlightDetails = [];
        $arrivalFlightDetails = [];
        foreach ($flight['flight'][0]['sectors'] ?? [] as $sector) {
            $departureFlightDetails[] = [
                "FlightID" => $sector['flightid'],
                "FlightNumber" => $sector['flightnumber'],
                "Origin" => $sector['departure'],
                "Destination" => $sector['arrival'],
                "DepartureDateTime" => date('d M Y', strtotime($sector['departdate'])) . ' ' . $sector['departtime'],  // 16 Mar 2023 23:30
                "ArrivalDateTime" => date('d M Y', strtotime($sector['arrivaldate'])) . ' ' . $sector['arrivaltime']    // 16 Mar 2023 23:30
            ];
        }
        foreach ($flight['flight'][1]['sectors'] ?? [] as $sector) {
            $arrivalFlightDetails[] = [
                "FlightID" => $sector['flightid'],
                "FlightNumber" => $sector['flightnumber'],
                "Origin" => $sector['departure'],
                "Destination" => $sector['arrival'],
                "DepartureDateTime" => date('d M Y', strtotime($sector['departdate'])) . ' ' . $sector['departtime'],  // 16 Mar 2023 23:30
                "ArrivalDateTime" => date('d M Y', strtotime($sector['arrivaldate'])) . ' ' . $sector['arrivaltime']    // 16 Mar 2023 23:30
            ];
        }

        $itinerary = [];
        if ($flight['type'] == 'DomesticRoundTrip') {
            $itinerary = [
                [
                    "FlightDetails" => $departureFlightDetails,
                    "BaseAmount" => $flight['airiqpricing']['TotalDepartureBaseAmount'],
                    "GrossAmount" => $flight['airiqpricing']['TotalDepartureGrossAmount']
                ],
                [
                    "FlightDetails" => $arrivalFlightDetails,
                    "BaseAmount" => $flight['airiqpricing']['TotalReturnBaseAmount'],
                    "GrossAmount" => $flight['airiqpricing']['TotalReturnGrossAmount']
                ]
            ];
        } else {
            $itinerary = [
                [
                    "FlightDetails" => array_merge($departureFlightDetails, $arrivalFlightDetails),
                    "BaseAmount" => $flight['airiqpricing']['TotalBaseAmount'],
                    "GrossAmount" => $flight['airiqpricing']['TotalGrossAmount']
                ]
            ];
        }

        $request = [
            "AgentInfo" => [
                "AgentId" => $agent['agentId'],
                "UserName" => $agent['username'],
                "AppType" => "API",
                "Version" => "V1.0"
            ],
            "SegmentInfo" => [
                "BaseOrigin" => $search->departure,
                "BaseDestination" => $search->destination,
                // "TripType" => "Y",
                "TripType" => $search->return_date ? "R" : "O",
                "AdultCount" => $search->adults,
                "ChildCount" => $search->childs,
                "InfantCount" => $search->infants
            ],
            "Trackid" => $flight['trackid'],
            "ItineraryInfo" => $itinerary
        ];

        // $jsonData = json_encode($request, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        // file_put_contents(public_path('airiq/pricingreq.json'), $jsonData);

        return $request;
    }

    public static function getBookingRequest($booking, $agent)
    {
        $search = SearchFlight::findorfail(session()->get('flight_search'));
        if (!$search) {
            return false;
        }

        if (!session()->get('airiq_pricing_response')) {
            return false;
        }

        $pricing = json_decode(session()->get('airiq_pricing_response'));

        $itineraryInfo = [];
        $trackId = '';
        foreach ($pricing->PriceItenaryInfo as $k => $itinerary) {
            $availability = $itinerary->AvailabilityResponse[0];
            $trackId = $itinerary->Trackid;
            $amount = 0;
            foreach ($availability->Fares[0]->Faredescription as $amt) {
                $multiplier = 1;

                if ($amt->Paxtype === 'ADT') {
                    $multiplier = $search->adults;
                } elseif ($amt->Paxtype === 'CHD') {
                    $multiplier = $search->childs;
                } elseif ($amt->Paxtype === 'INF') {
                    $multiplier = $search->infants;
                }

                $amount += ($amt->GrossAmount * $multiplier);
            }

            $flightInfo = [];
            foreach ($availability->Flights as $flightDetail) {
                $flightInfo[] = [
                    "FlightID" => $flightDetail->FlightID,
                    "FlightNumber" => $flightDetail->FlightNumber,
                    "Origin" => $flightDetail->Origin,
                    "Destination" => $flightDetail->Destination,
                    "DepartureDateTime" => $flightDetail->DepartureDateTime,
                    "ArrivalDateTime" => $flightDetail->ArrivalDateTime
                ];
            }


            $seat = [
                // [
                //     "SeatID" => "AQ091919467365485120919242618551SIIZUP1OVYJ|7079",
                //     "PaxRefNumber" => "1"
                // ],
                // [
                //     "SeatID" => "AQ091919467365485120919242618551SIIZUP1OVYJ|7305",
                //     "PaxRefNumber" => "1"
                // ],
            ];

            if ($k > 0) {
                $seat = [
                    // [
                    //     "SeatID" => "AQ105510028204683341055161458782UZSYLDQE6AO|6124",
                    //     "PaxRefNumber" => "1"
                    // ],
                    // [
                    //     "SeatID" => "AQ105510028204683341055161458782UZSYLDQE6AO|6307",
                    //     "PaxRefNumber" => "1"
                    // ],
                ];
            }


            $meal = [
                // [
                //     "MealID" => "6494",
                //     "PaxRefNumber" => "1"
                // ],
                // [
                //     "MealID" => "6496",
                //     "PaxRefNumber" => "2"
                // ],
            ];

            if ($k > 0) {
                $meal = [
                    // [
                    //     "MealID" => "6502",
                    //     "PaxRefNumber" => "1"
                    // ],
                    // [
                    //     "MealID" => "6507",
                    //     "PaxRefNumber" => "2"
                    // ],

                ];
            }

            $itineraryInfo[] = [
                "Token" => $availability->Token,
                "FlighstInfo" => $flightInfo,
                "PaymentMode" => "T",
                "SeatsSSRInfo" => $seat,
                "BaggSSRInfo" => [],
                "MealsSSRInfo" => $meal,
                "OtherSSRInfo" => [],
                "PaymentInfo" => [
                    [
                        "TotalAmount" => $amount
                    ]
                ]
            ];
        }

        $contactDetails = json_decode($booking->contact_details);
        $adults = FlightBookingDetail::where(['flight_booking_id' => $booking->id, 'pax_type' => 'ADT'])->get();
        $childs = FlightBookingDetail::where(['flight_booking_id' => $booking->id, 'pax_type' => 'CHLD'])->get();
        $infants = FlightBookingDetail::where(['flight_booking_id' => $booking->id, 'pax_type' => 'INFT'])->get();

        $adultInfo = [];
        $count = 1;
        foreach ($adults as $key => $adt) {
            $count = $count + $key;
            $adultInfo[] = [
                "PaxRefNumber" => $count,
                "Title" => str_replace(".", "", $adt->pax_title),
                "FirstName" => $adt->pax_first_name,
                "LastName" => $adt->pax_last_name,
                "DOB" => date('d/m/Y', strtotime($adt->dob)),
                "Gender" => $adt->pax_gender == 'M' ? "Male" : 'Female',
                "PaxType" => "ADT",
                "PassportNo" => $adt->doc_number,
                "PassportExpiry" => date('d/m/Y', strtotime($adt->doc_expiry_date)),
                "PassportIssuedDate" => "",
                "PassportCountryCode" => $adt->doc_issued_by,
                "InfantRef" => ""
            ];
        }

        $childInfo = [];
        foreach ($childs as $key => $chd) {
            $count = $count + ($key + 1);
            $childInfo[] = [
                "PaxRefNumber" => $count,
                "Title" => $chd->pax_title == 'Mr.' ? 'Mstr' : 'Miss',
                "FirstName" => $chd->pax_first_name,
                "LastName" => $chd->pax_last_name,
                "DOB" => date('d/m/Y', strtotime($chd->dob)),
                "Gender" => $chd->pax_gender == 'M' ? "Male" : 'Female',
                "PaxType" => "CHD",
                "PassportNo" => $chd->doc_number,
                "PassportExpiry" => date('d/m/Y', strtotime($chd->doc_expiry_date)),
                "PassportIssuedDate" => "",
                "PassportCountryCode" => $chd->doc_issued_by,
                "InfantRef" => ""
            ];
        }

        $infantsInfo = [];
        foreach ($infants as $key => $inf) {
            $count = $count + ($key + 1);
            $infantsInfo[] = [
                "PaxRefNumber" => $count,
                "Title" => $inf->pax_title == 'Mr.' ? 'Mstr' : 'Miss',
                "FirstName" => $inf->pax_first_name,
                "LastName" => $inf->pax_last_name,
                "DOB" => date('d/m/Y', strtotime($inf->dob)),
                "Gender" => $inf->pax_gender == 'M' ? "Male" : 'Female',
                "PaxType" => "INF",
                "PassportNo" => $inf->doc_number,
                "PassportExpiry" => date('d/m/Y', strtotime($inf->doc_expiry_date)),
                "PassportIssuedDate" => "",
                "PassportCountryCode" => $inf->doc_issued_by,
                "InfantRef" => $key + 1
            ];
        }

        $PaxDetailsInfo = array_merge($adultInfo, $childInfo, $infantsInfo);

        // $PaxDetailsInfo = [
        //     [
        //         "PaxRefNumber" => "1",
        //         "Title" => "MR",
        //         "FirstName" => "RUDRARAJ",
        //         "LastName" => "RAJBANSHI",
        //         "DOB" => "21/05/1998",
        //         "Gender" => "Male",
        //         "PaxType" => "ADT",
        //         "PassportNo" => "1234567",
        //         "PassportExpiry" => "21/05/2027",
        //         "PassportIssuedDate" => "",
        //         "PassportCountryCode" => "IN",
        //         "InfantRef" => ""
        //     ],
        //     // [
        //     //     "PaxRefNumber" => "2",
        //     //     "Title" => "MR",
        //     //     "FirstName" => "RUDRA",
        //     //     "LastName" => "RAJBANSHI",
        //     //     "DOB" => "21/05/1998",
        //     //     "Gender" => "Male",
        //     //     "PaxType" => "ADT",
        //     //     "PassportNo" => "12345675",
        //     //     "PassportExpiry" => "21/05/2027",
        //     //     "PassportIssuedDate" => "",
        //     //     "PassportCountryCode" => "IN",
        //     //     "InfantRef" => ""
        //     // ],
        //     // [
        //     //     "PaxRefNumber" => "3",
        //     //     "Title" => "MSTR",
        //     //     "FirstName" => "DURGESH",
        //     //     "LastName" => "UPADHYAYA",
        //     //     "DOB" => "21/05/2015",
        //     //     "Gender" => "Male",
        //     //     "PaxType" => "CHD",
        //     //     "PassportNo" => "1234561",
        //     //     "PassportExpiry" => "21/05/2027",
        //     //     "PassportIssuedDate" => "",
        //     //     "PassportCountryCode" => "IN",
        //     //     "InfantRef" => ""
        //     // ],
        //     // [
        //     //     "PaxRefNumber" => "4",
        //     //     "Title" => "MSTR",
        //     //     "FirstName" => "AADESH",
        //     //     "LastName" => "KHANAL",
        //     //     "DOB" => "21/05/2024",
        //     //     "Gender" => "Male",
        //     //     "PaxType" => "INF",
        //     //     "PassportNo" => "123456",
        //     //     "PassportExpiry" => "21/05/2027",
        //     //     "PassportIssuedDate" => "",
        //     //     "PassportCountryCode" => "IN",
        //     //     "InfantRef" => "1"
        //     // ]
        // ];

        $data = [
            "AgentInfo" => [
                "AgentId" => $agent['agentId'],
                "UserName" => $agent['username'],
                "AppType" => "API",
                "Version" => "V1.0"
            ],
            "AdultCount" => $search->adults,
            "ChildCount" => $search->childs,
            "InfantCount" => $search->infants,
            "ItineraryFlightsInfo" => $itineraryInfo,
            "PaxDetailsInfo" => $PaxDetailsInfo,
            "AddressDetails" => [
                "CountryCode" => $contactDetails->phone_code,
                "ContactNumber" => $contactDetails->phone,
                "EmailID" => $contactDetails->email,
            ],
            "GSTInfo" => [
                "GSTNumber" => "",
                "GSTCompanyName" => "",
                "GSTAddress" => "",
                "GSTEmailID" => "",
                "GSTMobileNumber" => ""
            ],
            "TripType" => $search->return_date ? "R" : "O",
            // "TripType" => "Y",
            "BlockPNR" => false,
            "BaseOrigin" => $search->departure,
            "BaseDestination" => $search->destination,
            "TrackId" => $trackId
        ];
        // dd($data);
        // $jsonData = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        // file_put_contents(public_path('airiq/bookingreq.json'), $jsonData);

        return $data;
    }

    public static function ticketDetails($data = null)
    {
        try {
            $ticketData = $data['Bookingresponse']['ItinearyDetails'];

            $mainData = [];
            foreach ($ticketData as $ticket) {
                $flight = $ticket['Item'][0];
                $passengers = [];
                foreach ($flight['TravellerInfo']['Item'] ?? [] as $mainTicket) {
                    $innerData = [];
                    foreach ($mainTicket['SegmentInformation']['Item'] ?? [] as $inner) {
                        $innerData[] = [
                            "AirlinePNR" => $inner['AirlinePNR'],
                            "TicketNumber" => $inner['TicketNo'],
                            "FlightNumber" => $inner['FlightNumber'],
                            "Origin" => $inner['Origin'],
                            "Destination" => $inner['Destination'],
                            "DepartureDateTime" => $inner['DepartureDateTime'],
                            "ArrivalDateTime" => $inner['ArrivalDateTime'],
                            "Class" => $inner['ClassCode']
                        ];
                    }

                    $passengers[] =
                        [
                            "Title" => $mainTicket['Title'],
                            "PaxType" => $mainTicket['PaxType'],
                            "FirstName" => $mainTicket['FirstName'],
                            "LastName" => $mainTicket['LastName'],
                            "DateOfBirth" => $mainTicket['DateOfBirth'],
                            "TicketNumber" => $mainTicket['TicketNumber'],
                            "Details" => $innerData
                        ]
                    ;
                }

                $mainData[] = $data = [
                    "BookingTrackId" => $flight['BookingTrackId'],
                    "AirIqPNR" => $flight['AirIqPNR'],
                    "CRSPNR" => $flight['CRSPNR'],
                    "BaseOrigin" => $flight['BaseOrigin'],
                    "BaseDestination" => $flight['BaseDestination'],
                    "Class" => $flight['Class'],
                    "Passengers" => $passengers
                ];
            }

            return $mainData;
        } catch (Exception $error) {
            return [];
        }
    }

    public static function seatRequest($agent)
    {
        $search = SearchFlight::findorfail(session()->get('flight_search'));
        $pricing = json_decode(session()->get('airiq_pricing_response'));

        $trackId = '';
        $flightInfo = [];

        foreach ($pricing->PriceItenaryInfo as $itinerary) {
            $availability = $itinerary->AvailabilityResponse[0];
            $trackId = $itinerary->Trackid;

            foreach ($availability->Flights as $flightDetail) {
                $flightInfo[] = [
                    "FlightID" => $flightDetail->FlightID,
                    "FlightNumber" => $flightDetail->FlightNumber,
                    "Origin" => $flightDetail->Origin,
                    "Destination" => $flightDetail->Destination,
                    "DepartureDateTime" => $flightDetail->DepartureDateTime,
                    "ArrivalDateTime" => $flightDetail->ArrivalDateTime
                ];
            }
        }

        $data = [
            'AgentInfo' => [
                "AgentId" => $agent['agentId'],
                "UserName" => $agent['username'],
                'AppType' => 'API',
                'Version' => 'V1.0',
            ],
            'SegmentInfo' => [
                "BaseOrigin" => $search->departure,
                "BaseDestination" => $search->destination,
                "TripType" => $search->return_date ? "R" : "O",
                // "TripType" => "Y",
            ],
            'FlightsInfo' => $flightInfo,
            'APIPaxDetails' => [
                [
                    'PaxRefNumber' => '1',
                    'Title' => 'Mr',
                    'PaxType' => 'ADT',
                    'FirstName' => 'RUDRA',
                    'LastName' => 'RAJBANSHI',
                ],
                // [
                //     "PaxRefNumber" => "2",
                //     "Title" => "MSTR",
                //     "PaxType" => "CHD",
                //     "FirstName" => "DURGESH",
                //     "LastName" => "UPADHYAYA"
                // ],
                // [
                //     "PaxRefNumber" => "3",
                //     "Title" => "MSTR",
                //     "PaxType" => "INF",
                //     "FirstName" => "AADESH",
                //     "LastName" => "KHANAL"
                // ]
            ],
            'TrackId' => $trackId,
        ];

        // dd($data);
        // $jsonData = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        // file_put_contents(public_path('airiq/seatreq.json'), $jsonData);

        return $data;
    }
}
