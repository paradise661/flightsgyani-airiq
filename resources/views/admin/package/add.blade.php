<?php
$route = route('package.store');
$title = "";
$type = 0;
$image = "";
$deals_on_sale = "normal";
$popular_package = 0;
$key_words = '';
$special_package = 0;
$plan = 0;
$discount = 0;
$rating = 0;
$start_date = '';
$days = '';
$end_date = '';
$slug = "";
$price = "";
$description = "";
$packageId = "";
$categoryId = "";
$type = "";
$destination = "";
$rank = "";
$status = "";
$slider = "";
$state = "Add";

if (isset($package) && sizeof($package->toArray())) {
    $route = route('package.update', $package->id);
    $title = $package->title;
    $image = $package->image;
    $type = $package->type;
    $slug = $package->slug;
    $end_date = $package->end_date;
    $start_date = $package->start_date;
    $popular_package = $package->popular_package;
    $special_package = $package->special_package;
    $discount = $package->discount;
    $deals_on_sale = $package->deals_on_sale;
    $rating = $package->rating;
    $description = $package->description;
    $packageId = $package->parent_id;
    $price = $package->price;
    $key_words = $package->key_words;
    $plan = $package->plan;
    $destination = $package->destination;
    $categoryId = $package->category_id;
    $days = $package->days;
    $rank = $package->rank;
    $status = $package->status;
    $slider = $package->slider;
    $state = "Edit";
}
if (isset($errors) && sizeof($errors)) {
    $title = old('title');
    $type = old('type');
    $slug = old('slug');
    $end_date = old('end_date');
    $start_date = old('start_date');
    $popular_package = old('popular_package');
    $special_package = old('special_package');
    $discount = old('discount');
    $deals_on_sale = old('deals_on_sale');
    $rating = old('rating');
    $price = old('price');
}

?>


@extends('layouts.back')

@section('title', 'Package')

@section('content')

    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Package</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="form" action="{{$route}}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-4">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title"
                                       placeholder="Enter title" value="{{$title}}" required>
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('title') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="slug">Slug</label>
                                <input type="text" class="form-control" id="slug" name="slug"
                                       placeholder="Enter slug" value="{{$slug}}" readonly required>
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('slug') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="deals_on_sale">Deals on sale</label>
                                <select class="form-control" name="deals_on_sale">
                                    <option value="normal" {{$deals_on_sale == 'normal'?'selected':''}}>Normal</option>
                                    <option value="hot_deals" {{$deals_on_sale == 'hot_deals'?'selected':''}}>Hot
                                        Deals
                                    </option>
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <label for="discount">Discount(%)</label>
                                <input type="number" class="form-control" id="discount" name="discount"
                                       placeholder="Enter Discount" value="{{$discount}}" required>
                                @if ($errors->has('discount'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('discount') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="price">Price</label>
                                <input type="number" class="form-control" id="price" name="price"
                                       placeholder="Enter Price" value="{{$price}}" required>
                                @if ($errors->has('price'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('price') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="category">Category</label>
                                <select class="form-control" name="category_id">
                                    @foreach($categories as $category)
                                        <option
                                            value="{{$category->id}}" {{($categoryId == $category->id)?'selected':''}}>{{$category->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <label for="popular_package">Popular Package</label>
                                <select class="form-control" name="popular_package">
                                    <option value="0" {{$popular_package == 0? 'selected':''}}>NO</option>
                                    <option value="1" {{$popular_package == 1? 'selected':''}}>YES</option>
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <label for="start_date">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date"
                                       placeholder="Enter Start Date" value="{{$start_date}}">
                                @if ($errors->has('start_date'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('start_date') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="end_date">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date"
                                       placeholder="Enter End Date" value="{{$end_date}}">
                                @if ($errors->has('end_date'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('end_date') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group col-4">
                                <label for="days">Days</label>
                                <input type="number" class="form-control" id="days" name="days"
                                       placeholder="Enter Days" value="{{$days}}">
                                @if ($errors->has('days'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('days') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="rating">Rating</label>
                                <input type="number" class="form-control" id="rating" name="rating"
                                       placeholder="Enter Rating" value="{{$rating}}">
                                @if ($errors->has('rating'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('rating') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="special_package">Special Package</label>
                                <select class="form-control" name="special_package">
                                    <option value="0" {{$special_package == 0? 'selected':''}}>NO</option>
                                    <option value="1" {{$special_package == 1? 'selected':''}}>YES</option>
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <label for="plan">Plan</label>
                                <select class="form-control" name="plan">
                                    <option value="Family" {{$plan == 'Family'? 'selected':''}}>Family</option>
                                    <option value="Honeymoon" {{$plan == 'Honeymoon'? 'selected':''}}>Honeymoon</option>
                                    <option value="Corporate" {{$plan == 'Corporate'? 'selected':''}}>Corporate</option>
                                    <option value="Group Tours" {{$plan == 'Group Tours'? 'selected':''}}>Group Tours
                                    </option>
                                    <option value="Cruise" {{$plan == 'Cruise'? 'selected':''}}>Cruise</option>
                                    <option value="Sr Citizen" {{$plan == 'Sr Citizen'? 'selected':''}}>Sr Citizen
                                    </option>
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <label for="destination">Destination</label>
                                <input type="text" class="form-control" id="destination" name="destination"
                                       placeholder="Enter Destination" value="{{$destination}}">
                                @if ($errors->has('destination'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('destination') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="status">Status </label>
                                <select class="form-control" name="status">
                                    <option value="1" {{$status == 1? 'selected':''}}>ON</option>
                                    <option value="0" {{$status == 0? 'selected':''}}>OFF</option>
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <label for="rank">Rank</label>
                                <input type="number" class="form-control" id="rank" name="rank"
                                       placeholder="Enter Rank" value="{{$days}}">
                                @if ($errors->has('rank'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('rank') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group col-4">
                                <label for="status">Slider</label>
                                <select class="form-control" name="slider">
                                    <option value="0" {{$slider == 0? 'selected':''}}>OFF</option>
                                    <option value="1" {{$slider == 1? 'selected':''}}>ON</option>
                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="description">Key Words</label>
                            <textarea name="key_words" class="form-control">{{$key_words}}
                                </textarea>
                            @if ($errors->has('home'))
                                <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('description') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="ckeditor">{{$description}}
                                </textarea>
                            @if ($errors->has('home'))
                                <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('description') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="Image">Image</label>

                            <input type="file" id="imageFile" class="form-control" placeholder="Image"
                                   name="image" data-ratio="16" data-ratiowidth="9"
                                   @if(empty($image)) required @endif>

                            <div id="previewWrapper" class="hidden">
                                <br>
                                <img id="croppedImagePreview" height="150"><br>
                                <input type="hidden" name="inputCroppedPic" id="inputCroppedPic" tabindex="-1">
                                <button class="col-sm-offset-2 col-xs-offset-4 btn btn-danger btn-sm" type="button"
                                        id="removeCroppedImage" style="margin-top: 7px;">Remove
                                </button>
                            </div>
                            @if(!empty($image))
                                <img src="{{url($image)}}" style="width: 20%;">
                            @endif

                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
                <div class="modal" id="imageCropperModal">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content ">
                            <div class="modal-header">
                                <button type="button" class="close" style="margin-top: 5px!important; font-size: 25px;"
                                        data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <img id="cropImgSrc" class="h400">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel
                                </button>
                                <button type="button" class="btn btn-primary button saveImage" id="saveCroppedImg">Save
                                    changes
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- /.content -->

@endsection
@section('scripts')
    @include('admin.partials.jquery_validation')

    @include('admin.partials.cropperjs')
    <script src="{{ URL::asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script src="{{ URL::asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>

    <script>
        function readURL(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#preview').attr('src', e.target.result);
                    $('#preview').show();

                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function () {
            readURL(this);
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

