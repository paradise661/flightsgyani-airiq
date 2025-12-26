<?php

namespace App\Service\Sabre\Request;

use App\Service\Sabre\SabreBasic;
use App\Service\XMLSerializer;

// use SoapClient;


class CreateSession extends SabreBasic
{

  public function doRequest($data = null)
  {


    $xmlStr = $this->generateBody();

    if (is_dir('../storage/app/public/international/' . session()->get('flight_search'))) {
      $checkfile = '../storage/app/public/international/' . session()->get('flight_search') . '/CreateSessionRQ.txt';
      if (file_exists($checkfile)) {
        $file = '../storage/app/public/international/' . session()->get('flight_search') . '/CreateSessionRQ' . time() . '.txt';
      } else {
        $file = $checkfile;
      }
      file_put_contents($file, $xmlStr);
    } else {
      mkdir('../storage/app/public/international/' . session()->get('flight_search'), 0755, true);
      $file = '../storage/app/public/international/' . session()->get('flight_search') . '/CreateSessionRQ.txt';
      file_put_contents($file, $xmlStr);
    }
    $response = $this->doSoapRequest($xmlStr);

    $checkfile = '../storage/app/public/international/' . session()->get('flight_search') . '/CreateSessionRS.txt';
    if (file_exists($checkfile)) {
      $file = '../storage/app/public/international/' . session()->get('flight_search') . '/CreateSessionRS' . time() . '.txt';
    } else {
      $file = $checkfile;
    }
    file_put_contents($file, $response);
    $simple = "$response";
    if (!$response) {
      return false;
    }

    $token = $this->formatResponse($response);
    if (!$token) {
      return false;
    }

    return $token;
  }

  public function generateBody()
  {
    $timestamp = date("Y-m-d") . "T" . date("H-i-s") . "Z";

    return <<<XML
<?xml version="1.0" encoding="utf-8"?>
<soap-env:Envelope xmlns:soap-env="http://schemas.xmlsoap.org/soap/envelope/">
  <soap-env:Header>
    <eb:MessageHeader xmlns:eb="http://www.ebxml.org/namespaces/messageHeader">
        <eb:From>
          <eb:PartyId eb:type="urn:x12.org.IO5:01">$this->message_id</eb:PartyId>
        </eb:From>
        <eb:To>
          <eb:PartyId eb:type="urn:x12.org.IO5:01">$this->url</eb:PartyId>
        </eb:To>
        <eb:ConversationId>$this->message_id</eb:ConversationId>
        <eb:Service eb:type="SabreXML">Session</eb:Service>
        <eb:Action>SessionCreateRQ</eb:Action>
        <eb:CPAID>$this->pcc</eb:CPAID>
       <eb:MessageData>
        <eb:MessageId>$this->message_id</eb:MessageId>
        <eb:Timestamp>$timestamp</eb:Timestamp>
        <eb:TimeToLive>$timestamp</eb:TimeToLive>
       </eb:MessageData>
    </eb:MessageHeader>
    <wsse:Security xmlns:wsse="http://schemas.xmlsoap.org/ws/2002/12/secext">
      <wsse:UsernameToken>
        <wsse:Username>$this->username</wsse:Username>
        <wsse:Password>$this->password</wsse:Password>
        <Organization>$this->pcc</Organization>
        <Domain>Default</Domain>
      </wsse:UsernameToken>
    </wsse:Security>
  </soap-env:Header>
    <soap-env:Body>
      <SessionCreateRQ>
        <POS>
           <Source PseudoCityCode='$this->pcc'/>
        </POS>
      </SessionCreateRQ>
    </soap-env:Body>
</soap-env:Envelope>
XML;
  }

  public function formatResponse($data)
  {
    // dd($data);
    //        return 'dadad';
    $doc = new \DOMDocument();
    $doc->loadXML($data);
    // dd($doc);
    $xml_array = XMLSerializer::XMLtoArray($data);
    // dd($xml_array);
    $fault = $this->checkSoapFault($xml_array);
    if ($fault) {
      return false;
    }

    $token = $doc->getElementsByTagName("BinarySecurityToken")->item(0)->nodeValue;
    if (!$token) {
      return false;
    }

    return $token;
  }

  public function tempResponse() {}
}
