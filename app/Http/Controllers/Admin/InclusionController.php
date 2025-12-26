<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InclusionRequest;
use App\Models\Inclusion;
use Illuminate\Http\Request;


class InclusionController extends Controller
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
            Inclusion::create($attr);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Inserted Successfully');

    }

    public function update(Request $request, $id)
    {
        $attr = $request->except('_token');
        try {
            Inclusion::where('id', $id)
                ->update($attr);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->back()->with('success', 'Updated Successfully');
    }

    public function delete(Request $request)
    {
        $iteneray = Inclusion::findOrFail($request->id);
        if ($iteneray->delete()) {
            return response(200);
        } else {
            return response(500);
        }
    }
}
