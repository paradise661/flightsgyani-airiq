<?php

namespace App\Http\Controllers\Admin\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\PlasmaUpdateRequest;
use App\Models\Domestic\Plasma;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Gate;

class PlasmaController extends Controller
{
    public function edit()
    {
        abort_unless(Gate::allows('view plasma'), 403);

        $plasma = Plasma::first();
        activityLog('viewed plasma details');

        return view('admin.v2.plasma.edit', compact('plasma'));
    }

    public function update(PlasmaUpdateRequest $request)
    {
        abort_unless(Gate::allows('view plasma'), 403);

        try {
            $request['environment'] = $request->environment ? '1' : '0';
            Plasma::updateOrCreate(
                ['id' => 1],
                $request->except('_token')
            );
            activityLog('updated plasma details');

            return redirect()->back()->with('success', 'Plasma credentials updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('warning', $e->getMessage())->withInput();
        }
    }
}
