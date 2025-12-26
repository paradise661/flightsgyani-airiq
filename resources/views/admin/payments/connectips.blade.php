@extends('layouts.back')
@section('title')
    ConnectIPS
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
                    <h3 class="box-title">ConnectIPS</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body" style="padding-left: 20px">
                    <form role="form" id="form" action="{{ route('ips.connect.update') }}" method="POST"
                          enctype="multipart/form-data">
                        {{csrf_field()}}

                        <div class="row">
                            <div class="form-group col-4">
                                <label for="merchant">Merchant ID</label>
                                <input type="text" class="form-control" id="merchant" name="merchant"
                                       value="{{ $ips->merchant_id }}" required>
                                @if ($errors->has('merchant'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('merchant') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="app">App ID</label>
                                <input type="text" class="form-control" id="app" name="app"
                                       value="{{ $ips->app_id }}" required>
                                @if ($errors->has('app'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('app') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="appname">App Name</label>
                                <input type="text" class="form-control" id="appname" name="appname"
                                       value="{{ $ips->app_name }}" required>
                                @if ($errors->has('appname'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('appname') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="gateway">Gateway URL</label>
                                <input type="text" class="form-control" id="gateway" name="gateway"
                                       value="{{ $ips->process_url }}" required>
                                @if ($errors->has('gateway'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('gateway') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group col-4">
                                <label for="validation">Validation URL</label>
                                <input type="text" class="form-control" id="validation" name="validation"
                                       value="{{ $ips->validation_url }}" required>
                                @if ($errors->has('validation'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('validation') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group col-4">
                                <label for="trans">Transaction URL</label>
                                <input type="text" class="form-control" id="trans" name="trans"
                                       value="{{ $ips->transaction_url }}" required>
                                @if ($errors->has('trans'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('trans') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group col-4">
                                <label for="cert">Certificate File</label>
                                <input type="file" class="form-control" id="cert" name="cert">
                                <a href="{{ public_path().'/private/ips/IPS.pfx' }}" target="_blank">Certificate</a>
                                @if ($errors->has('cert'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('cert') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group col-4">
                                <label>Status</label>
                                <input type="checkbox" {{ ($ips->status)?'checked':'' }} id="status" name="status">
                                <label for="status" id="statusLabel">{{ ($ips->status)?'Enabled':'Disabled' }}</label>
                                @if ($errors->has('status'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('status') }}</strong>
                                </span>
                                @endif
                            </div>

                        </div>


                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
@endsection
@section('scripts')
    <script>
        $("#status").on("click", function () {
            if ($(this).is(':checked')) {
                $('#statusLabel').html('Enabled');
            } else {
                $('#statusLabel').html("Disabled");
            }
        })
    </script>
@endsection

