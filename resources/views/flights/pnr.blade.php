@extends('layouts.front')
@section('title')
    PNR
@endsection

@section('body')
    <div class="container booking-page">
        <div class="row mt-4">
            <div class="col-lg-9 mt-4">
                @if(!$booking->pnr_id)
                    Error in processing request!!! <br>
                    {{ session()->get('error') }}
                @endif

                <h3 class="m-0 p-0 pb-1 mb-3 border-bottom">Fight Details</h3>
                <div class="flight-more-details p-3 border mt-3">
                    <div class="w-100 m-0 mt-3">
                        <div>
                            @foreach($flights['flight'] as $flight)
                                @foreach($flight['sectors'] as $f)
                                    <div class="row">
                                        <div class="col-md-2 col-sm-12 text-center border-md-right">
                                            <img
                                                src="{{ URL::asset('/frontend/air-logos/'.$f['marketingairline'].'.png') }}"
                                                class="logo-img-sm" alt="">
                                            <p class="text-center smaller bold">{{ $f['marketingairline'] }}</p>
                                            <small class="gray-text smaller">{{ $f['flightnumber'] }}</small>
                                        </div>
                                        <div class="col-md-4 col-sm-5 col-xs-5">
                                            <p class="big-text bold text-right">
                                                {{ $f['departure'] }} ({{ $f['departtime'] }})
                                            </p>
                                            <p class="text-right small gray-text">
                                                {{ $f['departport'] }} @isset($f['depterminal'])
                                                    ({{ $f['depterminal'] }})
                                                @endisset
                                            </p>
                                            <p class="text-right smaller gray-text">
                                                {{ $f['departdate'] }}
                                            </p>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                            <p class="small bold pb-1 border-red-dashed w-80 m-0-a flight-icons text-center">
                                                {{ $f['elapstime'] }}
                                            </p>
                                            <p class="small gray-text pt-1 text-center">
                                                {{ $f['class'] }}/{{ $f['resbook'] }}
                                            </p>
                                        </div>
                                        <div class="col-md-4 col-sm-5 col-xs-5">
                                            <p class="big-text bold text-left">
                                                {{ $f['arrival'] }} ( {{ $f['arrivaltime'] }})
                                            </p>
                                            <p class="text-left small gray-text">
                                                {{ $f['arrivalport'] }} @isset($f['arrivalterminal'])
                                                    ({{ $f['arrivalterminal'] }})
                                                @endisset
                                            </p>
                                            <p class="text-left smaller gray-text">
                                                {{ $f['arrivaldate'] }}
                                            </p>
                                        </div>
                                    </div>


                                    @if(array_key_exists($loop->iteration,$flight['sectors']))
                                        <div class="row connection-details pb-2 mx-4">
                                            <div class="text-center col-xs-12">
                                                <span class="small bg-blue text-white br-100 py-2 px-4">
                                                    Connection Time:  {{ \App\Service\Sabre\SabreBasic::generateFlightTime(\Carbon\Carbon::parse($flight['sectors'][$loop->iteration-1]['arrivaldate'].' '.$flight['sectors'][$loop->iteration-1]['arrivaltime'])->diffInRealMinutes(\Carbon\Carbon::parse($flight['sectors'][$loop->iteration]['departdate'].' '.$flight['sectors'][$loop->iteration]['departtime']))) }}</span>
                                            </div>
                                        </div>
                                    @endif

                                @endforeach
                            @endforeach


                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-3 mt-4">
                <div class="p-3 bg-red text-center">
                    <h4 class="m-0 text-white">{{ (isset($booking->pnr_id))?$booking->pnr_id:'' }}</h4>
                </div>
                <div class="p-3 bg-grey text-center clearfix">

                    @foreach($flights['detail'] as $detail)

                        <div class="float-left w-45">
                            <strong>{{ $detail['origin'] }}</strong>
                        </div>
                        <i class="fa fa-plane r-45"></i>
                        <div class="float-right w-45">
                            <strong>{{ $detail['destination'] }}</strong>
                        </div>
                        <div class="text-center pt-2">
                            <small>{{ $detail['origindate'] }} <span
                                    class="text-green px-5"><strong>--</strong></span>{{ $detail['destinationdate'] }}
                            </small>
                        </div>
                    @endforeach
                    <div class="pt-3 text-left border-bottom">
                        <p class="border-bottom"><strong class="text-danger p-2">Passengers</strong></p>
                        <div class="clearfix px-3 pt-1">
                            @if($booking->adults > 0)
                                <strong>Adult :</strong><span class="float-right">{{ $booking->adults }}</span><br>
                            @endif
                            @if($booking->childs > 0)
                                <strong>Child :</strong><span class="float-right">{{ $booking->childs }}</span><br>
                            @endif
                            @if($booking->infants > 0)
                                <strong>Infant :</strong><span class="float-right">{{ $booking->infants }}</span><br>
                            @endif
                        </div>
                    </div>
                    <div class="pt-2 border-bottom clearfix">
                        <h4 class="text-danger float-left py-2 pl-1">{{ $flights['pricing']['markedfare'] }}</h4>
                        <span data-toggle="modal" data-target="#fareModal" class="float-right text-green bold"><small>Fare Breakdown <i
                                    class="fa fa-info-circle pl-2"></i></small></span><br>
                    </div>
                    @isset($booking->pnr_id)
                        <div class="text-center mt-3 mb-3"><a href="{{ route('issue.ticket',$booking->booking_code) }}"
                                                              class="btn btn-green w-100">Issue Tickets</a></div>
                    @endisset
                    <div class="m-3 bg-red text-white p-3 border-radius-20">
                        <small><i class="fa fa-phone pr-3"></i>Need Help : +977-9876543210</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fare Modal -->
    <div class="modal fade" id="fareModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Fare Breakdown</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="w-100 table-responsive table-striped fare-table">
                        <tr>
                            <th>Fare Type</th>
                            @foreach($flights['breakdown'] as $breakdown)
                                <th>{{ $breakdown['type'] }}</th>
                            @endforeach
                        </tr>

                        <tr>
                            <td>Base Fare</td>
                            @foreach($flights['breakdown'] as $breakdown)
                                <td>{{ $breakdown['mbasefare'] }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td>Taxes and Other Charges </td>
                            @foreach($flights['breakdown'] as $breakdown)
                                <td>{{ $breakdown['tax'] }}</td>
                            @endforeach
                        </tr>

                        <tr>
                            <td>Total </td>
                            @foreach($flights['breakdown'] as $breakdown)
                                <td>{{ $breakdown['mtotal'] }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td>No of Pax</td>
                            @foreach($flights['breakdown'] as $breakdown)
                                <td>{{ $breakdown['qty'] }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="bold">Total</td>
                            <td class="bold" colspan="3">{{ $flights['pricing']['markedfare'] }}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

@endsection

