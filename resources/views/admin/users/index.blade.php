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
                <form role="form" id="form" action="{{ route('user.store') }}" method="POST"
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
                                <label for="email">Email Address</label>
                                <input type="text" class="form-control" autocomplete="off" id="email" name="email"
                                       value="{{ old('email') }}" required>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="phonenumber">Phone Number</label>
                                <input type="text" class="form-control" autocomplete="off" id="phonenumber" name="phonenumber"
                                       value="{{ old('phonenumber') }}" required>
                                @if ($errors->has('phonenumber'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('phonenumber') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="password">Password</label>
                                <input type="text" class="form-control" autocomplete="off" id="password" name="password"
                                       value="{{ old('password') }}" required>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('password') }}</strong>
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

                <table class="table table-hover" id="userTable">
                    <thead>
                    <tr>
                        <th class="datatable-nosort">#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Email Status</th>
                        <th>Status</th>
                        <th>Registered Date</th>
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
            var t = $('#userTable').DataTable({
                scrollCollapse: true,
                autoWidth: false,
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: '{{ route('get.users') }}',
                columns: [

                    {data: 'id'},
                    {data: 'name'},
                    {data: 'email'},
                    {data: 'phonenumber'},
                    {data: 'email_verified_at'},
                    {data: 'active'},
                    {data: 'created_at'},
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
    <script>
        $('.delete').on('click', function () {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                }
            })
        })
    </script>
@endsection
