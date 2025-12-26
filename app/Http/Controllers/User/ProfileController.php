<?php

namespace App\Http\Controllers\User;


use App\Models\Company;
use App\Models\User;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Image;

class ProfileController extends Controller
{
    protected $user;


    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $user = User::where('id', Auth::user()->id)->first();

        return view('user.profile.index', compact('user'));
    }

    public function update(Request $request)
    {

        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phonenumber' => 'sometimes|nullable|string|max:255',
        ]);

        $user = User::find(Auth::user()->id);

        $user->update($validate);

        return redirect()->back()->with(['success' => 'Data has been updated successfully']);
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();
        $validate = $request->validate([
            'current_password' => 'required|string|min:8',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($request->password || $request->current_password) {
            if (Hash::check($request->get('current_password'), $user->password)) {
                $user->password = bcrypt($request->get('password'));
                $user->save();
                return redirect()
                    ->back()
                    ->with('success', 'Data has been update successfully');
            } else {
                return redirect()
                    ->back()
                    ->withErrors(['current_password' => 'Your current password does not match.']);
            }
        }
    }

    public function showChangePassword()
    {
        return view('user.profile.change-password');
    }

}
