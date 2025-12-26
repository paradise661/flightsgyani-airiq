<?php

namespace App\Http\Controllers;

use App\Http\Services\NPSOnePGService;
use App\Http\Services\PaymentService;
use App\Models\Finance\ConnectIps;
use App\Models\Finance\Khalti;
use App\Models\Finance\NPSOnePG;
use App\Models\Finance\Payment;
use App\Models\InternationalFlight\FlightBooking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Neputer\Facades\Khalti as KhaltiFacade;

//use App\Model\Tour\TourBooking;

class PaymentController extends Controller
{

    public function stripePayment(Request $request)
    {
        if ($request->type == 'IF') {
            $booking = FlightBooking::where('booking_code', $request->booking)->first();
            if (!$booking) {
                return redirect()->back()->with('warning', 'Error getting booking data.');
            }
            $payment = new Payment();
            if (Auth::user()) {
                $payment->user_id = Auth::user()->id;
            }

            $payment->payment_type = 'Stripe';
            $payment->amount = $booking->final_fare;
            $payment->product_type = 'International Flight Ticket';
            $payment->currency = $booking->currency;
            $payment->transaction_id = $request->stripeToken;
            $payment->invoice_no = $booking->booking_code;

            $booking->payments()->save($payment);

            $booking->update([
                'payment_status' => true
            ]);


            return redirect()->route('generate.pnr', $request->booking);
        } else {
            abort(404);
        }
    }

    /* IPS Function Starts */
    public function ipsPayment(Request $request)
    {
        $booking = FlightBooking::where('booking_code', $request->code)->first();
        if (!$booking) {
            return response()->json('Not Found', 404);
        }
        $response = [];
        $ips = ConnectIps::where('status', true)->first();
        if (!$ips) {
            Log::channel('stack')->critical('ConnectIPS credentials not found');
            return response()->json('Ips Credentials Not Found', 404);
        }
        $sectors = '';
        foreach (json_decode($booking->flights, true)['flight'] as $flights) {
            foreach ($flights as $flight) {
                $sectors .= $flight['departure'] . '-' . $flight['arrival'] . '/';
            }
        }

        $response['merchant'] = $ips->merchant_id;
        $response['url'] = $ips->process_url;
        $response['appId'] = $ips->app_id;
        $response['appName'] = $ips->app_name;
        $response['date'] = Carbon::now()->format('d-m-Y');
        $response['currency'] = $booking->currency;
        $response['txnId'] = $booking->booking_code;
        $response['amount'] = $booking->final_fare . '00';
        $response['reference'] = help_getRandomString(9);
        $response['remarks'] = 'International Flight Ticket';
        $response['particulars'] = $sectors;

        $string = 'MERCHANTID=' . $response['merchant'] .
            ',APPID=' . $response['appId'] .
            ',APPNAME=' . $response['appName'] .
            ',TXNID=' . $response['txnId'] .
            ',TXNDATE=' . $response['date'] .
            ',TXNCRNCY=' . $response['currency'] .
            ',TXNAMT=' . $response['amount'] .
            ',REFERENCEID=' . $response['reference'] .
            ',REMARKS=' . $response['remarks'] .
            ',PARTICULARS=' . $response['particulars'] .
            ',TOKEN=TOKEN';

        $token = $this->generateHashForIps($string);
        if (!$token) {
            return response()->json('Hash could not be generated.', 404);
        }

        $response['token'] = $token;
        return $response;
    }

    public function generateHashForIps($string)
    {
        if (file_exists($certificateFile = '../storage/app/private/ips/IPS.pfx')) {
            if (!$certificate = file_get_contents($certificateFile)) {
                Log::channel('stack')->critical('IPS Certificate file not found');
                return false;
            }
            if (openssl_pkcs12_read($certificate, $cert_info, "123")) {
                if ($private_key = openssl_pkey_get_private($cert_info['pkey'])) {
                    $parray = openssl_pkey_get_details($private_key);
                }
            } else {
                Log::channel('stack')->critical('ConnectIPS Certificate Private key not found.');
                return false;
            }
            $hashToken = '';
            if (openssl_sign($string, $signature, $private_key, "sha256WithRSAEncryption")) {
                $hash = base64_encode($signature);
                openssl_free_key($private_key);
            } else {
                Log::channel('stack')->critical('IPS Certificate could not be signed');
                return false;
            }
            return $hash;
        } else {
            Log::channel('stack')->critical('IPS Certificate file not found');
            return false;
        }
    }

    public function getIpsSuccessResponse(Request $request)
    {
        $booking = FlightBooking::where('booking_code', $request->TXNID)->first();
        if (!$booking) {
            abort(404);
        }
        $response = $this->validateIpsPayment($request, $booking, 'details');
        $paymentResponse = json_decode($response, true);
        if ($paymentResponse['status'] == 'SUCCESS') {
            $payment = new Payment();
            $payment->payment_type = 'ConnectIPS';
            $payment->amount = $paymentResponse['txnAmt'];
            $payment->transaction_id = $paymentResponse['refId'];
            $payment->status = $paymentResponse['statusDesc'];
            $payment->invoice_no = $booking->booking_code;
            $payment->date_time = $paymentResponse['txnDate'];
            $payment->payment_gateway_id = $paymentResponse['appId'];
            $payment->currency = 'NPR';
            $payment->product_type = 'International Flight Ticket';
            $payment->payment_status = true;

            $booking->payments()->save($payment);
            if ($booking->paid_amount >= $booking->final_fare) {
                $booking->update([
                    'payment_status' => true
                ]);
            }
            return redirect()->route('generate.pnr', $booking->booking_code);
        } else {
            return redirect()->route('flight.payment', $booking->booking_code);
        }
    }

    public function validateIpsPayment($request, $booking, $type)
    {
        $ips = ConnectIps::first();
        $string = 'MERCHANTID=' . $ips->merchant_id . ',APPID=' . $ips->app_id . ',REFERENCEID=' . $request['txnid'] . ',TXNAMT=' .
            $booking->final_fare;
        $hash = $this->generateHashForIps($string);

        $data = [];
        $data['merchantId'] = $ips->merchant_id;
        $data['appId'] = $ips->app_id;
        $data['referenceId'] = $request['txnid'];
        $data['txnAmt'] = $request['amount'];
        $data['token'] = $hash;
        $headers = array(
            'Content-Type:application/json',
        );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        if ($type == 'validate') {
            curl_setopt($curl, CURLOPT_URL, $ips->validation_url);
        } else {
            curl_setopt($curl, CURLOPT_URL, $ips->transaction_url);
        }
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_USERPWD, $ips->app_id . ':' . $ips->password);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        //        dd($curl);
        $result = curl_exec($curl);
        curl_close($curl);
        //        dd($result);
        return $result;
    }

    public function getIpsFailureResponse(Request $request)
    {
        $booking = FlightBooking::where('booking_code', $request->TXNID)->first();
        if (!$booking) {
            abort(404);
        }
        $response = $this->validateIpsPayment($request, $booking, 'validate');
        //        dd($response);
        return redirect()->route('flight.payment', $booking->booking_code)
            ->with('warning', 'Error in processing payment');
    }
    /*IPS ends*/

    /*Khalti Function starts*/

    public function initKhaltiPayment(Request $request)
    {
        $validate = $request->validate([
            'booking_code' => 'required|string',
        ]);

        $khalti = (new PaymentService())->bookWithKhalti($validate['booking_code']);

        return Redirect::to($khalti->payment_url);
    }

    public function khaltiPayment(Request $request)
    {

        $payload = $request->validate([
            "pidx" => "required|string",
            "transaction_id" => "required|string",
            "tidx" => "required|string",
            "amount" => "required|numeric",
            "total_amount" => "required|numeric",
            "mobile" => "required|string",
            "status" => "required|string",
            "purchase_order_id" => "required|string",
            "purchase_order_name" => "required|string",
        ]);


        $validationResponse = $this->verifyKhaltiPayment($payload['pidx']);

        $flightBooking = FlightBooking::where('booking_code', $payload['purchase_order_id'])->first();
        $flightBooking->update(['for_payment' => 1]);
        if (isset($validationResponse['status']) && $validationResponse['status'] === "Completed") {
            $payment = $flightBooking->payments()->where('invoice_no', $payload['purchase_order_id'])->first();
            $payment->update([
                'status' => 'Success',
                'payment_status' => true,
            ]);
            $flightBooking->update([
                'payment_status' => true
            ]);
        }

        return redirect()->route('generate.pnr', [
            'code' => $payload['purchase_order_id']
        ]);
    }

    public function verifyKhaltiPayment($pidx)
    {
        return KhaltiFacade::lookup($pidx);
    }
    /*Khalti Ends*/

    /*NPSOnePg function starts*/

    public function getNPSOnePGGateways(Request $request)
    {
        $NPSOnePg = new NPSOnePGService();
        return $NPSOnePg->getNPSOnePGGateways();
    }

    public function genereateNPSOnePGSignature(string|array $string)
    {
        $NPSOnePg = NPSOnePG::first();
        if (is_array($string)) :
            $string = implode($string);
        endif;

        $hash = hash_hmac('SHA512', $string, $NPSOnePg->secret_key, false);

        $signData = strtoupper($hash);
        return urlencode($signData);
    }

    public function genereaterNPSForm($booking, $code)
    {
        //        session()->flash('NPSOnePG_session.');
        $data = [];
        $NPSOnePg = NPSOnePG::first();
        $booking = FlightBooking::where('booking_code', $booking)->first();
        $MerchantTxnId = $booking->booking_code . '-T-' . uniqid();
        if (!$booking) {
            return redirect()->back()->with('warning', 'Error getting booking data.');
        }
        $data['currency'] = $booking->currency;
        $amount = $booking->final_fare . '.00';
        $ProcessId = $this->generateNPSOnePGProcessID($booking->booking_code, $MerchantTxnId);

        if (!empty($ProcessId['errors'])) {
            $message = $ProcessId['errors']['message'];
            abort('404', "error Creating process id")->with($message);
        } else {
            $NPSPid = $ProcessId['data']['ProcessId'];
        }

        session()->put('NPSOnePG_session.' . 'ProcessId', $NPSPid);

        return view(
            'flights.payment_form',
            [
                'bankcode' => $code,
                'amount' => $amount,
                'NPSOnePg' => $NPSOnePg,
                'ProcessID' => $NPSPid,
                'booking' => $booking,
                'MerchantTxnId' => $MerchantTxnId
            ]
        );
    }

    public function generateNPSOnePGProcessID($transationID, $MerchantTxnId)
    {
        $NPSOnePg = NPSOnePG::first();
        $booking = FlightBooking::where('booking_code', $transationID)->first();
        $marchantTransaction = $MerchantTxnId;
        $amount = $booking->final_fare . '.00';
        $signature = $this->genereateNPSOnePGSignature($amount
            . $NPSOnePg->merchant_id
            . $NPSOnePg->merchant_name
            . $marchantTransaction);

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode($NPSOnePg->username . ':' . $NPSOnePg->password),
            'Content-Type' => 'application/json',
        ])
            ->post(
                $NPSOnePg->process_id_url,
                [
                    'Amount' => $booking->final_fare . '.00',
                    'MerchantId' => $NPSOnePg->merchant_id,
                    'MerchantName' => $NPSOnePg->merchant_name,
                    'MerchantTxnId' => $marchantTransaction,
                    'Signature' => $signature
                ]
            )
            ->throw()
            ->json();
        return $response;
    }

    public function getNPSResponse(Request $request)
    {
        $booking_id = explode('-T-', $request->MerchantTxnId);

        $booking = FlightBooking::where('booking_code', $booking_id[0])->first();
        if (!$booking) {
            abort(404);
        }

        $transaction_status = $this->checkNPStransaction($request->MerchantTxnId);

        /*$paymentResponse = json_decode($transaction_status, true);*/

        if ($transaction_status['code'] === '0' && $transaction_status['message'] === 'Success') {

            if ($transaction_status['data']['Status'] === 'Success') {
                $payment = new Payment();
                $payment->payment_type = 'Nepal Payment Solution API';
                $payment->amount = $transaction_status['data']['Amount'];
                $payment->transaction_id = $transaction_status['data']['GatewayReferenceNo'];
                $payment->status = $transaction_status['data']['Status'];
                $payment->invoice_no = $booking->booking_code;
                $payment->date_time = $transaction_status['data']['TransactionDate'];
                $payment->payment_gateway_id = $transaction_status['data']['MerchantTxnId'];
                $payment->currency = 'NPR';
                $payment->product_type = 'International Flight Ticket'
                    . ' of processid ' . $transaction_status['data']['ProcessId']
                    . 'with service charge of '
                    . $transaction_status['data']['ServiceCharge'];
                $payment->payment_status = true;
                $payment->user_id = auth()->id();
                $booking->payments()->save($payment);
                if ($booking->paid_amount >= $booking->final_fare) {
                    $booking->update([
                        'payment_status' => true
                    ]);
                }
                return redirect()->route('generate.pnr', $booking->booking_code);
            }
        } else {

            return redirect()->route('flight.payment', $booking->booking_code)->with('errors', $transaction_status['errors']);
        }
    }

    public function checkNPStransaction($transactionID)
    {

        $NPSOnePg = NPSOnePG::first();
        $signature = $this->genereateNPSOnePGSignature(
            $NPSOnePg->merchant_id
                . $NPSOnePg->merchant_name
                . $transactionID
        );

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode($NPSOnePg->username . ':' . $NPSOnePg->password),
            'Content-Type' => 'application/json',
        ])
            ->post(
                $NPSOnePg->transaction_url,
                [
                    'MerchantId' => $NPSOnePg->merchant_id,
                    'MerchantName' => $NPSOnePg->merchant_name,
                    'MerchantTxnId' => $transactionID,
                    'Signature' => $signature
                ]
            )
            ->throw()
            ->json();

        return $response;
    }

    public function getNPSNotification(Request $request)
    {
        dd($request);
    }

    public function getNPSCancel(Request $request)
    {
        return "Sorry transction could naot be made try again later";
    }
    /*NPSOnePg Ends*/
}
