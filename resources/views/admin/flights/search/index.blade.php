@extends('layouts.back')
@section('title')
    Search Log
@endsection
@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(session('warning'))
        <div class="alert alert-danger alert-dismissible show" role="alert">
            <strong>Error!</strong> {{ session('warning') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">

                <div class="box-header with-border">
                    <h3 class="box-title">Search Log</h3>
                    <a href="{{ route('admin.clear.flight.search') }}"
                       onclick="return confirm('This will delete all search data and can not be undone. Continue?');"
                       class="btn btn-danger align-right">Clear Log</a>
                </div>
                <table class="stripe hover multiple-select-row data-table-export nowrap" id="search-table">
                    <thead>
                    <tr>
                        <th>Search ID</th>
                        <th>User</th>
                        <th class="datatable-nosort">Sector</th>
                        <th>Flight Date</th>
                        <th>Return Date</th>
                        <th class="datatable-nosort">PAX</th>
                        <th>Search Date</th>
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
        $(document).ready(function () {
            var t = $('#search-table').DataTable({
                scrollCollapse: true,
                autoWidth: false,
                responsive: true,
                processing: true,
                serverSide: true,
                pageLength: 100,
                ajax: '{{ route('get.search.data') }}',
                columns: [

                    {data: 'id'},
                    {data: 'user_id'},
                    {data: 'sector'},
                    {data: 'flight_date'},
                    {data: 'return_date'},
                    {data: 'pax'},
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
            }).order([0, 'des']).draw();
        });
    </script>
@endsection
