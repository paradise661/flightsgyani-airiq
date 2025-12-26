@extends('layouts.back')
@section('title')
    Airlines
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
                    <h3 class="box-title">Airlines</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="form" action="{{ route('airline.store') }}" method="POST"
                      enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-4">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                       value="{{ old('name') }}" required>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('name') }}</strong>
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
                            <div class="form-group col-4">
                                <label for="image">Image</label>
                                <input type="file" class="form-control" id="image" name="image">
                                @if ($errors->has('image'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('image') }}</strong>
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
                    <h3 class="box-title">Available Airlines</h3>
                </div>

                <table class="table table-hover" id="airportTable">
                    <thead>
                    <tr>
                        <th class="datatable-nosort">#</th>
                        <th>Name</th>
                        <th>IATA Code</th>
                        <th class="datatable-nosort">Image</th>
                        <th class="datatable-nosort">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(\App\Models\InternationalFlight\Airline::all() as $air)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $air->name }}</td>
                            <td>{{ $air->code }}</td>
                            <td><img src="{{ asset('/frontend/air-logos/'.$air->code.'.png') }}" width="50" height="50"
                                     alt=""></td>
                            <td>
                                <div class="dropdown">
                                    <a class="btn btn-outline-primary dropdown-toggle" href="#" role="button"
                                       data-toggle="dropdown">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item"
                                           href="{{ route('airline.edit',$air->code) }}"><i
                                                class="fa fa-eye"></i> Edit</a>
                                        <a class="dropdown-item"
                                           href="{{ route('airline.delete',$air->code) }}"><i
                                                class="fa fa-trash"></i> Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
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
