<?php

namespace App\Http\Controllers\B2b;

use App\Helpers\PaymentHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFundRequest;
use App\Models\B2B\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function transactions()
    {
        return view('b2b.payment.transactions');
    }

    public function loadFund()
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort(403);
        }
        $agents = User::where('user_type', 'AGENT')->where('status', 'Active')->get();
        return view('b2b.payment.loadfund', compact('agents'));
    }

    public function loadFundStore(StoreFundRequest $request)
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort(403);
        }

        $transaction = PaymentHelper::transaction($request->agent_id, 'CREDITED', $request->currency_type, $request->amount, 'ADMIN', $request->remarks, date('Y-m-d'));
        activityLog('loaded fund of ' . $request->currency_type . ' ' . $request->amount . ' for invoice ID ' . $transaction->invoice_id);

        return redirect()->route('v2.admin.transactions.list')->with('success', 'Amount Loaded');
    }

    public function transactionsList()
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort(403);
        }

        return view('b2b.payment.topup');
    }

    public function transactionsShow(Transaction $transaction)
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort(403);
        }
        return view('b2b.payment.topupview', compact('transaction'));
    }

    public function transactionsupdate(Request $request, Transaction $transaction)
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort(403);
        }

        activityLog('updated payment status from agent topups');

        $transaction->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Status Updated');
    }

    public function transactionsAll()
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort(403);
        }
        return view('b2b.payment.admintransactions');
    }

    public function transactionDetails(Transaction $transaction)
    {
        if (!Auth::user()->hasAnyRole('SUPER-ADMIN')) {
            abort(403);
        }
        return view('b2b.payment.admintransactionview', compact('transaction'));
    }
}
