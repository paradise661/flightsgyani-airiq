<?php

namespace App\Notifications\Flight;

use App\Models\InternationalFlight\GroupFlightBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class GroupBookingRequest extends Notification
{
    use Queueable;
    public $booking;

    /**
     * Create a new notification instance.
     *
     * @param GroupFlightBooking $groupFlightBooking
     */
    public function __construct(GroupFlightBooking $groupFlightBooking)
    {
        $this->booking = $groupFlightBooking;
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
            ->line('New Group Booking Request.')
            ->action('View', route('admin.view.group.booking', encrypt($this->booking->id)))
            ->line('Verify new booking request.');
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
            'data' => 'You have a new group booking request from ' . $this->booking->requestedBy->name,
            'url' => route('admin.view.group.booking', encrypt($this->booking->id)),
            'title' => 'New Group Flight Booking Request',
            'image' => URL::asset('front/images/request.png')
        ];
    }
}
