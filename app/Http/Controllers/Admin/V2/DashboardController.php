<?php

namespace App\Http\Controllers\Admin\V2;

use App\Helpers\ReportHelper;
use App\Http\Controllers\Controller;
use App\Models\B2B\Transaction;
use App\Models\Blog;
use App\Models\Domestic\DomesticFlightBooking;
use App\Models\Inquery;
use App\Models\InternationalFlight\FlightBooking;
use App\Models\Package;
use App\Models\Partner;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // abort_unless(Gate::allows('view dashboard'), 403);

        set_time_limit(0);
        $data = [];
        $data['domesticBookingCount'] = DomesticFlightBooking::count();
        $data['intlBookingCount'] = FlightBooking::count();
        $data['inqueriesCount'] = Inquery::count();
        $data['registeredUsers'] = User::where('user_type', 'USER')->count();
        $data['domesticData'] = ReportHelper::domesticBookingSearch(Carbon::today()->subDays(6)->format('Y-m-d'), date('Y-m-d'));
        $data['internationalData'] = ReportHelper::internationalBookingSearch(Carbon::today()->subDays(6)->format('Y-m-d'), date('Y-m-d'));

        $data['transactions'] = Transaction::orderBy('id', 'DESC')
            ->limit(10)->get();
        activityLog('viewed dashboard');
        return view('admin.v2.dashboard', $data);
    }
}
