<?php

namespace App\Http\Controllers;

use App\Events\FlightBookedEvent;
use App\Http\Requests\{BookingFormRequest, SearchFlightRequest};
use App\Jobs\FlightBookingCancelRequest;
use App\Models\Finance\ConnectIps;
use App\Models\Finance\Khalti;
use App\Models\Finance\NPSOnePG;
use App\Models\InternationalFlight\{Airline, Airport, FlightBooking, FlightBookingDetail, FlightTicket, SearchFlight};
use App\Service\Sabre\{AgentMarkupService, MarkupService, Request\BargainFinderMaxAdRQ, Request\SessionCloseRQ};
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use App\Http\Services\NPSOnePGService;
use App\Http\Services\PaymentService;
use App\Mail\InternationalFlightBooking;
use App\Models\CompanyTicketDetail;
use App\Service\AirIq\AirIqFlight;
use App\Service\AirIq\AirIqHelper;
use App\Service\AirIq\AirIqService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use PDF;

class FlightController extends FlightBaseController
{

    public function airportSearch(Request $request)
    {
        $search = $request->get('term');

        if (!empty($search)) {
            $result = Airport::select('*')->selectRaw("
            CASE 
                WHEN code LIKE ? THEN 1 
                WHEN airport LIKE ? THEN 2 
                WHEN city LIKE ? THEN 3 
                WHEN country LIKE ? THEN 4 
                ELSE 5 
            END AS priority
        ", [
                '%' . ucfirst($search) . '%',
                '%' . strtoupper($search) . '%',
                '%' . ucfirst($search) . '%',
                '%' . ucfirst($search) . '%'
            ])
                ->where('code', 'LIKE', '%' . ucfirst($search) . '%')
                ->orWhere('airport', 'LIKE', '%' . strtoupper($search) . '%')
                ->orWhere('city', 'LIKE', '%' . ucfirst($search) . '%')
                ->orWhere('country', 'LIKE', '%' . ucfirst($search) . '%')
                ->orderBy('priority')
                ->limit(5)
                ->get();
        } else {
            $topDepartures = SearchFlight::select('departure', \DB::raw('COUNT(id) as flight_count'))
                ->groupBy('departure')
                ->orderByDesc('flight_count')
                ->limit(5);

            $result = Airport::joinSub($topDepartures, 'top_departures', function ($join) {
                $join->on('airports.code', '=', 'top_departures.departure');
            })
                ->select('airports.*', 'top_departures.flight_count')
                ->orderByDesc('top_departures.flight_count') // Ensure proper ordering by occurrence
                ->get();
        }


        $data = array();
        foreach ($result as $hsl) {
            $data[] = [
                "city" => $hsl->code,
                "city_full" => $hsl->city,
                "airport" => $hsl->code . '- ' . $hsl->airport . ',' . $hsl->city . '-' . $hsl->country
            ];
        }
        return response()->json($data);
    }

    public function airlineSearch(Request $request)
    {
        $search = $request->get('term');
        $result = Airline::where('name', 'LIKE', '%' . $search . '%')
            ->orWhere('code', 'LIKE', '%' . $search . '%')
            ->get();
        $data = array();
        foreach ($result as $hsl) {
            $data[] = $hsl->code . '-' . $hsl->name;
        }
        return response()->json($data);
    }

    public function searchFlight(SearchFlightRequest $request)
    {
        // dd($request->all());
        //save search parameters to database
        if (session()->has('sabre_token')) {
            $close_session = new SessionCloseRQ();
            $close_session->doRequest();
        }
        $search = new SearchFlight();

        $search->departure = strtoupper($this->getAirportCode($request->departure));
        session()->put('flight_origin', strtoupper($this->getAirportCode($request->departure)));
        $search->destination = strtoupper($this->getAirportCode($request->destination));
        $search->flight_date = Carbon::createFromFormat('Y-m-d', $request->flightdate)->toDateString();
        if ($request->type == 'R') {
            $search->return_date = Carbon::createFromFormat('Y-m-d', $request->returndate)->toDateString();
        }
        if ($request->flightadults > 0) {
            $search->adults = $request->flightadults;
        }
        if ($request->flightchilds > 0) {
            $search->childs = $request->flightchilds;
        }
        if ($request->flightinfants > 0) {
            $search->infants = $request->flightinfants;
        }
        if (Auth::user()) {
            $search->user_id = Auth::user()->id;
        }
        $search->nationality = $request->nationality;
        if ($request->nationality == 'NP') {
            $search->currency = 'NPR';
        } else if ($request->nationality == 'IN') {
            $search->currency = 'NPR';
        } else {
            $search->currency = 'USD';
        }

        session()->put('flight_nationality', strtoupper($request->nationality));


        //        check if search is multi city

        if ($request->type == 'M') {
            $sectorsData = collect($request->only(
                'int_multi_from',
                'int_multi_to',
                'int_multi_departure'
            ));


            $sectors = $sectorsData->transpose()->map(function ($newSectors) {
                //                dd($newSectors);
                if ((isset($newSectors[0])) && (isset($newSectors[1])) && (isset($newSectors[2]))) {
                    return [
                        'depart' => strtoupper($this->getAirportCode($newSectors[0])),
                        'arrival' => strtoupper($this->getAirportCode($newSectors[1])),
                        'date' => $newSectors[2]
                    ];
                }
            })
                ->filter(function ($item) {
                    return $item != null;
                });


            $search->sectors = json_encode($sectors);
        }

        if (isset($request->class)) {
            if ($request->class == 'Economy') {
                $search->class = 'Y';
            } else if ($request->class == 'First Class') {
                $search->class = 'F';
            } else if ($request->class == 'Business') {
                $search->class = 'C';
            }
        }

        if (isset($request->airline)) {
            $search->airline = explode('-', $request->airline)[0];
        }

        $search->save();

        session()->forget(['flight', 'flight_book']); //forget if previously flight is booked
        session()->put('flight_search', $search->id); //put search in session

        $collect_flights = $this->getFlights($search); // sabre data

        $collect_flights2 = [];
        if($search->departure !== 'KTM'){
            if($request->type !== 'M'){
                $collect_flights2 = AirIqService::getFlights($search);  // airiq data
            }
        }

        $mergedFlights = array_merge($collect_flights, $collect_flights2);
        // usort($mergedFlights, function ($a, $b) {
        //     $priceA = (int) filter_var($a['pricing']['total'], FILTER_SANITIZE_NUMBER_INT);
        //     $priceB = (int) filter_var($b['pricing']['total'], FILTER_SANITIZE_NUMBER_INT);
        //     return $priceA <=> $priceB;
        // });

        usort($mergedFlights, function ($a, $b) {
            $priceA = (float) preg_replace('/[^\d.]/', '', $a['pricing']['total']);
            $priceB = (float) preg_replace('/[^\d.]/', '', $b['pricing']['total']);
            return $priceA <=> $priceB;
        });

        // dd($mergedFlights);
        $airlines = collect($mergedFlights)->unique('airline')->pluck('airline');
        session()->put('flight_result', $mergedFlights);
        session()->put('flight_airline', $airlines);
        return redirect()->route('search.result');
    }

    public function getAirportCode($airport)
    {
        $data = explode('-', $airport);
        return $data[0];
    }

    public function getFlights($search)
    {

        dd("Success");
        $token = $this->callCreateSession(); //create sabre session token and put in session with created time
        if (!$token) {
            return redirect()->back()->with('warning', 'Error Connecting to server.');
        }

        session()->put('token_time', Carbon::now());
        session()->put('sabre_token', $token);

        $bfx = new BargainFinderMaxAdRQ();
        $doc = $bfx->doRequest();

        if (!$doc) { //if response has error
            return view('flights.search-result', ['flights' => false, 'search' => $search, 'airlines' => false]);
        }

        $bfx_response = $bfx->formatResponse($doc);  //get flight from response xml

        if (!isset($bfx_response)) {
            return view('flights.search-result', ['flights' => false, 'search' => $search, 'airlines' => false]);
        }

        if (Auth::check() && Auth::user()->user_type === 'AGENT') {
            $markup = new AgentMarkupService();
            return $markup->addMarkup($bfx_response);
        }


        $markup = new MarkupService();

        return $markup->addMarkup($bfx_response);
    }

    public function nextDaySearch()
    {
        $search = SearchFlight::findorfail(session()->get('flight_search'));
        $newSearch = $search->replicate();
        $newSearch->flight_date = $search->flight_date->addDay()->format('Y-m-d');
        $newSearch->save();
        session()->forget(['flight', 'flight_book']); //forget if previously flight is booked
        session()->put('flight_search', $newSearch->id); //put search in session

        $collect_flights = $this->getFlights($newSearch);

        session()->put('flight_result', $collect_flights);
        session()->put('flight_airline', $airlines);
        return redirect()->route('search.result');
    }

    public function prevDaySearch()
    {
        $search = SearchFlight::findorfail(session()->get('flight_search'));
        if ($search->flight_date->isToday()) {
            return redirect()->route('search.result')->with('warning', 'Not before today');
        }
        $newSearch = $search->replicate();
        $newSearch->flight_date = $search->flight_date->subDay()->format('Y-m-d');
        $newSearch->save();
        session()->forget(['flight', 'flight_book']); //forget if previously flight is booked
        session()->put('flight_search', $newSearch->id); //put search in session

        $collect_flights = $this->getFlights($newSearch);

        $airlines = collect($collect_flights)->unique('airline')->pluck('airline');
        session()->put('flight_result', $collect_flights);
        session()->put('flight_airline', $airlines);
        return redirect()->route('search.result');
    }

    public function getSabreTokenTime(Request $request)
    {
        $tokenTime = Carbon::parse(session()->get('token_time'));
        $expireTime = Carbon::parse(session()->get('token_time'))->addMinutes(5);
        $checkCurrentTime = Carbon::now()->diffInMilliseconds($tokenTime);
        //        dd($checkCurrentTime);
        if ($checkCurrentTime > 300000) {
            //            return 0;
            return 300000;
        } else {
            $diff = $expireTime->diffInMilliseconds($tokenTime, true);
            if ($diff > 300000) {
                return 0;
                //                return 300000;
            } else {
                return $diff;
            }
        }
    }

    public function showFlightResult()
    {
        $flights = session()->get('flight_result');
        // return $flights;

        $search = SearchFlight::findorfail(session()->get('flight_search'));
        $airlines = session()->get('flight_airline');

        // if (!$airlines) {
        //     return redirect()->route('frontend.index')->with('warning', 'Fares have been changed since last search.');
        // }

        return view('flights.search-result', ['flights' => $flights, 'search' => $search, 'airlines' => $airlines]);
    }

    public function sortFlights(Request $request)
    {
        //        dd($request->all());
        if (session()->has('flight_result')) {
            $flights = session()->get('flight_result');

            $collectFlights = collect($flights);

            //            check for airline filter

            if (is_array($request->airline) && count($request->airline) > 0) {

                $sortAirFlights = collect($collectFlights->whereIn('airline', $request->airline)->all());
            } else {
                $sortAirFlights = $collectFlights;
            }

            //            check for stops filter

            if (is_array($request->stops) && count($request->stops) > 0) {
                $stops = $request->stops;
                $sortStopFlights = collect($sortAirFlights->map(function ($item) use ($stops) {

                    foreach ($stops as $s) {
                        if ($s == '2+') {
                            if ($item['detail'][0]['stops'] > 2) {
                                return $item;
                            }
                        } else {
                            if ($item['detail'][0]['stops'] == (int) $s) {
                                return $item;
                            }
                        }
                    }
                })->filter(function ($item) {
                    return $item != null;
                })->all());
            } else {
                $sortStopFlights = $sortAirFlights;
            }

            //            check for depart time filter
            if (is_array($request->departime) && count($request->departime) > 0) {
                $departime = $request->departime;
                $sortDepartFlights = collect($sortStopFlights->map(function ($item) use ($departime) {
                    foreach ($departime as $time) {
                        $range = explode('-', $time);
                        $startLimit = Carbon::createFromFormat('H:i', $range[0]);
                        $endLimit = Carbon::createFromFormat('H:i', $range[1]);
                        $flightTime = Carbon::createFromFormat('H:i:s', $item['detail'][0]['origintime']);
                        if ($flightTime->between($startLimit, $endLimit)) {
                            return $item;
                        }
                    }
                })->filter(function ($item) {
                    return $item != null;
                })->all());
            } else {
                $sortDepartFlights = $sortStopFlights;
            }

            //            check for arrival time filter

            if (is_array($request->arrivaltime) && count($request->arrivaltime) > 0) {
                $departime = $request->arrivaltime;
                $sortArrivalFlights = collect($sortDepartFlights->map(function ($item) use ($departime) {
                    foreach ($departime as $time) {
                        $range = explode('-', $time);
                        $startLimit = Carbon::createFromFormat('H:i', $range[0]);
                        $endLimit = Carbon::createFromFormat('H:i', $range[1]);
                        $flightTime = Carbon::createFromFormat('H:i:s', $this->getArrivalTime($item));
                        if ($flightTime->between($startLimit, $endLimit)) {
                            return $item;
                        }
                    }
                })->filter(function ($item) {
                    return $item != null;
                })->all());
            } else {
                $sortArrivalFlights = $sortDepartFlights;
            }

            //            check for refundable filter

            if (isset($request->refund)) {

                if ($request->refund == 'refund') {

                    $sortRefundFlights = collect($sortArrivalFlights->filter(function ($value) {
                        return $value['detail'][0]['refundable'] == 'false';
                    })->all());
                } else if ($request->refund == 'non-refund') {
                    $sortRefundFlights = collect($sortArrivalFlights->filter(function ($value) {
                        return $value['detail'][0]['refundable'] == 'true';
                    })->all());
                } else {
                    $sortRefundFlights = $sortArrivalFlights;
                }
            } else {
                $sortRefundFlights = $sortArrivalFlights;
            }

            if (isset($request->type) && isset($request->dir)) {
                if ($request->type == 'price') {
                    //                    $flights = $sortRefundFlights->toArray();
                    if ($request->dir == 'asc') {
                        $sortedFlights = $sortRefundFlights->sortBy(function ($item, $key) {
                            return explode(' ', $item['pricing']['markedfare']);
                        });
                        //
                    } else {
                        $sortedFlights = $sortRefundFlights->sortByDesc(function ($item, $key) {
                            return explode(' ', $item['pricing']['markedfare']);
                        });
                        //
                    }
                } else if ($request->type == 'duration') {
                    //                    $flightsArray = $sortRefundFlights->toArray();
                    if ($request->dir == 'asc') {
                        $sortedFlights = $sortRefundFlights->sortBy(function ($item, $key) {
                            return $this->getTotalTime($item);
                        });
                    } else {
                        $sortedFlights = $sortRefundFlights->sortByDesc(function ($item, $key) {
                            return $this->getTotalTime($item);
                        });
                    }
                } else if ($request->type == 'depart') {
                    if ($request->dir == 'asc') {
                        $sortedFlights = $sortRefundFlights->sortBy(function ($item, $key) {
                            return $item['flight'][0][0]['departtime'];
                        });
                    } else {
                        $sortedFlights = $sortRefundFlights->sortByDesc(function ($item, $key) {
                            return $item['flight'][0][0]['departtime'];
                        });
                    }
                } else if ($request->type == 'arrival') {
                    if ($request->dir == 'asc') {
                        $sortedFlights = $sortRefundFlights->sortBy(function ($item, $key) {
                            return $this->getArrivalTime($item);
                        });
                    } else {
                        $sortedFlights = $sortRefundFlights->sortByDesc(function ($item, $key) {
                            return $this->getArrivalTime($item);
                        });
                    }
                } else {
                    $sortedFlights = $sortRefundFlights;
                }
            } else {
                $sortedFlights = $sortRefundFlights;
            }
            //            dd($sortedFlights);
            return view('front.includes.searchresultpage.flightfilter', ['flights' => $sortedFlights, 'filterType' => $request->type])->render();
        } else {
            abort(404);
        }
    }

    public function getArrivalTime($flight)
    {
        $flightCount = count($flight['detail']);
        return $flight['detail'][$flightCount - 1]['destinationtime'];
    }

    public function getTotalTime($flight)
    {
        $time = 0;
        foreach ($flight['detail'] as $detail) {
            $time = $time + $detail['totaltime'];
        }
        return $time;
    }

    public function bookFlight(Request $request)
    {

        $search = SearchFlight::findorfail(session()->get('flight_search'));
        if (!$search) {
            return redirect()->route('frontend.index')->with('error', 'Error!! Please start over.');
        }

        $flight = decrypt($request->flight);
        session()->put('flight', $request->flight);
        session()->save();

        // dd($flight['apiprovider']);
        if (($flight['apiprovider'] ?? '') != 'airiq') {
            session()->put('apiprovider', 'sabre');
            $response = $this->callAirBook($flight['flight']);
            if (!$response) {
                session()->put('flight_book', false);
                $this->callIgnoreTransaction();
            } else {
                session()->put('flight_book', true);
            }
        } else {
            session()->put('apiprovider', 'airiq');
            session()->put('flight_book', true);
            session()->save();
            AirIqService::getPricing();
        }

        return redirect()->route('passenger.form');
    }

    public function showPassengerForm()
    {
        // dd(json_decode(session()->get('airiq_pricing_response')));
        if (session()->has('flight_book')) {
            $response = session()->get('flight_book');
        } else {
            abort(404);
        }

        if (session()->has('flight')) {
            $flight = decrypt(session()->get('flight'));
        } else {
            abort(404);
        }

        if (session()->has('flight_search')) {
            $search = SearchFlight::findorfail(session()->get('flight_search'));
        } else {
            abort(404);
        }

        return view('flights.flight-book', ['search' => $search, 'flights' => $flight, 'response' => $response]);
    }

    public function passengerDetails(BookingFormRequest $request)
    {
        $searchFlight = SearchFlight::findorfail(session()->get('flight_search'));
        $flight = decrypt(session()->get('flight'));
        $passengers = [];
        $adults = [];
        $childs = [];
        $infants = [];
        $contact = [];
        $contact['name'] = $request->confullname;
        // $contact['name'] = $request->confirstname;
        // $contact['mname'] = $request->conmidname;
        // $contact['lname'] = $request->conlastname;
        $contact['email'] = $request->conemail;
        $contact['phone'] = $request->conphone;
        $contact['phone_code'] = $request->phone_code;

        $nationalities = [];
        if ($searchFlight->adults > 0) {
            $requestAdult = collect($request->only(
                'adttitle',
                'adtfirstname',
                'adtlastname',
                'adtdob',
                'adtpassport',
                'adtnation',
                'adtgender',
                'adtpassportexpiry',
                'adtpassportcountry',
                'adtdoctype'
                //                ,'adtmeal','adtrequest','adtfreq','adtreq','adtfreqair'
            ));

            $adults = $requestAdult->transpose()->map(function ($guestData) use ($adults) {
                return [
                    'title' => $guestData[0],
                    'firstname' => $guestData[1],
                    'lastname' => $guestData[2],
                    'dob' => $guestData[3],
                    'passport' => $guestData[4],
                    'nationality' => $guestData[5],
                    'gender' => $guestData[6],
                    'passexpire' => $guestData[7],
                    'passcountry' => $guestData[8],
                    'doctype' => $guestData[9],
                    //                    'meal'=>$guestData[11],
                    //                    'ssr'=>$guestData[12],
                    //                    'freq'=>$guestData[13],
                    //                    'req'=>$guestData[14],
                    //                    'freqair'=>$guestData[15]
                ];
            });
        }

        if ($searchFlight->childs > 0) {
            $requestChild = collect($request->only(
                'chdtitle',
                'chdfirstname',
                'chdlastname',
                'chddob',
                'chdpassport',
                'chdnation',
                'chdgender',
                'chdpassportexpiry',
                'chdpassportcountry',
                'chddoctype'
                //                ,'chdmeal','chdrequest','chdfreq','chdreq','chdfreqair'
            ));

            $childs = $requestChild->transpose()->map(function ($guestData) {
                return [
                    'title' => $guestData[0],
                    'firstname' => $guestData[1],
                    'lastname' => $guestData[2],
                    'dob' => $guestData[3],
                    'passport' => $guestData[4],
                    'nationality' => $guestData[5],
                    'gender' => $guestData[6],
                    'passexpire' => $guestData[7],
                    'passcountry' => $guestData[8],
                    'doctype' => $guestData[9],
                    //                    'meal'=>$guestData[11],
                    //                    'ssr'=>$guestData[12],
                    //                    'freq'=>$guestData[13],
                    //                    'req'=>$guestData[14],
                    //                    'freqair'=>$guestData[15]
                ];
            });
        }

        if ($searchFlight->infants > 0) {
            $requestInfant = collect($request->only(
                'inftitle',
                'inffirstname',
                'inflastname',
                'infdob',
                'infpassport',
                'infnation',
                'infgender',
                'infpassportexpiry',
                'infpassportcountry',
                'infdoctype'
                //                ,'infmeal','infrequest','infreq'
            ));

            $infants = $requestInfant->transpose()->map(function ($guestData) use ($infants) {
                return [
                    'title' => $guestData[0],
                    'firstname' => $guestData[1],
                    'lastname' => $guestData[2],
                    'dob' => $guestData[3],
                    'passport' => $guestData[4],
                    'nationality' => $guestData[5],
                    'gender' => $guestData[6],
                    'passexpire' => $guestData[7],
                    'passcountry' => $guestData[8],
                    'doctype' => $guestData[9],
                    //                    'meal'=>$guestData[11],
                    //                    'ssr'=>$guestData[12],
                    //                    'req'=>$guestData[13]
                ];
            });
        }

        $nqTax = 0;
        if (session()->get('flight_origin') == 'KTM' && session()->get('flight_nationality') == 'NP') {
            $adtNationalities = count($adults)
                ? $adults->pluck('nationality')->filter(function ($item) {
                    return $item !== 'NP';
                })->all()
                : [];

            $childNationalities = count($childs)
                ? $childs->pluck('nationality')->filter(function ($item) {
                    return $item !== 'NP';
                })->all()
                : [];

            $totalNationalities = array_merge($adtNationalities, $childNationalities);
            $nqTax = (int) count($totalNationalities) * 1130;
        }

        $flightDate = $flight['flight'][0]['sectors'][0]['departdate'];
        $flightTime = $flight['flight'][0]['sectors'][0]['departtime'];

        $booking = new FlightBooking();
        $booking->booking_code = strtoupper(uniqid());
        $booking->search_flight_id = session()->get('flight_search');
        $booking->contact_details = json_encode($contact, true);
        $booking->air_price = json_encode($flight['pricing'], true);
        $booking->flights = json_encode($flight, true);
        $booking->airline = $flight['airline'];
        $booking->bsp_fare = explode(' ', $flight['pricing']['total'])[1];
        $booking->final_fare = explode(' ', $flight['pricing']['markedfare'])[1] + $nqTax;
        $booking->currency = explode(' ', $flight['pricing']['basefare'])[0];
        $booking->flight_date = $flightDate . ' ' . $flightTime;

        $flight = decrypt(session()->get('flight'));
        $booking->airiq_flights_details = json_encode($flight['airiqflights']);
        $booking->airiq_pricing_details = session()->get('airiq_pricing_response');
        $booking->airiq_flight_type = $flight['type'];
        $booking->api_provider = session('apiprovider');

        if (isset($searchFlight->sectors)) {
            $booking->trip_type = 'M';
        } else {
            if (isset($searchFlight->return_date)) {
                $booking->trip_type = 'R';
            } else {
                $booking->trip_type = 'O';
            }
        }
        if (Auth::user()) {
            $booking->user_id = auth()->id();
        }
        $booking->save();

        if ($searchFlight->adults > 0) {
            $this->savePassengerDetail($adults, 'ADT', $booking->id);
        }

        if ($searchFlight->childs > 0) {
            $this->savePassengerDetail($childs, 'CHLD', $booking->id);
        }

        if ($searchFlight->infants > 0) {
            $this->savePassengerDetail($infants, 'INFT', $booking->id);
        }
        // event(new FlightBookedEvent($booking));

        // if (session('apiprovider') === 'airiq') {
        //     Redirect::to(route('issue.ticket', [
        //         'code' => $booking->booking_code
        //     ]))->send();
        // }

        $mailDetails = [
            'flight_type' => $searchFlight->return_date ? 'R' : 'O',
            'sector_from' => $searchFlight->departure,
            'sector_to' => $searchFlight->destination,
            'adult_count' => $searchFlight->adults,
            'child_count' => $searchFlight->childs,
            'infant_count' => $searchFlight->infants,
            'departure_date' => date('Y-m-d', strtotime($searchFlight->flight_date)),
            'emergency_contact_phone' => $request->conphone,
            'emergency_contact_email' => $request->conemail,
            'booking_code' => $booking->booking_code,
        ];
        Mail::to(['info@flightsgyani.com'])->send(new InternationalFlightBooking($mailDetails, 'admin'));

        // dd($searchFlight);

        if ($request->paymentMethod == 'Wallet') {
            // if logged in user is agent then use loaded amount for payment
            $checkAgent = $this->checkAgentBalance();
            if ($checkAgent == 'insufficient-balance') {
                return redirect()->back()->with('error', 'Insufficient Balance');
            }
        }

        $khalti = (new PaymentService())->bookWithKhalti($booking->booking_code, $request->paymentMethod);

        return Redirect::to($khalti->payment_url);
    }

    public function savePassengerDetail($pax, $type, $id)
    {
        foreach ($pax as $p) {
            $detail = new FlightBookingDetail();
            $detail->flight_booking_id = $id;
            $detail->pax_title = $p['title'];
            $detail->pax_first_name = $p['firstname'];

            $detail->pax_last_name = $p['lastname'];
            $detail->pax_type = $type;
            $detail->pax_gender = $p['gender'];
            $detail->dob = $p['dob'];
            $detail->nationality = $p['nationality'];
            $detail->doc_type = $p['doctype'];
            $detail->doc_number = $p['passport'];
            $detail->doc_expiry_date = $p['passexpire'];
            $detail->doc_issued_by = $p['passcountry'];
            //            $detail->meal_code = $p['meal'];
            //            $detail->ssr_request = $p['ssr'];
            //            if($type != 'INFT'){
            //                $detail->freq_flyer = $p['freq'];
            //                $detail->freq_flyer_airline = $p['freqair'];
            //            }
            //            $detail->request = $p['req'];
            $detail->save();
        }
    }

    public function payment($code)
    {
        $booking = FlightBooking::where('booking_code', $code)->first();
        if (!$booking) {
            abort(404);
        }
        if ($booking->pnr_id != null && $booking->ticket_details != null) {
            return redirect()->route('show.ticket', $code);
        }
        if ($booking->pnr_id != null && $booking->ticket_details == null && $booking->payment_status == true) {
            return redirect()->route('issue.ticket', $code);
        }

        if ($booking->payment_status && is_null($booking->pnr_id)) {
            return redirect()->route('generate.pnr', $code);
        }

        $khalti = Khalti::first();
        if ($khalti && !$khalti->status) {
            $khalti = false;
        }
        $ips = ConnectIps::first();
        if ($ips && !$ips->status) {
            $ips = false;
        }
        $NPSOnePG = NPSOnePG::first();
        if ($NPSOnePG && !$NPSOnePG->status) {
            $NPSOnePG = false;
        }

        $flights = json_decode($booking->flights, true);
        $pricing = json_decode($booking->air_price, true);

        $paymentMethods = (new NPSOnePGService())->getNPSOnePGGateways();

        return view('flights.payment', [
            'booking' => $booking,
            'flights' => $flights,
            'pricing' => $pricing,
            'khalti' => $khalti,
            'ips' => $ips,
            'NPSOnePG' => $NPSOnePG,
            "paymentMethods" => json_decode($paymentMethods, true)
        ]);
    }

    public function generatePnr($code)
    {

        $booking = FlightBooking::where('booking_code', $code)->first();
        if (!$booking) {
            abort(404);
        }
        if (!$booking->payment_status) {
            // return redirect()->route('flight.payment', $code);
            return redirect()->route('domesticflights.ticket.error', $code);
        }
        // if (!($booking->payments()->exists()) && $booking->payment_status == false) {
        //     // return redirect()->route('flight.payment', $code);
        //     return redirect()->route('domesticflights.ticket.error', $code);
        // }

        // if ((!Auth::user()) || !Auth::user()->hasRole('Admin')) {
        if ($booking->pnr_id != null && $booking->ticket_details != null) {
            return redirect()->route('show.ticket', $code);
        }
        if ($booking->pnr_id != null && $booking->ticket_details == null && $booking->payment_status == true) {
            return redirect()->route('issue.ticket', $code);
        }

        // }
        $contact = json_decode($booking->contact_details, true);
        $airline = json_decode($booking->flights, true)['airline'];

        $adults = $booking->bookingDetails()->where('pax_type', 'ADT')->get();

        $childs = $booking->bookingDetails()->where('pax_type', 'CHLD')->get();

        $infants = $booking->bookingDetails()->where('pax_type', 'INFT')->get();

        $response = $this->callPassengerDetail($airline, $contact, $adults, $childs, $infants);

        if ($response) {
            $booking->update([
                'pnr_id' => $response['pnr'],

            ]);
        }

        return redirect()->route('issue.ticket', $code);

        // $is_office_staff =  Auth::check() && Auth::user()->hasAnyRole("OFFICE STAFF");
        // if ((!Auth::user()) || !Auth::user()->hasRole('Admin') || $is_office_staff) {
        //     if ($booking->pnr_id != null && $booking->ticket_details == null && ($booking->payment_status == true || $is_office_staff)) {
        //         return redirect()->route('issue.ticket', $code);
        //     }
        // }
        // event(new FlightBookedEvent($booking));
        // return redirect()->route('show.pnr', $code);
    }

    public function showPNR($code)
    {

        $booking = FlightBooking::where('booking_code', $code)->first();

        if (!$booking) {
            abort(404);
        }
        if ((!Auth::user()) || !Auth::user()->hasRole('Admin')) {

            if ($booking->user_id != auth()->id()) {
                abort(404);
            }
        }


        if ($booking->ticket_status) {
            return redirect()->route('show.ticket', $code);
        }

        $flights = json_decode($booking->flights, true);
        return view('flights.pnr', ['booking' => $booking, 'flights' => $flights]);
    }

    //new ticket api request with get reservation and printer

    public function getFlightTickets($code)
    {
        $booking = FlightBooking::where('booking_code', $code)->first();
        $searchFlight = SearchFlight::findorfail(session()->get('flight_search'));
        if ($booking->api_provider == 'airiq') {
            // $bookFlight = AirIqFlight::bookFlight($booking);
            // $isBookingComplete = AirIqFlight::getTicketDetails($booking);
            // if (!$bookFlight || !$isBookingComplete) {
            //     return redirect()->route('domesticflights.ticket.error', $code);
            // }
            $airiqbooking = AirIqService::bookFlight($booking);
            if (!$airiqbooking) {
                return redirect()->route('domesticflights.ticket.error', $code);
            }
        } else {
            $is_office_staff = Auth::check() && Auth::user()->hasAnyRole("OFFICE STAFF");
            $contact = json_decode($booking->contact_details, true);
            if (!$booking) {
                abort(404);
            }

            if ($booking->pnr_id == null && ($booking->payment_status == true || $is_office_staff)) {
                return redirect()->route('generate.pnr', $code);
            }

            if (isset($booking->ticket_details)) {
                return redirect()->route('show.ticket', $code);
            }
            $tickets = $this->callTicketIssue($code);

            if (!$tickets) {
                return redirect()->route('domesticflights.ticket.error', $code);
            }

            $booking->update([
                'ticket_status' => true,
                'ticket_details' => json_encode($tickets),
                'ticket_itineraries' => json_encode($this->callGetReservation('Tickets', $booking->pnr_id))

            ]);

            $c = 2;

            foreach ($tickets as $ticket) {
                $ticketData = new FlightTicket();
                $ticketData->flight_booking_id = $booking->id;
                $ticketData->first_name = $ticket['fname'];
                $ticketData->last_name = $ticket['lname'];
                $ticketData->ticket_number = $ticket['number'];
                $ticketData->rph = $c;
                $ticketData->status = true;
                $ticketData->saveOrFail();
                $c++;
            }
        }

        $mailDetails = [
            'flight_type' => $searchFlight->return_date ? 'R' : 'O',
            'sector_from' => $searchFlight->departure,
            'sector_to' => $searchFlight->destination,
            'adult_count' => $searchFlight->adults,
            'child_count' => $searchFlight->childs,
            'infant_count' => $searchFlight->infants,
            'departure_date' => date('Y-m-d', strtotime($searchFlight->flight_date)),
            'emergency_contact_phone' => $contact->phone ?? '',
            'emergency_contact_email' => $contact->email ?? '',
            'emergency_contact_fullname' => ($contact->name ?? '') . ' ' . ($contact->lname ?? ''),
            'booking_code' => $booking->booking_code,
        ];
        Mail::to($contact->email ?? ['info@flightsgyani.com'])->send(new InternationalFlightBooking($mailDetails, 'user'));

        return redirect()->route('show.ticket', $code);
    }


    //previously used ticket issue api

    /* public function issueTicket($code)
     {
         $booking = FlightBooking::where('booking_code', $code)->first();
         if (!$booking) {
             abort(404);
         }
         if (!auth()->user()->hasRole('Admin')) {
             if ($booking->user_id != auth()->id()) {
                 abort(404);
             }
             if ($booking->pnr_id == null && $booking->payment_status == false) {
                 return redirect()->route('flight.payment', $code);
             }
             if ($booking->pnr_id == null && $booking->payment_status == true) {
                 return redirect()->route('generate.pnr', $code);
             }
             if (isset($booking->ticket_details)) {
                 return redirect()->route('show.ticket', $code);
             }
             if ($booking->payment()->exists() && $booking->payment_status == false) {
                 return redirect()->route('flight.payment', $code);
             }
         }
         $flights = json_decode($booking->flights, true);
         $pnr = $booking->pnr_id;
         $airline = $booking->airline;
         $response = $this->callGetReservation('open pnr', $pnr);
         if (!$response) {
             return redirect()->route('show.ticket', $code);
         }
         $printer_status = $this->callFirstPrinter();
         if (!$printer_status) {

             return redirect()->route('show.ticket', $code);

         }
         $printer1_status = $this->callSecondPrinter();
         if (!$printer1_status) {
             return redirect()->route('show.ticket', $code);
         }
         $ticket_status = $this->callAirTicketIssue($code);
         if (!$ticket_status) {
             $transaction_status = $this->callIgnoreTransaction();
             $this->callGetReservation('open pnr', $pnr);
             $ticketcall = $this->callAirTicketIssue($code);
             if (!$ticketcall) {
                 return redirect()->route('show.ticket', $code);
             }
         }
         $transaction_status = $this->callIgnoreTransaction();
         if (!$transaction_status) {
             return redirect()->route('show.ticket', $code);
         }
         $tickets = $this->callGetReservation('Tickets', $pnr);
         if (!$tickets) {
             return redirect()->route('show.ticket', $code);
         }
         $booking->update([
             'ticket_status' => true,
             'ticket_details' => json_encode($tickets['tickets'])
         ]);

         foreach ($tickets['tickets'] as $ticket) {
             foreach ($ticket['ticket'] as $t) {
                 $ticketData = new FlightTicket();
                 $ticketData->flight_booking_id = $booking->id;
                 $ticketData->pax_type = $ticket['type'];
                 $ticketData->first_name = $ticket['firstname'];
                 $ticketData->last_name = $ticket['lastname'];
                 $ticketData->ticket_reference = $t['original'];
                 $ticketData->ticket_number = $t['ticket'];
                 $ticketData->rph = $t['rph'];
                 $ticketData->status = true;
                 $ticketData->save();
             }
         }
         $close_response = $this->callSessionClose();
         if ($close_response) {
             session()->forget('flight_search');
             session()->forget('sabre_token');
             session()->forget('flight');
             session()->forget('flight_book');
         }
         return redirect()->route('show.ticket', $code);
     }*/

    public function showTicket($booking_code = '')
    {
        return view('front.success', compact('booking_code'));
        // $is_office_staff =  Auth::check() && Auth::user()->hasAnyRole("OFFICE STAFF");
        // $booking = FlightBooking::where('booking_code', $code)->first();
        // if (!$booking) {
        //     return redirect()->route('frontend.index');
        // }

        // if ($booking->user_id == auth()->id() || Auth::user()->hasRole('Admin')) {
        //     if ((!Auth::user()) || !Auth::user()->hasRole('Admin') && !$is_office_staff) {
        //         if (!$booking->payment_status) {
        //             return redirect()->route('flight.payment', $code);
        //         }
        //     }
        //     if ((!Auth::user()) || !Auth::user()->hasRole('Admin')) {
        //         if (!isset($booking->pnr_id) && $booking->payment_status) {
        //             return redirect()->route('generate.pnr', $code);
        //         }
        //     }
        //     $flights = json_decode($booking->flights, true)['flight'];
        //     if (!isset($booking->ticket_details)) {
        //         $tickets = false;
        //     } else {
        //         $tickets = $booking->getTickets()->get();
        //     }

        //     $baggage = json_decode($booking->flights, true)['baggage'];
        //     $tickets_itinearies = json_decode($booking->ticket_itineraries, true);
        //     return view('flights.ticket', ['tickets' => $tickets, 'flights' => $flights, 'booking' => $booking, 'baggage' => $baggage, 'ticket_itineraries' => $tickets_itinearies]);
        // } else {
        //     abort(404);
        // }
    }

    public function downloadTicket($booking_code)
    {
        $booking = FlightBooking::where('booking_code', $booking_code)->first();
        // dd($booking);

        $ticketDetails = null;
        if ($booking->user_id) {
            $ticketDetails = CompanyTicketDetail::where('user_id', $booking->user_id)->first();
        }

        if ($booking->api_provider == 'airiq') {
            $flights = json_decode($booking->flights, true)['flight'];
            if (!isset($booking->airiq_ticket_details)) {
                $tickets = false;
            } else {
                $tickets = json_decode($booking->airiq_ticket_details);
            }

            $baggage = json_decode($booking->flights, true)['baggage'];
            $pdf = Pdf::loadView('flights.airiqticket', compact('ticketDetails', 'tickets', 'flights', 'booking', 'baggage'));
            return $pdf->stream('flightsgyani-ticket.pdf');
        } else {
            $flights = json_decode($booking->flights, true)['flight'];
            if (!isset($booking->ticket_details)) {
                $tickets = false;
            } else {
                $tickets = $booking->getTickets()->get();
            }

            // dd($tickets);

            $baggage = json_decode($booking->flights, true)['baggage'];
            $ticket_itineraries = json_decode($booking->ticket_itineraries, true);
            $pdf = Pdf::loadView('flights.international-ticket', compact('ticketDetails', 'tickets', 'flights', 'booking', 'baggage', 'ticket_itineraries'));
            return $pdf->stream('flightsgyani-ticket.pdf');
        }
    }

    public function getAirline($flights)
    {
        return $flights['airline'];
    }

    public function getFareRule(Request $request)
    {
        $flights = session()->get('flight_result');

        $flight = collect($flights)->firstwhere('rph', $request->index);

        $date = $flight['detail'][0]['origindate'];
        $fare_rules = [];
        foreach ($flight['breakdown'] as $break) {
            foreach ($break['farecodes'] as $code) {
                $response = $this->callFareRule($code, $date);
                if ($response) {
                    array_push($fare_rules, [
                        'pax' => $break['type'],
                        'origin' => $code['start'],
                        'destination' => $code['end'],
                        'rule' => $response
                    ]);
                }
            }
        }
        return view('flights.fare-rule', ['rules' => $fare_rules])->render();
    }

    public function createTicketPdf($code)
    {
        $booking = FlightBooking::where('booking_code', $code)->first();
        if (!$booking) {
            return redirect()->route('frontend.index');
        }
        if (!auth()->user()->hasRole('Admin')) {
            if (!$booking->payment_status) {
                return redirect()->route('flight.payment', $code);
            }
            if (!isset($booking->pnr_id) && $booking->payment_status) {
                return redirect()->route('generate.pnr', $code);
            }
        }
        $flights = json_decode($booking->flights, true)['flight'];
        if (!isset($booking->ticket_details)) {
            $tickets = false;
        } else {
            $tickets = json_decode($booking->ticket_details, true);
        }
        $baggage = json_decode($booking->flights, true)['baggage'];
        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $options->set('debugKeepTemp', TRUE);
        $options->set('isHtml5ParserEnabled', true);
        $pdf = new Dompdf($options);
        $pdf->loadHtml(View::make('print', ['tickets' => $tickets, 'flights' => $flights, 'booking' => $booking, 'baggage' => $baggage])->render());
        $pdf->render();
        return $pdf->stream('ticket.pdf');
    }

    public function viewFlightBooking($code)
    {
        $booking = Auth::user()->internationalBooking()->where('booking_code', $code)->first();

        if (!$booking) {
            return redirect()->back()->with('warning', 'No Records Found');
        }

        $flight = json_decode($booking->flights, true);
        return view('viewbooking', ['booking' => $booking, 'flight' => $flight]);
    }

    public function requestVoidFlightBooking($code)
    {
        $booking = FlightBooking::where('booking_code', $code)->where('user_id', auth()->id())->first();

        if (!$booking) {
            abort(404);
        }

        if (!isset($booking->pnr_id)) {
            return redirect()->back()->with('warning', 'PNR not found.');
        }
        if ($booking->pnr_void) {
            return redirect()->back()->with('warning', 'PNR has been already cancelled.');
        }
        if ($booking->flight_date < date('Y-m-d H:i:s')) {
            return redirect()->back()->with('warning', 'Booking can not be cancelled.');
        }
        return view('voidflightbooking', ['booking' => $booking]);
    }

    public function sendVoidRequest(Request $request)
    {
        $request->validate([
            'booking_code' => 'required|exists:flight_bookings,booking_code',
            'pnr' => 'required|exists:flight_bookings,pnr_id',
            'message' => 'required'
        ], [
            'booking_code.required' => 'Provide your booking code',
            'booking_code.exists' => 'Invalid Booking Code',
            'pnr.required' => 'Provide PNR to be Canceled',
            'pnr.exists' => 'Invalid PNR',
            'message.required' => 'Provide your reason'
        ]);

        $booking = FlightBooking::where('booking_code', $request->booking_code)->where('user_id', auth()->id())->first();
        if (!$booking) {
            return redirect()->back()->with('warning', 'Not found in your booking list');
        }
        dispatch((new FlightBookingCancelRequest($booking, $request->message))->delay(Carbon::now()->addMinutes(2)));
        return redirect()->back()->with('success', 'Cancel Request sent successfully.');
    }

    public function checkAgentBalance()
    {
        if (Auth::check()) {
            if (Auth::user()->user_type == 'AGENT') {

                if (session()->has('flight')) {
                    $flight = decrypt(session()->get('flight'));
                    $amount = $flight['pricing']['markedfare'];
                    $price = explode(" ", $amount);
                    $currency = $price[0];
                    $amt = round($price[1]) ?? 0;

                    $remainingBalance = 0;
                    if ($currency == 'NPR') {
                        $remainingBalance = remainingBalance(Auth::user()->id, 'NPR');
                    }
                    if ($currency == 'USD') {
                        $remainingBalance = remainingBalance(Auth::user()->id, 'USD');
                    }

                    if ($remainingBalance >= $amt) {
                        return 'success';
                    } else {
                        return 'insufficient-balance';
                    }
                } else {
                    return 'insufficient-balance';
                }
            }
        }
        return 'skip';
    }
}
