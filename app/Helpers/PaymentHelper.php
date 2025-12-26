<?php

namespace App\Helpers;

use App\Models\B2B\Transaction;
use Illuminate\Support\Facades\Auth;

class PaymentHelper
{
    static function transaction($agent_id, $transaction_type, $currency, $amount, $payment_type, $remarks, $invoice_date)
    {
        $remaining_balance_npr = 0;
        $remaining_balance_usd = 0;
        $currentBalance = remainingBalance($agent_id);
        if ($currency == 'NPR') {
            if ($transaction_type == 'CREDITED') {
                $remaining_balance_npr = $currentBalance['NPR'] + $amount;
            } else {
                $remaining_balance_npr = $currentBalance['NPR'] - $amount;
            }
        }
        if ($currency == 'USD') {
            if ($transaction_type == 'CREDITED') {
                $remaining_balance_usd = $currentBalance['USD'] + $amount;
            } else {
                $remaining_balance_usd = $currentBalance['USD'] - $amount;
            }
        }

        $transaction = Transaction::create([
            'agent_id' => $agent_id,
            'invoice_id' => self::generateInvoiceID(),
            'transaction_type' => $transaction_type,
            'currency_type' => $currency,
            'amount' => $amount,
            'load_by' => Auth::user()->id ?? null,
            'load_type' => $payment_type,
            'invoice_date' => $invoice_date,
            'remaining_balance_npr' => $remaining_balance_npr,
            'remaining_balance_usd' => $remaining_balance_usd,
            'remarks' => $remarks,
            'status' => 'DUE'
        ]);
        return $transaction;
    }

    static function generateInvoiceID()
    {
        $id = "INV-" . date('y-m');
        $oldId = Transaction::where('invoice_id', 'LIKE', '%' . $id . '%')->orderBy('id', 'DESC')->first();
        if (!$oldId) {
            return "INV-" . date('y-m') . '-0002';
        }

        $string = $oldId->invoice_id;
        $parts = explode('-', $string);
        $last_number = (int)$parts[count($parts) - 1] + 1;
        $formatted_last_number = str_pad($last_number, strlen($parts[count($parts) - 1]), '0', STR_PAD_LEFT);
        $parts[count($parts) - 1] = $formatted_last_number;
        $new_string = implode('-', $parts);

        return $new_string;
    }
}
