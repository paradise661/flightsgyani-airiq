<?php

use App\Models\ActivityLog;
use App\Models\B2B\Transaction;
use App\Models\Domestic\DomesticFlightCommission;
use App\Models\Domestic\Plasma;
use App\Models\Finance\Khalti;
use App\Models\InternationalFlight\{Airline, Airport, DailyFlightReport, FlightBooking, SearchFlight};
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use App\Models\InternationalFlightCommission;

//use App\Model\Tour\TourBooking;

if (!function_exists('help_getHashCode')) {
    function help_getHashCode($code, $type)
    {
        $merchantID = config()->get('hbl.merchantID');
        $secretKey = config()->get('hbl.secretKey');
        if ($type == 'T') {
            //            $booking = TourBooking::where('booking_code',$code)->first();
            //            $string = $merchantID.$code.$booking->pricing.help_getCurrencyCodeForHbl($booking->currency).'N';
            //            $hash = hash_hmac('SHA256', $string, $secretKey, false);
        } else if ($type == 'H') {
            //            $booking = HotelBooking::where('booking_code',$code)->first();
            //            $string = $merchantID.$code.$booking->pricing.help_getCurrencyCodeForHbl($booking->currency).'N';
            //            $hash = hash_hmac('SHA256',$string,$secretKey,false);
        } else if ($type == 'I') {
            $booking = FlightBooking::where('booking_code', $code)->first();
            $string = $merchantID . $code . $booking->final_fare . help_getCurrencyCodeForHbl($booking->currency) . 'N';
            $hash = hash_hmac('SHA256', $string, $secretKey, false);
        } else if ($type == 'D') {
            //            $booking = DomesticFlightBooking::where('booking_code',$code)->first();
            //            $string = $merchantID.$code.$booking->pricing.help_getCurrencyCodeForHbl($booking->currency).'N';
            //            $hash = hash_hmac('SHA256',$string,$secretKey,false);
        }

        $signData = strtoupper($hash);
        return urlencode($signData);
    }
}

if (!function_exists('help_getAmountInPaisa')) {

    function help_getAmountInPaisa($amount)
    {
        //        dd(explode(' ',$amount));
        if (count(explode(' ', $amount)) > 1) {
            $price = explode(' ', $amount)[1] . '00';
            $len = strlen((string)($price));
            for ($i = $len; $i < 12; $i++) {
                $price = '0' . (string)$price;
            }
            return $price;
        } else {
            $newAmount = $amount . '00';
            $len = strlen((string)($newAmount));
            for ($i = $len; $i < 12; $i++) {
                $newAmount = '0' . $newAmount;
            }
            return $newAmount;
        }
    }
}

if (!function_exists('help_getCurrencyCodeForHbl')) {
    function help_getCurrencyCodeForHbl($currency)
    {
        return config()->get('hbl.' . $currency);
    }
}

if (!function_exists('help_isPassportRequired')) {

    function help_isPassportRequired()
    {
        $search = SearchFlight::findorfail(Session::get('flight_search'));

        if (
            help_isAirportNepalIndia($search->departure) && help_isAirportNepalIndia($search->destination)
            && help_isSectorToIndia($search->sectors)
        ) {
            return false;
        }
        return true;
    }
}
if (!function_exists('help_isSectorToIndia')) {

    function help_isSectorToIndia($sector)
    {

        if (!isset($sector)) {
            return true;
        }
        $sectors = json_decode($sector, true);

        foreach ($sectors as $s) {
            if (!help_isAirportNepalIndia($s['depart'])) {
                return false;
            }

            if (!help_isAirportNepalIndia($s['arrival'])) {
                return false;
            }
        }
        return true;
    }
}

if (!function_exists('help_isAirportNepalIndia')) {

    function help_isAirportNepalIndia($code)
    {
        $airport = Airport::where('code', $code)->first();
        if (!$airport) {
            return false;
        }
        if ($airport->country == 'Nepal' || $airport->country == 'India') {
            return true;
        }
        return false;
    }
}

if (!function_exists('help_getCityFromCode')) {

    function help_getCityFromCode($code)
    {
        $airport = Airport::where('code', $code)->first();
        if (!$airport) {
            return $code;
        }
        return $airport->city;
    }
}

if (!function_exists('help_getAgentBalance')) {
    function help_getAgentBalance()
    {
        if (auth()->user()->hasRole('Agent')) {
            if (auth()->user()->topUp()->exists()) {
                return auth()->user()->topUp->balance;
            } else {
                return 0;
            }
        } else {
            return null;
        }
    }
}

if (!function_exists('help_getAmountFromPrice')) {
    function help_getAmountFromPrice($price)
    {
        return (int)explode(' ', $price)[1];
    }
}
if (!function_exists('help_getCurrencyFromPrice')) {
    function help_getCurrencyFromPrice($price)
    {
        //        dd(explode(' ',$price));
        return explode(' ', $price)[0];
    }
}

if (!function_exists('help_getAirportFromCode')) {
    function help_getAirportFromCode($code)
    {
        $airport = Airport::where('code', $code)->first();
        if (!$airport) {
            return $code;
        }
        return $airport->code . '-' . $airport->airport . ',' . $airport->city;
    }
}

if (!function_exists('help_getHashCodeForFonePay')) {
    function help_getHashCodeForFonePay($code, $action, $type)
    {
        $prn = help_getRandomString();
        $username = Config::get('fonepay.pid');
        $secret = Config::get('fonepay.secret');
        if ($type == 'H') {
            //            $booking = HotelBooking::where('booking_code',$code)->first();
            //            $string = $username.','.$action.','.$booking->booking_code.','.$booking->total_amount.','
            //                .$booking->ofHotel->currency.','.date('m/d/Y').','.$booking->ofHotel->name.' Booking,N/A,'
            //                .env('APP_URL').'/hotel-fonepay';
            //            $hash = hash_hmac('sha512',$string,$secret);
            ////            dd($hash);
            //            return $hash;
        } else if ($type === 'IF') {
            $booking = FlightBooking::where('booking_code', $code)->first();
            $string = $username . ',' . $action . ',' . $code . ',' . $booking->final_fare .
                ',' . $booking->currency . ',' . date('m/d/Y') .
                ',International Flight Booking,N/A,' . env('APP_URL') . '/flight-fonepay';
            return hash_hmac('sha512', $string, $secret);
        } else if ($type === 'DF') {
            //            $booking = DomesticFlightBooking::where('booking_code',$code)->first();
            //            $string = $username.','.$action.','.$code.','.$booking->pricing.','.$booking->currency.','
            //                .date('m/d/Y').',Domestic Flight Booking,N/A,'.env('APP_URL').'/dom-fonepay';
            //            return hash_hmac('sha512',$string,$secret);
        } else if ($type == 'T') {
            //            $booking = TourBooking::where('booking_code',$code)->first();
            //            $string = $username.','.$action.','.$booking->payment_reference.','.help_getTourPayableAmount($code).','
            //                .$booking->currency.','.date('m/d/Y').','.$booking->booking_code.',Tour,'
            //                .env('APP_URL').'/tour-fonepay';
            //            return hash_hmac('sha512',$string,$secret);
        }
    }
}

if (!function_exists('help_getTestHash')) {
    function help_getTestHash($code, $action)
    {
        $username = Config::get('fonepay.pid');
        $secret = Config::get('fonepay.secret');
        $string = $username . ',' . $action . ',' . $code . ',1,NPR,' . date('m/d/Y') . ',Flight Booking,N/A,' . env('APP_URL') . '/fonepay';
        //        dd($string);
        $hash = hash_hmac('sha512', $string, $secret);
        return $hash;
    }
}

if (!function_exists('help_canPnrBeVoid')) {
    function help_canPnrBeVoid($code)
    {
        $booking = FlightBooking::with('getTickets')->where('booking_code', $code)->first();
        if (!$booking) {
            return false;
        }
        if (!isset($booking->pnr_id)) {
            return false;
        }

        if ($booking->pnr_void) {
            return false;
        }
        if (!isset($booking->ticket_details)) {
            return true;
        }
        foreach ($booking->getTickets as $ticket) {
            if ($ticket->status) {
                return false;
            }
        }
        return true;
    }
}

if (!function_exists('help_hasReportOfDate')) {
    function help_hasReportOfDate($date)
    {
        $checkDate = Carbon::parse($date)->format('Y-m-d');
        $report = DailyFlightReport::where('date', $checkDate)->first();
        if (!$report) {
            return false;
        } else {
            return true;
        }
    }
}

if (!function_exists('help_getAirlineFromCode')) {
    function help_getAirlineFromCode($code, $showCode = true)
    {
        $airline = Airline::where('code', $code)->first();
        if (!$airline) {
            return $code;
        }

        return $showCode ? $airline->code . '-' . $airline->name : $airline->name;
    }
}

if (!function_exists('help_getRandomString')) {
    function help_getRandomString($length = 20)
    {
        if ($length < 4) {
            $length = 4;
        }
        $string = bin2hex(openssl_random_pseudo_bytes($length));
        return $string;
    }
}

if (!function_exists('help_getAirlineNameFromCode')) {
    function help_getAirlineNameFromCode($code)
    {
        $airline = Airline::where('code', $code)->first();
        if (!$airline) {
            return $code;
        }
        return $airline->name;
    }
}
if (!function_exists('help_getCityNameFromCode')) {
    function help_getCityNameFromCode($code)
    {
        $airport = Airport::where('code', $code)->first();
        if (!$airport) {
            return $code;
        }
        return $airport->city;
    }
}
//if(!function_exists('help_getTourPayableAmount')){
//    function help_getTourPayableAmount($code){
//        $booking = TourBooking::where('booking_code',$code)->first();
//        if(!$booking){
//            return 0;
//        }
//        if($booking->ofTour->payment_percent == 0 || $booking->ofTour->payment_percent == null){
//            return $booking->pricing;
//        }
//        $amount = round(($booking->pricing * $booking->ofTour->payment_percent)/100,0);
//        return $amount;
//    }
//}

if (!function_exists('help_generateFlightTime')) {
    function help_generateFlightTime($minutes)
    {
        $hr = floor($minutes / 60);
        $mins = $minutes % 60;
        if ($hr > 0) {
            return $hr . ' Hr ' . $mins . ' mins';
        } else {
            return $mins . ' mins';
        }
    }
}

//return time calculation
if (!function_exists('timeCalculation')) {
    function timeCalculation($dep_time, $arr_time)
    {
        $startTime = new DateTime($arr_time);
        $endTime = new DateTime($dep_time);

        $interval = $startTime->diff($endTime);
        if ($interval->h > 0) {
            return $interval->h . "h" . $interval->i . "m\n";
        } else {
            return $interval->i . "m\n";
        }
    }
}

//return domestic airlines full name
if (!function_exists('airlinesFullName')) {
    function airlinesFullName($shortcode)
    {
        $array = array(
            'U4' => 'Buddha Air',
            'S1' => 'Saurya Airlines',
            'RMK' => 'Simrik Airlines',
            'YT' => 'Yeti Airlines',
            'GA' => 'Goma Airlines',
            'SHA' => 'Shree Airlines',
            'ST' => 'Sita Air',
        );

        return $array[$shortcode];
    }
}

if (!function_exists('domesticFlightTotalCalculation')) {
    function domesticFlightTotalCalculation($adultPrice, $adultQuantity, $childPrice, $childQuantity, $fuel_surcharge = 0, $tax = 0, $agency_commission = 0, $child_commission = 0)
    {
        $adult = ($adultPrice + $fuel_surcharge + $tax) * $adultQuantity;
        $child = ($childPrice + $fuel_surcharge + $tax) * $childQuantity;
        // $adiscount = floor($agency_commission * $adultQuantity);
        // $cDiscount = floor($child_commission * $childQuantity);

        $adultTotalPrice = $adult;
        $childTotalPrice = $child;
        $totalPrice = $adultTotalPrice + $childTotalPrice;
        // $cashback = $adiscount + $cDiscount;

        return $totalPrice;
    }
}

if (!function_exists('nepaliCurrencyFormat')) {
    function nepaliCurrencyFormat($amount)
    {
        $decimal = (string) ($amount - floor($amount));
        $amount = floor($amount);
        $length = strlen($amount);
        $m = '';
        $amount = strrev($amount);
        for ($i = 0; $i < $length; $i++) {
            if (($i == 3 || ($i > 3 && ($i - 1) % 2 == 0)) && $i != $length) {
                $m .= ',';
            }
            $m .= $amount[$i];
        }
        $result = strrev($m);
        $decimal = preg_replace("/0./i", ".", $decimal);
        $decimal = substr($decimal, 0, 3);
        if ($decimal != '0') {
            $result = $result . $decimal;
        }
        return $result;
    }
}

if (!function_exists('totalDomesticAmount')) {
    function totalDomesticAmount()
    {
        $outbound_flight = Session::get('outbound_flight');
        $inbound_flight = Session::get('inbound_flight');
        $request_data = Session::get('request_data');

        $adult_fare = ($outbound_flight->AdultFare ?? 0) + ($inbound_flight->AdultFare ?? 0);
        $child_fare = ($outbound_flight->ChildFare ?? 0) + ($inbound_flight->ChildFare ?? 0);
        $fuel_surcharge = ($outbound_flight->FuelSurcharge ?? 0) + ($inbound_flight->FuelSurcharge ?? 0);
        $tax = ($outbound_flight->Tax ?? 0) + ($inbound_flight->Tax ?? 0);
        $outbound_discount = $outbound_flight->Discount ?? 0;

        $outboundTotalAmount = domesticFlightTotalCalculation(
            $outbound_flight->AdultFare,
            $request_data['adult'],
            $outbound_flight->ChildFare,
            $request_data['child'],
            $outbound_flight->FuelSurcharge,
            $outbound_flight->Tax,
            $outbound_flight->AgencyCommission,
            $outbound_flight->ChildCommission,
        );
        $inboundTotalAmount = 0;
        $inbound_discount = 0;

        if ($request_data['type'] == 'R') {
            $inbound_discount = $inbound_flight->Discount ?? 0;
            $inboundTotalAmount = domesticFlightTotalCalculation(
                $inbound_flight->AdultFare,
                $request_data['adult'],
                $inbound_flight->ChildFare,
                $request_data['child'],
                $inbound_flight->FuelSurcharge,
                $inbound_flight->Tax,
                $inbound_flight->AgencyCommission,
                $inbound_flight->ChildCommission,
            );
        }
        $totalDiscount = $outbound_discount + $inbound_discount;
        $totalAmount = $outboundTotalAmount + $inboundTotalAmount - $totalDiscount;

        return [
            "Currency" => $outbound_flight->Currency ?? 'NPR',
            "totalAmount" => $totalAmount ?? 0,
            "totalDiscount" => $totalDiscount ?? 0,
            "outboundDiscountAmount" => $outbound_discount ?? 0,
            "inboundDiscountAmount" => $inbound_discount ?? 0,
            "adult_fare" => $adult_fare ?? 0,
            "child_fare" => $child_fare ?? 0,
            "fuel_surcharge" => $fuel_surcharge ?? 0,
            "tax" => $tax ?? 0,
            "request_data" => $request_data
        ];
    }

    function domesticSessionClear()
    {
        Session::forget('request_data');
        Session::forget('outbound_flight');
        Session::forget('inbound_flight');
        Session::forget('reservation_data');
        Session::forget('passenger_details');
    }
}



if (!function_exists('help_getRoundAmount')) {
    function help_getRoundAmount($amount)
    {
        $price = explode(" ", $amount);
        $price[1] = round($price[1]);

        return implode(" ", $price);
    }
}


if (!function_exists('listCountries')) {

    function listCountries()
    {

        return [
            'AF' => 'Afghanistan',
            'AL' => 'Albania',
            'DZ' => 'Algeria',
            'AS' => 'American Samoa',
            'AD' => 'Andorra',
            'AO' => 'Angola',
            'AI' => 'Anguilla',
            'AQ' => 'Antarctica',
            'AG' => 'Antigua and Barbuda',
            'AR' => 'Argentina',
            'AM' => 'Armenia',
            'AW' => 'Aruba',
            'AU' => 'Australia',
            'AT' => 'Austria',
            'AZ' => 'Azerbaijan',
            'BS' => 'Bahamas',
            'BH' => 'Bahrain',
            'BD' => 'Bangladesh',
            'BB' => 'Barbados',
            'BY' => 'Belarus',
            'BE' => 'Belgium',
            'BZ' => 'Belize',
            'BJ' => 'Benin',
            'BM' => 'Bermuda',
            'BT' => 'Bhutan',
            'BO' => 'Bolivia',
            'BA' => 'Bosnia and Herzegovina',
            'BW' => 'Botswana',
            'BR' => 'Brazil',
            'IO' => 'British Indian Ocean Territory',
            'VG' => 'British Virgin Islands',
            'BN' => 'Brunei',
            'BG' => 'Bulgaria',
            'BF' => 'Burkina Faso',
            'BI' => 'Burundi',
            'KH' => 'Cambodia',
            'CM' => 'Cameroon',
            'CA' => 'Canada',
            'CV' => 'Cape Verde',
            'KY' => 'Cayman Islands',
            'CF' => 'Central African Republic',
            'TD' => 'Chad',
            'CL' => 'Chile',
            'CN' => 'China',
            'CX' => 'Christmas Island',
            'CC' => 'Cocos Islands',
            'CO' => 'Colombia',
            'KM' => 'Comoros',
            'CK' => 'Cook Islands',
            'CR' => 'Costa Rica',
            'HR' => 'Croatia',
            'CU' => 'Cuba',
            'CW' => 'Curaçao',
            'CY' => 'Cyprus',
            'CZ' => 'Czech Republic',
            'CD' => 'Democratic Republic of the Congo',
            'DK' => 'Denmark',
            'DJ' => 'Djibouti',
            'DM' => 'Dominica',
            'DO' => 'Dominican Republic',
            'TL' => 'East Timor',
            'EC' => 'Ecuador',
            'EG' => 'Egypt',
            'SV' => 'El Salvador',
            'GQ' => 'Equatorial Guinea',
            'ER' => 'Eritrea',
            'EE' => 'Estonia',
            'ET' => 'Ethiopia',
            'FK' => 'Falkland Islands',
            'FO' => 'Faroe Islands',
            'FJ' => 'Fiji',
            'FI' => 'Finland',
            'FR' => 'France',
            'PF' => 'French Polynesia',
            'GA' => 'Gabon',
            'GM' => 'Gambia',
            'GE' => 'Georgia',
            'DE' => 'Germany',
            'GH' => 'Ghana',
            'GI' => 'Gibraltar',
            'GR' => 'Greece',
            'GL' => 'Greenland',
            'GD' => 'Grenada',
            'GU' => 'Guam',
            'GT' => 'Guatemala',
            'GG' => 'Guernsey',
            'GN' => 'Guinea',
            'GW' => 'Guinea-Bissau',
            'GY' => 'Guyana',
            'HT' => 'Haiti',
            'HN' => 'Honduras',
            'HK' => 'Hong Kong',
            'HU' => 'Hungary',
            'IS' => 'Iceland',
            'IN' => 'India',
            'ID' => 'Indonesia',
            'IR' => 'Iran',
            'IQ' => 'Iraq',
            'IE' => 'Ireland',
            'IM' => 'Isle of Man',
            'IL' => 'Israel',
            'IT' => 'Italy',
            'CI' => 'Ivory Coast',
            'JM' => 'Jamaica',
            'JP' => 'Japan',
            'JE' => 'Jersey',
            'JO' => 'Jordan',
            'KZ' => 'Kazakhstan',
            'KE' => 'Kenya',
            'KI' => 'Kiribati',
            'XK' => 'Kosovo',
            'KW' => 'Kuwait',
            'KG' => 'Kyrgyzstan',
            'LA' => 'Laos',
            'LV' => 'Latvia',
            'LB' => 'Lebanon',
            'LS' => 'Lesotho',
            'LR' => 'Liberia',
            'LY' => 'Libya',
            'LI' => 'Liechtenstein',
            'LT' => 'Lithuania',
            'LU' => 'Luxembourg',
            'MO' => 'Macau',
            'MK' => 'Macedonia',
            'MG' => 'Madagascar',
            'MW' => 'Malawi',
            'MY' => 'Malaysia',
            'MV' => 'Maldives',
            'ML' => 'Mali',
            'MT' => 'Malta',
            'MH' => 'Marshall Islands',
            'MR' => 'Mauritania',
            'MU' => 'Mauritius',
            'YT' => 'Mayotte',
            'MX' => 'Mexico',
            'FM' => 'Micronesia',
            'MD' => 'Moldova',
            'MC' => 'Monaco',
            'MN' => 'Mongolia',
            'ME' => 'Montenegro',
            'MS' => 'Montserrat',
            'MA' => 'Morocco',
            'MZ' => 'Mozambique',
            'MM' => 'Myanmar',
            'NA' => 'Namibia',
            'NR' => 'Nauru',
            'NP' => 'Nepal',
            'NL' => 'Netherlands',
            'NC' => 'New Caledonia',
            'NZ' => 'New Zealand',
            'NI' => 'Nicaragua',
            'NE' => 'Niger',
            'NG' => 'Nigeria',
            'NU' => 'Niue',
            'KP' => 'North Korea',
            'MP' => 'Northern Mariana Islands',
            'NO' => 'Norway',
            'OM' => 'Oman',
            'PK' => 'Pakistan',
            'PW' => 'Palau',
            'PS' => 'Palestine',
            'PA' => 'Panama',
            'PG' => 'Papua New Guinea',
            'PY' => 'Paraguay',
            'PE' => 'Peru',
            'PH' => 'Philippines',
            'PN' => 'Pitcairn Islands',
            'PL' => 'Poland',
            'PT' => 'Portugal',
            'PR' => 'Puerto Rico',
            'QA' => 'Qatar',
            'CG' => 'Republic of the Congo',
            'RE' => 'Reunion',
            'RO' => 'Romania',
            'RU' => 'Russia',
            'RW' => 'Rwanda',
            'BL' => 'Saint Barthelemy',
            'SH' => 'Saint Helena',
            'KN' => 'Saint Kitts and Nevis',
            'LC' => 'Saint Lucia',
            'MF' => 'Saint Martin',
            'PM' => 'Saint Pierre and Miquelon',
            'VC' => 'Saint Vincent and the Grenadines',
            'WS' => 'Samoa',
            'SM' => 'San Marino',
            'ST' => 'Sao Tome and Principe',
            'SA' => 'Saudi Arabia',
            'SN' => 'Senegal',
            'RS' => 'Serbia',
            'SC' => 'Seychelles',
            'SL' => 'Sierra Leone',
            'SG' => 'Singapore',
            'SX' => 'Sint Maarten',
            'SK' => 'Slovakia',
            'SI' => 'Slovenia',
            'SB' => 'Solomon Islands',
            'SO' => 'Somalia',
            'ZA' => 'South Africa',
            'KR' => 'South Korea',
            'SS' => 'South Sudan',
            'ES' => 'Spain',
            'LK' => 'Sri Lanka',
            'SD' => 'Sudan',
            'SR' => 'Suriname',
            'SJ' => 'Svalbard and Jan Mayen',
            'SZ' => 'Swaziland',
            'SE' => 'Sweden',
            'CH' => 'Switzerland',
            'SY' => 'Syria',
            'TW' => 'Taiwan',
            'TJ' => 'Tajikistan',
            'TZ' => 'Tanzania',
            'TH' => 'Thailand',
            'TG' => 'Togo',
            'TK' => 'Tokelau',
            'TO' => 'Tonga',
            'TT' => 'Trinidad and Tobago',
            'TN' => 'Tunisia',
            'TR' => 'Turkey',
            'TM' => 'Turkmenistan',
            'TC' => 'Turks and Caicos Islands',
            'TV' => 'Tuvalu',
            'VI' => 'U.S. Virgin Islands',
            'UG' => 'Uganda',
            'UA' => 'Ukraine',
            'AE' => 'United Arab Emirates',
            'GB' => 'United Kingdom',
            'US' => 'United States',
            'UY' => 'Uruguay',
            'UZ' => 'Uzbekistan',
            'VU' => 'Vanuatu',
            'VA' => 'Vatican',
            'VE' => 'Venezuela',
            'VN' => 'Vietnam',
            'WF' => 'Wallis and Futuna',
            'EH' => 'Western Sahara',
            'YE' => 'Yemen',
            'ZM' => 'Zambia',
            'ZW' => 'Zimbabwe'
        ];
    }
}



if (!function_exists('getSiteSettings')) {
    function getSiteSettings()
    {
        return Site::first();
    }
}

if (!function_exists('khaltiCredentials')) {
    function khaltiCredentials()
    {
        // live credentials
        // private $khaltiURL = 'https://khalti.com/api/v2/epayment/initiate/';
        // private $khaltiKEY = 'live_secret_key_a7958f973c1f4c6fa62f6e3954f59a0e';

        // test credentials
        // private $khaltiURL = 'https://a.khalti.com/api/v2/epayment/initiate/';
        // private $khaltiKEY = 'live_secret_key_68791341fdd94846a146f0457ff7b455';
        $plasma = Plasma::first();
        if ($plasma->environment == 1) {
            $kh = Khalti::first();
            $khalti = (object) [];
            $khalti->khaltiURL = 'https://khalti.com/api/v2/epayment/initiate/';
            $khalti->secret_key = $kh->secret_key ?? '';
            return $khalti;
        } else {
            $khalti = (object) [];
            $khalti->khaltiURL = 'https://a.khalti.com/api/v2/epayment/initiate/';
            $khalti->secret_key = 'live_secret_key_68791341fdd94846a146f0457ff7b455';
            return $khalti;
        }
    }
}

if (!function_exists('getDomesticFlightDiscounts')) {
    function getDomesticFlightDiscounts()
    {
        $commission = DomesticFlightCommission::latest()->where('status', 1)->get();

        $data = [];
        foreach ($commission as $comm) {
            if (Auth::check() && Auth::user()->user_type === 'AGENT') {
                $data[$comm->domestic_airline_code] = $comm->agent_commission;
            } else {
                $data[$comm->domestic_airline_code] = $comm->commission;
            }
        }

        // $data = [
        //     'S1' => 100,
        //     'U4' => 10,
        // ];
        return $data;
    }
}

if (!function_exists('remainingBalance')) {
    function remainingBalance($agent_id, $currency_type = '')
    {
        $transaction = Transaction::where('agent_id', $agent_id)->orderBy('id', 'DESC')->first();
        if ($currency_type == 'USD') {
            return $transaction->remaining_balance_usd ?? 0;
        }
        if ($currency_type == 'NPR') {
            return $transaction->remaining_balance_npr ?? 0;
        }
        return [
            'NPR' => $transaction->remaining_balance_npr ?? 0,
            'USD' => $transaction->remaining_balance_usd ?? 0,
        ];
    }
}

if (!function_exists('activityLog')) {
    function activityLog($activity = '')
    {
        return ActivityLog::create([
            'user_id' => Auth::user()->id ?? null,
            'activity' => Auth::user()->name . ' (' . Auth::user()->email . ') ' . $activity
        ]);
    }
}

if (!function_exists('paymentRecord')) {
    function paymentRecord($agent_id, $currency_type = '')
    {
        $payment = Transaction::where('agent_id', $agent_id)
            ->where('currency_type', 'NPR')
            ->where('load_type', 'ADMIN')
            ->selectRaw('
                         SUM(CASE WHEN status = "DUE" THEN amount ELSE 0 END) as due,
                         SUM(CASE WHEN status = "PAID" THEN amount ELSE 0 END) as paid
                     ')
            ->first();
        return $payment;
    }
}

if (!function_exists('checkKhaltiPayment')) {
    function checkKhaltiPayment($pidx)
    {
        try {
            $configs = [
                "pidx" => $pidx
            ];
            // dd($configs);
            $json_configs = json_encode($configs);

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://khalti.com/api/v2/epayment/lookup/',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $json_configs,
                CURLOPT_HTTPHEADER => array(
                    'Authorization: key live_secret_key_a7958f973c1f4c6fa62f6e3954f59a0e',
                    'Content-Type: application/json',
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            if ($response) {
                $data = json_decode($response);
                if ($data->status === 'Completed' && $data->transaction_id) {
                    return true;
                }
            }
            return false;
        } catch (Exception $error) {
            return false;
        }
    }
}


if (!function_exists('getInternationalFlightDiscounts')) {
    function getInternationalFlightDiscounts($search, $currency = 'NPR')
    {
        $currencyRate = 1;
        if ($currency != 'NPR') {
            $currencyRate = getCurrencyRate() ?? 1;
        }

        $commission = InternationalFlightCommission::latest()->where('status', 1)->get();

        $isRoundWay = 1;
        if ($search->return_date) {
            $isRoundWay = 2;
        }

        $data = [];
        foreach ($commission as $comm) {
            if (Auth::check() && Auth::user()->user_type === 'AGENT') {
                $amount = ($search->adults * $comm->agent_commission ?? 0) + ($search->childs * $comm->agent_child_commission ?? 0) + ($search->infants * $comm->agent_infant_commission ?? 0);
                $data[$comm->international_airline_code] = ($amount / $currencyRate) * $isRoundWay;
            } else {
                $amount = ($search->adults * $comm->commission ?? 0) + ($search->childs * $comm->child_commission ?? 0) + ($search->infants * $comm->infant_commission ?? 0);
                $data[$comm->international_airline_code] = ($amount / $currencyRate) * $isRoundWay;
            }
        }
        return $data;
    }
}

if (!function_exists('getCurrencyRate')) {
    function getCurrencyRate()
    {
        return 140;
    }
}

if (!function_exists('getSite')) {
    function getSite()
    {
        return Site::first();
    }
}
