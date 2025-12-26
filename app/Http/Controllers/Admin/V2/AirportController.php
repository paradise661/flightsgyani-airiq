<?php

namespace App\Http\Controllers\Admin\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\AirportStoreRequest;
use App\Models\InternationalFlight\Airport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AirportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('view airport'), 403);
        activityLog('viewed international airport details');
        return view('admin.v2.intlflights.airports.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(Gate::allows('create airport'), 403);

        return view('admin.v2.intlflights.airports.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AirportStoreRequest $request)
    {
        abort_unless(Gate::allows('create airport'), 403);

        $airport = new Airport();
        $airport->country = $request->country;
        $airport->city = $request->city;
        $airport->airport = $request->airport;
        $airport->code = $request->code;
        $airport->save();
        activityLog('added new international airport named ' . $request->airport);

        return redirect()->route('v2.admin.airport.index')->with('success', 'Airport added successfully.');
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
    public function edit($code)
    {
        abort_unless(Gate::allows('edit airport'), 403);

        $airport = Airport::where('code', $code)->first();
        if (!$airport) {
            return redirect()->back()->with('warning', 'Data Error!!!');
        }
        return view('admin.v2.intlflights.airports.edit', ['airport' => $airport]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AirportStoreRequest $request)
    {
        abort_unless(Gate::allows('edit airport'), 403);

        $airport = Airport::where('code', $request->data)->first();
        if (!$airport) {
            return redirect()->back()->with('warning', 'Not Found.');
        }
        $airport->update([
            'country' => $request->country,
            'city' => $request->city,
            'airport' => $request->airport,
            'code' => $request->code
        ]);
        activityLog('updated international airport named ' . $request->airport);

        return redirect()->route('v2.admin.airport.index')->with('success', 'Airport Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($code)
    {
        abort_unless(Gate::allows('delete airport'), 403);

        $airport = Airport::where('code', $code)->first();
        if (!$airport) {
            return redirect()->back()->with('warning', 'Please try again.');
        }
        $airport->delete();
        activityLog('deleted international airport named ' . $airport->airport);

        return redirect()->back()->with('success', 'Airport deleted successfully.');
    }
}
