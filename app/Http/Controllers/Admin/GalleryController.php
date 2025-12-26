<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GalleryRequest;
use App\Models\Gallery;
use File;
use Illuminate\Http\Request;

class GalleryController extends Controller
{

    protected $data = [];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['galleries'] = Gallery::all();
        return view('admin.gallery.index', $data);
    }

    public function add()
    {
        return view('admin.gallery.add');
    }

    public function store(GalleryRequest $request)
    {
//        dd($request->toArray());
        $destinationPath = public_path() . '/uploads/gallery/';
        $galleries = Gallery::create([
            'caption' => $request['caption'],

        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = $galleries->id . '.' . $file->getClientOriginalExtension();
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0775, true, true);
            }
            $file->move($destinationPath, $imageName);
            $galleries->image = $imageName;
            $galleries->save();
        }
        return redirect()->route('gallery.index')->with('success', 'Inserted Successfully');

    }

    public function edit($id)
    {
        $this->data['gallery'] = Gallery::find($id);
        return view('admin.gallery.add', $this->data);
    }

    public function show($id)
    {
        return 'show';
        $this->data['query'] = News::findOrFail($id);
        return view('admin.news.edit', $this->data);

    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'caption' => 'required',
        ]);
        $destinationPath = public_path() . '/uploads/gallery/';
        $gallery = Gallery::findOrFail($id);
        Gallery::where('id', $gallery->id)
            ->update([
                'caption' => $request['caption'],
            ]);

        if ($request->hasFile('image')) {
            $path = public_path() . '/uploads/gallery/' . $gallery->image;
            File::delete($path);
            $file = $request->file('image');
            $imageName = $gallery->id . '.' . $file->getClientOriginalExtension();
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0775, true, true);
            }
            $file->move($destinationPath, $imageName);
            $gallery->image = $imageName;
            $gallery->save();
        }
        return redirect()->route('gallery.index')->with('success', 'Updated Successfully');
    }

    public function delete(Request $request)
    {
        $gallery = Gallery::findOrFail($request->id);
        $path = public_path() . '/uploads/gallery/' . $gallery->image;
        File::delete($path);
        if ($gallery->delete()) {
            return response(200);
        } else {
            return response(500);
        }
        //return redirect()->back()->with('success', 'Deleted Successfully');

    }

}
