<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Booking;
use App\Models\Client;
use App\Models\Package;
use App\Models\Partner;
use App\Models\Vendor;
use Excel;
use PDF;

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
        set_time_limit(0);
        $data = [];
        $data['packageCount'] = Package::count();
        $data['partnerCount'] = Partner::count();
        $data['blogCount'] = Blog::count();
        // dd($data);
        return view('admin.dashboard', $data);
    }
}
