<?php

namespace App\Http\Livewire\User;

use App\Models\Domestic\DomesticFlightBooking;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Domesticbookings extends Component
{
    use WithPagination;
    public $search = '';
    public $bookingView = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $search = $this->search;

        $bookings = DomesticFlightBooking::where('user_id', Auth::user()->id)
            ->where(function ($query) use ($search) {
                $query->where('booking_code', 'LIKE', "%$search%")
                    ->orWhere('sector_from', 'LIKE', "%$search%")
                    ->orWhere('ticket_status', 'LIKE', "%$search%")
                    ->orWhere('sector_to', 'LIKE', "%$search%")
                    ->orWhere('departure_date', 'LIKE', "%$search%")
                    ->orWhere('arrival_date', 'LIKE', "%$search%")
                    ->orWhere('emergency_contact_fullname', 'LIKE', "%$search%")
                    ->orWhere('emergency_contact_email', 'LIKE', "%$search%")
                    ->orWhere('emergency_contact_phone', 'LIKE', "%$search%")
                    ->orWhere('created_at', 'LIKE', "%$search%");
            })
            ->latest()
            ->paginate(10);
        return view('livewire.user.domesticbookings', compact('bookings'));
    }

    public function viewBooking($booking_code)
    {
        $booking = DomesticFlightBooking::where('booking_code', $booking_code)->first();
        if ($booking) {
            $this->bookingView = $booking;
        }
    }

    public function backEvent()
    {
        $this->bookingView = '';
        $this->resetPage();
    }
}
