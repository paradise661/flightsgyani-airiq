<?php
namespace App\Http\Services;

use App\Models\Finance\NPSOnePG;
use Illuminate\Support\Facades\Http;

class NPSOnePGService  {
    public function getNPSOnePGGateways() {
        $NPSOnePg = NPSOnePG::first();
        $signature = $this->genereateNPSOnePGSignature($NPSOnePg->merchant_id . $NPSOnePg->merchant_name);

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode($NPSOnePg->username . ':' . $NPSOnePg->password),
            'Content-Type' => 'application/json',
        ])
            ->post(
                $NPSOnePg->instrument_url,
                [
                    'MerchantId' => $NPSOnePg->merchant_id,
                    'MerchantName' => $NPSOnePg->merchant_name,
                    'Signature' => $signature
                ]
            )
            ->throw()
            ->json();

        return (collect($response['data'])->groupBy('BankType'))->toJson();

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
}