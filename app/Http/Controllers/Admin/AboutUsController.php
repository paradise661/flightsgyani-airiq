<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use File;
use Illuminate\Http\Request;
use Image;

class AboutUsController extends Controller
{
    protected $data = [];
    protected $imageSavePath = '/uploads/about/';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['abouts'] = AboutUs::all();
        return view('admin.about-us.index', $data);
    }

    public function store(Request $request)
    {
        try {
            $attr = $request->except('image', '_token', 'inputCroppedPic');

            AboutUs::create($attr);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Inserted Successfully');

    }


    public function update(Request $request, $id)
    {
        try {
            $attr = $request->except('image', '_token', 'inputCroppedPic');
            AboutUs::where('id', $id)
                ->update($attr);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->back()->with('success', 'Updated Successfully');
    }

    public function delete(Request $request)
    {
        $about = AboutUs::findOrFail($request->id);
        if ($about->delete()) {
            return response(200);
        } else {
            return response(500);
        }

    }

}
