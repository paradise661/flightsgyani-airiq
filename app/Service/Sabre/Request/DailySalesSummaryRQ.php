<?php

namespace App\Service\Sabre\Request;

use App\Service\Sabre\SabreBasic;
use App\Service\XMLSerializer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DailySalesSummaryRQ extends SabreBasic
{

    public function doRequest($date)
    {
        $bodyXML = $this->generateBody($date);
        $requestXML = $this->generateEnvelopeXmlWithSecurityHeaderFromBody('TKT_TravelAgencyReportsRQ', $bodyXML);
        if (is_dir(storage_path('/app/public/international/admin'))) {
            $file = storage_path('/app/public/international/admin/DailySalesSummaryRQ-' . Auth::user()->name . '-' . time() . '.txt');
            file_put_contents($file, $requestXML);
        } else {
            mkdir(storage_path('/app/public/international/admin'), 0755, true);
            $file = storage_path('/app/public/international/admin/DailySalesSummaryRQ-' . Auth::user()->name . '-' . time() . '.txt');
            file_put_contents($file, $requestXML);
        }
        $responseXML = $this->doSoapRequest($requestXML);
        $file = storage_path('/app/public/international/admin/DailySalesSummaryRS-' . Auth::user()->name . '-' . time() . '.txt');
        file_put_contents($file, $responseXML);
        return $this->formatResponse($responseXML);
    }

    public function generateBody($date)
    {
        $bodyArray = [
            'n1:DailySalesSummaryRQ' => [
                '_attributes' => [
                    'xmlns:n1' => 'http://www.sabre.com/ns/Ticketing/AsrServices/1.0',
                    'version' => '1.2.2'
                ],
                'n1:Header' => [],
                'n1:SelectionCriteria' => [
                    '_attributes' => [
                        'isCacheLateLargeReports' => 'true',
                        'clientTimeoutSecs' => '60'
                    ],
                    'n1:ReportDate' => Carbon::parse($date)->format('Y-m-d'),
                ]
            ]
        ];

        $bodyXML = XMLSerializer::generateValidXmlFromArray($bodyArray);
        return $bodyXML;
    }

    public function formatResponse($response)
    {
        $doc = new \DOMDocument();
        $doc->loadXML($response);
        $response_array = XMLSerializer::XMLtoArray($response);
        $fault = $this->checkSoapFault($response_array);
        if ($fault) {
            return false;
        }
        $status = $this->checkResponseStatus($doc);
        if (!$status) {
            return false;
        }
        $formattedResponse = [];
        $date = $doc->getElementsByTagName('ReportDate')->item(0)->nodeValue;
        $transactions = $doc->getElementsByTagName('Transaction');
        foreach ($transactions as $transaction) {
            $transactionReport = [];
            $transactionReport['date'] = $date;
            $transactionReport['pnr'] = $transaction->getElementsByTagName('PnrLocator')->item(0)->nodeValue;
            $transactionReport['pax'] = $transaction->getElementsByTagName('PassengerName')->item(0)->nodeValue;
            $transactionReport['ticket'] = $transaction->getElementsByTagName('DocumentNumber')->item(0)->nodeValue;
            $transactionReport['airline'] = $transaction->getElementsByTagName('AirlineCode')->item(0)->nodeValue;
            $commision = $transaction->getElementsByTagName('Commission')->item(0);
            if (isset($commission)) {
                $transactionReport['commissionAmount'] = $commision->getElementsByTagName('Amount')->item(0)->nodeValue;
                $transactionReport['commissionPercent'] = $commision->getElementsByTagName('Percent')->item(0)->nodeValue;
            } else {
                $transactionReport['commissionAmount'] = 0;
                $transactionReport['commissionPercent'] = 0;
            }

            $payment = $transaction->getElementsByTagName('Payments')->item(0);
            $transactionReport['currency'] = $payment->getElementsByTagName('CurrencyCode')->item(0)->nodeValue;
            $transactionReport['totalAmount'] = $payment->getElementsByTagName('PaymentTotal')->item(0)->nodeValue;
            $transactionReport['time'] = $transaction->getElementsByTagName('TransactionDateTime')->item(0)->nodeValue;
            array_push($formattedResponse, $transactionReport);
        }

        return $formattedResponse;
    }
}
