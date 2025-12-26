<?php

namespace App\Http\Controllers;

use App\Models\InternationalFlight\{FlightBooking, FlightBookingDetail};
use App\Service\Sabre\BSPCommissionService;
use App\Service\Sabre\Request\{AirTicketIssueRQ,
    BargainFindermaxRQ,
    CheckPnrDetails,
    CreateSession,
    DailySalesSummaryRQ,
    DesignatePrinter1RQ,
    DesignatePrinterRQ,
    EndTransactionRQ,
    EnhancedAirBookRQ,
    FareRuleRQ,
    GetReservationRQ,
    IgnoreTransactionRQ,
    OpenPnrRQ,
    PassengerDetailsRQ,
    SalesReportRQ,
    SessionCloseRQ,
    TicketIssueRQ,
    VoidPnrRQ,
    VoidTicketRQ};

abstract class FlightBaseController extends Controller
{

    public function callCreateSession()
    {
//        if(session()->has('sabre_token')){
//            return session()->get('sabre_token');
//        }
        $session = new CreateSession();
        $token = $session->doRequest();
//        $token = $session->formatResponse('jhvj');
        return $token;
    }

    public function callBargainFinder()
    {
        $bfx = new BargainFindermaxRQ();
        $flights = $bfx->doRequest();
        return $flights;
    }

    public function callFareRule($code, $date)
    {
        $rule = new FareRuleRQ();
        $response = $rule->doRequest($code, $date);
        return $response;
    }


    public function callAirBook($flight)
    {
        if (file_exists('../storage/app/public/international/' . session()->get('flight_search') . '/EnhancedAirBookRS.txt')) {
            $this->callIgnoreTransaction();
            $book = new EnhancedAirBookRQ();
            $response = $book->doRequest($flight);
            return $response;
        } else {
            $book = new EnhancedAirBookRQ();
            $response = $book->doRequest($flight);
            return $response;
        }
    }

    public function callIgnoreTransaction()
    {
        $trans = new IgnoreTransactionRQ();
        $status = $trans->doRequest();
        return $status;
    }

    public function callPassengerDetail($airline, $contact, $adults, $childs, $infants)
    {
//        dd($childs);
        if (file_exists('../storage/app/public/international/' . session()->get('flight_search') . '/PassengerDetailsRS.txt')) {
            $file = '../storage/app/public/international/' . session()->get('flight_search') . '/PassengerDetailsRS.txt';
            $response = file_get_contents($file);
            $passenger = new PassengerDetailsRQ();
            $status = $passenger->formatResponse($response);
            if (!$status) {
                $this->callIgnoreTransaction();
                $response = $passenger->doRequest($airline, $contact, $adults, $childs, $infants);
                return $response;
            } else {
                return $status;
            }
        } else {
            $passenger = new PassengerDetailsRQ();
            $response = $passenger->doRequest($airline, $contact, $adults, $childs, $infants);
            return $response;
        }

    }

    public function openPnr($pnr)
    {
        $openReservation = new OpenPnrRQ();
        $reservationStatus = $openReservation->doRequest($pnr);
        if (!$reservationStatus) {
            return false;
        }
        return true;
    }

    public function callFirstPrinter()
    {

        if (file_exists('../storage/app/public/international/' . session()->get('flight_search') . '/DesignatePrinterRS.txt')) {
            $file = '../storage/app/public/international/' . session()->get('flight_search') . '/DesignatePrinterRS.txt';
            $response = file_get_contents($file);

//            dd($response);
            $printer = new DesignatePrinterRQ();
            $status = $printer->formatResponse($response);
            if (!$status) {
                $printer = new DesignatePrinterRQ();
                $pstatus = $printer->doRequest();
                return $pstatus;
            } else {
                return $status;
            }
        } else {
            $printer = new DesignatePrinterRQ();
            $status = $printer->doRequest();
            return $status;
        }

    }

    public function callSecondPrinter()
    {
        if (file_exists('../storage/app/public/international/' . session()->get('flight_search') . '/DesignatePrinter1RS.txt')) {
            $file = '../storage/app/public/international/' . session()->get('flight_search') . '/DesignatePrinter1RS.txt';
            $response = file_get_contents($file);

            $printer = new DesignatePrinter1RQ();
            $status = $printer->formatResponse($response);
            if (!$status) {
                $printer = new DesignatePrinter1RQ();
                $pstatus = $printer->doRequest();
                return $pstatus;
            } else {
                return $status;
            }
        } else {
            $printer = new DesignatePrinter1RQ();
            $status = $printer->doRequest();
            return $status;
        }
    }

    public function callAirTicketIssue($code)
    {
        $booking = FlightBooking::where('booking_code', $code)->first();
        if (!$code) {
            return redirect()->back()->with('warning', 'Error getting booking data.');
        }
        $airline = $booking->airline;
        $adults = FlightBookingDetail::where(['flight_booking_id' => $booking->id, 'pax_type' => 'ADT'])->get();
        $childs = FlightBookingDetail::where(['flight_booking_id' => $booking->id, 'pax_type' => 'CHLD'])->get();
        $infants = FlightBookingDetail::where(['flight_booking_id' => $booking->id, 'pax_type' => 'INFT'])->get();
        if (file_exists('../storage/app/public/international/' . session()->get('flight_search') . '/AirTicketIssueRS.txt')) {
            $file = '../storage/app/public/international/' . session()->get('flight_search') . '/AirTicketIssueRS.txt';
            $response = file_get_contents($file);
//            dd($response);
            $tickets = new AirTicketIssueRQ();
            $ticket_status = $tickets->formatResponse($response);
            if (!$ticket_status) {
                $tickets = new AirTicketIssueRQ();
                $commissionService = new BSPCommissionService();
                $commission = $commissionService->calculateCommission($booking);
                $ticket_status = $tickets->doRequest($airline, $adults, $childs, $infants, $commission);
                return $ticket_status;
            } else {
                return $ticket_status;
            }
        } else {
            $commissionService = new BSPCommissionService();
            $commission = $commissionService->calculateCommission($booking);
            $tickets = new AirTicketIssueRQ();
//            dd($airline);
            $ticket_status = $tickets->doRequest($airline, $adults, $childs, $infants, $commission);
            return $ticket_status;
        }
    }

    public function callTicketIssue($code)
    {
        $booking = FlightBooking::where('booking_code', $code)->first();
        if (!$code) {
            return redirect()->back()->with('warning', 'Error getting booking data.');
        }
        $ticket = new TicketIssueRQ();
        $response = $ticket->doRequest($booking);
        return $response;
    }

    public function callGetReservation($type, $pnr)
    {
        $reserve = new GetReservationRQ();
        $response = $reserve->doRequest($type, $pnr);
        return $response;
    }

    public function callSessionClose()
    {
        $close = new SessionCloseRQ();
        $response = $close->doRequest();
        return $response;
    }

    public function callVoidPnr($pnr)
    {
        $void = new VoidPnrRQ();
        $status = $void->doRequest();

        return $status;
    }

    public function callEndTransaction()
    {
        $transaction = new EndTransactionRQ();
        $transactionStatus = $transaction->doRequest();

        return $transactionStatus;
    }

    public function callVoidTicket($ticket)
    {
        $voidTicket = new VoidTicketRQ();
        $ticketStatus = $voidTicket->doRequest($ticket);
        return $ticketStatus;
    }

    public function callCheckPnrDetails($pnr)
    {
        $pnrDetails = new CheckPnrDetails();
        $details = $pnrDetails->doRequest($pnr);
        return $details;
    }

    public function callDailySalesReport($date)
    {
        $salesReport = new SalesReportRQ();
        $report = $salesReport->doRequest($date);
        return $report;
    }

    public function callDailySalesSummary($date)
    {
        $salesSummary = new DailySalesSummaryRQ();
        $report = $salesSummary->doRequest($date);
        return $report;
    }
}
