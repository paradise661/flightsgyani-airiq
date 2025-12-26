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
                                    what we do </a>
                            </div>

                        </div>
                    </div>
                    <table id="dataTable" class="table table-hover" style="width: 100%">
                        <thead>
                        <tr>
                            <th>S NO.</th>
                            <th>Title</th>
                            <th>Descritpion</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($whatwedos)
                            @foreach($whatwedos as $key => $a)
                                <tr>

                                    <td>{{ $key +1 }}</td>
                                    <td>{{ $a->title}}</td>
                                    <td>{!!  $a->description ? \Illuminate\Support\Str::words($a->description, 50) :'' !!}
                                    </td>
                                    <td width="20%">
                                        <a href="#"
                                           class="btn-sm btn-primary contactEdit"
                                           data-id="{{$a->id}}"
                                           data-title="{{$a->title}}"
                                           data-description="{{$a->description}}"

                                        ><i class="fa fa-edit"></i> </a>
                                        {{--<a href="{{ route('category.show', $a->id) }}" class="btn-sm btn-info"><i--}}
                                        {{--class="fa fa-eye"></i> </a>--}}
                                        <a class='btn-sm btn-danger' data-toggle='tooltip' title='Delete'
                                           data-action='delete'
                                           href='{{route('whatwedo.delete')}}' data-id='{{$a->id}}'><i
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
                        <h5 class="modal-title" id="exampleModalLabel">What we Do?</h5>
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
                                    <textarea name="description" class="ckeditor" id="description">
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

    <script src="{{ URL::asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script src="{{ URL::asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>

    <script>

        $(document).on('click', '#addContact', function (e) {
            e.preventDefault();
            $('#formModal').modal('show');
            var url = "{{route('whatwedo.store')}}";
            $('#form').attr('action', url);
            $('#form').trigger('reset');

        });
        $(document).on('click', '.contactEdit', function (e) {
            e.preventDefault();
            $('#formModal').modal('show');
            var id = $(this).data('id');
            var url = "{{route('whatwedo.update',[null])}}/" + id;
            $('#form').attr('action', url);
            var title = $(this).data('title');
            var description = $(this).data('description');
            CKEDITOR.instances['description'].setData(description);

            $('#title').val(title);

        });
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });

    </script>
@endsection
