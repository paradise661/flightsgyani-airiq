@extends('layouts.back')
@section('title')
    NPS OnePG
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
                    <h3 class="box-title">NPS OnePG</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body" style="padding-left: 20px">
                    <form role="form" id="form" action="{{ route('NPSOnePG.update') }}" method="POST"
                          enctype="multipart/form-data">
                        {{csrf_field()}}

                        <div class="row">
                            <div class="form-group col-4">
                                <label for="processUrl">Process Id URL</label>
                                <input type="text"
                                       value="{{ old('processUrl',$NPSOnePG->process_id_url) }}"
                                       id="processUrl" name="processUrl" class="form-control">
                                @error('processUrl')
                                <span class="help-block">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group col-4">

                                <label for="redirectionUrl">Redirection URL</label>
                                <input type="text"
                                       value="{{ old('redirectionUrl',$NPSOnePG->redirection_url) }}"
                                       id="redirectionUrl" name="redirectionUrl" class="form-control">
                                @error('redirectionUrl')
                                <span class="help-block">
                                    <strong class="text-danger">{{ $message }}  </strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group col-4">
                                <label for="instrumentUrl">Instrument URL</label>
                                <input type="text"
                                       value="{{ old('instrumentUrl',$NPSOnePG->instrument_url) }}"
                                       id="instrumentUrl" name="instrumentUrl" class="form-control">
                                @error('instrumentUrl')
                                <span class="help-block">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group col-4">

                                <label for="transactionUrl">Transaction URL</label>
                                <input type="text" value="{{ old('transactionUrl',$NPSOnePG->transaction_url) }}"
                                       id="transactionUrl" name="transactionUrl" class="form-control">
                                @error('transactionUrl')
                                <span class="help-block">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                                @enderror

                            </div>
                            <div class="form-group col-4">

                                <label for="merchant">Merchant ID</label>
                                <input type="text" value="{{ old('merchant',$NPSOnePG->merchant_id) }}"
                                       id="merchant" name="merchant" class="form-control">
                                @error('merchant')
                                <span class="help-block">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-4">
                                <label for="merchantName">Merchant Name</label>
                                <input type="text" value="{{ old('merchantName',$NPSOnePG->merchant_name) }}"
                                       id="merchantName" name="merchantName" class="form-control">
                                @error('merchantName')
                                <span class="help-block">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-4">
                                <label for="username">Username</label>
                                <input type="text" value="{{ old('username',$NPSOnePG->username) }}"
                                       id="username" name="username" class="form-control">
                                @error('username')
                                <span class="help-block">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-4">
                                <label for="password">Password</label>
                                <input type="text" value="{{ old('password',$NPSOnePG->password) }}"
                                       id="password" name="password" class="form-control">
                                @error('password')
                                <span class="help-block">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-4">
                                <label for="secretKey">Secret Key</label>
                                <input type="text" value="{{ old('secretKey',$NPSOnePG->secret_key) }}"
                                       id="secretKey" name="secretKey" class="form-control">
                                @error('secretKey')
                                <span class="help-block">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-4">
                                <label for="charge">Additional Charge(%)</label>
                                <input type="text"
                                       value="{{ old('charge',$NPSOnePG->additional_charge) }}"
                                       id="charge" name="charge"
                                       class="form-control">
                                @error('charge')
                                <span class="help-block">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>


                            <div class="form-group col-4">
                                <label>Status</label>
                                <input type="checkbox" {{ ($NPSOnePG->status)?'checked':'' }} id="status" name="status">
                                <label for="status"
                                       id="statusLabel">{{ ($NPSOnePG->status)?'Enabled':'Disabled' }}</label>
                                @error('status')
                                <span class="help-block">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                                @enderror
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

