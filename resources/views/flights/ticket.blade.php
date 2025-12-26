@extends('layouts.front')
@section('title')
    Ticket
@endsection
@section('styles')
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,500,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet" type="text/css">
    <style type="text/css">
        @import url(https://fonts.googleapis.com/css?family=Lato:300,400,500,700);
        @import url(https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700);
    </style>
    <!--<![endif]-->
    <style type="text/css">
        @media only screen and (min-width: 480px) {
            .mj-column-per-33 {
                width: 33% !important;
                max-width: 33%;
            }

            .mj-column-per-66 {
                width: 66% !important;
                max-width: 66%;
            }

            .mj-column-per-100 {
                width: 100% !important;
                max-width: 100%;
            }
        }
    </style>
    <style type="text/css">
        @media only screen and (max-width: 480px) {
            table.mj-full-width-mobile {
                width: 100% !important;
            }

            td.mj-full-width-mobile {
                width: auto !important;
            }
        }

        @media print {
            body {
                margin: 0;
                color: #000;
                background-color: #fff;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
@endsection
@section('body')

    <div class="flex container justify-between max-w-4xl mx-auto my-4">
        <a class="border-2 rounded border-red-600 hover:bg-red-600 hover:text-white text-red-600 outlinea px-4 py-1 float-left"
            id="print" href="#">Print</a><br>
        <label class="checkbox-inline right">
            <input id="hide-payment" type="checkbox" value="">Hide Fare Details
        </label>
    </div>
    <div id="ticket">
        <div style="background:#f5f5f5;background-color:#f5f5f5;margin:0px auto;max-width:912px;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
                <tr>
                    <td style="float:left;padding:10px; width:50%">
                        <img alt="logo" height="auto" src="https://flightsgyani.com/frontend/images/logo.png"
                            style="border:0;display:block;height:auto;width:auto;">
                    </td>
                    <td style="padding:10px ;font-family:Lato, Helvetica, Arial, sans-serif; text-align:right;width:50%">
                        <div style="margin-bottom:5px; font-size:18px;font-weight:bold;line-height:1;color: #36454f;">
                            FLIGHTS GYANI PVT LTD
                        </div>
                        <div style="margin-bottom:5px; font-size:12px;font-weight:bold;line-height:1;color: #36454f;">
                            Email:
                            info@flightsgyani.com
                        </div>
                        <div style="margin-bottom:5px; font-size:12px;font-weight:bold;line-height:1;color: #36454f;">
                            Contact: 01-4266881
                        </div>
                        <div style="margin-bottom:5px; font-size:12px;font-weight:bold;line-height:1;color: #36454f;">
                            Emergency Contact: 9860146706/9857015300
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:912px;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
                style="background:#ffffff;background-color:#ffffff;width:100%;">
                <tbody>
                    <tr>
                        <td style="direction:ltr;padding:0px;padding-bottom:5px;padding-top:5px;text-align:center;">
                            <div class="mj-column-per-100 mj-outlook-group-fix"
                                style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                    <tbody>
                                        <tr>
                                            <td style="vertical-align:top;padding:0px;">
                                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                                    style width="100%">
                                                    <tr>
                                                        <td align="left"
                                                            style="font-size:0px;padding:15px;padding-bottom:0;word-break:break-word;">
                                                            <div
                                                                style="font-family:Lato, Helvetica, Arial, sans-serif;font-size:18px;line-height:1;text-align:center;color:#16161d;">
                                                                <strong>E-Ticket
                                                                    Receipt</strong>
                                                            </div>
                                                            <div
                                                                style="margin-top:5px; font-family:Lato, Helvetica, Arial, sans-serif;font-size:14px;line-height:1;text-align:left;color:#16161d;">
                                                                <b>Date of
                                                                    Issue:
                                                                </b>{{ $booking->created_at->toFormattedDateString() }}
                                                            </div>
                                                            <div
                                                                style="margin-top:5px; font-family:Lato, Helvetica, Arial, sans-serif;font-size:14px;line-height:1;text-align:left;color:#16161d;">
                                                                <strong>Booking
                                                                    Reference: </strong>{{ $booking->pnr_id }}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:912px;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
                style="background:#ffffff;background-color:#ffffff;width:100%;">
                <tbody>
                    <tr>
                        <td
                            style="direction:ltr;font-size:0px;padding:0px;padding-bottom:5px;padding-top:5px;text-align:center;">
                            <div class="mj-column-per-100 mj-outlook-group-fix"
                                style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                    <tbody>
                                        <tr>
                                            <td style="vertical-align:top;padding:0px;">
                                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                                    style width="100%">
                                                    <tr>
                                                        <td align="left"
                                                            style="font-size:0px;padding:15px;padding-bottom:0;word-break:break-word;">
                                                            <div
                                                                style="font-family:Lato, Helvetica, Arial, sans-serif;font-size:18px;line-height:1;text-align:left;color:#16161d;">
                                                                <strong>Passenger(s)
                                                                    Information</strong>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:912px;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
                style="background:#ffffff;background-color:#ffffff;width:100%;">
                <tbody>
                    <tr>
                        <td
                            style="direction:ltr;font-size:0px;padding:0px;padding-bottom:5px;padding-left:15px;padding-right:15px;padding-top:0;text-align:center;">
                            <div class="mj-column-per-100 mj-outlook-group-fix"
                                style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                    <tbody>
                                        <tr>
                                            <td style="vertical-align:top;padding:0px;">
                                                <table border="0" cellpadding="0" cellspacing="0"
                                                    role="presentation" style width="100%">
                                                    <tr>
                                                        <td align="left"
                                                            style="font-size:0px;padding:0px;word-break:break-word;">
                                                            <table cellpadding="0" cellspacing="0" width="100%"
                                                                border="0"
                                                                style="color:#000000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;table-layout:auto;width:100%;border:none;">
                                                                <tr
                                                                    style="border:1px solid #ecedee;text-align:center;padding:15px 0;background:#e5e4e2">
                                                                    <th style="border:1px solid #0f0f0f;padding: 0 15px;">
                                                                        Passenger
                                                                        Name
                                                                    </th>
                                                                    <th
                                                                        style="border:1px solid #0f0f0f;text-align:center; padding: 0 15px;">
                                                                        Ticket Number
                                                                    </th>
                                                                    <th
                                                                        style="border:1px solid #0f0f0f; padding: 0 0 0 15px;">
                                                                        Document Number
                                                                    </th>
                                                                </tr>
                                                                @forelse($booking->getTickets as $key=> $ticket)
                                                                    <tr>
                                                                        <td
                                                                            style="border:1px solid #0f0f0f;text-align:center; padding: 0 15px;">

                                                                            {{ $ticket->getPaxDetail($ticket->flight_booking_id, $ticket->first_name, $ticket->last_name)->pax_title }}
                                                                            {{ $ticket->full_name }}
                                                                        </td>
                                                                        <td
                                                                            style="border:1px solid #0f0f0f; text-align:center; padding: 0 15px;">
                                                                            {{ $ticket['ticket_number'] }}
                                                                        </td>
                                                                        <td
                                                                            style="border:1px solid #0f0f0f; text-align:center; padding: 0 15px;">
                                                                            {{ $ticket->getPaxDetail($ticket->flight_booking_id, $ticket->first_name, $ticket->last_name)->doc_number }}
                                                                            /
                                                                            {{ $ticket->getPaxDetail($ticket->flight_booking_id, $ticket->first_name, $ticket->last_name)->doc_type }}
                                                                            /
                                                                            {{ $ticket->getPaxDetail($ticket->flight_booking_id, $ticket->first_name, $ticket->last_name)->pax_type }}
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="3">No
                                                                            Tickets
                                                                            Issued
                                                                        </td>
                                                                    </tr>
                                                                @endforelse
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:912px;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
                style="background:#ffffff;background-color:#ffffff;width:100%;">
                <tbody>
                    <tr>
                        <td
                            style="direction:ltr;font-size:0px;padding:0px;padding-bottom:5px;padding-top:0;text-align:center;">
                            <div class="mj-column-per-100 mj-outlook-group-fix"
                                style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                    width="100%">
                                    <tbody>
                                        <tr>
                                            <td style="vertical-align:top;padding:0px;">
                                                <table border="0" cellpadding="0" cellspacing="0"
                                                    role="presentation" style width="100%">
                                                    <tr>
                                                        <td align="left"
                                                            style="font-size:0px;padding:15px;padding-bottom:0;word-break:break-word;">
                                                            <div
                                                                style="font-family:Lato, Helvetica, Arial, sans-serif;font-size:18px;line-height:1;text-align:left;color:#16161d;">
                                                                <strong>Flight
                                                                    Information</strong>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:912px;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
                style="background:#ffffff;background-color:#ffffff;width:100%;">
                <tbody>
                    <tr>
                        <td
                            style="direction:ltr;font-size:0px;padding:0px;padding-bottom:5px;padding-left:15px;padding-right:15px;padding-top:0;text-align:center;">
                            <div class="mj-column-per-100 mj-outlook-group-fix"
                                style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                    width="100%">
                                    <tbody>
                                        <tr>
                                            <td style="vertical-align:top;padding:0px;">
                                                <table border="0" cellpadding="0" cellspacing="0"
                                                    role="presentation" style width="100%">
                                                    <tr>
                                                        <td align="left"
                                                            style="font-size:0px;padding:0px;word-break:break-word;">
                                                            <table cellpadding="0" cellspacing="0" width="100%"
                                                                border="0"
                                                                style="color:#000000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;table-layout:auto;width:100%;border:none;">
                                                                <tr
                                                                    style="border:1px solid #ecedee;text-align:center;padding:15px 0;background:#e5e4e2">
                                                                    <th style="border:1px solid #0f0f0f;padding: 0 15px;">
                                                                        Operated
                                                                        By
                                                                    </th>
                                                                    <th style="border:1px solid #0f0f0f; padding: 0 15px;">
                                                                        Departs
                                                                        From
                                                                    </th>
                                                                    <th style="border:1px solid #0f0f0f; padding: 0 15px;">
                                                                        Arrives
                                                                        At
                                                                    </th>
                                                                    <th style="border:1px solid #0f0f0f; padding: 0 15px;">
                                                                        Details
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    @foreach (json_decode($booking->flights, true)['flight'] as $flight)
                                                                        @foreach ($flight['sectors'] as $key => $value)
                                                                <tr>
                                                                    <td
                                                                        style="border:1px solid #0f0f0f;font-weight:bold; text-align:center; padding: 0 5px;">
                                                                        <img class="img img-fluid"
                                                                            src="{{ asset('frontend/air-logos/' . $value['operatingairline'] . '.png') }}"
                                                                            alt="" style="width: 50px;">
                                                                        <br />
                                                                        {{ $value['operatingairline'] }}
                                                                        {{ $value['flightnumber'] }}
                                                                    </td>

                                                                    <td
                                                                        style="border:1px solid #0f0f0f; text-align:center; padding: 0 5px;">
                                                                        {{ $value['departport'] }}@isset($value['depterminal'])
                                                                        ({{ $value['depterminal'] }})
                                                                    @endisset {{ $value['departdate'] }}
                                                                    , {{ $value['departtime'] }}</td>
                                                                <td
                                                                    style="border:1px solid #0f0f0f; text-align:center; padding: 0 5px;">
                                                                    {{ $value['arrivalport'] }}
                                                                    @isset($value['arrivalterminal'])
                                                                        ({{ $value['arrivalterminal'] }}
                                                                        )
                                                                    @endisset {{ $value['arrivaldate'] }}
                                                                    {{ $value['arrivaltime'] }}</td>
                                                                <td
                                                                    style="border:1px solid #0f0f0f; text-align:left; padding: 0 5px;">
                                                                    <b>Cabin Baggage
                                                                        :</b>
                                                                    <br />
                                                                    @foreach ($baggage as $bag)
                                                                        {{ $bag['unit'] }} {{ $bag['type'] }}
                                                                        / Pax
                                                                        Type: {{ $bag['pax'] }}
                                                                        <br />
                                                                    @endforeach <br>
                                                                    <b>Check-in
                                                                        Baggage
                                                                        :</b>
                                                                    <br />
                                                                    @foreach ($baggage as $bag)
                                                                        {{ $bag['pax'] == 'INF' ? '0 Kg' : '7 Kg' }}
                                                                        / Pax
                                                                        Type: {{ $bag['pax'] }}
                                                                        <br />
                                                                    @endforeach <br>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                            @endforeach
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                            </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    </td>
    </tr>
    </tbody>
    </table>
</div>
<div style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:912px;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
        style="background:#ffffff;background-color:#ffffff;width:100%;">
        <tbody>
            <tr>
                <td
                    style="direction:ltr;font-size:0px;padding:0px;padding-bottom:5px;padding-top:0;text-align:center;">
                    <div class="mj-column-per-100 mj-outlook-group-fix"
                        style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                            <tbody>
                                <tr>
                                    <td style="vertical-align:top;padding:0px;">
                                        <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                            style width="100%">
                                            <tr>
                                                <td align="left"
                                                    style="font-size:0px;padding:15px;padding-bottom:0;word-break:break-word;">
                                                    <div
                                                        style="font-family:Lato, Helvetica, Arial, sans-serif;font-size:18px;line-height:1;text-align:left;color:#16161d;">
                                                        <strong>Other Details</strong>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="payment-details-ticket"
    style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:912px;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
        style="background:#ffffff;background-color:#ffffff;width:100%;">
        <tbody>
            <tr>
                <td
                    style="direction:ltr;font-size:0px;padding:0px;padding-bottom:5px;padding-left:15px;padding-right:15px;padding-top:0;text-align:center;">
                    <div class="mj-column-per-100 mj-outlook-group-fix"
                        style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                            <tbody>
                                <tr>
                                    <td style="vertical-align:top;padding:0px;">
                                        <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                            style width="100%">
                                            <tr>
                                                <td align="left"
                                                    style="font-size:0px;padding:0px;word-break:break-word;">
                                                    <table cellpadding="0" cellspacing="0" width="100%"
                                                        border="0"
                                                        style="color:#000000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;table-layout:auto;width:100%;border:none;">
                                                        <tr
                                                            style="border:1px solid #ecedee;text-align:center;padding:15px 0;background:#e5e4e2">
                                                            <th
                                                                style="border:1px solid #0f0f0f;padding: 0 15px; text-align:left">
                                                                Receipt
                                                            </th>
                                                            <th
                                                                style="border:1px solid #0f0f0f; padding: 0 15px; text-align:left">
                                                                Contact Details
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                style="border:1px solid #0f0f0f; text-align:left; padding: 0 5px;">
                                                                @php $price = json_decode($booking->air_price,true) @endphp
                                                                <table>
                                                                    <td
                                                                        style="width:50%;text-align:left; font-weight:bold">
                                                                        Ticket Fare:
                                                                    </td>
                                                                    <td style="padding-left:20px;text-align:right;">
                                                                        {{ $price['mbasefare'] }}
                                                                    </td>
                                                                </table>
                                                                <table>
                                                                    <td
                                                                        style="width:50%;text-align:left; font-weight:bold">
                                                                        Taxes:
                                                                    </td>
                                                                    <td style="padding-left:20px;text-align:right;">
                                                                        {{ $price['tax'] }}
                                                                    </td>
                                                                </table>
                                                                <table>
                                                                    <td
                                                                        style="width:50%;text-align:left; font-weight:bold">
                                                                        Total:
                                                                    </td>
                                                                    <td style="padding-left:20px;text-align:right;">
                                                                        {{ $price['markedfare'] }}
                                                                    </td>
                                                                </table>
                                                            </td>
                                                            <td
                                                                style="border:1px solid #0f0f0f; text-align:left; padding: 0 5px;">
                                                                <table>
                                                                    <tr
                                                                        style="text-align:left; font-weight:300; font-size:10px">
                                                                        <a>FLIGHTS GYANI
                                                                            PVT
                                                                            LTD</a><br>
                                                                        <a>JAMAL,
                                                                            KANTIPATH</a><br>
                                                                        <a>2ND FLOOR,
                                                                            BALTRA
                                                                            SHOWROOM</a><br>
                                                                        <a>KATHMANDU,
                                                                            NEPAL</a><br>
                                                                        <a>9860146706/9857015300
                                                                            (WhatsApp,
                                                                            Viber)</a><br>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:912px;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
        style="background:#ffffff;background-color:#ffffff;width:100%;">
        <tbody>
            <tr>
                <td
                    style="direction:ltr;font-size:0px;padding:0px;padding-bottom:5px;padding-top:0;text-align:center;">
                    <div class="mj-column-per-100 mj-outlook-group-fix"
                        style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                            <tbody>
                                <tr>
                                    <td style="vertical-align:top;padding:0px;">
                                        <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                            style width="100%">
                                            <tr>
                                                <td align="left"
                                                    style="font-size:0px;padding:15px;padding-bottom:0;word-break:break-word;">
                                                    <div
                                                        style="font-family:Lato, Helvetica, Arial, sans-serif;font-size:18px;line-height:1;text-align:left;color:#16161d;">
                                                        <strong>Flight Rules</strong>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:912px;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
        style="background:#ffffff;background-color:#ffffff;width:100%;">
        <tbody>
            <tr>
                <td
                    style="direction:ltr;font-size:0px;padding:0px;padding-bottom:35px;padding-left:15px;padding-right:15px;padding-top:0;text-align:center;">
                    <div class="mj-column-per-100 mj-outlook-group-fix"
                        style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                            <tbody>
                                <tr>
                                    <td style="vertical-align:top;padding:0px;">
                                        <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                            style width="100%">
                                            <tr>
                                                <td align="left"
                                                    style="font-size:0px;padding:0px;word-break:break-word;">
                                                    <table cellpadding="0" cellspacing="0" width="100%"
                                                        border="0"
                                                        style="color:#000000;font-family:Helvetica;font-size:8px;line-height:18px;table-layout:auto;width:100%;border:none;">
                                                        <tr
                                                            style="border:1px solid #ecedee;text-align:center;padding:15px 0;background:#e5e4e2">
                                                            <th
                                                                style="border:1px solid #0f0f0f;padding: 0 15px; text-align:left;font-weight:100">
                                                                <li>All Guests,
                                                                    including
                                                                    children and
                                                                    infants,
                                                                    must present
                                                                    valid identification
                                                                    at
                                                                    check-in.
                                                                </li>
                                                                <li>Check-in begins 3
                                                                    hours
                                                                    prior to the flight
                                                                    for
                                                                    seat
                                                                    assignment and
                                                                    closes 1 hour prior to the
                                                                    scheduled
                                                                    departure.
                                                                </li>
                                                                <li>Carriage and other
                                                                    services provided by
                                                                    the
                                                                    carrier are
                                                                    subject to
                                                                    conditions of
                                                                    carriage, which are
                                                                    hereby
                                                                    incorporated by
                                                                    reference. These
                                                                    conditions may be
                                                                    obtained from the
                                                                    issuing carrier.
                                                                </li>
                                                                <li>Please contact
                                                                    airlines
                                                                    for terminal
                                                                    queries.
                                                                </li>
                                                                <li>Partial
                                                                    cancellations
                                                                    are not allowed for
                                                                    round-trip
                                                                    Fares.
                                                                </li>
                                                                <li>Meal amount is
                                                                    non-refundable.
                                                                </li>
                                                                <li>We are not be
                                                                    responsible for any
                                                                    Flight
                                                                    delay/Cancellation
                                                                    from
                                                                    airline's end.
                                                                </li>
                                                                <li>Kindly contact the
                                                                    airline at least 24
                                                                    hrs
                                                                    before to
                                                                    reconfirm your
                                                                    flight
                                                                    detail giving
                                                                    reference
                                                                    of Airline
                                                                    Reference Number.
                                                                </li>
                                                                <li>We are a travel
                                                                    agent
                                                                    and all reservations
                                                                    made through
                                                                    our website are as
                                                                    per
                                                                    the terms and
                                                                    conditions
                                                                    of the
                                                                    concerned airlines.
                                                                </li>
                                                                <li>All
                                                                    modifications,cancellations
                                                                    and refunds of the
                                                                    airline tickets
                                                                    shall be
                                                                    strictly in
                                                                    accordance
                                                                    with the
                                                                    policy of the
                                                                    concerned
                                                                    airlines after
                                                                    deducting
                                                                    our
                                                                    service charges and
                                                                    we
                                                                    disclaim all
                                                                    liability
                                                                    in
                                                                    connection thereof.
                                                                </li>
                                                            </th>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
</div>

{{-- <section class="dashboard gray-bg padd-0 mrg-top-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="row mrg-0 mrg-top-20">
                        <div class="tr-single-box padd-bot-25 padd-l-15">
                            <div class="tr-single-header"></div>
                            <div class="tr-single-body">
                                <div class="detail-wrapper padd-top-30 padd-bot-30">
                                    <div class="row text-center clearfix">
                                        <div class="col-md-12 text-right">
                                            <a href="#" id="print"
                                               class="btn btn-outline-danger float-left">Print</a><br>
                                            <label class="checkbox-inline right">
                                                <input type="checkbox" value="" id="hide-payment">Hide Fare Details
                                            </label>
                                        </div>
                                    </div>
                                    <div id="ticket">
                                        <div
                                            style="background:#f5f5f5;background-color:#f5f5f5;margin:0px auto;max-width:912px;">
                                            <table align="center" border="0" cellpadding="0" cellspacing="0"
                                                   role="presentation" style="width:100%;">
                                                <tr>
                                                    <td style="float:left;padding:10px; width:50%">
                                                        <img alt="logo" height="auto"
                                                             src="https://flightsgyani.com/frontend/images/logo.png"
                                                             style="border:0;display:block;height:auto;width:auto;">
                                                    </td>
                                                    <td style="padding:10px ;font-family:Lato, Helvetica, Arial, sans-serif; text-align:right;width:50%">
                                                        <div
                                                            style="margin-bottom:5px; font-size:18px;font-weight:bold;line-height:1;color: #36454f;">
                                                            FLIGHTS GYANI PVT LTD
                                                        </div>
                                                        <div
                                                            style="margin-bottom:5px; font-size:12px;font-weight:bold;line-height:1;color: #36454f;">
                                                            Email:
                                                            info@flightsgyani.com
                                                        </div>
                                                        <div
                                                            style="margin-bottom:5px; font-size:12px;font-weight:bold;line-height:1;color: #36454f;">
                                                            Contact: 01-4266881
                                                        </div>
                                                        <div
                                                            style="margin-bottom:5px; font-size:12px;font-weight:bold;line-height:1;color: #36454f;">
                                                            Emergency Contact: 9860146706/9857015300
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>


                                        <div
                                            style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:912px;">
                                            <table align="center" border="0" cellpadding="0" cellspacing="0"
                                                   role="presentation"
                                                   style="background:#ffffff;background-color:#ffffff;width:100%;">
                                                <tbody>
                                                <tr>
                                                    <td style="direction:ltr;padding:0px;padding-bottom:5px;padding-top:5px;text-align:center;">
                                                        <div class="mj-column-per-100 mj-outlook-group-fix"
                                                             style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                                            <table border="0" cellpadding="0" cellspacing="0"
                                                                   role="presentation" width="100%">
                                                                <tbody>
                                                                <tr>
                                                                    <td style="vertical-align:top;padding:0px;">
                                                                        <table border="0" cellpadding="0"
                                                                               cellspacing="0"
                                                                               role="presentation" style
                                                                               width="100%">
                                                                            <tr>
                                                                                <td align="left"
                                                                                    style="font-size:0px;padding:15px;padding-bottom:0;word-break:break-word;">
                                                                                    <div
                                                                                        style="font-family:Lato, Helvetica, Arial, sans-serif;font-size:18px;line-height:1;text-align:center;color:#16161d;">
                                                                                        <strong>E-Ticket
                                                                                            Receipt</strong>
                                                                                    </div>
                                                                                    <div
                                                                                        style="margin-top:5px; font-family:Lato, Helvetica, Arial, sans-serif;font-size:14px;line-height:1;text-align:left;color:#16161d;">
                                                                                        <b>Date of
                                                                                            Issue: </b>{{ $booking->created_at->toFormattedDateString() }}
                                                                                    </div>
                                                                                    <div
                                                                                        style="margin-top:5px; font-family:Lato, Helvetica, Arial, sans-serif;font-size:14px;line-height:1;text-align:left;color:#16161d;">
                                                                                        <strong>Booking
                                                                                            Reference: </strong>{{ $booking->pnr_id }}
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>


                                        <div
                                            style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:912px;">
                                            <table align="center" border="0" cellpadding="0" cellspacing="0"
                                                   role="presentation"
                                                   style="background:#ffffff;background-color:#ffffff;width:100%;">
                                                <tbody>
                                                <tr>
                                                    <td style="direction:ltr;font-size:0px;padding:0px;padding-bottom:5px;padding-top:5px;text-align:center;">
                                                        <div class="mj-column-per-100 mj-outlook-group-fix"
                                                             style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                                            <table border="0" cellpadding="0" cellspacing="0"
                                                                   role="presentation" width="100%">
                                                                <tbody>
                                                                <tr>
                                                                    <td style="vertical-align:top;padding:0px;">
                                                                        <table border="0" cellpadding="0"
                                                                               cellspacing="0"
                                                                               role="presentation" style
                                                                               width="100%">
                                                                            <tr>
                                                                                <td align="left"
                                                                                    style="font-size:0px;padding:15px;padding-bottom:0;word-break:break-word;">
                                                                                    <div
                                                                                        style="font-family:Lato, Helvetica, Arial, sans-serif;font-size:18px;line-height:1;text-align:left;color:#16161d;">
                                                                                        <strong>Passenger(s)
                                                                                            Information</strong></div>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div
                                            style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:912px;">
                                            <table align="center" border="0" cellpadding="0" cellspacing="0"
                                                   role="presentation"
                                                   style="background:#ffffff;background-color:#ffffff;width:100%;">
                                                <tbody>
                                                <tr>
                                                    <td style="direction:ltr;font-size:0px;padding:0px;padding-bottom:5px;padding-left:15px;padding-right:15px;padding-top:0;text-align:center;">
                                                        <div class="mj-column-per-100 mj-outlook-group-fix"
                                                             style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                                            <table border="0" cellpadding="0" cellspacing="0"
                                                                   role="presentation" width="100%">
                                                                <tbody>
                                                                <tr>
                                                                    <td style="vertical-align:top;padding:0px;">
                                                                        <table border="0" cellpadding="0"
                                                                               cellspacing="0"
                                                                               role="presentation" style
                                                                               width="100%">
                                                                            <tr>
                                                                                <td align="left"
                                                                                    style="font-size:0px;padding:0px;word-break:break-word;">
                                                                                    <table cellpadding="0"
                                                                                           cellspacing="0"
                                                                                           width="100%" border="0"
                                                                                           style="color:#000000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;table-layout:auto;width:100%;border:none;">
                                                                                        <tr style="border:1px solid #ecedee;text-align:center;padding:15px 0;background:#e5e4e2">
                                                                                            <th style="border:1px solid #0f0f0f;padding: 0 15px;">
                                                                                                Passenger
                                                                                                Name
                                                                                            </th>
                                                                                            <th style="border:1px solid #0f0f0f;text-align:center; padding: 0 15px;">
                                                                                                Ticket Number
                                                                                            </th>
                                                                                            <th style="border:1px solid #0f0f0f; padding: 0 0 0 15px;">
                                                                                                Document Number
                                                                                            </th>
                                                                                        </tr>
                                                                                        @forelse($booking->getTickets as $key=> $ticket)
                                                                                            <tr>
                                                                                                <td style="border:1px solid #0f0f0f;text-align:center; padding: 0 15px;">

                                                                                                    {{$ticket->getPaxDetail($ticket->flight_booking_id,$ticket->first_name,$ticket->last_name)->pax_title}}
                                                                                                    {{ $ticket->full_name }}
                                                                                                </td>
                                                                                                <td style="border:1px solid #0f0f0f; text-align:center; padding: 0 15px;">
                                                                                                    {{ $ticket['ticket_number'] }}
                                                                                                </td>
                                                                                                <td style="border:1px solid #0f0f0f; text-align:center; padding: 0 15px;">
                                                                                                    {{$ticket->getPaxDetail($ticket->flight_booking_id,$ticket->first_name,$ticket->last_name)->doc_number}}
                                                                                                    /
                                                                                                    {{$ticket->getPaxDetail($ticket->flight_booking_id,$ticket->first_name,$ticket->last_name)->doc_type}}
                                                                                                    /
                                                                                                    {{$ticket->getPaxDetail($ticket->flight_booking_id,$ticket->first_name,$ticket->last_name)->pax_type}}
                                                                                                </td>
                                                                                            </tr>
                                                                                        @empty
                                                                                            <tr>
                                                                                                <td colspan="3">No
                                                                                                    Tickets
                                                                                                    Issued
                                                                                                </td>
                                                                                            </tr>
                                                                                        @endforelse
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div
                                            style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:912px;">
                                            <table align="center" border="0" cellpadding="0" cellspacing="0"
                                                   role="presentation"
                                                   style="background:#ffffff;background-color:#ffffff;width:100%;">
                                                <tbody>
                                                <tr>
                                                    <td style="direction:ltr;font-size:0px;padding:0px;padding-bottom:5px;padding-top:0;text-align:center;">
                                                        <div class="mj-column-per-100 mj-outlook-group-fix"
                                                             style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                                            <table border="0" cellpadding="0" cellspacing="0"
                                                                   role="presentation" width="100%">
                                                                <tbody>
                                                                <tr>
                                                                    <td style="vertical-align:top;padding:0px;">
                                                                        <table border="0" cellpadding="0"
                                                                               cellspacing="0"
                                                                               role="presentation" style
                                                                               width="100%">
                                                                            <tr>
                                                                                <td align="left"
                                                                                    style="font-size:0px;padding:15px;padding-bottom:0;word-break:break-word;">
                                                                                    <div
                                                                                        style="font-family:Lato, Helvetica, Arial, sans-serif;font-size:18px;line-height:1;text-align:left;color:#16161d;">
                                                                                        <strong>Flight
                                                                                            Information</strong>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div
                                            style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:912px;">
                                            <table align="center" border="0" cellpadding="0" cellspacing="0"
                                                   role="presentation"
                                                   style="background:#ffffff;background-color:#ffffff;width:100%;">
                                                <tbody>
                                                <tr>
                                                    <td style="direction:ltr;font-size:0px;padding:0px;padding-bottom:5px;padding-left:15px;padding-right:15px;padding-top:0;text-align:center;">
                                                        <div class="mj-column-per-100 mj-outlook-group-fix"
                                                             style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                                            <table border="0" cellpadding="0" cellspacing="0"
                                                                   role="presentation" width="100%">
                                                                <tbody>
                                                                <tr>
                                                                    <td style="vertical-align:top;padding:0px;">
                                                                        <table border="0" cellpadding="0"
                                                                               cellspacing="0"
                                                                               role="presentation" style
                                                                               width="100%">
                                                                            <tr>
                                                                                <td align="left"
                                                                                    style="font-size:0px;padding:0px;word-break:break-word;">
                                                                                    <table cellpadding="0"
                                                                                           cellspacing="0"
                                                                                           width="100%" border="0"
                                                                                           style="color:#000000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;table-layout:auto;width:100%;border:none;">
                                                                                        <tr style="border:1px solid #ecedee;text-align:center;padding:15px 0;background:#e5e4e2">
                                                                                            <th style="border:1px solid #0f0f0f;padding: 0 15px;">
                                                                                                Operated
                                                                                                By
                                                                                            </th>
                                                                                            <th style="border:1px solid #0f0f0f; padding: 0 15px;">
                                                                                                Departs
                                                                                                From
                                                                                            </th>
                                                                                            <th style="border:1px solid #0f0f0f; padding: 0 15px;">
                                                                                                Arrives
                                                                                                At
                                                                                            </th>
                                                                                            <th style="border:1px solid #0f0f0f; padding: 0 15px;">
                                                                                                Details
                                                                                            </th>
                                                                                        </tr>
                                                                                        <tr>
                                                                                        @foreach (json_decode($booking->flights, true)['flight'] as $flight)
                                                                                            @foreach ($flight['sectors'] as $key => $value)

                                                                                                <tr>
                                                                                                    <td style="border:1px solid #0f0f0f;font-weight:bold; text-align:center; padding: 0 5px;">
                                                                                                        <img
                                                                                                            src="{{ asset('frontend/air-logos/'.$value['operatingairline'].'.png') }}"
                                                                                                            alt=""
                                                                                                            style="width: 50px;"
                                                                                                            class="img img-fluid">
                                                                                                        <br/>
                                                                                                        {{ $value['operatingairline'] }} {{ $value['flightnumber'] }}
                                                                                                    </td>

                                                                                                    <td style="border:1px solid #0f0f0f; text-align:center; padding: 0 5px;">
                                                                                                        {{ $value['departport'] }}@isset($value['depterminal'])
                                                                                                            ({{ $value['depterminal'] }}
                                                                                                            )
                                                                                                        @endisset {{ $value['departdate'] }}
                                                                                                        , {{ $value['departtime'] }}</td>
                                                                                                    <td style="border:1px solid #0f0f0f; text-align:center; padding: 0 5px;">
                                                                                                        {{ $value['arrivalport'] }} @isset($value['arrivalterminal'])
                                                                                                            ({{ $value['arrivalterminal'] }}
                                                                                                            )
                                                                                                        @endisset {{ $value['arrivaldate'] }} {{ $value['arrivaltime'] }}</td>
                                                                                                    <td style="border:1px solid #0f0f0f; text-align:left; padding: 0 5px;">
                                                                                                        <b>Cabin Baggage
                                                                                                            :</b>
                                                                                                        <br/>@foreach ($baggage as $bag)
                                                                                                            {{ $bag['unit'] }} {{ $bag['type'] }}
                                                                                                            / Pax
                                                                                                            Type: {{ $bag['pax'] }}
                                                                                                            <br/>
                                                                                                        @endforeach <br>
                                                                                                        <b>Check-in
                                                                                                            Baggage
                                                                                                            :</b>
                                                                                                        <br/>@foreach ($baggage as $bag)
                                                                                                            {{ ($bag['pax'] == 'INF')?'0 Kg':'7 Kg' }}
                                                                                                            / Pax
                                                                                                            Type: {{ $bag['pax'] }}
                                                                                                            <br/>
                                                                                                        @endforeach <br>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                @endforeach
                                                                                                @endforeach
                                                                                                </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div
                                            style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:912px;">
                                            <table align="center" border="0" cellpadding="0" cellspacing="0"
                                                   role="presentation"
                                                   style="background:#ffffff;background-color:#ffffff;width:100%;">
                                                <tbody>
                                                <tr>
                                                    <td style="direction:ltr;font-size:0px;padding:0px;padding-bottom:5px;padding-top:0;text-align:center;">
                                                        <div class="mj-column-per-100 mj-outlook-group-fix"
                                                             style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                                            <table border="0" cellpadding="0" cellspacing="0"
                                                                   role="presentation" width="100%">
                                                                <tbody>
                                                                <tr>
                                                                    <td style="vertical-align:top;padding:0px;">
                                                                        <table border="0" cellpadding="0"
                                                                               cellspacing="0"
                                                                               role="presentation" style
                                                                               width="100%">
                                                                            <tr>
                                                                                <td align="left"
                                                                                    style="font-size:0px;padding:15px;padding-bottom:0;word-break:break-word;">
                                                                                    <div
                                                                                        style="font-family:Lato, Helvetica, Arial, sans-serif;font-size:18px;line-height:1;text-align:left;color:#16161d;">
                                                                                        <strong>Other Details</strong>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="payment-details-ticket"
                                             style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:912px;">
                                            <table align="center" border="0" cellpadding="0" cellspacing="0"
                                                   role="presentation"
                                                   style="background:#ffffff;background-color:#ffffff;width:100%;">
                                                <tbody>
                                                <tr>
                                                    <td style="direction:ltr;font-size:0px;padding:0px;padding-bottom:5px;padding-left:15px;padding-right:15px;padding-top:0;text-align:center;">
                                                        <div class="mj-column-per-100 mj-outlook-group-fix"
                                                             style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                                            <table border="0" cellpadding="0" cellspacing="0"
                                                                   role="presentation" width="100%">
                                                                <tbody>
                                                                <tr>
                                                                    <td style="vertical-align:top;padding:0px;">
                                                                        <table border="0" cellpadding="0"
                                                                               cellspacing="0"
                                                                               role="presentation" style
                                                                               width="100%">
                                                                            <tr>
                                                                                <td align="left"
                                                                                    style="font-size:0px;padding:0px;word-break:break-word;">
                                                                                    <table cellpadding="0"
                                                                                           cellspacing="0"
                                                                                           width="100%" border="0"
                                                                                           style="color:#000000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;table-layout:auto;width:100%;border:none;">
                                                                                        <tr style="border:1px solid #ecedee;text-align:center;padding:15px 0;background:#e5e4e2">
                                                                                            <th style="border:1px solid #0f0f0f;padding: 0 15px; text-align:left">
                                                                                                Receipt
                                                                                            </th>
                                                                                            <th style="border:1px solid #0f0f0f; padding: 0 15px; text-align:left">
                                                                                                Contact Details
                                                                                            </th>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td style="border:1px solid #0f0f0f; text-align:left; padding: 0 5px;">
                                                                                                @php $price = json_decode($booking->air_price,true) @endphp
                                                                                                <table>
                                                                                                    <td style="width:50%;text-align:left; font-weight:bold">
                                                                                                        Ticket Fare:
                                                                                                    </td>
                                                                                                    <td style="padding-left:20px;text-align:right;">{{ $price['mbasefare'] }}
                                                                                                    </td>
                                                                                                </table>
                                                                                                <table>
                                                                                                    <td style="width:50%;text-align:left; font-weight:bold">
                                                                                                        Taxes:
                                                                                                    </td>
                                                                                                    <td style="padding-left:20px;text-align:right;">{{ $price['tax'] }}
                                                                                                    </td>
                                                                                                </table>
                                                                                                <table>
                                                                                                    <td style="width:50%;text-align:left; font-weight:bold">
                                                                                                        Total:
                                                                                                    </td>
                                                                                                    <td style="padding-left:20px;text-align:right;">{{ $price['markedfare'] }}
                                                                                                    </td>
                                                                                                </table>
                                                                                            </td>
                                                                                            <td style="border:1px solid #0f0f0f; text-align:left; padding: 0 5px;">
                                                                                                <table>
                                                                                                    <tr style="text-align:left; font-weight:300; font-size:10px">
                                                                                                        <a>FLIGHTS GYANI
                                                                                                            PVT
                                                                                                            LTD</a><br>
                                                                                                        <a>JAMAL,
                                                                                                            KANTIPATH</a><br>
                                                                                                        <a>2ND FLOOR,
                                                                                                            BALTRA
                                                                                                            SHOWROOM</a><br>
                                                                                                        <a>KATHMANDU,
                                                                                                            NEPAL</a><br>
                                                                                                        <a>9860146706/9857015300
                                                                                                            (WhatsApp,
                                                                                                            Viber)</a><br>
                                                                                                    </tr>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div
                                            style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:912px;">
                                            <table align="center" border="0" cellpadding="0" cellspacing="0"
                                                   role="presentation"
                                                   style="background:#ffffff;background-color:#ffffff;width:100%;">
                                                <tbody>
                                                <tr>
                                                    <td style="direction:ltr;font-size:0px;padding:0px;padding-bottom:5px;padding-top:0;text-align:center;">
                                                        <div class="mj-column-per-100 mj-outlook-group-fix"
                                                             style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                                            <table border="0" cellpadding="0" cellspacing="0"
                                                                   role="presentation" width="100%">
                                                                <tbody>
                                                                <tr>
                                                                    <td style="vertical-align:top;padding:0px;">
                                                                        <table border="0" cellpadding="0"
                                                                               cellspacing="0"
                                                                               role="presentation" style
                                                                               width="100%">
                                                                            <tr>
                                                                                <td align="left"
                                                                                    style="font-size:0px;padding:15px;padding-bottom:0;word-break:break-word;">
                                                                                    <div
                                                                                        style="font-family:Lato, Helvetica, Arial, sans-serif;font-size:18px;line-height:1;text-align:left;color:#16161d;">
                                                                                        <strong>Flight Rules</strong>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div
                                            style="background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:912px;">
                                            <table align="center" border="0" cellpadding="0" cellspacing="0"
                                                   role="presentation"
                                                   style="background:#ffffff;background-color:#ffffff;width:100%;">
                                                <tbody>
                                                <tr>
                                                    <td style="direction:ltr;font-size:0px;padding:0px;padding-bottom:35px;padding-left:15px;padding-right:15px;padding-top:0;text-align:center;">
                                                        <div class="mj-column-per-100 mj-outlook-group-fix"
                                                             style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                                            <table border="0" cellpadding="0" cellspacing="0"
                                                                   role="presentation" width="100%">
                                                                <tbody>
                                                                <tr>
                                                                    <td style="vertical-align:top;padding:0px;">
                                                                        <table border="0" cellpadding="0"
                                                                               cellspacing="0"
                                                                               role="presentation" style
                                                                               width="100%">
                                                                            <tr>
                                                                                <td align="left"
                                                                                    style="font-size:0px;padding:0px;word-break:break-word;">
                                                                                    <table cellpadding="0"
                                                                                           cellspacing="0"
                                                                                           width="100%" border="0"
                                                                                           style="color:#000000;font-family:Helvetica;font-size:8px;line-height:18px;table-layout:auto;width:100%;border:none;">
                                                                                        <tr style="border:1px solid #ecedee;text-align:center;padding:15px 0;background:#e5e4e2">
                                                                                            <th style="border:1px solid #0f0f0f;padding: 0 15px; text-align:left;font-weight:100">
                                                                                                <li>All Guests,
                                                                                                    including
                                                                                                    children and
                                                                                                    infants,
                                                                                                    must present
                                                                                                    valid identification
                                                                                                    at
                                                                                                    check-in.
                                                                                                </li>
                                                                                                <li>Check-in begins 2
                                                                                                    hours
                                                                                                    prior to the flight
                                                                                                    for
                                                                                                    seat
                                                                                                    assignment and
                                                                                                    closes 45
                                                                                                    minutes prior to the
                                                                                                    scheduled
                                                                                                    departure.
                                                                                                </li>
                                                                                                <li>Carriage and other
                                                                                                    services provided by
                                                                                                    the
                                                                                                    carrier are
                                                                                                    subject to
                                                                                                    conditions of
                                                                                                    carriage, which are
                                                                                                    hereby
                                                                                                    incorporated by
                                                                                                    reference. These
                                                                                                    conditions may be
                                                                                                    obtained from the
                                                                                                    issuing carrier.
                                                                                                </li>
                                                                                                <li>Please contact
                                                                                                    airlines
                                                                                                    for terminal
                                                                                                    queries.
                                                                                                </li>
                                                                                                <li>Partial
                                                                                                    cancellations
                                                                                                    are not allowed for
                                                                                                    round-trip
                                                                                                    Fares.
                                                                                                </li>
                                                                                                <li>Meal amount is
                                                                                                    non-refundable.
                                                                                                </li>
                                                                                                <li>We are not be
                                                                                                    responsible for any
                                                                                                    Flight
                                                                                                    delay/Cancellation
                                                                                                    from
                                                                                                    airline's end.
                                                                                                </li>
                                                                                                <li>Kindly contact the
                                                                                                    airline at least 24
                                                                                                    hrs
                                                                                                    before to
                                                                                                    reconfirm your
                                                                                                    flight
                                                                                                    detail giving
                                                                                                    reference
                                                                                                    of Airline
                                                                                                    Reference Number.
                                                                                                </li>
                                                                                                <li>We are a travel
                                                                                                    agent
                                                                                                    and all reservations
                                                                                                    made through
                                                                                                    our website are as
                                                                                                    per
                                                                                                    the terms and
                                                                                                    conditions
                                                                                                    of the
                                                                                                    concerned airlines.
                                                                                                </li>
                                                                                                <li>All
                                                                                                    modifications,cancellations
                                                                                                    and refunds of the
                                                                                                    airline tickets
                                                                                                    shall be
                                                                                                    strictly in
                                                                                                    accordance
                                                                                                    with the
                                                                                                    policy of the
                                                                                                    concerned
                                                                                                    airlines after
                                                                                                    deducting
                                                                                                    our
                                                                                                    service charges and
                                                                                                    we
                                                                                                    disclaim all
                                                                                                    liability
                                                                                                    in
                                                                                                    connection thereof.
                                                                                                </li>
                                                                                            </th>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
@if ($ticket_itineraries)
    <div class="center">
    @empty(!$ticket_itineraries['flights'])
        Flights Info <br />
        @foreach ($ticket_itineraries['flights'] as $ticket_itinerary_flight)
            {{ $ticket_itinerary_flight['departure'] }}<br />
            {{--                    {{$ticket_itinerary_flight['depter']}}<br/> --}}
            {{ $ticket_itinerary_flight['deptime'] }}<br />
            {{ $ticket_itinerary_flight['arrival'] }}<br />
            {{--                    {{$ticket_itinerary_flight['arrter']}}<br/> --}}
            {{ $ticket_itinerary_flight['arrdate'] }}<br />
            {{ $ticket_itinerary_flight['arrtime'] }}<br />
            {{ $ticket_itinerary_flight['marairline'] }}<br />
            {{ $ticket_itinerary_flight['marflightno'] }}<br />
            {{ $ticket_itinerary_flight['opairline'] }}<br />
            {{ $ticket_itinerary_flight['opflightno'] }}<br />
            {{ $ticket_itinerary_flight['class'] }}<br />
            {{--                    {{$ticket_itinerary_flight['meal']}} --}}
        @endforeach
    @endempty
@empty(!$ticket_itineraries['tickets'])
    <br />
    Ticket Details Info<br />
    @foreach ($ticket_itineraries['tickets'] as $ticket_itinerary_ticket)
        {{ $ticket_itinerary_ticket['type'] }}<br />
        {{ $ticket_itinerary_ticket['lastname'] }}<br />
        {{ $ticket_itinerary_ticket['firstname'] }}<br />
        @foreach ($ticket_itinerary_ticket['ticket'] as $ticket)
            {{ $ticket['rph'] }}<br />
            {{ $ticket['original'] }}<br />
            {{ $ticket['ticket'] }}
        @endforeach
    @endforeach
@endempty
@empty(!$ticket_itineraries['baggages'])
<br />
Baggage INfo<br />
@foreach ($ticket_itineraries['baggages'] as $ticket_itinerary_baggage)
    {{ $ticket_itinerary_baggage['passengerType'] }} ->
    {{ $ticket_itinerary_baggage['allowance'] }} ->
    {{ $ticket_itinerary_baggage['type'] }}
@endforeach
@endempty
</div>
@endif
@endsection
@section('scripts')
<script src="{{ asset('/frontend/js/print.js') }}"></script>
<script>
    $('#print').on('click', function() {
        $('#ticket').print({
            globalStyles: true,
            mediaPrint: true,
            {{-- stylesheet: '{{ asset('frontend/css/bootstrap.min.css') }}', --}}
            noPrintSelector: ".no-print",
            iframe: true,
            append: null,
            prepend: null,
            manuallyCopyFormValues: true,
            deferred: $.Deferred(),
            timeout: 750,
            title: null,
        });
    })
</script>
@endsection
