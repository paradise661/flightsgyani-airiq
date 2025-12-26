<?php

namespace App\Helpers;

use App\Models\Domestic\DomesticFlightBooking;
use App\Models\DomesticSearchFlight;
use App\Models\InternationalFlight\FlightBooking;
use App\Models\InternationalFlight\SearchFlight;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportHelper
{
    static function domesticBookingSearch($start_date, $end_date, $user_id = null)
    {
        // Generate all dates between start_date and end_date
        $dates = [];
        $currentDate = Carbon::parse($start_date);

        while ($currentDate <= Carbon::parse($end_date)) {
            $dates[] = $currentDate->format('Y-m-d');
            $currentDate->addDay();
        }

        $bookings = DomesticFlightBooking::selectRaw('DATE(created_at) as date, count(*) as count');
        if ($user_id) {
            $bookings = $bookings->where('user_id', $user_id);
        }
        $bookings = $bookings->whereBetween(DB::raw('DATE(created_at)'), [$start_date, $end_date])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->pluck('count', DB::raw('DATE(created_at) as date'))
            ->toArray();

        $searchLog = DomesticSearchFlight::selectRaw('DATE(created_at) as date, count(*) as count');
        if ($user_id) {
            $searchLog = $searchLog->where('user_id', $user_id);
        }
        $searchLog = $searchLog->whereBetween(DB::raw('DATE(created_at)'), [$start_date, $end_date])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->pluck('count', DB::raw('DATE(created_at) as date'))
            ->toArray();

        $finalResults = [];
        foreach ($dates as $date) {
            $finalResults[] = [
                'date' => $date,
                'booking' => isset($bookings[$date]) ? $bookings[$date] : 0,
                'search' => isset($searchLog[$date]) ? $searchLog[$date] : 0,
            ];
        }

        $dates = array_column($finalResults, 'date');
        $bookings = array_column($finalResults, 'booking');
        $search = array_column($finalResults, 'search');
        return ['dates' => $dates, 'bookings' => $bookings, 'search' => $search];
    }

    static function internationalBookingSearch($start_date, $end_date, $user_id = null)
    {
        // Generate all dates between start_date and end_date
        $dates = [];
        $currentDate = Carbon::parse($start_date);

        while ($currentDate <= Carbon::parse($end_date)) {
            $dates[] = $currentDate->format('Y-m-d');
            $currentDate->addDay();
        }

        $bookings = FlightBooking::selectRaw('DATE(created_at) as date, count(*) as count');
        if ($user_id) {
            $bookings = $bookings->where('user_id', $user_id);
        }
        $bookings = $bookings->whereBetween(DB::raw('DATE(created_at)'), [$start_date, $end_date])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->pluck('count', DB::raw('DATE(created_at) as date'))
            ->toArray();

        $searchLog = SearchFlight::selectRaw('DATE(created_at) as date, count(*) as count');
        if ($user_id) {
            $searchLog = $searchLog->where('user_id', $user_id);
        }
        $searchLog = $searchLog->whereBetween(DB::raw('DATE(created_at)'), [$start_date, $end_date])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->pluck('count', DB::raw('DATE(created_at) as date'))
            ->toArray();

        $finalResults = [];
        foreach ($dates as $date) {
            $finalResults[] = [
                'date' => $date,
                'booking' => isset($bookings[$date]) ? $bookings[$date] : 0,
                'search' => isset($searchLog[$date]) ? $searchLog[$date] : 0,
            ];
        }

        $dates = array_column($finalResults, 'date');
        $bookings = array_column($finalResults, 'booking');
        $search = array_column($finalResults, 'search');
        return ['dates' => $dates, 'bookings' => $bookings, 'search' => $search];
    }
}
