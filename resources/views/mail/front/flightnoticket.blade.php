<html>
<head>

</head>
<body>
@component('mail::message')
    # Having issue? No Problem.

    <p>Its look like you are having issue generating your ticket. Don't worry your ticket pricing will be retained.</p>


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

    <br>
    <h3 style="margin-left:50px;float: left;">PNR</h3>
    <h3
        style="margin-right: 50px;float: right">{{ $flightBooking->pnr_id }}</h3>
    <br>
    <p>We are really sorry for having issue. We will contact you soon.</p>
    <br>


    @component('mail::button', ['url' => route('frontend.index')])
        FlightsGyani
    @endcomponent

    Thanks,
    {{ config('app.name') }}
@endcomponent
</body>
</html>
