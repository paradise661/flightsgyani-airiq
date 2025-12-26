<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OperationalTourRequest;
use App\Models\OperationalTour;
use Illuminate\Http\Request;


class OperationalTourController extends Controller
{
    protected $data = [];


    public function __construct()
    {
        $this->middleware('auth');
    }


    public function store(OperationalTourRequest $request)
    {
        $attr = $request->except('_token');
        try {
            OperationalTour::create($attr);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Inserted Successfully');

    }

    public function update(OperationalTourRequest $request, $id)
    {
        $attr = $request->except('_token');
        try {
            OperationalTour::where('id', $id)
                ->update($attr);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->back()->with('success', 'Updated Successfully');
    }

    public function delete(Request $request)
    {
        $iteneray = OperationalTour::findOrFail($request->id);
        if ($iteneray->delete()) {
            return response(200);
        } else {
            return response(500);
        }
    }
}
