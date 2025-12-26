@extends('layouts.back')

@section('title', 'About us')

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
                                {{--<a class="btn btn-primary pull-right" href="#" id="addContact"> Add--}}
                                {{--Blog </a>--}}
                            </div>

                        </div>
                    </div>
                    <table id="dataTable" class="table table-hover" style="width: 100%">
                        <thead>
                        <tr>
                            {{--<th>S NO.</th>--}}
                            <th>Name</th>
                            <th>Short Descritpion</th>
                            <th>fb</th>
                            <th>instagram</th>
                            {{--<th>Linkedin</th>--}}
                            {{--<th>Twitter</th>--}}
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($abouts)
                            @foreach($abouts as $key => $a)
                                <tr>

                                    {{--<td>{{ $key +1 }}</td>--}}
                                    <td>{{ $a->name }}</td>
                                    <td>{{ $a->short_description }}</td>
                                    <td>{{ $a->fb}}</td>
                                    <td>{{ $a->instagram}}</td>
                                    {{--<td>{{ $a->linkedin}}</td>--}}
                                    {{--<td>{{ $a->twitter}}</td>--}}
                                    <td width="20%">
                                        <a href="#"
                                           class="btn-sm btn-primary contactEdit"
                                           data-id="{{$a->id}}"
                                           data-name="{{$a->name}}"
                                           data-short_description="{{$a->short_description}}"
                                           data-description="{{$a->description}}"
                                           data-instagram="{{$a->instagram}}"
                                           data-linkedin="{{$a->linkedin}}"
                                           data-twitter="{{$a->twitter}}"
                                        ><i class="fa fa-edit"></i> </a>
                                        {{--<a href="{{ route('category.show', $a->id) }}" class="btn-sm btn-info"><i--}}
                                        {{--class="fa fa-eye"></i> </a>--}}
                                        <a class='btn-sm btn-danger' data-toggle='tooltip' title='Delete'
                                           data-action='delete'
                                           href='{{route('about-us.delete')}}' data-id='{{$a->id}}'><i
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
                                    <label for="facebook">Facebook</label>
                                    <input type="text" name="fb" class="form-control" id="facebook"
                                           placeholder="Enter Facebook" required>
                                </div>
                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="instagram">Instagram</label>
                                    <input type="text" name="instagram" class="form-control" id="instagram"
                                           placeholder="Enter Instagram" required>
                                </div>
                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="linkedin">Linked In</label>
                                    <input type="text" name="linkedin" class="form-control" id="linkedin"
                                           placeholder="Enter Linked In" required>
                                </div>
                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="twitter">Twitter</label>
                                    <input type="text" name="twitter" class="form-control" id="twitter"
                                           placeholder="Enter Twitter" required>
                                </div>
                                <div class="form-group col-lg-4 col-sm-4">
                                    <label for="short_description">Short descritpion</label>
                                    <input type="text" name="short_description" class="form-control"
                                           id="short_description"
                                           placeholder="Enter short desciption" required>
                                </div>
                                <div class="form-group col-lg-12 col-sm-12">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="ckeditor">
                                </textarea>
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
    {{--    @include('admin.partials.cropperjs')--}}
    <script src="{{ URL::asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script src="{{ URL::asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
    <script>

        $(document).on('click', '#addContact', function (e) {
            e.preventDefault();
            $('#formModal').modal('show');
            var url = "{{route('about-us.store')}}";
            $('#form').attr('action', url);

        });
        $(document).on('click', '.contactEdit', function (e) {
            e.preventDefault();
            $('#formModal').modal('show');
            var id = $(this).data('id');
            var name = $(this).data('name');
            var short_description = $(this).data('short_description');
            var facebook = $(this).data('facebook');
            var instagram = $(this).data('instagram');
            var linkedin = $(this).data('linkedin');
            var twitter = $(this).data('twitter');
            var description = $(this).data('description');

            var url = "{{route('about-us.update',[null])}}/" + id;
            $('#name').val(name);
            $('#short_description').val(short_description);
            $('#facebook').val(facebook);
            $('#instagram').val(instagram);
            $('#linkedin').val(linkedin);
            $('#twitter').val(twitter);
            CKEDITOR.instances['description'].setData(description)

            $('#form').attr('action', url);

        });
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });

    </script>
@endsection
