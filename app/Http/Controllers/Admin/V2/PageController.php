<?php

namespace App\Http\Controllers\Admin\v2;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\PageCrudStoreRequest;
use App\Http\Requests\Back\PageCrudUpdateRequest;
use App\Models\Page;
use File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Gate;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('view page'), 403);
        activityLog('viewed pages');

        return view('admin.v2.page.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(Gate::allows('create page'), 403);

        return view('admin.v2.page.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageCrudStoreRequest $request)
    {
        abort_unless(Gate::allows('create page'), 403);

        try {
            $input = $request->all();
            $input['image'] = $this->fileUpload($request, 'image');
            $input['slug'] = Str::slug($request->title);
            Page::create($input);
            activityLog('added new page named ' . $request->title);

            return redirect()->route('v2.admin.pages.index')->with('success', 'Page added successfully.');
        } catch (Exception $e) {
            return redirect()->route('v2.admin.pages.index')->with('warning', $e->getMessage())->withInput();
        }
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
    public function edit(Page $page)
    {
        abort_unless(Gate::allows('edit page'), 403);

        return view('admin.v2.page.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PageCrudUpdateRequest $request, Page $page)
    {
        abort_unless(Gate::allows('edit page'), 403);

        try {
            $old_image = $page->image;
            $input = $request->all();
            $image = $this->fileUpload($request, 'image');

            if ($image) {
                $this->removeFile($old_image);
                $input['image'] = $image;
            } else {
                unset($input['image']);
            }

            $input['slug'] = Str::slug($request->title);
            $page->update($input);
            activityLog('updated page named ' . $request->title);

            return redirect()->route('v2.admin.pages.index')->with('success', 'Page updated successfully.');
        } catch (Exception $e) {
            return redirect()->route('v2.admin.pages.index')->with('warning', $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        abort_unless(Gate::allows('delete page'), 403);

        $this->removeFile($page->image);
        $page->delete();
        activityLog('deleted page named ' . $page->title);
        return redirect()->route('v2.admin.pages.index')->with('success', 'Page deleted Successfully');
    }

    public function fileUpload(Request $request, $name)
    {
        $imageName = '';
        if ($image = $request->file($name)) {
            $destinationPath = public_path() . '/uploads/page';
            $imageName = date('YmdHis') . $name . "-" . $image->getClientOriginalName();
            $image->move($destinationPath, $imageName);
            $image = $imageName;
        }
        return $imageName;
    }


    public function removeFile($file)
    {
        // $file2 = explode(asset('/uploads/page') . '/', $file);
        if ($file) {
            $path = public_path() . '/uploads/page/' . $file;
            if (File::exists($path)) {
                File::delete($path);
            }
        }
    }
}
