@extends('layouts.back')
@section('title')
    Flight Bookings
@endsection
@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible  show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(session('warning'))
        <div class="alert alert-danger alert-dismissible  show" role="alert">
            <strong>Error!</strong> {{ session('warning') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    Flight Bookings
                </div>
                <table class="stripe hover multiple-select-row" id="bookingsTable">
                    <thead>
                    <tr>
                        <th>Booking Code</th>
                        <th>Booked By</th>
                        <th>PNR</th>
                        <th class="datatable-nosort">Sector</th>
                        <th>Airline</th>
                        <th>Flight Date</th>
                        <th>Contact</th>
                        <th>Air Price</th>
                        <th>Ticket Status</th>
                        <th>Booking Date</th>
                        <th class="datatable-nosort">Action</th>
                    </tr>
                    </thead>
                    <tbody>


                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        var t = $('#bookingsTable').DataTable({
            scrollCollapse: true,
            autoWidth: false,
            responsive: true,
            processing: true,
            serverSide: true,
            pageLength: 10,
            ajax: '{{ route('get.bookings.data') }}',
            columns: [

                {data: 'booking_code'},
                {data: 'user_id'},
                {data: 'pnr_id'},
                {data: 'sector'},
                {data: 'airline'},
                {data: 'flight_date'},
                {data: 'contact_details'},
                {data: 'final_fare'},
                {data: 'ticket_status'},
                {data: 'created_at'},
                {data: 'actions'},
            ],
            columnDefs: [{
                targets: "datatable-nosort",
                orderable: false,
            }],
        });
        t.on('order.dt search.dt', function () {
            // t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            //     cell.innerHTML = i + 1;
            // });
        }).order([9, 'des']).draw();
    </script>
@endsection
