<?php

namespace App\Notifications\Flight;

use App\Models\InternationalFlight\FlightBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class FlightBooked extends Notification
{
    use Queueable;
    public $flightBooking;

    /**
     * Create a new notification instance.
     *
     * @param FlightBooking $flightBooking
     */
    public function __construct(FlightBooking $flightBooking)
    {
        $this->flightBooking = $flightBooking;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Flight Booking')
            ->markdown('mail.back.flightbooked', ['flightBooking' => $this->flightBooking]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function toDatabase()
    {
        if (isset($this->flightBooking->pnr_id) && !isset($this->flightBooking->ticket_details)) {
            $data = json_decode($this->flightBooking->contact_details, true)['name'] . ' has created PNR of ' . $this->flightBooking->pnr_id . ' but not generated ticket.';
            $title = 'PNR : ' . $this->flightBooking->pnr_id . ' generated ,No Ticket issued.';
        } else if (isset($this->flightBooking->pnr_id) && isset($this->flightBooking->ticket_details)) {
            $data = json_decode($this->flightBooking->contact_details, true)['name'] . ' has created PNR of ' . $this->flightBooking->pnr_id . ' and issued ticket.';
            $title = 'Ticket Issued of PNR : ' . $this->flightBooking->pnr_id;
        } else if (!isset($this->flightBooking->pnr_id) && !isset($this->flightBooking->ticket_details)) {
            $data = json_decode($this->flightBooking->contact_details, true)['name'] . ' has booked flight  but not generated PNR.';
            $title = 'Flight Booking PNR not generated.';
        } else {
            $data = json_decode($this->flightBooking->contact_details, true)['name'] . ' has booked flight.';
            $title = 'New Flight Booking.';
        }
        $airline = URL::asset('/frontend/air-logos/' . json_decode($this->flightBooking->flights, true)['airline'] . '.png');

        return [
            'data' => $data,
            'url' => route('admin.view.flight.booking', $this->flightBooking->booking_code),
            'title' => $title,
            'image' => $airline
        ];
    }
}
