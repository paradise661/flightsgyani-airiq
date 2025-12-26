<?php

namespace App\Http\Controllers\Admin\V2;

use App\Http\Controllers\Controller;
use App\Models\Inquery;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class InqueryController extends Controller
{
    public function contact()
    {
        abort_unless(Gate::allows('view inquiry'), 403);
        activityLog('viewed inquery details');

        return view('admin.v2.inquery.index');
    }

    public function viewInquery(Inquery $inquery)
    {
        abort_unless(Gate::allows('view inquiry'), 403);

        $inquery->update(['status' => 1]);
        activityLog('viewed inquery details of ' . $inquery->name);

        return view('admin.v2.inquery.show', compact('inquery'));
    }

    public function truncateInquery()
    {
        abort_unless(Gate::allows('deleteall inquiry'), 403);

        Inquery::truncate();
        activityLog('deleted all inquery details');

        return redirect()->back()->with('success', 'Inqueries deleted');
    }

    public function registeredUsers()
    {
        abort_unless(Gate::allows('view registeruser'), 403);
        activityLog('viewed all registered users');

        return view('admin.v2.registeredusers.index');
    }

    public function registeredUserStatus(User $user)
    {
        abort_unless(Gate::allows('status registeruser'), 403);

        $user->update([
            'active' => $user->active ? 0 : 1
        ]);
        activityLog('updated ' . $user->email . ' user status to ' . ($user->active ? 'Active' : 'Inactive'));

        return redirect()->back()->with('success', 'User Status Changed');
    }

    public function registeredUserDelete(User $user)
    {
        abort_unless(Gate::allows('delete registeruser'), 403);

        $user->delete();
        activityLog('deleted user named ' . $user->name . ' and email ' . $user->email);

        return redirect()->back()->with('success', 'User Deleted');
    }

    public function deleteInquery(Inquery $inquery)
    {
        abort_unless(Gate::allows('delete inquery'), 403);

        $inquery->delete();
        activityLog('deleted inquery details of ' . $inquery->name);

        return redirect()->back()->with('success', 'Inquery deleted');
    }
}
