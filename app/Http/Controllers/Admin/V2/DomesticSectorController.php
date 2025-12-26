<?php

namespace App\Http\Controllers\Admin\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\SectorRequest;
use App\Http\Requests\Request as RequestsRequest;
use App\Models\Domestic\DomesticSector;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Gate;

class DomesticSectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('view sector'), 403);
        activityLog('viewed domestic sectors');

        return view('admin.v2.sector.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(Gate::allows('create sector'), 403);

        return view('admin.v2.sector.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SectorRequest $request)
    {
        abort_unless(Gate::allows('create sector'), 403);

        try {
            $input = $request->all();
            DomesticSector::create($input);
            activityLog('added new domestic sector with name ' . $request->name);

            return redirect()->route('v2.admin.domestic.sectors.index')->with('success', 'Sector Added Successfully.');
        } catch (Exception $e) {
            return redirect()->route('v2.admin.domestic.sectors.index')->with('warning', $e->getMessage())->withInput();
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
    public function edit(DomesticSector $sector)
    {
        abort_unless(Gate::allows('edit sector'), 403);

        return view('admin.v2.sector.edit', compact('sector'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SectorRequest $request, DomesticSector $sector)
    {
        abort_unless(Gate::allows('edit sector'), 403);

        try {
            $sector->update($request->all());
            activityLog('updated domestic sector with name ' . $request->name);

            return redirect()->route('v2.admin.domestic.sectors.index')->with('success', 'Sector Updated Successfully.');
        } catch (Exception $e) {
            return redirect()->route('v2.admin.domestic.sectors.index')->with('warning', $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DomesticSector $sector)
    {
        abort_unless(Gate::allows('delete sector'), 403);

        $sector->delete();
        activityLog('deleted domestic sector with name ' . $sector->name);

        return redirect()->route('v2.admin.domestic.sectors.index')->with('success', 'Sector Deleted Successfully');
    }
}
