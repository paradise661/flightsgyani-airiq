<?php

namespace App\Http\Controllers\B2b;

use App\Http\Controllers\Controller;
use App\Models\Domestic\DomesticFlightBooking;
use App\Models\InternationalFlight\FlightBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function domesticFlightBookings()
    {
        return view('b2b.domesticbookings.index');
    }

    public function domesticFlightBookingsDetails(DomesticFlightBooking $booking)
    {
        if (Auth::user()->id == $booking->user_id) {
            return view('b2b.domesticbookings.show', compact('booking'));
        } else {
            abort(404);
        }
    }

    public function flightBookings()
    {
        return view('b2b.internationalbookings.index');
    }

    public function viewFlightBooking($code)
    {
        $booking = FlightBooking::with(['ofSearch', 'bookingDetails', 'payments', 'bookedBy', 'getTickets'])->where('booking_code', $code)->first();
        if (Auth::user()->id == $booking->user_id) {
            return view('b2b.internationalbookings.show', ['booking' => $booking]);
        } else {
            abort(404);
        }
    }
}
