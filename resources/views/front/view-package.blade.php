@php
    $route = Request::route()->getName();
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
@endphp

@extends('layouts.front')
@section('meta')
    <meta property="og:url" content="{{$actual_link}}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="{{$package->title}}"/>
    <meta property="og:description" content="{{ htmlentities($package->description) }}"/>
    <meta property="og:image" content="{{URL::to($package->image)}}"/>

    @php $keywords = \App\Http\Services\HelperService::keywords(); @endphp

    <meta name="keywords" content="{{$package->key_words ? $package->key_words :'Flights Gyani'}}"/>
@endsection
@section('body')
    <style>
        .help-block.with-errors {
            color: #EF6F6C;
            margin-left: 30px;
            margin-top: -15px;
        }
    </style>

    <section class="details">
        <div class="container">
            <div class="tour-head">
                <div class="row">
                    <div class="col-md-6">
                        <div class="tour-image">
                            <img src="{{$package->image}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="tour-title">
                            <div class="tour-detail clearfix">
                                <h3 style="margin-bottom: 0px;">{{$package->title}}</h3>
                                <p class="tour-price py-2">
                                    <span
                                        class="h2">NPR {{$package->price ? number_format($package->price).' /-' : ''}}</span>
                                </p>

                                <div class="fb-share-button share-buttons float-right"
                                     data-href="{{route('package.detail',$package->slug)}}"
                                     data-layout="button_count">
                                </div>

                                <p><i
                                        class="flaticon-maps-and-flags"></i><span>{{$package->destination ? $package->destination :''}}</span>
                                <div class="well text-justify">
                                    {!!  $package->description ? \Illuminate\Support\Str::words($package->description, 55) :'' !!}
                                    <a href="#" data-description="{!! $package->description !!}" id="viewMore">view
                                        More</a>

                                </div>
                                </p>
                                <p class="package-days"><strong><i class="flaticon-time pr-2"></i>Duration
                                        : {{$package->days ? $package->days :''}} days</strong></p>
                            </div>
                            <div class="title-btns mt-3">
                                <a href="#!" data-toggle="modal" data-target="#callPopup" class="btn-blue booknow">Book
                                    Now</a>
                                <a href="#!" class="btn-blue" id="email">Email</a>
                                <a href="{{route('package.download',$package->id)}}" class="btn-blue" id="download">Download
                                    Itinerary</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-outer mt-5">
                <div class="row">
                    <div class="col-lg-2">

                        <div class="bucket-list" data-ref="container-1">
                            <div class="bucket-icons">
                                <div class="category-box">
                                    <ul class="post-category nav nav-tabs">
                                        <li class="active"><a data-toggle="tab" href="#itenirary">Itinerary</a></li>
                                        <li><a data-toggle="tab" href="#inclusion">Inclusion</a></li>
                                        <li><a data-toggle="tab" href="#exclusion">Exclusion</a></li>
                                        <li><a data-toggle="tab" href="#hotel">Hotel</a></li>
                                        <li><a data-toggle="tab" href="#price">Price</a></li>
                                        <li><a data-toggle="tab" href="#optional-tours">Optional Tours</a></li>
                                        <li><a data-toggle="tab" href="#map">Visa Requirement</a></li>
                                        <li><a data-toggle="tab" href="#terms">Terms and Conditions</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="col-lg-10">
                        <div class="tab-content">
                            <div id="itenirary" class="tab-pane fade in active">
                                <div class="itenirary-content">
                                    @if($package->itineraries)
                                        @foreach($package->itineraries as $i)
                                            <div class="itenirary-item">
                                                <div class="it-date">
                                                    <p class="it-day">Day <span>{{$i->day}}</span></p>
                                                </div>
                                                <div class="it-content">
                                                    <h3>{{$i->title}}</h3>
                                                    <p class="text-justify">{!! $i->description !!}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                </div>
                            </div>
                            <div id="inclusion" class="tab-pane fade text-justify">
                                {!! $package->inclusion ? $package->inclusion->description : '' !!}
                            </div>
                            <div id="exclusion" class="tab-pane fade text-justify">
                                {!! $package->exclusion ? $package->exclusion->description : '' !!}
                            </div>
                            <div id="hotel" class="tab-pane fade text-justify">
                                <table class="table-bordered table tab-table w-100">
                                    <thead>
                                    <tr>
                                        <td>Destination</td>
                                        <td>Hotel Name</td>
                                        <td>Hotel Category</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($package->hotels)
                                        @foreach($package->hotels as $h)
                                            <tr style="text-align: center">
                                                <td>{{$h->destination}}</td>
                                                <td>{{$h->name}}</td>
                                                <td>{{$h->category}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif

                                    </tbody>
                                </table>
                            </div>
                            <div id="price" class="tab-pane fade">
                                <table class="table table-bordered tab-table">
                                    <thead>
                                    <tr>
                                        <td>Adult Single</td>
                                        <td>Adult Double</td>
                                        <td>Adult Tripple</td>
                                        <td>Child with Bed</td>
                                        <td>Child Without Bed</td>
                                        <td>Infant</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="table-price">
                                            NPR {{$package->priceDetail ? ($package->priceDetail->adult_single_share ? number_format($package->priceDetail->adult_single_share).'/-' :'-') :'-' }}</td>
                                        <td class="table-price">
                                            NPR {{$package->priceDetail ? ($package->priceDetail->adult_double_share ? number_format($package->priceDetail->adult_double_share).'/-' :'-') :'-' }}</td>
                                        <td class="table-price">
                                            NPR {{$package->priceDetail ? ($package->priceDetail->adult_trip_share ? number_format($package->priceDetail->adult_trip_share).'/-' :'-') :'-' }}</td>
                                        <td class="table-price">
                                            NPR {{$package->priceDetail ? ($package->priceDetail->child_with_bed ? number_format($package->priceDetail->child_with_bed).'/-' :'-') :'-' }}</td>
                                        <td class="table-price">
                                            NPR {{$package->priceDetail ? ($package->priceDetail->child_without_bed ? number_format($package->priceDetail->child_without_bed).'/-' :'-') :'-' }}</td>
                                        <td class="table-price">
                                            NPR {{$package->priceDetail ? ($package->priceDetail->infant ? number_format($package->priceDetail->infant).'/-' :'-') :'-' }}</td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div id="optional-tours" class="tab-pane fade">
                                <table class="table table-bordered tab-table">
                                    <thead>
                                    <tr>
                                        <td>Category</td>
                                        <td>Price per Adult</td>
                                        <td>Price per Child</td>
                                        <td>Price per infant</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($package->operationalTours)
                                        @foreach($package->operationalTours as $ot)
                                            <tr class="optional">
                                                <td class="optional-name">{{$ot->destination}}</td>
                                                <td>NPR {{ number_format($ot->price_per_adult).'/-' }}</td>
                                                <td> NPR {{ number_format($ot->price_per_child).'/-' }}</td>
                                                <td> NPR {{number_format($ot->price_per_infant).'/-'}}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <div id="map" class="tab-pane fade text-justify">
                                <p class="text-justify">{!! $package->visa ? ($package->visa->description ? $package->visa->description :'') :'' !!}</p>
                            </div>
                            <div id="terms" class="tab-pane fade text-justify">
                                <div class="terms-content">
                                    <p class="text-justify">{!! $package->term ? ($package->term->description ? $package->term->description :'') :'' !!}</p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /Bootstrap Tabs -->
                    <!-- Bootstrap Accordion -->


                </div>
            </div>
        </div>


        <div class="modal fade" id="callPopup" tabindex="-1" role="dialog" aria-labelledby="call-action"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center" id="call-action">Book now</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: red">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="GET" id="bookForm">
                            <div class="row">
                                <input type="hidden" name="type" id="type" class="form-control" value="book">
                                <div class="form-group col-lg-6 col-sm-6 col-md-6">
                                    <input type="text" class="form-control" name="name" placeholder="Enter Your Name"
                                           required>
                                </div>
                                <div class="form-group col-lg-6 col-sm-6 col-md-6">
                                    <input type="text" name="phone" class="form-control"
                                           placeholder="Enter Your Phone No." required>
                                </div>
                                <div class="form-group col-lg-6 col-sm-6 col-md-6">
                                    <input type="text" name="email" class="form-control" placeholder="Enter Your Email"
                                           required>
                                </div>
                                <div class="form-group col-lg-6 col-sm-6 col-md-6">
                                    <input type="text" name="city" class="form-control" placeholder="Enter Your city"
                                           required>
                                </div>
                            </div>
                            <button href="#" class="btn btn-danger" id="downloadButton">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="viewMoreModal" tabindex="-1" role="dialog" aria-labelledby="call-action"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center" id="call-action"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: red">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <span id="loadMore"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="downloadModal" tabindex="-1" role="dialog" aria-labelledby="call-action"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center" id="call-action">Please fill the form for further
                            action</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('package.download',$package->id)}}" method="get" id="downloadForm">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="type" id="type" class="form-control" value="download">
                                <div class="form-group col-lg-6 col-sm-6 col-md-6">
                                    <input type="text" name="name" class="form-control" placeholder="Enter Your Name"
                                           required>
                                </div>
                                <div class="form-group col-lg-6 col-sm-6 col-md-6">
                                    <input type="text" name="phone" class="form-control"
                                           placeholder="Enter Your Phone No." required>
                                </div>
                                <div class="form-group col-lg-6 col-sm-6 col-md-6">
                                    <input type="text" name="email" class="form-control" placeholder="Enter Your Email"
                                           required>
                                </div>
                                <div class="form-group col-lg-6 col-sm-6 col-md-6">
                                    <input type="text" name="city" class="form-control" placeholder="Enter Your city"
                                           required>
                                </div>
                            </div>
                            <button href="#" class="btn btn-danger" id="downloadButton">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </section>

@endsection
@section('scripts')

    <!-- *Scripts* -->
    <script type="text/javascript">
        /**
         * default validation configs, can be override in specifc view blades
         */
        $.validator.setDefaults({
            errorClass: 'help-block with-errors',
            errorElement: 'div',
            /*//        onkeyup: function (element) {
            //            $(element).valid();
            //        },*/
            onfocusout: function (element) {
                $(element).valid();
            },
            highlight: function (element, errorClass, validClass) {
                //console.log('hee');
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).closest('.form-group').removeClass('has-error');
                $(element).closest('.form-group').find('.help-block').hide();
            },
            errorPlacement: function (error, element) {
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
        $(document).on('click', '#viewMore', function (e) {
            e.preventDefault();
            var description = $(this).data('description');
            $('#loadMore').html(description);
            $('#viewMoreModal').modal('show');
        });
        $(document).on('click', '#download', function (e) {
            e.preventDefault();
            $('#type').val('download')
            $('#downloadModal').modal('show');
        });

        $(document).on('click', '#downloadButton', function (e) {
            e.preventDefault();
            if ($('#downloadForm').valid()) {
                $('#downloadModal').modal('hide');
                // $('#downloadForm')[0].reset();
                $('#downloadForm').submit();
            }
        });
        $(document).on('click', '#email', function (e) {
            e.preventDefault();
            $('#type').val('email')
            $('#downloadModal').modal('show');
        });

        $('#viewMoreModal').on('hidden.bs.modal', function () {
            $(this).find('form')[0].reset();
        });
        $('#downloadModal').on('hidden.bs.modal', function () {
            $(this).find('form')[0].reset();
        });
    </script>

@endsection
