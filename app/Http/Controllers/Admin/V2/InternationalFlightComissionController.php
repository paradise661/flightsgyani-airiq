<?php

namespace App\Http\Controllers\Admin\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\InternationalAirlineCommission;
use App\Models\InternationalFlight\Airline;
use App\Models\InternationalFlightCommission;
use Exception;
use Illuminate\Http\Request;

class InternationalFlightComissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // abort_unless(Gate::allows('view domesticairlinecommission'), 403);
        activityLog('viewed international flight discounts');

        return view('admin.v2.internationalflightcommission.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // abort_unless(Gate::allows('create domesticairlinecommission'), 403);

        $airlines = Airline::orderBy('name')->get();
        return view('admin.v2.internationalflightcommission.create', compact('airlines'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InternationalAirlineCommission $request)
    {
        // abort_unless(Gate::allows('create domesticairlinecommission'), 403);

        try {
            $input = $request->all();
            $airline = Airline::find($request->international_airline_id);
            $input['international_airline'] = $airline->name ?? NULL;
            $input['international_airline_code'] = $airline->code ?? NULL;
            InternationalFlightCommission::create($input);
            activityLog('added new international flight discount for ' . $airline->name);

            return redirect()->route('v2.admin.commissions.index')->with('success', 'Commission Added Successfully.');
        } catch (Exception $e) {
            return redirect()->route('v2.admin.commissions.index')->with('warning', $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(InternationalFlightCommission $commission)
    {
        // abort_unless(Gate::allows('edit domesticairlinecommission'), 403);

        $airlines = Airline::orderBy('name')->get();
        return view('admin.v2.internationalflightcommission.edit', compact('commission', 'airlines'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InternationalAirlineCommission $request, InternationalFlightCommission $commission)
    {
        // abort_unless(Gate::allows('edit domesticairlinecommission'), 403);

        try {
            $input = $request->all();
            $airline = Airline::find($request->international_airline_id);
            $input['international_airline'] = $airline->name ?? NULL;
            $input['international_airline_code'] = $airline->code ?? NULL;
            $commission->update($input);
            activityLog('updated international flight discount for ' . $airline->name);

            return redirect()->route('v2.admin.commissions.index')->with('success', 'Commission Updated Successfully.');
        } catch (Exception $e) {
            return redirect()->route('v2.admin.commissions.index')->with('warning', $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(InternationalFlightCommission $commission)
    {
        // abort_unless(Gate::allows('delete domesticairlinecommission'), 403);
        $commission->delete();
        activityLog('deleted international flight discount for ' . $commission->international_airline);

        return redirect()->route('v2.admin.commissions.index')->with('success', 'Commission Deleted Successfully');
    }
}
