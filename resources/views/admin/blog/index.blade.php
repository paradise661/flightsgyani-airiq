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
                                    Blog </a>
                            </div>

                        </div>
                    </div>
                    <table id="dataTable" class="table table-hover" style="width: 100%">
                        <thead>
                        <tr>
                            <th>S NO.</th>
                            <th>Name</th>
                            <th>Descritpion</th>
                            <th>image</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($blogs)
                            @foreach($blogs as $key => $a)
                                <tr>

                                    <td>{{ $key +1 }}</td>
                                    <td>{{ $a->title }}</td>
                                    <td>{!!  $a->description ? \Illuminate\Support\Str::words($a->description, 50) :'' !!}
                                    </td>
                                    <td><img src="{{$a->image}}" style="width:20%"></td>
                                    <td width="20%">
                                        <a href="#"
                                           class="btn-sm btn-primary addAuthor"
                                           data-id="{{$a->id}}"
                                           data-authorid="{{$a->author ? $a->author->id : ''}}"
                                           data-authorname="{{$a->author ? $a->author->name : ''}}"
                                           data-authorfb="{{$a->author ? $a->author->fb : ''}}"
                                           data-authortwitter="{{$a->author ? $a->author->twitter : ''}}"
                                           data-authorinstagram="{{$a->author ? $a->author->instagram : ''}}"
                                           data-authorimage="{{$a->author ? url($a->author->image) : ''}}"
                                           data-authordescription="{{$a->author ? $a->author->description : ''}}"
                                        ><i class="fa fa-user"></i> </a>
                                        <a href="#"
                                           class="btn-sm btn-primary contactEdit"
                                           data-id="{{$a->id}}"
                                           data-title="{{$a->title}}"
                                           data-description="{{$a->description}}"
                                           data-image="{{$a->image}}"

                                        ><i class="fa fa-edit"></i> </a>
                                        {{--<a href="{{ route('category.show', $a->id) }}" class="btn-sm btn-info"><i--}}
                                        {{--class="fa fa-eye"></i> </a>--}}
                                        <a class='btn-sm btn-danger' data-toggle='tooltip' title='Delete'
                                           data-action='delete'
                                           href='{{route('blog.delete')}}' data-id='{{$a->id}}'><i
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
                        <h5 class="modal-title" id="exampleModalLabel">Blog</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="form" enctype="multipart/form-data" method="post">
                            {{csrf_field()}}
                            <div class="row">
                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" id="title"
                                           placeholder="Enter Title" required>
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
        <div class="modal fade" id="authorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Author Detail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formAuthor" enctype="multipart/form-data" method="post">
                            {{csrf_field()}}
                            <div class="row">
                                <input type="hidden" name="id" id="id" value="">
                                <input type="hidden" name="blog_id" id="blodId" value="">
                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="title">Name</label>
                                    <input type="text" name="name" class="form-control" id="Authorname"
                                           placeholder="Enter Name" required>
                                </div>
                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="fb">Facebook</label>
                                    <input type="text" name="fb" class="form-control" id="Authorfb"
                                           placeholder="Enter Facebook" required>
                                </div>
                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="twitter">twitter</label>
                                    <input type="text" name="twitter" class="form-control" id="Authortwitter"
                                           placeholder="Enter Twitter" required>
                                </div>
                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="instagram">instagram</label>
                                    <input type="text" name="instagram" class="form-control" id="Authorinstagram"
                                           placeholder="Enter Instagram" required>
                                </div>
                                <div class="form-group col-lg-12 col-sm-12">
                                    <label for="description">Description</label>

                                </div>
                                <div class="form-group col-lg-12 col-sm-12">
                                    <textarea class="form-control" name="description" rows="4" id="Authordescription">
                                </textarea>
                                </div>


                                <div class="form-group">
                                    <img src="" style="width:20%" id="AuthorImage">
                                    <label for="Image">Image</label>

                                    <input type="file" id="imageFile" class="form-control" placeholder="Image"
                                           name="image">
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
            var url = "{{route('blog.store')}}";
            $('#form').attr('action', url);

        });
        $(document).on('click', '.addAuthor', function (e) {
            e.preventDefault();
            var blog_id = $(this).data('id');
            var id = $(this).data('authorid');
            var authorname = $(this).data('authorname');
            var authorfb = $(this).data('authorfb');
            var authortwitter = $(this).data('authortwitter');
            var authorinstagram = $(this).data('authorinstagram');
            var authorimage = $(this).data('authorimage');
            var authordescription = $(this).data('authordescription');

            $('#id').val(id);
            $('#Authorname').val(authorname);
            $('#Authorfb').val(authorfb);
            $('#Authorinstagram').val(authorinstagram);
            $('#Authortwitter').val(authortwitter);
            $('#Authordescription').html(authordescription);
            $('#AuthorImage').attr('src', authorimage);
            $('#blodId').val(blog_id);
            $('#authorModal').modal('show');
            var url = "{{route('author.store')}}";
            $('#formAuthor').attr('action', url);

        });
        $(document).on('click', '.contactEdit', function (e) {
            e.preventDefault();
            $('#formModal').modal('show');
            var id = $(this).data('id');
            var title = $(this).data('title');
            var description = $(this).data('description');
            var image = $(this).data('image');


            var url = "{{route('blog.update',[null])}}/" + id;
            $('#title').val(title);
            $('#image').attr('src', image);
            CKEDITOR.instances['description'].setData(description)

            $('#form').attr('action', url);

        });
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });

    </script>
@endsection
