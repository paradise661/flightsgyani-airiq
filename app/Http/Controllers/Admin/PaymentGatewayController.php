<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Finance\ConnectIps;
use App\Models\Finance\Khalti;
use App\Models\Finance\NPSOnePG;
use ConnectIpsTableSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class PaymentGatewayController extends Controller
{
    public function ipsConnect()
    {
        $ips = ConnectIps::first();
        if (!$ips) {
            Artisan::call('db:seed', ['--class' => ConnectIpsTableSeeder::class]);
            $ips = ConnectIps::first();
        }
        return view('admin.payments.connectips', ['ips' => $ips]);
    }

    public function updateConnectIps(Request $request)
    {
        $request->validate([
            'merchant' => 'required',
            'app' => 'required',
            'appname' => 'required',
            'gateway' => 'required',
            'validation' => 'required',
            'trans' => 'required',
        ], [
            'merchant.required' => "Merchant ID is required.",
            'app.required' => "App ID is required.",
            'appname.required' => 'App Name is required.',
            'gateway.required' => 'Provide gateway url.',
            'validation.required' => "Validation url is required.",
            'trans.required' => 'Transaction url is required.'
        ]);
        if ($request->has('status')) {
            $status = true;
        } else {
            $status = false;
        }
        try {
            $ips = ConnectIps::first();
            $ips->update([
                'merchant_id' => $request->merchant,
                'app_id' => $request->app,
                'app_name' => $request->appname,
                'process_url' => $request->gateway,
                'validation_url' => $request->validation,
                'transaction_url' => $request->trans,
                'status' => $status
            ]);
            if ($request->hasFile('cert')) {
                Storage::disk('private')->delete('ips/IPS.pfx');
                $request->file('cert')->storeAs('/ips', 'IPS.pfx', ['disk' => 'private']);
            }
            return redirect()->back()->with('success', 'ConnectIPS credentials updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', $e->getMessage());
        }

    }

    public function khalti()
    {
        $khalti = Khalti::first();
        if (!$khalti) {
            $khalti = new Khalti();
            $khalti->save();
        }
        return view('admin.payments.khalti', ['khalti' => $khalti]);
    }

    public function updateKhalti(Request $request)
    {
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
        return redirect()->back()->with('success', 'Khalti credentials updated successfully.');
    }

    public function NPSOnePG()
    {
        $NPSOnePG = NPSOnePG::firstorCreate();
        return view('admin.payments.npsOnePG', ['NPSOnePG' => $NPSOnePG]);
    }

    public function updateNPSOnePG(Request $request)
    {

        $request->validate([
            'processUrl' => 'required|url|max:200',
            'redirectionUrl' => 'required|url|max:200',
            'instrumentUrl' => 'required|url|max:200',
            'transactionUrl' => 'required|url|max:200',
            'merchant' => 'required|string|max:50',
            'merchantName' => 'required|string|max:50',
            'username' => 'required|string|max:50',
            'password' => 'required|string|max:50',
            'secretKey' => 'required|string|max:50',
            'charge' => 'required|integer|min:0',
        ]);
        if ($request->has('status')) {
            $status = true;
        } else {
            $status = false;
        }
        $NPSOnePG = NPSOnePG::first();
        if (!$NPSOnePG) {
            $NPSOnePG = new NPSOnePG();
            $NPSOnePG->save();
        }

        $NPSOnePG->update([
            'redirection_url' => $request->redirectionUrl,
            'instrument_url' => $request->instrumentUrl,
            'process_id_url' => $request->processUrl,
            'transaction_url' => $request->transactionUrl,
            'username' => $request->username,
            'password' => $request->password,
            'merchant_id' => $request->merchant,
            'merchant_name' => $request->merchantName,
            'secret_key' => $request->secretKey,
            'status' => $status,
            'additional_charge' => $request->charge

        ]);
        return redirect()->back()->with('success', 'NPSOnePG credentials updated successfully.');
    }
}
