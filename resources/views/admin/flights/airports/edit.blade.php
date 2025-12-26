@extends('layouts.back')
@section('title')
    Update Airport
@endsection
@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(session('warning'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
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
                    <h3 class="box-title">Update Airport</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="form" action="{{ route('airport.update') }}" method="POST"
                      enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="hidden" name="data" value="{{ $airport->code }}">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-4">
                                <label for="country">Country</label>
                                <input type="text" class="form-control" id="country" name="country"
                                       value="{{ $airport->country }}" required>
                                @if ($errors->has('country'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('country') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="city" name="city"
                                       value="{{ $airport->city }}" required>
                                @if ($errors->has('city'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('city') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="airport">Airport Name</label>
                                <input type="text" class="form-control" id="airport" name="airport"
                                       value="{{ $airport->airport }}" required>
                                @if ($errors->has('airport'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('airport') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="code">IATA Code</label>
                                <input type="text" class="form-control" id="code" name="code"
                                       value="{{ $airport->code }}" required>
                                @if ($errors->has('code'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('code') }}</strong>
                                </span>
                                @endif
                            </div>

                        </div>

                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>

            </div>
        </div>


    </div>
@endsection

