<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laratrust\Role;
use App\Models\User;
use Illuminate\Http\Request;

class LaratrustController extends Controller
{
    public function roles()
    {
        $roles = Role::all();
        return view('admin.users.roles.index', ['roles' => $roles]);
    }

    public function roleStore(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'display' => 'required|unique:roles,display_name'
        ]);
        try {
            $role = new Role();
            $role->name = $request->name;
            $role->display_name = $request->display;
            $role->description = $request->description;

            $role->save();
            return redirect()->back()->with('success', 'Role created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', $e->getMessage());
        }

    }

    public function roleEdit($id)
    {
        $role = Role::findorfail(decrypt($id));
        return view('admin.users.roles.edit', ['role' => $role]);
    }

    public function roleUpdate(Request $request)
    {
        $role = Role::findorfail(decrypt($request->role));
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'display_name' => 'required|unique:roles,display_name,' . $role->id
        ], [
            'name.required' => 'Role name is required.',
            'name.unique' => 'Role already exists.',
            'display_name.required' => 'Display name is required.',
            'display_name.unique' => 'Display name already exists.'
        ]);

        try {

            $role->update([
                'name' => $request->name,
                'display_name' => $request->display,
                'description' => $request->description,
            ]);

            return redirect()->back()->with('success', 'Role updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', $e->getMessage());
        }

    }

    public function roleDelete(Request $request)
    {

        try {
            $role = Role::findorfail(decrypt($request->id));
            $role->delete();
            return response()->json('Deleted', 200);
        } catch (\Exception $e) {
            return response()->json('Error', 500);
        }
    }

    public function assignUserRole()
    {
        $roles = Role::all();
        return view('admin.users.roles.assignrole', ['roles' => $roles]);
    }

    public function grantUserRole(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'roles' => 'required|array|min:1'
        ], [
            'name.required' => 'Select a valid user.',
            'name.regex' => 'Select a valid user.',
            'roles.required' => 'Select role to be assigned.',
            'roles.array' => 'Select role to be granted.',
            'roles.min' => 'Select role to be assigned.'
        ]);
        $user = User::where('email', explode('-', $request->name)[0])->first();
        if (!$user) {
            return redirect()->back()->with('warning', 'User not found.');
        }
        try {
            $user->syncRoles($request->roles);

            return redirect()->back()->with('success', 'Roles assigned successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', $e->getMessage());
        }


    }
}
