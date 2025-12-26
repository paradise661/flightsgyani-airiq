@extends('layouts.back')
@section('title')
    Update Sabre Credentials
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
            <strong>Success!</strong> {{ session('warning') }}
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
                    <h3 class="box-title">Update Sabre credentials</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="form" action="{{ route('sabre.details.update') }}" method="POST"
                      enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-4">
                                <label for="title">PCC</label>
                                <input type="text" class="form-control" id="sabrepcc" name="sabrepcc"
                                       value="{{ config('sabre.pcc') }}" required>
                                @if ($errors->has('sabrepcc'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('sabrepcc') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="slug">EndPoint</label>
                                <input type="text" class="form-control" id="sabreurl" name="sabreurl"
                                       value="{{ config('sabre.url') }}" required>
                                @if ($errors->has('sabreurl'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('sabreurl') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="deals_on_sale">Username</label>
                                <input type="text" class="form-control" id="sabreuser" name="sabreuser"
                                       value="{{ config('sabre.username') }}" required>
                                @if ($errors->has('sabreuser'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('sabreuser') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="discount">Password</label>
                                <input type="text" class="form-control" id="sabrepassword" name="sabrepassword"
                                       value="{{ config('sabre.password') }}" required>
                                @if ($errors->has('sabrepassword'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('sabrepassword') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="price">LNIATA</label>
                                <input type="text" class="form-control" id="sabrelniata" name="sabrelniata"
                                       value="{{ config('sabre.lniata') }}" required>
                                @if ($errors->has('sabrelniata'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('sabrelniata') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="category">City Code</label>
                                <input type="text" class="form-control" id="sabrecitycode" name="sabrecitycode"
                                       value="{{ config('sabre.citycode') }}" required>
                                @if ($errors->has('sabrecitycode'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('sabrecitycode') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="category">Address Line</label>
                                <input type="text" class="form-control" id="sabreaddressline" name="sabreaddressline"
                                       value="{{ config('sabre.addressline') }}" required>
                                @if ($errors->has('sabreaddressline'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('sabreaddressline') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="start_date">City Name</label>
                                <input type="text" class="form-control" id="sabrecityname" name="sabrecityname"
                                       value="{{ config('sabre.cityname') }}" required>
                                @if ($errors->has('sabrecityname'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('sabrecityname') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="start_date">Country Code</label>
                                <input type="text" class="form-control" id="sabrecountrycode" name="sabrecountrycode"
                                       value="{{ config('sabre.cityname') }}" required>
                                @if ($errors->has('sabrecountrycode'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('sabrecountrycode') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group col-4">
                                <label for="days">Postal Code</label>
                                <input type="text" class="form-control" id="sabrepostal" name="sabrepostal"
                                       value="{{ config('sabre.postal') }}">
                                @if ($errors->has('sabrepostal'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('sabrepostal') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="rating">Street Number</label>
                                <input type="text" class="form-control" id="sabrestreet" name="sabrestreet"
                                       value="{{ config('sabre.streetnumber') }}">
                                @if ($errors->has('sabrestreet'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('sabrestreet') }}</strong>
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
    </div>
@endsection
