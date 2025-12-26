<?php

namespace App\Http\Controllers\Admin\V2;

use App\Http\Controllers\Controller;
use App\Models\Domestic\DomesticFlightBooking;
use App\Models\DomesticSearchFlight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DomesticFlightController extends Controller
{
    public function domesticFlightBookings()
    {
        abort_unless(Gate::allows('view domesticbooking'), 403);
        activityLog('viewed domestic flight bookings');

        return view('admin.v2.domestic.booking.index');
    }

    public function domesticFlightBookingsDetails(DomesticFlightBooking $booking)
    {
        abort_unless(Gate::allows('view domesticbooking'), 403);
        activityLog('viewed domestic flight booking details of code: ' . $booking->booking_code);

        return view('admin.v2.domestic.booking.show', compact('booking'));
    }

    public function domesticFlightSearch()
    {
        abort_unless(Gate::allows('view domesticsearchlog'), 403);
        activityLog('viewed domestic flight search logs');

        return view('admin.v2.search.index');
    }

    public function domesticFlightSearchDelete(DomesticSearchFlight $search)
    {
        abort_unless(Gate::allows('delete domesticsearchlog'), 403);

        $search->delete();
        activityLog('deleted domestic flight search log');

        return redirect()->back()->with('success', 'Search record deleted');
    }

    public function domesticFlightSearchDeleteAll()
    {
        abort_unless(Gate::allows('deleteall domesticsearchlog'), 403);

        DomesticSearchFlight::truncate();
        activityLog('deleted all domestic flight search logs');

        return redirect()->back()->with('success', 'Search record deleted');
    }
}
