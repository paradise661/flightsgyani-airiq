@component('mail::message')
    # New International Flight Booking

    You have new international flight booking to review.
    <br>
    Booking Code : <strong>{{ $flightBooking->booking_code }}</strong>

    @component('mail::button', ['url' => route('admin.view.flight.booking',$flightBooking->booking_code)])
        View
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
