@extends('layouts.back')
@section('title', $package->title)
@php $package_id = $package->id; @endphp
@section('content')
    <style>
        .nablist > li {
            width: 100px;
            height: 65px !important;
            margin-left: 5px;
        }

        .tabledetails {
            /*font-size: 10px;*/
            background: beige;
        }
    </style>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h1 class="box-title">{{$package->title}}</h1>
                    </div>
                    <table style="width:100%; margin-left: 5px;margin-right: 5px;" class="table-bordered ">
                        <tr>
                            <th>Title</th>
                            <td>{{$package->title?$package->title :''}}</td>
                            <th>Price</th>
                            <td>NPR {{$package->price ? $package->price : ''}}</td>
                            <th>Plan</th>
                            <td>{{$package->plan ? $package->plan : ''}}</td>
                        </tr>
                        <tr>
                            <th>Popular Package</th>
                            <td>{{($package->popular_package == 1) ? 'Yes':'NO'}}</td>
                            <th>Special Pacakge</th>
                            <td>{{($package->sepcial_package == 1) ? 'Yes':'NO'}}</td>

                            <th>Deals on sale</th>
                            <td>{{($package->deals_on_sale == 1) ? 'Hot Deals':'Normal'}}</td>
                        </tr>
                        <tr>
                            <th>Rating</th>
                            <td>{{$package->rating?$package->rating :''}}</td>
                            <th>Days</th>
                            <td>{{$package->days ? $package->days : ''}}</td>
                        </tr>
                        <tr>
                            <th>Discount</th>
                            <td>{{$package->discount ? $package->discount :0}}</td>
                            <th>Start Date</th>
                            <td>{{$package->start_date? $package->start_date : ''}}</td>
                            <th>End Date</th>
                            <td>{{$package->end_date ? $package->end_date : ''}}</td>
                        </tr>
                        <tr>
                            <th>Destination</th>
                            <td>{{$package->destination ? $package->destination :0}}</td>
                        </tr>
                    </table>
                    <div class="row" style="margin-bottom: 40px; margin-top: 19px;margin-left: 15px;">
                        <div class="col-lg-9 col-md-9 tabledetails">
                            <div style="margin-top: 5px">
                                {!! $package->description  !!}
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 ">
                            <div class="well" style="margin-left: 5px">
                                <img src="{{$package->image}}" alt="image" style="width: 50%">
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 40px">
                        <div class="col-md-4">
                            <span class="h3 m-lg-1">Itinerary</span>
                            <a href="#" class="pull-right btn btn-primary btn-sm" id="addItinerary"><i
                                    class="fa fa-plus"></i> </a>
                            <table id="dataTable" class="table table-hover tabledetails" style="width: 100%">
                                <thead>
                                <tr>
                                    <th>day</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($package->itineraries) > 0)
                                    @foreach($package->itineraries as $key=>$i)
                                        <tr>
                                            <td>{{$i->day}}</td>
                                            <td>{{$i->title}}</td>
                                            <td>{{$i->description}}</td>
                                            <td>
                                                <a href="#"
                                                   class="editItinerary"
                                                   style="margin-right: 5px; font-size: 12px"
                                                   data-id="{{$i->id}}"
                                                   data-day="{{$i->day}}"
                                                   data-title="{{$i->title}}"
                                                   data-description="{{$i->description}}"
                                                ><i class="fa fa-edit"></i> </a>
                                                <a class='' data-toggle='tooltip' title='Delete'
                                                   data-action='delete'
                                                   href='{{route('itinerary.delete')}}' data-id='{{$i->id}}'><i
                                                        class="fa fa-trash" style="color:red;font-size: 12px"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3">No data found</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4">

                            <span class="h3 m-lg-1">Price</span>
                            @if(!$package->priceDetail)
                                <a href="#" class="pull-right btn btn-primary btn-sm" id="addPrice"><i
                                        class="fa fa-plus"></i> </a>
                            @else
                                <a href="#"
                                   class="editPrice pull-right btn btn-info btn-sm"
                                   data-id="{{$package->priceDetail->id}}"
                                   data-adultsingleshare="{{$package->priceDetail->adult_single_share}}"
                                   data-adultdoubleshare="{{$package->priceDetail->adult_double_share}}"
                                   data-adulttripshare="{{$package->priceDetail->adult_trip_share}}"
                                   data-childwithbed="{{$package->priceDetail->child_with_bed}}"
                                   data-childwithoutbed="{{$package->priceDetail->child_without_bed}}"
                                   data-infant="{{$package->priceDetail->infant}}"
                                ><i class="fa fa-edit"></i> </a>
                            @endif
                            <table id="dataTable" class="table table-hover tabledetails" style="width: 100%">
                                <thead>
                                <tr>
                                    <th>Adult Single share</th>
                                    <td>
                                        NPR. {{$package->priceDetail ? $package->priceDetail->adult_single_share : ''}}</td>
                                    <th>Adult Double Share</th>
                                    <td>
                                        NPR. {{$package->priceDetail ? $package->priceDetail->adult_double_share : ''}}</td>

                                </tr>
                                <tr>
                                    <th>Adult Trippple Share</th>
                                    <td>
                                        NPR. {{$package->priceDetail ? $package->priceDetail->adult_trip_share :''}}</td>
                                    <th>Child with bed</th>
                                    <td>NPR. {{$package->priceDetail ? $package->priceDetail->child_with_bed :''}}</td>
                                </tr>
                                <tr>
                                    <th>Child without bed</th>
                                    <td>
                                        NPR. {{$package->priceDetail ? $package->priceDetail->child_without_bed :''}}</td>
                                    <th>Infant</th>
                                    <td>NPR. {{$package->priceDetail ?$package->priceDetail->infant:''}}</td>

                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <span class="h3 m-lg-1">Hotels</span>
                            <a href="#" class="pull-right btn btn-primary btn-sm" id="addHotel">Add </a>
                            <table id="dataTable" class="table table-hover tabledetails" style="width: 100%">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Destination</th>
                                    <th>Category</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @if(count($package->hotels) > 0)
                                    @foreach($package->hotels as $key=>$hotel)
                                        <tr>
                                            <td>{{$hotel->name}}</td>
                                            <td>{{$hotel->destination}}</td>
                                            <td>{{$hotel->category}}</td>
                                            <td>
                                                <a href="#"
                                                   class="editHotel"
                                                   style="margin-right: 5px; font-size: 12px"
                                                   data-id="{{$hotel->id}}"
                                                   data-name="{{$hotel->name}}"
                                                   data-destination="{{$hotel->destination}}"
                                                   data-category="{{$hotel->category}}"
                                                ><i class="fa fa-edit"></i> </a>
                                                <a class='' data-toggle='tooltip' title='Delete'
                                                   data-action='delete'
                                                   href='{{route('hotels.delete')}}' data-id='{{$hotel->id}}'><i
                                                        class="fa fa-trash" style="color:red;font-size: 12px"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3"> No Data Found.</td>
                                    </tr>
                                @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 40px">
                        <div class="col-md-4">
                            <span class="h3 m-lg-1">Exclusion</span>
                            @if(!$package->exclusion)
                                <a href="#" class="pull-right btn btn-primary btn-sm" id="addExclusion">Add </a>
                            @else
                                <a href="#"
                                   class="editExclusion pull-right btn btn-info btn-sm"
                                   data-id="{{$package->exclusion->id}}"
                                   data-description="{{$package->exclusion->description}}"
                                ><i class="fa fa-edit"></i> </a>
                            @endif
                            <div>
                                {!! $package->exclusion ? $package->exclusion->description :'' !!}
                            </div>

                        </div>
                        <div class="col-md-4">
                            <span class="h3 m-lg-1">Inclusion</span>
                            @if(!$package->inclusion)
                                <a href="#" class="pull-right btn btn-primary btn-sm" id="addInclusion">Add </a>
                            @else
                                <a href="#"
                                   class="editInclusion pull-right btn btn-info btn-sm"
                                   data-id="{{$package->inclusion->id}}"
                                   data-description="{{$package->inclusion->description}}"
                                ><i class="fa fa-edit"></i> </a>
                            @endif
                            <div>
                                {!! $package->inclusion  ? $package->inclusion->description :'' !!}
                            </div>

                        </div>
                        <div class="col-md-4">
                            <span class="h3 m-lg-1">Terms & Conditions</span>
                            @if(!$package->term)
                                <a href="#" class="pull-right btn btn-primary btn-sm" id="addTerms">Add </a>
                            @else
                                <a href="#"
                                   class="editTerms pull-right btn btn-info btn-sm"
                                   data-id="{{$package->term->id}}"
                                   data-description="{{$package->term->description}}"
                                ><i class="fa fa-edit"></i> </a>
                            @endif
                            <div>
                                {!! $package->term  ? $package->term->description :'' !!}
                            </div>

                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 40px">
                        <div class="col-md-4">
                            <span class="h3 m-lg-1">Visa Requirement</span>
                            @if(!$package->visa)
                                <a href="#" class="pull-right btn btn-primary btn-sm" id="addVisa">Add </a>
                            @else
                                <a href="#"
                                   class="editVisa pull-right btn btn-info btn-sm"
                                   data-id="{{$package->visa->id}}"
                                   data-description="{{$package->visa->description}}"
                                ><i class="fa fa-edit"></i> </a>
                            @endif
                            <div>
                                {!! $package->visa  ? $package->visa->description :'' !!}
                            </div>

                        </div>
                        <div class="col-md-8">
                            <span class="h3 m-lg-1">Operation Tours</span>
                            <a href="#" class="pull-right btn btn-primary btn-sm" id="addOPT"><i
                                    class="fa fa-plus"></i> </a>
                            <table id="dataTable" class="table table-hover tabledetails" style="width: 100%">
                                <thead>
                                <tr>
                                    <th>Destination</th>
                                    <th>Price Per Adult</th>
                                    <th>Price Per Child</th>
                                    <th>Price Per Infant</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($package->operationalTours) > 0)
                                    @foreach($package->operationalTours as $key=>$o)
                                        <tr>
                                            <td>{{$o->destination}}</td>
                                            <td>{{$o->price_per_adult}}</td>
                                            <td>{{$o->price_per_child}}</td>
                                            <td>{{$o->price_per_infant}}</td>
                                            <td>
                                                <a href="#"
                                                   class="editOPT"
                                                   style="margin-right: 5px; font-size: 12px"
                                                   data-id="{{$o->id}}"
                                                   data-destination="{{$o->destination}}"
                                                   data-priceperadult="{{$o->price_per_adult}}"
                                                   data-priceperchild="{{$o->price_per_child}}"
                                                   data-priceperinfant="{{$o->price_per_infant}}"
                                                ><i class="fa fa-edit"></i> </a>
                                                <a class='' data-toggle='tooltip' title='Delete'
                                                   data-action='delete'
                                                   href='{{route('operational-tour.delete')}}' data-id='{{$o->id}}'><i
                                                        class="fa fa-trash" style="color:red;font-size: 12px"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3">No data found</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>


    <div class="modal fade" id="itenaryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><span id="addEdit"></span>Itenary</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formIternary" enctype="multipart/form-data" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="package_id" value="{{$package_id}}">
                        <div class="form-group">
                            <label for="title">Day</label>
                            <input type="text" name="day" class="form-control" id="day" placeholder="Enter day"
                                   required>
                        </div>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" id="title" placeholder="Enter Title"
                                   required>
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

    <div class="modal fade" id="priceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><span id="addEdit"></span>Price Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formPrice" enctype="multipart/form-data" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="package_id" value="{{$package_id}}">
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label for="adult_single_share">Adult Single Share</label>
                                <input type="number" name="adult_single_share" class="form-control"
                                       id="adult_single_share"
                                       placeholder="Enter Adult Single Share" required>
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="adult_double_share">Adult Double Share</label>
                                <input type="number" name="adult_double_share" class="form-control"
                                       id="adult_double_share"
                                       placeholder="Enter Adult Double Share" required>
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="adult_trip_share">Adult Trip Share</label>
                                <input type="number" name="adult_trip_share" class="form-control" id="adult_trip_share"
                                       placeholder="Enter Adult Trip Share" required>
                            </div>

                            <div class="form-group col-lg-4">
                                <label for="child_with_bed">Child with bed</label>
                                <input type="number" name="child_with_bed" class="form-control" id="child_with_bed"
                                       placeholder="Enter Child with bed" required>
                            </div>

                            <div class="form-group col-lg-4">
                                <label for="child_without_bed">Child without bed</label>
                                <input type="number" name="child_without_bed" class="form-control"
                                       id="child_without_bed"
                                       placeholder="Enter Child without bed" required>
                            </div>

                            <div class="form-group col-lg-4">
                                <label for="infant">Infance</label>
                                <input type="number" name="infant" class="form-control" id="infant"
                                       placeholder="Enter Infance" required>
                            </div>
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

    <div class="modal fade" id="hotelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><span id="addEdit"></span>Hotels</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formHotel" enctype="multipart/form-data" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="package_id" value="{{$package_id}}">
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control" id="name"
                                       placeholder="Enter Name" required>
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="Destination">Destination</label>
                                <input type="text" name="destination" class="form-control" id="destination"
                                       placeholder="Enter Destination" required>
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="category">Category</label>
                                <input type="text" name="category" class="form-control" id="category"
                                       placeholder="Enter Category" required>
                            </div>

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
    <div class="modal fade" id="exclusionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><span id="addEdit"></span>Exclusion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formExclusion" enctype="multipart/form-data" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="package_id" value="{{$package_id}}">
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label for="descriptionE">Description</label>
                                <textarea name="description" id="descriptionE" class="ckeditor">
                                </textarea>
                            </div>

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
    <div class="modal fade" id="inclusionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><span id="addEdit"></span>Inclusion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formInclusion" enctype="multipart/form-data" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="package_id" value="{{$package_id}}">
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label for="descriptioI">Description</label>
                                <textarea name="description" id="descriptionI" class="ckeditor">
                                </textarea>
                            </div>

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
    <div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><span id="addEdit"></span>Terms and Conditions</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formTerms" enctype="multipart/form-data" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="package_id" value="{{$package_id}}">
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label for="descriptioI">Description</label>
                                <textarea name="description" id="descriptionT" class="ckeditor">
                                </textarea>
                            </div>

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
    <div class="modal fade" id="visaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><span id="addEdit"></span>Visa Reqiurement</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formVisa" enctype="multipart/form-data" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="package_id" value="{{$package_id}}">
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label for="descriptioV">Description</label>
                                <textarea name="description" id="descriptionV" class="ckeditor">
                                </textarea>
                            </div>

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

    <div class="modal fade" id="OPTModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><span id="addEdit"></span>Operation Tour</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formOPT" enctype="multipart/form-data" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="package_id" value="{{$package_id}}">
                        <div class="form-group">
                            <label for="title">Destination</label>
                            <input type="text" name="destination" class="form-control" id="destinationO"
                                   placeholder="Enter destination" required>
                        </div>
                        <div class="form-group">
                            <label for="price_per_adult">Price Per Adult</label>
                            <input type="number" name="price_per_adult" class="form-control" id="price_per_adult"
                                   placeholder="Enter Price Per Adult" required>
                        </div>
                        <div class="form-group">
                            <label for="price_per_child">Price Per Child</label>
                            <input type="number" name="price_per_child" class="form-control" id="price_per_child"
                                   placeholder="Enter Price Per Child" required>
                        </div>
                        <div class="form-group">
                            <label for="price_per_infant">Price Per Infant</label>
                            <input type="number" name="price_per_infant" class="form-control" id="price_per_infant"
                                   placeholder="Enter Price Per Infant" required>
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

@endsection
@section('scripts')
    {{--    @include('includes.ckeditor')--}}
    <script src="{{ URL::asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script src="{{ URL::asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
    <script>
        {{--Itinerary--}}
        $(document).on('click', '#addItinerary', function (e) {
            e.preventDefault();
            $('#itenaryModal').modal('show');
            var url = "{{route('itinerary.store')}}";
            $('#formIternary').attr('action', url);
            $('#formIternary')[0].reset();

        });
        $(document).on('click', '.editItinerary', function (e) {
            e.preventDefault();
            $('#itenaryModal').modal('show');
            var id = $(this).data('id');
            var day = $(this).data('day');
            var title = $(this).data('title');
            var description = $(this).data('description');
            var url = "{{route('itinerary.update',[null])}}/" + id;

            $('#title').val(title);
            $('#day').val(day);
            $('#description').val(description);
            $('#formIternary').attr('action', url);

        });

        {{--price--}}
        $(document).on('click', '#addPrice', function (e) {
            e.preventDefault();
            $('#priceModal').modal('show');
            var url = "{{route('price-details.store')}}";
            $('#formPrice').attr('action', url);
            $('#formPrice')[0].reset();

        });
        $(document).on('click', '.editPrice', function (e) {
            e.preventDefault();
            $('#priceModal').modal('show');
            var id = $(this).data('id');
            var adultsingleshare = $(this).data('adultsingleshare');
            var adultdoubleshare = $(this).data('adultdoubleshare');
            var adulttripshare = $(this).data('adulttripshare');
            var childwithbed = $(this).data('childwithbed');
            var childwithoutbed = $(this).data('childwithoutbed');
            var infant = $(this).data('infant');

            $('#adult_single_share').val(adultsingleshare);
            $('#adult_double_share').val(adultdoubleshare);
            $('#adult_trip_share').val(adulttripshare);
            $('#child_with_bed').val(childwithbed);
            $('#child_without_bed').val(childwithoutbed);
            $('#infant').val(infant);

            var url = "{{route('price-details.update',[null])}}/" + id;
            $('#formPrice').attr('action', url);

        });

        {{--Hotels--}}
        $(document).on('click', '#addHotel', function (e) {
            e.preventDefault();
            $('#hotelModal').modal('show');
            var url = "{{route('hotels.store')}}";
            $('#formHotel').attr('action', url);
            $('#formHotel')[0].reset();

        });
        $(document).on('click', '.editHotel', function (e) {
            e.preventDefault();
            $('#hotelModal').modal('show');
            var id = $(this).data('id');
            var name = $(this).data('name');
            var destination = $(this).data('destination');
            var category = $(this).data('category');

            $('#name').val(name);
            $('#destination').val(destination);
            $('#category').val(category);

            var url = "{{route('hotels.update',[null])}}/" + id;
            $('#formHotel').attr('action', url);

        });

        {{--Exclusion--}}
        $(document).on('click', '#addExclusion', function (e) {
            e.preventDefault();
            $('#exclusionModal').modal('show');
            var url = "{{route('exclusion.store')}}";
            $('#formExclusion').attr('action', url);
            $('#formExclusion')[0].reset();

        });
        $(document).on('click', '.editExclusion', function (e) {
            e.preventDefault();
            $('#exclusionModal').modal('show');
            var id = $(this).data('id');
            var description = $(this).data('description');
            CKEDITOR.instances['descriptionE'].setData(description)


            var url = "{{route('exclusion.update',[null])}}/" + id;
            $('#formExclusion').attr('action', url);
        });

        {{--Inclusion--}}
        $(document).on('click', '#addInclusion', function (e) {
            e.preventDefault();
            $('#inclusionModal').modal('show');
            var url = "{{route('inclusion.store')}}";
            $('#formInclusion').attr('action', url);
            $('#formInclusion')[0].reset();


        });
        $(document).on('click', '.editInclusion', function (e) {
            e.preventDefault();
            $('#inclusionModal').modal('show');
            var id = $(this).data('id');
            var description = $(this).data('description');
            CKEDITOR.instances['descriptionI'].setData(description)


            var url = "{{route('inclusion.update',[null])}}/" + id;
            $('#formInclusion').attr('action', url);

        });

        {{--Terms And condition--}}
        $(document).on('click', '#addTerms', function (e) {
            e.preventDefault();
            $('#termsModal').modal('show');
            var url = "{{route('terms-and-conditions.store')}}";
            $('#formTerms').attr('action', url);
            $('#formTerms')[0].reset();


        });
        $(document).on('click', '.editTerms', function (e) {
            e.preventDefault();
            $('#termsModal').modal('show');
            var id = $(this).data('id');
            var description = $(this).data('description');
            CKEDITOR.instances['descriptionT'].setData(description)


            var url = "{{route('terms-and-conditions.update',[null])}}/" + id;
            $('#formTerms').attr('action', url);

        });

        {{--Terms And condition--}}
        $(document).on('click', '#addVisa', function (e) {
            e.preventDefault();
            $('#visaModal').modal('show');
            var url = "{{route('visa.store')}}";
            $('#formVisa').attr('action', url);
            $('#formVisa')[0].reset();

        });
        $(document).on('click', '.editVisa', function (e) {
            e.preventDefault();
            $('#visaModal').modal('show');
            var id = $(this).data('id');
            var description = $(this).data('description');
            CKEDITOR.instances['descriptionT'].setData(description)


            var url = "{{route('visa.update',[null])}}/" + id;
            $('#formVisa').attr('action', url);

        });


        {{--Operational Tour--}}
        $(document).on('click', '#addOPT', function (e) {
            e.preventDefault();
            $('#OPTModal').modal('show');
            var url = "{{route('operational-tour.store')}}";
            $('#formOPT').attr('action', url);
            $('#formOPT')[0].reset();


        });
        $(document).on('click', '.editOPT', function (e) {
            e.preventDefault();
            $('#OPTModal').modal('show');
            var id = $(this).data('id');
            var destination = $(this).data('destination');
            var priceperadult = $(this).data('priceperadult');
            var priceperchild = $(this).data('priceperchild');
            var priceperinfant = $(this).data('priceperinfant');
            var url = "{{route('operational-tour.update',[null])}}/" + id;

            $('#destinationO').val(destination);
            $('#price_per_adult').val(priceperadult);
            $('#price_per_child').val(priceperchild);
            $('#price_per_infant').val(priceperinfant);
            $('#formOPT').attr('action', url);

        });
    </script>
@endsection


