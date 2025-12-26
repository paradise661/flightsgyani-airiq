<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use File;
use Illuminate\Http\Request;
use Image;
use Input;

//use Intervention\Image\Image;
//use Intervention\Image\Facades\Image;

class BlogController extends Controller
{
    protected $data = [];

    protected $imageSavePath = '/uploads/blog/';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $blogs = Blog::get();
        return view('admin.blog.index', compact('blogs'));
    }


    public function store(BlogRequest $request)
    {
        $attr = $request->except('image', '_token', 'inputCroppedPic');
        try {
            if ($request->has('inputCroppedPic') && $request->inputCroppedPic != null) {
                $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
                Image::make($request->input('inputCroppedPic'))
                    ->encode('jpg')
                    ->save(public_path($destinationPath));
                $attr['image'] = $destinationPath;
            }
            $blogs = Blog::create($attr);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('blog.index')->with('success', 'Inserted Successfully');

    }

    public function update(BlogRequest $request, $id)
    {
        $attr = $request->except('image', '_token', 'inputCroppedPic');
        $blog = Blog::findOrFail($id);

        if ($request->has('inputCroppedPic') && $request->inputCroppedPic != null) {
            $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
            Image::make($request->input('inputCroppedPic'))
                ->encode('jpg')
                ->save(public_path($destinationPath));
            $attr['image'] = $destinationPath;
        }
        Blog::where('id', $blog->id)
            ->update($attr);
        return redirect()->route('blog.index')->with('success', 'Updated Successfully');
    }

    public function delete(Request $request)
    {
        $blog = Blog::findOrFail($request->id);
        $path = public_path() . $this->imageSavePath . $blog->image;
        File::delete($path);
        if ($blog->delete()) {
            return response(200);
        } else {
            return response(500);
        }

    }

}
