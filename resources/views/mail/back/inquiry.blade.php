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

    table,
    th,
    td {
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
<p> Lazimpat Opposite to British Embassy Gate 5, Kathmandu</p>
         <p> Phone :01-5970440</p>
         <p> Mobile: +977-9857015300</p>
    </div>
<br>
<br>
<br>
<hr>
<div>
    <h2>Thank You!!!!</h2>
    <p>Your Inquiry has been recieved successfully with following details. We will contact you as soon as possible.</p>
    @if(isset($data['inq_date']))
        <p>Inquiry Date: {{$data['inq_date']}}</p>
    @endif
    <p>Mail: {{$data['email'] ? $data['email'] :''}}</p>
    <p>Name: {{$data['name'] ? $data['name'] :''}}</p>
    <p>Phone: {{$data['phone'] ? $data['phone'] :''}}</p>
    <p>City: {{$data['city'] ? $data['city'] : ''}}</p>
    <p>Message: {{$data['message'] ? $data['message'] :'' }}</p>


    </div>

    <hr>
    <footer style="text-align: center">For more detail visit <i style="color: red">www.flightsgyani.com</i> or email us @
        <i style="color: red;">info@flightsgyani.com</i>
    </footer>
</body>

</html>
