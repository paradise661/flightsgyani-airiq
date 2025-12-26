<html>
<title>
    <head>

    </head>
</title>
<style>
    body {
        font-family: 'Roboto', sans-serif;
    }

    .tcenter {
        text-align: center;
    }

    .tleft {
        text-align: left;
    }

    .tright {
        text-align: right;
    }

    h1 {
        margin-bottom: 2px;
        text-decoration: underline;
    }

    hr {
        border-width: 2px;
        border-color: black;
    }

    table {
        border-collapse: collapse;
    }

    table, th, td {
        border: 1px solid black;
    }

    .itinerary h4 {
        color: #1bb6f0;
    }

    .banner {
        color: #fff;
        background: #1bb6f0;
    }

    .address {
        position: absolute;
        margin-left: 550px;
        margin-top: -60px;
    }

    .address p {
        margin-top: 0px;
        margin-bottom: 1px;
        font-size: 12px;
    }

    .day {
        border-radius: 15px;
        background: #1bb6f0;
        padding-left: 10px;
        padding-right: 10px;
        padding-top: 5px;
        padding-bottom: 2px;
        color: white;
    }
</style>
<body>
<div class="tleft">
    <img src="{{url('frontend/images/logo.png')}}">
</div>
<div class="address">
    <p>Kathmandu Office: 01-4418644</p>
    <p>Butwal Office: 071-541578</p>
    <p>Mobile: 9867836383</p>
</div>
<br>
<br>
<br>
<hr>
<div>
    <h2 class="tcenter">{{$package->title}}</h2>
    <p>{!!  $package->description  !!}</p>
    <span style="margin-right: 200px">Days : <strong>{{$package->days}}</strong></span>
    <span> Price: <strong>NPR {{$package->price}}</strong></span>
</div>

<div>
    @if($package->itineraries)
        <h2 class="banner">Itinerary</h2>
        <div class="itinerary" style="margin-top: -10px">
            @foreach($package->itineraries as $i)
                <p style="background: #f5f5f5;"><span style="color: red"> Day <span
                            class="day">{{$i->day}}</span> :</span> <span
                        style=" margin-top: -15px;margin-bottom: -15px; font-size: 20px; color: #1bb6f0;">{{$i->title}}</span>
                </p>
                <p style="text-align: justify">
                    {{$i->description}}
                </p>
            @endforeach
        </div>
        {{--<table style="width: 100%" class="table-bordered">--}}
        {{--<thead style="color: red">--}}
        {{--<tr>--}}
        {{--<th>Day</th>--}}
        {{--<th>Title</th>--}}
        {{--<th>Description</th>--}}
        {{--</tr>--}}
        {{--</thead>--}}
        {{--@foreach($package->itineraries as $i)--}}
        {{--<tr style="text-align: center">--}}
        {{--<td>{{$i->day}}</td>--}}
        {{--<td>{{$i->title}}</td>--}}
        {{--<td>{{$i->description}}</td>--}}
        {{--</tr>--}}
        {{--@endforeach--}}
        {{--</table>--}}
    @endif
</div>
<div>
    @if($package->inclusion)
        <h2 class="banner">Inclusion</h2>
        <p style="text-align: justify">{!! $package->inclusion->description !!}</p>
    @endif
</div>
<div>
    @if($package->exclusion)
        <h2 class="banner">Exclusion</h2>
        <p style="text-align: justify">{!! $package->exclusion->description !!}</p>
    @endif
</div>
<div>
    @if($package->hotels)
        <h2 class="banner">Hotels</h2>
        <table style="width: 100%" class="table-bordered">
            <thead style="color: red ;text-align: center">
            <tr>
                <th>Destination</th>
                <th>Name</th>
                <th>Category</th>
            </tr>
            </thead>
            @foreach($package->hotels as $hotel)
                <tr style="text-align: center">
                    <td>{{$hotel->destination}}</td>
                    <td>{{$hotel->name}}</td>
                    <td>{{$hotel->category}}</td>
                </tr>
            @endforeach
        </table>
    @endif
</div>
<div>
    @if($package->priceDetail)
        <h2 class="banner">Price</h2>
        <table style="width: 100%" class="table-bordered">
            <thead style="color: red">
            <tr style="text-align: center">
                <td>Adult Single</td>
                <td>Adult Double</td>
                <td>Adult Tripple</td>
                <td>Child with Bed</td>
                <td>Child Without Bed</td>
                <td>Infant</td>
            </tr>
            </thead>
            <tbody>
            <tr style="text-align: center">
                <td class="table-price">
                    NPR {{$package->priceDetail ? ($package->priceDetail->adult_single_share ? $package->priceDetail->adult_single_share :'-') :'-' }}</td>
                <td class="table-price">
                    NPR {{$package->priceDetail ? ($package->priceDetail->adult_double_share ? $package->priceDetail->adult_double_share :'-') :'-' }}</td>
                <td class="table-price">
                    NPR {{$package->priceDetail ? ($package->priceDetail->adult_trip_share ? $package->priceDetail->adult_trip_share :'-') :'-' }}</td>
                <td class="table-price">
                    NPR {{$package->priceDetail ? ($package->priceDetail->child_with_bed ? $package->priceDetail->child_with_bed :'-') :'-' }}</td>
                <td class="table-price">
                    NPR {{$package->priceDetail ? ($package->priceDetail->child_without_bed ? $package->priceDetail->child_without_bed :'-') :'-' }}</td>
                <td class="table-price">
                    NPR {{$package->priceDetail ? ($package->priceDetail->infant ? $package->priceDetail->infant :'-') :'-' }}</td>

            </tr>
            </tbody>
        </table>
    @endif
</div>
<div>
    @if($package->operationalTours)
        <h2 class="banner">Operational Tours</h2>
        <table style="width: 100%" class="table-bordered">
            <thead style="color: red">
            <tr style="text-align: center">
                <td>Category</td>
                <td>Price per Adult</td>
                <td>Price per Child</td>
                <td>Price per infant</td>
            </tr>
            </thead>
            <tbody>
            @foreach($package->operationalTours as $ot)
                <tr style="text-align: center">
                    <td class="optional-name">{{$ot->destination}}</td>
                    <td>NPR {{ $ot->price_per_adult }}</td>
                    <td> NPR {{ $ot->price_per_child }}</td>
                    <td> NPR {{$ot->price_per_infant}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
<div>
    @if($package->visa)
        <h2 class="banner">Visa Requirement</h2>
        <p style="text-align: justify">{!! $package->visa? $package->visa->description:'' !!}</p>
    @endif
</div>
<div>
    @if($package->term )
        <h2 class="banner">Terms and Condition</h2>
        <p style="text-align: justify">{!! $package->term ? $package->term->description:'' !!}</p>
    @endif
</div>
<hr>
<footer style="text-align: center">For more detail visit <i style="color: red">www.flightsgyani.com</i> or email us @ <i
        style="color: red;">info@flightsgyani.com</i></footer>
</body>
</html>
