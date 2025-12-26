<?php

namespace App\Http\Controllers\Admin\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort_unless(Gate::allows('view admin'), 403);
        }
        activityLog('viewed all permissions');

        return view('admin.v2.permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort_unless(Gate::allows('view admin'), 403);
        }
        return view('admin.v2.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermissionRequest $request)
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort_unless(Gate::allows('view admin'), 403);
        }
        $permission = Permission::create($request->all());
        $role_admin = Role::where('name', 'SUPER-ADMIN')->first();
        $role_admin->givePermissionTo($permission);
        activityLog('added new permission ' . $request->name);

        return redirect()->route('v2.admin.permissions.index')->with('success', 'Permission Deleted');
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
    public function edit(Permission $permission)
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort_unless(Gate::allows('view admin'), 403);
        }
        return view('admin.v2.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort_unless(Gate::allows('view admin'), 403);
        }
        $permission->update($request->all());
        return redirect()->route('v2.admin.permissions.index')->with('success', 'Permission Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort_unless(Gate::allows('view admin'), 403);
        }
        $permission->delete();
        return redirect()->route('v2.admin.permissions.index')->with('success', 'Permission Deleted');
    }
}
