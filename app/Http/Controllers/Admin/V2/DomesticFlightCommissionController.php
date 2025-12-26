<?php

namespace App\Http\Controllers\Admin\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\DomesticAirlineCommissionRequest;
use App\Models\Domestic\DomesticAirline;
use App\Models\Domestic\DomesticFlightCommission;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Gate;

class DomesticFlightCommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('view domesticairlinecommission'), 403);
        activityLog('viewed domestic flight discounts');

        return view('admin.v2.domesticflightcommission.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(Gate::allows('create domesticairlinecommission'), 403);

        $airlines = DomesticAirline::oldest('order')->get();
        return view('admin.v2.domesticflightcommission.create', compact('airlines'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DomesticAirlineCommissionRequest $request)
    {
        abort_unless(Gate::allows('create domesticairlinecommission'), 403);

        try {
            $input = $request->all();
            $airline = DomesticAirline::find($request->domestic_airline_id);
            $input['domestic_airline'] = $airline->name ?? NULL;
            $input['domestic_airline_code'] = $airline->code ?? NULL;
            DomesticFlightCommission::create($input);
            activityLog('added new domestic flight discount for ' . $airline->name);

            return redirect()->route('v2.admin.domestic.commissions.index')->with('success', 'Commission Added Successfully.');
        } catch (Exception $e) {
            return redirect()->route('v2.admin.domestic.commissions.index')->with('warning', $e->getMessage())->withInput();
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
    public function edit(DomesticFlightCommission $commission)
    {
        abort_unless(Gate::allows('edit domesticairlinecommission'), 403);

        $airlines = DomesticAirline::oldest('order')->get();
        return view('admin.v2.domesticflightcommission.edit', compact('commission', 'airlines'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DomesticAirlineCommissionRequest $request, DomesticFlightCommission $commission)
    {
        abort_unless(Gate::allows('edit domesticairlinecommission'), 403);

        try {
            $input = $request->all();
            $airline = DomesticAirline::find($request->domestic_airline_id);
            $input['domestic_airline'] = $airline->name ?? NULL;
            $input['domestic_airline_code'] = $airline->code ?? NULL;
            $commission->update($input);
            activityLog('updated domestic flight discount for ' . $airline->name);

            return redirect()->route('v2.admin.domestic.commissions.index')->with('success', 'Commission Updated Successfully.');
        } catch (Exception $e) {
            return redirect()->route('v2.admin.domestic.commissions.index')->with('warning', $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DomesticFlightCommission $commission)
    {
        abort_unless(Gate::allows('delete domesticairlinecommission'), 403);

        $commission->delete();
        activityLog('deleted domestic flight discount for ' . $commission->domestic_airline);

        return redirect()->route('v2.admin.domestic.commissions.index')->with('success', 'Commission Deleted Successfully');
    }
}
