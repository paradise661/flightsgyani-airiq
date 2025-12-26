@extends('layouts.front')
@section('title')
    Error
@endsection
@section('body')
    <div class="min-h-96">
        <div class="w-full h-full flex flex-col items-center justify-center">
            <img src="{{ asset('/images/error.png') }}" alt="" class="max-w-80">

            <p class="text-lg max-w-[620px] text-center">
                Your booking could not be completed due to an issue. <br> Please contact our support team at <a
                    class="text-secondary" href="mailto: info@flightsgyani.com"> info@flightsgyani.com</a> <br> Contact Us :
                <a class="text-secondary" href="tel: 01-4547791"> 01-4547791/9802368063/9860146706 </a> <br> Provide your
                Booking ID <span class="text-xl font-medium text-primary">
                    #{{ $booking_code }}
                </span>for assistance. We’re here to help.
            </p>
        </div>
    </div>
@endsection
