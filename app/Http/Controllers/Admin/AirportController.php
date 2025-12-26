<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\AirportStoreRequest;
use App\Models\InternationalFlight\Airport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AirportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $airports = Airport::orderBy('country')->paginate(100);

        return view('admin.flights.airports.airport', ['airports' => $airports]);
    }


    public function getAirports(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'country',
            2 => 'city',
            3 => 'airport',
            4 => 'code',
            5 => 'actions'
        );
        $totalData = Airport::count();
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        if (empty($request->input('search.value'))) {
            $airports = Airport::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $airports = Airport::where('id', 'LIKE', '%' . $search . '%')
                ->orWhere('country', 'LIKE', '%' . $search . '%')
                ->orWhere('city', 'LIKE', '%' . $search . '%')
                ->orWhere('airport', 'LIKE', '%' . $search . '%')
                ->orWhere('code', 'LIKE', '%' . $search . '%')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Airport::where('id', 'LIKE', '%' . $search . '%')
                ->orWhere('country', 'LIKE', '%' . $search . '%')
                ->orWhere('city', 'LIKE', '%' . $search . '%')
                ->orWhere('airport', 'LIKE', '%' . $search . '%')
                ->orWhere('code', 'LIKE', '%' . $search . '%')
                ->count();
        }
        $data = array();
        if (!empty($airports)) {
            $c = 1;
            foreach ($airports as $airport) {
                $edit = route('airport.edit', $airport->code);
                $delete = route('airport.delete', $airport->code);

                $nestedData['id'] = $c;
                $nestedData['country'] = $airport->country;
                $nestedData['city'] = $airport->city;
                $nestedData['airport'] = $airport->airport;
                $nestedData['code'] = $airport->code;
                $nestedData['actions'] = '<div class="dropdown">
                                        <a class="btn btn-outline-primary dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                            <i class="fa fa-ellipsis-h"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="' . $edit . '" ><i class="fa fa-eye"></i> Edit</a>
                                            <a class="dropdown-item" href="' . $delete . '"><i class="fa fa-trash"></i> Delete</a>
                                        </div>
                                    </div>';
                $c++;
                $data[] = $nestedData;
            }
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            "data" => $data
        );
//        dd($user);
//        return response()->json($user);
        echo json_encode($json_data);

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
    public function store(AirportStoreRequest $request)
    {
//        dd($request);
        $airport = new Airport();
        $airport->country = $request->country;
        $airport->city = $request->city;
        $airport->airport = $request->airport;
        $airport->code = $request->code;
        $airport->save();

        return redirect()->back()->with('success', 'Airport added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param Airport $airport
     * @return Response
     */
    public function show(Airport $airport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Airport $airport
     * @return Response
     */
    public function edit($code)
    {
        $airport = Airport::where('code', $code)->first();
        if (!$airport) {
            return redirect()->back()->with('warning', 'Data Error!!!');
        }
        return view('admin.flights.airports.edit', ['airport' => $airport]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Airport $airport
     * @return Response
     */
    public function update(AirportStoreRequest $request)
    {
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
        return redirect()->route('airport.index')->with('success', 'Airport Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Airport $airport
     * @return Response
     */
    public function destroy($code)
    {
        $airport = Airport::where('code', $code)->first();
        if (!$airport) {
            return redirect()->back()->with('warning', 'Please try again.');
        }
        $airport->delete();
        return redirect()->back()->with('success', 'Airport deleted successfully.');
    }
}
