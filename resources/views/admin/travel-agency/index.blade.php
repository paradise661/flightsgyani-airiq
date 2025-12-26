@extends('layouts.back')

@section('title', 'Travel Agency')

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
                                    Travel Agency </a>
                            </div>

                        </div>
                    </div>
                    <table id="dataTable" class="table table-hover" style="width: 100%">
                        <thead>
                        <tr>
                            <th>S NO.</th>
                            <th>Name</th>
                            <th>Quote</th>
                            <th>image</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($travelAgencies)
                            @foreach($travelAgencies as $key => $ta)
                                <tr>

                                    <td>{{ $key +1 }}</td>
                                    <td>{{ $ta->name }}</td>
                                    <td>{!!  $ta->quote !!}</td>
                                    <td><img src="{{$ta->image}}" style="width:20%"></td>
                                    <td width="20%">
                                        <a href="#"
                                           class="btn-sm btn-primary contactEdit"
                                           data-id="{{$ta->id}}"
                                           data-name="{{$ta->name}}"
                                           data-quote="{{$ta->quote}}"
                                           data-image="{{$ta->image}}"

                                        ><i class="fa fa-edit"></i> </a>
                                        {{--<a href="{{ route('category.show', $ta->id) }}" class="btn-sm btn-info"><i--}}
                                        {{--class="fa fa-eye"></i> </a>--}}
                                        <a class='btn-sm btn-danger' data-toggle='tooltip' title='Delete'
                                           data-action='delete'
                                           href='{{route('travel-agency.delete')}}' data-id='{{$ta->id}}'><i
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
                        <h5 class="modal-title" id="exampleModalLabel">What People Say</h5>
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
                                           placeholder="Enter name" required>
                                </div>
                                <div class="form-group col-lg-12 col-sm-12">
                                    <label for="description">Quote</label>
                                    <textarea name="quote" id="description" class="ckeditor">
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
            var url = "{{route('travel-agency.store')}}";
            $('#form').attr('action', url);

        });
        $(document).on('click', '.contactEdit', function (e) {
            e.preventDefault();
            $('#formModal').modal('show');
            var id = $(this).data('id');
            var name = $(this).data('name');
            var quote = $(this).data('quote');
            var image = $(this).data('image');


            var url = "{{route('travel-agency.update',[null])}}/" + id;
            $('#name').val(name);
            $('#image').attr('src', image);
            CKEDITOR.instances['description'].setData(quote)

            $('#form').attr('action', url);

        });
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });

    </script>
@endsection
