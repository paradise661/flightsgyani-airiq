<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\BSPCommissionStoreRequest;
use App\Models\InternationalFlight\BSPCommission;

class BSPCommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.flights.bsp.index');
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
    public function store(BSPCommissionStoreRequest $request)
    {
        try {
            $commission = new BSPCommission();
            $commission->airline = explode('-', $request->airline)[0];
            $commission->commission = $request->commission;
            if ($request->type == 'siti') {
                $commission->with_origin = strtoupper(explode('-', $request->origin)[0]);
            }

            if ($request->type == 'soto') {
                $commission->without_origin = strtoupper(explode('-', $request->origin)[0]);
            }

            $commission->save();
            return redirect()->back()->with('success', 'Commission added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param BSPCommission $bSPCommission
     * @return void
     */
    public function show(BSPCommission $bSPCommission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Model\BSPCommission $bSPCommission
     * @return \Illuminate\Http\Response
     */
    public function edit($bSPCommission)
    {
        return view('admin.flights.bsp.edit', ['commission' => (unserialize(base64_decode($bSPCommission)))]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Model\BSPCommission $bSPCommission
     * @return \Illuminate\Http\Response
     */
    public function update(BSPCommissionStoreRequest $request, $bSPCommission)
    {

        try {
            $commission = BSPCommission::findorFail($bSPCommission);

//            $commission = unserialize(base64_decode($bSPCommission));
            if ($request->type == 'siti') {
                $withOrigin = strtoupper(explode('-', $request->origin)[0]);
            } else {
                $withOrigin = null;
            }
            if ($request->type == 'soto') {
                $withOutOrigin = strtoupper(explode('-', $request->origin)[0]);
            } else {
                $withOutOrigin = null;
            }

            $commission->update([
                'airline' => explode('-', $request->airline)[0],
                'commission' => $request->commission,
                'with_origin' => $withOrigin,
                'without_origin' => $withOutOrigin
            ]);
            return redirect()->route('bspcommission.index')->with('success', 'BSP Commission for ' . $request->airline . ' has been updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', $e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Model\BSPCommission $bSPCommission
     * @return \Illuminate\Http\Response
     */
    public function destroy($bSPCommission)
    {
        try {
            $commission = unserialize(base64_decode($bSPCommission));
//            dd($commission);
            $commission->delete();
            return redirect()->back()->with('success', 'BSP Commission for ' . $commission->airline . ' has been deleted.');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', $e->getMessage());
        }


    }
}
