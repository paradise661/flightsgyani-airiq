<?php

namespace App\Http\Livewire\B2b;

use App\Models\InternationalFlight\FlightBooking;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Intlbooking extends Component
{
    use WithPagination;
    public $searchTerms = '';
    public $dateRange = '';
    public $limit = 10;
    public $paymentStatus = 'All';

    public function updatingSearchTerms()
    {
        $this->resetPage();
    }

    public function updatingDateRange()
    {
        $this->resetPage();
    }

    public function updatingPaymentStatus()
    {
        $this->resetPage();
    }

    // Apply filters when the user clicks the 'Filter' button
    public function applyFilters()
    {
        // This method triggers the re-rendering with applied filters
        $this->resetPage(); // Reset pagination on filter change
    }

    // Clear all filters
    public function clearFilters()
    {
        $this->searchTerms = '';
        $this->dateRange = '';
        $this->paymentStatus = 'All';
        $this->limit = 10;
        $this->resetPage(); // Reset pagination as well
    }

    public function render()
    {
        $searchTerms = '%' . $this->searchTerms . '%';
        // Parse the date range if it exists
        $dates = [];
        if (!empty($this->dateRange)) {
            $dates = explode(' to ', $this->dateRange);
        }

        $bookings = FlightBooking::latest()
            ->where('user_id', Auth::user()->id)
            ->where(function ($query) use ($searchTerms) {
                $query->where('booking_code', 'LIKE', $searchTerms)
                    ->orWhere('flights', 'LIKE', $searchTerms)
                    ->orWhere('contact_details', 'LIKE', $searchTerms)
                    ->orWhere('pnr_id', 'LIKE', $searchTerms)
                    ->orWhere('ticket_status', 'LIKE', $searchTerms)
                    ->orWhere('final_fare', 'LIKE', $searchTerms)
                    ->orWhere('airline', 'LIKE', $searchTerms)
                    ->orWhere('currency', 'LIKE', $searchTerms)
                    ->orWhere('flight_date', 'LIKE', $searchTerms);
            });
        // Apply date range filter if both dates are present
        if (count($dates) === 2) {
            $startDate = $dates[0];
            $endDate = \Carbon\Carbon::parse($dates[1])->endOfDay();
            $bookings = $bookings->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Apply payment status filter
        if ($this->paymentStatus !== 'All') {
            $bookings = $bookings->where('ticket_status', $this->paymentStatus);
        }
        $bookings = $bookings->paginate($this->limit);

        return view('livewire.b2b.intlbooking', compact('bookings'));
    }
}
