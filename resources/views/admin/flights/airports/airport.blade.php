@extends('layouts.back')
@section('title')
    Airports
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
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Airports</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="form" action="{{ route('airport.store') }}" method="POST"
                      enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-4">
                                <label for="country">Country</label>
                                <input type="text" class="form-control" id="country" name="country"
                                       value="{{ old('country') }}" required>
                                @if ($errors->has('country'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('country') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="city" name="city"
                                       value="{{ old('city') }}" required>
                                @if ($errors->has('city'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('city') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="airport">Airport Name</label>
                                <input type="text" class="form-control" id="airport" name="airport"
                                       value="{{ old('airport') }}" required>
                                @if ($errors->has('airport'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('airport') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="code">IATA Code</label>
                                <input type="text" class="form-control" id="code" name="code"
                                       value="{{ old('code') }}" required>
                                @if ($errors->has('code'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('code') }}</strong>
                                </span>
                                @endif
                            </div>

                        </div>

                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>

            </div>
        </div>

        <div class="col-md-12">
            <div class="box box-secondary">
                <div class="box-header with-border">
                    <h3 class="box-title">Available Airports</h3>
                </div>

                <table class="table table-hover" id="airportTable">
                    <thead>
                    <tr>
                        <th class="datatable-nosort">#</th>
                        <th>Country</th>
                        <th>City</th>
                        <th>Airport</th>
                        <th>IATA Code</th>
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
            var t = $('#airportTable').DataTable({
                scrollCollapse: true,
                autoWidth: false,
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: '{{ route('getairports') }}',
                columns: [

                    {data: 'id'},
                    {data: 'country'},
                    {data: 'city'},
                    {data: 'airport'},
                    {data: 'code'},
                    {data: 'actions'},
                ],
                columnDefs: [{
                    targets: "datatable-nosort",
                    orderable: false,
                }],
            });
            t.on('order.dt search.dt', function () {
                t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
        });
    </script>
@endsection
