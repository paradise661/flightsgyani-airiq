@extends('layouts.admin.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary flex justify-between">
                <div class="box-header">
                    <strong>Flight Booking :-</strong> {{ $booking->booking_code ?? '' }}
                    <span class="bg-red-500 text-white text-xs px-2 rounded-md">
                        {{ $booking->api_provider ? strtoupper($booking->api_provider) : 'SABRE' }}
                    </span>
                </div>
                <div class="box-header">
                    <a class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400"
                        href="{{ route('v2.admin.flight.bookings') }}">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        @include('admin.v2.inc.messages')
        <div class="w-full mx-auto">

            <div class="w-full mx-auto bg-white p-6 rounded-lg shadow-xl">
                <!-- Tab Buttons -->
                <div class="flex space-x-6 border-b-2 pb-4 mb-6">
                    <button
                        class="tab-button w-full py-3 text-center text-gray-600 hover:text-white hover:bg-primary focus:outline-none"
                        id="tab1">
                        Contact Details
                    </button>
                    <button
                        class="tab-button w-full py-3 text-center text-gray-600 hover:text-white hover:bg-primary focus:outline-none"
                        id="tab2">
                        Flight Details
                    </button>
                    <button
                        class="tab-button w-full py-3 text-center text-gray-600 hover:text-white hover:bg-primary focus:outline-none"
                        id="tab3">
                        Passengers
                    </button>
                    <button
                        class="tab-button w-full py-3 text-center text-gray-600 hover:text-white hover:bg-primary focus:outline-none"
                        id="tab4">
                        Ticket Details
                    </button>
                    <button
                        class="tab-button w-full py-3 text-center text-gray-600 hover:text-white hover:bg-primary focus:outline-none"
                        id="tab5">
                        Pricing Details
                    </button>
                    <button
                        class="tab-button w-full py-3 text-center text-gray-600 hover:text-white hover:bg-primary focus:outline-none"
                        id="tab6">
                        Baggage Details
                    </button>
                    <button
                        class="tab-button w-full py-3 text-center text-gray-600 hover:text-white hover:bg-primary focus:outline-none"
                        id="tab7">
                        Fare Penalty
                    </button>
                    <button
                        class="tab-button w-full py-3 text-center text-gray-600 hover:text-white hover:bg-primary focus:outline-none"
                        id="tab8">
                        Action
                    </button>
                </div>

                <!-- Tab Content -->
                <div class="tab-content ">
                    <!-- Tab 1 Content -->
                    <div class="tab-panel tab-content-box hidden" id="content1">
                        {{-- <h2 class="text-xl font-semibold mb-3">Tab 1 Content</h2> --}}

                        <div class="p-5">
                            <dl class="space-y-4 text-gray-700">
                                <!-- Name -->
                                <div class="flex">
                                    <dt class="w-1/3 font-semibold">Name</dt>
                                    <dd class="w-2/3">{{ json_decode($booking->contact_details, true)['name'] ?? '' }}
                                        {{ json_decode($booking->contact_details, true)['mname'] ?? '' }}
                                        {{ json_decode($booking->contact_details, true)['lname'] ?? '' }}
                                    </dd>
                                </div>

                                <!-- Email -->
                                <div class="flex">
                                    <dt class="w-1/3 font-semibold">Email</dt>
                                    <dd class="w-2/3">{{ json_decode($booking->contact_details, true)['email'] ?? '' }}
                                    </dd>
                                </div>

                                <!-- Phone -->
                                <div class="flex">
                                    <dt class="w-1/3 font-semibold">Phone</dt>
                                    <dd class="w-2/3">{{ json_decode($booking->contact_details, true)['phone'] ?? '' }}
                                    </dd>
                                </div>

                                <hr>
                                @if ($booking->is_office_staff || ($booking->user && $booking->bookedBy->user_type == 'AGENT'))
                                    <h2><strong>{{ $booking->bookedBy->user_type == 'AGENT' ? 'Agent' : 'Staff ' }}
                                            Details</strong>
                                    </h2>
                                    <!-- Name -->
                                    <div class="flex">
                                        <dt class="w-1/3 font-semibold">Name</dt>
                                        <dd class="w-2/3">{{ $booking->bookedBy->name ?? '' }}
                                        </dd>
                                    </div>

                                    <!-- Email -->
                                    <div class="flex">
                                        <dt class="w-1/3 font-semibold">Email</dt>
                                        <dd class="w-2/3">{{ $booking->bookedBy->email ?? '' }}
                                        </dd>
                                    </div>

                                    <!-- Phone -->
                                    <div class="flex">
                                        <dt class="w-1/3 font-semibold">Phone</dt>
                                        <dd class="w-2/3">{{ $booking->bookedBy->phonenumber ?? '' }}
                                        </dd>
                                    </div>
                                @endif
                            </dl>
                        </div>

                    </div>
                    <!-- Tab 2 Content -->
                    <div class="tab-panel tab-content-box hidden" id="content2">
                        <div class="p-5">
                            @php
                                $flights = json_decode($booking->flights ?? '', true);
                            @endphp
                            @foreach ($flights['flight'] ?? [] as $flight)
                                @foreach ($flight['sectors'] ?? [] as $v)
                                    <div class="flex flex-wrap mb-4">
                                        <!-- Departure -->
                                        <div class="w-full sm:w-1/2 p-3">
                                            {{-- <i class="fa fa-plane text-2xl text-gray-600 transform rotate-12"></i> --}}
                                            <strong>Departure</strong>
                                            <p class="mt-2 text-gray-800">
                                                {{ $v['departdate'] ?? '' }}<br>{{ $v['departtime'] ?? '' }}<br>{{ $v['departure'] ?? '' }}
                                            </p>
                                        </div>

                                        <!-- Arrival -->
                                        <div class="w-full sm:w-1/2 p-3">
                                            <strong>Arrival</strong>
                                            {{-- <i class="fa fa-plane text-2xl text-gray-600 transform rotate-45"></i> --}}
                                            <p class="mt-2 text-gray-800">
                                                {{ $v['arrivaldate'] ?? '' }}<br>{{ $v['arrivaltime'] ?? '' }}<br>{{ $v['arrival'] ?? '' }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="text-gray-800 mb-4">
                                        <p class="mb-2"><span class="text-black-500">Flight Number:</span>
                                            {{ $v['flightnumber'] ?? '' }}
                                        </p>
                                        <p class="mb-2"><span class="text-black-500">Class:</span>
                                            {{ $v['class'] ?? '' }}
                                        </p>
                                        <p class="mb-2"><span class="text-black-500">Flight Time:</span>
                                            {{ $v['flighttime'] ?? '' }}
                                        </p>
                                        <p class="mb-2"><span class="text-black-500">Operating Airline:</span>
                                            {{ $v['operatingairline'] ?? '' }}
                                        </p>
                                        <p class="mb-2"><span class="text-black-500">Marketing Airline:</span>
                                            {{ $v['marketingairline'] ?? '' }}
                                        </p>
                                        <p class="mb-2"><span class="text-black-500">ResBookCode:</span>
                                            {{ $v['resbook'] ?? '' }}
                                        </p>
                                    </div>

                                    <hr class="my-4 border-t-2 border-red-600">
                                @endforeach
                            @endforeach

                        </div>

                    </div>
                    <!-- Tab 3 Content -->
                    <div class="tab-panel tab-content-box hidden" id="content3">
                        <div class="p-5">
                            <div class="overflow-x-auto">
                                <table class="min-w-full table-auto border-collapse">
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">#</th>
                                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">PAX</th>
                                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Type/Gender
                                            </th>
                                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">
                                                DOB/Nationality</th>
                                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Doc
                                                Type/Number</th>
                                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Doc Expiry
                                                Date/Issuer</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($booking->bookingDetails ?? [] as $pax)
                                            <tr class="border-b">
                                                <td class="px-4 py-2 text-sm text-gray-800">{{ $loop->iteration ?? '' }}
                                                </td>
                                                <td class="px-4 py-2 text-sm text-gray-800">{{ $pax->pax_title ?? '' }}
                                                    {{ $pax->pax_first_name ?? '' }} {{ $pax->pax_mid_name ?? '' }}
                                                    {{ $pax->pax_last_name ?? '' }}
                                                </td>
                                                <td class="px-4 py-2 text-sm text-gray-800">{{ $pax->pax_type ?? '' }} /
                                                    {{ $pax->pax_gender ?? '' }}
                                                </td>
                                                <td class="px-4 py-2 text-sm text-gray-800">{{ $pax->dob ?? '' }} /
                                                    {{ $pax->nationality ?? '' }}
                                                </td>
                                                <td class="px-4 py-2 text-sm text-gray-800">{{ $pax->doc_type ?? '' }} /
                                                    {{ $pax->doc_number ?? '' }}
                                                </td>
                                                <td class="px-4 py-2 text-sm text-gray-800">
                                                    {{ $pax->doc_expiry_date ?? '' }} /
                                                    {{ $pax->doc_issued_by ?? '' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <!-- Tab 4 Content -->
                    <div class="tab-panel tab-content-box hidden" id="content4">
                        <div class="p-5">
                            @if($booking->api_provider == 'airiq')
                                <div class="overflow-x-auto">
                                    <table class="min-w-full table-auto border-collapse">
                                        <thead>
                                            <tr class="bg-gray-100">
                                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">#</th>
                                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">PAX</th>
                                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Name
                                                </th>
                                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Ticket
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (json_decode($booking->airiq_ticket_details) ?? [] as $ticket)
                                                @foreach($ticket->Passengers as $mainTicket)
                                                    <tr class="border-b">
                                                        <td class="px-4 py-2 text-sm text-gray-800">
                                                            {{ $loop->iteration ?? '' }}
                                                        </td>
                                                        <td class="px-4 py-2 text-sm text-gray-800">
                                                            {{ $mainTicket->PaxType ?? '' }}
                                                        </td>
                                                        <td class="px-4 py-2 text-sm text-gray-800">
                                                            {{ $mainTicket->FirstName ?? '' }}
                                                            {{ $mainTicket->LastName ?? '' }}
                                                        </td>
                                                        <td class="px-4 py-2 text-sm text-gray-800">
                                                            {{ $mainTicket->TicketNumber ?? '' }}
                                                        </td>
                                                        <td class="px-4 py-2 text-sm text-gray-800">
                                                            {{ $mainTicket->ticket_reference ?? '' }}
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @elseif (isset($booking->ticket_details))
                                <div class="overflow-x-auto">
                                    <table class="min-w-full table-auto border-collapse">
                                        <thead>
                                            <tr class="bg-gray-100">
                                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">#</th>
                                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">PAX</th>
                                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Name
                                                </th>
                                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Ticket
                                                </th>
                                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">
                                                    Reference</th>
                                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Status
                                                </th>
                                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Voided
                                                    By</th>
                                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Void
                                                    Date</th>
                                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Actions
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($booking->getTickets ?? [] as $ticket)
                                                <tr class="border-b">
                                                    <td class="px-4 py-2 text-sm text-gray-800">
                                                        {{ $loop->iteration ?? '' }}
                                                    </td>
                                                    <td class="px-4 py-2 text-sm text-gray-800">
                                                        {{ $ticket->pax_type ?? '' }}
                                                    </td>
                                                    <td class="px-4 py-2 text-sm text-gray-800">
                                                        {{ $ticket->first_name ?? '' }}
                                                        {{ $ticket->last_name ?? '' }}
                                                    </td>
                                                    <td class="px-4 py-2 text-sm text-gray-800">
                                                        {{ $ticket->ticket_number ?? '' }}
                                                    </td>
                                                    <td class="px-4 py-2 text-sm text-gray-800">
                                                        {{ $ticket->ticket_reference ?? '' }}
                                                    </td>
                                                    <td class="px-4 py-2 text-sm">
                                                        <span
                                                            class="inline-block px-2 py-1 text-xs font-semibold {{ $ticket->status ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                                            {{ $ticket->status ? 'Not Void' : 'Void' }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-2 text-sm text-gray-800">
                                                        {{ isset($ticket->voided_by) ? $ticket->voidedBy->name : '' }}
                                                    </td>
                                                    <td class="px-4 py-2 text-sm text-gray-800">
                                                        {{ isset($ticket->void_date) ? $ticket->void_date : '' }}
                                                    </td>
                                                    <td class="px-4 py-2 text-sm">
                                                        @if ($ticket->status)
                                                            @if ($booking->api_provider !== 'airiq')
                                                                <a class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-xs font-semibold"
                                                                    href="{{ route('admin.flight.void.single.ticket', encrypt($ticket->id)) }}"
                                                                    onclick="return confirm('Are you sure to void? You cannot revert it.')">
                                                                    <i class="fi-skull"></i> Void
                                                                </a>
                                                            @endif
                                                        @else
                                                            <!-- Empty cell for the case when the ticket is already voided -->
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p>No tickets issued yet</p>
                            @endif
                        </div>

                    </div>
                    <!-- Tab 5 Content -->
                    <div class="tab-panel tab-content-box hidden" id="content5">
                        <div class="p-5">

                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                <!-- Index Column -->
                                <div class="bg-white p-4 rounded-lg shadow-md">
                                    <h4 class="mb-6 text-lg font-semibold text-gray-700">Index</h4>
                                    <dd class="text-gray-600">Base Fare</dd>
                                    <dd class="text-gray-600">Tax</dd>
                                    <dd class="text-gray-600">Total Fare</dd>
                                </div>

                                <!-- BSP Fare Column -->
                                <div class="bg-white p-4 rounded-lg shadow-md">
                                    <h4 class="mb-6 text-lg font-semibold text-gray-700">BSP Fare</h4>
                                    <dd class="text-gray-600">
                                        {{ json_decode($booking->air_price, true)['basefare'] ?? '' }}
                                    </dd>
                                    <dd class="text-gray-600">{{ json_decode($booking->air_price, true)['tax'] ?? '' }}
                                    </dd>
                                    <dd class="text-gray-600">{{ json_decode($booking->air_price, true)['total'] ?? '' }}
                                    </dd>
                                </div>

                                <!-- Final Fare Column -->
                                <div class="bg-white p-4 rounded-lg shadow-md">

                                    <h4 class="mb-6 text-lg font-semibold text-gray-700">Final Fare</h4>
                                    <dd class="text-gray-600">
                                        {{ json_decode($booking->air_price, true)['mbasefare'] ?? '' }}
                                    </dd>
                                    <dd class="text-gray-600">{{ json_decode($booking->air_price, true)['tax'] ?? '' }}
                                    </dd>
                                    <div class="flex justify-between">

                                        <dd class="text-gray-600">
                                            {{ json_decode($booking->air_price, true)['markedfare'] ?? '' }}
                                        </dd>
                                        <div class="text-green-500">
                                            Discount: {{ json_decode($booking->air_price, true)['discount'] ?? 0 }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-6 border-t border-red-600">

                            @foreach (json_decode($booking->flights, true)['breakdown'] ?? [] as $breakdown)
                                <h4 class="text-center mb-6 text-lg font-semibold"><strong>PAX
                                        {{ $breakdown['type'] ?? '' }} *
                                        {{ $breakdown['qty'] ?? '' }}</strong></h4>

                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                    <!-- Index Column -->
                                    <div class="bg-white p-4 rounded-lg shadow-md">
                                        <h4 class="mb-6 text-lg font-semibold text-gray-700">Index</h4>
                                        <dd class="text-gray-600">Base Fare</dd>
                                        <dd class="text-gray-600">Tax</dd>
                                        <dd class="text-gray-600">Markup</dd>
                                        @if ($booking->bookedBy()->exists())
                                            @if ($booking->bookedBy->hasRole('Agent'))
                                                <dd class="text-gray-600">Commission</dd>
                                            @endif
                                        @endif
                                        <dd class="text-gray-600">Total Fare</dd>
                                    </div>

                                    <!-- BSP Fare Column -->
                                    <div class="bg-white p-4 rounded-lg shadow-md">
                                        <h4 class="mb-6 text-lg font-semibold text-gray-700">BSP Fare</h4>
                                        <dd class="text-gray-600">{{ $breakdown['basefare'] ?? '' }}</dd>
                                        <dd class="text-gray-600">{{ $breakdown['tax'] ?? '' }}</dd>
                                        <dd class="text-gray-600">{{ $booking->currency ?? '' }}
                                            @isset($breakdown['markup'])
                                                {{ $breakdown['markup'] }}
                                            @else
                                                0
                                            @endisset
                                        </dd>
                                        @if ($booking->bookedBy()->exists())
                                            @if ($booking->bookedBy->hasRole('Agent'))
                                                <dd class="text-gray-600">{{ $booking->currency }}
                                                    @isset($breakdown['commission'])
                                                        {{ $breakdown['commission'] }}
                                                    @else
                                                        0
                                                    @endisset
                                                </dd>
                                            @endif
                                        @endif
                                        <dd class="text-gray-600">{{ $breakdown['total'] ?? '' }}</dd>
                                    </div>

                                    <!-- Final Fare Column -->
                                    <div class="bg-white p-4 rounded-lg shadow-md">
                                        <h4 class="mb-6 text-lg font-semibold text-gray-700">Final Fare</h4>
                                        <dd class="text-gray-600">{{ $breakdown['mbasefare'] ?? '' }}</dd>
                                        <dd class="text-gray-600">{{ $breakdown['tax'] ?? '' }}</dd>
                                        <dd class="text-gray-600">-</dd>
                                        @if ($booking->bookedBy()->exists())
                                            @if ($booking->bookedBy->hasRole('Agent'))
                                                <dd class="text-gray-600">-</dd>
                                            @endif
                                        @endif
                                        <dd class="text-gray-600">{{ $breakdown['mtotal'] ?? '' }}</dd>
                                    </div>
                                </div>

                                <hr class="my-6 border-t border-red-600">

                                <h5 class="mb-4 text-lg font-semibold"><strong>FareBasis Codes</strong></h5>
                                <table class="min-w-full bg-white table-auto border-collapse rounded-lg shadow-md">
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Origin</th>
                                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Destination
                                            </th>
                                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Airline
                                            </th>
                                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Fare Code
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($breakdown['farecodes'] ?? [] as $code)
                                            <tr class="border-b">
                                                <td class="px-4 py-2 text-sm text-gray-600">{{ $code['start'] ?? '' }}
                                                </td>
                                                <td class="px-4 py-2 text-sm text-gray-600">{{ $code['end'] ?? '' }}</td>
                                                <td class="px-4 py-2 text-sm text-gray-600">{{ $code['air'] ?? '' }}</td>
                                                <td class="px-4 py-2 text-sm text-gray-600">{{ $code['code'] ?? '' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                @if (array_key_exists('taxbreakdown', $breakdown))
                                    <hr class="my-6 border-t border-red-600">
                                    <h5 class="mb-4 text-lg font-semibold"><strong>Tax Breakdown</strong></h5>
                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                        <div>
                                            <dd class="text-gray-600">Code</dd>
                                            <dd class="text-gray-600">Amount</dd>
                                        </div>
                                        @foreach ($breakdown['taxbreakdown'] ?? [] as $tax)
                                            <div>
                                                <dd class="text-gray-600">{{ $tax['code'] ?? '' }}</dd>
                                                <dd class="text-gray-600">{{ $tax['amount'] ?? '' }}</dd>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <hr class="my-6 border-t border-red-600">
                            @endforeach
                        </div>

                    </div>
                    <!-- Tab 6 Content -->
                    <div class="tab-panel tab-content-box hidden" id="content6">
                        <div class="p-5">
                            <div class="overflow-x-auto">
                                <table class="min-w-full table-auto bg-white border-collapse rounded-lg shadow-md">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="px-6 py-3 text-sm font-semibold text-left text-gray-700">Pax Type
                                            </th>
                                            <th class="px-6 py-3 text-sm font-semibold text-left text-gray-700">Bag Type
                                            </th>
                                            <th class="px-6 py-3 text-sm font-semibold text-left text-gray-700">Bag Unit
                                            </th>
                                            <th class="px-6 py-3 text-sm font-semibold text-left text-gray-700">Description
                                            </th>
                                            <th class="px-6 py-3 text-sm font-semibold text-left text-gray-700">Cabin/Meal
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (json_decode($booking->flights, true)['baggage'] ?? [] as $baggage)
                                            <tr class="border-b">
                                                <td class="px-6 py-4 text-sm text-gray-600">{{ $baggage['pax'] ?? '' }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-600">{{ $baggage['type'] ?? '' }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-600">{{ $baggage['unit'] ?? '' }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-600">
                                                    {{ $baggage['description'] ? $baggage['description'] : '-' }}
                                                </td>
                                                @if (isset($baggage['detail']))
                                                    <td class="px-6 py-4 text-sm text-gray-600">
                                                        @foreach ($baggage['detail'] as $de)
                                                            {{ $de['cabin'] }} /
                                                            @if (is_array($de['meal']))
                                                                <!-- Handle if meal is an array -->
                                                            @else
                                                                {{ $de['meal'] }}
                                                            @endif
                                                            -
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
                    <!-- Tab 7 Content -->
                    <div class="tab-panel tab-content-box hidden" id="content7">
                        <div class="p-5">
                            <div class="overflow-x-auto">
                                <table class="min-w-full table-auto bg-white border-collapse rounded-lg shadow-md">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="px-6 py-3 text-sm font-semibold text-left text-gray-700">Pax Type
                                            </th>
                                            <th class="px-6 py-3 text-sm font-semibold text-left text-gray-700">Penalty
                                            </th>
                                            <th class="px-6 py-3 text-sm font-semibold text-left text-gray-700">
                                                Applicability</th>
                                            <th class="px-6 py-3 text-sm font-semibold text-left text-gray-700">
                                                Availability</th>
                                            <th class="px-6 py-3 text-sm font-semibold text-left text-gray-700">Applicable
                                                Charges</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (json_decode($booking->flights, true)['farepenalty'] ?? [] as $penalty)
                                            <tr class="border-b hover:bg-gray-50">
                                                <td class="px-6 py-4 text-sm text-gray-600">
                                                    {{ $penalty['paxtype'] ?? '' }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-600">
                                                    {{ $penalty['penaltytype'] ?? '' }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-600">
                                                    {{ $penalty['applicable'] ?? '' }}
                                                    Flight
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-600">
                                                    {{ $penalty['status'] ? 'Yes' : 'No' }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-600">{{ $penalty['amount'] ?? '' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <!-- Tab 8 Content -->
                    <div class="tab-panel tab-content-box hidden" id="content8">
                        <div class="p-5">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-gray-600 font-semibold">Ticket Status</dt>
                                    <dd class="text-gray-800">{{ $booking->ticket_status ? 'Issued' : 'Pending' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-600 font-semibold">PNR Status</dt>
                                    @if ($booking->api_provider == 'airiq')
                                        <dd class="text-gray-800">
                                           <p>{{ isset($booking->airiq_ticket_details) ? 'Generated' : 'Not Generated' }}</p> 
                                            AIRIQ PNR: 
                                            @foreach (json_decode($booking->airiq_ticket_details) ?? [] as $k => $ispnr)
                                                <strong>
                                                    @if ($k > 0)
                                                        /
                                                    @endif
                                                    {{ $ispnr->AirIqPNR }} 
                                                </strong>
                                            @endforeach
                                            <br>
                                             AIRLINE PNR: 
                                            @foreach (json_decode($booking->airiq_ticket_details) ?? [] as $ke => $getpnr)
                                                <strong>
                                                    @if ($ke > 0)
                                                        /
                                                    @endif
                                                    {{ $getpnr->Passengers[$ke]->Details[0]->AirlinePNR }} 
                                                </strong>
                                            @endforeach
                                        </dd>
                                    @else
                                        <dd class="text-gray-800">
                                            {{ isset($booking->pnr_id) ? ($booking->pnr_void ? 'Canceled' : 'Generated') : 'Not Generated' }}
                                            <strong> {{ isset($booking->pnr_id) ? $booking->pnr_id : '' }}</strong>
                                        </dd>
                                    @endif
                                </div>
                            </div>

                            @if (!isset($booking->pnr_id))
                                @if ($booking->api_provider !== 'airiq')
                                    <a class="mt-4 inline-block w-auto px-6 py-2 bg-red-600 text-white rounded-md text-sm font-medium text-center hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
                                        href="{{ route('admin.flight.generate.pnr', $booking->booking_code) }}">
                                        Generate PNR
                                    </a>
                                @endif
                            @endif

                            @if ($booking->api_provider == 'airiq')
                                <a class="mt-4 inline-block w-auto px-6 py-2 bg-green-600 text-white rounded-md text-sm font-medium text-center hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500"
                                    href="{{ route('viewTicket', ['booking_code' => $booking->booking_code, 'email' => json_decode($booking->contact_details, true)['email'] ?? '', 'type' => 'international']) }}"
                                    target="_blank">
                                    View Ticket
                                </a>
                            @endif
                            @if (!isset($booking->ticket_details) && isset($booking->pnr_id) && !$booking->pnr_void)
                                @if ($booking->api_provider !== 'airiq')
                                    <a class="mt-4 inline-block w-auto px-6 py-2 bg-green-600 text-white rounded-md text-sm font-medium text-center hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500"
                                        href="{{ route('admin.flight.issue.ticket', $booking->booking_code) }}">
                                        Issue Ticket
                                    </a>
                                @endif
                            @else
                                @isset($booking->ticket_details)
                                    <a class="mt-4 inline-block w-auto px-6 py-2 bg-green-600 text-white rounded-md text-sm font-medium text-center hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500"
                                        href="{{ route('viewTicket', ['booking_code' => $booking->booking_code, 'email' => json_decode($booking->contact_details, true)['email'] ?? '', 'type' => 'international']) }}"
                                        target="_blank">
                                        View Ticket
                                    </a>
                                    {{-- <a
                                        class="mt-4 inline-block w-auto px-6 py-2 bg-green-600 text-white rounded-md text-sm font-medium text-center hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500"
                                        href="{{ route('show.ticket', $booking->booking_code) }}" target="_blank">
                                        View Ticket
                                    </a> --}}
                                @endisset
                            @endif

                            @if ($booking->api_provider !== 'airiq')
                                @if (help_canPnrBeVoid($booking->booking_code))
                                    <a class="mt-4 inline-block w-auto px-6 py-2 bg-red-600 text-white rounded-md text-sm font-medium text-center hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
                                        href="{{ route('admin.flight.void.pnr', $booking->booking_code) }}">
                                        Void PNR
                                    </a>
                                @endif
                            @endif

                            @if ($booking->api_provider !== 'airiq')
                                <a class="mt-4 inline-block w-auto px-6 py-2 bg-gray-600 text-white rounded-md text-sm font-medium text-center hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500"
                                    href="{{ route('admin.view.files', $booking->search_flight_id) }}" target="_blank">
                                    View Log Files
                                </a>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function () {
                    // Initially activate the first tab
                    $('#tab1').addClass('active bg-primary text-white');
                    $('#content1').removeClass('hidden').addClass('tab-panel-visible');

                    // Event listener for tab clicks
                    $('.tab-button').click(function () {
                        // Remove active class from all tabs and hide all content
                        $('.tab-button').removeClass('active bg-primary text-white');
                        $('.tab-panel').removeClass('tab-panel-visible').addClass('hidden');

                        // Get the id of the clicked tab and set it as active
                        var tabId = $(this).attr('id');
                        var contentId = '#content' + tabId.replace('tab', '');

                        // Add active class to the clicked tab and show the content
                        $(this).addClass('active bg-primary text-white');
                        $(contentId).removeClass('hidden').addClass('tab-panel-visible');
                    });
                });
            </script>
        </div>

    </div>
@endsection