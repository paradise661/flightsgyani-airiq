<?php

namespace App\Http\Controllers\Domestic\Admin;

use App\Http\Controllers\Controller;
use App\Models\Domestic\DomesticFlightBooking;
use Illuminate\Http\Request;

class DomesticFlightController extends Controller
{
    public function domesticFlightBookings()
    {
        $bookings = DomesticFlightBooking::orderBy('created_at', 'DESC')->get();
        return view('admin.domestic.booking.index', compact('bookings'));
    }

    public function domesticFlightBookingsDetails(DomesticFlightBooking $booking)
    {
        return view('admin.domestic.booking.show', compact('booking'));
    }
}
