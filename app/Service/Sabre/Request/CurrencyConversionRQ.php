<?php

namespace App\Service\Sabre\Request;

use App\Models\InternationalFlight\SearchFlight;
use App\Service\Sabre\SabreBasic;
use App\Service\XMLSerializer;
use DOMDocument;


class CurrencyConversionRQ extends SabreBasic
{
    public function doRequest()
    {
        $body = <<<XML
            <DisplayCurrencyRQ xmlns="http://webservices.sabre.com/sabreXML/2011/10" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ReturnHostCommand="false" TimeStamp="2012-01-12T11:00:00-06:00" Version="2.1.0">
                <CountryCode>US</CountryCode>
                <CurrencyCode>NPR</CurrencyCode>
            </DisplayCurrencyRQ>
        XML;

        $xmlstr = $this->generateEnvelopeXmlWithSecurityHeaderFromBody('DisplayCurrencyLLSRQ', $body);

        $request = $this->doSoapRequest($xmlstr);

        $response = $this->checkResponse($request);

        if (!$response) {
            return false;
        }


        $value = $response->getElementsByTagName('Rate')->item(0)->nodeValue;

        return $value;
    }


    public function checkResponse($response)
    {
        //        $response = $this->tempResponse();
        $doc = new \DOMDocument();
        $doc->loadXML($response);
        $response_array = XMLSerializer::XMLtoArray($response);
        $soap_fault = $this->checkSoapFault($response_array);
        if ($soap_fault) {
            return false;
        }

        $status = $this->checkResponseStatus($doc);
        if (!$status) {
            return false;
        }
        return $doc;
    }
}
