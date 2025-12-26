@extends('layouts.back')

@section('title', 'Blog')

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
                                    Team Member </a>
                            </div>

                        </div>
                    </div>
                    <table id="dataTable" class="table table-hover" style="width: 100%">
                        <thead>
                        <tr>
                            <th>S NO.</th>
                            <th>Name</th>
                            <th>Post</th>
                            <th>Descritpion</th>
                            <th>image</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($teams)
                            @foreach($teams as $key => $a)
                                <tr>

                                    <td>{{ $key +1 }}</td>
                                    <td>{{ $a->name }}</td>
                                    <td>{{ $a->post }}</td>
                                    <td>{!!  $a->short_description ? \Illuminate\Support\Str::words($a->short_description, 50) :'' !!}
                                    </td>
                                    <td><img src="{{$a->image}}" style="width:20%"></td>
                                    <td width="20%">
                                        <a href="#"
                                           class="btn-sm btn-primary contactEdit"
                                           data-id="{{$a->id}}"
                                           data-name="{{$a->name}}"
                                           data-post="{{$a->post}}"
                                           data-shortdescription="{{$a->short_description}}"
                                           data-image="{{$a->image}}"
                                           data-fb="{{$a->fb}}"
                                           data-instagram="{{$a->instagram}}"
                                           data-twitter="{{$a->twitter}}"

                                        ><i class="fa fa-edit"></i> </a>
                                        {{--<a href="{{ route('category.show', $a->id) }}" class="btn-sm btn-info"><i--}}
                                        {{--class="fa fa-eye"></i> </a>--}}
                                        <a class='btn-sm btn-danger' data-toggle='tooltip' title='Delete'
                                           data-action='delete'
                                           href='{{route('team.delete')}}' data-id='{{$a->id}}'><i
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
                        <h5 class="modal-title" id="exampleModalLabel">Team</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formUrl" enctype="multipart/form-data" method="post">
                            {{csrf_field()}}
                            <div class="row">
                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                           placeholder="Enter Name" required>
                                </div>
                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="post">Post</label>
                                    <input type="text" name="post" class="form-control" id="post"
                                           placeholder="Enter Post" required>
                                </div>
                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="fb">Facebook</label>
                                    <input type="text" name="fb" class="form-control" id="fb"
                                           placeholder="Enter Facebook" required>
                                </div>
                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="instagram">Instagram</label>
                                    <input type="text" name="instagram" class="form-control" id="instagram"
                                           placeholder="Enter Instagram" required>
                                </div>
                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="twitter">Twitter</label>
                                    <input type="text" name="twitter" class="form-control" id="twitter"
                                           placeholder="Enter Twitter" required>
                                </div>
                                <div class="form-group col-lg-12 col-sm-12">
                                    <label for="description">Short Description</label>
                                    <textarea name="short_description" class="ckeditor" id="short_description">
                                </textarea>
                                </div>

                                <div class="form-group">
                                    <label for="Image">Image</label>

                                    <input type="file" id="imageFile" class="form-control" placeholder="Image"
                                           name="image" data-ratio="16" data-ratiowidth="16">

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

@stop

@section('scripts')
    @include('admin.partials.jquery_validation')
    @include('admin.partials.cropperjs')
    <script src="{{ URL::asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script src="{{ URL::asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
    <script>

        $(document).on('click', '#addContact', function (e) {
            e.preventDefault();
            $('#formModal').modal('show');
            var url = "{{route('team.store')}}";
            $('#formUrl').attr('action', url);

        });
        $(document).on('click', '.contactEdit', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            var url = "{{route('team.update',[null])}}/" + id;
            $('#formUrl').attr('action', url);


            $('#formModal').modal('show');
            var name = $(this).data('name');
            var post = $(this).data('post');
            var short_description = $(this).data('shortdescription');
            var fb = $(this).data('fb');
            var instagram = $(this).data('instagram');
            var twitter = $(this).data('twitter');
            var image = $(this).data('image');


            $('#name').val(name);
            $('#short_description').html(short_description);
            $('#fb').val(fb);
            $('#instagram').val(instagram);
            $('#twitter').val(twitter);
            $('#post').val(post);
            $('#image').attr('src', image);
            CKEDITOR.instances['short_description'].setData(short_description)

        });
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });

    </script>
@endsection
