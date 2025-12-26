@extends('layouts.back')

@section('title', 'Category')

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
                                <a class="btn btn-primary pull-right" href="#" id="addCategory"> Add
                                    Category </a>
                            </div>

                        </div>
                    </div>
                    <table id="dataTable" class="table table-hover" style="width: 100%">
                        <thead>
                        <tr>
                            <th>S NO.</th>
                            <th>Title</th>
                            <th>slug</th>
                            <th>Type</th>
                            <th>Parent</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($categories)
                            @foreach($categories as $key => $category)
                                <tr>

                                    <td>{{ $key+++1 }}</td>
                                    <td>{{ $category->title }}</td>
                                    <td>{{ $category->slug }}</td>
                                    <td>{{ $category->type == 0 ?'Domestic':'International' }}</td>
                                    <td>{{ $category->parent ? $category->parent->title : 'N/A' }}</td>
                                    <td width="20%">
                                        <a href="#"
                                           class="btn-sm btn-primary categoryEdit"
                                           data-id="{{$category->id}}"
                                           data-title="{{$category->title}}"
                                           data-slug="{{$category->slug}}"
                                           data-type="{{$category->type}}"
                                           data-parentid="{{$category->parent_id}}"
                                        ><i class="fa fa-edit"></i> </a>
{{--                                        <a href="{{ route('category.show', $category->id) }}" class="btn-sm btn-info"><i--}}
{{--                                                class="fa fa-eye"></i> </a>--}}
                                        <a class='btn-sm btn-danger' data-toggle='tooltip' title='Delete'
                                           data-action='delete'
                                           href='{{route('category.delete')}}' data-id='{{$category->id}}'><i
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

        @if($categories)
            <!-- Modal -->
            <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><span id="addEdit"></span>Category</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="form" enctype="multipart/form-data" method="post">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" id="title"
                                           placeholder="Enter Title" required>
                                </div>
                                <div class="form-group">
                                    <label for="slug">Slug</label>
                                    <input type="text" class="form-control" id="slug" name="slug"
                                           placeholder="Enter slug" readonly required>
                                </div>
                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <select class="form-control" name="type" id="type">
                                        <option value="0">Domestic</option>
                                        <option value="1">International</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="category">Parent</label>
                                    <select class="form-control" name="parent_id" id="parentId">
                                        <option value=""> No Parent</option>
                                        @foreach($parentCategories as $category)
                                            <option value="{{$category->id}}">{{$category->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </section>

@stop

@section('scripts')
    <script>
        $(document).on('click', '#addCategory', function (e) {
            e.preventDefault();
            $('#formModal').modal('show');
            var url = "{{route('category.store')}}";
            $('#form').attr('action', url);

        });
        $(document).on('click', '.categoryEdit', function (e) {
            e.preventDefault();
            $('#formModal').modal('show');
            var id = $(this).data('id');
            var title = $(this).data('title');
            var parent_id = $(this).data('parentid');
            var type = $(this).data('type');
            var slug = $(this).data('slug');
            var url = "{{route('category.update',[null])}}/" + id;
            $('#title').val(title);
            $('#type').val(type);
            $('#parentId').val(parent_id);
            $('#slug').val(slug);
            $('#form').attr('action', url);

        });
        $(document).ready(function () {
            $('#dataTable').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'colvis']
            });
        });
        $(function () {
            $('#title').keyup(function () {
                var title = $(this).val();
                if (title === '') {
                    return;
                }
//                $('#h1_title').val(title);

                title = title.toLowerCase();
                title = title.replace(/[^a-z0-9 ]+/g, '');
                title = title.replace('  ', ' ');

                var url = title.replace(/\s/g, '-');
                $('#slug').val(url);
            });
        });
    </script>
@endsection

