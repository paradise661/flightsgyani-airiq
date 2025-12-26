<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TermCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TermConditionsController extends Controller
{
    public function index()
    {
        $tc = TermCondition::first();
        if (!$tc) {
            $tc = new TermCondition();
            $tc->save();
        }
        return view('admin.pages.tc', ['tc' => $tc]);
    }

    public function update(Request $request)
    {
        $tc = TermCondition::first();
        $tc->update([
            'title' => $request->title,
            'content' => $request->description,
            'slug' => Str::slug($request->title, '-')
        ]);

        return redirect()->back()->with('success', 'Terms & Conditions updated successfully.');
    }
}
