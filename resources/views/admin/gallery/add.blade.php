<?php
$route = route('gallery.store');
$caption = "";
$image = "";
$state = "Add";

if (isset($gallery) && sizeof($gallery->toArray())) {
    $route = route('gallery.update', $gallery->id);
    $caption = $gallery->caption;
    $image = $gallery->image;
    $state = "Edit";
}
?>


@extends('admin.app')

@section('title')
    {{ $state }} Gallery
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
                        <h3 class="box-title">{{$state}} Gallery</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" id="form" action="{{$route}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="box-body">
                            <div class="form-group">
                                <label for="caption">Caption</label>
                                <input type="text" class="form-control" id="caption" name="caption"
                                       placeholder="Enter caption" value="{{$caption}}" required>
                                @if ($errors->has('caption'))
                                    <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('caption') }}</strong>
                            </span>
                                @endif
                            </div>

                            <!-- This wraps the whole cropper -->
                            <div id="image-cropper">
                                <!-- This is where the preview image is displayed -->
                                <div class="cropit-preview"></div>

                                <!-- This range input controls zoom -->
                                <!-- You can add additional elements here, e.g. the image icons -->
                                <input type="range" class="cropit-image-zoom-input"/>

                                <!-- This is where user selects new image -->
                                <input type="file" name="image" id="image" class="cropit-image-input"
                                       src="{{url('uploads/category/1.jpg')}}"/>

                                <!-- The cropit- classes above are needed
                                     so cropit can identify these elements -->
                            </div>

                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    @include('includes.jquery_validation')
    <!-- /.content -->

@stop
@section('scripts')
    @include('includes.cropit')

    <script>
        $('form').validate()
    </script>
    <script>
        function readURL(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    //$('#preview').attr('src', e.target.result);
                    console.log($("#image"));
                    console.log(e.target.result);
                    $('#image').attr('src', e.target.result);
                    var image = document.getElementById('image');
                    var cropper = new Cropper(image, {
                        aspectRatio: 16 / 9,
                        viewMode: 2
                    });
                    //                    .cropper({
                    //                        aspectRatio: 16 / 9,
                    //                        crop: function(e) {
                    //                            console.log(e.detail.x);
                    //                            console.log(e.detail.y);
                    //                            console.log(e.detail.width);
                    //                            console.log(e.detail.height);
                    //                            console.log(e.detail.rotate);
                    //                            console.log(e.detail.scaleX);
                    //                            console.log(e.detail.scaleY);
                    //                        }
                    //                    });

                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $(".cropit-image-input").change(function () {
            readURL(this);
        });


    </script>

@stop

