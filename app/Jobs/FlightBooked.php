<?php

namespace App\Jobs;

use App\Mail\YourFlightBooking;
use App\Models\InternationalFlight\FlightBooking;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class FlightBooked implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public FlightBooking $flightBooking;
    public int $tries = 2;

    /**
     * Create a new job instance.
     *
     * @param FlightBooking $flightBooking
     */
    public function __construct(FlightBooking $flightBooking)
    {
        $this->flightBooking = $flightBooking;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $admins = User::whereRoleIs('Admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new \App\Notifications\Flight\FlightBooked($this->flightBooking));
        }
        Mail::to(json_decode($this->flightBooking->contact_details, true)['email'])->send(new YourFlightBooking($this->flightBooking));

    }
}
