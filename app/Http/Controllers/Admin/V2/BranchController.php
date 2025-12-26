<?php

namespace App\Http\Controllers\Admin\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\BranchStoreRequest;
use App\Models\Branch;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Gate;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('view branch'), 403);
        activityLog('viewed all branches');

        return view('admin.v2.branch.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(Gate::allows('create branch'), 403);

        return view('admin.v2.branch.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BranchStoreRequest $request)
    {
        abort_unless(Gate::allows('create branch'), 403);

        try {
            $input = $request->all();
            Branch::create($input);
            activityLog('added new branch named ' . $request->title);

            return redirect()->route('v2.admin.branches.index')->with('success', 'Branch added successfully.');
        } catch (Exception $e) {
            return redirect()->route('v2.admin.branches.index')->with('warning', $e->getMessage())->withInput();
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
    public function edit(Branch $branch)
    {
        abort_unless(Gate::allows('edit branch'), 403);

        return view('admin.v2.branch.edit', compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BranchStoreRequest $request, Branch $branch)
    {
        abort_unless(Gate::allows('edit branch'), 403);

        try {
            $input = $request->all();
            $branch->update($input);
            activityLog('updated branch named ' . $request->title);

            return redirect()->route('v2.admin.branches.index')->with('success', 'Branch updated successfully.');
        } catch (Exception $e) {
            return redirect()->route('v2.admin.branches.index')->with('warning', $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {
        abort_unless(Gate::allows('delete branch'), 403);

        $branch->delete();
        activityLog('deleted branch named ' . $branch->title);

        return redirect()->route('v2.admin.branches.index')->with('success', 'Branch deleted Successfully');
    }
}
