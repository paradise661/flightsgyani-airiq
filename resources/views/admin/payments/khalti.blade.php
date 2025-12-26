@extends('layouts.back')
@section('title')
    Khalti
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
                    <h3 class="box-title">Khalti</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body" style="padding-left: 20px">
                    <form role="form" id="form" action="{{ route('khalti.update') }}" method="POST"
                          enctype="multipart/form-data">
                        {{csrf_field()}}

                        <div class="row">


                            <div class="form-group col-4">
                                <label for="public">Public Key</label>
                                <input type="text" class="form-control" id="public" name="publicKey"
                                       value="{{ $khalti->public_key }}" required>
                                @if ($errors->has('publicKey'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('publicKey') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group col-4">
                                <label for="private">Private Key</label>
                                <input type="text" class="form-control" id="private" name="privateKey"
                                       value="{{ $khalti->secret_key }}" required>
                                @if ($errors->has('privateKey'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('privateKey') }}</strong>
                                </span>
                                @endif
                            </div>


                            <div class="form-group col-4">
                                <label>Status</label>
                                <input type="checkbox" {{ ($khalti->status)?'checked':'' }} id="status" name="status">
                                <label for="status"
                                       id="statusLabel">{{ ($khalti->status)?'Enabled':'Disabled' }}</label>
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

