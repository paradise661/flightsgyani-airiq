<?php

namespace App\Http\Controllers\Admin\V2;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    public function activityLogs()
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort(403);
        }

        return view('admin.v2.activitylog.index');
    }

    public function activityLogDelete(ActivityLog $log)
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort(403);
        }

        $log->delete();
        return redirect()->route('v2.admin.activitylogs.index')->with('success', 'Activity log deleted Successfully');
    }

    public function truncateActivityLog()
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort(403);
        }

        ActivityLog::truncate();
        return redirect()->back()->with('success', 'Activity logs deleted');
    }
}
