{{--  @component('mail::message')
    # Need Help?
    <div style="clear: both;">
        <h3 style="text-align: center;color: red;">Are you having any issues in booking flight ticket?</h3>
        <h3 style="clear:both;">Are you looking for @foreach(json_decode($flightBooking->flights,true)['flight'] as $f)
                @foreach($f['sectors'] as $foo)
                    {{$foo['departure']}} -> {{ $foo['arrival'] }},
                @endforeach
            @endforeach flight ticket?</h3>
    </div>

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
                                                               alt=""></span>
                    </td>
                    <td><span style="margin-right: 15px;">{{ $foo['arrival'] }} <img
                                src="{{ asset('frontend/images/flight-land.png') }}" alt=""></span>
                    </td>
                </tr>

            @endforeach
        @endforeach

    </table>

    <br>

    You are receiving this email because you searched for flights.<br>

    <br>

    @component('mail::button', ['url' => route('frontend.index')])
        FlightsGyani
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent  --}}

@component('mail::message')
## Hi,

# Are you having any issues in booking your flight ?

## Your booking is not confirmed yet .

Please contact our customer support on ***01-4266881*** for assistance:


Thanks,<br>
{{ config('app.name') }}
@endcomponent
