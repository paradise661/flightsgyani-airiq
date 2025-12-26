<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TermsAndConditionRequest;
use App\Models\TermsAndCondition;
use Illuminate\Http\Request;


class TermsAndConditionsController extends Controller
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
            TermsAndCondition::create($attr);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Inserted Successfully');

    }

    public function update(Request $request, $id)
    {
        $attr = $request->except('_token');
        try {
            TermsAndCondition::where('id', $id)
                ->update($attr);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->back()->with('success', 'Updated Successfully');
    }

    public function delete(Request $request)
    {
        $iteneray = TermsAndCondition::findOrFail($request->id);
        if ($iteneray->delete()) {
            return response(200);
        } else {
            return response(500);
        }
    }
}
