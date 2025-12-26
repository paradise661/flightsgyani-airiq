<?php

namespace App\Http\Controllers\Admin\V2;

use App\Http\Controllers\Controller;
use App\Models\Whatwedo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class WhatwedoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('view whatwedo'), 403);
        activityLog('viewed what we do');

        return view('admin.v2.whatwedo.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(Gate::allows('create whatwedo'), 403);

        return view('admin.v2.whatwedo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_unless(Gate::allows('create whatwedo'), 403);

        Whatwedo::create($request->all());
        activityLog('added new what we do named ' . $request->title);

        return redirect()->route('v2.admin.whatwedo.index')->with('success', 'What we do created successfully');
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
    public function edit(Whatwedo $whatwedo)
    {
        abort_unless(Gate::allows('edit whatwedo'), 403);

        return view('admin.v2.whatwedo.edit', compact('whatwedo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Whatwedo $whatwedo)
    {
        abort_unless(Gate::allows('edit whatwedo'), 403);

        $whatwedo->update($request->all());
        activityLog('updated what we do named ' . $request->title);

        return redirect()->route('v2.admin.whatwedo.index')->with('success', 'What we do updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Whatwedo $whatwedo)
    {
        abort_unless(Gate::allows('delete whatwedo'), 403);

        $whatwedo->delete();
        activityLog('deleted what we do named ' . $whatwedo->title);

        return redirect()->route('v2.admin.whatwedo.index')->with('success', 'What we do deleted successfully');
    }
}
