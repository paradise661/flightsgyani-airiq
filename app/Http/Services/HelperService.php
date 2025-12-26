<?php

namespace App\Http\Services;

use App\Models\Journal;

class HelperService
{

    public static function keywords()
    {
        $keywords = 'Europe Package from Nepal,Thailand package from Nepal,Best Travel Agency in Nepal,Best Travel Agency for International Holidays,International Hotel booking Service in Nepal';
        $keywords .= 'USA package from Nepal,Singapore Malaysia Package from Nepal,bali Package from Nepal,cheap Flights Ticket in Nepal ,Australia package from Nepal,Maldives package from Nepal';
        $keywords .= 'Dubai Package from Nepal, Mauritius Package from Nepal,Vietnam Cambodia Package from Nepal,India Package from Nepal';
        $keywords .= 'China Package from nepal,japan package from nepal,Baku Package from Nepal,Korea Package from Nepal,Egypt Package from Nepal, South Africa Package from Nepal,UK Package from Nepal';

        return $keywords;
    }

}
