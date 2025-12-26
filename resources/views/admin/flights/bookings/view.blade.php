@extends('layouts.back')
@section('title')
    Flight Booking {{ $booking->booking_code ?? '' }}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    Flight Booking :- {{ $booking->booking_code ?? '' }}
                </div>
                <div class="col-12">
                    <div class="tab">
                        <div class="">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="">
                                        <a class="active" data-toggle="tab" aria-expanded="true" href="#contact"
                                            role="tab" aria-selected="true"><i class="icon-copy fa fa-vcard"
                                                aria-hidden="true"></i>
                                            Contact Details</a>
                                    </li>
                                    <li class="">
                                        <a class="" data-toggle="tab" href="#flights" role="tab"
                                            aria-expanded="true" aria-selected="false"><i class="icon-copy fa fa-plane"
                                                aria-hidden="true"></i> Flight Details</a>
                                    </li>
                                    <li class="">
                                        <a class="" data-toggle="tab" href="#passengers" role="tab"
                                            aria-expanded="true" aria-selected="false"><i class="fa fa-users"></i>
                                            Passengers</a>
                                    </li>
                                    <li class="">
                                        <a class="" data-toggle="tab" href="#tickets" role="tab"
                                            aria-expanded="true" aria-selected="false"><i class="icon-copy fi-ticket"></i>
                                            Ticket Details</a>
                                    </li>
                                    <li class="">
                                        <a class="" data-toggle="tab" href="#pricing" role="tab"
                                            aria-expanded="true" aria-selected="false"><i class="icon-copy fa fa-money"
                                                aria-hidden="true"></i> Pricing Details</a>
                                    </li>
                                    <li class="">
                                        <a class="" data-toggle="tab" href="#baggage" role="tab"
                                            aria-selected="false"><i class="icon-copy fa fa-shopping-bag"
                                                aria-hidden="true"></i> Baggage Details</a>
                                    </li>
                                    <li class="">
                                        <a class="" data-toggle="tab" href="#penalty" role="tab"
                                            aria-selected="false"><i class="icon-copy fa fa-money" aria-expanded="true"
                                                aria-hidden="true"></i> Fare Penalty</a>
                                    </li>
                                    <li class="">
                                        <a class="" data-toggle="tab" href="#actions" role="tab"
                                            aria-expanded="true" aria-selected="false"><i class="icon-copy fa fa-cog"
                                                aria-hidden="true"></i>
                                            Actions</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="contact">
                                        <div class="pd-20">

                                            <dl class="row">
                                                <dt class="col-sm-3">Name</dt>
                                                <dd class="col-sm-9">
                                                    {{ json_decode($booking->contact_details, true)['name'] ?? '' }}
                                                    {{ json_decode($booking->contact_details, true)['mname'] ?? '' }}
                                                    {{ json_decode($booking->contact_details, true)['lname'] ?? '' }}</dd>
                                                <dt class="col-sm-3">Email</dt>
                                                <dd class="col-sm-9">
                                                    {{ json_decode($booking->contact_details, true)['email'] ?? '' }}</dd>
                                                <dt class="col-sm-3">Phone</dt>
                                                <dd class="col-sm-9">
                                                    {{ json_decode($booking->contact_details, true)['phone'] ?? '' }}</dd>
                                            </dl>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tickets" role="tabpanel">
                                        <div class="pd-20">

                                            @if (isset($booking->ticket_details))
                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">PAX</th>
                                                                <th scope="col">Name</th>
                                                                <th scope="col">Ticket</th>
                                                                <th scope="col">Reference</th>
                                                                <th scope="col">Status</th>
                                                                <th scope="col">Voided By</th>
                                                                <th scope="col">Void Date</th>
                                                                <th scope="col">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($booking->getTickets as $ticket)
                                                                <tr>
                                                                    <td scope="row">{{ $loop->iteration ?? '' }}</td>
                                                                    <td scope="row">{{ $ticket->pax_type ?? '' }}</td>
                                                                    <td scope="row">{{ $ticket->first_name ?? '' }}
                                                                        {{ $ticket->last_name ?? '' }}</td>
                                                                    <td scope="row">{{ $ticket->ticket_number ?? '' }}
                                                                    </td>
                                                                    <td scope="row">
                                                                        {{ $ticket->ticket_reference ?? '' }}
                                                                    </td>
                                                                    <td scope="row"><span
                                                                            class="badge {{ $ticket->status ? 'badge-success' : 'badge-danger' }}">{{ $ticket->status ? 'Not Void' : 'Void' }}</span>
                                                                    </td>
                                                                    <td scope="row">
                                                                        {{ isset($ticket->voided_by) ? $ticket->voidedBy->name : '' }}
                                                                    </td>
                                                                    <td scope="row">
                                                                        {{ isset($ticket->void_date) ? $ticket->void_date : '' }}
                                                                    </td>
                                                                    <td scope="row">
                                                                        @if ($ticket->status)
                                                                            <a class="btn" data-bgcolor="#ff0000"
                                                                                data-color="#ffffff"
                                                                                href="{{ route('admin.flight.void.single.ticket', encrypt($ticket->id)) }}"
                                                                                onclick="return confirm('Are you sure to void? You can not revert it.')"><i
                                                                                    class="icon-copy fi-skull"></i>
                                                                                Void</a>
                                                                        @else
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                No tickets issued yet
                                            @endif
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="flights" role="tabpanel">
                                        <div class="pd-20">

                                            @php
                                                $flights = json_decode($booking->flights, true);
                                                foreach ($flights['flight'] as $flight) {
                                                    foreach ($flight['sectors'] as $v) {
                                                        echo '<div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <i class="icon-copy fa fa-plane" aria-hidden="true" style="transform:rotate(20deg)"></i><br>' .
                                                            $v['departdate'] .
                                                            '<br>' .
                                                            $v['departtime'] .
                                                            '
                                                        <br>' .
                                                            $v['departure'] .
                                                            '<hr>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <i class="icon-copy fa fa-plane" aria-hidden="true" style="transform:rotate(70deg)"></i><br>' .
                                                            $v['arrivaldate'] .
                                                            '<br>' .
                                                            $v['arrivaltime'] .
                                                            '
                                                        <br>' .
                                                            $v['arrival'] .
                                                            '<hr>
                                                        </div>
                                                      </div>
                                                      Flight Number <i class="icon-copy fa fa-arrow-right" aria-hidden="true"></i> ' .
                                                            $v['flightnumber'] .
                                                            '<br> Class <i class="icon-copy fa fa-arrow-right" aria-hidden="true"></i> ' .
                                                            $v['class'] .
                                                            '<br>
                                                      Flight Time <i class="icon-copy fa fa-arrow-right" aria-hidden="true"></i> ' .
                                                            $v['flighttime'] .
                                                            '<br>
                                                      Operating Airline <i class="icon-copy fa fa-arrow-right" aria-hidden="true"></i> ' .
                                                            $v['operatingairline'] .
                                                            '<br>
                                                      Marketing Airline <i class="icon-copy fa fa-arrow-right" aria-hidden="true"></i> ' .
                                                            $v['marketingairline'] .
                                                            '<br>
                                                      ResBookCode <i class="icon-copy fa fa-arrow-right" aria-hidden="true"></i> ' .
                                                            $v['resbook'] .
                                                            '<br>
                                                      <hr style="height:1px;background-color:#cb2127">';
                                                    }
                                                }

                                            @endphp
                                        </div>

                                    </div>
                                    <div class="tab-pane fade" id="passengers" role="tabpanel">
                                        <div class="pd-20">

                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">PAX</th>
                                                            <th scope="col">Type/Gender</th>
                                                            <th scope="col">DOB/Nationality</th>
                                                            <th scope="col">Doc Type/Number</th>
                                                            <th scope="col">Doc Expiry Date/Issuer</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($booking->bookingDetails as $pax)
                                                            <tr>
                                                                <th scope="row">{{ $loop->iteration ?? '' }}</th>
                                                                <th scope="row">{{ $pax->pax_title ?? '' }}
                                                                    {{ $pax->pax_first_name ?? '' }}
                                                                    {{ $pax->pax_mid_name ?? '' }}
                                                                    {{ $pax->pax_last_name ?? '' }}</th>
                                                                <th scope="row">{{ $pax->pax_type ?? '' }}
                                                                    / {{ $pax->pax_gender ?? '' }}</th>
                                                                <th scope="row">{{ $pax->dob ?? '' }}
                                                                    / {{ $pax->nationality ?? '' }}</th>
                                                                <th scope="row">{{ $pax->doc_type ?? '' }}
                                                                    / {{ $pax->doc_number ?? '' }}</th>
                                                                <th scope="row">{{ $pax->doc_expiry_date ?? '' }}
                                                                    / {{ $pax->doc_issued_by ?? '' }}</th>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            {{--                                        @endforeach --}}
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pricing" role="tabpanel">
                                        <div class="pd-20">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4 col-sm-12">
                                                    <h4 class="mb-30">Index</h4>
                                                    <dd>Base Fare</dd>
                                                    <dd>Tax</dd>
                                                    <dd>Total Fare</dd>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-12">
                                                    <h4 class="mb-30">BSP Fare</h4>
                                                    <dd>{{ json_decode($booking->air_price, true)['basefare'] ?? '' }}</dd>
                                                    <dd>{{ json_decode($booking->air_price, true)['tax'] ?? '' }}</dd>
                                                    <dd>{{ json_decode($booking->air_price, true)['total'] ?? '' }}</dd>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-12">
                                                    <h4 class="mb-30">Final Fare</h4>
                                                    <dd>{{ json_decode($booking->air_price, true)['mbasefare'] ?? '' }}
                                                    </dd>
                                                    <dd>{{ json_decode($booking->air_price, true)['tax'] ?? '' }}</dd>
                                                    <dd>{{ json_decode($booking->air_price, true)['markedfare'] ?? '' }}
                                                    </dd>
                                                </div>
                                            </div>
                                        </div>
                                        <hr style="height:1px;background-color:#cb2127">
                                        <div class="pd-20">
                                            {{-- {{ dd(json_decode($booking->flights,true)) }} --}}

                                            @foreach (json_decode($booking->flights, true)['breakdown'] as $breakdown)
                                                {{-- {{ dd($breakdown) }} --}}
                                                <h4 class="mb-30 align-center"><strong>PAX {{ $breakdown['type'] ?? 0 }}
                                                        * {{ $breakdown['qty'] ?? 0 }}</strong></h4>
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                                        <h4 class="mb-30">Index</h4>
                                                        <dd>Base Fare</dd>
                                                        <dd>Tax</dd>
                                                        <dd>Markup</dd>
                                                        {{-- {{ dd($booking) }} --}}
                                                        @if ($booking->bookedBy()->exists())
                                                            @if ($booking->bookedBy->hasRole('Agent'))
                                                                <dd>Commission</dd>
                                                            @endif
                                                        @endif
                                                        <dd>Total Fare</dd>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                                        <h4 class="mb-30">BSP Fare</h4>
                                                        <dd>{{ $breakdown['basefare'] ?? '' }}</dd>
                                                        <dd>{{ $breakdown['tax'] ?? '' }}</dd>
                                                        <dd>{{ $booking->currency ?? '' }}
                                                            @isset($breakdown['markup'])
                                                                {{ $breakdown['markup'] ?? '' }}
                                                            @else
                                                                0
                                                            @endisset
                                                        </dd>
                                                        @if ($booking->bookedBy()->exists())
                                                            @if ($booking->bookedBy->hasRole('Agent'))
                                                                <dd>{{ $booking->currency ?? '' }}
                                                                    @isset($breakdown['commission'])
                                                                        {{ $breakdown['commission'] }}
                                                                    @else
                                                                        0
                                                                    @endisset
                                                                </dd>
                                                            @endif
                                                        @endif
                                                        <dd>{{ $breakdown['total'] ?? '' }}</dd>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                                        <h4 class="mb-30">Final Fare</h4>
                                                        <dd>{{ $breakdown['mbasefare'] ?? '' }}</dd>
                                                        <dd>{{ $breakdown['tax'] ?? '' }}</dd>
                                                        <dd>-</dd>
                                                        @if ($booking->bookedBy()->exists())
                                                            @if ($booking->bookedBy->hasRole('Agent'))
                                                                <dd>-</dd>
                                                            @endif
                                                        @endif
                                                        <dd>{{ $breakdown['mtotal'] }}</dd>
                                                    </div>
                                                </div>
                                                <hr>
                                                <h5 class="mb-20"><strong>FareBasis Codes</strong></h5>

                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Origin</th>
                                                            <th>Destination</th>
                                                            <th>Airline</th>
                                                            <th>Fare Code</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($breakdown['farecodes'] as $code)
                                                            <tr>
                                                                <td>{{ $code['start'] ?? '' }}</td>
                                                                <td>{{ $code['end'] ?? '' }}</td>
                                                                <td>{{ $code['air'] ?? '' }}</td>
                                                                <td>{{ $code['code'] ?? '' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                @if (array_key_exists('taxbreakdown', $breakdown))
                                                    <hr>
                                                    <h5><strong>Tax Breakdown</strong></h5><br>
                                                    <div class="row">
                                                        <div class="col-lg-2 col-md-2 col-sm-12">
                                                            <dd>Code</dd>
                                                            <dd>Amount</dd>
                                                        </div>
                                                        @foreach ($breakdown['taxbreakdown'] as $tax)
                                                            <div class="col-lg-2 col-md-2 col-sm-12">
                                                                <dd>{{ $tax['code'] ?? '' }}</dd>
                                                                <dd>{{ $tax['amount'] ?? '' }}</dd>
                                                            </div>
                                                        @endforeach

                                                    </div>
                                                @endif
                                                <hr style="height:1px;background-color:#cb2127">
                                            @endforeach
                                        </div>

                                    </div>
                                    <div class="tab-pane fade" id="baggage" role="tabpanel">
                                        <div class="pd-20">
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Pax Type</th>
                                                            <th>Bag Type</th>
                                                            <th>Bag Unit</th>
                                                            <th>Description</th>

                                                            <th>Cabin/Meal</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach (json_decode($booking->flights, true)['baggage'] as $baggage)
                                                            <tr>
                                                                <td>{{ $baggage['pax'] ?? '' }}</td>
                                                                <td>{{ $baggage['type'] ?? '' }}</td>
                                                                <td>{{ $baggage['unit'] ?? '' }}</td>
                                                                <td>{{ $baggage['description'] ? $baggage['description'] : '-' }}
                                                                </td>
                                                                @if (isset($baggage['detail']))
                                                                    <td>
                                                                        @foreach ($baggage['detail'] as $de)
                                                                            {{ $de['cabin'] ?? '' }} /
                                                                            @if (is_array($de['meal']))
                                                                            @else
                                                                                {{ $de['meal'] ?? '' }}
                                                                            @endif -
                                                                        @endforeach
                                                                    </td>
                                                                @endif
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="penalty" role="tabpanel">
                                        <div class="pd-20">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Pax Type</th>
                                                        <th scope="col">Penalty</th>
                                                        <th scope="col">Applicability</th>
                                                        <th scope="col">Availability</th>
                                                        <th scope="col">Applicable Charges</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach (json_decode($booking->flights, true)['farepenalty'] as $penalty)
                                                        <tr>
                                                            <td> {{ $penalty['paxtype'] ?? '' }}</td>
                                                            <td>{{ $penalty['penaltytype'] ?? '' }}</td>
                                                            <td>{{ $penalty['applicable'] ?? '' }} Flight</td>
                                                            <td>{{ $penalty['status'] ? 'Yes' : 'No' }}</td>
                                                            <td> {{ $penalty['amount'] ?? '' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="actions" role="tabpanel">
                                        <div class="pd-20">

                                            <div class="row">
                                                <dt class="col-sm-4">Ticket Status</dt>
                                                <dd class="col-sm-8">{{ $booking->ticket_status ? 'Issued' : 'Pending' }}
                                                </dd>
                                                <dt class="col-sm-4">PNR Status</dt>
                                                <dd class="col-sm-8">
                                                    {{ isset($booking->pnr_id) ? ($booking->pnr_void ? 'Canceled' : 'Generated') : 'Not Generated' }}
                                                    <strong> {{ isset($booking->pnr_id) ? $booking->pnr_id : '' }}</strong>
                                                </dd>
                                            </div>

                                            @if (!isset($booking->pnr_id))
                                                <a class="btn btn-danger btn-lg btn-block"
                                                    href="{{ route('admin.flight.generate.pnr', $booking->booking_code) }}"
                                                    type="button">Generate
                                                    PNR</a>
                                            @endif

                                            @if (!isset($booking->ticket_details) && isset($booking->pnr_id) && !$booking->pnr_void)
                                                <a class="btn btn-success btn-lg btn-block" type="button"
                                                    href="{{ route('admin.flight.issue.ticket', $booking->booking_code) }}">Issue
                                                    Ticket</a>
                                            @else
                                                @isset($booking->ticket_details)
                                                    <a class="btn btn-success btn-lg btn-block" type="button"
                                                        target="_blank"
                                                        href="{{ route('show.ticket', $booking->booking_code) }}">View
                                                        Ticket</a>
                                                @endisset
                                            @endif
                                            @if (help_canPnrBeVoid($booking->booking_code))
                                                <a class="btn btn-danger btn-lg btn-block"
                                                    href="{{ route('admin.flight.void.pnr', $booking->booking_code) }}"
                                                    type="button">Void PNR</a>
                                            @endif
                                            <a class="btn btn-secondary btn-lg btn-block"
                                                href="{{ route('admin.view.files', $booking->search_flight_id) }}"
                                                target="_blank">View Log
                                                Files</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
