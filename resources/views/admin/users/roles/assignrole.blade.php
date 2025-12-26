@extends('layouts.back')
@section('title')
    Assign Role to User
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
                    <h3 class="box-title">Assign User Role</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="form" action="{{ route('user.grantrole') }}" method="POST"
                      enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-12">
                                <div class="row">
                                    <div class="col-2">
                                        <label for="name">User</label>
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control user-typeahead" autocomplete="off"
                                               id="name" name="name"
                                               value="{{ old('name') }}" required>
                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                </span>
                                        @endif
                                    </div>
                                </div>


                            </div>
                            <div class="form-group col-12">
                                <div class="row">
                                    <div class="col-2">
                                        Roles
                                    </div>
                                    <div class="col-10">
                                        <div class="row">
                                            @forelse($roles as $role)
                                                <div class="col-4">

                                                    <input type="checkbox" autocomplete="off" id="{{ $role->name }}"
                                                           name="roles[]"
                                                           value="{{ $role->id }}"> <label
                                                        for="{{ $role->name }}">{{ $role->name }}</label>
                                                    @empty
                                                        No Roles Found &nbsp; &nbsp;<a href="{{ route('role.index') }}">Create
                                                            Role</a>
                                                    @endforelse
                                                    @if ($errors->has('roles'))
                                                        <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('roles') }}</strong>
                                </span>
                                                    @endif
                                                </div>
                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>

                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Assign</button>
                    </div>
                </form>

            </div>
        </div>


    </div>
@endsection
