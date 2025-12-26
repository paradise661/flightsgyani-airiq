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
                                <a class="btn btn-primary pull-right" href="{{route('package.add')}}"> Add
                                    Package </a>
                            </div>

                        </div>
                    </div>
                    <table id="dataTable" class="table table-hover" style="width: 100%">
                        <thead>
                        <tr>
                            <th>S NO.</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($packages)
                            @foreach($packages as $key => $package)
                                <tr>

                                    <td>{{ $key+++1 }}</td>
                                    <td>{{ $package->title }}</td>
                                    <td>{!!  $package->description ? \Illuminate\Support\Str::words($package->description, 26) :'' !!}</td>
                                    <td width="20%">
                                        <a href="{{route('package.edit',$package->id)}}"
                                           class="btn-sm btn-primary categoryEdit"

                                        ><i class="fa fa-edit"></i> </a>
                                        <a href="{{ route('package.show', $package->id) }}" class="btn-sm btn-info"><i
                                                class="fa fa-eye"></i> </a>
                                        <a href="{{ route('admin.package.download', $package->id) }}"
                                           class="btn-sm btn-secondary"><i
                                                class="fa fa-download"></i> </a>
                                        <a class='btn-sm btn-danger' data-toggle='tooltip' title='Delete'
                                           data-action='delete'
                                           href='{{route('package.delete')}}' data-id='{{$package->id}}'><i
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
                                <label for="description"> Description</label>
                                <textarea class="form-control" name="description" id="description" rows="3"></textarea>
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
    </section>
@stop

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>
@endsection
