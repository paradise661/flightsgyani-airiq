@php $route = Request::route()->getName()
@endphp

@extends('layouts.back')

@section('title', 'Inquery')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="row">
                            <div class="col-lg-6">
                            </div>
                        </div>
                    </div>
                    <table id="dataTable" class="table table-hover" style="width: 100%">
                        <thead>
                        <tr>
                            <th>S NO.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>City</th>
                            <th>Inquery Date</th>
                            <th>Message</th>
                            @if($route == 'booking.index')
                                <th>Package</th>
                            @endif
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($inqueries)
                            @foreach($inqueries as $key => $a)
                                <tr @if($a->status == 0)style="color: red" @endif>
                                    <td>{{ $key +1 }}</td>
                                    <td>{{ $a->name }}</td>
                                    <td>{{ $a->email }}</td>
                                    <td>{{ $a->phone}}</td>
                                    <td>{{ $a->city}}</td>
                                    <td>{{ $a->inq_date ?? '-'}}</td>
                                    <td>{{ $a->message ?? '-'}}</td>
                                    @if($route == 'booking.index')
                                        <td>
                                            <a href="{{route('package.show',$a->package->id)}}"> {{$a->package ? $a->package->title:'-'}}</a>
                                        </td>
                                    @endif
                                    <td width="20%">
                                        <a href="#"
                                           class="btn-sm btn-primary contactEdit"
                                           data-id="{{$a->id}}"
                                           data-name="{{$a->name}}"
                                           data-email="{{$a->email}}"
                                           data-phone="{{$a->phone}}"
                                           data-city="{{$a->city}}"
                                           data-inqdate="{{$a->inq_date}}"
                                           data-message="{{$a->message}}"
                                        ><i class="fa fa-eye"></i> </a>

                                        <a class='btn-sm btn-danger' data-toggle='tooltip' title='Delete'
                                           data-action='delete'
                                           href='{{route('inquery.delete')}}' data-id='{{$a->id}}'><i
                                                class="fa fa-trash"></i> </a>
                                    </td>
                                    </strong>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h2><strong>Name : </strong> <span id="name"></span></h2>
                        <p><strong> Email: </strong><span id="email"></span></p>
                        <p><strong> Phone: </strong><span id="phone"></span></p>
                        <p><strong> City: </strong> <span id="city"></span></p>
                        <p><strong> Message: </strong><span id="message"></span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
            @include('admin.partials.modal')
        </div>
    </section>
    {{--    @include('includes.jquery_validation')--}}
    {{--    @include('includes.ckeditor')--}}
@stop

@section('scripts')
    {{--    @include('includes.cropperjs')--}}
    <script>

        $(document).on('click', '#addContact', function (e) {
            e.preventDefault();
            $('#formModal').modal('show');
            var url = "{{route('about-us.store')}}";
            $('#form').attr('action', url);

        });
        $(document).on('click', '.contactEdit', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            var url = "{{route('inquery.update',[null])}}/" + id;

            $.ajax({
                url: url,
                id: id
            });
            $('#formModal').modal('show');
            var name = $(this).data('name');
            var phone = $(this).data('phone');
            var email = $(this).data('email');
            var city = $(this).data('city');
            var message = $(this).data('message');

            $('#name').html(name);
            $('#phone').html(phone);
            $('#email').html(email);
            $('#city').html(city);
            $('#message').html(message);
        });
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
        $('#formModal').on('hidden.bs.modal', function (e) {
            location.reload();
        });

    </script>
@endsection
