<?php

namespace App\Http\Controllers\Admin\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\BSPCommissionStoreRequest;
use App\Models\InternationalFlight\BSPCommission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BSPCommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('view bspcommission'), 403);
        activityLog('viewed international BSP Commissions');

        return view('admin.v2.intlflights.bsp.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(Gate::allows('create bspcommission'), 403);

        return view('admin.v2.intlflights.bsp.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BSPCommissionStoreRequest $request)
    {
        abort_unless(Gate::allows('create bspcommission'), 403);

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
            activityLog('added new international BSP Commission named ' . explode('-', $request->airline)[0]);

            return redirect()->route('v2.admin.bspcommission.index')->with('success', 'Commission added successfully.');
        } catch (\Exception $e) {
            return redirect()->route('v2.admin.bspcommission.index')->with('warning', $e->getMessage());
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
    public function edit($bSPCommission)
    {
        abort_unless(Gate::allows('edit bspcommission'), 403);

        return view('admin.v2.intlflights.bsp.edit', ['commission' => (unserialize(base64_decode($bSPCommission)))]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BSPCommissionStoreRequest $request, $bSPCommission)
    {
        abort_unless(Gate::allows('edit bspcommission'), 403);

        try {
            $commission = BSPCommission::findorFail($bSPCommission);
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
            activityLog('updated new international BSP Commission named ' . explode('-', $request->airline)[0]);

            return redirect()->route('v2.admin.bspcommission.index')->with('success', 'BSP Commission for ' . $request->airline . ' has been updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($bSPCommission)
    {
        abort_unless(Gate::allows('delete bspcommission'), 403);

        try {
            $commission = unserialize(base64_decode($bSPCommission));
            $commission->delete();
            activityLog('added new international BSP Commission named ' . $commission->airline);

            return redirect()->back()->with('success', 'BSP Commission for ' . $commission->airline . ' has been deleted.');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', $e->getMessage());
        }
    }
}
