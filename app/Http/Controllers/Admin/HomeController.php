<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Home;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $homes = Home::get();
        return view('admin.home.index', compact('homes'));
    }

    public function edit($id)
    {
        $this->data['homes'] = Home::find($id);
        return view('admin.home.form', $this->data);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'home' => 'required',
        ]);
        $home = Home::findOrFail($id);
        $home->update([
            'home' => $request['home'],
        ]);

        return redirect()->route('home.index')->with('success', 'Updated Successfully');
    }
}
