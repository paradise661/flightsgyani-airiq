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
                            <th>Blog</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Website</th>
                            <th>Descritpion</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($comments)
                            @foreach($comments as $key => $a)
                                <tr>

                                    <td>{{ $key +1 }}</td>
                                    <td>{{ $a->blog ? $a->blog->title :'' }}</td>
                                    <td>{{ $a->name }}</td>
                                    <td>{{ $a->email }}</td>
                                    <td>{{ $a->website }}</td>
                                    <td>{!!  $a->comment ? \Illuminate\Support\Str::words($a->comment, 50) :'' !!}
                                    </td>
                                    <td width="20%">
                                        <a href="#" class="btn-sm btn-info" id="commentView"
                                           data-comment="{{$a->comment}}"><i class="fa fa-eye"></i></a>

                                        <a class='btn-sm btn-danger' data-toggle='tooltip' title='Delete'
                                           data-action='delete'
                                           href='{{route('comment.delete')}}' data-id='{{$a->id}}'><i
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
    </section>

@stop

@section('scripts')
    @include('admin.partials.jquery_validation')
    @include('admin.partials.cropperjs')
    <script>
        $(document).on('click', '#commentView', function (e) {
            e.preventDefault();
            alert($(this).data('comment'))
        });

        $(document).ready(function () {
            $('#dataTable').DataTable();
        });

    </script>
@endsection
