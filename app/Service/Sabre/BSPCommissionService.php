<?php

namespace App\Service\Sabre;

use App\Models\InternationalFlight\BSPCommission;
use App\Models\InternationalFlight\FlightBooking;

class BSPCommissionService
{
    public $airline, $flights, $origin;


    public function calculateCommission(FlightBooking $flightBooking)
    {

        $this->airline = $flightBooking->airline;
        $this->flights = json_decode($flightBooking->flights, true)['flight'];
        //        dd($this->flights);
        $this->origin = $this->flights[0]['sectors'][0]['departure'] == 'KTM' ? '' : null;
        //        dd($this->origin);
        $commission = $this->getCommission();

        return $commission;
    }

    public function getCommission()
    {
        $commission = $this->getCommissionWithOrigin();
        if ($commission) {
            return $commission;
        } else {
            $commission = $this->getCommissionWithOutOrigin();
            if ($commission) {
                return $commission;
            } else {
                $commission = $this->getNetCommission();
                if ($commission) {
                    return $commission;
                } else {
                    return false;
                }
            }
        }
    }

    public function getCommissionWithOrigin()
    {
        $bspCommission = BSPCommission::where('airline', $this->airline)->where('with_origin', $this->origin)->latest()->first();
        if ($bspCommission) {
            return $bspCommission->commission;
        } else {
            return false;
        }
    }

    public function getCommissionWithOutOrigin()
    {
        $bspCommission = BSPCommission::where('airline', $this->airline)->where('without_origin', $this->origin)->latest()->first();
        if ($bspCommission) {
            return $bspCommission->commission;
        } else {
            return false;
        }
    }

    public function getNetCommission()
    {
        $bspCommission = BSPCommission::where('airline', $this->airline)->where('with_origin', null)->where('without_origin', null)->latest()->first();
        if ($bspCommission) {
            return $bspCommission->commission;
        } else {
            return false;
        }
    }
}
