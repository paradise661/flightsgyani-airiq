<?php

namespace App\Http\Controllers\Admin\V2;

use App\Http\Controllers\Controller;
use App\Http\Livewire\Admin\Roles;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
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
        activityLog('viewed all staffs');

        return view('admin.v2.users.index');
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
        $roles = Role::whereNotIn('name', ['SUPER-ADMIN'])->get();
        return view('admin.v2.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort_unless(Gate::allows('view admin'), 403);
        }
        $input = $request->except('roles');
        $input['user_type'] = 'ADMIN';
        $input['active'] = 1;
        $input['password'] = Hash::make($request->password);
        $user = User::create($input);
        $user->assignRole($request->roles);
        activityLog('added new staff named ' . $request->name);

        return redirect()->route('v2.admin.users.index')->with('success', 'Staff Created');
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
    public function edit(User $user)
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort_unless(Gate::allows('view admin'), 403);
        }
        if ($user->id == 1) {
            abort_unless(Gate::allows('view admin'), 403);
        }
        $roles = Role::whereNotIn('name', ['SUPER-ADMIN'])->get();
        $assignedRoles = $user->roles->pluck('name')->toArray();

        return view('admin.v2.users.edit', compact('roles', 'user', 'assignedRoles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort_unless(Gate::allows('view admin'), 403);
        }
        if ($user->id == 1) {
            abort_unless(Gate::allows('view admin'), 403);
        }
        $input = $request->except('roles', 'password');
        if ($request->password) {
            $input['password'] = Hash::make($request->password);
        }
        $user->update($input);
        $user->roles()->detach();
        $user->assignRole($request->roles);
        activityLog('updated staff named ' . $request->name);

        return redirect()->route('v2.admin.users.index')->with('success', 'Staff Details Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort_unless(Gate::allows('view admin'), 403);
        }
        if ($user->id == 1) {
            abort_unless(Gate::allows('view admin'), 403);
        }
        $user->roles()->detach();
        $user->delete();
        activityLog('deleted staff named ' . $user->name);

        return redirect()->route('v2.admin.users.index')->with('success', 'Staff Deleted');
    }
}
