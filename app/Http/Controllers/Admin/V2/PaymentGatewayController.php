<?php

namespace App\Http\Controllers\Admin\V2;

use App\Http\Controllers\Controller;
use App\Models\Finance\Khalti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PaymentGatewayController extends Controller
{
    public function khalti()
    {
        abort_unless(Gate::allows('view khalti'), 403);

        $khalti = Khalti::first();
        if (!$khalti) {
            $khalti = new Khalti();
            $khalti->save();
        }
        activityLog('viewed khalti details');

        return view('admin.v2.payments.khalti', ['khalti' => $khalti]);
    }

    public function khaltiStore(Request $request)
    {
        abort_unless(Gate::allows('view khalti'), 403);

        $request->validate([
            'publicKey' => 'required|max:191',
            'privateKey' => 'required|max:191'
        ]);
        if ($request->has('status')) {
            $status = true;
        } else {
            $status = false;
        }
        $khalti = Khalti::first();
        if (!$khalti) {
            $khalti = new Khalti();
            $khalti->save();
        }
        $khalti->update([
            'public_key' => $request->publicKey,
            'secret_key' => $request->privateKey,
            'status' => $status
        ]);
        activityLog('updated khalti details');

        return redirect()->back()->with('success', 'Khalti credentials updated successfully.');
    }
}
