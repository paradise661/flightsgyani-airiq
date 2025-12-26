<?php

namespace App\Jobs;

use App\Models\InternationalFlight\FlightBooking;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FlightBookingCancelRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $booking, $message;
    public $tries = 5;

    /**
     * Create a new job instance.
     *
     * @param FlightBooking $flightBooking
     * @param $message
     */
    public function __construct(FlightBooking $flightBooking, $message)
    {
        $this->booking = $flightBooking;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $admins = User::whereRoleIs('Admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new \App\Notifications\Flight\BookingCancelRequest($this->booking, $this->message));
        }
    }
}
