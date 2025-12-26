<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PriceDetailsRequest;
use App\Models\PriceDetails;
use Illuminate\Http\Request;


class PriceDetailsController extends Controller
{
    protected $data = [];


    public function __construct()
    {
        $this->middleware('auth');
    }


    public function store(Request $request)
    {
        $attr = $request->except('_token');
        try {
            PriceDetails::create($attr);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Inserted Successfully');

    }

    public function update(PriceDetailsRequest $request, $id)
    {
        $attr = $request->except('_token');
        try {
            PriceDetails::where('id', $id)
                ->update($attr);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->back()->with('success', 'Updated Successfully');
    }

    public function delete(PriceDetailsRequest $request)
    {
        $iteneray = PriceDetail::findOrFail($request->id);
        if ($iteneray->delete()) {
            return response(200);
        } else {
            return response(500);
        }
    }
}
