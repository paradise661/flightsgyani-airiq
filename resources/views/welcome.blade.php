@extends('layouts.front')

@section('body')
<!-- Hero Slider / Banner   -->
<div class="slider banner-slider relative hidden md:block">
    @if ($sliders->count() > 0)
    @foreach ($sliders as $slider)
    <div>
        <img class="object-cover w-full h-60 md:h-[611px]" src="{{ asset($slider->image) }}" alt="" />
    </div>
    @endforeach
    @else
    <div>
        <img class="object-cover w-full h-60 md:h-[611px]" src="{{ asset('frontend/images/default-slider.jpg') }}"
            alt="" />

        {{-- <img class="object-cover w-full h-60 md:h-[611px]"
            src="https://s3-np1.datahub.com.np/flightsgyani-artifacts/fianl_1.gif" alt="" /> --}}
    </div>
    @endif

</div>
<!-- / Hero Slider / Banner   -->
{{--
<div class="loader hide">
    <div class="loader-box">
        <h4 class="text-center"><strong class="px-4" id="sectors"></strong></h4>
        <div class="row">
            <div class="col-md-6">
                <div class="text-center bold">DEPARTURE DATE: <strong id="depart-date"></strong>
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-center bold hide">RETURN DATE: <strong id="return-date"></strong></div>
            </div>
        </div>
        <img src="{{ asset('frontend/images/search-loader.gif') }}" alt="gif" />
        <hr style="padding:0;border: 1px solid green;margin-bottom:0px;">
        <a href="#!"><img src="{{ asset('frontend/images/pop-up-ad-for-website.png') }}" alt=""
                style="width: -webkit-fill-available;"></a>
    </div>
</div> --}}

<!-- Banner -->
{{-- <section id="home_banner">
    <!-- Paradise Slider -->
    <div id="kenburns_061"
        class="carousel slide ps_indicators_txt_icon ps_control_txt_icon thumb_scroll_x swipe_x ps_easeOutQuart"
        data-ride="carousel" data-pause="hover" data-interval="5000" data-duration="1000">
        <!-- Wrapper For Slides -->
        <div class="carousel-inner" role="listbox">

            <!-- First Slide -->
            @foreach ($sliders as $slider)
            <div class="item {{ ($loop->iteration == 1)?'active':'' }}">
                <!-- Slide Background -->
                <img src="{{ $slider->image }}" alt="FlightsGyani" />

            </div><!-- /item -->
            @endforeach

        </div>
        <!-- End of Wrapper For Slides -->

        <!-- Left Control -->
        <a class="left carousel-control" href="#kenburns_061" role="button" data-slide="prev">
            &lt;
            <span class="sr-only">Previous</span>
        </a>

        <!-- Right Control -->
        <a class="right carousel-control" href="#kenburns_061" role="button" data-slide="next">
            &gt;
            <span class="sr-only">Next</span>
        </a>
    </div> <!-- End Paradise Slider -->
</section> --}}
<!-- Banner Ends -->

@include('front.includes.homepage.search')

{{-- <section class="bucket-list" data-ref="container-2">
    <div class="bucket-icons">
        <div class="container">
            <div class="section-title text-center">
                <h2>Popular Packages</h2>
                <div class="section-icon">
                    <i class="flaticon-diamond"></i>
                </div>
            </div>
            <div class="category-box">
                <ul class="post-category filtered popular">
                    @foreach ($locations as $location)
                    <li class="filter popular" data-filter=".{{ explode(' ',$location->title)[0] }}">
                        <span>{{ $location->title }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="bucket-content">
        <div class="container">
            @foreach ($locations as $location)
            <div class="row mix {{ explode(' ',$location->title)[0] }} ">
                @foreach ($specialPackages->where('category_id', $location->id) as $specialPackage)
                <div class="col-lg-4 col-md-6 col-sm-6 mt-4">
                    <div class="package-item">
                        <div class="package-image">
                            <a href="{{ $specialPackage->slug }}"> <img src="{{URL::to($specialPackage->image)}}"
                                    alt="Image"></a>
                            <div class="package-content">
                                <h4 class="text-center">{{ $specialPackage->title }}</h4>
                                <div class="text-center" style="padding-top: 10px;">
                                    <i class="fa fa-calendar" style="font-size: 18px;"></i>
                                </div>
                                <div class="text-center">
                                    {{$specialPackage->days}} Day{{($specialPackage->days > 1) ? 's' :'' }}
                                </div>
                                <div style="padding-top: 20px;">
                                    <h3 class="text-center" style="color: #01adef;">
                                        NPR {{number_format($specialPackage->price)}} /-</h3>
                                </div>
                            </div>
                        </div>

                        <div class="package-price">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-5 col-xs-5 text-center" style="padding: 8px;">
                                    @for ($i = 0; $i < $specialPackage->rating; $i++)
                                        <span class="fa fa-star checked"></span>
                                        @endfor
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-7 col-xs-7 text-center" style="padding: 8px;">

                                    <a href="{{ $specialPackage->slug }}" class="btn btn-green">View more
                                        details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Popular Packages Ends -->


<!-- Bucket Lists -->
<section>
    <div class="section-title text-center">
        <h2>Top up your Bucket List</h2>
        <div class="section-icon">
            <i class="flaticon-diamond"></i>
        </div>
    </div>
    <div class="container" style="padding: 15px; border: 1px solid #efefef;">
        <div class="row">
            <div class="col-lg-2">

                <div class="bucket-list" data-ref="container-1">
                    <div class="bucket-icons">
                        <div class="category-box">
                            <ul class="post-category nav nav-tabs">
                                <li class="filter active"><a href="#family" data-toggle="tab"><i
                                            class="flaticon-family"></i><span>Family</span></a>
                                </li>
                                <li class="filter"><a href="#honeymoon" data-toggle="tab"><i
                                            class="flaticon-sailboat"></i><span>Honeymoon</span></a></li>
                                <li class="filter"><a href="#corporate" data-toggle="tab"><i
                                            class="flaticon-bicycle"></i><span>Corporate</span></a></li>
                                <li class="filter"><a href="#group" data-toggle="tab"><i
                                            class="flaticon-family"></i><span>Group Tour</span></a>
                                </li>
                                <li class="filter"><a href="#cruise" data-toggle="tab"><i
                                            class="flaticon-sun-umbrella"></i><span>Cruise</span></a></li>
                                <li class="filter"><a href="#senior" data-toggle="tab"><i
                                            class="flaticon-man-in-hike"></i><span>Sr. Citizen</span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-10 border-left">
                <div class="bucket-content tab-content">
                    <div class="row tab-pane fade in active" id="family">
                        <div class="col-md-6">
                            @foreach ($families as $key => $data)
                            @if ($key < 3) <div class="bucket-item">
                                <div class="bucket-image">
                                    <a href="{{$data->slug}}"> <img src="{{URL::to($data->image)}}" alt="Image"></a>

                                </div>
                                <div class="bucket-item-content">
                                    <p><a href="{{$data->slug}}">{{$data->title}}</a></p>
                                    <p><span>{{$data->days}} Day{{($data->days > 1) ? 's' :'' }} </span></p>
                                    <p><span> NPR {{number_format($data->price)}} /- </span></p>
                                </div>
                        </div>
                        @endif
                        @endforeach

                    </div>

                    <div class="col-md-6">
                        @foreach ($families as $key => $data)
                        @if ($key >= 3)
                        <div class="bucket-item">
                            <div class="bucket-image">
                                <a href="{{$data->slug}}"> <img src="{{URL::to($data->image)}}" alt="Image"></a>

                            </div>
                            <div class="bucket-item-content">
                                <p><a href="{{$data->slug}}">{{$data->title}}</a></p>
                                <p><span>{{$data->days}} Day{{($data->days > 1) ? 's' :'' }} </span></p>
                                <p><span> NPR {{number_format($data->price)}} /- </span></p>
                            </div>
                        </div>
                        @endif
                        @endforeach


                    </div>
                </div>
                <div class="row tab-pane fade" id="honeymoon">
                    <div class="col-md-6">
                        @foreach ($honeymoon as $key => $data)
                        @if ($key < 3) <div class="bucket-item">
                            <div class="bucket-image">
                                <a href="{{$data->slug}}"> <img src="{{URL::to($data->image)}}" alt="Image"></a>

                            </div>
                            <div class="bucket-item-content">
                                <p><a href="{{$data->slug}}">{{$data->title}}</a></p>
                                <span>{{$data->days}} Day{{($data->days > 1) ? 's' :'' }} </span><span> NPR
                                    {{number_format($data->price)}} /- </span>
                            </div>
                    </div>
                    @endif
                    @endforeach
                </div>

                <div class="col-md-6">
                    @foreach ($honeymoon as $key => $data)
                    @if ($key >= 3)
                    <div class="bucket-item">
                        <div class="bucket-image">
                            <a href="{{$data->slug}}"> <img src="{{URL::to($data->image)}}" alt="Image"></a>

                        </div>
                        <div class="bucket-item-content">
                            <p><a href="{{$data->slug}}">{{$data->title}}</a></p>
                            <span>{{$data->days}} Day{{($data->days > 1) ? 's' :'' }} </span><span> NPR
                                {{number_format($data->price)}} /- </span>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
            <div class="row tab-pane fade" id="corporate">
                <div class="col-md-6">
                    @foreach ($corporate as $key => $data)
                    @if ($key < 3) <div class="bucket-item">
                        <div class="bucket-image">
                            <a href="{{$data->slug}}"> <img src="{{URL::to($data->image)}}" alt="Image"></a>

                        </div>
                        <div class="bucket-item-content">
                            <p><a href="{{$data->slug}}">{{$data->title}}</a></p>
                            <span>{{$data->days}} Day{{($data->days > 1) ? 's' :'' }}</span><span>NPR
                                {{number_format($data->price)}} /- </span>
                        </div>
                </div>
                @endif
                @endforeach
            </div>

            <div class="col-md-6">
                @foreach ($corporate as $key => $data)
                @if ($key >= 3)
                <div class="bucket-item">
                    <div class="bucket-image">
                        <a href="{{$data->slug}}"> <img src="{{URL::to($data->image)}}" alt="Image"></a>

                    </div>
                    <div class="bucket-item-content">
                        <p><a href="{{$data->slug}}">{{$data->title}}</a></p>
                        <span>{{$data->days}} Day{{($data->days > 1) ? 's' :'' }}</span><span>NPR
                            {{number_format($data->price)}} /- </span>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
        <div class="row tab-pane fade" id="group">
            <div class="col-md-6">
                @foreach ($groupTours as $key => $data)
                @if ($key < 3) <div class="bucket-item">
                    <div class="bucket-image">
                        <a href="{{$data->slug}}"> <img src="{{URL::to($data->image)}}" alt="Image"></a>

                    </div>
                    <div class="bucket-item-content">
                        <p><a href="{{$data->slug}}">{{$data->title}}</a></p>
                        <span>{{$data->days}} Day{{($data->days > 1) ? 's' :'' }}</span><span>NPR
                            {{number_format($data->price)}} /- </span>
                    </div>
            </div>
            @endif
            @endforeach
        </div>

        <div class="col-md-6">
            @foreach ($groupTours as $key => $data)
            @if ($key >= 3)
            <div class="bucket-item">
                <div class="bucket-image">
                    <a href="{{$data->slug}}"> <img src="{{URL::to($data->image)}}" alt="Image"></a>

                </div>
                <div class="bucket-item-content">
                    <p><a href="{{$data->slug}}">{{$data->title}}</a></p>
                    <span>{{$data->days}} Day{{($data->days > 1) ? 's' :'' }}</span><span>NPR
                        {{number_format($data->price)}} /- </span>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
    <div class="row tab-pane fade" id="cruise">
        <div class="col-md-6">
            @foreach ($cruise as $key => $data)
            @if ($key < 3) <div class="bucket-item">
                <div class="bucket-image">
                    <a href="{{$data->slug}}"> <img src="{{URL::to($data->image)}}" alt="Image"></a>

                </div>
                <div class="bucket-item-content">
                    <p><a href="{{$data->slug}}">{{$data->title}}</a></p>
                    <span>{{$data->days}} Day{{($data->days > 1) ? 's' :'' }}</span><span>NPR
                        {{number_format($data->price)}} /- </span>
                </div>
        </div>
        @endif
        @endforeach
    </div>

    <div class="col-md-6">
        @foreach ($cruise as $key => $data)
        @if ($key >= 3)
        <div class="bucket-item">
            <div class="bucket-image">
                <a href="{{$data->slug}}"> <img src="{{URL::to($data->image)}}" alt="Image"></a>

            </div>
            <div class="bucket-item-content">
                <p><a href="{{$data->slug}}">{{$data->title}}</a></p>
                <span>{{$data->days}} Day{{($data->days > 1) ? 's' :'' }}</span><span>NPR
                    {{number_format($data->price)}} /- </span>
            </div>
        </div>
        @endif
        @endforeach
    </div>
    </div>
    <div class="row tab-pane fade" id="senior">
        <div class="col-md-6">
            @foreach ($srcitizen as $key => $data)
            @if ($key < 3) <div class="bucket-item">
                <div class="bucket-image">
                    <a href="{{$data->slug}}"> <img src="{{URL::to($data->image)}}" alt="Image"></a>

                </div>
                <div class="bucket-item-content">
                    <p><a href="{{$data->slug}}">{{$data->title}}</a></p>
                    <span>{{$data->days}} Day{{($data->days > 1) ? 's' :'' }}</span><span>NPR
                        {{number_format($data->price)}} /- </span>
                </div>
        </div>
        @endif
        @endforeach
    </div>

    <div class="col-md-6">
        @foreach ($srcitizen as $key => $data)
        @if ($key >= 3)
        <div class="bucket-item">
            <div class="bucket-image">
                <a href="{{$data->slug}}"> <img src="{{URL::to($data->image)}}" alt="Image"></a>

            </div>
            <div class="bucket-item-content">
                <p><a href="{{$data->slug}}">{{$data->title}}</a></p>
                <span>{{$data->days}} Day{{($data->days > 1) ? 's' :'' }}</span><span>NPR
                    {{number_format($data->price)}} /- </span>
            </div>
        </div>
        @endif
        @endforeach
    </div>
    </div>
    </div>

    </div>
    </div>
    </div>
</section>
<!-- Bucket Lists Ends -->

<!-- Blog -->
<section class="blog" id="blog">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title text-center">
                    <h2>Our Blog</h2>
                    <div class="section-icon">
                        <i class="flaticon-diamond"></i>
                    </div>
                </div>
            </div>
            @foreach ($blogs as $blog)
            <div class="col-sm-4 col-xs-12">
                <div class="blog-item">
                    <div class="blog-image">
                        <a href="{{route('frontend.blog.detail',$blog->title)}}">
                            <img src="{{URL::to($blog->image)}}" alt="Image"></a>
                    </div>
                    <div class="blog-content text-justify">
                        <h3>
                            <a href="{{route('frontend.blog.detail',$blog->title)}}">{{$blog->title}}</a>
                        </h3>
                        <div class="blog-date">
                            <span class="blog-date"><a href="#">{{$blog->created_at}}</a></span>
                            <span class="pull-right">


                            </span>
                        </div>
                        {!! $blog->description ? \Illuminate\Support\Str::words($blog->description, 40) :'' !!}
                        <br><br>
                        <a href="{{route('frontend.blog.detail',$blog->title)}}" class="btn btn-danger">Read More</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section> --}}

<!-- Testimonials -->
{{-- <section class="testimonials">
    <div class="container">
        <div class="clients-slider owl-carousel">
            @foreach ($travelAgencies as $key => $t)
            <div class="item">
                <img src="{{URL::to($t->image)}}" alt="" class="client-img">
                <h4 class="text-center">{{$t->name}}</h4>
                <p class="text-center">
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                </p>
                <div class="quotebox">
                    <img src="{{ asset('frontend/images/quotebox.png') }}" alt=""
                        class="quotebox-img img img-responsive">
                    <div class="client-review text-center">
                        {!! $t->quote !!}
                    </div>
                </div>
            </div>
            @endforeach


        </div>
    </div>
</section> --}}
<!-- Testimonials -->
{{-- @if (isset($site->homepage_popup_status) && isset($site->homepage_popup))
<div class="modal" id="popup-ad" tabindex="-1" role="dialog" aria-labelledby="call-action" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <button type="button" data-dismiss="modal" aria-label="Close" style=" position: absolute;
                top: -3%;
                z-index: 9999999;
                left: 99%;
                background: #ed2028;
                color: white;
                padding: 1px 8px 1px 8px;

                border-radius: 100px;">
                x
            </button>

            <div class="modal-body" style="padding: 0px;">
                <img src="{{ $site->homepage_popup }}" alt="FlightsGyani">
            </div>
        </div>
    </div>
</div>
@endif --}}
<div class="overlay hide_me">

</div>
@endsection
@section('scripts')
<script type="text/javascript">
    @if (isset($site->homepage_popup_status) && isset($site->homepage_popup))
            $('#popup-ad').modal().show();
        @endif
        /**
         * default validation configs, can be override in specifc view blades
         */
        $.validator.setDefaults({
            errorClass: 'help-block with-errors',
            errorElement: 'div',
            /*//        onkeyup: function (element) {
            //            $(element).valid();
            //        },*/
            onfocusout: function(element) {
                $(element).valid();
            },
            highlight: function(element, errorClass, validClass) {
                //console.log('hee');
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).closest('.form-group').removeClass('has-error');
                $(element).closest('.form-group').find('.help-block').hide();
            },
            errorPlacement: function(error, element) {
                $(element).closest('.form-group').append(error);
            },
        });
</script>
<style>
    .help-block.with-errors {
        color: #EF6F6C;
    }
</style>

<script>
    $(".clients-slider").owlCarousel({
            items: 1,
            loop: true,
            nav: false,
            autoplay: true,
            autoplayHoverPause: true
        });


        $('#swap').on('click', function() {
            if ($("#intOrigin").val() || $("#intDestination").val()) {
                var e = $("#intOrigin").val();
                $("#intOrigin").val($("#intDestination").val()),
                    $("#intDestination").val(e),
                    $("#intOrigin").closest(".widget__input"),
                    $("#intDestination").closest(".widget__input")
            } else;
            $("#intOrigin").val() && $("#intDestination").val() ? ($(this).find('#swapicon').toggleClass("rotate"),
                $("#intOrigin").closest(".widget__input").addClass("is-active"),
                $("#intDestination").closest(".widget__input").addClass("is-active")) : $(this).find(
                '#swapicon').toggleClass("rotate")
        })

        $('#one-way-radio').on('click', function() {

            // console.log('sdasdsadasd');
            $('input[name="type"]').val('O');
            $('.radio-buttons').removeClass('active');
            $(this).addClass('active');

            $('#ret_date_div input').removeAttr('required');
            $('#ret_date_div').addClass('hide');
            $('#parent-multi-city').addClass('hide');
            $('#multiCityForm').addClass('hide');
            $('.add-more-btn').addClass('hide');
            $('#search_box').find('#swap').removeClass('hide');
            $('#search_box').find('#dep_date_div').addClass('col-lg-12 col-sm-12 col-md-12');
            $('#search_box').find('#dep_date_div').removeClass('col-lg-6 col-sm-6 col-md-6');
            $('#search_box').find('#ret_date_div').addClass('col-lg-12');
            $('#search_box').find('#ret_date_div').removeClass('col-lg-6');
            $('#search_box').find('#nationality_div').addClass('col-lg-12');
            $('#search_box').find('#nationality_div').removeClass('col-lg-6');

        });
        $('#two-way-radio').on('click', function() {

            $('input[name="type"]').val('R');
            $('.radio-buttons').removeClass('active');
            $(this).addClass('active');

            // console.log('sdasdsadasd');
            $('#ret_date_div input').attr('required', 'required');
            $('#ret_date_div').removeClass('hide');
            $('#parent-multi-city').addClass('hide');
            $('#multiCityForm').addClass('hide');
            $('.add-more-btn').addClass('hide');
            $('#search_box').find('#swap').removeClass('hide');
            $('#search_box').find('#dep_date_div').removeClass('col-lg-12 col-md-12');
            $('#search_box').find('#dep_date_div').addClass('col-lg-6 col-md-6 col-sm-6');
            $('#search_box').find('#ret_date_div').removeClass('col-lg-12');
            $('#search_box').find('#ret_date_div').addClass('col-lg-6');
            {{--  $('#search_box').find('#nationality_div').removeClass('col-lg-12');
            $('#search_box').find('#nationality_div').addClass('col-lg-6');  --}}


        });
        $('#multi-city-radio').on('click', function(e) {
            $('input[name="type"]').val('M');
            $('.radio-buttons').removeClass('active');

            $(this).addClass('active');

            // console.log('sdasdsadasd');
            $('#ret_date_div input').removeAttr('required');
            $('#ret_date_div').addClass('hide');
            $('#dep_date_div').removeClass('')
            $('#parent-multi-city').removeClass('hide');
            $('#multiCityForm').removeClass('hide');
            $('.add-more-btn').removeClass('hide');
            $('#search_box').find('#swap').addClass('hide');
            $('#search_box').find('#ret_date_div').removeClass('col-lg-2');
            $('#search_box').find('#dep_date_div').addClass('col-lg-12 col-sm-12 col-md-12');
            $('#search_box').find('#dep_date_div').removeClass('col-lg-6 col-sm-6 col-md-6');


        });

        var i = 0;

        function duplicate() {

            if (i < 3) {
                var displayedCopy = $('#multiCityForm').find('#multi-city-input' + ++i);
                displayedCopy.removeClass('hide');
                displayedCopy.find('.takeoff').attr({
                    'name': 'int_multi_from[]',
                    'required': 'required'
                });
                displayedCopy.find('.landing').attr({
                    'name': 'int_multi_to[]',
                    'required': 'required'
                });
                displayedCopy.find('.datepicker').attr({
                    'name': 'int_multi_departure[]',
                    'required': 'required'
                });

            }
            if (i === 3) {
                $('.close.add-more').addClass('hide');
            }
        }

        function hideMultiCity(elem) {
            $(elem).parents('.multi-city-area').addClass('hide');
            $(elem).parents('.multi-city-area').find('.takeoff').removeAttr('name required');
            $(elem).parents('.multi-city-area').find('.landing').removeAttr('name required');
            $(elem).parents('.multi-city-area').find('.datepicker').removeAttr('name required');
            --i;
            checkValueOfI();
        }

        function checkValueOfI() {
            if (i < 3) {
                console.log(i);
                $('.close.add-more').removeClass('hide');
            }
        }


        $('#search_box').validate({
            errorPlacement: function() {
                return false; // suppresses error message text
            }
        });
        $('#homepage_search_btn').on('click', function() {



            if ($('#search_box').valid()) {



                var searchType = $('input[name="type"]').val();
                if (searchType === 'O' || searchType === 'R') {




                    $('#sectors').html($('#intOrigin').val().split('-', 1) + ' <i class="fa fa-fighter-jet"></i> ' +
                        $('#intDestination').val().split('-', 1));



                    $('#depart-date').html($('#dep_date').val());
                    if (searchType === 'O') {
                        $('#depart-date').closest('.col-md-6').removeClass('col-md-6').addClass('col-md-12');
                    }

                    if (searchType === 'R') {






                        $('#sectors').html($('#dep_from').val().split('-', 1) +
                            ' <i class="fa fa-fighter-jet"></i> ' + $('#arr_to').val().split('-', 1) +
                            ' <i class="fa fa-fighter-jet"></i> ' + $('#dep_from').val().split('-', 1));
                        $('#return-date').parent('.text-center').removeClass('hide');
                        $('#return-date').html($('#ret_date').val());
                    }
                } else if (searchType === 'M') {


                    $('#sectors').removeClass('px-4');
                    $('#depart-date').closest('div').hide();

                    function transpose(a) {
                        return Object.keys(a[0]).map(function(c) {
                            return a.map(function(r) {
                                return r[c];
                            });
                        });
                    }



                    $('#depart-date').closest('p').hide();
                    var sectors = ' ' + $('#dep_from').val().split('-', 1) + ' ' +
                        '  <i class="fa fa-fighter-jet"></i>  ' + ' ' + $('#arr_to').val().split('-', 1) + ' ' +
                        '  <i class="fa fa-calendar"></i>  ' + ' ' + $('#dep_date').val() + ' ' + '<br>';
                    var multiSectors = [];
                    var multiFroms = (function() {
                        var multiFrom = [];
                        $('input[name="int_multi_from[]').each(function() {
                            multiFrom.push($(this).val().split('-', 1));
                        });
                        return multiFrom;
                    })();
                    multiSectors.push(multiFroms);
                    var multiTos = (function() {
                        var multiTo = [];
                        $('input[name="int_multi_to[]"]').each(function() {
                            multiTo.push($(this).val().split('-', 1));
                        });
                        return multiTo;
                    })();
                    multiSectors.push(multiTos);
                    var multiDepartures = (function() {
                        var multiDeparture = [];
                        $('input[name="int_multi_departure[]"]').each(function() {
                            multiDeparture.push($(this).val());
                        });
                        return multiDeparture;
                    })();
                    multiSectors.push(multiDepartures);
                    console.log(multiSectors);
                    var tMultiSectors = transpose(multiSectors);
                    console.log(tMultiSectors);
                    tMultiSectors.forEach(function(item, index) {

                        singleSector = item.toString().split(',');
                        sectors += ' ' + singleSector[0] + ' ' + '  <i class="fa fa-fighter-jet"></i>  ' +
                            ' ' + singleSector[1] + ' ' + '  <i class="fa fa-calendar"></i>  ' + ' ' +
                            singleSector[2] + ' ' + '<br>';
                    })

                    $('#sectors').html(sectors);
                }


                $('.loader').removeClass('hide');


            }

        });
</script>

<script>
    var themesEl2 = document.querySelector('[data-ref="container-2"]');


        var config = {
            controls: {
                scope: 'local'
            }
        };

        var mixer2 = mixitup(themesEl2, config);

        jQuery('ul.post-category li:first-child').trigger('click');

        //jQuery for page scrolling feature - requires jQuery Easing plugin
        $(document).on('click', 'a.page-scroll', function(event) {
            var $anchor = $(this);
            $('html, body').stop().animate({
                scrollTop: $($anchor.attr('href')).offset().top
            }, 1500, 'easeInOutExpo');
            event.preventDefault();
        });


        $('.popup-search-form>div>input').each(function() {
            $(this).number();
        });
</script>
<script>
    function valueTransfer(elem) {

            switch ($(elem).attr('id')) {
                case "int_to":
                    var value = $(elem).val();
                    $('#multi_from1').val(value);
                    break;
                case "multi_to1":
                    var value = $(elem).val();
                    $('#multi_from2').val(value);
                    break;
                case "multi_to2":
                    var value = $(elem).val();
                    $('#multi_from3').val(value);
                    break;
                case "multi_to3":
                    var value = $(elem).val();
                    $('#multi_from4').val(value);
                    break;
                default:
                    // statements_def
                    break;
            }
        }
</script>
@endsection