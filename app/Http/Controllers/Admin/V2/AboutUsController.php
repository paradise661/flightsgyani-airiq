<?php

namespace App\Http\Controllers\Admin\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\AboutUsRequest;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Gate;

class AboutUsController extends Controller
{
    protected $data = [];
    protected $imageSavePath = '/uploads/about/';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('view about'), 403);
        activityLog('viewed all about us');

        return view('admin.v2.about.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AboutUsRequest $request)
    {
        abort_unless(Gate::allows('edit about'), 403);

        try {
            $attr = $request->except('image', '_token', 'inputCroppedPic');

            AboutUs::create($attr);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        activityLog('added new about us named ' . $request->name);

        return redirect()->back()->with('success', 'Inserted Successfully');
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
    public function edit(AboutUs $aboutu)
    {
        abort_unless(Gate::allows('edit about'), 403);

        return view('admin.v2.about.edit', compact('aboutu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AboutUsRequest $request, AboutUs $aboutu)
    {
        abort_unless(Gate::allows('edit about'), 403);

        try {
            $attr = $request->except('image', '_token', 'inputCroppedPic');
            $input = $request->all();
            $aboutu->update($input);
            activityLog('updated about us named ' . $request->name);

            return redirect()->route('v2.admin.aboutus.index')->with('success', 'About updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AboutUs $aboutu)
    {
        abort_unless(Gate::allows('delete about'), 403);

        return 1;
        $aboutu->delete();
        activityLog('deleted about us named ' . $aboutu->name);

        return redirect()->route('v2.admin.aboutus.index')->with('success', 'About deleted Successfully');
    }
}
