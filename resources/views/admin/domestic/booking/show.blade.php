@extends('layouts.back')
@section('title')
    Domestic Flight Bookings
@endsection
@section('content')
<style>
    body {
        background-color: #f8f9fa;
        font-family: Arial, sans-serif;
    }

    .booking-details {
        background-color: #fff;
        padding: 25px;
        margin-top: 20px;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    .section-title {
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #5ec750;
        border-bottom: 3px solid #5ec750;
        padding-bottom: 10px;
    }

    .detail-item {
        margin-bottom: 15px;
    }

    .detail-label {
        font-weight: bold;
        color: #555;
    }

    .booking-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .booking-header h3 {
        font-size: 24px;
        color: #333;
    }

    .text-right {
        text-align: right;
    }

    .btn-primary,
    .btn-success {
        width: 140px;
    }

    .passenger-info {
        border-bottom: 1px solid #ddd;
        padding-bottom: 15px;
        margin-bottom: 15px;
    }
</style>
<section class="">

    <div class="">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="booking-details">

                    <!-- Booking Header Section -->
                    <div class="booking-header">
                        <h3>Booking Details</h3>
                        <div>
                            <span class="detail-label">Booking ID:</span> {{ $booking->booking_code ?? '' }}<br>
                            <span class="detail-label">Date of Issue:</span>
                            {{ date('M d, Y', strtotime($booking->created_at ?? '')) }}
                        </div>
                    </div>

                    <!-- Contact Details Section -->
                    <div class="section-title">Contact Details</div>
                    <div class="row">
                        <div class="col-sm-6 detail-item">
                            <span class="detail-label">Full Name:</span>
                            {{ $booking->emergency_contact_fullname ?? '' }}
                        </div>
                        <div class="col-sm-6 detail-item">
                            <span class="detail-label">Email:</span> {{ $booking->emergency_contact_email ?? '' }}
                        </div>
                        <div class="col-sm-6 detail-item">
                            <span class="detail-label">Phone:</span> {{ $booking->emergency_contact_phone ?? '' }}
                        </div>
                    </div>

                    <!-- Flight Details Section -->
                    <div class="section-title">Flight Details ({{ $booking->flight_type == 'O' ? 'One Way ' : 'Round' }}
                        Trip)</div>

                    <div class="row">
                        @foreach ($booking->flightInfo as $flight)
                            <div class="col-md-6">
                                <h4>{{ $flight->flight_type == 'O' ? 'Departure' : 'Return' }} Flight</h4>
                                <div class="row">
                                    <div class="col-sm-6 detail-item">
                                        <span class="detail-label">PNR:</span> {{ $flight->pnr_no ?? '' }}
                                    </div>
                                    <div class="col-sm-6 detail-item">
                                        <span class="detail-label">Flight:</span>{{ $flight->airline ?? '' }}
                                        {{ $flight->flight_no ?? '' }}
                                    </div>
                                    <div class="col-sm-6 detail-item">
                                        <span class="detail-label">Departure:</span> {{ $flight->departure ?? '' }}
                                    </div>
                                    <div class="col-sm-6 detail-item">
                                        <span class="detail-label">Departure Time:</span>
                                        {{ date('h:i A', strtotime($flight->departure_time)) }}
                                    </div>
                                    <div class="col-sm-6 detail-item">
                                        <span class="detail-label">Arrival:</span> {{ $flight->arrival ?? '' }}
                                    </div>
                                    <div class="col-sm-6 detail-item">
                                        <span class="detail-label">Arrival Time:</span>
                                        {{ date('h:i A', strtotime($flight->arrival_time)) }}
                                    </div>
                                    <div class="col-sm-6 detail-item">
                                        <span class="detail-label">Ticket Type:</span>
                                        {{ $flight->refundable == 'T' ? 'Refundable' : 'Non-Refundable' }}
                                    </div>
                                    <div class="col-sm-6 detail-item">
                                        <span class="detail-label">Class:</span> {{ $flight->flight_class_code ?? '' }}
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Passenger Details Section -->
                    <div class="section-title">Passenger Details</div>
                    @foreach ($booking->flightTicket as $key => $ticket)
                    <div class="passenger-info">
                        <span class="detail-label">Passenger:</span> {{$ticket->first_name}} {{$ticket->last_name}} ({{$ticket->pax_type}})<br>
                        <span class="detail-label">Ticket No:</span> {{ $ticket->ticket_no }}<br>
                        <span class="detail-label">Gender:</span> {{$ticket->gender}}<br>
                        <span class="detail-label">Nationality:</span> {{$ticket->nationality}}<br>
                        <span class="detail-label">Sector:</span> {{$ticket->sector}}<br>
                        <span class="detail-label">Flight Date:</span> {{$ticket->flight_date}}<br>
                        <span class="detail-label">Flight No:</span> {{$ticket->flight_no}}<br>
                    </div>
                    @endforeach

                    <!-- Payment Details Section -->
                    <div class="section-title">Payment Details</div>
                    <div class="row">
                        <div class="col-sm-6 detail-item">
                            <span class="detail-label">Payment Method:</span> {{$booking->payment->payment_type ?? ''}}
                        </div>
                        <div class="col-sm-6 detail-item text-right">
                            <span class="detail-label">Amount Paid:</span> {{$booking->payment->currency ?? ''}} {{$booking->payment->total_booking_amount ?? ''}} ({{$booking->payment->payment_status ?? ''}})
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

</section>
@endsection
