<?php

namespace App\Listeners;

use App\Jobs\FlightBooked;
use Carbon\Carbon;

class FlightBookedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
       dispatch((new FlightBooked($event->flightBooking))->delay(Carbon::now()->addSecond(10)));
    }
}
