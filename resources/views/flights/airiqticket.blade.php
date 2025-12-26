<div id="ticket">
    <div style="background:#f5f5f5;background-color:#f5f5f5;margin:0px auto;max-width:912px;">
        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
            <tr>
                <td style="float:left;padding:10px; width:50%">
                    @php
                        $logoBase64 = '';
                        if (!empty($ticketDetails?->company_logo) && file_exists(public_path('uploads/ticket/' . $ticketDetails->company_logo))) {
                            $path = public_path('uploads/ticket/' . $ticketDetails->company_logo);
                            $type = pathinfo($path, PATHINFO_EXTENSION);
                            $data = file_get_contents($path);
                            $logoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                        } else {
                            // fallback logo from local public folder, not remote URL
                            $path = public_path('frontend/images/logo.png');
                            $type = pathinfo($path, PATHINFO_EXTENSION);
                            $data = file_get_contents($path);
                            $logoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                        }
                    @endphp
                    <img alt="logo" height="auto" src="{{ $logoBase64 }}"
                        style="border:0;display:block;height:60px;width:auto;">

                    <!-- <img alt="logo" height="auto"
                        src="{{ $ticketDetails ? public_path('uploads/ticket/' . $ticketDetails->company_logo) : 'https://flightsgyani.com/frontend/images/logo.png' }}"
                        style="border:0;display:block;height:60px;width:auto;"> -->
                </td>
                <td style="padding:10px ;font-family:Lato, Helvetica, Arial, sans-serif; text-align:right;width:50%">
                    <div style="margin-bottom:5px; font-size:18px;font-weight:bold;line-height:1;color: #36454f;">
                        {{ $ticketDetails->company_name ?? 'FLIGHTS GYANI PVT LTD' }}
                    </div>
                    <div style="margin-bottom:5px; font-size:12px;font-weight:bold;line-height:1;color: #36454f;">
                        Email:
                        {{ $ticketDetails->company_email ?? 'info@flightsgyani.com' }}
                    </div>
                    <div style="margin-bottom:5px; font-size:12px;font-weight:bold;line-height:1;color: #36454f;">
                        Contact: {{ $ticketDetails->company_contact ?? '01-4547791' }}

                    </div>
                    <div style="margin-bottom:5px; font-size:12px;font-weight:bold;line-height:1;color: #36454f;">
                        Emergency Contact: {{ $ticketDetails->emergency_contact ?? '9802368063/9860146706' }}
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
                                            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style
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
                                                                Issue:
                                                            </b>{{ $booking->created_at->toFormattedDateString() }}
                                                        </div>
                                                        <div
                                                            style="margin-top:5px; font-family:Lato, Helvetica, Arial, sans-serif;font-size:14px;line-height:1;text-align:left;color:#16161d;">
                                                            <strong>Booking
                                                                Reference:
                                                            </strong>
                                                            @if ($tickets)
                                                                @foreach ($tickets as $k => $tkt)
                                                                    {{ $k > 0 ? '/' : '' }}
                                                                    {{ $tkt->AirIqPNR }}
                                                                @endforeach
                                                            @endif

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

    @if($tickets)
        @foreach($tickets as $key => $ticket)

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
                                                    <table border="0" cellpadding="0" cellspacing="0" role="presentation" style
                                                        width="100%">
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
                                                <td style="vertical-align:top;padding:0px;">
                                                    <table border="0" cellpadding="0" cellspacing="0" role="presentation" style
                                                        width="100%">
                                                        <tr>
                                                            <td align="right"
                                                                style="font-size:0px;padding:15px;padding-bottom:0;word-break:break-word;">
                                                                <div
                                                                    style="font-family:Lato, Helvetica, Arial, sans-serif;font-size:15px;line-height:1;text-align:right;color:#16161d;">
                                                                    <strong>Airline PNR:</strong>
                                                                    {{ $ticket->Passengers[0]->Details[0]->AirlinePNR ?? 'N/A' }}
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
                                                    <table border="0" cellpadding="0" cellspacing="0" role="presentation" style
                                                        width="100%">
                                                        <tr>
                                                            <td align="left"
                                                                style="font-size:0px;padding:0px;word-break:break-word;">
                                                                <table cellpadding="0" cellspacing="0" width="100%" border="0"
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
                                                                    @foreach($ticket->Passengers as $ticketDetail)
                                                                        <tr>
                                                                            <td
                                                                                style="border:1px solid #0f0f0f;text-align:center; padding: 0 15px;">
                                                                                {{ $ticketDetail->Title }}
                                                                                {{ $ticketDetail->FirstName }}
                                                                                {{ $ticketDetail->LastName }}
                                                                            </td>
                                                                            <td
                                                                                style="border:1px solid #0f0f0f; text-align:center; padding: 0 15px;">
                                                                                {{ $ticketDetail->TicketNumber }}
                                                                            </td>
                                                                            <td
                                                                                style="border:1px solid #0f0f0f; text-align:center; padding: 0 15px;">
                                                                                {{ $booking->getPaxDetail($booking->id, $ticketDetail->FirstName, $ticketDetail->LastName)->doc_number }}
                                                                                /
                                                                                {{ $booking->getPaxDetail($booking->id, $ticketDetail->FirstName, $ticketDetail->LastName)->doc_type }}
                                                                                /
                                                                                {{ $booking->getPaxDetail($booking->id, $ticketDetail->FirstName, $ticketDetail->LastName)->pax_type }}
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach

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
        @endforeach
    @endif

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
                                            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style
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
                                            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style
                                                width="100%">
                                                <tr>
                                                    <td align="left"
                                                        style="font-size:0px;padding:0px;word-break:break-word;">
                                                        <table cellpadding="0" cellspacing="0" width="100%" border="0"
                                                            style="color:#000000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:15px;table-layout:auto;width:100%;border:none;">
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
                                                                                    src="{{ public_path('frontend/air-logos/' . $value['operatingairline'] . '.png') }}"
                                                                                    alt="" style="width: 50px;">
                                                                                <br />
                                                                                {{ $value['operatingairline'] }}
                                                                                {{ $value['flightnumber'] }}
                                                                            </td>

                                                                            <td
                                                                                style="border:1px solid #0f0f0f; text-align:center; padding: 0 5px;">
                                                                                {{ $value['departport'] }}@isset($value['depterminal'])
                                                                                    ({{ $value['depterminal'] }})
                                                                                @endisset <br>{{ $value['departdate'] }}
                                                                                , {{ $value['departtime'] }}
                                                                            </td>
                                                                            <td
                                                                                style="border:1px solid #0f0f0f; text-align:center; padding: 0 5px;">
                                                                                {{ $value['arrivalport'] }}
                                                                                @isset($value['arrivalterminal'])
                                                                                    ({{ $value['arrivalterminal'] }})
                                                                                @endisset <br>{{ $value['arrivaldate'] }}
                                                                                {{ $value['arrivaltime'] }}
                                                                            </td>
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
                <td style="direction:ltr;font-size:0px;padding:0px;padding-bottom:5px;padding-top:0;text-align:center;">
                    <div class="mj-column-per-100 mj-outlook-group-fix"
                        style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                            <tbody>
                                <tr>
                                    <td style="vertical-align:top;padding:0px;">
                                        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style
                                            width="100%">
                                            <tr>
                                                <td align="left"
                                                    style="font-size:0px;padding:15px;padding-bottom:0;word-break:break-word;">
                                                    <div
                                                        style="font-family:Lato, Helvetica, Arial, sans-serif;font-size:18px;line-height:1;text-align:left;color:#16161d;">
                                                        <strong>Contact Details</strong>
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
<div class="payment-details-ticket" style="background:#ffffff;margin:0px auto;max-width:912px;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
        style="background:#ffffff;width:100%;">
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
                                        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style=""
                                            width="100%">
                                            <tbody>
                                                <tr>
                                                    <td align="left"
                                                        style="font-size:0px;padding:0px;word-break:break-word;">
                                                        <table cellpadding="0" cellspacing="0" width="100%" border="0"
                                                            style="color:#000000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:10px;line-height:2px;table-layout:auto;width:100%;border:none;">
                                                            <tbody>
                                                                <tr>
                                                                    <td
                                                                        style="border:1px solid #0f0f0f; text-align:left; padding-left:10px; font-family:Ubuntu, Helvetica, Arial, sans-serif; font-size:13px; line-height:8px; color:#000;">
                                                                        @if ($ticketDetails && $ticketDetails->contact_details)
                                                                            <span style="line-height:1px;">
                                                                                {!! $ticketDetails->contact_details !!}
                                                                            </span>
                                                                        @else
                                                                            <div
                                                                                style="margin-bottom:10px; margin-top:7px; font-weight:bold; font-size:13px; color:#333;">
                                                                                FLIGHTS GYANI PVT LTD
                                                                            </div>
                                                                            <div style="margin-bottom:8px;">
                                                                                Lazimpat Opposite to British
                                                                                Embassy, Kathmandu
                                                                            </div>
                                                                            <div style="margin-bottom:8px;">
                                                                                <strong>Phone:</strong>
                                                                                01-4547791 / 980-2368063 /
                                                                                +977 986-0146706
                                                                            </div>
                                                                            <div style="margin-bottom:8px;">
                                                                                <strong>Address:</strong>
                                                                                Milan Chowk - Butwal,
                                                                                Butwal, Nepal
                                                                            </div>
                                                                            <div style="margin-bottom:8px;">
                                                                                <strong>Contact:</strong>
                                                                                071-591346 / +977 9857053346
                                                                            </div>
                                                                        @endif
                                                                    </td>

                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
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
                <td style="direction:ltr;font-size:0px;padding:0px;padding-bottom:5px;padding-top:0;text-align:center;">
                    <div class="mj-column-per-100 mj-outlook-group-fix"
                        style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                            <tbody>
                                <tr>
                                    <td style="vertical-align:top;padding:0px;">
                                        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style
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
                                        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style
                                            width="100%">
                                            <tr>
                                                <td align="left"
                                                    style="font-size:0px;padding:0px;word-break:break-word;">
                                                    <table cellpadding="0" cellspacing="0" width="100%" border="0"
                                                        style="color:#000000;font-family:Helvetica;font-size:11px;line-height:18px;table-layout:auto;width:100%;border:none;">
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
                                                                    closes 1 hour
                                                                    prior to the
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