@extends('layouts.back')

@section('title', 'About Us')

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
                            <div class="col-lg-6">
                                <a class="btn btn-primary pull-right" href="#" id="addContact"> Add
                                    Contact </a>
                            </div>

                        </div>
                    </div>
                    <table id="dataTable" class="table table-hover" style="width: 100%">
                        <thead>
                        <tr>
                            <th>S NO.</th>
                            <th>Name</th>
                            <th>email</th>
                            <th>Phone</th>
                            <th>address</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($contacts)
                            @foreach($contacts as $key => $contact)
                                <tr>

                                    <td>{{ $key+++1 }}</td>
                                    <td>{{ $contact->name }}</td>
                                    <td>{{ $contact->email }}</td>
                                    <td>{{ $contact->phone}}</td>
                                    <td>{{ $contact->address}}</td>
                                    <td width="20%">
                                        <a href="#"
                                           class="btn-sm btn-primary contactEdit"
                                           data-id="{{$contact->id}}"
                                           data-name="{{$contact->name}}"
                                           data-email="{{$contact->email}}"
                                           data-phone="{{$contact->phone}}"
                                           data-address="{{$contact->address}}"
                                           data-description="{{$contact->description}}"
                                           data-image="{{$contact->image}}"
                                        ><i class="fa fa-edit"></i> </a>
                                        {{--<a href="{{ route('category.show', $contact->id) }}" class="btn-sm btn-info"><i--}}
                                        {{--class="fa fa-eye"></i> </a>--}}
                                        <a class='btn-sm btn-danger' data-toggle='tooltip' title='Delete'
                                           data-action='delete'
                                           href='{{route('contact-us.delete')}}' data-id='{{$contact->id}}'><i
                                                class="fa fa-trash"></i> </a>


                                    </td>
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
                        <h5 class="modal-title" id="exampleModalLabel">Contact Us</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="form" enctype="multipart/form-data" method="post">
                            {{csrf_field()}}
                            <div class="row">
                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                           placeholder="Enter Name" required>
                                </div>
                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control" id="email"
                                           placeholder="Enter Email" required>
                                </div>
                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone" class="form-control" id="phone"
                                           placeholder="Enter Phone" required>
                                </div>
                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="address">Adress</label>
                                    <input type="text" name="address" class="form-control" id="address"
                                           placeholder="Enter Address" required>
                                </div>
                                <div class="form-group col-lg-12 col-sm-12">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="ckeditor">
                                </textarea>
                                </div>

                                <div class="form-group">
                                    <label for="Image">Image</label>

                                    <input type="file" id="imageFile" class="form-control" placeholder="Image"
                                           name="image" data-ratio="16" data-ratiowidth="12">

                                    <div id="previewWrapper" class="hidden">
                                        <br>
                                        <img id="croppedImagePreview" height="150"><br>
                                        <input type="hidden" name="inputCroppedPic" id="inputCroppedPic" tabindex="-1">
                                        <button class="col-sm-offset-2 col-xs-offset-4 btn btn-danger btn-sm"
                                                type="button"
                                                id="removeCroppedImage" style="margin-top: 7px;">Remove
                                        </button>
                                    </div>
                                    <img src="" id="image" width="20%">
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @include('admin.partials.modal')
        </div>
    </section>

@endsection

@section('scripts')
    @include('admin.partials.jquery_validation')
    @include('admin.partials.cropperjs')
    <script src="{{ URL::asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script src="{{ URL::asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
    <script>

        $(document).on('click', '#addContact', function (e) {
            e.preventDefault();
            $('#formModal').modal('show');
            var url = "{{route('contact-us.store')}}";
            $('#form').trigger('reset');
            CKEDITOR.instances['description'].setData('')
            $('#form').attr('action', url);

        });
        $(document).on('click', '.contactEdit', function (e) {
            e.preventDefault();
            $('#formModal').modal('show');
            var id = $(this).data('id');
            var name = $(this).data('name');
            var phone = $(this).data('phone');
            var email = $(this).data('email');
            var address = $(this).data('address');
            var image = $(this).data('image');
            var description = $(this).data('description');

            var url = "{{route('contact-us.update',[null])}}/" + id;
            $('#name').val(name);
            $('#phone').val(phone);
            $('#email').val(email);
            $('#image').attr('src', image);
            $('#address').val(address);
            CKEDITOR.instances['description'].setData(description)

            $('#form').attr('action', url);

        });
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });

    </script>
@endsection
