<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }



    public function authenticated(Request $request)
    {
        if (Auth::user()->user_type == 'AGENT') {
            Auth::logout();
            return redirect()->back()->with('error', 'Invalid Email/Password. Seems like you are trying to access agent dashboard. Please click on agent login and try again');
        }

        // if (!Auth::user()->verified || !Auth::user()->active) {
        //     Auth::logout();
        //     return redirect()->back()->with('error', 'Your account is inactive');
        // }

        if ($request->has('previous')) {
            $this->redirectTo = $request->get('previous');
        }

        if (Auth::user()->user_type == 'ADMIN') {
            activityLog('logged in');

            return redirect()->route('v2.admin.dashboard');
        } else {
            if (session()->has('url.intended')) {
                return redirect(session('url.intended'));
            }
            return redirect()->route('frontend.index');
        }
    }


    public function socialiteLoginWithGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function socialiteLoginCallback()
    {

        try {
            $socialUser = Socialite::driver('google')->user();

            $user = User::where('email', $socialUser->email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $socialUser->name,
                    'email' => $socialUser->email,
                    'email_verified_at' => now(),
                    'provider_id' => $socialUser->id,
                    'provider_type' => 'google',
                ]);
            }


            Auth::login($user);

            return redirect()->route('frontend.index');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Something went wrong');
        }
    }
}
