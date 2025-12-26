<?php

namespace App\Service\Sabre;

use App\Models\B2B\AgentFlightCommission;
use App\Models\InternationalFlight\SearchFlight;
use Illuminate\Support\Facades\Auth;

class CommissionService
{
    public $trip_type, $adult, $child, $infant, $class, $airline, $origin, $destination;

    public function __construct()
    {
        $search_flight = SearchFlight::findorfail(session()->get('flight_search'));
        $this->origin = $search_flight->arrival;
        $this->destination = $search_flight->destination;
        if ($search_flight->arrival == 'KTM') {
            $this->type = 'siti';
            $this->antiType = 'soto';
        } else {
            $this->type = 'soto';
            $this->antiType = 'siti';
        }
        if ($search_flight->return_date == null) {
            $this->trip_type = 'O';
        } else {
            $this->trip_type = 'R';
        }
    }

    public function calculateCommission($flights)
    {

        $newflights = [];
        foreach ($flights as $flight) {
            $class = [];
            foreach ($flight['flight'] as $foo) {
                foreach ($foo as $bar) {
                    array_push($class, $bar['resbook']);
                }
            }

            $this->class = $class;
            $this->airline = $flight['airline'];
            $commission = $this->getCommissionRule($flight['airline']);
            if (!$commission) {
                $compulsoryCommission = $this->getCompulsoryRule();
                if (!$compulsoryCommission) {
                    $new = $this->applyNullCommission($flight);
                } else {
                    $new = $this->applyCommissionRule($flight, $compulsoryCommission);
                    if (!$new) {
                        $new = $this->applyNullCommission($flight);
                    }
                }
            } else {
                $new = $this->applyCommissionRule($flight, $commission);
                if (!$new) {
                    $new = $this->applyNullCommission($flight);
                }
            }

            array_push($newflights, $new);
        }

        return $newflights;
    }

    public function getCommissionRule($airline)
    {
        $commission = $this->getCommissionMatchingAll($airline);
        if (!$commission) {
            $commission = $this->getCommissionMatchingThree($airline);
            if (!$commission) {
                $commission = $this->getCommissionMatchingTwo($airline);
                if (!$commission) {
                    $commission = $this->getCommissionMatchingOne($airline);
                    if (!$commission) {
                        $commission = $this->getCompulsoryRule();
                        if (!$commission) {
                            return false;
                        } else {
                            return $commission;
                        }
                    } else {
                        return $commission;
                    }
                } else {
                    return $commission;
                }
            } else {
                return $commission;
            }
        } else {
            return $commission;
        }
    }

    public function getCommissionMatchingAll($airline)
    {
        $commission = AgentFlightCommission::where('airline', $this->airline)
            ->where('origin', $this->origin)
            ->where('destination', $this->destination)
            ->where('trip_type', $this->trip_type)
            ->where($this->type, true)
            ->where($this->antiType, false)
            ->where(function ($query) {
                foreach ($this->class as $cls) {
                    $query->where('class', 'like', '%' . $cls . '%');
                }
            })
            ->orderBy('priority', 'asc')
            ->first();

        if (!$commission) {
            $commission = AgentFlightCommission::where('airline', $this->airline)
                ->where('origin', $this->origin)
                ->where('destination', $this->destination)
                ->where('trip_type', $this->trip_type)
                ->where($this->antiType, false)
                ->where(function ($query) {
                    foreach ($this->class as $cls) {
                        $query->where('class', 'like', '%' . $cls . '%');
                    }
                })
                ->orderBy('priority', 'asc')
                ->first();
        }

        if ($commission) {
            return $commission;
        } else {
            return false;
        }
    }

    public function getCommissionMatchingThree($airline)
    {
        $air_sec_trip = AgentFlightCommission::where('airline', $this->airline)
            ->where('origin', $this->origin)
            ->where('destination', $this->destination)
            ->where('trip_type', $this->trip_type)
            ->where('class', null)
            ->orderBy('priority', 'asc')
            ->first();

        $air_sec_class = AgentFlightCommission::where('airline', $this->airline)
            ->where('origin', $this->origin)
            ->where('destination', $this->destination)
            ->where($this->antiType, false)
            ->where('trip_type', 'A')
            ->where('class', null)
            ->where(function ($query) {
                foreach ($this->class as $cls) {
                    $query->where('class', 'like', '%' . $cls . '%');
                }
            })
            ->orderBy('priority', 'asc')
            ->first();
        $air_trip_class = AgentFlightCommission::where('airline', $this->airline)
            ->where('trip_type', $this->trip_type)
            ->where($this->type, true)
            ->where($this->antiType, false)
            ->where('origin', null)
            ->where('destination', null)
            ->where(function ($query) {
                foreach ($this->class as $cls) {
                    $query->where('class', 'like', '%' . $cls . '%');
                }

            })
            ->orderBy('priority', 'asc')
            ->first();
        if (!$air_trip_class) {
            $air_trip_class = AgentFlightCommission::where('airline', $this->airline)
                ->where('trip_type', $this->trip_type)
                ->where($this->antiType, false)
                ->where('origin', null)
                ->where('destination', null)
                ->where(function ($query) {
                    foreach ($this->class as $cls) {
                        $query->where('class', 'like', '%' . $cls . '%');
                    }
                })
                ->orderBy('priority', 'asc')
                ->first();
        }
        $sec_trip_class = AgentFlightCommission::where('origin', $this->origin)
            ->where('destination', $this->destination)
            ->where('trip_type', $this->trip_type)
            ->where($this->antiType, false)
            ->where('airline', null)
            ->where(function ($query) {
                foreach ($this->class as $cls) {
                    $query->where('class', 'like', '%' . $cls . '%');
                }

            })
            ->orderBy('priority', 'asc')
            ->first();
        $commissions = collect([$air_sec_trip, $air_sec_class, $air_trip_class, $sec_trip_class]);

        $new = $commissions->filter(function ($item) {
            return $item != null;
        });
        if ($new->count() > 0) {
            $min = $new->min('priority');
            return $new->filter(function ($item) use ($min) {
                return $item->priority == $min;
            })->first();
        } else {
            return false;
        }
    }

    public function getCommissionMatchingTwo($airline)
    {
        $air_sec = AgentFlightCommission::where('airline', $this->airline)
            ->where('origin', $this->origin)
            ->where('destination', $this->destination)
            ->where($this->antiType, false)
            ->where('trip_type', 'A')
            ->where('class', null)
            ->orderBy('priority', 'asc')
            ->first();
        $air_trip = AgentFlightCommission::where('airline', $this->airline)
            ->where('origin', null)
            ->where('destination', null)
            ->where($this->type, true)
            ->where($this->antiType, false)
            ->where('trip_type', $this->trip_type)
            ->where('class', null)
            ->orderBy('priority', 'asc')
            ->first();
        if (!$air_trip) {
            $air_trip = AgentFlightCommission::where('airline', $this->airline)
                ->where('origin', null)
                ->where('destination', null)
                ->where($this->antiType, false)
                ->where('trip_type', $this->trip_type)
                ->where('class', null)
                ->orderBy('priority', 'asc')
                ->first();
        }
        $air_class = AgentFlightCommission::where('airline', $this->airline)
            ->where('origin', null)
            ->where('destination', null)
            ->where($this->type, true)
            ->where($this->antiType, false)
            ->where(function ($query) {
                foreach ($this->class as $cls) {
                    $query->where('class', 'like', '%' . $cls . '%');
                }

            })
            ->where('trip_type', 'A')
            ->orderBy('priority', 'asc')
            ->first();
        if (!$air_class) {
            $air_class = AgentFlightCommission::where('airline', $this->airline)
                ->where('origin', null)
                ->where('destination', null)
                ->where($this->antiType, false)
                ->where(function ($query) {
                    foreach ($this->class as $cls) {
                        $query->where('class', 'like', '%' . $cls . '%');
                    }

                })
                ->where('trip_type', 'A')
                ->orderBy('priority', 'asc')
                ->first();
        }
        $sec_trip = AgentFlightCommission::where('airline', null)
            ->where('origin', $this->origin)
            ->where('destination', $this->destination)
            ->where('trip_type', $this->trip_type)
            ->where($this->type, true)
            ->where($this->antiType, false)
            ->where('class', null)
            ->orderBy('priority', 'asc')
            ->first();
        if (!$sec_trip) {
            $sec_trip = AgentFlightCommission::where('airline', null)
                ->where('origin', $this->origin)
                ->where('destination', $this->destination)
                ->where('trip_type', $this->trip_type)
                ->where($this->antiType, false)
                ->where('class', null)
                ->orderBy('priority', 'asc')
                ->first();
        }

        $sec_class = AgentFlightCommission::where('airline', null)
            ->where('origin', $this->origin)
            ->where('destination', $this->destination)
            ->where('trip_type', 'A')
            ->where($this->antiType, false)
            ->where(function ($query) {
                foreach ($this->class as $cls) {
                    $query->where('class', 'like', '%' . $cls . '%');
                }
            })
            ->orderBy('priority', 'asc')
            ->first();

        $trip_class = AgentFlightCommission::where('airline', null)
            ->where('origin', $this->origin)
            ->where('destination', $this->destination)
            ->where('trip_type', $this->trip_type)
            ->where($this->type, true)
            ->where($this->antiType, false)
            ->where(function ($query) {
                foreach ($this->class as $cls) {
                    $query->where('class', 'like', '%' . $cls . '%');
                }
            })
            ->orderBy('priority', 'asc')
            ->first();
        if (!$trip_class) {
            $trip_class = AgentFlightCommission::where('airline', null)
                ->where('origin', $this->origin)
                ->where('destination', $this->destination)
                ->where('trip_type', $this->trip_type)
                ->where($this->antiType, false)
                ->where(function ($query) {
                    foreach ($this->class as $cls) {
                        $query->where('class', 'like', '%' . $cls . '%');
                    }
                })
                ->orderBy('priority', 'asc')
                ->first();
        }
        $commissions = collect([$air_sec, $air_trip, $air_class, $sec_trip, $sec_class, $trip_class]);
        $new = $commissions->filter(function ($item) {
            return $item != null;
        });
        if ($new->count() > 0) {
            $min = $new->min('priority');
            return $new->filter(function ($item) use ($min) {
                return $item->priority == $min;
            })->first();
        } else {
            return false;
        }
    }

    public function getCommissionMatchingOne($airline)
    {

        $air = AgentFlightCommission::where('airline', $this->airline)
            ->where('origin', null)
            ->where('destination', null)
            ->where('trip_type', 'A')
            ->where($this->type, true)
            ->where($this->antiType, false)
            ->where('class', null)
            ->orderBy('priority', 'asc')
            ->first();
        if (!$air) {
            $air = AgentFlightCommission::where('airline', $this->airline)
                ->where('origin', null)
                ->where('destination', null)
                ->where('trip_type', 'A')
                ->where('class', null)
                ->where($this->antiType, false)
                ->orderBy('priority', 'asc')
                ->first();
        }

        $sec = AgentFlightCommission::where('airline', null)
            ->where('origin', $this->origin)
            ->where('destination', $this->destination)
            ->where($this->antiType, false)
            ->where('trip_type', 'A')
            ->where('class', null)
            ->orderBy('priority', 'asc')
            ->first();
//        dd($sec);
        $trip = AgentFlightCommission::where('airline', null)
            ->where('origin', null)
            ->where('destination', null)
            ->where('trip_type', $this->trip_type)
            ->where($this->type, true)
            ->where($this->antiType, false)
            ->where('class', null)
            ->orderBy('priority', 'asc')
            ->first();
        if (!$trip) {
            $trip = AgentFlightCommission::where('airline', null)
                ->where('origin', null)
                ->where('destination', null)
                ->where('trip_type', $this->trip_type)
                ->where($this->antiType, false)
                ->where('class', null)
                ->orderBy('priority', 'asc')
                ->first();
        }
        $class = AgentFlightCommission::where('airline', null)
            ->where('origin', null)
            ->where('destination', null)
            ->where('trip_type', 'A')
            ->where($this->type, true)
            ->where($this->antiType, false)
            ->where(function ($query) {
                foreach ($this->class as $cls) {
                    $query->where('class', 'like', '%' . $cls . '%');
                }

            })
            ->orderBy('priority', 'asc')
            ->first();
        if (!$class) {
            $class = AgentFlightCommission::where('airline', null)
                ->where('origin', null)
                ->where('destination', null)
                ->where('trip_type', 'A')
                ->where($this->antiType, false)
                ->where(function ($query) {
                    foreach ($this->class as $cls) {
                        $query->where('class', 'like', '%' . $cls . '%');
                    }

                })
                ->orderBy('priority', 'asc')
                ->first();
        }
        $commissions = collect([$air, $sec, $trip, $class]);
//        dd($commissions);
        $new = $commissions->filter(function ($item) {
            return $item != null;
        });
        if ($new->count() > 0) {
            $min = $new->min('priority');
            return $new->filter(function ($item) use ($min) {
                return $item->priority == $min;
            })->first();
        } else {
            return false;
        }
    }

    public function getCompulsoryRule()
    {
        $commission = AgentFlightCommission::where('airline', null)
            ->where('origin', null)
            ->where('destination', null)
            ->where($this->type, true)
            ->where($this->antiType, false)
            ->where('trip_type', 'A')
            ->where('class', null)
            ->first();

        if (!$commission) {
            $commission = AgentFlightCommission::where('airline', null)
                ->where('origin', null)
                ->where('destination', null)
                ->where($this->antiType, false)
                ->where('trip_type', 'A')
                ->where('class', null)
                ->first();
        }
        if ($commission) {
            return $commission;
        } else {
            return false;
        }
    }

    public function applyNullCommission($flight)
    {
        $temp = $flight;
        $c = 0;
        foreach ($flight['breakdown'] as $break) {
            $temp['breakdown'][$c]['commission'] = 0;
            $c++;
        }
        return $temp;
    }

    public function applyCommissionRule($flight, $commission)
    {

        $temp = $flight;
        $c = 0;
        $total = 0;
        $basetotal = 0;
        $team = Auth::user()->rolesTeams()->first();
        if (!$team) {
            return false;
        }
        foreach ($flight['breakdown'] as $break) {
            $fare = $break['mbasefare'];
            $tax = $break['tax'];
            $qty = $break['qty'];
            $type = $break['type'];
            $new_price = $this->changePrice($type, $fare, $commission, $team);
            $basetotal = $basetotal + $this->getAmount($new_price) * $qty;
            $total = $total + ($this->getAmount($new_price) + $this->getAmount($tax)) * $qty;
            $temp['breakdown'][$c]['mbasefare'] = $new_price;
            $temp['breakdown'][$c]['commission'] = $this->getAmount($new_price) - $this->getAmount($fare);
            $temp['breakdown'][$c]['mtotal'] = $this->getCurrency($new_price) . ' ' . (($this->getAmount($new_price) + $this->getAmount($tax)) * $qty);
            $c++;
        }
        $temp['pricing']['markedfare'] = $this->getCurrency($flight['pricing']['basefare']) . ' ' . $total;
        $temp['pricing']['mbasefare'] = $this->getCurrency($flight['pricing']['basefare']) . ' ' . $basetotal;
        return $temp;
    }

    public function changePrice($type, $fare, $commission, $team)
    {
        $currency = explode(' ', $fare)[0];
        $amount = explode(' ', $fare)[1];
        $com_details = $commission->values
            ->where('currency', $currency)
            ->where('team_id', $team->id)
            ->first();

        if (!$com_details) {
            return $fare;
        }
        if ($type == 'ADT') {
            $margin = $com_details->adt_margin;
            $calc = $com_details->adt_calc_type;
            $amount_type = $com_details->adt_amount_type;
        }
        if ($type == 'CNN') {
            $margin = $com_details->chd_margin;
            $calc = $com_details->chd_calc_type;
            $amount_type = $com_details->chd_amount_type;
        }
        if ($type == 'INF') {
            $margin = $com_details->inf_margin;
            $calc = $com_details->inf_calc_type;
            $amount_type = $com_details->inf_amount_type;
        }
        if ($type == 'STD') {
            $margin = $com_details->std_margin;
            $calc = $com_details->std_calc_type;
            $amount_type = $com_details->std_amount_type;
        }
        if ($type == 'LBR') {
            $margin = $com_details->lbr_margin;
            $calc = $com_details->lbr_calc_type;
            $amount_type = $com_details->lbr_amount_type;
        }

        if ($margin == 0) {
            return $fare;
        }

        if ($amount_type == '%') {
            if ($calc == '+') {
                $newprice = (int)$amount + (($margin / 100) * $amount);
            } else {
                $newprice = (int)$amount - (($margin / 100) * $amount);
            }

        } else {
            if ($calc == '+') {
                $newprice = $amount + $margin;
            } else {
                $newprice = $amount - $margin;
            }
        }
//        dd($newprice);
        return $currency . ' ' . $newprice;
    }

    public function getAmount($fare)
    {
        return explode(' ', $fare)[1];
    }

    public function getCurrency($fare)
    {
        return explode(' ', $fare)[0];
    }
}
