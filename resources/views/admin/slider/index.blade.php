@extends('layouts.back')

@section('title', 'Slider')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(session('warning'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ session('warning') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

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
                                    Slider </a>
                            </div>
                            @if($errors->has('image'))
                                <span class="error">
                                    {{ $errors->first('image') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <table id="dataTable" class="table table-hover" style="width: 100%">
                        <thead>
                        <tr>
                            <th>S NO.</th>
                            <th>image</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($sliders)
                            @forelse($sliders as  $slider)
                                <tr>

                                    <td>{{ $loop->iteration }}</td>


                                    <td><img src="{{$slider->image}}" class="img img-responsive" width="200"
                                             height="100"></td>
                                    <td>

                                        <a class='btn-sm btn-danger' data-toggle='tooltip' title='Delete'
                                           data-action='delete'
                                           href='{{route('slider.delete')}}' data-id='{{$slider->id}}'><i
                                                class="fa fa-trash"></i> </a>


                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-danger">No records found.</td>
                                </tr>
                            @endforelse
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
                        <h5 class="modal-title" id="exampleModalLabel">Slider</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="form" enctype="multipart/form-data" method="post">
                            {{csrf_field()}}
                            <div class="row">


                                <div class="form-group">
                                    <div class="input-group">
                                       <span class="input-group-btn">
                                         <a id="lfm" data-input="thumbnail" data-preview="holder"
                                            class="btn btn-primary">
                                           <i class="fa fa-picture-o"></i> Choose
                                         </a>
                                       </span>
                                        <input id="thumbnail" class="form-control" type="text" name="image">
                                    </div>
                                    <img id="holder" style="margin-top:15px;max-height:100px;">
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

    <script src="{{ asset('/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script>
        $('#lfm').filemanager('image', {prefix: '/admin/filemanager'});
        $(document).on('click', '#addContact', function (e) {
            e.preventDefault();
            $('#formModal').modal('show');
            var url = "{{route('slider.store')}}";
            $('#form').attr('action', url);

        });


    </script>
@endsection
