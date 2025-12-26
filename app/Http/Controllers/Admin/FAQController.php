<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FAQ;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FAQController extends Controller
{
    public function index()
    {
        $faq = FAQ::first();
        if (!$faq) {
            $faq = new FAQ();
            $faq->save();
        }
        return view('admin.pages.faq', ['faq' => $faq]);
    }

    public function update(Request $request)
    {
        $faq = FAQ::first();
        $faq->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'content' => $request->description
        ]);
        return redirect()->back()->with('success', 'FAQ updated successfully.');
    }
}
