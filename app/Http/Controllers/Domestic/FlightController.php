<?php

namespace App\Http\Controllers\Domestic;

use App\Helpers\PaymentHelper;
use App\Helpers\SoapHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePassengerDetails;
use App\Mail\B2b\AdminNotify;
use App\Mail\DomesticFlightBooking as MailDomesticFlightBooking;
use App\Models\B2B\Transaction;
use App\Models\CompanyTicketDetail;
use App\Models\Domestic\DomesticAirline;
use App\Models\Domestic\DomesticFlightBooking;
use App\Models\Domestic\DomesticFlightInfo;
use App\Models\Domestic\DomesticFlightPayment;
use App\Models\Domestic\DomesticFlightTicket;
use App\Models\Domestic\DomesticPassenger;
use App\Models\Domestic\DomesticSector;
use App\Models\DomesticSearchFlight;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class FlightController extends Controller
{
    public $discount = [];

    public function flightResult(Request $request)
    {
        dd("Domestic Flight Not Required");
        domesticSessionClear(); //clears all session
        $data = $this->getRequestData($request);

        $flights = $this->getAllFlights($data);

        // Extract unique airlines for filter
        $airlines = array_unique(array_merge(
            array_column($flights['Outbound']['Availability'] ?? [], 'Airline'),
            array_column($flights['Inbound']['Availability'] ?? [], 'Airline')
        ));

        // Fetch sectors
        $sectors = DomesticSector::oldest('order')->get();
        $airlinesData = DomesticAirline::oldest('order')->get();

        // for airlines image and name
        $airData = [];
        $airDataName = [];
        foreach ($airlinesData as $key => $air) {
            $airData[$air->code] = $air->image;
            $airDataName[$air->code] = $air->name;
        }

        return view('front.domestic.searchresult', compact('airlines', 'flights', 'data', 'sectors', 'airData', 'airDataName'));
    }

    public function passengerDetails(Request $request)
    {
        $outboundFlightDetails = (object) decrypt($request->selectedoutboundflightdetails ?? '');
        $inboundFlightDetails = $request->selectedinboundflightdetails ? (object) decrypt($request->selectedinboundflightdetails) : '';
        // dd([$outboundFlightDetails, $inboundFlightDetails]);
        Session::put('outbound_flight', $outboundFlightDetails);
        Session::put('inbound_flight', $inboundFlightDetails);

        $reserv = SoapHelper::reservation($request->oneway_flightid, $request->twoway_flightid);
        $reservation = json_decode(json_encode($reserv), true);
        Session::put('reservation_data', $reservation);

        return redirect()->route('domesticflights.passengerdetails.page');
    }

    public function passengerDetailsPage()
    {
        $reservation = Session::get('reservation_data');
        $request_data = Session::get('request_data');
        if (!$reservation) {
            return redirect()->route('frontend.index');
        }

        return view('front.domestic.passengerdetails', compact('request_data', 'reservation'));
    }

    public function passengerDetailsStore(StorePassengerDetails $request)
    {
        Session::put('passenger_details', $request->all());
        return redirect()->route('domesticflights.payment.store');
    }

    public function payment()
    {
        return view('front.domestic.payment');
    }

    public function paymentStore(Request $request)
    {
        $khaltiKEY = khaltiCredentials()->secret_key;
        $khaltiURL = khaltiCredentials()->khaltiURL;
        $passenger_details = Session::get('passenger_details');
        $summary = totalDomesticAmount();

        // if logged in user is office staff then issue ticket directly without any payment
        if (Auth::check() && Auth::user()->hasAnyRole('OFFICE STAFF')) {
            return redirect()->route('domesticflights.payment.status');
        }

        if ($passenger_details['paymentMethod'] == 'Wallet') {
            // if logged in user is agent then use loaded amount for payment
            $checkAgent = $this->checkAgentBalance();
            if ($checkAgent == 'success') {
                return redirect()->route('domesticflights.payment.status');
            }
            if ($checkAgent == 'insufficient-balance') {
                return redirect()->back()->with('error', 'Insufficient Balance');
            }
        }


        $USD_rate = getCurrencyRate();
        $amt = $summary['totalAmount'] ?? 0;
        if ($summary['Currency'] != 'NPR') {
            $amt = $summary['totalAmount'] * $USD_rate;
        }
        $amt = ceil($amt);
        // khalti payment
        $curl = curl_init();
        $configs = [
            "return_url" => route('domesticflights.payment.status'),
            "website_url" => $request->getSchemeAndHttpHost(),
            "amount" => $amt * 100,
            "purchase_order_id" => strtoupper(Str::random(8)),
            "purchase_order_name" => $passenger_details['emergency_full_name'] ?? '',
            "customer_info" => [
                "name" => $passenger_details['emergency_full_name'] ?? '',
                "email" => $passenger_details['emergency_email'] ?? '',
                "phone" => $passenger_details['emergency_phone_number'] ?? ''
            ]
        ];
        // dd($configs);
        $json_configs = json_encode($configs);

        curl_setopt_array($curl, array(
            CURLOPT_URL => $khaltiURL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $json_configs,
            CURLOPT_HTTPHEADER => array(
                'Authorization: key ' . $khaltiKEY,
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($response);
        if ($response) {
            $data = json_decode($response);
            return redirect($data->payment_url);
        }
        // khalti payment ends
    }

    public function paymentStatus()
    {
        $checkBooking = $_GET['purchase_order_id'] ?? null;
        if ($checkBooking) {
            $booking = DomesticFlightBooking::where('booking_code', $checkBooking)->first();
            if ($booking) {
                return redirect()->route('frontend.index');
            }
        }
        $request_data = Session::get('request_data');
        $outbound_flight = Session::get('outbound_flight');
        $inbound_flight = Session::get('inbound_flight');
        $reservation_data = Session::get('reservation_data');
        $passenger_details = Session::get('passenger_details');
        $summary = totalDomesticAmount();

        $payment_status = $_GET['status'] ?? '';
        $is_office_staff = false;
        $is_agent = false;
        $payment_type = 'Khalti';
        if (Auth::check() && Auth::user()->hasAnyRole('OFFICE STAFF')) {
            $payment_status = 'Pending';
            $is_office_staff = true;
            $payment_type = 'OFFICE STAFF';
        }

        if ($passenger_details['paymentMethod'] == 'Wallet') {
            $checkAgent = $this->checkAgentBalance();
            if ($checkAgent == 'success') {
                $payment_status = 'Completed';
                $is_agent = true;
                $payment_type = 'Wallet';
                // deduct amount from agent wallet
                PaymentHelper::transaction(Auth::user()->id, 'DEBITED', $outbound_flight->Currency ?? '', $summary['totalAmount'] ?? 0, 'WALLET', 'Flight Booking', date('Y-m-d'));
            }
            if ($checkAgent == 'insufficient-balance') {
                // dont issue ticket if there is no sufficient balance
                return "Insufficient Balance";
            }
        }

        $USD_rate = getCurrencyRate();
        $amt = $summary['totalAmount'] ?? 0;
        if ($summary['Currency'] != 'NPR') {
            $amt = $summary['totalAmount'] * $USD_rate;
        }

        // for khalti
        if ($payment_status != 'User canceled' || $is_office_staff || $is_agent) {
            $totalAmt = isset($_GET['total_amount']) ? $_GET['total_amount'] / 100 : ceil($amt);
            $booking = DomesticFlightBooking::create([
                'user_id' => Auth::user()->id ?? null,
                'booking_code' => $_GET['purchase_order_id'] ?? strtoupper(Str::random(8)),
                'coupon_code' => null,
                'sector_from' => $request_data['from'] ?? '',
                'sector_to' => $request_data['to'] ?? '',
                'departure_date' => $request_data['flightDate'] ? date('Y-m-d', strtotime($request_data['flightDate'] ?? '')) : null,
                'arrival_date' => $request_data['returnDate'] ? date('Y-m-d', strtotime($request_data['returnDate'] ?? '')) : null,
                'flight_type' => $request_data['type'] ?? '',
                'adult_count' => $request_data['adult'] ?? null,
                'child_count' => $request_data['child'] ?? null,
                'nationality' => $request_data['nationality'] ?? '',
                'total_booking_amount' => $totalAmt,
                'emergency_contact_title' => '',
                'emergency_contact_fullname' => $passenger_details['emergency_full_name'] ?? '',
                'emergency_contact_email' => $passenger_details['emergency_email'] ?? '',
                'emergency_contact_phone' => $passenger_details['emergency_phone_number'] ?? '',
                'is_office_staff' => $is_office_staff ? 1 : 0,
                'ticket_status' => 'Not Issued',
                'discount_amount' => $summary['totalDiscount'] ?? 0,
            ]);

            $payment = DomesticFlightPayment::create([
                'booking_id' => $booking->id ?? null,
                'payment_id' => strtoupper(Str::random(16)),
                'pgw_reference_id' => $_GET['pidx'] ?? '',
                'pidx' => $_GET['pidx'] ?? '',
                'transaction_id' => $_GET['transaction_id'] ?? '',
                'total_booking_amount' => $totalAmt,
                'currency' => $outbound_flight->Currency ?? '',
                'payment_date' => date('Y-m-d'),
                'payment_status' => $payment_status,
                'payment_type' => $payment_type
            ]);

            // if($_GET['pidx'] == $_GET['transaction_id']){
            //     return redirect()->route('domesticflights.ticket.error', $booking->booking_code);
            // }

            $this->domesticFlightInfo($booking, $request_data, $reservation_data, $outbound_flight, $inbound_flight);
            $this->passengerData($booking, $payment_status);

            if ($payment_type == 'Khalti') {
                if (!checkKhaltiPayment($_GET['pidx'])) {
                    $payment->update([
                        'payment_status' => 'Failed',
                    ]);
                    Mail::to(['info@flightsgyani.com'])->send(new MailDomesticFlightBooking($booking->id, 'admin', 'failed'));

                    return redirect()->route('domesticflights.ticket.error', $booking->booking_code);
                }
            }

            if ($payment_status == 'Completed' || $is_office_staff) {
                $tickets = SoapHelper::issueTicket($outbound_flight->FlightId ?? '', $inbound_flight->FlightId ?? '');
                $issueTicket = $this->ticketStore($tickets, $booking);
                if ($issueTicket) {
                    $booking->update(['ticket_status' => 'Issued']);
                    Mail::to($booking->emergency_contact_email)->send(new MailDomesticFlightBooking($booking->id, 'user'));
                    Mail::to(['info@flightsgyani.com'])->send(new MailDomesticFlightBooking($booking->id, 'admin'));

                    return redirect()->route('domesticflights.booking.complete', $booking->booking_code);
                }
            }
            return redirect()->route('domesticflights.ticket.error', $booking->booking_code);
        } else {
            return redirect()->route('frontend.index');
        }
    }

    public function bookingComplete($booking_code = '')
    {
        domesticSessionClear();
        return view('front.domestic.success', compact('booking_code'));
    }

    public function ticketDownload($booking_code)
    {
        $booking = DomesticFlightBooking::where('booking_code', $booking_code)->first();
        if ($booking->user_id) {
            $ticketDetails = CompanyTicketDetail::where('user_id', $booking->user_id)->first();
        } else {
            $ticketDetails = null;
        }
        // for airlines image and name
        $airlinesData = DomesticAirline::oldest('order')->get();
        $airData = [];
        $airDataName = [];
        foreach ($airlinesData as $key => $air) {
            $airData[$air->code] = $air->image;
            $airDataName[$air->code] = $air->name;
        }

        $pdf = Pdf::loadView('front.domestic.ticket', compact('booking', 'airData', 'ticketDetails'));
        return $pdf->download('flightsgyani-ticket.pdf');
    }

    public function domesticFlightInfo($booking, $request_data, $reservation_data, $outbound_flight, $inbound_flight)
    {
        $pnr = [];
        if ($request_data['type'] == 'O') {
            $pnr = $reservation_data['PNRDetail'];
        }
        if ($request_data['type'] == 'R') {
            $pnr = $reservation_data['PNRDetail'][0];
        }

        DomesticFlightInfo::create([
            'booking_id' => $booking->id ?? null,
            'flight_type' => 'O',
            'pnr_no' => $pnr['PNRNO'] ?? '',
            'airline' => $outbound_flight->Airline ?? '',
            'flight_date' => date('Y-m-d', strtotime($outbound_flight->FlightDate ?? '')),
            'flight_no' => $outbound_flight->FlightNo ?? '',
            'flight_id' => $outbound_flight->FlightId ?? '',
            'departure' => $outbound_flight->Departure ?? '',
            'departure_time' => $outbound_flight->DepartureTime ?? null,
            'arrival' => $outbound_flight->Arrival ?? '',
            'arrival_time' => $outbound_flight->ArrivalTime ?? null,
            'aircraft_type' => $outbound_flight->AircraftType ?? '',
            'adult' => $outbound_flight->Adult ?? null,
            'child' => $outbound_flight->Child ?? null,
            'infant' => $outbound_flight->Infant ?? null,
            'flight_class_code' => $outbound_flight->FlightClassCode ?? '',
            'currency' => $outbound_flight->Currency ?? '',
            'adult_fare' => $outbound_flight->AdultFare ?? null,
            'child_fare' => $outbound_flight->ChildFare ?? null,
            'infant_fare' => $outbound_flight->InfantFare ?? null,
            'res_fare' => $outbound_flight->ResFare ?? null,
            'fuel_surcharge' => $outbound_flight->FuelSurcharge ?? null,
            'tax' => $outbound_flight->Tax ?? null,
            'refundable' => $outbound_flight->Refundable ?? '',
            'free_baggage' => $outbound_flight->FreeBaggage ?? '',
            'agency_commission' => $outbound_flight->AgencyCommission ?? null,
            'child_commission' => $outbound_flight->ChildCommission ?? null,
            'calling_station_id' => $outbound_flight->CallingStationId ?? '',
            'calling_station' => $outbound_flight->CallingStation ?? '',
            'status' => $pnr['ReservationStatus'] ?? ''
        ]);

        if ($request_data['type'] == 'R') {
            $pnr1 = $reservation_data['PNRDetail'][1];

            DomesticFlightInfo::create([
                'booking_id' => $booking->id ?? null,
                'flight_type' => 'I',
                'pnr_no' => $pnr1['PNRNO'] ?? '',
                'airline' => $inbound_flight->Airline ?? '',
                'flight_date' => date('Y-m-d', strtotime($inbound_flight->FlightDate ?? '')),
                'flight_no' => $inbound_flight->FlightNo ?? '',
                'flight_id' => $inbound_flight->FlightId ?? '',
                'departure' => $inbound_flight->Departure ?? '',
                'departure_time' => $inbound_flight->DepartureTime ?? null,
                'arrival' => $inbound_flight->Arrival ?? '',
                'arrival_time' => $inbound_flight->ArrivalTime ?? null,
                'aircraft_type' => $inbound_flight->AircraftType ?? '',
                'adult' => $inbound_flight->Adult ?? null,
                'child' => $inbound_flight->Child ?? null,
                'infant' => $inbound_flight->Infant ?? null,
                'flight_class_code' => $inbound_flight->FlightClassCode ?? '',
                'currency' => $inbound_flight->Currency ?? '',
                'adult_fare' => $inbound_flight->AdultFare ?? null,
                'child_fare' => $inbound_flight->ChildFare ?? null,
                'infant_fare' => $inbound_flight->InfantFare ?? null,
                'res_fare' => $inbound_flight->ResFare ?? null,
                'fuel_surcharge' => $inbound_flight->FuelSurcharge ?? null,
                'tax' => $inbound_flight->Tax ?? null,
                'refundable' => $inbound_flight->Refundable ?? '',
                'free_baggage' => $inbound_flight->FreeBaggage ?? '',
                'agency_commission' => $inbound_flight->AgencyCommission ?? null,
                'child_commission' => $inbound_flight->ChildCommission ?? null,
                'calling_station_id' => $inbound_flight->CallingStationId ?? '',
                'calling_station' => $inbound_flight->CallingStation ?? '',
                'status' => $pnr1['ReservationStatus'] ?? ''
            ]);
        }
    }

    public function passengerData($booking, $status)
    {
        $passengers = SoapHelper::passengerDetailsFormat();
        foreach ($passengers->passengerDetails as $key => $passenger) {
            DomesticPassenger::create([
                'booking_id' => $booking->id ?? null,
                'title' => $passenger->title ?? '',
                'first_name' => $passenger->first_name ?? '',
                'last_name' => $passenger->last_name ?? '',
                'pax_type' => $passenger->type ?? '',
                'gender' => $passenger->gender ?? '',
                'nationality' => $passenger->nationality ?? '',
                'status' => $status ?? ''
            ]);
        }
    }

    public function ticketStore($tickets, $booking)
    {
        $details = (array) $tickets;

        if (!isset($details['Passenger'])) {
            return false;
        }

        $validDetails = $details['Passenger'] ?? '';

        if (!is_array($validDetails)) {
            $validDetails = array($validDetails);
        }

        foreach ($validDetails as $ticket) {
            DomesticFlightTicket::create([
                'booking_id' => $booking->id ?? null,
                'airline' => $ticket->Airline ?? '',
                'pnr_no' => $ticket->PnrNo ?? '',
                'title' => $ticket->Title ?? '',
                'gender' => $ticket->Gender ?? '',
                'first_name' => $ticket->FirstName ?? '',
                'last_name' => $ticket->LastName ?? '',
                'pax_type' => $ticket->PaxType ?? '',
                'nationality' => $ticket->Nationality ?? '',
                'issue_from' => $ticket->IssueFrom ?? '',
                'agency_name' => $ticket->AgencyName ?? '',
                'issue_date' => date('Y-m-d', strtotime($ticket->IssueDate ?? '')),
                'issue_by' => $ticket->IssueBy ?? '',
                'flight_no' => $ticket->FlightNo ?? '',
                'flight_date' => date('Y-m-d', strtotime($ticket->FlightDate ?? '')),
                'departure' => $ticket->Departure ?? '',
                'flight_time' => $ticket->FlightTime ?? null,
                'ticket_no' => $ticket->TicketNo ?? '',
                'arrival' => $ticket->Arrival ?? '',
                'arrival_time' => $ticket->ArrivalTime ?? null,
                'sector' => $ticket->Sector ?? '',
                'class_code' => $ticket->ClassCode ?? '',
                'currency' => $ticket->Currency ?? '',
                'fare' => $ticket->Fare ?? null,
                'surcharge' => $ticket->Surcharge ?? null,
                'tax_currency' => $ticket->TaxCurrency ?? '',
                'tax' => $ticket->Tax ?? null,
                'commission_amount' => $ticket->CommissionAmount ?? null,
                'refundable' => $ticket->Refundable ?? '',
                'invoice' => $ticket->Invoice ?? '',
                'reporting_time' => $ticket->ReportingTime ?? '',
                'free_baggage' => $ticket->FreeBaggage ?? '',
                'status' => 'Success'
            ]);
        }
        return true;
    }

    public function error($booking_code = '')
    {
        domesticSessionClear(); //clears all session
        return view('front.domestic.error', compact('booking_code'));
    }

    public function getRequestData($request)
    {
        $type = 'O';
        if ($request->type == 'one-way') {
            $type = 'O';
        } else {
            $type = 'R';
        }
        if (!$request->returnDate) {
            $type = 'O';
        }

        $data = [
            'from' => $request->from,
            'to'  => $request->to,
            'flightDate' => date('d-m-Y', strtotime($request->flightDate)),
            'type' => $type,
            'returnDate' => $request->returnDate ? date('d-m-Y', strtotime($request->returnDate)) : '',
            'nationality' => $request->nationality ?? 'NP',
            'adult' => $request->adult ?? 1,
            'child' => $request->child ?? 0
        ];

        DomesticSearchFlight::create([
            'departure' => $request->from,
            'arrival' => $request->to,
            'departure_date' => date('Y-m-d', strtotime($request->flightDate)),
            'return_date' => $request->returnDate ? date('Y-m-d', strtotime($request->returnDate)) : null,
            'type' => $type,
            'adults' => $request->adult ?? 1,
            'childs' => $request->child ?? 0,
            'nationality' => $request->nationality ?? 'NP',
            'user_id' => Auth::user()->id ?? 0,
        ]);
        Session::put('request_data', $data);

        return $data;
    }

    public function getAllFlights($data)
    {
        $flights = SoapHelper::checkFlightStatus($data);
        $flights = json_decode(json_encode($flights), true); // Convert to array

        $this->discount = getDomesticFlightDiscounts(); // get all flights discount

        // Normalize Outbound Flights
        if (!empty($flights['Outbound']) && array_key_exists('Availability', $flights['Outbound'])) {
            if (array_keys($flights['Outbound']['Availability']) !== range(0, count($flights['Outbound']['Availability']) - 1)) {
                $flights['Outbound']['Availability'] = [$flights['Outbound']['Availability']];
            }

            // Calculate total amount for outbound flights and sort them
            $flights['Outbound']['Availability'] = collect($flights['Outbound']['Availability'])
                ->filter(function ($flight) {
                    $departureDateTimeString = $flight['FlightDate'] . ' ' . $flight['DepartureTime'];
                    $departureDateTime = Carbon::createFromFormat('d-M-Y H:i', $departureDateTimeString);
                    $currentDateTime = Carbon::now();
                    return $departureDateTime->isAfter($currentDateTime);
                })
                ->map(function ($flight) {
                    return [
                        ...$flight,
                        'Discount' => ($this->discount[$flight['Airline']] ?? 0) * ($flight['Adult'] + $flight['Child']),
                        'TotalAmount' => domesticFlightTotalCalculation(
                            $flight['AdultFare'] ?? 0,
                            $flight['Adult'] ?? 0,
                            $flight['ChildFare'] ?? 0,
                            $flight['Child'] ?? 0,
                            $flight['FuelSurcharge'] ?? 0,
                            $flight['Tax'] ?? 0,
                            $flight['AgencyCommission'] ?? 0,
                            $flight['ChildCommission'] ?? 0
                        ),
                        'sortAmount' => domesticFlightTotalCalculation(
                            $flight['AdultFare'] ?? 0,
                            $flight['Adult'] ?? 0,
                            $flight['ChildFare'] ?? 0,
                            $flight['Child'] ?? 0,
                            $flight['FuelSurcharge'] ?? 0,
                            $flight['Tax'] ?? 0,
                            $flight['AgencyCommission'] ?? 0,
                            $flight['ChildCommission'] ?? 0
                        ) - (($this->discount[$flight['Airline']] ?? 0) * ($flight['Adult'] + $flight['Child'])),
                    ];
                })
                ->sortBy('sortAmount')
                ->values()
                ->toArray();
        }

        // Normalize Inbound Flights
        if (!empty($flights['Inbound']) && array_key_exists('Availability', $flights['Inbound'])) {
            if (array_keys($flights['Inbound']['Availability']) !== range(0, count($flights['Inbound']['Availability']) - 1)) {
                $flights['Inbound']['Availability'] = [$flights['Inbound']['Availability']];
            }

            // Calculate total amount for inbound flights and sort them
            $flights['Inbound']['Availability'] = collect($flights['Inbound']['Availability'])
                ->filter(function ($flight) {
                    $departureDateTimeString = $flight['FlightDate'] . ' ' . $flight['DepartureTime'];
                    $departureDateTime = Carbon::createFromFormat('d-M-Y H:i', $departureDateTimeString);
                    $currentDateTime = Carbon::now();
                    return $departureDateTime->isAfter($currentDateTime);
                })
                ->map(function ($flight) {
                    return [
                        ...$flight,
                        'Discount' => ($this->discount[$flight['Airline']] ?? 0) * ($flight['Adult'] + $flight['Child']),
                        'TotalAmount' => domesticFlightTotalCalculation(
                            $flight['AdultFare'] ?? 0,
                            $flight['Adult'] ?? 0,
                            $flight['ChildFare'] ?? 0,
                            $flight['Child'] ?? 0,
                            $flight['FuelSurcharge'] ?? 0,
                            $flight['Tax'] ?? 0,
                            $flight['AgencyCommission'] ?? 0,
                            $flight['ChildCommission'] ?? 0
                        ),
                        'sortAmount' => domesticFlightTotalCalculation(
                            $flight['AdultFare'] ?? 0,
                            $flight['Adult'] ?? 0,
                            $flight['ChildFare'] ?? 0,
                            $flight['Child'] ?? 0,
                            $flight['FuelSurcharge'] ?? 0,
                            $flight['Tax'] ?? 0,
                            $flight['AgencyCommission'] ?? 0,
                            $flight['ChildCommission'] ?? 0
                        ) - (($this->discount[$flight['Airline']] ?? 0) * ($flight['Adult'] + $flight['Child'])),
                    ];
                })
                ->sortBy('sortAmount')
                ->values()
                ->toArray();
        }

        return $flights;
    }

    public function checkAgentBalance()
    {
        if (Auth::check()) {
            if (Auth::user()->user_type == 'AGENT') {
                $summary = totalDomesticAmount();

                $amt = $summary['totalAmount'] ?? 0;
                $remainingBalance = 0;
                if ($summary['Currency'] == 'NPR') {
                    $remainingBalance = remainingBalance(Auth::user()->id, 'NPR');
                }
                if ($summary['Currency'] == 'USD') {
                    $remainingBalance = remainingBalance(Auth::user()->id, 'USD');
                }

                if ($remainingBalance >= $amt) {
                    return 'success';
                } else {
                    return 'insufficient-balance';
                }
            }
        }
        return 'skip';
    }
}
