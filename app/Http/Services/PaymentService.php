<?php


namespace App\Http\Services;

use App\Helpers\PaymentHelper;
use App\Models\Finance\Payment;
use App\Models\InternationalFlight\FlightBooking;
use App\Service\Sabre\Request\CurrencyConversionRQ;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Neputer\Facades\Khalti;

class PaymentService
{
    public function bookWithKhalti($booking_code, $paymentMethod = '')
    {

        if (!session()->has('usd_npr_exchange_rate')) {
            $currency_conversion_rq = new CurrencyConversionRQ();
            $usd_npr_exchange_rate = $currency_conversion_rq->doRequest();
            session()->put('usd_npr_exchange_rate', $usd_npr_exchange_rate);
        }

        $usd_npr_exchange_rate = session()->get('usd_npr_exchange_rate');


        // Create Payment copy before success as intent
        $booking = FlightBooking::where('booking_code', $booking_code)->first();
        $payment = new Payment();

        if (Auth::user()) {
            $payment->user_id = Auth::user()->id;
        }

        $is_office_staff = Auth::check() && Auth::user()->hasAnyRole('OFFICE STAFF');

        $return_url = route('khalti.payment');

        $purchase_order_id = $booking_code; // example 123567;
        $purchase_order_name = "International Flight Booking"; // example Transaction: 1234,
        $amount = $booking->currency === "USD" ? round($booking->final_fare * $usd_npr_exchange_rate) : $booking->final_fare; // Your total amount in paisa Rs 1 = 100 paisa
        $khaltiAmount = (config("khalti.debug") ? 15 :  $amount) * 100; // Your total amount in paisa Rs 1 = 100 paisa

        $khalti = Khalti::initiate($return_url, $purchase_order_id, $purchase_order_name,  $khaltiAmount);

        $payment = Payment::where('invoice_no', $booking->booking_code)->first();

        $payment_type = $paymentMethod;
        if ($is_office_staff) {
            $payment_type = 'OFFICE STAFF';
        }
        $payment_status = false;
        if ($paymentMethod == 'Wallet') {
            PaymentHelper::transaction(Auth::user()->id, 'DEBITED', $booking->currency ?? '', $amount, 'WALLET', 'Flight Booking', date('Y-m-d'));
            $payment_status = true;
            $booking->update(['payment_status' => true]);
        }

        if (!$payment) {
            $payment = new Payment();
            $payment->payment_type = $payment_type;
            $payment->amount = $amount;
            $payment->transaction_id = $khalti->pidx;
            $payment->status = 'Created';
            $payment->invoice_no = $booking->booking_code;
            $payment->date_time = now();
            // $payment->payment_gateway_id = $response['merchant']['idx'];
            $payment->currency = 'NPR';
            $payment->product_type = 'International Flight Ticket';
            $payment->payment_status = $payment_status;

            $booking->payments()->save($payment);
        }

        if ($is_office_staff) {
            Redirect::to(route('issue.ticket', [
                'code' => $purchase_order_id
            ]))->send();
        }

        if ($paymentMethod == 'Wallet') {
            Redirect::to(route('issue.ticket', [
                'code' => $purchase_order_id
            ]))->send();
        }

        return $khalti;
    }
}
