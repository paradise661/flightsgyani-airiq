<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PrivacyPolicyController extends Controller
{
    public function index()
    {
        $pp = PrivacyPolicy::first();
        if (!$pp) {
            $pp = new PrivacyPolicy();
            $pp->save();
        }
        return view('admin.pages.pp', ['pp' => $pp]);
    }

    public function update(Request $request)
    {
        $pp = PrivacyPolicy::first();
        $pp->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'content' => $request->description
        ]);
        return redirect()->back()->with('success', 'Privacy Policy updated successfully.');
    }
}
