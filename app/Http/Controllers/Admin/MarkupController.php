<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\MarkupStoreRequest;
use App\Models\InternationalFlight\Markup;
use App\Models\InternationalFlight\MarkupDetail;
use Illuminate\Support\Facades\Auth;

class MarkupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.flights.markups.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(MarkupStoreRequest $request)
    {
//        dd($request->type);
        try {
            $markup = new Markup();
//            $types = collect($request->type);
            if (is_array($request->type) && count($request->type) > 0) {
                $markup->type = json_encode($request->type);
            }

            if (is_array($request->type) && count($request->type) > 0) {
                if (in_array('Sector', $request->type, true)) {
//                    dd($request);
                    $markup->origin = $this->getAirlineCode($request->origin);
                    $markup->destination = $this->getAirlineCode($request->destination);
                }
                if (in_array('Airline', $request->type, true)) {
                    $markup->airline = strtoupper(explode('-', $request->airline)[0]);
                }
                if (in_array('TripType', $request->type, true)) {
                    $markup->trip_type = $request->triptype;
                } else {
                    $markup->trip_type = 'A';
                }
                if (in_array('Class', $request->type, true)) {
                    $markup->class = json_encode($request->class);
                }
            }
            $markup->status = $request->status;
            $markup->user_id = Auth::user()->id;
            $markup->priority = $request->priority;
            $markup->save();


            $detail = new MarkupDetail();
            $detail->markup_id = $markup->id;
            $detail->adt_margin = $this->getMarginValue($request->adtusdmargin);
            $detail->chd_margin = $this->getMarginValue($request->chdusdmargin);
            $detail->inf_margin = $this->getMarginValue($request->infusdmargin);
            $detail->std_margin = $this->getMarginValue($request->stdusdmargin);
            $detail->lbr_margin = $this->getMarginValue($request->lbrusdmargin);

            $detail->adt_calc_type = $this->getCalculationType($request->adtusdmargin);
            $detail->chd_calc_type = $this->getCalculationType($request->chdusdmargin);
            $detail->inf_calc_type = $this->getCalculationType($request->infusdmargin);
            $detail->std_calc_type = $this->getCalculationType($request->stdusdmargin);
            $detail->lbr_calc_type = $this->getCalculationType($request->lbrusdmargin);

            $detail->adt_amount_type = $this->getAmountType($request->adtusdmargin);
            $detail->chd_amount_type = $this->getAmountType($request->chdusdmargin);
            $detail->inf_amount_type = $this->getAmountType($request->infusdmargin);
            $detail->std_amount_type = $this->getAmountType($request->stdusdmargin);
            $detail->lbr_amount_type = $this->getAmountType($request->lbrusdmargin);

            $detail->currency = 'USD';

            $detail->save();


            $details = new MarkupDetail();
            $details->markup_id = $markup->id;
            $details->adt_margin = $this->getMarginValue($request->adtnprmargin);
            $details->chd_margin = $this->getMarginValue($request->chdnprmargin);
            $details->inf_margin = $this->getMarginValue($request->infnprmargin);
            $details->std_margin = $this->getMarginValue($request->stdnprmargin);
            $details->lbr_margin = $this->getMarginValue($request->lbrnprmargin);

            $details->adt_calc_type = $this->getCalculationType($request->adtnprmargin);
            $details->chd_calc_type = $this->getCalculationType($request->chdnprmargin);
            $details->inf_calc_type = $this->getCalculationType($request->infnprmargin);
            $details->std_calc_type = $this->getCalculationType($request->stdnprmargin);
            $details->lbr_calc_type = $this->getCalculationType($request->lbrnprmargin);

            $details->adt_amount_type = $this->getAmountType($request->adtnprmargin);
            $details->chd_amount_type = $this->getAmountType($request->chdnprmargin);
            $details->inf_amount_type = $this->getAmountType($request->infnprmargin);
            $details->std_amount_type = $this->getAmountType($request->stdnprmargin);
            $details->lbr_amount_type = $this->getAmountType($request->lbrnprmargin);
            $details->currency = 'NPR';

            $details->save();

            return redirect()->back()->with('success', 'Markup added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', $e->getMessage())->withInput();
        }
    }

    public function getAirlineCode($string)
    {
//        dd($string);
        return (explode('-', $string)[0]);
    }

    public function getMarginValue($string)
    {
        if ($string == 0) {
            return $string;
        }
        if (is_numeric($string[0]) && is_numeric(substr($string, -1))) {
            return $string;
        }
        if (!(is_numeric($string[0])) && is_numeric(substr($string, -1))) {
            return substr($string, 1);
        }
        if (!(is_numeric($string[0])) && !(is_numeric(substr($string, -1)))) {
//            dd(substr($string,1,-1));
            return substr($string, 1, -1);
        }
        if (is_numeric($string[0]) && !(is_numeric(substr($string, -1)))) {
            return substr($string, 0, -1);
        }
    }


    public function getCalculationType($string)
    {
        $type = $string[0];
        if ($type == '-') {
            return '-';
        } else {
            return '+';
        }
    }

    public function getAmountType($string)
    {
        if (substr($string, -1) == '%') {
            return '%';
        } else {
            return '0';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Model\Markup $markup
     * @return \Illuminate\Http\Response
     */
    public function show(Markup $markup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Model\Markup $markup
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $markup = Markup::with('details')->findorfail($id);

        $np_data = $markup->details->where('currency', 'NPR')->first();
//      dd($np_data);
        $us_data = $markup->details()->where('currency', 'USD')->first();
//        dd($us_data);
        return view('admin.flights.markups.edit', ['markup' => $markup, 'np' => $np_data, 'us' => $us_data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Model\Markup $markup
     * @return \Illuminate\Http\Response
     */
    public function update(MarkupStoreRequest $request)
    {
//        dd($request);
        $markup = Markup::findorfail($request->markup);
//        try {


        if (is_array($request->type) && count($request->type) > 0) {
            if (in_array('airline', $request->type, true)) {
                $airline = strtoupper(explode('-', $request->airline)[0]);
            } else {
                $airline = null;
            }
        } else {
            $airline = null;
        }
//        dd($airline);

        if (is_array($request->type) && count($request->type) > 0) {
            if (in_array('sector', $request->type, true)) {
                $origin = explode('-', $request->origin)[0];
                $destination = explode('-', $request->destination)[0];
            } else {
                $origin = null;
                $destination = null;
            }

        } else {
            $origin = null;
            $destination = null;
        }

        if (is_array($request->type) && count($request->type) > 0) {
            if (in_array('Class', $request->type, true)) {
                $class = json_encode($request->class);
            } else {
                $class = null;
            }
        } else {
            $class = null;
        }

        if (is_array($request->type) && count($request->type) > 0) {
            $type = json_encode($request->type);
        } else {
            $type = null;
        }


        $markup->update([
            'type' => $type,
            'airline' => $airline,
            'origin' => $origin,
            'class' => $class,
            'destination' => $destination,
            'trip_type' => $request->triptype,
            'status' => $request->status,
            'priority' => $request->priority,
            'last_updated_by' => Auth::user()->id
        ]);

        $detail = $markup->details->where('currency', 'NPR')->first();
        $detail->update([
            'adt_margin' => $this->getMarginValue($request->adtnprmargin),
            'chd_margin' => $this->getMarginValue($request->chdnprmargin),
            'inf_margin' => $this->getMarginValue($request->infnprmargin),
            'std_margin' => $this->getMarginValue($request->stdnprmargin),
            'lbr_margin' => $this->getMarginValue($request->lbrnprmargin),
            'adt_calc_type' => $this->getCalculationType($request->adtnprmargin),
            'chd_calc_type' => $this->getCalculationType($request->chdnprmargin),
            'inf_calc_type' => $this->getCalculationType($request->infnprmargin),
            'std_calc_type' => $this->getCalculationType($request->stdnprmargin),
            'lbr_calc_type' => $this->getCalculationType($request->lbrnprmargin),
            'adt_amount_type' => $this->getAmountType($request->adtnprmargin),
            'chd_amount_type' => $this->getAmountType($request->chdnprmargin),
            'inf_amount_type' => $this->getAmountType($request->infnprmargin),
            'std_amount_type' => $this->getAmountType($request->stdnprmargin),
            'lbr_amount_type' => $this->getAmountType($request->lbrnprmargin),

        ]);

        $detail2 = $markup->details->where('currency', 'USD')->first();
//        dd($detail2);
        $detail2->update([
            'adt_margin' => $this->getMarginValue($request->adtusdmargin),
            'chd_margin' => $this->getMarginValue($request->chdusdmargin),
            'inf_margin' => $this->getMarginValue($request->infusdmargin),
            'std_margin' => $this->getMarginValue($request->stdusdmargin),
            'lbr_margin' => $this->getMarginValue($request->lbrusdmargin),
            'adt_calc_type' => $this->getCalculationType($request->adtusdmargin),
            'chd_calc_type' => $this->getCalculationType($request->chdusdmargin),
            'inf_calc_type' => $this->getCalculationType($request->infusdmargin),
            'std_calc_type' => $this->getCalculationType($request->stdusdmargin),
            'lbr_calc_type' => $this->getCalculationType($request->lbrusdmargin),
            'adt_amount_type' => $this->getAmountType($request->adtusdmargin),
            'chd_amount_type' => $this->getAmountType($request->chdusdmargin),
            'inf_amount_type' => $this->getAmountType($request->infusdmargin),
            'std_amount_type' => $this->getAmountType($request->stdusdmargin),
            'lbr_amount_type' => $this->getAmountType($request->lbrusdmargin),

        ]);


        return redirect()->route('markup.index')->with('success', 'Markup updated successfully.');
//        } catch(\Exception $e){
//            return redirect()->back()->with('warning',$e->getMessage());
//        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Model\Markup $markup
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $markup = Markup::findorfail($id);
        $markup->delete();
        return redirect()->back()->with('success', 'Markup deleted successfully');
    }
}
