@extends('layouts.back')
@section('title')
    Domestic Flight Bookings
@endsection
@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible  show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button class="close" data-dismiss="alert" type="button" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session('warning'))
        <div class="alert alert-danger alert-dismissible  show" role="alert">
            <strong>Error!</strong> {{ session('warning') }}
            <button class="close" data-dismiss="alert" type="button" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    Domestic Flight Bookings
                </div>
                <table class="table " id="">
                    <thead>
                        <tr>
                            <th>Booking Code</th>
                            <th class="datatable-nosort">Departure</th>
                            <th>Arrival</th>
                            <th>Departure Date</th>
                            <th>Arrival Date</th>
                            <th>Total Amount</th>
                            <th>Contact</th>
                            <th>Ticket Status</th>
                            <th>Booking Date</th>
                            <th class="datatable-nosort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                            <tr>
                                <td>{{ $booking->booking_code ?? '' }}</td>
                                <td>{{ $booking->sector_from ?? '' }}</td>
                                <td>{{ $booking->sector_to ?? '' }}</td>
                                <td>{{ $booking->departure_date ?? '' }}</td>
                                <td>{{ $booking->flight_type == 'R' ? $booking->arrival_date : '-' }}</td>
                                <td>{{ $booking->total_booking_amount ?? '' }}</td>
                                <td>{{ $booking->emergency_contact_fullname ?? '' }}
                                    ({{ $booking->emergency_contact_phone ?? '' }})</td>
                                <td>{{ $booking->payment->payment_status ?? '' }}</td>
                                <td>{{ $booking->created_at->format('Y-m-d') ?? '' }}</td>
                                <td>
                                    <a class="dropdown-item"
                                        href="{{ route('admin.domestic.flight.bookings.details', $booking->id) }}"><i
                                            class="fa fa-eye"></i> View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
