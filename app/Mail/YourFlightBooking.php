<?php

namespace App\Mail;

use App\Models\InternationalFlight\FlightBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class YourFlightBooking extends Mailable
{
    use Queueable, SerializesModels;

    public $flightBooking;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(FlightBooking $flightBooking)
    {
        $this->flightBooking = $flightBooking;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if (isset($this->flightBooking->pnr_id) && isset($this->flightBooking->ticket_details)) {
            return $this->markdown('mail.front.flightcomplete')->with('flightBooking', $this->flightBooking);
        } else if (isset($this->flightBooking->pnr_id) && !isset($this->flightBooking->ticket_details)) {
            return $this->markdown('mail.front.flightnoticket')->with('flightBooking', $this->flightBooking);
        } else {
            return $this->markdown('mail.front.flightnopnr')->with('flightBooking', $this->flightBooking);
        }
    }
}
