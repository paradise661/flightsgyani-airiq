<?php

namespace App\Service\Sabre;

use App\Models\AgentMarkup;
use App\Models\InternationalFlight\Markup;
use App\Models\InternationalFlight\SearchFlight;

class AgentMarkupService
{
    protected $origin, $destination, $trip_type, $class, $type, $antiType, $airline;

    public function __construct()
    {
        $search_flight = SearchFlight::findorfail(session()->get('flight_search'));
        $this->origin = $search_flight->arrival;
        $this->destination = $search_flight->destination;
        if ($search_flight->arrival == 'KTM') {
            $this->type = 'siti';
            $this->antiType = 'soto';
        } else {
            $this->antiType = 'siti';
            $this->type = 'soto';
        }
        if ($search_flight->return_date == null) {
            $this->trip_type = 'O';
        }
        if ($search_flight->return_date != null) {
            $this->trip_type = 'R';
        }
    }

    public function addMarkup($flights)
    {
        $newflights = [];
        $search = SearchFlight::findorfail(session()->get('flight_search'));
        $totalQuantity = $search->adults + $search->childs;
        $currency = $search->currency ?? 'NPR';
        $discount = getInternationalFlightDiscounts($search, $currency);

        foreach ($flights as $flight) {
            $this->airline = $flight['airline'];
            $class = [];
            foreach ($flight['flight'] as $foo) {
                foreach ($foo['sectors'] as $bar)

                    array_push($class, $bar['resbook']);
            }

            $this->class = $class;
            $markup = $this->getMarkup();
            if (!$markup) {
                $new = $this->setNullMarkup($flight, $discount);
            } else {
                $new = $this->applyMarkup($flight, $markup, $discount);
            }

            array_push($newflights, $new);
        }
        //        dd($newflights);
        return $newflights;
    }

    public function getMarkup()
    {
        //        dd($this->search->destination);
        $markup = $this->getMarkupMatchingAll();
        if (!$markup) {
            $markup = $this->getMarkupMatchingThree();
            if (!$markup) {
                $markup = $this->getMarkupMatchingTwo();
                if (!$markup) {
                    $markup = $this->getMarkupMatchingOne();
                    //                dd($markup);
                    if (!$markup) {
                        $markup = $this->getCompulsoryMarkups();
                        if (!$markup) {
                            return false;
                        } else {
                            return $markup;
                        }
                    } else {
                        return $markup;
                    }
                } else {
                    return $markup;
                }
            } else {
                return $markup;
            }
        } else {
            return $markup;
        }
    }

    public function getMarkupMatchingAll()
    {

        $markup = AgentMarkup::where('airline', $this->airline)
            ->where('origin', $this->origin)
            ->where('destination', $this->destination)
            ->where('trip_type', 'A')
            ->where(function ($query) {
                foreach ($this->class as $cls) {
                    $query->where('class', 'like', '%' . $cls . '%');
                }
            })
            ->where('status', true)
            ->orderBy('priority')
            ->first();
        if ($markup) {
            return $markup;
        } else {
            return false;
        }
    }

    public function getMarkupMatchingThree()
    {
        $air_sec_trip = AgentMarkup::where('airline', $this->airline)
            ->where('origin', $this->origin)
            ->where('destination', $this->destination)
            ->where('trip_type', $this->trip_type)
            ->where('class', null)
            ->where($this->antiType, false)
            ->where('status', true)
            ->orderBy('priority', 'asc')
            ->first();
        $air_sec_class = AgentMarkup::where('airline', $this->airline)
            ->where('origin', $this->origin)
            ->where('destination', $this->destination)
            ->where($this->antiType, false)
            ->where('trip_type', 'A')
            ->where(function ($query) {
                foreach ($this->class as $cls) {
                    $query->where('class', 'like', '%' . $cls . '%');
                }
            })
            ->where('status', true)
            ->orderBy('priority', 'asc')
            ->first();
        $air_trip_class = AgentMarkup::where('airline', $this->airline)
            ->where('trip_type', $this->trip_type)
            ->where($this->type, true)
            ->where('origin', null)
            ->where('destination', null)
            ->where(function ($query) {
                foreach ($this->class as $cls) {
                    $query->where('class', 'like', '%' . $cls . '%');
                }
            })
            ->where('status', true)
            ->orderBy('priority', 'asc')
            ->first();
        if (!$air_trip_class) {
            $air_trip_class = AgentMarkup::where('airline', $this->airline)
                ->where('trip_type', $this->trip_type)
                ->where('origin', null)
                ->where('destination', null)
                ->where($this->antiType, false)
                ->where(function ($query) {
                    foreach ($this->class as $cls) {
                        $query->where('class', 'like', '%' . $cls . '%');
                    }
                })
                ->where('status', true)
                ->orderBy('priority', 'asc')
                ->first();
        }
        $sec_trip_class = AgentMarkup::where('origin', $this->origin)
            ->where('destination', $this->destination)
            ->where('trip_type', $this->trip_type)
            ->where('airline', null)
            ->where(function ($query) {
                foreach ($this->class as $cls) {
                    $query->where('class', 'like', '%' . $cls . '%');
                }
            })
            ->where($this->antiType, false)
            ->where('status', true)
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

    public function getMarkupMatchingTwo()
    {
        $airline_sector = AgentMarkup::where('origin', $this->origin)
            ->where('destination', $this->destination)
            ->where('airline', $this->airline)
            ->where('status', true)
            ->where('soto', false)
            ->where('siti', false)
            ->where('trip_type', 'A')
            ->where('class', null)
            ->orderBy('priority')
            ->first();

        $airline_trip = AgentMarkup::where('airline', $this->airline)
            ->where('origin', null)
            ->where('destination', null)
            ->where('status', true)
            ->where('trip_type', $this->trip_type)
            ->where('class', null)
            ->where($this->type, true)
            ->orderBy('priority')
            ->first();
        if (!$airline_trip) {
            $airline_trip = AgentMarkup::where('airline', $this->airline)
                ->where('origin', null)
                ->where('destination', null)
                ->where('status', true)
                ->where('trip_type', $this->trip_type)
                ->where('class', null)
                ->where($this->antiType, false)
                ->orderBy('priority')
                ->first();
        }

        $airline_class = AgentMarkup::where('airline', $this->airline)
            ->where('origin', null)
            ->where('destination', null)
            ->where('trip_type', 'A')
            ->where(function ($query) {
                foreach ($this->class as $cls) {
                    $query->where('class', 'like', '%' . $cls . '%');
                }
            })
            ->where($this->type, true)
            ->where('status', true)
            ->orderBy('priority')
            ->first();

        if (!$airline_class) {
            $airline_class = AgentMarkup::where('airline', $this->airline)
                ->where('origin', null)
                ->where('destination', null)
                ->where('trip_type', 'A')
                ->where(function ($query) {
                    foreach ($this->class as $cls) {
                        $query->where('class', 'like', '%' . $cls . '%');
                    }
                })
                ->where($this->antiType, false)
                ->where('status', true)
                ->orderBy('priority')
                ->first();
        }

        $trip_sector = AgentMarkup::where('origin', $this->origin)
            ->where('destination', $this->destination)
            ->where('airline', null)
            ->where('status', true)
            ->where('trip_type', $this->trip_type)
            ->where('soto', false)
            ->where('siti', false)
            ->orderBy('priority')
            ->first();
        $trip_class = AgentMarkup::where('origin', null)
            ->where('destination', null)
            ->where('airline', null)
            ->where('status', true)
            ->where($this->type, true)
            ->where('trip_type', $this->trip_type)
            ->where(function ($query) {
                foreach ($this->class as $cls) {
                    $query->where('class', 'like', '%' . $cls . '%');
                }
            })->orderBy('priority')
            ->first();
        if (!$trip_class) {
            $trip_class = AgentMarkup::where('origin', null)
                ->where('destination', null)
                ->where('airline', null)
                ->where('status', true)
                ->where($this->antiType, false)
                ->where('trip_type', $this->trip_type)
                ->where(function ($query) {
                    foreach ($this->class as $cls) {
                        $query->where('class', 'like', '%' . $cls . '%');
                    }
                })->orderBy('priority')
                ->first();
        }
        $class_sector = AgentMarkup::where('origin', $this->origin)
            ->where('destination', $this->destination)
            ->where('airline', null)
            ->where('trip_type', 'A')
            ->where(function ($query) {
                foreach ($this->class as $cls) {
                    $query->where('class', 'like', '%' . $cls . '%');
                }
            })->where('status', true)
            ->orderBy('priority')
            ->first();


        $markups = collect([$airline_sector, $airline_trip, $trip_sector, $airline_class, $trip_class, $class_sector]);
        //        dd($markups);
        $new = $markups->filter(function ($item) {
            return $item != null;
        });
        //        dd($new);
        if ($new->count() > 0) {
            $min = $new->min('priority');
            //            dd($new);
            return $new->filter(function ($item) use ($min) {
                //                dd($item);
                return $item->priority == $min;
            })->first();
        } else {
            return false;
        }
    }

    public function getMarkupMatchingOne()
    {
        //        $markups = new Collection();
        $air_markup = $this->getMarkupFromAirline();
        $sector_markups = $this->getMarkupFromSector();
        //        dd($sector_markups);
        $trip_markups = $this->getMarkupFromTripType();
        $class_markups = $this->getMarkupFromClass();
        $markups = collect([$air_markup, $sector_markups, $trip_markups, $class_markups]);
        //        $markups = $markups->merge($air_markup)->merge($sector_markups)->merge($trip_markups);
        $new = $markups->filter(function ($item) {
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

    public function getMarkupFromAirline()
    {
        $markup = AgentMarkup::where('airline', $this->airline)
            ->where('origin', null)
            ->where('destination', null)
            ->where('trip_type', 'A')
            ->where($this->type, true)
            ->where('status', true)
            ->orderBy('priority')
            ->first();
        if (!$markup) {
            $markup = AgentMarkup::where('airline', $this->airline)
                ->where('origin', null)
                ->where('destination', null)
                ->where('trip_type', 'A')
                ->where($this->antiType, false)
                ->where('status', true)
                ->orderBy('priority')
                ->first();
        }
        return $markup;
    }

    public function getMarkupFromSector()
    {
        //        dd($this->search->destination);
        $markup = AgentMarkup::where('origin', $this->origin)
            ->where('destination', $this->destination)
            ->where('airline', null)
            ->whereIn('trip_type', ['A', $this->trip_type])
            ->where('status', true)
            ->orderBy('priority')
            ->first();
        //        dd($markup);
        return $markup;
    }

    public function getMarkupFromTripType()
    {
        $markup = AgentMarkup::where('trip_type', $this->trip_type)
            ->where('airline', null)
            ->where('origin', null)
            ->where($this->type, true)
            ->where('destination', null)
            ->orderBy('priority')
            ->where('status', true)
            ->first();
        if (!$markup) {
            $markup = AgentMarkup::where('trip_type', $this->trip_type)
                ->where('airline', null)
                ->where('origin', null)
                ->where($this->antiType, false)
                ->where('destination', null)
                ->orderBy('priority')
                ->where('status', true)
                ->first();
        }
        return $markup;
    }

    public function getMarkupFromClass()
    {
        $markup = AgentMarkup::where('origin', null)
            ->where('destination', null)
            ->where('trip_type', 'A')
            ->where('airline', null)
            ->where(function ($query) {
                foreach ($this->class as $cls) {
                    $query->where('class', 'like', '%' . $cls . '%');
                }
            })
            ->where($this->type, true)
            ->where('status', true)
            ->orderBy('priority')
            ->first();
        if (!$markup) {
            $markup = AgentMarkup::where('origin', null)
                ->where('destination', null)
                ->where('trip_type', 'A')
                ->where('airline', null)
                ->where(function ($query) {
                    foreach ($this->class as $cls) {
                        $query->where('class', 'like', '%' . $cls . '%');
                    }
                })
                ->where($this->antiType, false)
                ->where('status', true)
                ->orderBy('priority')
                ->first();
        }
        return $markup;
    }

    public function getCompulsoryMarkups()
    {
        $markup = AgentMarkup::where('airline', null)
            ->where('origin', null)
            ->where('destination', null)
            ->where('trip_type', 'A')
            ->where('status', true)
            ->where($this->type, true)
            ->orderBy('priority')
            ->first();

        if (!$markup) {
            $markup = AgentMarkup::where('airline', null)
                ->where('origin', null)
                ->where('destination', null)
                ->where('trip_type', 'A')
                ->where('status', true)
                ->where($this->antiType, false)
                ->orderBy('priority')
                ->first();
        }
        if ($markup) {
            return $markup;
        } else {
            return false;
        }
    }

    public function setNullMarkup($flight, $discount)
    {
        $discountAmount = $discount[$flight['airline']] ?? 0;
        $temp = $flight;
        $c = 0;
        foreach ($flight['breakdown'] as $break) {
            $fare = $break['basefare'];
            $tax = $break['tax'];
            $qty = $break['qty'];
            $new_adt = $fare;
            $temp['breakdown'][$c]['mbasefare'] = $new_adt;
            $temp['breakdown'][$c]['markup'] = 0;
            $temp['breakdown'][$c]['mtotal'] = $break['total'];
            $c++;
        }

        $farecurrency = $this->getCurrency($flight['pricing']['total']);
        $fareamount = $this->getAmount($flight['pricing']['total']);
        $temp['pricing']['markedfare'] = $farecurrency . ' ' . ($fareamount - $discountAmount);
        $temp['pricing']['markedfarewithoutdiscount'] = $farecurrency . ' ' . $fareamount;
        $temp['pricing']['mbasefare'] = $flight['pricing']['basefare'];
        $temp['pricing']['discount'] = $farecurrency . ' ' . $discountAmount;
        $temp['pricing']['discountAmount'] = $discountAmount;
        return $temp;
    }

    public function applyMarkup($flight, $markup, $discount)
    {
        $discountAmount = $discount[$flight['airline']] ?? 0;
        $temp = $flight;
        $basetotal = 0;
        $total = 0;
        $c = 0;
        foreach ($flight['breakdown'] as $break) {
            if ($break['type'] == 'ADT') {

                $adt_fare = $break['basefare'];
                $adt_tax = $break['tax'];
                $adt_qty = $break['qty'];
                $new_adt = $this->changePrice($adt_fare, $markup, 'ADT');
                $total = $total + (($this->getAmount($new_adt) + $this->getAmount($adt_tax)) * $adt_qty);
                $basetotal = $basetotal + ($this->getAmount($new_adt) * $adt_qty);
                $temp['breakdown'][$c]['mbasefare'] = $new_adt;
                $temp['breakdown'][$c]['markup'] = $this->getAmount($new_adt) - $this->getAmount($adt_fare);
                $temp['breakdown'][$c]['mtotal'] = $this->getCurrency($adt_fare) . ' ' . (($this->getAmount($new_adt) + $this->getAmount($adt_tax)) * $adt_qty);
            }
            if ($break['type'] == 'CNN') {
                $chd_fare = $break['basefare'];
                $chd_tax = $break['tax'];
                $chd_qty = $break['qty'];
                $new_chd = $this->changePrice($chd_fare, $markup, 'CNN');
                $total = $total + (($this->getAmount($new_chd) + $this->getAmount($chd_tax)) * $chd_qty);
                $basetotal = $basetotal + ($this->getAmount($new_chd) * $chd_qty);
                $temp['breakdown'][$c]['mbasefare'] = $new_chd;
                $temp['breakdown'][$c]['markup'] = $this->getAmount($new_chd) - $this->getAmount($chd_fare);
                $temp['breakdown'][$c]['mtotal'] = $this->getCurrency($chd_fare) . ' ' . (($this->getAmount($new_chd) + $this->getAmount($chd_tax)) * $chd_qty);
            }
            if ($break['type'] == 'INF') {
                $inf_fare = $break['basefare'];
                $inf_tax = $break['tax'];
                $inf_qty = $break['qty'];
                $new_inf = $this->changePrice($inf_fare, $markup, 'INF');
                $total = $total + (($this->getAmount($new_inf) + $this->getAmount($inf_tax)) * $inf_qty);
                $basetotal = $basetotal + ($this->getAmount($new_inf) * $inf_qty);
                $temp['breakdown'][$c]['mbasefare'] = $new_inf;
                $temp['breakdown'][$c]['markup'] = $this->getAmount($new_inf) - $this->getAmount($inf_fare);
                $temp['breakdown'][$c]['mtotal'] = $this->getCurrency($inf_fare) . ' ' . (($this->getAmount($new_inf) + $this->getAmount($inf_tax)) * $inf_qty);
            }

            $c++;
        }
        $farecurrency = $this->getCurrency($flight['pricing']['basefare']);
        $temp['pricing']['markedfare'] = $farecurrency . ' ' . ($total - $discountAmount);
        $temp['pricing']['markedfarewithoutdiscount'] = $farecurrency . ' ' . $total;
        $temp['pricing']['mbasefare'] = $farecurrency . ' ' . $basetotal;
        $temp['pricing']['discount'] = $farecurrency . ' ' . $discountAmount;
        $temp['pricing']['discountAmount'] = $discountAmount;

        return $temp;
    }

    public function changePrice($fare, $markup, $type)
    {
        //        dd($markup);
        $currency = explode(' ', $fare)[0];
        $amount = explode(' ', $fare)[1];
        $detail = $markup->details->where('currency', $currency)->first();
        if (!$detail) {
            return $fare;
        }
        //        dd($currency);
        if ($type == 'ADT') {
            $margin = $detail->adt_margin;
            $calc = $detail->adt_calc_type;
            $amount_type = $detail->adt_amount_type;
        }
        if ($type == 'CNN') {
            $margin = $detail->chd_margin;
            $calc = $detail->chd_calc_type;
            $amount_type = $detail->chd_amount_type;
        }
        if ($type == 'INF') {
            $margin = $detail->inf_margin;
            $calc = $detail->inf_calc_type;
            $amount_type = $detail->inf_amount_type;
        }
        if ($type == 'STD') {
            $margin = $detail->std_margin;
            $calc = $detail->std_calc_type;
            $amount_type = $detail->std_amount_type;
        }
        if ($type == 'LBR') {
            $margin = $detail->lbr_margin;
            $calc = $detail->lbr_calc_type;
            $amount_type = $detail->lbr_amount_type;
        }

        if ($margin == 0) {
            return $fare;
        }

        if ($amount_type == '%') {
            if ($calc == '+') {
                $newprice = $amount + (($margin / 100) * $amount);
            } else {
                $newprice = $amount - (($margin / 100) * $amount);
            }
        } else {
            if ($calc == '+') {
                $newprice = $amount + $margin;
            } else {
                $newprice = $amount - $margin;
            }
        }
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
