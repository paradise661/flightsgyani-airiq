<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Domestic\DomesticFlightBooking;

class Domesticbooking extends Component
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


        // Start query for bookings
        $bookings = DomesticFlightBooking::query()
            ->latest()
            ->where(function ($query) use ($searchTerms) {
                $query->where('booking_code', 'LIKE', $searchTerms)
                    ->orWhere('sector_from', 'LIKE', $searchTerms)
                    ->orWhere('ticket_status', 'LIKE', $searchTerms)
                    ->orWhere('sector_to', 'LIKE', $searchTerms)
                    ->orWhere('departure_date', 'LIKE', $searchTerms)
                    ->orWhere('arrival_date', 'LIKE', $searchTerms)
                    ->orWhere('emergency_contact_fullname', 'LIKE', $searchTerms)
                    ->orWhere('emergency_contact_email', 'LIKE', $searchTerms)
                    ->orWhere('emergency_contact_phone', 'LIKE', $searchTerms)
                    ->orWhere('created_at', 'LIKE', $searchTerms);
            });

        // Apply date range filter if both dates are present
        if (count($dates) === 2) {
            $startDate = $dates[0];
            $endDate = \Carbon\Carbon::parse($dates[1])->endOfDay();
            $bookings = $bookings->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Apply payment status filter
        if ($this->paymentStatus !== 'All') {
            if ($this->paymentStatus == 1) {
                $bookings = $bookings->where('is_office_staff', true);
            } else {
                $bookings = $bookings->whereHas('payment', function ($query) {
                    $query->where('payment_status', $this->paymentStatus);
                });
            }
        }

        // Paginate results
        $bookings = $bookings->paginate($this->limit);

        // Return the view with filtered bookings
        return view('livewire.admin.domesticbooking', compact('bookings'));
    }
}
