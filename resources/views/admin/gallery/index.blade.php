@extends('admin.app')
@section('title')
    Add Gallery
@stop
@section('body')
    <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->

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
                                <h3 class="box-title">Gallery</h3>
                            </div>
                            <div class="col-lg-6">
                                <a class="btn btn-default pull-right" href="{{route('gallery.add')}}"> Add Gallery </a>
                            </div>

                        </div>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>S. NO</th>
                            <th>Caption</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($galleries as $key=>$gallery)
                            <tr>
                                <td>
                                    {{$key+1}}
                                </td>
                                <td>
                                    {{$gallery->caption}}
                                </td>
                                <td>
                                    <a class="btn btn-info" href="#">View</a>
                                    <a class="btn btn-primary" href="{{route('gallery.edit',$gallery->id)}}">Edit</a>
                                    <a class='btn btn-danger' data-toggle='tooltip' title='Delete' data-action='delete'
                                       href="{{route('gallery.delete')}}" data-id="{{$gallery->id}}">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    @include('includes.sweatalert')
    <script>
        $(document).on('delete.success', function () {
            location.reload();
        })
    </script>
    <!-- /.content -->

@stop

