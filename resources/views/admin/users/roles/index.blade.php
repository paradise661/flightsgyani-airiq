@extends('layouts.back')
@section('title')
    Roles
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
                    <h3 class="box-title">Create Role</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="form" action="{{ route('role.store') }}" method="POST"
                      enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-4">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" autocomplete="off" id="name" name="name"
                                       value="{{ old('name') }}" required>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="display">Display Name</label>
                                <input type="text" class="form-control" autocomplete="off" id="display" name="display"
                                       value="{{ old('display') }}" required>
                                @if ($errors->has('display'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('display') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="description">Description</label>
                                <textarea class="form-control" autocomplete="off" id="description" name="description"
                                >{{ old('description') }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                </span>
                                @endif
                            </div>


                        </div>

                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>

            </div>
        </div>

        <div class="col-md-12">
            <div class="box box-secondary">
                <div class="box-header with-border">
                    <h3 class="box-title">Registered Users</h3>
                </div>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="datatable-nosort">#</th>
                        <th>Name</th>
                        <th>Display Name</th>
                        <th>Description</th>
                        <th class="datatable-nosort">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->display_name }}</td>
                            <td>{{ (isset($role->description))?$role->description:'-' }}</td>
                            <td>
                                <div class="dropdown">
                                    <a class="btn btn-outline-primary dropdown-toggle" href="#" role="button"
                                       data-toggle="dropdown">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{ route('role.edit',encrypt($role->id)) }}"><i
                                                class="fa fa-eye"></i> View</a>
                                        <a class="dropdown-item" href="{{ route('role.destroy') }}" data-action="delete"
                                           data-id="{{ encrypt($role->id) }}"><i class="fa fa-trash"></i> Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-danger">No Records Found</td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
@section('scripts')

@endsection
