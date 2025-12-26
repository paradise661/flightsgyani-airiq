<?php

namespace App\Http\Controllers\Admin\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
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
        activityLog('viewed all roles');

        return view('admin.v2.roles.index');
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
        $permissions = Permission::all();
        $emp = [];
        foreach ($permissions as $permission) {
            $emp[$permission->parent][] = $permission;
        }
        $permissions = $emp;
        return view('admin.v2.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort_unless(Gate::allows('view admin'), 403);
        }
        $role = Role::create($request->except('permissions'));
        $role->givePermissionTo($request->permission);
        activityLog('added new role named ' . $request->name);

        return redirect()->route('v2.admin.roles.index')->with('success', 'Role Created');
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
    public function edit(Role $role)
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort_unless(Gate::allows('view admin'), 403);
        }

        if ($role->name == 'SUPER-ADMIN') {
            abort_unless(Gate::allows('view admin'), 403);
        }
        $permissions = Permission::get();

        $emp = [];
        foreach ($permissions as $permission) {
            $emp[$permission->parent][] = $permission;
        }
        $permission = $emp;

        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('admin.v2.roles.edit', compact('role', 'permission', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, Role $role)
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort_unless(Gate::allows('view admin'), 403);
        }
        if ($role->name == 'SUPER-ADMIN') {
            abort_unless(Gate::allows('view admin'), 403);
        }
        $role->update($request->except('permissions'));
        $role->permissions()->detach();
        $role->givePermissionTo($request->permission);
        activityLog('updated role named ' . $request->name);

        return redirect()->route('v2.admin.roles.index')->with('success', 'Role Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort_unless(Gate::allows('view admin'), 403);
        }
        if ($role->name == 'SUPER-ADMIN') {
            abort_unless(Gate::allows('view admin'), 403);
        }
        $role->delete();
        $role->permissions()->detach();
        activityLog('deleted role named ' . $role->name);

        return redirect()->route('v2.admin.roles.index')->with('success', 'Role Deleted');
    }
}
