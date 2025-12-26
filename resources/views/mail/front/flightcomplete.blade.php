<html>
<head>

</head>
<body>
@component('mail::message')
    # We are more than happy to be a part for your journey

    <table style="width:100%;border: 1px solid red;padding: 10px;text-align: center;">
        @foreach(json_decode($flightBooking->flights,true)['flight'] as $f)
            @foreach($f['sectors'] as $foo)
                <tr>
                    <td><img style="margin-right: 50px;"
                             src="{{ asset('/frontend/air-logos/'.$foo['marketingairline'].'.png') }}" width="50"
                             height="50" alt="{{ $foo['marketingairline'] }}">
                    </td>
                    <td><span style="margin-right: 25px;">{{ $foo['departure'] }} <img
                                src="{{ asset('frontend/images/flight-takeoff.png') }}" alt=""></span>
                    </td>
                    <td><span style="margin-right: 25px;"><img src="{{ asset('frontend/images/flight-path.png') }}"
                                                               alt=""><small>{{ $foo['departdate'] }}</small></span>
                    </td>
                    <td><span style="margin-right: 15px;">{{ $foo['arrival'] }} <img
                                src="{{ asset('frontend/images/flight-land.png') }}" alt=""></span>
                    </td>
                </tr>

            @endforeach
        @endforeach

    </table>
    <br>
    <h3 style="margin-left:50px;float: left;">PNR</h3><h3
        style="margin-right: 50px;float: right">{{ $flightBooking->pnr_id }}</h3>
    <br>
    <h3 style="text-align: center;">Ticket Details</h3>
    <table style="width:100%;padding: 10px;text-align: center;">
        @foreach($flightBooking->getTickets as $t)

            <tr>
                <td>{{ $t->full_name }}</td>
                <td>{{ $t->pax_type }}</td>
                <td>{{ $t->ticket_number }}</td>

            </tr>

        @endforeach

    </table>
    <br>

    @component('mail::button', ['url' => route('frontend.index')])
        FlightsGyani
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
</body>
</html>
