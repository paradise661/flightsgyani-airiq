<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserController extends Controller
{


    public function __construct()
    {

    }

    public function index()
    {
        return view('admin.users.index');
    }

    public function getUsers(Request $request)
    {
//        dd($request);
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'email',
            3 => 'phonenumber',
            4=> 'email_verified_at',
            5 => 'active',
            6 => 'created_at',
            7 => 'actions'
        );
        $totalData = User::count();
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        if (empty($request->input('search.value'))) {
            $users = User::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $users = User::where('id', 'LIKE', '%' . $search . '%')
                ->orWhere('name', 'LIKE', '%' . $search . '%')
                ->orWhere('email', 'LIKE', '%' . $search . '%')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = User::where('id', 'LIKE', '%' . $search . '%')
                ->orWhere('name', 'LIKE', '%' . $search . '%')
                ->orWhere('email', 'LIKE', '%' . $search . '%')
                ->count();
        }
        $data = array();
        if (!empty($users)) {
            $c = 1;
            foreach ($users as $user) {
                $restore = route('user.restore', encrypt($user->id));
                $suspend = route('user.suspend', encrypt($user->id));
                $update = route('user.edit', encrypt($user->id));
                $delete = route('user.destroy', encrypt($user->id));

                $nestedData['id'] = $c;
                $nestedData['name'] = $user->name;
                $nestedData['email'] = $user->email;
                $nestedData['phonenumber'] = $user->phonenumber;
                $nestedData['email_verified_at'] = (isset($user->email_verified_at)) ? 'Verified' : 'Unverified';
                $nestedData['active'] = ($user->active) ? 'Active' : 'Inactive';
                $nestedData['created_at'] = $user->created_at->toFormattedDateString();
                $nestedData['actions'] = '<div class="dropdown">
                                <a class="btn btn-outline-primary dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                    <i class="fa fa-ellipsis-h"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-left">';

                $nestedData['actions'] .= ' <a class="dropdown-item" href="' . $update . '"><i class="fa fa-pen"></i>Edit</a>';

                if ($user->active) {
                    $nestedData['actions'] .= '<a class="dropdown-item" href="' . $suspend . '"><i class="fa fa-cross"></i> Suspend</a>';
                } else {
                    $nestedData['actions'] .= '<a class="dropdown-item" href="' . $restore . '"><i class="fa fa-eye"></i> Restore</a>';
                }
                $nestedData['actions'] .= '<a class="dropdown-item delete" data-content="' . $user->id . '" href="' . $delete . '"><i class="fa fa-trash"></i> Delete</a>
                                </div>
                            </div>';
                $c++;
                $data[] = $nestedData;
            }
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            "data" => $data
        );
//        dd($user);
//        return response()->json($user);
        echo json_encode($json_data);
    }


    public function store(UserRequest $request)
    {
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phonenumber = $request->phonenumber;
            $user->password = bcrypt($request->password);
            $user->active = true;
            $user->save();
            return redirect()->back()->with('success', 'User inserted Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', $e->getMessage());
        }

    }

    public function edit($id)
    {
        $user = User::findorfail(decrypt($id));
        return view('admin.users.edit', ['user' => $user]);
    }

    public function destroy(Request $request)
    {

        $user = User::findorfail(decrypt($request->id));
        try {
            $user->delete();
            return redirect()->back()->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', $e->getMessage());
        }
    }

//

    public function changePassword(Request $request, $id)
    {
        $user = User::find($id);
        $user->password = bcrypt($request->get('password'));
        $user->save();
        return redirect()
            ->back()
            ->with('success', 'Data has been update successfully');

    }

    public function getUser(Request $request)
    {
        $search = $request->get('term');
        $result = User::where('name', 'LIKE', '%' . $search . '%')
            ->orWhere('email', 'LIKE', '%' . $search . '%')
            ->get();

        $data = array();
        foreach ($result as $hsl) {
            $data[] = $hsl->email . '-' . $hsl->name;
        }
        return response()->json($data);
    }

    public function suspend($id)
    {
        $user = User::findorfail(decrypt($id));

        $user->update([
            'active' => false
        ]);
        return redirect()->back()->with('success', 'User suspended succesfully.');
    }

    public function update(Request $request)
    {


        $user = User::findorfail(decrypt($request->user));
        $request->validate([
            'name' => 'required|min:5',
            'email' => 'email|unique:users,email,' . $user->id,
            'phonenumber' => 'numeric|between:7,13|unique:users,phonenumber' . $user->phonenumber,
            'password' => 'nullable|min:6'
        ], [
            'name.required' => 'Name is required',
            'name.min' => 'Name is too short.',
            'email.email' => 'Provide a valid email.',
            'email.unique' => 'Email already exists for another user.',
            'phonenumber.unique' => 'Phone number already exists for another user.',
            'password.min' => 'Password is too short'
        ]);
        try {
            if ($request->has('status')) {
                $status = true;
            } else {
                $status = false;
            }

            if (isset($request->password)) {
                $password = bcrypt($request->password);
            } else {
                $password = $user->password;
            }

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phonenumber' => $request->phonenumber,
                'password' => $password,
                'active' => $status
            ]);

            return redirect()->back()->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', $e->getMessage());
        }


    }

    public function restore($id)
    {
        $user = User::findorfail(decrypt($id));
        $user->update([
            'active' => true
        ]);

        return redirect()->back()->with('success', 'User restored successfully');
    }


}
