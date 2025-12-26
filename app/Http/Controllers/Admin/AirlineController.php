<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\AirlineStoreRequest;
use App\Models\InternationalFlight\Airline;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class AirlineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $airlines = Airline::all();
        return view('admin.flights.airlines.index', ['airlines' => $airlines]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(AirlineStoreRequest $request)
    {
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
            return redirect()->back()->with('success', 'Airline added successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('warning', $e->getMessage())->withInput();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param Airline $airline
     * @return Response
     */
    public function show(Airline $airline)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Airline $airline
     * @return Response
     */
    public function edit($code)
    {
        $airline = Airline::where('code', $code)->first();
        if (!$airline) {
            return redirect()->back()->with('warning', 'No Data Found.');
        }
        return view('admin.flights.airlines.edit', ['airline' => $airline]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Airline $airline
     * @return Response
     */
    public function update(Request $request)
    {
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
            return redirect()->route('airline.index')->with('success', 'Airline updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', $e->getMessage());
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Airline $airline
     * @return Response
     */
    public function destroy($code)
    {
        $airline = Airline::where('code', $code)->first();
        if (!$airline) {
            return redirect()->back()->with('warning', 'No Data Found.');
        }
        Storage::disk('airlines')->delete($airline->image);
        $airline->delete();
        return redirect()->back()->with('success', 'Airline deleted successfully.');
    }

    public function autoComplete(Request $request)
    {
        $search = $request->get('term');
        $result = Airline::where('name', 'LIKE', '%' . $search . '%')
            ->orWhere('code', 'LIKE', '%' . $search . '%')
            ->get();
        $data = array();
        foreach ($result as $hsl) {
            $data[] = $hsl->code . '-' . $hsl->name;
        }
        return response()->json($data);
    }
}
