<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\WhatwedoRequest;
use App\Models\Whatwedo;
use File;
use Illuminate\Http\Request;
use Image;
use Input;
use PDF;
use Yajra\Datatables\Facades\Datatables;

//use Intervention\Image\Image;
//use Intervention\Image\Facades\Image;

class WhatwedoController extends Controller
{
    protected $data = [];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $whatwedos = Whatwedo::all();
        return view('admin.whatwedo.index', compact('whatwedos'));
    }

    public function store(Request $request)
    {
        $attr = $request->except('image', '_token', 'inputCroppedPic');

        try {
            $whatwedo = Whatwedo::create($attr);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->route('whatwedo.index')->with('success', 'Inserted Successfully');

    }


    public function update(Request $request, $id)
    {
        $attr = $request->except('image', '_token', 'inputCroppedPic');
        $whatwedo = Whatwedo::findOrFail($id);
        Whatwedo::where('id', $whatwedo->id)
            ->update($attr);
        return redirect()->route('whatwedo.index')->with('success', 'Updated Successfully');
    }

    public function delete(Request $request)
    {
        $whatwedo = Whatwedo::findOrFail($request->id);
        if ($whatwedo->delete()) {
            return response(200);
        } else {
            return response(500);
        }
        //return redirect()->back()->with('success', 'Deleted Successfully');

    }

}
