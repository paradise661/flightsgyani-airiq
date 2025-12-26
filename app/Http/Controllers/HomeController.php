<?php

namespace App\Http\Controllers;

use App\Models\Domestic\DomesticFlightBooking;
use App\Models\InternationalFlight\FlightBooking;
use App\Models\User;
use App\Notifications\CustomVerifyEmail;
use Carbon\Carbon;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

use function Ramsey\Uuid\v1;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $search = $request->query("q");

        $booking = FlightBooking::where('user_id', Auth::user()->id)
            ->where(function ($query) use ($search) {
                $query->where('booking_code', '=', "$search")
                    ->orWhere('pnr_id', $search)
                    ->orWhere('contact_details->name', "like", "%$search%")
                    ->orWhere('contact_details->email', "like", "%$search%");
            })
            ->latest()
            ->paginate(5);
        return view('home', ['booking' => $booking]);
    }


    public function bookingDetail(Request $request, $id)
    {
        $booking = FlightBooking::find($id);


        return view('front.user-dashboard.booking-detail', ['booking' => $booking]);
    }

    public function domesticBookingDetail()
    {
        return view('user.domesticbookings');
    }

    public function verify($id, $hash)
    {
        // Find the user
        $user = User::findOrFail($id);

        // Check if the hash matches
        if (sha1($user->getEmailForVerification()) !== $hash) {
            throw ValidationException::withMessages([
                'email' => ['The email verification link is invalid.'],
            ]);
        }

        // Check if the verification has expired (custom expiration logic)
        $expires = request()->query('expires');
        if ($expires && Carbon::createFromTimestamp($expires)->isBefore(now())) {
            throw ValidationException::withMessages([
                'email' => ['The verification link has expired.'],
            ]);
        }

        // Mark the user as verified
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));
        }

        // Redirect the user to their dashboard or home
        return redirect()->route('home')->with('verified', true);
    }

    public function verifyResend()
    {
        $user = User::find(Auth::user()->id);
        $user->notify(new CustomVerifyEmail());
        return redirect()->back()->with('success', 'Verification link has been sent to your mail');
    }
}
