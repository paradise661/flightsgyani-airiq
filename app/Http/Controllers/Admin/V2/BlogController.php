<?php

namespace App\Http\Controllers\Admin\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use Illuminate\Http\Request;
use Image;
use File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    protected $data = [];

    protected $imageSavePath = '/uploads/blog/';

    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('view blog'), 403);
        activityLog('viewed blogs');

        return view('admin.v2.blog.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(Gate::allows('create blog'), 403);

        return view('admin.v2.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogRequest $request)
    {
        abort_unless(Gate::allows('create blog'), 403);

        $attr = $request->except('image', '_token');
        $attr['slug'] = Str::slug($request->title);
        try {
            if ($request->has('image') && $request->image != null) {
                $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
                Image::make($request->input('image'))
                    ->encode('jpg')
                    ->save(public_path($destinationPath));
                $attr['image'] = $destinationPath;
            }
            Blog::create($attr);
            activityLog('add new blog named ' . $request->title);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('v2.admin.blog.index')->with('success', 'Inserted Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        abort_unless(Gate::allows('edit blog'), 403);

        return view('admin.v2.blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogRequest $request, Blog $blog)
    {
        abort_unless(Gate::allows('edit blog'), 403);

        $attr = $request->except('image', '_token');
        $attr['slug'] = Str::slug($request->title);
        if ($request->has('image') && $request->image != null) {
            $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
            Image::make($request->input('image'))
                ->encode('jpg')
                ->save(public_path($destinationPath));
            $attr['image'] = $destinationPath;
            $path = public_path() . $blog->image;
            File::delete($path);
        }

        $blog->update($attr);
        activityLog('updated blog named ' . $request->title);

        return redirect()->route('v2.admin.blog.index')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        abort_unless(Gate::allows('delete blog'), 403);

        $path = public_path() . $blog->image;
        File::delete($path);
        $blog->delete();
        activityLog('deleted blog named ' . $blog->title);

        return redirect()->route('v2.admin.blog.index')->with('success', 'Blog Deleted Successfully');
    }
}
