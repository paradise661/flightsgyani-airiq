@extends('layouts.user-dashboard')

@section('content')
    <h4 class="text-2xl font-semibold">Bookings</h4>
    <div class="mt-3 booking-details flex flex-col gap-1">
        <div class="text-lg font-medium">{{ $booking->booking_code ?? '' }}</div>
        {{-- <div class="text-sm font-normal">
            Booked By :- Paradise Destination Pvt. Ltd
        </div> --}}
        <div class="text-lg font-medium">PNR : {{ $booking->pnr_id ?? 'Not generated' }}</div>
        <div class="text-sm font-semibold">
            Payment Status: {{ $booking->payment_status ? 'Paid' : 'Unpaid' }}
        </div>
    </div>

    <div class="mt-3">
        <nav class="flex gap-x-1 overflow-x-auto" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
            <button type="button"
                class="hs-tab-active:bg-primary hs-tab-active:text-white hs-tab-active:hover:text-white hs-tab-active: py-3 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm font-medium text-center text-gray-500 hover:text-primary focus:outline-none focus:text-primary rounded-lg disabled:opacity-50 disabled:pointer-events-none active"
                id="booking-detail-item-1" aria-selected="true" data-hs-tab="#booking-detail-1"
                aria-controls="booking-detail-1" role="tab">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-plane-departure"></i>
                    Flight
                </div>
            </button>
            <button type="button"
                class="hs-tab-active:bg-primary hs-tab-active:text-white hs-tab-active:hover:text-white hs-tab-active: py-3 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm font-medium text-center text-gray-500 hover:text-primary focus:outline-none focus:text-primary rounded-lg disabled:opacity-50 disabled:pointer-events-none"
                id="booking-detail-item-2" aria-selected="false" data-hs-tab="#booking-detail-2"
                aria-controls="booking-detail-2" role="tab">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-user-group"></i>
                    Passengers
                </div>
            </button>
            <button type="button"
                class="hs-tab-active:bg-primary hs-tab-active:text-white hs-tab-active:hover:text-white hs-tab-active: py-3 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm font-medium text-center text-gray-500 hover:text-primary focus:outline-none focus:text-primary rounded-lg disabled:opacity-50 disabled:pointer-events-none"
                id="booking-detail-item-3" aria-selected="false" data-hs-tab="#booking-detail-3"
                aria-controls="booking-detail-3" role="tab">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-ticket"></i>
                    Ticket
                </div>
            </button>
            <button type="button"
                class="hs-tab-active:bg-primary hs-tab-active:text-white hs-tab-active:hover:text-white hs-tab-active: py-3 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm font-medium text-center text-gray-500 hover:text-primary focus:outline-none focus:text-primary rounded-lg disabled:opacity-50 disabled:pointer-events-none"
                id="booking-detail-item-4" aria-selected="false" data-hs-tab="#booking-detail-4"
                aria-controls="booking-detail-4" role="tab">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-money-bill"></i>
                    Pricing
                </div>
            </button>
            {{-- <button type="button"
                class="hs-tab-active:bg-primary hs-tab-active:text-white hs-tab-active:hover:text-white hs-tab-active: py-3 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm font-medium text-center text-gray-500 hover:text-primary focus:outline-none focus:text-primary rounded-lg disabled:opacity-50 disabled:pointer-events-none"
                id="booking-detail-item-5" aria-selected="false" data-hs-tab="#booking-detail-5"
                aria-controls="booking-detail-5" role="tab">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-cart-flatbed-suitcase"></i>
                    Pricing
                </div>
            </button> --}}
            <button type="button"
                class="hs-tab-active:bg-primary hs-tab-active:text-white hs-tab-active:hover:text-white hs-tab-active: py-3 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm font-medium text-center text-gray-500 hover:text-primary focus:outline-none focus:text-primary rounded-lg disabled:opacity-50 disabled:pointer-events-none"
                id="booking-detail-item-6" aria-selected="false" data-hs-tab="#booking-detail-6"
                aria-controls="booking-detail-6" role="tab">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-gear"></i>
                    Actions
                </div>
            </button>
        </nav>

        <div class="mt-3">
            <div id="booking-detail-1" role="tabpanel" aria-labelledby="booking-detail-item-1">
                <div class="detail-wrap">
                    @php
                        $flights = json_decode($booking['flights'] ?? '', true);
                    @endphp
                    {{-- @dd($flights) --}}
                    @foreach ($flights['flight'] ?? [] as $flight)
                        @foreach ($flight['sectors'] ?? [] as $sector)
                            <div class="grid grid-col-1 md:grid-cols-12 px-4 gap-1">
                                <div class="col-span-2">
                                    <div class="logo-sec">
                                        <img
                                            src="{{ URL::asset('/frontend/air-logos/' . ($sector['marketingairline'] ?? '') . '.png') }}" />
                                        <span class="title">BDT 4,271</span>
                                    </div>
                                </div>
                                <div class="col-span-10">
                                    <div class="airport-part">
                                        <div class="airport-name min-w-fit">
                                            <h4 class="city-name">{{ $sector['departure'] ?? '' }}</h4>
                                            <h4 class="date">
                                                {{ \Carbon\Carbon::parse($sector['departdate'] ?? '')->format('D M d, Y') }}
                                            </h4>
                                            <h3 class="time">
                                                {{ \Carbon\Carbon::parse($sector['departtime'] ?? '')->format('H:i') }}
                                            </h3>
                                        </div>
                                        <div class="airport-progress">
                                            <i class="fa-solid fa-circle text-secondary float-start"></i>
                                            <i class="fa-solid fa-circle text-secondary float-end"></i>
                                            <div class="stop-time">{{ $sector['elapstime'] ?? '' }}</div>
                                            <div class="stop">{{ $sector['stops'] ?? '' }} Stop</div>
                                        </div>
                                        <div class="airport-name arrival min-w-fit">
                                            <h4 class="city-name">{{ $sector['arrival'] ?? '' }}</h4>
                                            <h4 class="date">
                                                {{ \Carbon\Carbon::parse($sector['arrivaldate'] ?? '')->format('D M d, Y') }}
                                            </h4>
                                            <h3 class="time">
                                                {{ \Carbon\Carbon::parse($sector['arrivaltime'] ?? '')->format('H:i') }}
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
            <div id="booking-detail-2" class="hidden" role="tabpanel" aria-labelledby="booking-detail-item-2">
                @php
                    $contact = json_decode($booking['contact_details'] ?? '', true);
                    $passangers = $booking->bookingDetails()->get() ?? [];
                @endphp
                <div>
                    <div class="text-center">
                        <h6 class="text-lg font-medium">Contact Details</h6>
                        <div class="flex justify-center gap-5 mt-2">
                            <div class="bg-primary-background px-3 py-2 text-sm font-medium rounded-lg">
                                {{ $contact['name'] ?? '' }} {{ $contact['lname'] ?? '' }}
                            </div>
                            <div class="bg-primary-background px-3 py-2 text-sm font-medium rounded-lg">
                                {{ $contact['email'] ?? '' }}
                            </div>
                            <div class="bg-primary-background px-3 py-2 text-sm font-medium rounded-lg">
                                {{ $contact['phone'] ?? '' }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="text-center">
                        <h6 class="text-lg font-medium">Passenger Details</h6>
                    </div>
                    <div class="flex flex-col">
                        <div class="-m-1.5 overflow-x-auto">
                            <div class="p-1.5 min-w-full inline-block align-middle">
                                <div class="overflow-hidden">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead>
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                    Name
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                    Age
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                    Nationality
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($passangers ?? [] as $passanger)
                                                <tr class="odd:bg-white even:bg-gray-100 hover:bg-gray-100">
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                        {{ $passanger['pax_first_name'] ?? '' }}
                                                        {{ $passanger['pax_middle_name'] ?? '' }}
                                                        {{ $passanger['pax_last_name'] ?? '' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                        {{ \Carbon\Carbon::parse($passanger['dob'])->age ?? '' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                        {{ $passanger['nationality'] ?? '' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="booking-detail-3" class="hidden" role="tabpanel" aria-labelledby="booking-detail-item-3">
                <div class="flex justify-center">
                    @if ($booking->ticket_status ?? '')
                        <a href="{{ route('show.ticket', $booking->booking_code) }}"
                            class="inline-flex items-center text-xs bg-primary font-medium px-3 py-2 rounded-lg border border-transparent text-white focus:outline-none disabled:opacity-50 disabled:pointer-events-none">
                            View
                            Ticket</a>
                    @else
                        <div class="bg-primary-background px-3 py-2 text-sm font-medium rounded-lg">

                            Ticket not Issued
                        </div>
                    @endif
                </div>
            </div>
            <div id="booking-detail-4" class="hidden" role="tabpanel" aria-labelledby="booking-detail-item-4">
                <div class="flex flex-col">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="overflow-hidden">
                            @php
                            $pricing = (json_decode($booking->air_price ?? '', true))
                            @endphp
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                Base Fair
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                TAX
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                Total
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd:bg-white even:bg-gray-100 hover:bg-gray-100">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                {{$pricing['basefare'] ?? ''}}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                {{$pricing['tax'] ?? ''}}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                {{$pricing['total'] ?? ''}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            {{-- <div id="booking-detail-5" class="hidden" role="tabpanel" aria-labelledby="booking-detail-item-5">
                <div class="flex flex-col">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                Name
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                Age
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                Address
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd:bg-white even:bg-gray-100 hover:bg-gray-100">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                John Brown
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                45
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                New York No. 1 Lake Park
                                            </td>
                                        </tr>

                                        <tr class="odd:bg-white even:bg-gray-100 hover:bg-gray-100">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                Jim Green
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                27
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                London No. 1 Lake Park
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div id="booking-detail-6" class="hidden" role="tabpanel" aria-labelledby="booking-detail-item-6">
                <div class="flex justify-center">
                    <div class="bg-primary-background px-3 py-2 text-sm font-medium rounded-lg">
                        Sorry no further actions available for this booking.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
