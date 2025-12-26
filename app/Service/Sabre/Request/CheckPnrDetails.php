<?php

namespace App\Service\Sabre\Request;

use App\Service\Sabre\SabreBasic;
use App\Service\XMLSerializer;
use DOMDocument;

class CheckPnrDetails extends SabreBasic
{
    public function doRequest($pnr)
    {
//        dd($pnr);
        $body = $this->generateBody($pnr);
        $xmlstr = $this->generateEnvelopeXmlWithSecurityHeaderFromBody('GetReservationRQ', $body);
        if (is_dir('../storage/app/public/international/' . $pnr)) {
            $checkfile = '../storage/app/public/international/' . $pnr . '/CheckPnrDetailsRQ.txt';
            if (file_exists($checkfile)) {
                $file = '../storage/app/public/international/' . $pnr . '/CheckPnrDetailsRQ' . time() . '.txt';
            } else {
                $file = $checkfile;
            }
            file_put_contents($file, $xmlstr);
        } else {
            mkdir('../storage/app/public/international/' . $pnr, 0755, true);
            $file = '../storage/app/public/international/' . $pnr . '/CheckPnrDetailsRQ.txt';
            file_put_contents($file, $xmlstr);
        }
        $response = $this->doSoapRequest($xmlstr);
        $checkfile = '../storage/app/public/international/' . $pnr . '/CheckPnrDetailsRS.txt';
        if (file_exists($checkfile)) {
            $file = '../storage/app/public/international/' . $pnr . '/CheckPnrDetailsRS' . time() . '.txt';
        } else {
            $file = $checkfile;
        }
        file_put_contents($file, $response);
        if ($action == 'Tickets') {
            return $this->getTickets($response);
        }
        return $this->formatResponse($response);
    }

    public function generateBody($pnr)
    {

        $get_reservation = [
            "GetReservationRQ" => [
                '_attributes' => [
                    'xmlns' => "http://webservices.sabre.com/pnrbuilder/v1_19",
                    'Version' => "1.19.0"
                ],
                "Locator" => $pnr,
                "RequestType" => "Stateful",
                "ReturnOptions" => [
                    "SubjectAreas" => [
                        "SubjectArea" => "ACTIVE",
                        "SubjectArea " => "ANCILLARY",
                        "SubjectArea  " => "FARETYPE",
                        "SubjectArea   " => "FQTV",
                        "SubjectArea    " => "HEADER",
                        "SubjectArea     " => "PRICE_QUOTE",
                        "SubjectArea      " => "TICKETING"
                    ],
                    "ViewName" => "Default",
                    "ResponseFormat" => "STL"
                ]
            ]
        ];

        $xml_body = XMLSerializer::generateValidXmlFromArray($get_reservation);
        return $xml_body;
    }

    public function getTickets($response)
    {

        $doc = new \DOMDocument();
        $doc->loadXML($response);
        $xml_array = XMLSerializer::XMLtoArray($response);
        $fault = $this->checkSoapFault($xml_array);
        if ($fault) {
            return false;
        }
        $formatted_response = [];
        $flights = $doc->getElementsByTagName('Segments')->item(0);
        $segments = $flights->getElementsByTagName('Segment');
        $flights_details = [];
        $tickets = [];
        foreach ($segments as $segment) {
            $details = $segment->getElementsByTagName('Air')->item(0);
            $departure = $details->getElementsByTagName('DepartureAirport')->item(0)->nodeValue;
            $arrival = $details->getElementsByTagName('ArrivalAirport')->item(0)->nodeValue;
            if ($details->getElementsByTagName('DepartureTerminalName')->length > 0) {
                $departureterminal = $details->getElementsByTagName('DepartureTerminalName')->item(0)->nodeValue;
            } else {
                $departureterminal = 'Not Available';
            }
            if ($details->getElementsByTagName('ArrivalTerminalName')->length > 0) {
                $arrivalterminal = $details->getElementsByTagName('ArrivalTerminalName')->item(0)->nodeValue;
            } else {
                $arrivalterminal = 'Not Available';
            }
            $opairline = $details->getElementsByTagName('OperatingAirlineShortName')->item(0)->nodeValue;
            $marairline = $details->getElementsByTagName('MarketingAirlineCode')->item(0)->nodeValue;
            $marflightno = $details->getElementsByTagName('MarketingFlightNumber')->item(0)->nodeValue;
            $class = $details->getElementsByTagName('OperatingClassOfService')->item(0)->nodeValue;
            $meal = $details->getElementsByTagName('Meal')->item(0)->getAttribute('Code');
            $departuredatetime = $details->getElementsByTagName('DepartureDateTime')->item(0)->nodeValue;
            $arrivaldatetime = $details->getElementsByTagName('ArrivalDateTime')->item(0)->nodeValue;
            $opflightno = $details->getElementsByTagName('FlightNumber')->item(0)->nodeValue;

            array_push($flights_details, [
                'departure' => $departure,
                'arrival' => $arrival,
                'depter' => $departureterminal,
                'arrter' => $arrivalterminal,
                'depdate' => $this->getFlightDate($departuredatetime)[0],
                'deptime' => $this->getFlightDate($departuredatetime)[1],
                'arrdate' => $this->getFlightDate($arrivaldatetime)[0],
                'arrtime' => $this->getFlightDate($arrivaldatetime)[1],
                'opairline' => $opairline,
                'marairline' => $marairline,
                'marflightno' => $marflightno,
                'opflightno' => $opflightno,
                'class' => $this->getFlightClassFromCode($class),
                'meal' => $meal
            ]);
        }

        $passengers = $doc->getElementsByTagName('Passengers')->item(0);
        $pax = $passengers->getElementsByTagName('Passenger');
        foreach ($pax as $p) {
            $type = $p->getAttribute('passengerType');
            $lastname = $p->getElementsByTagName('LastName')->item(0)->nodeValue;
            $firstname = $p->getElementsByTagName('FirstName')->item(0)->nodeValue;
            $ticket_details = $p->getElementsByTagName('TicketDetails');
            $ticket = [];
            foreach ($ticket_details as $ticket_detail) {
                $rph = $ticket_detail->getAttribute('index');
                $orgdetail = $ticket_detail->getElementsByTagName('OriginalTicketDetails')->item(0)->nodeValue;
                $ticket_no = $ticket_detail->getElementsByTagName('TicketNumber')->item(0)->nodeValue;

                array_push($ticket, [
                    'rph' => $rph,
                    'original' => $orgdetail,
                    'ticket' => $ticket_no
                ]);
            }

            array_push($tickets, [
                'type' => $type,
                'lastname' => $lastname,
                'firstname' => $firstname,
                'ticket' => $ticket
            ]);

        }
        $formatted_response['flights'] = $flights_details;
        $formatted_response['tickets'] = $tickets;
//        dd($formatted_response);
        return $formatted_response;
    }

    public function formatResponse($response)
    {

//        $response = $this->tempResponse();
        $doc = new DOMDocument();
        $doc->loadXML($response);
        $response_array = XMLSerializer::XMLtoArray($response);
        $fault = $this->checkSoapFault($response_array);
        if ($fault) {
            return false;
        }

        return true;
    }


    public function tempResponse()
    {
        return <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<soap-env:Envelope xmlns:soap-env="http://schemas.xmlsoap.org/soap/envelope/">
	<soap-env:Header>
		<eb:MessageHeader xmlns:eb="http://www.ebxml.org/namespaces/messageHeader" eb:version="1.0" soap-env:mustUnderstand="1">
			<eb:From>
				<eb:PartyId eb:type="urn:x12.org.IO5:01">webservices.sabre.com</eb:PartyId>
			</eb:From>
			<eb:To>
				<eb:PartyId eb:type="urn:x12.org.IO5:01">4e0bc8399496d694</eb:PartyId>
			</eb:To>
			<eb:CPAId>SE1J</eb:CPAId>
			<eb:ConversationId>4e0bc8399496d694</eb:ConversationId>
			<eb:Service eb:type="SabreXML">GetReservationRQ</eb:Service>
			<eb:Action>GetReservationRQ</eb:Action>
			<eb:MessageData>
				<eb:MessageId>837587406677830151</eb:MessageId>
				<eb:Timestamp>2019-04-28T11:17:48</eb:Timestamp>
				<eb:RefToMessageId>4e0bc8399496d694</eb:RefToMessageId>
			</eb:MessageData>
		</eb:MessageHeader>
		<wsse:Security xmlns:wsse="http://schemas.xmlsoap.org/ws/2002/12/secext">
			<wsse:BinarySecurityToken valueType="String" EncodingType="wsse:Base64Binary">Shared/IDL:IceSess\/SessMgr:1\.0.IDL/Common/!ICESMS\/ACPCRTD!ICESMSLB\/CRT.LB!1556449643625!1607!13</wsse:BinarySecurityToken>
		</wsse:Security>
	</soap-env:Header>
	<soap-env:Body>
		<stl19:GetReservationRS xmlns:stl19="http://webservices.sabre.com/pnrbuilder/v1_19" xmlns:ns6="http://services.sabre.com/res/orr/v0" xmlns:or114="http://services.sabre.com/res/or/v1_14" xmlns:raw="http://tds.sabre.com/itinerary" xmlns:ns4="http://webservices.sabre.com/pnrconn/ReaccSearch" Version="1.19.0">
			<stl19:Reservation numberInParty="1" numberOfInfants="0" NumberInSegment="1">
				<stl19:BookingDetails>
					<stl19:RecordLocator>VNJMAA</stl19:RecordLocator>
					<stl19:CreationTimestamp>2019-04-28T06:09:00</stl19:CreationTimestamp>
					<stl19:SystemCreationTimestamp>2019-04-28T06:09:00</stl19:SystemCreationTimestamp>
					<stl19:CreationAgentID>AWS</stl19:CreationAgentID>
					<stl19:UpdateTimestamp>2019-04-28T06:11:30</stl19:UpdateTimestamp>
					<stl19:PNRSequence>3</stl19:PNRSequence>
					<stl19:FlightsRange Start="2019-05-04T17:15:00" End="2019-05-04T18:50:00"/>
					<stl19:DivideSplitDetails/>
					<stl19:EstimatedPurgeTimestamp>2019-05-04T00:00:00</stl19:EstimatedPurgeTimestamp>
					<stl19:UpdateToken>-474f86269896e3ba9d9366bb64e13b45f8771b710abf0e11</stl19:UpdateToken>
				</stl19:BookingDetails>
				<stl19:POS AirExtras="false" InhibitCode="U">
					<stl19:Source BookingSource="SE1J" AgentSine="AWS" PseudoCityCode="SE1J" ISOCountry="NP" AgentDutyCode="*" AirlineVendorID="AA" HomePseudoCityCode="SE1J" PrimeHostID="1B"/>
				</stl19:POS>
				<stl19:PassengerReservation>
					<stl19:Passengers>
						<stl19:Passenger id="4" nameType="S" passengerType="ADT" nameId="01.01" nameAssocId="1" elementId="pnr-4.1">
							<stl19:LastName>PARAJULI</stl19:LastName>
							<stl19:FirstName>SUGAM</stl19:FirstName>
							<stl19:EmailAddress id="7">
								<stl19:Address>TEST@TEST.COM</stl19:Address>
								<stl19:Comment>AIRLINETICKET</stl19:Comment>
							</stl19:EmailAddress>
							<stl19:SpecialRequests>
								<stl19:APISRequest>
									<stl19:DOCSEntry id="13" type="G">
										<stl19:DocumentType>P</stl19:DocumentType>
										<stl19:CountryOfIssue>NP</stl19:CountryOfIssue>
										<stl19:DocumentNumber>154239874</stl19:DocumentNumber>
										<stl19:DocumentNationalityCountry>NP</stl19:DocumentNationalityCountry>
										<stl19:DateOfBirth>1992-02-20</stl19:DateOfBirth>
										<stl19:Gender>M</stl19:Gender>
										<stl19:DocumentExpirationDate>2024-06-19</stl19:DocumentExpirationDate>
										<stl19:Surname>PARAJULI</stl19:Surname>
										<stl19:Forename>SUGAM </stl19:Forename>
										<stl19:MiddleName>H</stl19:MiddleName>
										<stl19:PrimaryHolder>false</stl19:PrimaryHolder>
										<stl19:FreeText/>
										<stl19:ActionCode>HK</stl19:ActionCode>
										<stl19:NumberInParty>1</stl19:NumberInParty>
										<stl19:VendorCode>9W</stl19:VendorCode>
									</stl19:DOCSEntry>
								</stl19:APISRequest>
							</stl19:SpecialRequests>
							<stl19:Seats/>
						</stl19:Passenger>
					</stl19:Passengers>
					<stl19:Segments>
						<stl19:Poc>
							<stl19:Airport>KTM</stl19:Airport>
							<stl19:Departure>2019-05-04T17:15:00</stl19:Departure>
						</stl19:Poc>
						<stl19:Segment sequence="1" id="3">
							<stl19:Air id="3" sequence="1" segmentAssociationId="2" isPast="false" DayOfWeekInd="6" CodeShare="false" SpecialMeal="false" StopQuantity="00" SmokingAllowed="false" ResBookDesigCode="K" Code="9W">
								<stl19:DepartureAirport>KTM</stl19:DepartureAirport>
								<stl19:DepartureAirportCodeContext>IATA</stl19:DepartureAirportCodeContext>
								<stl19:ArrivalAirport>DEL</stl19:ArrivalAirport>
								<stl19:ArrivalAirportCodeContext>IATA</stl19:ArrivalAirportCodeContext>
								<stl19:ArrivalTerminalName>TERMINAL 3</stl19:ArrivalTerminalName>
								<stl19:ArrivalTerminalCode>3</stl19:ArrivalTerminalCode>
								<stl19:OperatingAirlineCode>9W</stl19:OperatingAirlineCode>
								<stl19:OperatingAirlineShortName>JET AIRWAYS</stl19:OperatingAirlineShortName>
								<stl19:OperatingFlightNumber>0259</stl19:OperatingFlightNumber>
								<stl19:EquipmentType>73H</stl19:EquipmentType>
								<stl19:MarketingAirlineCode>9W</stl19:MarketingAirlineCode>
								<stl19:MarketingFlightNumber>0259</stl19:MarketingFlightNumber>
								<stl19:OperatingClassOfService>K</stl19:OperatingClassOfService>
								<stl19:MarketingClassOfService>K</stl19:MarketingClassOfService>
								<stl19:MarriageGrp>
									<stl19:Ind>0</stl19:Ind>
									<stl19:Group>0</stl19:Group>
									<stl19:Sequence>0</stl19:Sequence>
								</stl19:MarriageGrp>
								<stl19:Meal Code="S"/>
								<stl19:Seats/>
								<stl19:AirlineRefId>DC9W*VNJMJB</stl19:AirlineRefId>
								<stl19:Eticket>true</stl19:Eticket>
								<stl19:DepartureDateTime>2019-05-04T17:15:00</stl19:DepartureDateTime>
								<stl19:ArrivalDateTime>2019-05-04T18:50:00</stl19:ArrivalDateTime>
								<stl19:FlightNumber>0259</stl19:FlightNumber>
								<stl19:ClassOfService>K</stl19:ClassOfService>
								<stl19:ActionCode>HK</stl19:ActionCode>
								<stl19:NumberInParty>1</stl19:NumberInParty>
								<stl19:SegmentSpecialRequests/>
								<stl19:inboundConnection>false</stl19:inboundConnection>
								<stl19:outboundConnection>false</stl19:outboundConnection>
								<stl19:ScheduleChangeIndicator>false</stl19:ScheduleChangeIndicator>
								<stl19:SegmentBookedDate>2019-04-28T06:09:00</stl19:SegmentBookedDate>
								<stl19:ElapsedTime>01.50</stl19:ElapsedTime>
								<stl19:AirMilesFlown>0507</stl19:AirMilesFlown>
								<stl19:FunnelFlight>false</stl19:FunnelFlight>
								<stl19:ChangeOfGauge>false</stl19:ChangeOfGauge>
								<stl19:Cabin Code="Y" SabreCode="Y" Name="ECONOMY" ShortName="ECONOMY" Lang="EN"/>
								<stl19:Banner>MARKETED BY JET AIRWAYS</stl19:Banner>
								<stl19:Informational>false</stl19:Informational>
							</stl19:Air>
							<stl19:Product id="3">
								<or114:ProductDetails productCategory="AIR">
									<or114:ProductName type="AIR"/>
									<or114:Air sequence="1" segmentAssociationId="2">
										<or114:DepartureAirport>KTM</or114:DepartureAirport>
										<or114:ArrivalAirport>DEL</or114:ArrivalAirport>
										<or114:ArrivalTerminalName>TERMINAL 3</or114:ArrivalTerminalName>
										<or114:ArrivalTerminalCode>3</or114:ArrivalTerminalCode>
										<or114:EquipmentType>73H</or114:EquipmentType>
										<or114:MarketingAirlineCode>9W</or114:MarketingAirlineCode>
										<or114:MarketingFlightNumber>259</or114:MarketingFlightNumber>
										<or114:MarketingClassOfService>K</or114:MarketingClassOfService>
										<or114:Cabin code="Y" sabreCode="Y" name="ECONOMY" shortName="ECONOMY" lang="EN"/>
										<or114:MealCode>S</or114:MealCode>
										<or114:ElapsedTime>110</or114:ElapsedTime>
										<or114:AirMilesFlown>507</or114:AirMilesFlown>
										<or114:FunnelFlight>false</or114:FunnelFlight>
										<or114:ChangeOfGauge>false</or114:ChangeOfGauge>
										<or114:DisclosureCarrier Code="9W" DOT="false">
											<or114:Banner>JET AIRWAYS</or114:Banner>
										</or114:DisclosureCarrier>
										<or114:AirlineRefId>DC9W*VNJMJB</or114:AirlineRefId>
										<or114:Eticket>true</or114:Eticket>
										<or114:DepartureDateTime>2019-05-04T17:15:00</or114:DepartureDateTime>
										<or114:ArrivalDateTime>2019-05-04T18:50:00</or114:ArrivalDateTime>
										<or114:FlightNumber>259</or114:FlightNumber>
										<or114:ClassOfService>K</or114:ClassOfService>
										<or114:ActionCode>HK</or114:ActionCode>
										<or114:NumberInParty>1</or114:NumberInParty>
										<or114:SegmentBookedDate>2019-04-28T06:09:00</or114:SegmentBookedDate>
									</or114:Air>
								</or114:ProductDetails>
							</stl19:Product>
						</stl19:Segment>
					</stl19:Segments>
					<stl19:TicketingInfo>
						<stl19:FutureTicketing id="6" index="1" elementId="pnr-6">
							<stl19:Code>TAW</stl19:Code>
						</stl19:FutureTicketing>
					</stl19:TicketingInfo>
					<stl19:ItineraryPricing/>
				</stl19:PassengerReservation>
				<stl19:ReceivedFrom>
					<stl19:Name>SWS TESTING</stl19:Name>
				</stl19:ReceivedFrom>
				<stl19:Addresses>
					<stl19:Address>
						<stl19:AddressLines>
							<stl19:AddressLine id="9" type="O">
								<stl19:Text>FAST INTL TRAVEL</stl19:Text>
							</stl19:AddressLine>
							<stl19:AddressLine id="10" type="O">
								<stl19:Text>12</stl19:Text>
							</stl19:AddressLine>
							<stl19:AddressLine id="11" type="O">
								<stl19:Text>KATHMANDU NP</stl19:Text>
							</stl19:AddressLine>
							<stl19:AddressLine id="12" type="O">
								<stl19:Text>00977</stl19:Text>
							</stl19:AddressLine>
						</stl19:AddressLines>
					</stl19:Address>
				</stl19:Addresses>
				<stl19:PhoneNumbers>
					<stl19:PhoneNumber id="8" index="1" elementId="pnr-8">
						<stl19:CityCode>KTM</stl19:CityCode>
						<stl19:Number>3265128745-A-1.1</stl19:Number>
					</stl19:PhoneNumber>
				</stl19:PhoneNumbers>
				<stl19:Remarks>
					<stl19:Remark index="1" id="14" type="FOP" elementId="pnr-14">
						<stl19:RemarkLines>
							<stl19:RemarkLine>
								<stl19:Text>CASH</stl19:Text>
							</stl19:RemarkLine>
						</stl19:RemarkLines>
					</stl19:Remark>
				</stl19:Remarks>
				<stl19:EmailAddresses/>
				<stl19:GenericSpecialRequests id="18" type="G" msgType="S">
					<stl19:Code>ADTK</stl19:Code>
					<stl19:FreeText>TO 9W BY 29APR19 1654KTM 29APR19 1639IN ELSE WILL BE XXLD</stl19:FreeText>
					<stl19:AirlineCode>1B</stl19:AirlineCode>
					<stl19:FullText>ADTK 1B TO 9W BY 29APR19 1654KTM 29APR19 1639IN ELSE WILL BE XXLD</stl19:FullText>
				</stl19:GenericSpecialRequests>
				<stl19:GenericSpecialRequests id="20" type="G" msgType="S">
					<stl19:Code>OTHS</stl19:Code>
					<stl19:FreeText>GUEST GST DETAILS INCOMPLETE KINDLY ENTER ALL FIELDS</stl19:FreeText>
					<stl19:AirlineCode>1S</stl19:AirlineCode>
					<stl19:FullText>OTHS 1S GUEST GST DETAILS INCOMPLETE KINDLY ENTER ALL FIELDS</stl19:FullText>
				</stl19:GenericSpecialRequests>
				<stl19:OpenReservationElements>
					<or114:OpenReservationElement id="3" type="FP" displayIndex="1" elementId="pnr-or-3">
						<or114:FormOfPayment migrated="false">
							<or114:Cash>
								<or114:Text>CASH</or114:Text>
							</or114:Cash>
						</or114:FormOfPayment>
					</or114:OpenReservationElement>
					<or114:OpenReservationElement id="13" type="SRVC" elementId="pnr-13">
						<or114:ServiceRequest actionCode="HK" airlineCode="9W" code="DOCS" serviceCount="1" serviceType="SSR" ssrType="GFX">
							<or114:FreeText>/P/NP/154239874/NP/20FEB1992/M/19JUN2024/PARAJULI/SUGAM /H</or114:FreeText>
							<or114:FullText>DOCS 9W HK1/P/NP/154239874/NP/20FEB1992/M/19JUN2024/PARAJULI/SUGAM /H</or114:FullText>
							<or114:TravelDocument>
								<or114:Type>P</or114:Type>
								<or114:DocumentIssueCountry>NP</or114:DocumentIssueCountry>
								<or114:DocumentNumber>154239874</or114:DocumentNumber>
								<or114:DocumentNationalityCountry>NP</or114:DocumentNationalityCountry>
								<or114:DocumentExpirationDate>19JUN2024</or114:DocumentExpirationDate>
								<or114:DateOfBirth>20FEB1992</or114:DateOfBirth>
								<or114:Gender>M</or114:Gender>
								<or114:LastName>PARAJULI</or114:LastName>
								<or114:FirstName>SUGAM</or114:FirstName>
								<or114:MiddleName>H</or114:MiddleName>
								<or114:Infant>false</or114:Infant>
								<or114:PrimaryDocHolderInd>false</or114:PrimaryDocHolderInd>
								<or114:HasDocumentData>true</or114:HasDocumentData>
							</or114:TravelDocument>
						</or114:ServiceRequest>
						<or114:NameAssociation>
							<or114:LastName>PARAJULI</or114:LastName>
							<or114:FirstName>SUGAM</or114:FirstName>
							<or114:NameRefNumber>01.01</or114:NameRefNumber>
						</or114:NameAssociation>
					</or114:OpenReservationElement>
					<or114:OpenReservationElement id="18" type="SRVC" elementId="pnr-18">
						<or114:ServiceRequest airlineCode="1B" code="ADTK" serviceType="SSR" ssrType="GFX">
							<or114:FreeText>TO 9W BY 29APR19 1654KTM 29APR19 1639IN ELSE WILL BE XXLD</or114:FreeText>
							<or114:FullText>ADTK 1B TO 9W BY 29APR19 1654KTM 29APR19 1639IN ELSE WILL BE XXLD</or114:FullText>
						</or114:ServiceRequest>
					</or114:OpenReservationElement>
					<or114:OpenReservationElement id="20" type="SRVC" elementId="pnr-20">
						<or114:ServiceRequest airlineCode="1S" code="OTHS" serviceType="SSR" ssrType="GFX">
							<or114:FreeText>GUEST GST DETAILS INCOMPLETE KINDLY ENTER ALL FIELDS</or114:FreeText>
							<or114:FullText>OTHS 1S GUEST GST DETAILS INCOMPLETE KINDLY ENTER ALL FIELDS</or114:FullText>
						</or114:ServiceRequest>
					</or114:OpenReservationElement>
					<or114:OpenReservationElement id="7" type="PSG_DETAILS_MAIL" elementId="pnr-7">
						<or114:Email comment="AIRLINETICKET">
							<or114:Address>TEST@TEST.COM</or114:Address>
						</or114:Email>
						<or114:NameAssociation>
							<or114:LastName>PARAJULI</or114:LastName>
							<or114:FirstName>SUGAM</or114:FirstName>
							<or114:NameRefNumber>01.01</or114:NameRefNumber>
						</or114:NameAssociation>
					</or114:OpenReservationElement>
				</stl19:OpenReservationElements>
			</stl19:Reservation>
			<or114:PriceQuote>
				<PriceQuoteInfo xmlns="http://www.sabre.com/ns/Ticketing/pqs/1.0">
					<Reservation updateToken="eNc:::BxS3N/gxjLcaGjQL20COuQ=="/>
					<Summary>
						<NameAssociation firstName="SUGAM" lastName="PARAJULI" nameId="1" nameNumber="1.1">
							<PriceQuote latestPQFlag="true" number="1" pricingStatus="MANUAL" pricingType="S" status="A" type="PQ">
								<Passenger passengerTypeCount="1" requestedType="ADT" type="ADT"/>
								<ItineraryType>I</ItineraryType>
								<ValidatingCarrier>9W</ValidatingCarrier>
								<Amounts>
									<Total currencyCode="NPR">16324</Total>
								</Amounts>
								<LocalCreateDateTime>2019-04-28T16:38:00</LocalCreateDateTime>
							</PriceQuote>
						</NameAssociation>
					</Summary>
					<Details number="1" passengerType="ADT" pricingStatus="MANUAL" pricingType="S" status="A" type="PQ">
						<AgentInfo duty="*" sine="AWS">
							<HomeLocation>SE1J</HomeLocation>
							<WorkLocation>SE1J</WorkLocation>
						</AgentInfo>
						<TransactionInfo>
							<CreateDateTime>2019-04-28T06:08:00</CreateDateTime>
							<UpdateDateTime>2019-04-28T06:09:00</UpdateDateTime>
							<LocalCreateDateTime>2019-04-28T16:38:00</LocalCreateDateTime>
							<LocalUpdateDateTime>2019-04-28T16:39:00</LocalUpdateDateTime>
							<InputEntry>WPA9WP1ADTXOTE-NQRQ</InputEntry>
						</TransactionInfo>
						<NameAssociationInfo firstName="SUGAM" lastName="PARAJULI" nameId="1" nameNumber="1.1"/>
						<SegmentInfo number="1" segmentStatus="OK">
							<Flight connectionIndicator="O">
								<MarketingFlight number="259">9W</MarketingFlight>
								<ClassOfService>K</ClassOfService>
								<Departure>
									<DateTime>2019-05-04T17:15:00</DateTime>
									<CityCode name="KATHMANDU">KTM</CityCode>
								</Departure>
								<Arrival>
									<DateTime>2019-05-04T18:50:00</DateTime>
									<CityCode name="DELHI">DEL</CityCode>
								</Arrival>
							</Flight>
							<FareBasis>K2OWNP</FareBasis>
							<NotValidBefore>2019-05-04</NotValidBefore>
							<NotValidAfter>2019-05-04</NotValidAfter>
							<Baggage allowance="20" type="K"/>
						</SegmentInfo>
						<FareInfo source="ATPC">
							<FareIndicators/>
							<BaseFare currencyCode="NPR">8200</BaseFare>
							<TotalTax currencyCode="NPR">8124</TotalTax>
							<TotalFare currencyCode="NPR">16324</TotalFare>
							<TaxInfo>
								<CombinedTax code="NQ">
									<Amount currencyCode="NPR">0</Amount>
								</CombinedTax>
								<CombinedTax code="NP">
									<Amount currencyCode="NPR">791</Amount>
								</CombinedTax>
								<CombinedTax code="XT">
									<Amount currencyCode="NPR">7333</Amount>
								</CombinedTax>
								<Tax code="NQ">
									<Amount currencyCode="NPR">0</Amount>
								</Tax>
								<Tax code="NP">
									<Amount currencyCode="NPR">791</Amount>
								</Tax>
								<Tax code="B6">
									<Amount currencyCode="NPR">1000</Amount>
								</Tax>
								<Tax code="YR">
									<Amount currencyCode="NPR">1131</Amount>
								</Tax>
								<Tax code="YQ">
									<Amount currencyCode="NPR">5202</Amount>
								</Tax>
							</TaxInfo>
							<FareCalculation>KTM 9W DEL72.56NUC72.56END ROE112.997859</FareCalculation>
							<FareComponent fareBasisCode="K2OWNP" number="1">
								<FlightSegmentNumbers>
									<SegmentNumber>1</SegmentNumber>
								</FlightSegmentNumbers>
								<FareDirectionality oneWay="true"/>
								<Departure>
									<DateTime>2019-05-04T17:15:00</DateTime>
									<CityCode name="KATHMANDU">KTM</CityCode>
								</Departure>
								<Arrival>
									<DateTime>2019-05-04T18:50:00</DateTime>
									<CityCode name="DELHI">DEL</CityCode>
								</Arrival>
								<Amount currencyCode="NUC" decimalPlace="2">72.56</Amount>
								<GoverningCarrier>9W</GoverningCarrier>
							</FareComponent>
						</FareInfo>
						<FeeInfo>
							<OBFee code="FCA" noChargeIndicator="X" type="OB">
								<Amount currencyCode="NPR">0</Amount>
								<Total currencyCode="NPR">16324</Total>
								<Description>ANY CC</Description>
							</OBFee>
							<OBFee code="FCA" type="OB">
								<Amount currencyCode="NPR">399</Amount>
								<Total currencyCode="NPR">16723</Total>
								<Description>ANY CC</Description>
							</OBFee>
							<OBFee code="FDA" noChargeIndicator="X" type="OB">
								<Amount currencyCode="NPR">0</Amount>
								<Total currencyCode="NPR">16324</Total>
								<Description>ANY CC</Description>
							</OBFee>
						</FeeInfo>
						<MiscellaneousInfo>
							<ValidatingCarrier>9W</ValidatingCarrier>
							<ItineraryType>I</ItineraryType>
						</MiscellaneousInfo>
						<MessageInfo>
							<Message number="301" type="INFO">One or more form of payment fees may apply</Message>
							<Message number="302" type="INFO">Actual total will be based on form of payment used</Message>
							<Message type="WARNING">VALIDATING CARRIER SPECIFIED - 9W</Message>
							<Remarks type="ENS">NON ENDO</Remarks>
							<PricingParameters>WPA9WP1ADTXOTE-NQRQ</PricingParameters>
						</MessageInfo>
						<HistoryInfo>
							<AgentInfo sine="AWS">
								<HomeLocation>SE1J</HomeLocation>
							</AgentInfo>
							<TransactionInfo>
								<LocalDateTime>2019-04-28T16:38:00</LocalDateTime>
								<InputEntry>WPA9WP1ADTXOTE-NQRQ</InputEntry>
							</TransactionInfo>
						</HistoryInfo>
					</Details>
				</PriceQuoteInfo>
			</or114:PriceQuote>
		</stl19:GetReservationRS>
	</soap-env:Body>
</soap-env:Envelope>
XML;

    }

    public function ticketResponse()
    {
        return <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<soap-env:Envelope xmlns:soap-env="http://schemas.xmlsoap.org/soap/envelope/">
	<soap-env:Header>
		<eb:MessageHeader xmlns:eb="http://www.ebxml.org/namespaces/messageHeader" eb:version="1.0" soap-env:mustUnderstand="1">
			<eb:From>
				<eb:PartyId eb:type="urn:x12.org.IO5:01">webservices.sabre.com</eb:PartyId>
			</eb:From>
			<eb:To>
				<eb:PartyId eb:type="urn:x12.org.IO5:01">8976f24d8da8650e</eb:PartyId>
			</eb:To>
			<eb:CPAId>SE1J</eb:CPAId>
			<eb:ConversationId>8976f24d8da8650e</eb:ConversationId>
			<eb:Service eb:type="SabreXML">GetReservationRQ</eb:Service>
			<eb:Action>GetReservationRQ</eb:Action>
			<eb:MessageData>
				<eb:MessageId>1040827341914940150</eb:MessageId>
				<eb:Timestamp>2019-05-02T09:29:53</eb:Timestamp>
				<eb:RefToMessageId>8976f24d8da8650e</eb:RefToMessageId>
			</eb:MessageData>
		</eb:MessageHeader>
		<wsse:Security xmlns:wsse="http://schemas.xmlsoap.org/ws/2002/12/secext">
			<wsse:BinarySecurityToken valueType="String" EncodingType="wsse:Base64Binary">Shared/IDL:IceSess\/SessMgr:1\.0.IDL/Common/!ICESMS\/ACPCRTD!ICESMSLB\/CRT.LB!1556788748239!5135!9</wsse:BinarySecurityToken>
		</wsse:Security>
	</soap-env:Header>
	<soap-env:Body>
		<stl19:GetReservationRS xmlns:stl19="http://webservices.sabre.com/pnrbuilder/v1_19" xmlns:ns6="http://services.sabre.com/res/orr/v0" xmlns:or114="http://services.sabre.com/res/or/v1_14" xmlns:raw="http://tds.sabre.com/itinerary" xmlns:ns4="http://webservices.sabre.com/pnrconn/ReaccSearch" Version="1.19.0">
			<stl19:Reservation numberInParty="3" numberOfInfants="1" NumberInSegment="2">
				<stl19:BookingDetails>
					<stl19:RecordLocator>UFOHSY</stl19:RecordLocator>
					<stl19:CreationTimestamp>2019-05-02T04:22:00</stl19:CreationTimestamp>
					<stl19:SystemCreationTimestamp>2019-05-02T04:22:00</stl19:SystemCreationTimestamp>
					<stl19:CreationAgentID>AWS</stl19:CreationAgentID>
					<stl19:UpdateTimestamp>2019-05-02T04:29:49</stl19:UpdateTimestamp>
					<stl19:PNRSequence>5</stl19:PNRSequence>
					<stl19:FlightsRange Start="2019-05-30T17:15:00" End="2019-06-07T14:50:00"/>
					<stl19:DivideSplitDetails/>
					<stl19:EstimatedPurgeTimestamp>2019-06-22T00:00:00</stl19:EstimatedPurgeTimestamp>
					<stl19:UpdateToken>352e387fe21c5bc91324d2c56d296bc7a8ecc31cf4edcf17</stl19:UpdateToken>
				</stl19:BookingDetails>
				<stl19:POS AirExtras="false" InhibitCode="U">
					<stl19:Source BookingSource="SE1J" AgentSine="AWS" PseudoCityCode="SE1J" ISOCountry="NP" AgentDutyCode="*" AirlineVendorID="AA" HomePseudoCityCode="SE1J" PrimeHostID="1B"/>
				</stl19:POS>
				<stl19:PassengerReservation>
					<stl19:Passengers>
						<stl19:Passenger id="5" nameType="S" passengerType="ADT" nameId="01.01" nameAssocId="1" withInfant="true" elementId="pnr-5.1">
							<stl19:LastName>GHIMIRE</stl19:LastName>
							<stl19:FirstName>CHANDRA</stl19:FirstName>
							<stl19:EmailAddress id="12">
								<stl19:Address>TEST@TEST.COM</stl19:Address>
								<stl19:Comment>AIRLINETICKET</stl19:Comment>
							</stl19:EmailAddress>
							<stl19:SpecialRequests>
								<stl19:GenericSpecialRequest id="19" type="G" msgType="S">
									<stl19:Code>INFT</stl19:Code>
									<stl19:FreeText>/GHIMIRE/SHYAM /03JAN19</stl19:FreeText>
									<stl19:ActionCode>KK</stl19:ActionCode>
									<stl19:NumberInParty>1</stl19:NumberInParty>
									<stl19:AirlineCode>9W</stl19:AirlineCode>
									<stl19:FullText>INFT 9W KK1 KTMDEL0259K30MAY/GHIMIRE/SHYAM /03JAN19</stl19:FullText>
								</stl19:GenericSpecialRequest>
								<stl19:GenericSpecialRequest id="20" type="G" msgType="S">
									<stl19:Code>INFT</stl19:Code>
									<stl19:FreeText>/GHIMIRE/SHYAM /03JAN19</stl19:FreeText>
									<stl19:ActionCode>KK</stl19:ActionCode>
									<stl19:NumberInParty>1</stl19:NumberInParty>
									<stl19:AirlineCode>9W</stl19:AirlineCode>
									<stl19:FullText>INFT 9W KK1 DELKTM0260K07JUN/GHIMIRE/SHYAM /03JAN19</stl19:FullText>
								</stl19:GenericSpecialRequest>
								<stl19:APISRequest>
									<stl19:DOCSEntry id="21" type="G">
										<stl19:DocumentType>P</stl19:DocumentType>
										<stl19:CountryOfIssue>NP</stl19:CountryOfIssue>
										<stl19:DocumentNumber>254698412</stl19:DocumentNumber>
										<stl19:DocumentNationalityCountry>NP</stl19:DocumentNationalityCountry>
										<stl19:DateOfBirth>1984-01-01</stl19:DateOfBirth>
										<stl19:Gender>M</stl19:Gender>
										<stl19:DocumentExpirationDate>2024-01-29</stl19:DocumentExpirationDate>
										<stl19:Surname>GHIMIRE</stl19:Surname>
										<stl19:Forename>CHANDRA </stl19:Forename>
										<stl19:MiddleName>H</stl19:MiddleName>
										<stl19:PrimaryHolder>false</stl19:PrimaryHolder>
										<stl19:FreeText/>
										<stl19:ActionCode>HK</stl19:ActionCode>
										<stl19:NumberInParty>1</stl19:NumberInParty>
										<stl19:VendorCode>9W</stl19:VendorCode>
									</stl19:DOCSEntry>
								</stl19:APISRequest>
								<stl19:APISRequest>
									<stl19:DOCSEntry id="23" type="G">
										<stl19:DocumentType>P</stl19:DocumentType>
										<stl19:CountryOfIssue>NP</stl19:CountryOfIssue>
										<stl19:DocumentNumber>621487569</stl19:DocumentNumber>
										<stl19:DocumentNationalityCountry>NP</stl19:DocumentNationalityCountry>
										<stl19:DateOfBirth>2019-01-03</stl19:DateOfBirth>
										<stl19:Gender>MI</stl19:Gender>
										<stl19:DocumentExpirationDate>2027-01-01</stl19:DocumentExpirationDate>
										<stl19:Surname>GHIMIRE</stl19:Surname>
										<stl19:Forename>SHYAM </stl19:Forename>
										<stl19:MiddleName>H</stl19:MiddleName>
										<stl19:PrimaryHolder>false</stl19:PrimaryHolder>
										<stl19:FreeText/>
										<stl19:ActionCode>HK</stl19:ActionCode>
										<stl19:NumberInParty>1</stl19:NumberInParty>
										<stl19:VendorCode>9W</stl19:VendorCode>
									</stl19:DOCSEntry>
								</stl19:APISRequest>
								<stl19:TicketingRequest>
									<stl19:TicketType>G</stl19:TicketType>
									<stl19:ValidatingCarrier>9W</stl19:ValidatingCarrier>
									<stl19:ActionCode>HK</stl19:ActionCode>
									<stl19:NumberInParty>1</stl19:NumberInParty>
									<stl19:BoardPoint>KTM</stl19:BoardPoint>
									<stl19:OffPoint>DEL</stl19:OffPoint>
									<stl19:ClassOfService>K</stl19:ClassOfService>
									<stl19:DateOfTravel>2019-05-30T00:00:00</stl19:DateOfTravel>
									<stl19:TicketNumber>5893458388858C1</stl19:TicketNumber>
								</stl19:TicketingRequest>
								<stl19:TicketingRequest>
									<stl19:TicketType>G</stl19:TicketType>
									<stl19:ValidatingCarrier>9W</stl19:ValidatingCarrier>
									<stl19:ActionCode>HK</stl19:ActionCode>
									<stl19:NumberInParty>1</stl19:NumberInParty>
									<stl19:BoardPoint>DEL</stl19:BoardPoint>
									<stl19:OffPoint>KTM</stl19:OffPoint>
									<stl19:ClassOfService>K</stl19:ClassOfService>
									<stl19:DateOfTravel>2019-06-07T00:00:00</stl19:DateOfTravel>
									<stl19:TicketNumber>5893458388858C2</stl19:TicketNumber>
								</stl19:TicketingRequest>
								<stl19:TicketingRequest>
									<stl19:TicketType>G</stl19:TicketType>
									<stl19:ValidatingCarrier>9W</stl19:ValidatingCarrier>
									<stl19:ActionCode>HK</stl19:ActionCode>
									<stl19:NumberInParty>1</stl19:NumberInParty>
									<stl19:BoardPoint>KTM</stl19:BoardPoint>
									<stl19:OffPoint>DEL</stl19:OffPoint>
									<stl19:ClassOfService>K</stl19:ClassOfService>
									<stl19:DateOfTravel>2019-05-30T00:00:00</stl19:DateOfTravel>
									<stl19:TicketNumber>INF5893458388860C1</stl19:TicketNumber>
								</stl19:TicketingRequest>
								<stl19:TicketingRequest>
									<stl19:TicketType>G</stl19:TicketType>
									<stl19:ValidatingCarrier>9W</stl19:ValidatingCarrier>
									<stl19:ActionCode>HK</stl19:ActionCode>
									<stl19:NumberInParty>1</stl19:NumberInParty>
									<stl19:BoardPoint>DEL</stl19:BoardPoint>
									<stl19:OffPoint>KTM</stl19:OffPoint>
									<stl19:ClassOfService>K</stl19:ClassOfService>
									<stl19:DateOfTravel>2019-06-07T00:00:00</stl19:DateOfTravel>
									<stl19:TicketNumber>INF5893458388860C2</stl19:TicketNumber>
								</stl19:TicketingRequest>
							</stl19:SpecialRequests>
							<stl19:Seats/>
							<stl19:Remarks/>
							<stl19:PhoneNumbers/>
							<stl19:TicketingInfo>
								<stl19:ETicketNumber id="32" index="2" elementId="pnr-32">TE 5893458388858-IN GHIMI/C SE1J*AWS 1459/02MAY*I</stl19:ETicketNumber>
								<stl19:TicketDetails id="32" index="2" elementId="pnr-32">
									<stl19:OriginalTicketDetails>TE 5893458388858-IN GHIMI/C SE1J*AWS 1459/02MAY*I</stl19:OriginalTicketDetails>
									<stl19:TransactionIndicator>TE</stl19:TransactionIndicator>
									<stl19:TicketNumber>5893458388858</stl19:TicketNumber>
									<stl19:PassengerName>GHIMI/C</stl19:PassengerName>
									<stl19:AgencyLocation>SE1J</stl19:AgencyLocation>
									<stl19:DutyCode>*</stl19:DutyCode>
									<stl19:AgentSine>AWS</stl19:AgentSine>
									<stl19:Timestamp>2019-05-02T14:59:00</stl19:Timestamp>
									<stl19:PaymentType>*</stl19:PaymentType>
								</stl19:TicketDetails>
							</stl19:TicketingInfo>
						</stl19:Passenger>
						<stl19:Passenger id="7" nameType="S" passengerType="C06" referenceNumber="C06" nameId="02.01" nameAssocId="2" elementId="pnr-7.2">
							<stl19:LastName>GHIMIRE</stl19:LastName>
							<stl19:FirstName>RAM </stl19:FirstName>
							<stl19:SpecialRequests>
								<stl19:ChildRequest id="18" type="G">
									<stl19:VendorCode>9W</stl19:VendorCode>
									<stl19:ActionCode>HK</stl19:ActionCode>
									<stl19:NumberInParty>1</stl19:NumberInParty>
								</stl19:ChildRequest>
								<stl19:APISRequest>
									<stl19:DOCSEntry id="22" type="G">
										<stl19:DocumentType>P</stl19:DocumentType>
										<stl19:CountryOfIssue>NP</stl19:CountryOfIssue>
										<stl19:DocumentNumber>254896321</stl19:DocumentNumber>
										<stl19:DocumentNationalityCountry>NP</stl19:DocumentNationalityCountry>
										<stl19:DateOfBirth>2013-03-02</stl19:DateOfBirth>
										<stl19:Gender>M</stl19:Gender>
										<stl19:DocumentExpirationDate>2025-01-03</stl19:DocumentExpirationDate>
										<stl19:Surname>GHIMIRE</stl19:Surname>
										<stl19:Forename>RAM </stl19:Forename>
										<stl19:MiddleName>H</stl19:MiddleName>
										<stl19:PrimaryHolder>false</stl19:PrimaryHolder>
										<stl19:FreeText/>
										<stl19:ActionCode>HK</stl19:ActionCode>
										<stl19:NumberInParty>1</stl19:NumberInParty>
										<stl19:VendorCode>9W</stl19:VendorCode>
									</stl19:DOCSEntry>
								</stl19:APISRequest>
								<stl19:TicketingRequest>
									<stl19:TicketType>G</stl19:TicketType>
									<stl19:ValidatingCarrier>9W</stl19:ValidatingCarrier>
									<stl19:ActionCode>HK</stl19:ActionCode>
									<stl19:NumberInParty>1</stl19:NumberInParty>
									<stl19:BoardPoint>KTM</stl19:BoardPoint>
									<stl19:OffPoint>DEL</stl19:OffPoint>
									<stl19:ClassOfService>K</stl19:ClassOfService>
									<stl19:DateOfTravel>2019-05-30T00:00:00</stl19:DateOfTravel>
									<stl19:TicketNumber>5893458388859C1</stl19:TicketNumber>
								</stl19:TicketingRequest>
								<stl19:TicketingRequest>
									<stl19:TicketType>G</stl19:TicketType>
									<stl19:ValidatingCarrier>9W</stl19:ValidatingCarrier>
									<stl19:ActionCode>HK</stl19:ActionCode>
									<stl19:NumberInParty>1</stl19:NumberInParty>
									<stl19:BoardPoint>DEL</stl19:BoardPoint>
									<stl19:OffPoint>KTM</stl19:OffPoint>
									<stl19:ClassOfService>K</stl19:ClassOfService>
									<stl19:DateOfTravel>2019-06-07T00:00:00</stl19:DateOfTravel>
									<stl19:TicketNumber>5893458388859C2</stl19:TicketNumber>
								</stl19:TicketingRequest>
							</stl19:SpecialRequests>
							<stl19:Seats/>
							<stl19:Remarks/>
							<stl19:PhoneNumbers/>
							<stl19:TicketingInfo>
								<stl19:ETicketNumber id="33" index="3" elementId="pnr-33">TE 5893458388859-IN GHIMI/R SE1J*AWS 1459/02MAY*I</stl19:ETicketNumber>
								<stl19:TicketDetails id="33" index="3" elementId="pnr-33">
									<stl19:OriginalTicketDetails>TE 5893458388859-IN GHIMI/R SE1J*AWS 1459/02MAY*I</stl19:OriginalTicketDetails>
									<stl19:TransactionIndicator>TE</stl19:TransactionIndicator>
									<stl19:TicketNumber>5893458388859</stl19:TicketNumber>
									<stl19:PassengerName>GHIMI/R</stl19:PassengerName>
									<stl19:AgencyLocation>SE1J</stl19:AgencyLocation>
									<stl19:DutyCode>*</stl19:DutyCode>
									<stl19:AgentSine>AWS</stl19:AgentSine>
									<stl19:Timestamp>2019-05-02T14:59:00</stl19:Timestamp>
									<stl19:PaymentType>*</stl19:PaymentType>
								</stl19:TicketDetails>
							</stl19:TicketingInfo>
						</stl19:Passenger>
						<stl19:Passenger id="9" nameType="I" passengerType="INF" referenceNumber="I03" nameId="03.01" nameAssocId="3" elementId="pnr-9.3">
							<stl19:LastName>GHIMIRE</stl19:LastName>
							<stl19:FirstName>SHYAM </stl19:FirstName>
							<stl19:Seats/>
							<stl19:Remarks/>
							<stl19:PhoneNumbers/>
							<stl19:TicketingInfo>
								<stl19:ETicketNumber id="34" index="4" elementId="pnr-34">TE 5893458388860-IN GHIMI/S SE1J*AWS 1459/02MAY*I</stl19:ETicketNumber>
								<stl19:TicketDetails id="34" index="4" elementId="pnr-34">
									<stl19:OriginalTicketDetails>TE 5893458388860-IN GHIMI/S SE1J*AWS 1459/02MAY*I</stl19:OriginalTicketDetails>
									<stl19:TransactionIndicator>TE</stl19:TransactionIndicator>
									<stl19:TicketNumber>5893458388860</stl19:TicketNumber>
									<stl19:PassengerName>GHIMI/S</stl19:PassengerName>
									<stl19:AgencyLocation>SE1J</stl19:AgencyLocation>
									<stl19:DutyCode>*</stl19:DutyCode>
									<stl19:AgentSine>AWS</stl19:AgentSine>
									<stl19:Timestamp>2019-05-02T14:59:00</stl19:Timestamp>
									<stl19:PaymentType>*</stl19:PaymentType>
								</stl19:TicketDetails>
							</stl19:TicketingInfo>
						</stl19:Passenger>
					</stl19:Passengers>
					<stl19:Segments>
						<stl19:Poc>
							<stl19:Airport>KTM</stl19:Airport>
							<stl19:Departure>2019-05-30T17:15:00</stl19:Departure>
						</stl19:Poc>
						<stl19:Segment sequence="1" id="3">
							<stl19:Air id="3" sequence="1" segmentAssociationId="2" isPast="false" DayOfWeekInd="4" CodeShare="false" SpecialMeal="false" StopQuantity="00" SmokingAllowed="false" ResBookDesigCode="K" Code="9W">
								<stl19:DepartureAirport>KTM</stl19:DepartureAirport>
								<stl19:DepartureAirportCodeContext>IATA</stl19:DepartureAirportCodeContext>
								<stl19:ArrivalAirport>DEL</stl19:ArrivalAirport>
								<stl19:ArrivalAirportCodeContext>IATA</stl19:ArrivalAirportCodeContext>
								<stl19:ArrivalTerminalName>TERMINAL 3</stl19:ArrivalTerminalName>
								<stl19:ArrivalTerminalCode>3</stl19:ArrivalTerminalCode>
								<stl19:OperatingAirlineCode>9W</stl19:OperatingAirlineCode>
								<stl19:OperatingAirlineShortName>JET AIRWAYS</stl19:OperatingAirlineShortName>
								<stl19:OperatingFlightNumber>0259</stl19:OperatingFlightNumber>
								<stl19:EquipmentType>73H</stl19:EquipmentType>
								<stl19:MarketingAirlineCode>9W</stl19:MarketingAirlineCode>
								<stl19:MarketingFlightNumber>0259</stl19:MarketingFlightNumber>
								<stl19:OperatingClassOfService>K</stl19:OperatingClassOfService>
								<stl19:MarketingClassOfService>K</stl19:MarketingClassOfService>
								<stl19:MarriageGrp>
									<stl19:Ind>0</stl19:Ind>
									<stl19:Group>0</stl19:Group>
									<stl19:Sequence>0</stl19:Sequence>
								</stl19:MarriageGrp>
								<stl19:Meal Code="S"/>
								<stl19:Seats/>
								<stl19:AirlineRefId>DC9W*EBQLNB</stl19:AirlineRefId>
								<stl19:Eticket>true</stl19:Eticket>
								<stl19:DepartureDateTime>2019-05-30T17:15:00</stl19:DepartureDateTime>
								<stl19:ArrivalDateTime>2019-05-30T18:50:00</stl19:ArrivalDateTime>
								<stl19:FlightNumber>0259</stl19:FlightNumber>
								<stl19:ClassOfService>K</stl19:ClassOfService>
								<stl19:ActionCode>HK</stl19:ActionCode>
								<stl19:NumberInParty>2</stl19:NumberInParty>
								<stl19:SegmentSpecialRequests>
									<stl19:GenericSpecialRequest id="19" type="G" msgType="S">
										<stl19:Code>INFT</stl19:Code>
										<stl19:FreeText>/GHIMIRE/SHYAM /03JAN19</stl19:FreeText>
										<stl19:ActionCode>KK</stl19:ActionCode>
										<stl19:NumberInParty>1</stl19:NumberInParty>
										<stl19:AirlineCode>9W</stl19:AirlineCode>
										<stl19:FullText>INFT 9W KK1 KTMDEL0259K30MAY/GHIMIRE/SHYAM /03JAN19</stl19:FullText>
									</stl19:GenericSpecialRequest>
									<stl19:GenericSpecialRequest id="37" type="G" msgType="S">
										<stl19:Code>TKNE</stl19:Code>
										<stl19:FreeText>9W HK1 KTMDEL0259K30MAY/5893458388858C1</stl19:FreeText>
										<stl19:ActionCode>HK</stl19:ActionCode>
										<stl19:NumberInParty>1</stl19:NumberInParty>
										<stl19:AirlineCode>9W</stl19:AirlineCode>
										<stl19:TicketNumber>5893458388858</stl19:TicketNumber>
										<stl19:FullText>TKNE 9W HK1 KTMDEL0259K30MAY/5893458388858C1</stl19:FullText>
									</stl19:GenericSpecialRequest>
									<stl19:GenericSpecialRequest id="39" type="G" msgType="S">
										<stl19:Code>TKNE</stl19:Code>
										<stl19:FreeText>9W HK1 KTMDEL0259K30MAY/5893458388859C1</stl19:FreeText>
										<stl19:ActionCode>HK</stl19:ActionCode>
										<stl19:NumberInParty>1</stl19:NumberInParty>
										<stl19:AirlineCode>9W</stl19:AirlineCode>
										<stl19:TicketNumber>5893458388859</stl19:TicketNumber>
										<stl19:FullText>TKNE 9W HK1 KTMDEL0259K30MAY/5893458388859C1</stl19:FullText>
									</stl19:GenericSpecialRequest>
									<stl19:GenericSpecialRequest id="41" type="G" msgType="S">
										<stl19:Code>TKNE</stl19:Code>
										<stl19:FreeText>9W HK1 KTMDEL0259K30MAY/INF5893458388860C1</stl19:FreeText>
										<stl19:ActionCode>HK</stl19:ActionCode>
										<stl19:NumberInParty>1</stl19:NumberInParty>
										<stl19:AirlineCode>9W</stl19:AirlineCode>
										<stl19:TicketNumber>INF5893458388</stl19:TicketNumber>
										<stl19:FullText>TKNE 9W HK1 KTMDEL0259K30MAY/INF5893458388860C1</stl19:FullText>
									</stl19:GenericSpecialRequest>
								</stl19:SegmentSpecialRequests>
								<stl19:inboundConnection>false</stl19:inboundConnection>
								<stl19:outboundConnection>false</stl19:outboundConnection>
								<stl19:ScheduleChangeIndicator>false</stl19:ScheduleChangeIndicator>
								<stl19:SegmentBookedDate>2019-05-02T04:22:00</stl19:SegmentBookedDate>
								<stl19:ElapsedTime>01.50</stl19:ElapsedTime>
								<stl19:AirMilesFlown>0507</stl19:AirMilesFlown>
								<stl19:FunnelFlight>false</stl19:FunnelFlight>
								<stl19:ChangeOfGauge>false</stl19:ChangeOfGauge>
								<stl19:Cabin Code="Y" SabreCode="Y" Name="ECONOMY" ShortName="ECONOMY" Lang="EN"/>
								<stl19:Banner>MARKETED BY JET AIRWAYS</stl19:Banner>
								<stl19:Informational>false</stl19:Informational>
							</stl19:Air>
							<stl19:Product id="3">
								<or114:ProductDetails productCategory="AIR">
									<or114:ProductName type="AIR"/>
									<or114:Air sequence="1" segmentAssociationId="2">
										<or114:DepartureAirport>KTM</or114:DepartureAirport>
										<or114:ArrivalAirport>DEL</or114:ArrivalAirport>
										<or114:ArrivalTerminalName>TERMINAL 3</or114:ArrivalTerminalName>
										<or114:ArrivalTerminalCode>3</or114:ArrivalTerminalCode>
										<or114:EquipmentType>73H</or114:EquipmentType>
										<or114:MarketingAirlineCode>9W</or114:MarketingAirlineCode>
										<or114:MarketingFlightNumber>259</or114:MarketingFlightNumber>
										<or114:MarketingClassOfService>K</or114:MarketingClassOfService>
										<or114:Cabin code="Y" sabreCode="Y" name="ECONOMY" shortName="ECONOMY" lang="EN"/>
										<or114:MealCode>S</or114:MealCode>
										<or114:ElapsedTime>110</or114:ElapsedTime>
										<or114:AirMilesFlown>507</or114:AirMilesFlown>
										<or114:FunnelFlight>false</or114:FunnelFlight>
										<or114:ChangeOfGauge>false</or114:ChangeOfGauge>
										<or114:DisclosureCarrier Code="9W" DOT="false">
											<or114:Banner>JET AIRWAYS</or114:Banner>
										</or114:DisclosureCarrier>
										<or114:AirlineRefId>DC9W*EBQLNB</or114:AirlineRefId>
										<or114:Eticket>true</or114:Eticket>
										<or114:DepartureDateTime>2019-05-30T17:15:00</or114:DepartureDateTime>
										<or114:ArrivalDateTime>2019-05-30T18:50:00</or114:ArrivalDateTime>
										<or114:FlightNumber>259</or114:FlightNumber>
										<or114:ClassOfService>K</or114:ClassOfService>
										<or114:ActionCode>HK</or114:ActionCode>
										<or114:NumberInParty>2</or114:NumberInParty>
										<or114:SegmentBookedDate>2019-05-02T04:22:00</or114:SegmentBookedDate>
									</or114:Air>
								</or114:ProductDetails>
							</stl19:Product>
						</stl19:Segment>
						<stl19:Segment sequence="2" id="4">
							<stl19:Air id="4" sequence="2" segmentAssociationId="3" isPast="false" DayOfWeekInd="5" CodeShare="false" SpecialMeal="false" StopQuantity="00" SmokingAllowed="false" ResBookDesigCode="K" Code="9W">
								<stl19:DepartureAirport>DEL</stl19:DepartureAirport>
								<stl19:DepartureAirportCodeContext>IATA</stl19:DepartureAirportCodeContext>
								<stl19:DepartureTerminalName>TERMINAL 3</stl19:DepartureTerminalName>
								<stl19:DepartureTerminalCode>3</stl19:DepartureTerminalCode>
								<stl19:ArrivalAirport>KTM</stl19:ArrivalAirport>
								<stl19:ArrivalAirportCodeContext>IATA</stl19:ArrivalAirportCodeContext>
								<stl19:OperatingAirlineCode>9W</stl19:OperatingAirlineCode>
								<stl19:OperatingAirlineShortName>JET AIRWAYS</stl19:OperatingAirlineShortName>
								<stl19:OperatingFlightNumber>0260</stl19:OperatingFlightNumber>
								<stl19:EquipmentType>73H</stl19:EquipmentType>
								<stl19:MarketingAirlineCode>9W</stl19:MarketingAirlineCode>
								<stl19:MarketingFlightNumber>0260</stl19:MarketingFlightNumber>
								<stl19:OperatingClassOfService>K</stl19:OperatingClassOfService>
								<stl19:MarketingClassOfService>K</stl19:MarketingClassOfService>
								<stl19:MarriageGrp>
									<stl19:Ind>0</stl19:Ind>
									<stl19:Group>0</stl19:Group>
									<stl19:Sequence>0</stl19:Sequence>
								</stl19:MarriageGrp>
								<stl19:Meal Code="L"/>
								<stl19:Seats/>
								<stl19:AirlineRefId>DC9W*EBQLNB</stl19:AirlineRefId>
								<stl19:Eticket>true</stl19:Eticket>
								<stl19:DepartureDateTime>2019-06-07T12:45:00</stl19:DepartureDateTime>
								<stl19:ArrivalDateTime>2019-06-07T14:50:00</stl19:ArrivalDateTime>
								<stl19:FlightNumber>0260</stl19:FlightNumber>
								<stl19:ClassOfService>K</stl19:ClassOfService>
								<stl19:ActionCode>HK</stl19:ActionCode>
								<stl19:NumberInParty>2</stl19:NumberInParty>
								<stl19:SegmentSpecialRequests>
									<stl19:GenericSpecialRequest id="20" type="G" msgType="S">
										<stl19:Code>INFT</stl19:Code>
										<stl19:FreeText>/GHIMIRE/SHYAM /03JAN19</stl19:FreeText>
										<stl19:ActionCode>KK</stl19:ActionCode>
										<stl19:NumberInParty>1</stl19:NumberInParty>
										<stl19:AirlineCode>9W</stl19:AirlineCode>
										<stl19:FullText>INFT 9W KK1 DELKTM0260K07JUN/GHIMIRE/SHYAM /03JAN19</stl19:FullText>
									</stl19:GenericSpecialRequest>
									<stl19:GenericSpecialRequest id="38" type="G" msgType="S">
										<stl19:Code>TKNE</stl19:Code>
										<stl19:FreeText>9W HK1 DELKTM0260K07JUN/5893458388858C2</stl19:FreeText>
										<stl19:ActionCode>HK</stl19:ActionCode>
										<stl19:NumberInParty>1</stl19:NumberInParty>
										<stl19:AirlineCode>9W</stl19:AirlineCode>
										<stl19:TicketNumber>5893458388858</stl19:TicketNumber>
										<stl19:FullText>TKNE 9W HK1 DELKTM0260K07JUN/5893458388858C2</stl19:FullText>
									</stl19:GenericSpecialRequest>
									<stl19:GenericSpecialRequest id="40" type="G" msgType="S">
										<stl19:Code>TKNE</stl19:Code>
										<stl19:FreeText>9W HK1 DELKTM0260K07JUN/5893458388859C2</stl19:FreeText>
										<stl19:ActionCode>HK</stl19:ActionCode>
										<stl19:NumberInParty>1</stl19:NumberInParty>
										<stl19:AirlineCode>9W</stl19:AirlineCode>
										<stl19:TicketNumber>5893458388859</stl19:TicketNumber>
										<stl19:FullText>TKNE 9W HK1 DELKTM0260K07JUN/5893458388859C2</stl19:FullText>
									</stl19:GenericSpecialRequest>
									<stl19:GenericSpecialRequest id="42" type="G" msgType="S">
										<stl19:Code>TKNE</stl19:Code>
										<stl19:FreeText>9W HK1 DELKTM0260K07JUN/INF5893458388860C2</stl19:FreeText>
										<stl19:ActionCode>HK</stl19:ActionCode>
										<stl19:NumberInParty>1</stl19:NumberInParty>
										<stl19:AirlineCode>9W</stl19:AirlineCode>
										<stl19:TicketNumber>INF5893458388</stl19:TicketNumber>
										<stl19:FullText>TKNE 9W HK1 DELKTM0260K07JUN/INF5893458388860C2</stl19:FullText>
									</stl19:GenericSpecialRequest>
								</stl19:SegmentSpecialRequests>
								<stl19:inboundConnection>false</stl19:inboundConnection>
								<stl19:outboundConnection>false</stl19:outboundConnection>
								<stl19:ScheduleChangeIndicator>false</stl19:ScheduleChangeIndicator>
								<stl19:SegmentBookedDate>2019-05-02T04:22:00</stl19:SegmentBookedDate>
								<stl19:ElapsedTime>01.50</stl19:ElapsedTime>
								<stl19:AirMilesFlown>0507</stl19:AirMilesFlown>
								<stl19:FunnelFlight>false</stl19:FunnelFlight>
								<stl19:ChangeOfGauge>false</stl19:ChangeOfGauge>
								<stl19:Cabin Code="Y" SabreCode="Y" Name="ECONOMY" ShortName="ECONOMY" Lang="EN"/>
								<stl19:Banner>MARKETED BY JET AIRWAYS</stl19:Banner>
								<stl19:Informational>false</stl19:Informational>
							</stl19:Air>
							<stl19:Product id="4">
								<or114:ProductDetails productCategory="AIR">
									<or114:ProductName type="AIR"/>
									<or114:Air sequence="2" segmentAssociationId="3">
										<or114:DepartureAirport>DEL</or114:DepartureAirport>
										<or114:DepartureTerminalName>TERMINAL 3</or114:DepartureTerminalName>
										<or114:DepartureTerminalCode>3</or114:DepartureTerminalCode>
										<or114:ArrivalAirport>KTM</or114:ArrivalAirport>
										<or114:EquipmentType>73H</or114:EquipmentType>
										<or114:MarketingAirlineCode>9W</or114:MarketingAirlineCode>
										<or114:MarketingFlightNumber>260</or114:MarketingFlightNumber>
										<or114:MarketingClassOfService>K</or114:MarketingClassOfService>
										<or114:Cabin code="Y" sabreCode="Y" name="ECONOMY" shortName="ECONOMY" lang="EN"/>
										<or114:MealCode>L</or114:MealCode>
										<or114:ElapsedTime>110</or114:ElapsedTime>
										<or114:AirMilesFlown>507</or114:AirMilesFlown>
										<or114:FunnelFlight>false</or114:FunnelFlight>
										<or114:ChangeOfGauge>false</or114:ChangeOfGauge>
										<or114:DisclosureCarrier Code="9W" DOT="false">
											<or114:Banner>JET AIRWAYS</or114:Banner>
										</or114:DisclosureCarrier>
										<or114:AirlineRefId>DC9W*EBQLNB</or114:AirlineRefId>
										<or114:Eticket>true</or114:Eticket>
										<or114:DepartureDateTime>2019-06-07T12:45:00</or114:DepartureDateTime>
										<or114:ArrivalDateTime>2019-06-07T14:50:00</or114:ArrivalDateTime>
										<or114:FlightNumber>260</or114:FlightNumber>
										<or114:ClassOfService>K</or114:ClassOfService>
										<or114:ActionCode>HK</or114:ActionCode>
										<or114:NumberInParty>2</or114:NumberInParty>
										<or114:SegmentBookedDate>2019-05-02T04:22:00</or114:SegmentBookedDate>
									</or114:Air>
								</or114:ProductDetails>
							</stl19:Product>
						</stl19:Segment>
					</stl19:Segments>
					<stl19:TicketingInfo>
						<stl19:AlreadyTicketed id="36" index="1" elementId="pnr-36">
							<stl19:Code>T-02MAY-SE1J*AWS</stl19:Code>
						</stl19:AlreadyTicketed>
						<stl19:ETicketNumber id="32" index="2" elementId="pnr-32">TE 5893458388858-IN GHIMI/C SE1J*AWS 1459/02MAY*I</stl19:ETicketNumber>
						<stl19:ETicketNumber id="33" index="3" elementId="pnr-33">TE 5893458388859-IN GHIMI/R SE1J*AWS 1459/02MAY*I</stl19:ETicketNumber>
						<stl19:ETicketNumber id="34" index="4" elementId="pnr-34">TE 5893458388860-IN GHIMI/S SE1J*AWS 1459/02MAY*I</stl19:ETicketNumber>
						<stl19:TicketDetails id="32" index="2" elementId="pnr-32">
							<stl19:OriginalTicketDetails>TE 5893458388858-IN GHIMI/C SE1J*AWS 1459/02MAY*I</stl19:OriginalTicketDetails>
							<stl19:TransactionIndicator>TE</stl19:TransactionIndicator>
							<stl19:TicketNumber>5893458388858</stl19:TicketNumber>
							<stl19:PassengerName>GHIMI/C</stl19:PassengerName>
							<stl19:AgencyLocation>SE1J</stl19:AgencyLocation>
							<stl19:DutyCode>*</stl19:DutyCode>
							<stl19:AgentSine>AWS</stl19:AgentSine>
							<stl19:Timestamp>2019-05-02T14:59:00</stl19:Timestamp>
							<stl19:PaymentType>*</stl19:PaymentType>
						</stl19:TicketDetails>
						<stl19:TicketDetails id="33" index="3" elementId="pnr-33">
							<stl19:OriginalTicketDetails>TE 5893458388859-IN GHIMI/R SE1J*AWS 1459/02MAY*I</stl19:OriginalTicketDetails>
							<stl19:TransactionIndicator>TE</stl19:TransactionIndicator>
							<stl19:TicketNumber>5893458388859</stl19:TicketNumber>
							<stl19:PassengerName>GHIMI/R</stl19:PassengerName>
							<stl19:AgencyLocation>SE1J</stl19:AgencyLocation>
							<stl19:DutyCode>*</stl19:DutyCode>
							<stl19:AgentSine>AWS</stl19:AgentSine>
							<stl19:Timestamp>2019-05-02T14:59:00</stl19:Timestamp>
							<stl19:PaymentType>*</stl19:PaymentType>
						</stl19:TicketDetails>
						<stl19:TicketDetails id="34" index="4" elementId="pnr-34">
							<stl19:OriginalTicketDetails>TE 5893458388860-IN GHIMI/S SE1J*AWS 1459/02MAY*I</stl19:OriginalTicketDetails>
							<stl19:TransactionIndicator>TE</stl19:TransactionIndicator>
							<stl19:TicketNumber>5893458388860</stl19:TicketNumber>
							<stl19:PassengerName>GHIMI/S</stl19:PassengerName>
							<stl19:AgencyLocation>SE1J</stl19:AgencyLocation>
							<stl19:DutyCode>*</stl19:DutyCode>
							<stl19:AgentSine>AWS</stl19:AgentSine>
							<stl19:Timestamp>2019-05-02T14:59:00</stl19:Timestamp>
							<stl19:PaymentType>*</stl19:PaymentType>
						</stl19:TicketDetails>
					</stl19:TicketingInfo>
					<stl19:ItineraryPricing/>
				</stl19:PassengerReservation>
				<stl19:ReceivedFrom>
					<stl19:Name>SWS TESTING</stl19:Name>
				</stl19:ReceivedFrom>
				<stl19:Addresses>
					<stl19:Address>
						<stl19:AddressLines>
							<stl19:AddressLine id="14" type="O">
								<stl19:Text>FAST INTL TRAVEL</stl19:Text>
							</stl19:AddressLine>
							<stl19:AddressLine id="15" type="O">
								<stl19:Text>12</stl19:Text>
							</stl19:AddressLine>
							<stl19:AddressLine id="16" type="O">
								<stl19:Text>KATHMANDU NP</stl19:Text>
							</stl19:AddressLine>
							<stl19:AddressLine id="17" type="O">
								<stl19:Text>00977</stl19:Text>
							</stl19:AddressLine>
						</stl19:AddressLines>
					</stl19:Address>
				</stl19:Addresses>
				<stl19:PhoneNumbers>
					<stl19:PhoneNumber id="13" index="1" elementId="pnr-13">
						<stl19:CityCode>KTM</stl19:CityCode>
						<stl19:Number>5128496532-A-1.1</stl19:Number>
					</stl19:PhoneNumber>
				</stl19:PhoneNumbers>
				<stl19:Remarks>
					<stl19:Remark index="1" id="35" type="REG" elementId="pnr-35">
						<stl19:RemarkLines>
							<stl19:RemarkLine>
								<stl19:Text>XXTAW/</stl19:Text>
							</stl19:RemarkLine>
						</stl19:RemarkLines>
					</stl19:Remark>
					<stl19:Remark index="2" id="24" type="FOP" elementId="pnr-24">
						<stl19:RemarkLines>
							<stl19:RemarkLine>
								<stl19:Text>CASH</stl19:Text>
							</stl19:RemarkLine>
						</stl19:RemarkLines>
					</stl19:Remark>
				</stl19:Remarks>
				<stl19:EmailAddresses/>
				<stl19:GenericSpecialRequests id="29" type="G" msgType="S">
					<stl19:Code>ADTK</stl19:Code>
					<stl19:FreeText>TO 9W BY 09MAY19 1507KTM 09MAY19 1452IN ELSE WILL BE XXLD</stl19:FreeText>
					<stl19:AirlineCode>1B</stl19:AirlineCode>
					<stl19:FullText>ADTK 1B TO 9W BY 09MAY19 1507KTM 09MAY19 1452IN ELSE WILL BE XXLD</stl19:FullText>
				</stl19:GenericSpecialRequests>
				<stl19:GenericSpecialRequests id="31" type="G" msgType="S">
					<stl19:Code>OTHS</stl19:Code>
					<stl19:FreeText>GUEST GST DETAILS INCOMPLETE KINDLY ENTER ALL FIELDS</stl19:FreeText>
					<stl19:AirlineCode>1S</stl19:AirlineCode>
					<stl19:FullText>OTHS 1S GUEST GST DETAILS INCOMPLETE KINDLY ENTER ALL FIELDS</stl19:FullText>
				</stl19:GenericSpecialRequests>
				<stl19:AssociationMatrices>
					<stl19:AssociationMatrix>
						<stl19:Name>PersonIDType</stl19:Name>
						<stl19:Parent ref="pnr-5.1"/>
						<stl19:Child ref="pnr-32">
							<stl19:AssociationRule name="MoveOnDivide" value="ON"/>
						</stl19:Child>
					</stl19:AssociationMatrix>
					<stl19:AssociationMatrix>
						<stl19:Name>PersonIDType</stl19:Name>
						<stl19:Parent ref="pnr-7.2"/>
						<stl19:Child ref="pnr-33">
							<stl19:AssociationRule name="MoveOnDivide" value="ON"/>
						</stl19:Child>
					</stl19:AssociationMatrix>
					<stl19:AssociationMatrix>
						<stl19:Name>PersonIDType</stl19:Name>
						<stl19:Parent ref="pnr-9.3"/>
						<stl19:Child ref="pnr-34">
							<stl19:AssociationRule name="MoveOnDivide" value="ON"/>
						</stl19:Child>
					</stl19:AssociationMatrix>
				</stl19:AssociationMatrices>
				<stl19:OpenReservationElements>
					<or114:OpenReservationElement id="3" type="FP" displayIndex="1" elementId="pnr-or-3">
						<or114:FormOfPayment migrated="false">
							<or114:Cash>
								<or114:Text>CASH</or114:Text>
							</or114:Cash>
						</or114:FormOfPayment>
					</or114:OpenReservationElement>
					<or114:OpenReservationElement id="18" type="SRVC" elementId="pnr-18">
						<or114:ServiceRequest actionCode="HK" airlineCode="9W" code="CHLD" serviceCount="1" serviceType="SSR" ssrType="GFX">
							<or114:FreeText/>
							<or114:FullText>CHLD 9W HK1</or114:FullText>
						</or114:ServiceRequest>
						<or114:NameAssociation>
							<or114:LastName>GHIMIRE</or114:LastName>
							<or114:FirstName>RAM </or114:FirstName>
							<or114:NameRefNumber>02.01</or114:NameRefNumber>
						</or114:NameAssociation>
					</or114:OpenReservationElement>
					<or114:OpenReservationElement id="19" type="SRVC" elementId="pnr-19">
						<or114:ServiceRequest actionCode="KK" airlineCode="9W" code="INFT" serviceCount="1" serviceType="SSR" ssrType="GFX">
							<or114:FreeText>/GHIMIRE/SHYAM /03JAN19</or114:FreeText>
							<or114:FullText>INFT 9W KK1 KTMDEL0259K30MAY/GHIMIRE/SHYAM /03JAN19</or114:FullText>
						</or114:ServiceRequest>
						<or114:SegmentAssociation Id="3" SegmentAssociationId="2">
							<or114:AirSegment>
								<or114:CarrierCode>9W</or114:CarrierCode>
								<or114:FlightNumber>0259</or114:FlightNumber>
								<or114:DepartureDate>2019-05-30</or114:DepartureDate>
								<or114:BoardPoint>KTM</or114:BoardPoint>
								<or114:OffPoint>DEL</or114:OffPoint>
								<or114:ClassOfService>K</or114:ClassOfService>
							</or114:AirSegment>
						</or114:SegmentAssociation>
						<or114:NameAssociation>
							<or114:LastName>GHIMIRE</or114:LastName>
							<or114:FirstName>CHANDRA</or114:FirstName>
							<or114:NameRefNumber>01.01</or114:NameRefNumber>
						</or114:NameAssociation>
					</or114:OpenReservationElement>
					<or114:OpenReservationElement id="20" type="SRVC" elementId="pnr-20">
						<or114:ServiceRequest actionCode="KK" airlineCode="9W" code="INFT" serviceCount="1" serviceType="SSR" ssrType="GFX">
							<or114:FreeText>/GHIMIRE/SHYAM /03JAN19</or114:FreeText>
							<or114:FullText>INFT 9W KK1 DELKTM0260K07JUN/GHIMIRE/SHYAM /03JAN19</or114:FullText>
						</or114:ServiceRequest>
						<or114:SegmentAssociation Id="4" SegmentAssociationId="3">
							<or114:AirSegment>
								<or114:CarrierCode>9W</or114:CarrierCode>
								<or114:FlightNumber>0260</or114:FlightNumber>
								<or114:DepartureDate>2019-06-07</or114:DepartureDate>
								<or114:BoardPoint>DEL</or114:BoardPoint>
								<or114:OffPoint>KTM</or114:OffPoint>
								<or114:ClassOfService>K</or114:ClassOfService>
							</or114:AirSegment>
						</or114:SegmentAssociation>
						<or114:NameAssociation>
							<or114:LastName>GHIMIRE</or114:LastName>
							<or114:FirstName>CHANDRA</or114:FirstName>
							<or114:NameRefNumber>01.01</or114:NameRefNumber>
						</or114:NameAssociation>
					</or114:OpenReservationElement>
					<or114:OpenReservationElement id="21" type="SRVC" elementId="pnr-21">
						<or114:ServiceRequest actionCode="HK" airlineCode="9W" code="DOCS" serviceCount="1" serviceType="SSR" ssrType="GFX">
							<or114:FreeText>/P/NP/254698412/NP/01JAN1984/M/29JAN2024/GHIMIRE/CHANDRA /H</or114:FreeText>
							<or114:FullText>DOCS 9W HK1/P/NP/254698412/NP/01JAN1984/M/29JAN2024/GHIMIRE/CHANDRA /H</or114:FullText>
							<or114:TravelDocument>
								<or114:Type>P</or114:Type>
								<or114:DocumentIssueCountry>NP</or114:DocumentIssueCountry>
								<or114:DocumentNumber>254698412</or114:DocumentNumber>
								<or114:DocumentNationalityCountry>NP</or114:DocumentNationalityCountry>
								<or114:DocumentExpirationDate>29JAN2024</or114:DocumentExpirationDate>
								<or114:DateOfBirth>01JAN1984</or114:DateOfBirth>
								<or114:Gender>M</or114:Gender>
								<or114:LastName>GHIMIRE</or114:LastName>
								<or114:FirstName>CHANDRA</or114:FirstName>
								<or114:MiddleName>H</or114:MiddleName>
								<or114:Infant>false</or114:Infant>
								<or114:PrimaryDocHolderInd>false</or114:PrimaryDocHolderInd>
								<or114:HasDocumentData>true</or114:HasDocumentData>
							</or114:TravelDocument>
						</or114:ServiceRequest>
						<or114:NameAssociation>
							<or114:LastName>GHIMIRE</or114:LastName>
							<or114:FirstName>CHANDRA</or114:FirstName>
							<or114:NameRefNumber>01.01</or114:NameRefNumber>
						</or114:NameAssociation>
					</or114:OpenReservationElement>
					<or114:OpenReservationElement id="22" type="SRVC" elementId="pnr-22">
						<or114:ServiceRequest actionCode="HK" airlineCode="9W" code="DOCS" serviceCount="1" serviceType="SSR" ssrType="GFX">
							<or114:FreeText>/P/NP/254896321/NP/02MAR2013/M/03JAN2025/GHIMIRE/RAM /H</or114:FreeText>
							<or114:FullText>DOCS 9W HK1/P/NP/254896321/NP/02MAR2013/M/03JAN2025/GHIMIRE/RAM /H</or114:FullText>
							<or114:TravelDocument>
								<or114:Type>P</or114:Type>
								<or114:DocumentIssueCountry>NP</or114:DocumentIssueCountry>
								<or114:DocumentNumber>254896321</or114:DocumentNumber>
								<or114:DocumentNationalityCountry>NP</or114:DocumentNationalityCountry>
								<or114:DocumentExpirationDate>03JAN2025</or114:DocumentExpirationDate>
								<or114:DateOfBirth>02MAR2013</or114:DateOfBirth>
								<or114:Gender>M</or114:Gender>
								<or114:LastName>GHIMIRE</or114:LastName>
								<or114:FirstName>RAM</or114:FirstName>
								<or114:MiddleName>H</or114:MiddleName>
								<or114:Infant>false</or114:Infant>
								<or114:PrimaryDocHolderInd>false</or114:PrimaryDocHolderInd>
								<or114:HasDocumentData>true</or114:HasDocumentData>
							</or114:TravelDocument>
						</or114:ServiceRequest>
						<or114:NameAssociation>
							<or114:LastName>GHIMIRE</or114:LastName>
							<or114:FirstName>RAM </or114:FirstName>
							<or114:NameRefNumber>02.01</or114:NameRefNumber>
						</or114:NameAssociation>
					</or114:OpenReservationElement>
					<or114:OpenReservationElement id="23" type="SRVC" elementId="pnr-23">
						<or114:ServiceRequest actionCode="HK" airlineCode="9W" code="DOCS" serviceCount="1" serviceType="SSR" ssrType="GFX">
							<or114:FreeText>/P/NP/621487569/NP/03JAN2019/MI/01JAN2027/GHIMIRE/SHYAM /H</or114:FreeText>
							<or114:FullText>DOCS 9W HK1/P/NP/621487569/NP/03JAN2019/MI/01JAN2027/GHIMIRE/SHYAM /H</or114:FullText>
							<or114:TravelDocument>
								<or114:Type>P</or114:Type>
								<or114:DocumentIssueCountry>NP</or114:DocumentIssueCountry>
								<or114:DocumentNumber>621487569</or114:DocumentNumber>
								<or114:DocumentNationalityCountry>NP</or114:DocumentNationalityCountry>
								<or114:DocumentExpirationDate>01JAN2027</or114:DocumentExpirationDate>
								<or114:DateOfBirth>03JAN2019</or114:DateOfBirth>
								<or114:Gender>MI</or114:Gender>
								<or114:LastName>GHIMIRE</or114:LastName>
								<or114:FirstName>SHYAM</or114:FirstName>
								<or114:MiddleName>H</or114:MiddleName>
								<or114:Infant>true</or114:Infant>
								<or114:PrimaryDocHolderInd>false</or114:PrimaryDocHolderInd>
								<or114:HasDocumentData>true</or114:HasDocumentData>
							</or114:TravelDocument>
						</or114:ServiceRequest>
						<or114:NameAssociation>
							<or114:LastName>GHIMIRE</or114:LastName>
							<or114:FirstName>CHANDRA</or114:FirstName>
							<or114:NameRefNumber>01.01</or114:NameRefNumber>
						</or114:NameAssociation>
					</or114:OpenReservationElement>
					<or114:OpenReservationElement id="29" type="SRVC" elementId="pnr-29">
						<or114:ServiceRequest airlineCode="1B" code="ADTK" serviceType="SSR" ssrType="GFX">
							<or114:FreeText>TO 9W BY 09MAY19 1507KTM 09MAY19 1452IN ELSE WILL BE XXLD</or114:FreeText>
							<or114:FullText>ADTK 1B TO 9W BY 09MAY19 1507KTM 09MAY19 1452IN ELSE WILL BE XXLD</or114:FullText>
						</or114:ServiceRequest>
					</or114:OpenReservationElement>
					<or114:OpenReservationElement id="31" type="SRVC" elementId="pnr-31">
						<or114:ServiceRequest airlineCode="1S" code="OTHS" serviceType="SSR" ssrType="GFX">
							<or114:FreeText>GUEST GST DETAILS INCOMPLETE KINDLY ENTER ALL FIELDS</or114:FreeText>
							<or114:FullText>OTHS 1S GUEST GST DETAILS INCOMPLETE KINDLY ENTER ALL FIELDS</or114:FullText>
						</or114:ServiceRequest>
					</or114:OpenReservationElement>
					<or114:OpenReservationElement id="37" type="SRVC" elementId="pnr-37">
						<or114:ServiceRequest actionCode="HK" airlineCode="9W" code="TKNE" serviceCount="1" serviceType="SSR" ssrType="GFX">
							<or114:FreeText>/5893458388858C1</or114:FreeText>
							<or114:FullText>TKNE 9W HK1 KTMDEL0259K30MAY/5893458388858C1</or114:FullText>
						</or114:ServiceRequest>
						<or114:SegmentAssociation Id="3" SegmentAssociationId="2">
							<or114:AirSegment>
								<or114:CarrierCode>9W</or114:CarrierCode>
								<or114:FlightNumber>0259</or114:FlightNumber>
								<or114:DepartureDate>2019-05-30</or114:DepartureDate>
								<or114:BoardPoint>KTM</or114:BoardPoint>
								<or114:OffPoint>DEL</or114:OffPoint>
								<or114:ClassOfService>K</or114:ClassOfService>
							</or114:AirSegment>
						</or114:SegmentAssociation>
						<or114:NameAssociation>
							<or114:LastName>GHIMIRE</or114:LastName>
							<or114:FirstName>CHANDRA</or114:FirstName>
							<or114:NameRefNumber>01.01</or114:NameRefNumber>
						</or114:NameAssociation>
					</or114:OpenReservationElement>
					<or114:OpenReservationElement id="38" type="SRVC" elementId="pnr-38">
						<or114:ServiceRequest actionCode="HK" airlineCode="9W" code="TKNE" serviceCount="1" serviceType="SSR" ssrType="GFX">
							<or114:FreeText>/5893458388858C2</or114:FreeText>
							<or114:FullText>TKNE 9W HK1 DELKTM0260K07JUN/5893458388858C2</or114:FullText>
						</or114:ServiceRequest>
						<or114:SegmentAssociation Id="4" SegmentAssociationId="3">
							<or114:AirSegment>
								<or114:CarrierCode>9W</or114:CarrierCode>
								<or114:FlightNumber>0260</or114:FlightNumber>
								<or114:DepartureDate>2019-06-07</or114:DepartureDate>
								<or114:BoardPoint>DEL</or114:BoardPoint>
								<or114:OffPoint>KTM</or114:OffPoint>
								<or114:ClassOfService>K</or114:ClassOfService>
							</or114:AirSegment>
						</or114:SegmentAssociation>
						<or114:NameAssociation>
							<or114:LastName>GHIMIRE</or114:LastName>
							<or114:FirstName>CHANDRA</or114:FirstName>
							<or114:NameRefNumber>01.01</or114:NameRefNumber>
						</or114:NameAssociation>
					</or114:OpenReservationElement>
					<or114:OpenReservationElement id="39" type="SRVC" elementId="pnr-39">
						<or114:ServiceRequest actionCode="HK" airlineCode="9W" code="TKNE" serviceCount="1" serviceType="SSR" ssrType="GFX">
							<or114:FreeText>/5893458388859C1</or114:FreeText>
							<or114:FullText>TKNE 9W HK1 KTMDEL0259K30MAY/5893458388859C1</or114:FullText>
						</or114:ServiceRequest>
						<or114:SegmentAssociation Id="3" SegmentAssociationId="2">
							<or114:AirSegment>
								<or114:CarrierCode>9W</or114:CarrierCode>
								<or114:FlightNumber>0259</or114:FlightNumber>
								<or114:DepartureDate>2019-05-30</or114:DepartureDate>
								<or114:BoardPoint>KTM</or114:BoardPoint>
								<or114:OffPoint>DEL</or114:OffPoint>
								<or114:ClassOfService>K</or114:ClassOfService>
							</or114:AirSegment>
						</or114:SegmentAssociation>
						<or114:NameAssociation>
							<or114:LastName>GHIMIRE</or114:LastName>
							<or114:FirstName>RAM </or114:FirstName>
							<or114:NameRefNumber>02.01</or114:NameRefNumber>
						</or114:NameAssociation>
					</or114:OpenReservationElement>
					<or114:OpenReservationElement id="40" type="SRVC" elementId="pnr-40">
						<or114:ServiceRequest actionCode="HK" airlineCode="9W" code="TKNE" serviceCount="1" serviceType="SSR" ssrType="GFX">
							<or114:FreeText>/5893458388859C2</or114:FreeText>
							<or114:FullText>TKNE 9W HK1 DELKTM0260K07JUN/5893458388859C2</or114:FullText>
						</or114:ServiceRequest>
						<or114:SegmentAssociation Id="4" SegmentAssociationId="3">
							<or114:AirSegment>
								<or114:CarrierCode>9W</or114:CarrierCode>
								<or114:FlightNumber>0260</or114:FlightNumber>
								<or114:DepartureDate>2019-06-07</or114:DepartureDate>
								<or114:BoardPoint>DEL</or114:BoardPoint>
								<or114:OffPoint>KTM</or114:OffPoint>
								<or114:ClassOfService>K</or114:ClassOfService>
							</or114:AirSegment>
						</or114:SegmentAssociation>
						<or114:NameAssociation>
							<or114:LastName>GHIMIRE</or114:LastName>
							<or114:FirstName>RAM </or114:FirstName>
							<or114:NameRefNumber>02.01</or114:NameRefNumber>
						</or114:NameAssociation>
					</or114:OpenReservationElement>
					<or114:OpenReservationElement id="41" type="SRVC" elementId="pnr-41">
						<or114:ServiceRequest actionCode="HK" airlineCode="9W" code="TKNE" serviceCount="1" serviceType="SSR" ssrType="GFX">
							<or114:FreeText>/INF5893458388860C1</or114:FreeText>
							<or114:FullText>TKNE 9W HK1 KTMDEL0259K30MAY/INF5893458388860C1</or114:FullText>
						</or114:ServiceRequest>
						<or114:SegmentAssociation Id="3" SegmentAssociationId="2">
							<or114:AirSegment>
								<or114:CarrierCode>9W</or114:CarrierCode>
								<or114:FlightNumber>0259</or114:FlightNumber>
								<or114:DepartureDate>2019-05-30</or114:DepartureDate>
								<or114:BoardPoint>KTM</or114:BoardPoint>
								<or114:OffPoint>DEL</or114:OffPoint>
								<or114:ClassOfService>K</or114:ClassOfService>
							</or114:AirSegment>
						</or114:SegmentAssociation>
						<or114:NameAssociation>
							<or114:LastName>GHIMIRE</or114:LastName>
							<or114:FirstName>CHANDRA</or114:FirstName>
							<or114:NameRefNumber>01.01</or114:NameRefNumber>
						</or114:NameAssociation>
					</or114:OpenReservationElement>
					<or114:OpenReservationElement id="42" type="SRVC" elementId="pnr-42">
						<or114:ServiceRequest actionCode="HK" airlineCode="9W" code="TKNE" serviceCount="1" serviceType="SSR" ssrType="GFX">
							<or114:FreeText>/INF5893458388860C2</or114:FreeText>
							<or114:FullText>TKNE 9W HK1 DELKTM0260K07JUN/INF5893458388860C2</or114:FullText>
						</or114:ServiceRequest>
						<or114:SegmentAssociation Id="4" SegmentAssociationId="3">
							<or114:AirSegment>
								<or114:CarrierCode>9W</or114:CarrierCode>
								<or114:FlightNumber>0260</or114:FlightNumber>
								<or114:DepartureDate>2019-06-07</or114:DepartureDate>
								<or114:BoardPoint>DEL</or114:BoardPoint>
								<or114:OffPoint>KTM</or114:OffPoint>
								<or114:ClassOfService>K</or114:ClassOfService>
							</or114:AirSegment>
						</or114:SegmentAssociation>
						<or114:NameAssociation>
							<or114:LastName>GHIMIRE</or114:LastName>
							<or114:FirstName>CHANDRA</or114:FirstName>
							<or114:NameRefNumber>01.01</or114:NameRefNumber>
						</or114:NameAssociation>
					</or114:OpenReservationElement>
					<or114:OpenReservationElement id="12" type="PSG_DETAILS_MAIL" elementId="pnr-12">
						<or114:Email comment="AIRLINETICKET">
							<or114:Address>TEST@TEST.COM</or114:Address>
						</or114:Email>
						<or114:NameAssociation>
							<or114:LastName>GHIMIRE</or114:LastName>
							<or114:FirstName>CHANDRA</or114:FirstName>
							<or114:NameRefNumber>01.01</or114:NameRefNumber>
						</or114:NameAssociation>
					</or114:OpenReservationElement>
				</stl19:OpenReservationElements>
			</stl19:Reservation>
			<or114:PriceQuote>
				<PriceQuoteInfo xmlns="http://www.sabre.com/ns/Ticketing/pqs/1.0">
					<Reservation updateToken="eNc:::urUp06ZE91eibFAaSo+rVw=="/>
					<Summary>
						<NameAssociation firstName="CHANDRA" lastName="GHIMIRE" nameId="1" nameNumber="1.1">
							<PriceQuote latestPQFlag="true" number="1" pricingStatus="MANUAL" pricingType="S" status="A" type="PQ">
								<Indicators ticketed="true"/>
								<Passenger passengerTypeCount="1" requestedType="ADT" type="ADT"/>
								<ItineraryType>I</ItineraryType>
								<ValidatingCarrier>9W</ValidatingCarrier>
								<Amounts>
									<Total currencyCode="NPR">29740</Total>
								</Amounts>
								<LocalCreateDateTime>2019-05-02T14:49:00</LocalCreateDateTime>
							</PriceQuote>
						</NameAssociation>
						<NameAssociation firstName="RAM" lastName="GHIMIRE" nameId="2" nameNumber="2.1">
							<PriceQuote latestPQFlag="true" number="2" pricingStatus="MANUAL" pricingType="S" status="A" type="PQ">
								<Indicators ticketed="true"/>
								<Passenger passengerTypeCount="1" requestedType="CNN" type="CNN"/>
								<ItineraryType>I</ItineraryType>
								<TicketDesignator>CH25</TicketDesignator>
								<ValidatingCarrier>9W</ValidatingCarrier>
								<Amounts>
									<Total currencyCode="NPR">26090</Total>
								</Amounts>
								<LocalCreateDateTime>2019-05-02T14:49:00</LocalCreateDateTime>
							</PriceQuote>
						</NameAssociation>
						<NameAssociation firstName="SHYAM" lastName="I/1GHIMIRE" nameId="3" nameNumber="3.1">
							<PriceQuote latestPQFlag="true" number="3" pricingStatus="MANUAL" pricingType="S" status="A" type="PQ">
								<Indicators ticketed="true"/>
								<Passenger passengerTypeCount="1" requestedType="INF" type="INF"/>
								<ItineraryType>I</ItineraryType>
								<TicketDesignator>IN90</TicketDesignator>
								<ValidatingCarrier>9W</ValidatingCarrier>
								<Amounts>
									<Total currencyCode="NPR">8238</Total>
								</Amounts>
								<LocalCreateDateTime>2019-05-02T14:49:00</LocalCreateDateTime>
							</PriceQuote>
						</NameAssociation>
					</Summary>
					<Details number="1" passengerType="ADT" pricingStatus="MANUAL" pricingType="S" status="A" type="PQ">
						<AgentInfo duty="*" sine="AWS">
							<HomeLocation>SE1J</HomeLocation>
							<WorkLocation>SE1J</WorkLocation>
						</AgentInfo>
						<TransactionInfo>
							<CreateDateTime>2019-05-02T04:19:00</CreateDateTime>
							<UpdateDateTime>2019-05-02T04:22:00</UpdateDateTime>
							<LocalCreateDateTime>2019-05-02T14:49:00</LocalCreateDateTime>
							<LocalUpdateDateTime>2019-05-02T14:52:00</LocalUpdateDateTime>
							<InputEntry>WPA9WP1ADT/1CNN/1INFXOTE-NQRQ</InputEntry>
						</TransactionInfo>
						<NameAssociationInfo firstName="CHANDRA" lastName="GHIMIRE" nameId="1" nameNumber="1.1"/>
						<SegmentInfo number="1" segmentStatus="OK">
							<Flight connectionIndicator="O">
								<MarketingFlight number="259">9W</MarketingFlight>
								<ClassOfService>K</ClassOfService>
								<Departure>
									<DateTime>2019-05-30T17:15:00</DateTime>
									<CityCode name="KATHMANDU">KTM</CityCode>
								</Departure>
								<Arrival>
									<DateTime>2019-05-30T18:50:00</DateTime>
									<CityCode name="DELHI">DEL</CityCode>
								</Arrival>
							</Flight>
							<FareBasis>K2RTNP</FareBasis>
							<NotValidBefore>2019-05-30</NotValidBefore>
							<NotValidAfter>2019-05-30</NotValidAfter>
							<Baggage allowance="20" type="K"/>
						</SegmentInfo>
						<SegmentInfo number="2" segmentStatus="OK">
							<Flight connectionIndicator="O">
								<MarketingFlight number="260">9W</MarketingFlight>
								<ClassOfService>K</ClassOfService>
								<Departure>
									<DateTime>2019-06-07T12:45:00</DateTime>
									<CityCode name="DELHI">DEL</CityCode>
								</Departure>
								<Arrival>
									<DateTime>2019-06-07T14:50:00</DateTime>
									<CityCode name="KATHMANDU">KTM</CityCode>
								</Arrival>
							</Flight>
							<FareBasis>K2RTNP</FareBasis>
							<NotValidBefore>2019-06-07</NotValidBefore>
							<NotValidAfter>2019-06-07</NotValidAfter>
							<Baggage allowance="20" type="K"/>
						</SegmentInfo>
						<FareInfo source="ATPC">
							<FareIndicators/>
							<BaseFare currencyCode="NPR">14610</BaseFare>
							<TotalTax currencyCode="NPR">15130</TotalTax>
							<TotalFare currencyCode="NPR">29740</TotalFare>
							<TaxInfo>
								<CombinedTax code="NQ">
									<Amount currencyCode="NPR">0</Amount>
								</CombinedTax>
								<CombinedTax code="NP">
									<Amount currencyCode="NPR">791</Amount>
								</CombinedTax>
								<CombinedTax code="XT">
									<Amount currencyCode="NPR">14339</Amount>
								</CombinedTax>
								<Tax code="NQ">
									<Amount currencyCode="NPR">0</Amount>
								</Tax>
								<Tax code="NP">
									<Amount currencyCode="NPR">791</Amount>
								</Tax>
								<Tax code="B6">
									<Amount currencyCode="NPR">1000</Amount>
								</Tax>
								<Tax code="WO">
									<Amount currencyCode="NPR">689</Amount>
								</Tax>
								<Tax code="YR">
									<Amount currencyCode="NPR">2260</Amount>
								</Tax>
								<Tax code="YQ">
									<Amount currencyCode="NPR">10390</Amount>
								</Tax>
							</TaxInfo>
							<FareCalculation>KTM 9W DEL65.83 9W KTM65.83NUC131.66END ROE110.909234</FareCalculation>
							<FareComponent fareBasisCode="K2RTNP" number="1">
								<FlightSegmentNumbers>
									<SegmentNumber>1</SegmentNumber>
								</FlightSegmentNumbers>
								<FareDirectionality roundTrip="true"/>
								<Departure>
									<DateTime>2019-05-30T17:15:00</DateTime>
									<CityCode name="KATHMANDU">KTM</CityCode>
								</Departure>
								<Arrival>
									<DateTime>2019-05-30T18:50:00</DateTime>
									<CityCode name="DELHI">DEL</CityCode>
								</Arrival>
								<Amount currencyCode="NUC" decimalPlace="2">65.83</Amount>
								<GoverningCarrier>9W</GoverningCarrier>
							</FareComponent>
							<FareComponent fareBasisCode="K2RTNP" number="2">
								<FlightSegmentNumbers>
									<SegmentNumber>2</SegmentNumber>
								</FlightSegmentNumbers>
								<FareDirectionality inbound="true" roundTrip="true"/>
								<Departure>
									<DateTime>2019-06-07T12:45:00</DateTime>
									<CityCode name="DELHI">DEL</CityCode>
								</Departure>
								<Arrival>
									<DateTime>2019-06-07T14:50:00</DateTime>
									<CityCode name="KATHMANDU">KTM</CityCode>
								</Arrival>
								<Amount currencyCode="NUC" decimalPlace="2">65.83</Amount>
								<GoverningCarrier>9W</GoverningCarrier>
							</FareComponent>
						</FareInfo>
						<FeeInfo>
							<OBFee code="FCA" noChargeIndicator="X" type="OB">
								<Amount currencyCode="NPR">0</Amount>
								<Total currencyCode="NPR">29740</Total>
								<Description>ANY CC</Description>
							</OBFee>
							<OBFee code="FCA" type="OB">
								<Amount currencyCode="NPR">399</Amount>
								<Total currencyCode="NPR">30139</Total>
								<Description>ANY CC</Description>
							</OBFee>
							<OBFee code="FDA" noChargeIndicator="X" type="OB">
								<Amount currencyCode="NPR">0</Amount>
								<Total currencyCode="NPR">29740</Total>
								<Description>ANY CC</Description>
							</OBFee>
						</FeeInfo>
						<MiscellaneousInfo>
							<ValidatingCarrier>9W</ValidatingCarrier>
							<ItineraryType>I</ItineraryType>
						</MiscellaneousInfo>
						<MessageInfo>
							<Message number="301" type="INFO">One or more form of payment fees may apply</Message>
							<Message number="302" type="INFO">Actual total will be based on form of payment used</Message>
							<Message type="WARNING">VALIDATING CARRIER SPECIFIED - 9W</Message>
							<Remarks type="ENS">NON ENDO</Remarks>
							<PricingParameters>WPA9WP1ADT/1CNN/1INFXOTE-NQRQ</PricingParameters>
						</MessageInfo>
						<HistoryInfo>
							<AgentInfo sine="AWS">
								<HomeLocation>SE1J</HomeLocation>
							</AgentInfo>
							<TransactionInfo>
								<LocalDateTime>2019-05-02T14:49:00</LocalDateTime>
								<InputEntry>WPA9WP1ADT/1CNN/1INFXOTE-NQRQ</InputEntry>
							</TransactionInfo>
						</HistoryInfo>
					</Details>
					<Details number="2" passengerType="CNN" pricingStatus="MANUAL" pricingType="S" status="A" type="PQ">
						<AgentInfo duty="*" sine="AWS">
							<HomeLocation>SE1J</HomeLocation>
							<WorkLocation>SE1J</WorkLocation>
						</AgentInfo>
						<TransactionInfo>
							<CreateDateTime>2019-05-02T04:19:00</CreateDateTime>
							<UpdateDateTime>2019-05-02T04:22:00</UpdateDateTime>
							<LocalCreateDateTime>2019-05-02T14:49:00</LocalCreateDateTime>
							<LocalUpdateDateTime>2019-05-02T14:52:00</LocalUpdateDateTime>
							<InputEntry>WPA9WP1ADT/1CNN/1INFXOTE-NQRQ</InputEntry>
						</TransactionInfo>
						<NameAssociationInfo firstName="RAM" lastName="GHIMIRE" nameId="2" nameNumber="2.1"/>
						<SegmentInfo number="1" segmentStatus="OK">
							<Flight connectionIndicator="O">
								<MarketingFlight number="259">9W</MarketingFlight>
								<ClassOfService>K</ClassOfService>
								<Departure>
									<DateTime>2019-05-30T17:15:00</DateTime>
									<CityCode name="KATHMANDU">KTM</CityCode>
								</Departure>
								<Arrival>
									<DateTime>2019-05-30T18:50:00</DateTime>
									<CityCode name="DELHI">DEL</CityCode>
								</Arrival>
							</Flight>
							<FareBasis>K2RTNP/CH25</FareBasis>
							<NotValidBefore>2019-05-30</NotValidBefore>
							<NotValidAfter>2019-05-30</NotValidAfter>
							<Baggage allowance="20" type="K"/>
						</SegmentInfo>
						<SegmentInfo number="2" segmentStatus="OK">
							<Flight connectionIndicator="O">
								<MarketingFlight number="260">9W</MarketingFlight>
								<ClassOfService>K</ClassOfService>
								<Departure>
									<DateTime>2019-06-07T12:45:00</DateTime>
									<CityCode name="DELHI">DEL</CityCode>
								</Departure>
								<Arrival>
									<DateTime>2019-06-07T14:50:00</DateTime>
									<CityCode name="KATHMANDU">KTM</CityCode>
								</Arrival>
							</Flight>
							<FareBasis>K2RTNP/CH25</FareBasis>
							<NotValidBefore>2019-06-07</NotValidBefore>
							<NotValidAfter>2019-06-07</NotValidAfter>
							<Baggage allowance="20" type="K"/>
						</SegmentInfo>
						<FareInfo source="ATPC">
							<FareIndicators/>
							<BaseFare currencyCode="NPR">10960</BaseFare>
							<TotalTax currencyCode="NPR">15130</TotalTax>
							<TotalFare currencyCode="NPR">26090</TotalFare>
							<TaxInfo>
								<CombinedTax code="NQ">
									<Amount currencyCode="NPR">0</Amount>
								</CombinedTax>
								<CombinedTax code="NP">
									<Amount currencyCode="NPR">791</Amount>
								</CombinedTax>
								<CombinedTax code="XT">
									<Amount currencyCode="NPR">14339</Amount>
								</CombinedTax>
								<Tax code="NQ">
									<Amount currencyCode="NPR">0</Amount>
								</Tax>
								<Tax code="NP">
									<Amount currencyCode="NPR">791</Amount>
								</Tax>
								<Tax code="B6">
									<Amount currencyCode="NPR">1000</Amount>
								</Tax>
								<Tax code="WO">
									<Amount currencyCode="NPR">689</Amount>
								</Tax>
								<Tax code="YR">
									<Amount currencyCode="NPR">2260</Amount>
								</Tax>
								<Tax code="YQ">
									<Amount currencyCode="NPR">10390</Amount>
								</Tax>
							</TaxInfo>
							<FareCalculation>KTM 9W DEL49.37 9W KTM49.37NUC98.74END ROE110.909234</FareCalculation>
							<FareComponent fareBasisCode="K2RTNP/CH25" number="1">
								<FlightSegmentNumbers>
									<SegmentNumber>1</SegmentNumber>
								</FlightSegmentNumbers>
								<FareDirectionality roundTrip="true"/>
								<Departure>
									<DateTime>2019-05-30T17:15:00</DateTime>
									<CityCode name="KATHMANDU">KTM</CityCode>
								</Departure>
								<Arrival>
									<DateTime>2019-05-30T18:50:00</DateTime>
									<CityCode name="DELHI">DEL</CityCode>
								</Arrival>
								<Amount currencyCode="NUC" decimalPlace="2">49.37</Amount>
								<GoverningCarrier>9W</GoverningCarrier>
								<TicketDesignator>CH25</TicketDesignator>
							</FareComponent>
							<FareComponent fareBasisCode="K2RTNP/CH25" number="2">
								<FlightSegmentNumbers>
									<SegmentNumber>2</SegmentNumber>
								</FlightSegmentNumbers>
								<FareDirectionality inbound="true" roundTrip="true"/>
								<Departure>
									<DateTime>2019-06-07T12:45:00</DateTime>
									<CityCode name="DELHI">DEL</CityCode>
								</Departure>
								<Arrival>
									<DateTime>2019-06-07T14:50:00</DateTime>
									<CityCode name="KATHMANDU">KTM</CityCode>
								</Arrival>
								<Amount currencyCode="NUC" decimalPlace="2">49.37</Amount>
								<GoverningCarrier>9W</GoverningCarrier>
								<TicketDesignator>CH25</TicketDesignator>
							</FareComponent>
						</FareInfo>
						<FeeInfo>
							<OBFee code="FCA" noChargeIndicator="X" type="OB">
								<Amount currencyCode="NPR">0</Amount>
								<Total currencyCode="NPR">26090</Total>
								<Description>ANY CC</Description>
							</OBFee>
							<OBFee code="FCA" type="OB">
								<Amount currencyCode="NPR">399</Amount>
								<Total currencyCode="NPR">26489</Total>
								<Description>ANY CC</Description>
							</OBFee>
							<OBFee code="FDA" noChargeIndicator="X" type="OB">
								<Amount currencyCode="NPR">0</Amount>
								<Total currencyCode="NPR">26090</Total>
								<Description>ANY CC</Description>
							</OBFee>
						</FeeInfo>
						<MiscellaneousInfo>
							<ValidatingCarrier>9W</ValidatingCarrier>
							<ItineraryType>I</ItineraryType>
						</MiscellaneousInfo>
						<MessageInfo>
							<Message number="301" type="INFO">One or more form of payment fees may apply</Message>
							<Message number="302" type="INFO">Actual total will be based on form of payment used</Message>
							<Message type="WARNING">EACH CNN REQUIRES ACCOMPANYING SAME CABIN ADT</Message>
							<Message type="WARNING">VALIDATING CARRIER SPECIFIED - 9W</Message>
							<Remarks type="ENS">NON ENDO</Remarks>
							<PricingParameters>WPA9WP1ADT/1CNN/1INFXOTE-NQRQ</PricingParameters>
						</MessageInfo>
						<HistoryInfo>
							<AgentInfo sine="AWS">
								<HomeLocation>SE1J</HomeLocation>
							</AgentInfo>
							<TransactionInfo>
								<LocalDateTime>2019-05-02T14:49:00</LocalDateTime>
								<InputEntry>WPA9WP1ADT/1CNN/1INFXOTE-NQRQ</InputEntry>
							</TransactionInfo>
						</HistoryInfo>
					</Details>
					<Details number="3" passengerType="INF" pricingStatus="MANUAL" pricingType="S" status="A" type="PQ">
						<AgentInfo duty="*" sine="AWS">
							<HomeLocation>SE1J</HomeLocation>
							<WorkLocation>SE1J</WorkLocation>
						</AgentInfo>
						<TransactionInfo>
							<CreateDateTime>2019-05-02T04:19:00</CreateDateTime>
							<UpdateDateTime>2019-05-02T04:22:00</UpdateDateTime>
							<LocalCreateDateTime>2019-05-02T14:49:00</LocalCreateDateTime>
							<LocalUpdateDateTime>2019-05-02T14:52:00</LocalUpdateDateTime>
							<InputEntry>WPA9WP1ADT/1CNN/1INFXOTE-NQRQ</InputEntry>
						</TransactionInfo>
						<NameAssociationInfo firstName="SHYAM" lastName="I/1GHIMIRE" nameId="3" nameNumber="3.1"/>
						<SegmentInfo number="1" segmentStatus="NS">
							<Flight connectionIndicator="O">
								<MarketingFlight number="259">9W</MarketingFlight>
								<ClassOfService>K</ClassOfService>
								<Departure>
									<DateTime>2019-05-30T17:15:00</DateTime>
									<CityCode name="KATHMANDU">KTM</CityCode>
								</Departure>
								<Arrival>
									<DateTime>2019-05-30T18:50:00</DateTime>
									<CityCode name="DELHI">DEL</CityCode>
								</Arrival>
							</Flight>
							<FareBasis>K2RTNP/IN90</FareBasis>
							<NotValidBefore>2019-05-30</NotValidBefore>
							<NotValidAfter>2019-05-30</NotValidAfter>
							<Baggage allowance="10" type="K"/>
						</SegmentInfo>
						<SegmentInfo number="2" segmentStatus="NS">
							<Flight connectionIndicator="O">
								<MarketingFlight number="260">9W</MarketingFlight>
								<ClassOfService>K</ClassOfService>
								<Departure>
									<DateTime>2019-06-07T12:45:00</DateTime>
									<CityCode name="DELHI">DEL</CityCode>
								</Departure>
								<Arrival>
									<DateTime>2019-06-07T14:50:00</DateTime>
									<CityCode name="KATHMANDU">KTM</CityCode>
								</Arrival>
							</Flight>
							<FareBasis>K2RTNP/IN90</FareBasis>
							<NotValidBefore>2019-06-07</NotValidBefore>
							<NotValidAfter>2019-06-07</NotValidAfter>
							<Baggage allowance="10" type="K"/>
						</SegmentInfo>
						<FareInfo source="ATPC">
							<FareIndicators/>
							<BaseFare currencyCode="NPR">1460</BaseFare>
							<TotalTax currencyCode="NPR">6778</TotalTax>
							<TotalFare currencyCode="NPR">8238</TotalFare>
							<TaxInfo>
								<CombinedTax code="NQ">
									<Amount currencyCode="NPR">0</Amount>
								</CombinedTax>
								<CombinedTax code="YR">
									<Amount currencyCode="NPR">2260</Amount>
								</CombinedTax>
								<CombinedTax code="YQ">
									<Amount currencyCode="NPR">4518</Amount>
								</CombinedTax>
								<Tax code="NQ">
									<Amount currencyCode="NPR">0</Amount>
								</Tax>
								<Tax code="YR">
									<Amount currencyCode="NPR">2260</Amount>
								</Tax>
								<Tax code="YQ">
									<Amount currencyCode="NPR">4518</Amount>
								</Tax>
							</TaxInfo>
							<FareCalculation>KTM 9W DEL6.58 9W KTM6.58NUC13.16END ROE110.909234</FareCalculation>
							<FareComponent fareBasisCode="K2RTNP/IN90" number="1">
								<FlightSegmentNumbers>
									<SegmentNumber>1</SegmentNumber>
								</FlightSegmentNumbers>
								<FareDirectionality roundTrip="true"/>
								<Departure>
									<DateTime>2019-05-30T17:15:00</DateTime>
									<CityCode name="KATHMANDU">KTM</CityCode>
								</Departure>
								<Arrival>
									<DateTime>2019-05-30T18:50:00</DateTime>
									<CityCode name="DELHI">DEL</CityCode>
								</Arrival>
								<Amount currencyCode="NUC" decimalPlace="2">6.58</Amount>
								<GoverningCarrier>9W</GoverningCarrier>
								<TicketDesignator>IN90</TicketDesignator>
							</FareComponent>
							<FareComponent fareBasisCode="K2RTNP/IN90" number="2">
								<FlightSegmentNumbers>
									<SegmentNumber>2</SegmentNumber>
								</FlightSegmentNumbers>
								<FareDirectionality inbound="true" roundTrip="true"/>
								<Departure>
									<DateTime>2019-06-07T12:45:00</DateTime>
									<CityCode name="DELHI">DEL</CityCode>
								</Departure>
								<Arrival>
									<DateTime>2019-06-07T14:50:00</DateTime>
									<CityCode name="KATHMANDU">KTM</CityCode>
								</Arrival>
								<Amount currencyCode="NUC" decimalPlace="2">6.58</Amount>
								<GoverningCarrier>9W</GoverningCarrier>
								<TicketDesignator>IN90</TicketDesignator>
							</FareComponent>
						</FareInfo>
						<FeeInfo>
							<OBFee code="FCA" noChargeIndicator="X" type="OB">
								<Amount currencyCode="NPR">0</Amount>
								<Total currencyCode="NPR">8238</Total>
								<Description>ANY CC</Description>
							</OBFee>
							<OBFee code="FCA" type="OB">
								<Amount currencyCode="NPR">399</Amount>
								<Total currencyCode="NPR">8637</Total>
								<Description>ANY CC</Description>
							</OBFee>
							<OBFee code="FDA" noChargeIndicator="X" type="OB">
								<Amount currencyCode="NPR">0</Amount>
								<Total currencyCode="NPR">8238</Total>
								<Description>ANY CC</Description>
							</OBFee>
						</FeeInfo>
						<MiscellaneousInfo>
							<ValidatingCarrier>9W</ValidatingCarrier>
							<ItineraryType>I</ItineraryType>
						</MiscellaneousInfo>
						<MessageInfo>
							<Message number="301" type="INFO">One or more form of payment fees may apply</Message>
							<Message number="302" type="INFO">Actual total will be based on form of payment used</Message>
							<Message type="WARNING">REQUIRES ACCOMPANYING ADT PASSENGER</Message>
							<Message type="WARNING">EACH INF REQUIRES ACCOMPANYING ADT PASSENGER</Message>
							<Message type="WARNING">VALIDATING CARRIER SPECIFIED - 9W</Message>
							<Remarks type="ENS">NON ENDO</Remarks>
							<PricingParameters>WPA9WP1ADT/1CNN/1INFXOTE-NQRQ</PricingParameters>
						</MessageInfo>
						<HistoryInfo>
							<AgentInfo sine="AWS">
								<HomeLocation>SE1J</HomeLocation>
							</AgentInfo>
							<TransactionInfo>
								<LocalDateTime>2019-05-02T14:49:00</LocalDateTime>
								<InputEntry>WPA9WP1ADT/1CNN/1INFXOTE-NQRQ</InputEntry>
							</TransactionInfo>
						</HistoryInfo>
					</Details>
				</PriceQuoteInfo>
			</or114:PriceQuote>
		</stl19:GetReservationRS>
	</soap-env:Body>
</soap-env:Envelope>
XML;


    }
}
