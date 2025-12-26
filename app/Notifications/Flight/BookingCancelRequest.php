<?php

namespace App\Notifications\Flight;

use App\Models\InternationalFlight\FlightBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class BookingCancelRequest extends Notification
{
    use Queueable;
    public $booking, $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(FlightBooking $flightBooking, $message)
    {
        $this->booking = $flightBooking;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Flight Booking Cancel Request.')
            ->markdown('mail.flight.cancelbooking', ['booking' => $this->booking, 'message' => $this->message]);
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
        return [
            'data' => $this->booking->bookedBy->name . ' has requested to cancel booking of ' . $this->booking->pnr_id . ' pnr',
            'url' => route('admin.view.flight.booking', $this->booking->booking_code),
            'title' => 'New Flight Booking Cancel Request',
            'image' => URL::asset('front/images/cancel.png')
        ];
    }
}
