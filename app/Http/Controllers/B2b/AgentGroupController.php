<?php

namespace App\Http\Controllers\B2b;

use App\Http\Controllers\Controller;
use App\Http\Requests\B2B\AgentGroupRequest;
use App\Models\B2B\AgentGroup;
use Illuminate\Http\Request;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AgentGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort(403);
        }
        activityLog('viewed agent groups');

        return view('b2b.agentgroup.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort(403);
        }
        return view('b2b.agentgroup.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AgentGroupRequest $request)
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort(403);
        }
        try {
            $input = $request->all();
            $input['created_by'] = Auth::user()->id;
            AgentGroup::create($input);
            activityLog('added new agent group named ' . $request->name);

            return redirect()->route('v2.admin.agentgroups.index')->with('success', 'Agent Group added successfully.');
        } catch (Exception $e) {
            return redirect()->route('v2.admin.agentgroups.index')->with('warning', $e->getMessage())->withInput();
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
    public function edit(AgentGroup $agentgroup)
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort(403);
        }
        return view('b2b.agentgroup.edit', compact('agentgroup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AgentGroupRequest $request, AgentGroup $agentgroup)
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort(403);
        }
        try {
            $input = $request->all();
            $input['created_by'] = Auth::user()->id;
            $agentgroup->update($input);
            activityLog('updated agent group named ' . $request->name);

            return redirect()->route('v2.admin.agentgroups.index')->with('success', 'Agent Group updated successfully.');
        } catch (Exception $e) {
            return redirect()->route('v2.admin.agentgroups.index')->with('warning', $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AgentGroup $agentgroup)
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort(403);
        }
        $agentgroup->delete();
        activityLog('deleted agent group named ' . $agentgroup->name);

        return redirect()->route('v2.admin.agentgroups.index')->with('success', 'Agent Group deleted Successfully');
    }
}
