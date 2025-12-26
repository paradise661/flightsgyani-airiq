<?php

namespace App\Service\AirIq;

use App\Models\InternationalFlight\FlightBooking;
use App\Models\InternationalFlight\FlightBookingDetail;
use App\Models\InternationalFlight\FlightTicket;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class AirIqService
{
    private static $airiq = [
        // 'url' => 'http://testairiq.mywebcheck.in/TravelAPI.svc',
        // 'url' => 'http://airiqnewapi.mywebcheck.in/TravelAPI.svc', // test
        'url' => 'https://airiqnewapi.tesepr.com/TravelAPI.svc',    // live
        'username' => '9857015300',
        'password' => '323456', // live
        // 'password' => '9857015300',  //test
        'agentId' => 'AQAG052921'
    ];

    public static function generateToken()
    {
        try {
            $rawString = self::$airiq['agentId'] . '*' . self::$airiq['username'] . ':' . self::$airiq['password'];
            $base64String = base64_encode($rawString);
            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . $base64String,
            ])->post(self::$airiq['url'] . "/Login");

            // $data = $response->json();
            // dd($data);
            // if ($response->successful()) {
            $data = $response->json();
            $jsonData = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            // file_put_contents(public_path('airiq/loginres.json'), $jsonData);
            $expiresAt = now()->endOfDay();
            Cache::put('airiq_login_response', $jsonData, $expiresAt);

            if (!$data['Status']['Error']) {
                $expiresAt = now()->endOfDay();
                Cache::put('airiq_token', $data['Token'], $expiresAt);
                return $data;
            }
            // }
            return null;
        } catch (Exception $error) {
            return null;
        }
    }

    public static function getFlights($search)
    {
        set_time_limit(0);
        if (!Cache::get('airiq_token')) {
            self::generateToken();
        }

        try {
            $time = $search->departure . "-" . $search->destination . "-" . date("dHis");

            $request = AirIqHelper::getAvailabilityRequest($search, self::$airiq);
            self::store($time, 'req', $request);

            $response = Http::timeout(0)->withHeaders([
                'TOKEN' => Cache::get('airiq_token'),
            ])->post(self::$airiq['url'] . "/Availability", $request);

            // if ($response->successful()) {
            $data = $response->json();
            self::store($time, 'res', $data);

            if (!$data['Status']['Error']) {
                return AirIqHelper::transformFlightItems($data, $search);
            }
            // }
            return [];
        } catch (Exception $error) {
            return [];
        }
    }

    public static function getPricing()
    {
        if (!session()->get('flight')) {
            return false;
        }

        if (!Cache::get('airiq_token')) {
            self::generateToken();
        }

        $flight = decrypt(session()->get('flight'));
        $request = AirIqHelper::getPricingRequest($flight, self::$airiq);

        try {
            $response = Http::withHeaders([
                'TOKEN' => Cache::get('airiq_token'),
            ])->post(self::$airiq['url'] . "/Pricing", $request);

            if ($response->successful()) {
                $data = $response->json();
                // $jsonData = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                // file_put_contents(public_path('airiq/pricingres.json'), $jsonData);
                if (!$data['ResponseStatus']['Error']) {
                    session()->put('airiq_pricing_response', json_encode($data));
                    session()->save();
                    // AirIqService::getSeat();
                    return $data;
                }
            }
            return [];
        } catch (Exception $error) {
            return [];
        }
    }

    public static function bookFlight($booking = null)
    {
        set_time_limit(0);
        try {
            if (!session()->get('flight')) {
                return false;
            }

            if (!$booking) {
                return false;
            }

            if (!Cache::get('airiq_token')) {
                self::generateToken();
            }

            $request = AirIqHelper::getBookingRequest($booking, self::$airiq);

            $response = Http::timeout(0)->withHeaders([
                'TOKEN' => Cache::get('airiq_token'),
            ])->post(self::$airiq['url'] . "/Book", $request);

            if ($response->successful()) {
                $data = $response->json();
                // $jsonData = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                // file_put_contents(public_path('airiq/bookingres.json'), $jsonData);

                if (!$data['Status']['Error']) {
                    $ticketDetails = AirIqHelper::ticketDetails($data);
                    if ($booking) {
                        $booking->update([
                            'airiq_booking_details' => json_encode($data),
                            'airiq_ticket_details' => json_encode($ticketDetails),
                            'ticket_status' => 1,
                            'for_payment' => 1
                        ]);
                    }
                    return true;
                }
            }
            if ($booking) {
                $booking->update(['airiq_booking_details' => json_encode($response->json())]);
            }
            return false;
        } catch (Exception $error) {
            return false;
        }
    }

    public static function getSeat()
    {

        $request = AirIqHelper::seatRequest(self::$airiq);

        try {
            $response = Http::withHeaders([
                'TOKEN' => Cache::get('airiq_token'),
            ])->post(self::$airiq['url'] . "/GetAvailSeatMap", $request);

            // if ($response->successful()) {
            $data = $response->json();
            // $jsonData = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            // file_put_contents(public_path('airiq/seatres.json'), $jsonData);
            return $data;
            // } else {
            //     return [];
            // }
        } catch (Exception $error) {
            dd("error: " . $error);
            return [];
        }
    }

    public static function checkLogin()
    {
        try {
            if (request('token') == 'get') {
                dd(Cache::get('airiq_token'));
            }

            if (request('token') == 'forget') {
                dd(Cache::forget('airiq_token'));
            }

            if (request('token') == 'login') {
                dd(Cache::get('airiq_login_response'));
            }

            if (request('token') == 'store') {
                $time = date('dHis');
                self::store(25112150, 'res', 'This is another test');
            }

            dd("out");
        } catch (Exception $error) {
            dd($error);
        }
    }

    public static function store($time, $type, $data)
    {
        $file = storage_path("app/public/airiq/$time/$type-$time.txt");
        $jsonData = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        if (is_dir(storage_path('app/public/airiq/' . $time))) {
            file_put_contents($file, $jsonData);
        } else {
            mkdir(storage_path('app/public/airiq/' . $time), 0755, true);
            file_put_contents($file, $jsonData);
        }

        return true;
    }
}
