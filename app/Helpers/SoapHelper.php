<?php

namespace App\Helpers;

use App\Models\Domestic\Plasma;
use App\Models\Finance\Khalti;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use SoapClient;

class SoapHelper
{
    static function getSector()
    {
        $client = new SoapClient(SoapHelper::plasmaCredentials()['url'] ?? '', array('soap_version' => SOAP_1_1, "trace" => false, 'exceptions' => 0));

        $params = array(
            'parameters' => array(
                'strUserId' => SoapHelper::plasmaCredentials()['strUserId'] ?? '',
            )
        );
        $result = $client->__soapCall('SectorCode', $params);

        if (!isset($result->return)) {
            return [];
        }

        $final_data = simplexml_load_string($result->return);
        $final_data = json_decode(json_encode($final_data), true);
        return $final_data;
    }

    static function checkFlightStatus($data = [])
    {
        $client = new SoapClient(SoapHelper::plasmaCredentials()['url'] ?? '', array('soap_version' => SOAP_1_1, "trace" => false, 'exceptions' => 0));
        $params = array(
            'parameters' => array(
                'strUserId' => SoapHelper::plasmaCredentials()['strUserId'] ?? '',
                'strPassword' => SoapHelper::plasmaCredentials()['strPassword'] ?? '',
                'strAgencyId' => SoapHelper::plasmaCredentials()['strAgencyId'] ?? '',
                'strSectorFrom' => $data['from'],
                'strSectorTo' => $data['to'],
                'strFlightDate' => $data['flightDate'],
                'strTripType' => $data['type'],
                'strReturnDate' => $data['returnDate'],
                'strNationality' => $data['nationality'],
                'intAdult' => $data['adult'],
                'intChild' => $data['child'],
                'strClientIP' => "192.168.0.1"
            )
        );
        $result = $client->__soapCall('FlightAvailability', $params);

        if (!isset($result->return)) {
            return [];
        }

        $final_data = simplexml_load_string($result->return);
        return $final_data;
    }

    static function reservation($onewayFlightId, $twoWayFlightId)
    {
        $client = new SoapClient(SoapHelper::plasmaCredentials()['url'] ?? '', array('soap_version' => SOAP_1_1, "trace" => false, 'exceptions' => 0));

        $params = array(
            'parameters' => array(
                'strFlightId' => $onewayFlightId,
                'strReturnFlightId' => $twoWayFlightId,
            )

        );

        $result = $client->__soapCall('Reservation', $params);
        // dd([$result,$params]);

        if (!isset($result->return)) {
            return [];
        }

        $final_data = simplexml_load_string($result->return);
        // dd($final_data);
        return $final_data;
    }

    static function issueTicket($onewayFlightId, $twoWayFlightId)
    {
        $contactDetails = SoapHelper::passengerDetailsFormat();

        $newPassengerDetail = '<?xml version="1.0" ?>
            <PassengerDetail>';
        foreach ($contactDetails->passengerDetails as $passenger) {
            $newPassengerDetail .=
                "<Passenger>
                <PaxType>$passenger->type</PaxType>
                <Title>" . str_replace(".", "", $passenger->title) . "</Title>
                <Gender>" . $passenger->gender . "</Gender>
                <FirstName>" . strtoupper($passenger->first_name) . "</FirstName>
                <LastName>" . strtoupper($passenger->last_name) . "</LastName>
                <Nationality>" . $passenger->nationality . "</Nationality>
                <PaxRemarks>FlightsGyani</PaxRemarks>
                </Passenger>";
        }
        $newPassengerDetail .= '</PassengerDetail>';

        $client = new SoapClient(SoapHelper::plasmaCredentials()['url'] ?? '', array('soap_version' => SOAP_1_1, "trace" => false, 'exceptions' => 0));

        $bookingContactMobile = $contactDetails->emergency_phone;
        $bookingContactEmail = $contactDetails->emergency_email;
        $bookingContactPerson = $contactDetails->emergency_full_name;

        $params = array(
            'parameters' => array(
                'strFlightId' => $onewayFlightId,
                'strReturnFlightId' => $twoWayFlightId,
                'strContactName' =>  $bookingContactPerson,
                'strContactEmail' => $bookingContactEmail,
                'strContactMobile' => $bookingContactMobile,
                'strPassengerDetail' => $newPassengerDetail
            )
        );

        $result = $client->__soapCall('IssueTicket', $params);
        if (!isset($result->return)) {
            return false;
        }
        $final_data = simplexml_load_string($result->return);
        return $final_data;
    }

    static function passengerDetailsFormat()
    {
        $passenger_details = Session::get('passenger_details');
        $request_data = Session::get('request_data');

        $details1 = [];
        foreach ($passenger_details['adult_title'] ?? [] as $key => $title) {
            $details = [];
            $details['title'] = $title;
            $details['type'] = 'ADULT';
            $details['gender'] = $title == 'Mr.' ? 'M' : 'F';
            $details['first_name'] = $passenger_details['adult_first_name'][$key] ?? '';
            $details['last_name'] = $passenger_details['adult_last_name'][$key] ?? '';
            $details['nationality'] = $request_data['nationality'] ?? 'NP';
            $details1[] = (object) $details;
        }
        foreach ($passenger_details['child_title'] ?? [] as $key => $title) {
            $details = [];
            $details['title'] = $title;
            $details['type'] = 'ADULT';
            $details['gender'] = $title == 'Mr.' ? 'M' : 'F';
            $details['first_name'] = $passenger_details['child_first_name'][$key] ?? '';
            $details['last_name'] = $passenger_details['child_last_name'][$key] ?? '';
            $details['nationality'] = $request_data['nationality'] ?? 'NP';
            $details1[] = (object) $details;
        }
        $passenger = (object) [];
        $passenger->passengerDetails = $details1 ?? [];
        $passenger->emergency_full_name = $passenger_details['emergency_full_name'] ?? '';
        $passenger->emergency_phone = $passenger_details['emergency_phone_number'] ?? '';
        $passenger->emergency_email = $passenger_details['emergency_email'] ?? '';
        return $passenger;
    }

    static function plasmaCredentials()
    {
        // test credentials
        // static $url = "http://dev.usbooking.org/us/UnitedSolutions?wsdl";
        // static $strUserId = 'PARADI';
        // static $strPassword = 'PASSWORD';
        // static $strAgencyId = 'PLZ146';

        // live credentials
        // static $url = "http://usbooking.org/us/UnitedSolutions?wsdl";
        // static $strUserId = 'FGYANI';
        // static $strPassword = '@@FGY@AN185';
        // static $strAgencyId = 'PLZ185';

        $plasma = Plasma::first();
        $url = $plasma->environment ? $plasma->endpoint : $plasma->test_endpoint;
        $strUserId = $plasma->environment ? $plasma->username : $plasma->test_username;
        $strPassword = $plasma->environment ? $plasma->password : $plasma->test_password;
        $strAgencyId = $plasma->environment ? $plasma->agencyid : $plasma->test_agencyid;

        return [
            'url' => $url,
            'strUserId' => $strUserId,
            'strPassword' => $strPassword,
            'strAgencyId' => $strAgencyId,
        ];
    }
}
