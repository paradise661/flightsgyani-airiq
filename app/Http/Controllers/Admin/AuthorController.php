<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use File;
use Illuminate\Http\Request;
use Image;
use Input;

//use Intervention\Image\Image;
//use Intervention\Image\Facades\Image;

class AuthorController extends Controller
{
    protected $data = [];

    protected $imageSavePath = '/uploads/author/';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
//        dd($request->toArray());
        $attr = $request->except('image', '_token');

        try {
            if ($request->id == 0) {
                if (!empty($request->image)) {
                    $destinationPath = public_path() . '/uploads/author/';
                    $file = $request->image;
                    $imageName = 'uploads/author/' . rand(00001, 99999) . '.' . $file->getClientOriginalExtension();
                    if (!File::exists($destinationPath)) {
                        File::makeDirectory($destinationPath, 0775, true, true);
                    }
                    $file->move($destinationPath, $imageName);

                    $attr['image'] = $imageName;

                }
                Author::create($attr);
            } else {
                $id = $request->id;
                if (!empty($request->image)) {
                    $author = Author::find($id);
                    $path = public_path() . '/uploads/author' . $author->image;
                    \File::delete($path);
//            $author->delete();


                    $destinationPath = public_path() . '/uploads/author/';
                    $file = $request->image;
                    $imageName = 'uploads/author/' . rand(00001, 99999) . '.' . $file->getClientOriginalExtension();
                    if (!File::exists($destinationPath)) {
                        File::makeDirectory($destinationPath, 0775, true, true);
                    }
                    $file->move($destinationPath, $imageName);

                    $attr['image'] = $imageName;
                }

                Author::where('id', $id)->update($attr);

            }


        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('blog.index')->with('success', 'Inserted Successfully');

    }

}
