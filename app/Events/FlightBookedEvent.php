<?php

namespace App\Events;

use App\Models\InternationalFlight\FlightBooking;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FlightBookedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $flightBooking;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(FlightBooking $flightBooking)
    {
        $this->flightBooking = $flightBooking;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
