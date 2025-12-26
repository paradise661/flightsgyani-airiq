<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml"
>

<head>
    <title>
    </title>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{url('front/css/bootstrap.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,500,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet" type="text/css">
    <style type="text/css">
        @import url(https://fonts.googleapis.com/css?family=Lato:300,400,500,700);
        @import url(https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700);
    </style>
    <style>
        @page {
            margin: 0;
            padding: 0;
            page-break-after: auto;
            margin-top: 10px;
            word-break: break-word;
        }

    </style>
</head>

<body>
<div class="container-fluid">
    <div class="row-fluid" style="background:#f5f5f5;">
        <div class="col-md-12 pt-4">
            <table width="100%" cellspacing="0" cellpadding="0">
                <tr>
                    <td style="width: 30%">
                        @if(isset($booking->user_id))
                            @if($booking->bookedBy->hasRole('Agent'))
                                @if($booking->bookedBy->agencyDetail()->exists())
                                    @if(isset($booking->bookedBy->agencyDetail->agency_logo))
                                        <img
                                            src="{{ URL::asset('storage/agencylogo/'.$booking->bookedBy->agencyDetail->agency_logo ) }}"
                                            width="100%" class="" alt="">
                                    @else
                                        <img src="{{ URL::asset('front/images/ticket-flight.png')  }}"
                                             width="100%" class="" alt="">
                                    @endif
                                @else
                                    <img src="{{ URL::asset('public/front/images/flight-takeoff.png')  }}"
                                         width="100%" class="" alt="">
                                @endif
                            @else
                                <img src="{{ URL::asset('front/images/fitt-logo.png') }}" width="100%"
                                     class="" alt="">
                            @endif
                        @else
                            <img
                                src="{{ URL::asset('front/images/fitt-logo.png') }}" width="100%"
                                class="" alt="">
                        @endif
                    </td>
                    <td style="width: 70%;font-family:Lato, Helvetica, Arial, sans-serif;font-weight:900;line-height:1;text-align:right;">
                        @if(isset($booking->user_id))
                            {{--                            @if($booking->bookedBy->hasRole('Agent'))--}}
                            {{--                                @if($booking->bookedBy->agencyDetail()->exists())--}}
                            {{--                                      <p  style="font-size:25px;color:#2a5cab;">--}}
                            {{--                                            {{ $booking->bookedBy->agencyDetail->name }}--}}
                            {{--                                        </p>--}}
                            {{--                                    @if(isset($booking->bookedBy->agencyDetail->contact))--}}

                            {{--                                        <p  style="font-size:16px;color:#16161d;">Contact: {{ $booking->bookedBy->agencyDetail->contact }}--}}
                            {{--                                        </p>--}}
                            {{--                                    @else--}}
                            {{--                                        <p></p>--}}
                            {{--                                    @endif--}}
                            {{--                                    @if(isset($booking->bookedBy->agencyDetail->address))--}}
                            {{--                                        <p   style="font-size:16px;color:#16161d;">Address:{{ $booking->bookedBy->agencyDetail->address }}--}}

                            {{--                                    @else--}}
                            {{--                                        <p></p>--}}
                            {{--                                    @endif--}}
                            {{--                                @else--}}
                            <p style="font-size:25px;color:#2a5cab;">
                                {{ $booking->bookedBy->name }}
                            </p>

                        @endif
                        @else
                            <p style="font-size:16px;color:#16161d;">Fitt Hotline: {{ config('fitt.huntingline') }}<br/>
                                {{ explode(',',config('fitt.phone'))[0] }}</p>
                            <p style="font-size:16px;color:#16161d;">
                                Agency: {{ explode(',',config('fitt.phone'))[1] }}</p>
                        @endif
                        @else
                            <p style="font-size:16px;color:#16161d;">Fitt Hotline: {{ config('fitt.huntingline') }}<br/>
                                {{ explode(',',config('fitt.phone'))[0] }}</p>
                            <p style="font-size:16px;color:#16161d;">
                                Agency: {{ explode(',',config('fitt.phone'))[1] }}</p>
                        @endif

                    </td>
                </tr>

            </table>
        </div>


    </div>
    <div class="row-fluid" style="background:#f5f5f5;">
        <div class="col-md-12 p-0 m-0"
             style="font-family:Lato, Helvetica, Arial, sans-serif;font-size:25px;font-weight:900;line-height:1;text-align:center;color:#343a40;">
            e-Ticket Receipt
        </div>
    </div>
    <div class="row-fluid">
        <div class="col-md-12" style="font-family:Lato, Helvetica, Arial, sans-serif;
        font-size:10px;line-height:1;text-align:left;color:#999999; padding-bottom: 10px;">
            <strong>Below are the details of your electronic ticket.</strong>
        </div>
    </div>
    <div class="row-fluid">
        <div class="col-md-12"
             style="background:#6c757d; color:#eeeeee;font-family:Ubuntu, Helvetica, Arial,
             sans-serif;font-size:13px;line-height:22px;">
            PASSENGER & TICKET INFORMATION
        </div>
    </div>
    <div class="row-fluid mt-1">

        <table cellpadding="0" cellspacing="0" width="100%" border="0"
               style="color:#000000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;table-layout:auto;width:100%;border:none;">
            <tr style="border:1px solid #ecedee;text-align:center;padding:15px 0;background:#e5e4e2">
                <th style="border:1px solid #0f0f0f;padding: 0 15px;">Airline PNR</th>
                <th style="border:1px solid #0f0f0f; padding: 0 15px;">GDS PNR</th>
                <th style="border:1px solid #0f0f0f; padding: 0 0 0 15px;">Date of Issue</th>
            </tr>
            <tr>
                <td style="border:1px solid #0f0f0f;text-align:center; padding: 0 15px;"></td>
                <td style="border:1px solid #0f0f0f; text-align:center; padding: 0 15px;">{{ $booking->pnr_id }}</td>
                <td style="border:1px solid #0f0f0f; text-align:center; padding: 0 15px;">{{$booking->updated_at->toFormattedDateString()}}</td>
            </tr>
        </table>
    </div>

    <div class="row-fluid mt-2">
        <table cellpadding="0" cellspacing="0" width="100%" border="0"
               style="color:#000000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;table-layout:auto;width:100%;border:none;">
            <tr style="border:1px solid #ecedee;text-align:center;padding:15px 0;background:#e5e4e2">
                <th style="border:1px solid #0f0f0f;text-align:center;padding: 0 15px;">S/N</th>
                <th style="border:1px solid #0f0f0f;text-align:center; padding: 0 15px;">Passenger Name</th>
                <th style="border:1px solid #0f0f0f;text-align:center; padding: 0 0 0 15px;">Ticket Number</th>
                <th style="border:1px solid #0f0f0f;text-align:center; padding: 0 0 0 15px;">Ticket Status</th>
            </tr>

            @forelse($tickets as $ticket)
                <tr>
                    <td style="border:1px solid #0f0f0f;text-align:center; padding: 0 15px;">{{ $loop->iteration }}</td>
                    <td style="border:1px solid #0f0f0f; text-align:center; padding: 0 25px;">{{ $ticket->first_name }} {{ $ticket->last_name }}</td>
                    <td style="border:1px solid #0f0f0f; text-align:center; padding: 0 15px;">{{ $ticket->ticket_number }}</td>
                    <td style="border:1px solid #0f0f0f; text-align:center; padding: 0 15px;"> @if(!isset($ticket->void_date))
                            {{'Confirmed'}}
                        @else
                            {{'Void'}}
                        @endif
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="4">Tickets not issued</td>
                </tr>
            @endforelse


        </table>

    </div>
    <div class="row-fluid mt-1">
        <div class="col-md-12"
             style="background:#6c757d; color:#eeeeee;font-family:Ubuntu, Helvetica, Arial,
             sans-serif;font-size:13px;line-height:22px;">
            TRAVEL INFORMATION & ITINEARY
        </div>
    </div>
    <div class="row-fluid mt-3 page-break">
        <table cellpadding="0" cellspacing="0" width="100%" border="0"
               style="word-break:break-word;color:#000000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;table-layout:auto;border:none;">
            <tr style="border:1px solid #ecedee;text-align:center;background:#e5e4e2">
                <th style="border:1px solid #0f0f0f;">Airline</th>
                <th style="border:1px solid #0f0f0f;">Flight Number</th>
                <th style="border:1px solid #0f0f0f;">Departing</th>
                <th style="border:1px solid #0f0f0f;">Arriving</th>
                <th style="border:1px solid #0f0f0f;">Info</th>
            </tr>
            @foreach($flights as $f)
                @foreach($f as $flight)
                    <tr>
                        <td style="border:1px solid #0f0f0f;" width="15%">
                            <img
                                src="{{ URL::asset('front/air-logos/'.$flight['marketingairline'].'.png') }}"
                                style="border:0;display:block;outline:none;text-decoration:none;height:auto;width:100%;"
                                alt="{{$flight['marketingairline']}}"></td>
                        <td style="border:1px solid #0f0f0f;font-weight:bold; text-align:center; "
                            width="15%">{{ $flight['marketingairline'] }}
                            &nbsp;- {{ $flight['flightnumber'] }}&nbsp;
                        </td>
                        <td style="border:1px solid #0f0f0f; text-align:center; padding-left: 5px;" width="20%">
                            <b>{{ $flight['departure'] }}</b><br/>
                            <br/><b> {{ \Carbon\Carbon::parse($flight['departdate'])->toFormattedDateString() }} {{ $flight['departtime'] }}</b>
                        </td>
                        <td style="border:1px solid #0f0f0f; text-align:center; padding-left: 5px; " width="20%">
                            <b>{{ $flight['arrival'] }}</b><br>
                            <br/>
                            <b>{{ \Carbon\Carbon::parse($flight['arrivaldate'])->toFormattedDateString() }} {{ $flight['arrivaltime'] }}</b>
                        </td>
                        <td style="border:1px solid #0f0f0f; text-align:left; padding-left: 5px;" width="30%">
                            <!--                            <b>Luggage :</b> 25K <br/>
                                                        <b>Cabin Baggage :</b> 7K <br/>
                                                        <b>Class : </b>L-Economy <br/>
                                                        <b>Duration :</b> 2h 40m <br/>
                                                        <b>Aircraft :</b> Airbus Industrie A319 <br/>
                                                        <b>Meal :</b> Meal</td>-->

                    </tr>
                @endforeach
            @endforeach

        </table>
    </div>
    <div class="row-fluid mt-1">
        <div class="col-md-12"
             style="background:#6c757d; color:#eeeeee;font-family:Ubuntu, Helvetica, Arial,
                 sans-serif;font-size:13px;line-height:22px;">
            Baggage Info
        </div>
    </div>
    <div class="row-fluid mt-1">
        <table cellpadding="0" cellspacing="0" width="100%" border="0"
               style="color:#000000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;table-layout:auto;width:100%;border:none;">
            <thead>
            <tr>
                <th style="border:1px solid #0f0f0f;padding: 0 15px;">Baggage</th>
                @foreach($baggage as $bag)
                    <th style="border:1px solid #0f0f0f;padding: 0 15px;">{{ $bag['pax'] }}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>

            <tr class="border-bottom">
                <td style="border:1px solid #0f0f0f; text-align:left; padding: 0 5px;"></td>
                @foreach($baggage as $bag)
                    <td style="border:1px solid #0f0f0f; text-align:left; padding: 0 5px;">{{ $bag['unit'] }} {{ $bag['type'] }}
                        / {{ $bag['pax'] }}</td>
                @endforeach

            </tr>

            <tr class="border-bottom">
                <td style="border:1px solid #0f0f0f; text-align:left; padding: 0 5px;">Check-In Baggage</td>
                @foreach($baggage as $bag)
                    <td style="border:1px solid #0f0f0f; text-align:left; padding: 0 5px;"> {{ ($bag['pax'] == 'INF')?'':'7 Kg' }}</td>
                @endforeach
            </tr>


            {{--
<!--                @foreach($booking->passengers as $passenger)
                                    <tr>
                    <td style="border:1px solid #0f0f0f; text-align:left; padding: 0 5px;">{{ $passenger->full_name }}</td>
                    <td style="border:1px solid #0f0f0f; text-align:center; padding: 0 5px;">{{ $passenger->pax_doc_type }} / {{ $passenger->pax_doc_no }}</td>
                        <td style="border:1px solid #0f0f0f; text-align:left; padding: 0 5px;">{{ $passenger->ssr_meal_code ? help_getMealCodes($passenger->ssr_meal_code):'None' }}</td>
                    <td style="border:1px solid #0f0f0f; text-align:center; padding: 0 5px;">On Request</td>
                </tr>
            @endforeach-->
                                        --}}
        </table>
    </div>
    <div class="row-fluid mt-1">
        <div class="col-md-12"
             style="background:#6c757d; color:#eeeeee;font-family:Ubuntu, Helvetica, Arial,
             sans-serif;font-size:13px;line-height:22px;">
            PAYMENT DETAILS
        </div>
    </div>
    <div class="row-fluid mt-1">
        <table cellpadding="0" cellspacing="0" width="50%" border="0"
               style="color:#000000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;table-layout:auto;width:50%;border:none;">
            <tr style="border:1px solid #ecedee;text-align:center;padding:15px 0;background:#e5e4e2">
                <th style="border:1px solid #0f0f0f;padding: 0 15px;">Payment Type</th>
                <th style="border:1px solid #0f0f0f; padding: 0 15px;">Amount</th>
            </tr>
            @php $price = json_decode($booking->air_price,true) @endphp
            <tr class="border-bottom">
                <td style="border:1px solid #0f0f0f; text-align:left; padding: 0 5px;">Base Fare</td>
                @if($booking->agent_markup > 0)
                    <td style="border:1px solid #0f0f0f; text-align:left; padding: 0 5px;">{{ $booking->currency }} {{ help_getAmountFromPrice($price['mbasefare']) + $booking->agent_markup }}</td>
                @else
                    <td style="border:1px solid #0f0f0f; text-align:left; padding: 0 5px;">{{ $price['mbasefare'] }}</td>
                @endif

            </tr>
            <tr class="border-bottom">
                <td style="border:1px solid #0f0f0f; text-align:left; padding: 0 5px;">Taxes, Surcharge and Fees</td>
                <td style="border:1px solid #0f0f0f; text-align:left; padding: 0 5px;">{{ $price['tax'] }}</td>
            </tr>

            @if(isset($booking->discount_coupon) && isset($booking->discount_amount))
                <tr class="border-bottom">
                    <td style="border:1px solid #0f0f0f; text-align:left; padding: 0 5px;">Discount</td>
                    <td style="border:1px solid #0f0f0f; text-align:left; padding: 0 5px;">{{ $booking->currency }} {{ $booking->discount_amount }}</td>
                </tr>
            @endif

            <tr class="bold">
                <td style="border:1px solid #0f0f0f; text-align:left; padding: 0 5px;">Total</td>
                @if($booking->agent_markup > 0)
                    <td style="border:1px solid #0f0f0f; text-align:left; padding: 0 5px;">{{ $booking->currency }} {{ $booking->discounted_fare + $booking->agent_markup }}</td>
                @else
                    <td style="border:1px solid #0f0f0f; text-align:left; padding: 0 5px;">{{ $booking->currency }} {{ $booking->discounted_fare }}</td>
                @endif

            </tr>

        </table>
    </div>
    <div class="row-fluid mt-3" style="background:#d2d2d2; page-break-before: always;">
        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style width="100%">
            <tr>
                <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                    <div
                        style="font-family:Lato, Helvetica, Arial, sans-serif;font-size:12px;font-weight:bold;font-style: italic; line-height:1;text-align:left;color: #36454f;">
                        *Flight inclusions are subject to change with Airlines.
                    </div>
                </td>
            </tr>
            <tr>
                <td align="left" style="font-size:0px;padding:0px 25px;word-break:break-word;">
                    <div
                        style="font-family:Lato, Helvetica, Arial, sans-serif;font-size:16px;font-weight:bold;line-height:1;text-align:left;color: #36454f;">
                        Flight Rules
                    </div>
                </td>
            </tr>
            <tr>
                <td align="left" style="font-size:0px;padding:0px;word-break:break-word;">
                    <div
                        style="font-family:Lato, Helvetica, Arial, sans-serif;font-size:10px;font-weight:bold;font-style: italic; line-height:1.5;text-align:left;color: #36454f;">
                        <ul>
                            <li>All Guests, including children and infants, must present valid identification at
                                check-in.
                            </li>
                            <li>Checkin begins 4 hours prior.</li>
                            <li>These days Mandatory <b>RTPCR</b> test report needed along covid forms. Pls. Contact
                                your travel agent for this
                            </li>
                            <li>Carriage and other services provided by the carrier are subject to conditions of
                                carriage, which are hereby incorporated by reference. These conditions may be obtained
                                from the issuing carrier.
                            </li>
                            <li>Please contact airlines for terminal queries.</li>
                            <li>Partial cancellations are not allowed for round-trip Fares.</li>
                            <li>Meal amount is non-refundable.</li>
                            <li>We are not be responsible for any Flight delay/Cancellation from airline's end.</li>
                            <li>Kindly contact the airline at least 24 hrs before to reconfirm your flight detail giving
                                reference of Airline PNR Number.
                            </li>
                            <li>We are a travel agent and all reservations made through our website are as per the terms
                                and conditions of the concerned airlines. All modifications,cancellations and refunds of
                                the airline tickets shall be strictly in accordance with the policy of the concerned
                                airlines after deducting our service charges and we disclaim all liability in connection
                                thereof.
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
</body>

</html>
