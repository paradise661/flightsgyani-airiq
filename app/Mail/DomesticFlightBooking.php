<?php

namespace App\Mail;

use App\Models\Domestic\DomesticFlightBooking as DomesticDomesticFlightBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class DomesticFlightBooking extends Mailable
{
    use Queueable, SerializesModels;
    public $flightBooking;
    public $for;
    public $status;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($flightBooking, $for, $status = null)
    {
        $flight = DomesticDomesticFlightBooking::where('id', $flightBooking)->first();

        $this->flightBooking = $flight;
        $this->for = $for;
        $this->status = $status;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Flight Booking',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'front.domestic.mails.booking',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
