<?php

namespace App\Http\Controllers\Admin\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\AirlineStoreRequest;
use App\Models\InternationalFlight\Airline;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class AirlineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('view airline'), 403);
        activityLog('viewed international airlines');

        return view('admin.v2.intlflights.airlines.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(Gate::allows('create airline'), 403);

        return view('admin.v2.intlflights.airlines.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AirlineStoreRequest $request)
    {
        abort_unless(Gate::allows('create airline'), 403);

        try {
            $airline = new Airline();
            $airline->name = $request->name;
            $airline->code = $request->code;
            if (isset($request->image)) {
                if ($request->hasFile('image')) {
                    $filename = $request->code . '.png';
                    $path = $request->file('image')->storeAs('', $filename, ['disk' => 'airlines']);
                    $airline->image = $filename;
                }
            } else {
                $airline->image = $airline->code . '.png';
            }
            $airline->save();
            activityLog('added new international airline named ' . $request->name);

            return redirect()->route('v2.admin.airline.index')->with('success', 'Airline added successfully.');
        } catch (Exception $e) {
            return redirect()->route('v2.admin.airline.index')->with('warning', $e->getMessage())->withInput();
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
    public function edit($code)
    {
        abort_unless(Gate::allows('edit airline'), 403);

        $airline = Airline::where('code', $code)->first();
        if (!$airline) {
            return redirect()->back()->with('warning', 'No Data Found.');
        }
        return view('admin.v2.intlflights.airlines.edit', ['airline' => $airline]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort_unless(Gate::allows('edit airline'), 403);

        $airline = Airline::where('id', $request->data)->first();
        if (!$airline) {
            return redirect()->back()->with('warning', 'No Data Found.');
        }
        try {
            if ($request->hasFile('image')) {
                Storage::disk('airlines')->delete($airline->image);
                $filename = $request->code . '.png';
                $path = $request->file('image')->storeAs('', $filename, ['disk' => 'airlines']);
                $airline->update([
                    'name' => $request->name,
                    'code' => $request->code,
                    'image' => $filename
                ]);
            } else {
                $airline->update([
                    'name' => $request->name,
                    'code' => $request->code,
                ]);
            }
            activityLog('updated international airline named ' . $request->name);

            return redirect()->route('v2.admin.airline.index')->with('success', 'Airline updated successfully.');
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
    public function destroy($code)
    {
        abort_unless(Gate::allows('delete airline'), 403);

        $airline = Airline::where('code', $code)->first();
        if (!$airline) {
            return redirect()->back()->with('warning', 'No Data Found.');
        }
        Storage::disk('airlines')->delete($airline->image);
        $airline->delete();
        activityLog('deleted international airline named ' . $airline->name);

        return redirect()->back()->with('success', 'Airline deleted successfully.');
    }
}
