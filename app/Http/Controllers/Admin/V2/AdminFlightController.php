<?php

namespace App\Http\Controllers\Admin\V2;

use App\Http\Controllers\Controller;
use App\Models\InternationalFlight\FlightBooking;
use App\Models\InternationalFlight\SearchFlight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class AdminFlightController extends Controller
{
    public function flightBookings()
    {
        abort_unless(Gate::allows('view booking'), 403);
        activityLog('viewed international flight bookings');

        return view('admin.v2.intlflights.bookings.index');
    }

    public function viewFlightBooking($code)
    {
        abort_unless(Gate::allows('view booking'), 403);

        activityLog('viewed international flight booking details of code: ' . $code);

        $booking = FlightBooking::with(['ofSearch', 'bookingDetails', 'payments', 'bookedBy', 'getTickets'])->where('booking_code', $code)->first();
        return view('admin.v2.intlflights.bookings.show', ['booking' => $booking]);
    }

    public function flightSearchLog()
    {
        abort_unless(Gate::allows('view searchlog'), 403);
        activityLog('viewed international search logs');

        return view('admin.v2.intlflights.search.index');
    }

    public function viewLogFiles($id)
    {
        $search = SearchFlight::findorfail($id);
        $files = Storage::disk('public')->allFiles('/international/' . $id);
        activityLog('viewed international search log');

        return view('admin.v2.intlflights.search.logfiles', ['files' => $files]);
    }

    public function deleteSearch(Request $request)
    {
        abort_unless(Gate::allows('delete searchlog'), 403);

        $search = SearchFlight::with('haveBooking')->findorfail($request->id);
        if ($search->haveBooking->count() > 0) {
            $bookingCode = '';
            foreach ($search->haveBooking as $booking) {
                $bookingCode .= $booking->booking_code . '  ';
            }
            return redirect()->back()->with('warning', 'couldn\'nt be deleted. Search associated with booking of ' . $bookingCode . '. Delete booking first.');
        } else {
            Storage::deleteDirectory('public/international/' . $search->id);
            $search->delete();
            activityLog('deleted international search log');

            return redirect()->back()->with('success', 'Search data deleted successfully.');
        }
    }

    public function clearSearchLog()
    {
        abort_unless(Gate::allows('clear searchlog'), 403);

        set_time_limit(0);
        $searches = SearchFlight::with('haveBooking')->latest()->get();
        foreach ($searches as $search) {
            if ($search->haveBooking->count() > 0) {
                continue;
            } else {
                Storage::deleteDirectory('public/international/' . $search->id);
                $search->delete();
            }
        }
        activityLog('deleted all international search log');

        return redirect()->back()->with('success', 'Search associated with bookings couldn\'t be deleted.');
    }

    public function groupBookings()
    {
        $requests = GroupFlightBooking::with(['requestedBy', 'confirmedBy'])->latest()->get();
        //        dd($requests);
        return view('admin.flights.bookings.grouprequest', ['requests' => $requests]);
    }

    public function viewGroupBookingRequest($data)
    {
        $request = GroupFlightBooking::findorfail(decrypt($data));
        return view('back.flights.viewbookingrequest', ['request' => $request]);
    }

    public function deleteGroupBookingRequest($data)
    {
        try {
            $request = GroupFlightBooking::findorfail(decrypt($data));
            $request->delete();
            return redirect()->back()->with('success', 'Booking request deleted successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('warning', $e->getMessage());
        }
    }

    public function updateGroupBookingRequest($action, $id)
    {
        $bookingRequest = GroupFlightBooking::findorfail(decrypt($id));
        if ($action == 'cancel') {
            $bookingRequest->update([
                'status' => 'Canceled'
            ]);
        }
        if ($action == 'complete') {
            $bookingRequest->update([
                'status' => 'Completed'
            ]);
        }
        return redirect()->back()->with('success', 'Booking Request updated successfully.');
    }


    //new api for ticket issue

    public function getFlightTickets($code)
    {
        $booking = FlightBooking::where('booking_code', $code)->first();
        if (!$booking) {
            return redirect()->back()->with('warning', 'Error getting booking details.');
        }
        if (!isset($booking->pnr_id)) {
            return redirect()->back()->with('warning', 'PNR not generated.');
        }
        if (isset($booking->ticket_details) && !$booking->ticket_cancel) {
            return redirect()->back()->with('warning', 'Ticket already issued.');
        }
        session()->put('flight_search', $booking->search_flight_id);

        $token = $this->callCreateSession();


        session()->put('sabre_token', $token);

        $tickets = $this->callTicketIssue($code);
        if (!$tickets) {
            return redirect()->back()->with('warning', 'Ticket couldn\'nt be generated.');
        }
        $booking->update([
            'ticket_status' => true,
            'ticket_details' => json_encode($tickets)
        ]);
        $c = 2;
        foreach ($tickets as $ticket) {
            $ticketData = new FlightTicket();
            $ticketData->flight_booking_id = $booking->id;
            $ticketData->first_name = $ticket['fname'];
            $ticketData->last_name = $ticket['lname'];
            //            $ticketData->ticket_reference = $ticket['lname'];
            $ticketData->ticket_number = $ticket['number'];
            $ticketData->rph = $c;
            $ticketData->status = true;
            $ticketData->save();
            $c++;
        }
        return redirect()->back()->with('success', 'Ticket issued successfully.');
    }


    public function generatePnr($code)
    {

        $booking = FlightBooking::where('booking_code', $code)->first();
        if (!$booking) {
            return false;
        }
        if (isset($booking->pnr_id)) {
            return redirect()->back()->with('warning', 'PNR has been already generated.');
        }
        try {
            session()->put('flight_search', $booking->search_flight_id);
            $token = $this->callCreateSession();
            session()->put('sabre_token', $token);

            $airline = $booking->airline;
            $contact = json_decode($booking->contact_details, true);
            $adults = $booking->bookingDetails()->where('pax_type', 'ADT')->get();
            $childs = $booking->bookingDetails()->where('pax_type', 'CHLD')->get();
            $infants = $booking->bookingDetails()->where('pax_type', 'INFT')->get();
            $enhanceAirbookResponse = $this->bookFlight($booking);
            $response = $this->callPassengerDetail($airline, $contact, $adults, $childs, $infants);

            session()->forget('flight_search');
            session()->forget('sabre_token');
            if ($response) {
                $booking->update([
                    'pnr_id' => $response['pnr'],
                    'org_pricing' => json_encode($response['pricing'])
                ]);
                return redirect()->back()->with('success', 'PNR generated successfully.');
            } else {
                return redirect()->back()->with('warning', 'PNR could not be generated.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', $e->getCode());
        }
    }

    public function bookFlight($bookingCode)
    {

        $flight = decrypt($bookingCode);
        session()->put('flight', $bookingCode);

        $response = $this->callAirBook($flight['flight']);
        if (!$response) {
            session()->put('flight_book', false);
            $this->callIgnoreTransaction();
        } else {
            session()->put('flight_book', true);
        }

        return redirect()->back();
    }

    public function voidPNR($code)
    {
        //        dd(session()->get('sabre_token'));
        $booking = FlightBooking::where('booking_code', $code)->first();
        if (!$booking) {
            return redirect()->back()->with('warning', 'Could not get booking details.');
        }
        if (!isset($booking->pnr_id)) {
            return redirect()->back()->with('warning', 'PNR not generated.');
        }
        if ($booking->pnr_void) {
            return redirect()->back()->with('warning', 'PNR already voided.');
        }
        try {
            $pnr = $booking->pnr_id;
            session()->put('flight_search', $booking->search_flight_id);
            $token = $this->callCreateSession();
            session()->put('sabre_token', $token);

            $reservationStatus = $this->openPnr($pnr);

            if (!$reservationStatus) {
                return redirect()->back()->with('warning', 'PNR could not be opened');
            }

            $voidStatus = $this->callVoidPnr($pnr);
            if (!$voidStatus) {
                return redirect()->back()->with('error', 'Error in void operation.');
            }


            $transactionStatus = $this->callEndTransaction();
            if (!$transactionStatus) {
                return redirect()->back()->with('error', 'Error in transaction end.');
            }

            $booking->update([
                'pnr_void' => 1
            ]);

            session()->forget('sabre_token');
            session()->forget('flight_search');

            return redirect()->back()->with('success', 'PNR void successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', $e->getCode());
        }
    }

    public function voidTicket($code)
    {

        $booking = FlightBooking::where('booking_code', $code)->first();
        if (!$booking) {
            return redirect()->back()->with('warning', 'Error getting booking details.');
        }
        if (!isset($booking->pnr_id)) {
            return redirect()->back()->with('warning', 'No PNR Found.');
        }
        if (!$booking->ticket_status) {
            return redirect()->back()->with('warning', 'Ticket not generated.');
        }
        if ($booking->ticket_cancel) {
            return redirect()->back()->with('warning', 'Ticket already canceled.Open PNR and update.');
        }
        try {
            session()->put('flight_search', $booking->search_flight_id);
            $token = $this->callCreateSession();
            session()->put('sabre_token', $token);
            $total_void_count = $booking->ticket_void_count;
            $pnr = $booking->pnr_id;
            $count = $booking->ticket_void_count + 2;
            $c = 1;

            foreach (json_decode($booking->ticket_details, true) as $ticket) {

                $pnrStatus = $this->openPnr($pnr);
                if (!$pnrStatus) {
                    return redirect()->back()->with('warning', 'Pnr could not be opened.');
                }

                $firstCallVoidStatus = $this->callVoidTicket($count);
                if (!$firstCallVoidStatus) {
                    return redirect()->back()->with('warning', 'Error on ' . $c . ' ticket void operation.');
                }
                $secondCallVoidStatus = $this->callVoidTicket($count);
                if (!$secondCallVoidStatus) {
                    return redirect()->back()->with('warning', 'Error on ' . $c . ' ticket void operation.');
                }

                $this->callEndTransaction();

                $this->callIgnoreTransaction();

                $count++;
                $c++;
            }
            $booking->update([
                'ticket_cancel' => true,
                'ticket_void_count' => $total_void_count + 1
            ]);
            return redirect()->back()->with('success', 'Ticket cancelled successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', $e->getCode());
        }
    }

    public function voidSingleTicket($data)
    {

        $ticket = FlightTicket::findorfail(decrypt($data));
        if (!$ticket->status) {
            return redirect()->back()->with('warning', 'This ticket can not be voided.');
        }
        try {
            $pnr = $ticket->ofBooking->pnr_id;

            $token = $this->callCreateSession();
            if (!$token) {
                return redirect()->back()->with('warning', 'Could not create session.Check your GDS credentials.');
            }
            session()->put('sabre_token', $token);
            session()->put('flight_search', $ticket->ofBooking->flight_search_id);
            $pnrStatus = $this->openPnr($pnr);
            if (!$pnrStatus) {
                return redirect()->back()->with('warning', 'PNR could not be opened.');
            }

            $firstVoidCallStatus = $this->callVoidTicket($ticket->rph);
            if (!$firstVoidCallStatus) {
                return redirect()->back()->with('warning', 'Error on first void call.');
            }

            $secondVoidCallStatus = $this->callVoidTicket($ticket->rph);
            if (!$secondVoidCallStatus) {
                return redirect()->back()->with('warning', 'Error on second void call.');
            }
            $ticket->update([
                'status' => false,
                'void_date' => Carbon::now()->toDateTimeString(),
                'voided_by' => Auth::user()->id
            ]);
            return redirect()->back()->with('success', 'Ticket void successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', $e->getCode());
        }
    }

    public function getPnrDetails(Request $request)
    {
        $request->validate([
            'code' => 'required|min:6|max:6'
        ]);
        $token = $this->callCreateSession();
        if (!$token) {
            return redirect()->back()->with('warning', 'Could not get token from GDS.');
        }
        session()->put('sabre_token', $token);
    }

    public function dailySalesReport()
    {
        //        dd('hello');
        return view('back.flights.sales.dailysales');
    }

    public function getSalesReport(Request $request)
    {
        $request->validate([
            'date' => 'required|date|before:tomorrow'
        ]);

        $token = $this->callCreateSession();
        session()->put('sabre_token', $token);

        $reports = $this->callDailySalesSummary($request->date);
        $date = Carbon::parse($request->date)->toDateString();
        if (!$reports) {
            return redirect()->back()->with('warning', 'Error getting reports from server.');
        }

        foreach ($reports as $report) {
            $flightReport = DailyFlightReport::where('ticket', $report['ticket'])->where('date', $date)->first();
            if (!$flightReport) {
                $dailyData = new DailyFlightReport();
                $dailyData->date = $report['date'];
                $dailyData->pnr = $report['pnr'];
                $dailyData->time = $report['time'];
                $dailyData->amount = $report['totalAmount'];
                $dailyData->currency = $report['currency'];
                $dailyData->pax = $report['pax'];
                $dailyData->airlines = $report['airline'];
                $dailyData->commission = $report['commissionAmount'];
                $dailyData->commission_percent = $report['commissionPercent'];
                $dailyData->ticket = $report['ticket'];
                $dailyData->save();
            }
        }

        return view('back.flights.sales.report', ['reports' => $reports, 'date' => $request->date]);
    }

    public function saveSalesReport(Request $request)
    {
        $request->validate([
            'date' => 'required|date|before:today'
        ]);
        try {
            $date = Carbon::parse($request->date)->format('Y-m-d');
            $token = $this->callCreateSession();
            session()->put('sabre_token', $token);
            $reports = $this->callDailySalesSummary($request->date);
            if (!$reports) {
                return redirect()->back()->with('warning', 'Error in operations.');
            }
            //        dd($reports);
            foreach ($reports as $report) {
                $flightReport = DailyFlightReport::where('ticket', $report['ticket'])->where('date', $date)->first();
                if (!$flightReport) {
                    $dailyData = new DailyFlightReport();
                    $dailyData->date = $report['date'];
                    $dailyData->pnr = $report['pnr'];
                    $dailyData->time = $report['time'];
                    $dailyData->amount = $report['totalAmount'];
                    $dailyData->currency = $report['currency'];
                    $dailyData->pax = $report['pax'];
                    $dailyData->airlines = $report['airline'];
                    $dailyData->commission = $report['commissionAmount'];
                    $dailyData->commission_percent = $report['commissionPercent'];
                    $dailyData->ticket = $report['ticket'];
                    $dailyData->save();
                }
            }

            return redirect()->back()->with('success', 'Records updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', $e->getMessage());
        }
    }

    public function deleteFlightBooking($code)
    {
        abort_unless(Gate::allows('delete booking'), 403);

        $booking = FlightBooking::where('booking_code', $code)->first();
        if (!$booking) {
            abort(404);
        }

        if ($booking->payment_status) {
            return redirect()->back()->with('warning', 'Booking couldn\'t be deleted');
        }

        $booking->delete();
        Storage::disk('public')->deleteDirectory('international/' . $booking->search_flight_id);
        activityLog('deleted international flight booking details of code: ' . $code);

        return redirect()->back()->with('success', 'Booking deleted');
    }
}
