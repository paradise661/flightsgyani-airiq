@extends('layouts.back')
@section('title')
    Users
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
                    <h3 class="box-title">Create User</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="form" action="{{ route('user.update') }}" method="POST"
                      enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="hidden" name="user" value="{{ encrypt($user->id) }}">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-4">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" autocomplete="off" id="name" name="name"
                                       value="{{$user->name }}" required>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="email">Email Address</label>
                                <input type="text" class="form-control" autocomplete="off" id="email" name="email"
                                       value="{{ $user->email }}" required>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="password">Password</label>
                                <input type="text" class="form-control" autocomplete="off" id="password" name="password"
                                       value="{{ old('password') }}">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="password">Phone Number</label>
                                <input type="text" class="form-control" autocomplete="off" id="password" name="phonenumber"
                                       value="{{ old('phonenumber',$user->phonenumber) }}">
                                @if ($errors->has('phonenumber'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('phonenumber') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <h5>Status</h5>

                                <input type="checkbox" {{ ($user->active)?'checked':'' }}  id="status" name="status">
                                <label for="status" id="statusType">{{ ($user->active)?'Active':'Suspended' }}</label>
                                @if ($errors->has('status'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('status') }}</strong>
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
@section('scripts')
    <script>
        $('#status').on('click', function () {
            if ($(this).is(':checked')) {
                $('#statusType').html('Active');
            } else {
                $('#statusType').html('Suspend');
            }
        })
    </script>
@endsection
