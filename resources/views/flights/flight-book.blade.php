@extends('layouts.front')
@section('title')
Passenger Details
@endsection
@section('body')
<!-- Banner  -->
<div class="banner h-[100px] md:h-[175px] w-full overflow-hidden relative flex items-end justify-center">
    <img class="absolute top-0 right-0 hidden md:block" src="{{ asset('images/banner-plane.png') }}" alt="" />
    <div class="max-h-fit text-center items-baseline">
        <h4 class="text-white text-4xl font-bold tracking-wide z-10 relative">
            Traveller's Details
        </h4>
        <ol class="flex items-center justify-center whitespace-nowrap p-2">
            <li class="inline-flex items-center">
                <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600"
                    href="#">
                    <svg class="icon flat-color" id="home-alt-3" data-name="Flat Color" fill="#000000" width="20px"
                        height="20px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path id="primary"
                                d="M21.71,11.29l-9-9a1,1,0,0,0-1.42,0l-9,9a1,1,0,0,0-.21,1.09A1,1,0,0,0,3,13H4v7.3A1.77,1.77,0,0,0,5.83,22H8.5a1,1,0,0,0,1-1V16.1a1,1,0,0,1,1-1h3a1,1,0,0,1,1,1V21a1,1,0,0,0,1,1h2.67A1.77,1.77,0,0,0,20,20.3V13h1a1,1,0,0,0,.92-.62A1,1,0,0,0,21.71,11.29Z"
                                style="fill: #ffffff"></path>
                        </g>
                    </svg>
                </a>
                <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path d="M10 7L15 12L10 17" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </g>
                </svg>
            </li>
            <li class="inline-flex items-center">
                <a class="flex text-lg font-medium text-white truncate items-center hover:text-primary focus:outline-none focus:text-secondary"
                    href="#">
                    Flights
                </a>
                <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path d="M10 7L15 12L10 17" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </g>
                </svg>
            </li>

            <li class="text-lg font-medium text-gray-300 truncate" aria-current="page">
                Details
            </li>
        </ol>
    </div>
</div>
<!-- /Banner  -->

@foreach ($flights['detail'] as $flightKey => $flightDetail)
<!-- Flight Details Heading Accordion  -->
<div class="flight-details-accordion mt-4 md:mt-8">
    <div class="container mx-auto">
        <div class="hs-accordion-group bg-white rounded-lg shadow-md px-0 md:px-6 py-4">
            <div class="hs-accordion" id="hs-basic-with-title-and-arrow-stretched-heading-two">
                <button
                    class="hs-accordion-toggle overflow-hidden hs-accordion-active:text-blue-600 py-3 px-4 inline-flex items-center justify-between gap-x-3 w-full font-semibold text-start text-gray-800 hover:text-gray-500 disabled:opacity-50 disabled:pointer-events-none"
                    aria-expanded="false" aria-controls="hs-basic-with-title-and-arrow-stretched-collapse-two">
                    <div>
                        <h3 class="text-xl font-semibold tracking-wider text-gray-700">
                            {{ $flightDetail['origin'] }} to {{ $flightDetail['destination'] }}
                        </h3>
                        <p class="text-sm font-medium tracking-wide text-gray-400">
                            Departure On {{ \Carbon\Carbon::parse($flightDetail['origindate'])->format('M d, Y') }}
                            At {{ $flightDetail['origintime'] }} Direct Flight Travel Time
                            {{ $flightDetail['totaltime'] }}
                        </p>
                    </div>
                    <svg class="hs-accordion-active:hidden block size-5" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m6 9 6 6 6-6"></path>
                    </svg>
                    <svg class="hs-accordion-active:block hidden size-5" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m18 15-6-6-6 6"></path>
                    </svg>
                </button>
                <div class="hs-accordion-content hidden w-full overflow-hidden px-2 md:px-4 py-4 transition-[height] duration-300"
                    id="hs-basic-with-title-and-arrow-stretched-collapse-two" role="region"
                    aria-labelledby="hs-basic-with-title-and-arrow-stretched-heading-two">
                    @foreach ($flights['flight'][$flightKey]['sectors'] as $sector)
                    <div class="accordion-flight-detail rounded-lg overflow-hidden shadow-md mb-4">
                        <div
                            class="bg-primary w-full px-4 py-3 flex items-center justify-center gap-2 text-base">
                            <div class="flex items-center justify-center gap-3">
                                <i class="fa-solid fa-plane-departure text-white"></i>
                                <p class="text-white text-base font-bold tracking-wider">
                                    {{ $sector['departure'] }}
                                </p>
                                <i class="fa-solid fa-minus text-white"></i>
                                <p class="text-white text-base font-bold tracking-wider">
                                    {{ $sector['arrival'] }}
                                </p>
                                <i class="fa-solid fa-plane-arrival text-white"></i>
                            </div>
                        </div>
                        <div class="bg-white py-3 px-3 md:px-14">
                            <div class="traveller-flights">
                                <div class="airport-name md:min-w-fit">
                                    <h4 class="text-sm font-medium text-gray-500 text-start">
                                         {{ \Carbon\Carbon::parse($sector['departdate'])->format('D M d, Y') }}
                                    </h4>
                                    <h4 class="text-base font-semibold text-gray-700 text-start">
                                        {{ $sector['departport'] }}
                                    </h4>
                                    <h4 class="text-base font-semibold text-gray-500 text-start">
                                        {{ \Carbon\Carbon::parse($sector['departtime'])->format('H:i:s') }}
                                    </h4>
                                </div>

                                <div class="airport-progress">
                                    <i class="fa-regular fa-circle-dot text-primary float-start"></i>
                                    <i class="fa-regular fa-circle-dot text-primary float-end"></i>
                                </div>

                                <div class="airport-name arrival md:min-w-fit">
                                    <h4 class="text-sm font-medium text-gray-500 text-start">
                                        {{ \Carbon\Carbon::parse($sector['arrivaldate'])->format('D M d, Y') }}
                                    </h4>
                                    <h4 class="text-base font-semibold text-gray-700 text-start">
                                        {{ $sector['arrivalport'] }}
                                    </h4>
                                    <h4 class="text-base font-semibold text-gray-500 text-start">
                                        {{ \Carbon\Carbon::parse($sector['arrivaltime'])->format('H:i:s') }}
                                    </h4>
                                </div>
                            </div>
                            <div class="flex gap-4 md:gap-6 mt-4 items-center text-base">
                                <div class="flight-logo">
                                    <img src="{{ URL::asset('/frontend/air-logos/' . $sector['operatingairline'] . '.png') }}"
                                        alt="" width="72px" height="auto" />
                                    {{-- <p class="text-xs font-bold text-gray-400">BDT 4,271</p> --}}
                                </div>
                                <h6 class="text-base text-gray-400 font-medium">
                                    Direct : {{ $sector['elapstime'] }}
                                </h6>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="mt-2 md:mt-8 shadow-md rounded-lg">
                        <div class="px-3 md:px-14 py-5 grid grid-cols-4">
                            <div class="col-span-4 md:col-span-1">
                                <h5 class="text-base font-semibold text-gray-600">
                                    Baggage
                                </h5>
                                <p class="text-sm font-medium text-gray-400">
                                    Total baggage included in the price
                                </p>
                            </div>
                            <div class="col-span-4 gap-5 md:col-span-3">
                                <div class="flex flex-col gap-3">
                                    <div class="flex items-center justify-between">
                                        <div class="flex gap-2 items-center">
                                            <i class="fa-solid fa-briefcase text-primary text-2xl"></i>
                                            <div>
                                                <h6 class="text-xs text-primary font-medium">
                                                    1 Personal Item
                                                </h6>
                                                <p class="text-sm font-normal text-gray-400">
                                                    fits under the seat in front of you
                                                </p>
                                            </div>
                                        </div>
                                        <p class="text-xs font-medium text-gray-400 tracking-wider">
                                            Included
                                        </p>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex gap-2 items-center">
                                            <i class="fa-solid fa-suitcase-rolling text-primary text-2xl"></i>
                                            <div>
                                                <h6 class="text-xs text-primary font-medium">
                                                    1 Carry-On Bag
                                                </h6>
                                                <p class="text-sm font-normal text-gray-400">
                                                    Max Weight 7 kg
                                                </p>
                                            </div>
                                        </div>
                                        <p class="text-xs font-medium text-gray-400 tracking-wider">
                                            Included
                                        </p>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex gap-2 items-center">
                                            <i class="fa-solid fa-bag-shopping text-primary text-2xl"></i>
                                            <div>
                                                <h6 class="text-xs text-primary font-medium">
                                                    1 Checked Bag
                                                </h6>
                                                <p class="text-sm font-normal text-gray-400">
                                                    Max {{ $flights['detail'][$flightKey]['bag'] }}
                                                </p>
                                            </div>
                                        </div>
                                        <p class="text-xs font-medium text-gray-400 tracking-wider">
                                            Included
                                        </p>
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
<!-- / Flight Details Heading Accordion  -->
@endforeach

<!-- Page Layout  -->
<section class="traveller-details mt-4">
    <div class="container mx-auto">
        <form id="bookingForm" action="{{ route('passengers') }}" method="post">
            @csrf
            <div class="grid grid-cols-12 gap-4">
                <!-- Passenger Info  -->
                <div class="col-span-12 md:col-span-8 order-1 md:order-1 passenger-form">
                    @if ($search->adults)
                    <input type="hidden" name="adult" value="1" />
                    @endif
                    @if ($search->childs)
                    <input type="hidden" name="child" value="1" />
                    @endif
                    @if ($search->infants)
                    <input type="hidden" name="infant" value="1" />
                    @endif
                    @for ($i = 0; $i < $search->adults; $i++)
                        @include('front.includes.flight-book.passanger-detail', [
                        'i' => $i,
                        'type' => 'adult',
                        'inputName' => 'adt',
                        'idx' => $i + 1,
                        ])
                        @endfor

                        @for ($i = 0; $i < $search->childs; $i++)
                            @include('front.includes.flight-book.passanger-detail', [
                            'i' => $i,
                            'type' => 'child',
                            'inputName' => 'chd',
                            'idx' => $i + 1 + $search->adults,
                            ])
                            @endfor

                            @for ($i = 0; $i < $search->infants; $i++)
                                @include('front.includes.flight-book.passanger-detail', [
                                'i' => $i,
                                'type' => 'infant',
                                'inputName' => 'inf',
                                'idx' => $i + 1 + $search->adults + $search->childs,
                                ])
                                @endfor

                                @php
                                $name = explode(' ', auth()->user()?->name);
                                @endphp

                                <div class="rounded-lg border border-gray-300 px-4 py-3 md:px-6 md:py-6 bg-white mb-2">
                                    <h3 class="text-2xl font-semibold mt-4 md:mt-8">
                                        Emergency Contact
                                    </h3>

                                    <div class="form-layout grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 md:mt-8">
                                        <div class="w-full">
                                            <label class="block text-sm font-semibold mb-2" for="confullname">full Name<span
                                                    class="text-red-600">*</span></label>
                                            <input
                                                class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none
                                        @error('confullname') border-red-500 @enderror"
                                                id="confullname" value="{{ old('confullname') ?: $name[0] }}" type="text"
                                                name="confullname" placeholder="Full Name" />
                                            @error('confullname')
                                            <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        {{-- <div class="w-full">
                                    <label for="confirstname" class="block text-sm font-semibold mb-2">First Name<span
                                            class="text-red-600">*</span></label>
                                    <input value="{{old('confirstname') ?:  $name[0] }}" type="text" id="confirstname"
                                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none
                                        @error('confirstname') border-red-500 @enderror"
                                        name="confirstname" placeholder="First Name" />
                                        @error('confirstname')
                                        <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="w-full">
                                        <label for="confirstname" class="block text-sm font-semibold mb-2">Last Name<span
                                                class="text-red-600">*</span></label>
                                        <input type="text" id="conlastname"
                                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none
                                            @error('conlastname') border-red-500 @enderror"
                                            value="{{ old('conlastname') ?: ($name[1] ?? '') }}"
                                            name="conlastname" placeholder="Last Name" />
                                        @error('conlastname')
                                        <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div> --}}
                                    <div class="w-full">
                                        <label class="block text-sm font-semibold mb-2" for="phone">Phone Number <span
                                                class="text-red-600">*</span></label>

                                        <div class="flex">
                                            <div class="" style="width: 200px;">
                                                <select
                                                    class="" name="phone_code" id="phone_code"
                                                    data-hs-select='{"hasSearch": true, "value": "{{ old("phone_code") }}", "placeholder": "Select","toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>","toggleClasses": "{{ $errors->has("phone_code") ? 'border-red-600 ' : '' }}hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500","dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300","optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50",   "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 \" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",    "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"}'>
                                                    <!-- <option value="">Choose</option> -->
                                                    @foreach(App\Models\InternationalFlight\FlightBooking::phone_code as $key => $value)
                                                    <option value="{{ $value }}">{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <input
                                                class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none
                                            @error('conphone') border-red-500 @enderror"
                                                id="phone" type="number"
                                                value="{{ old('conphone') ?: auth()->user()?->phonenumber }}" name="conphone"
                                                placeholder="Phone number" />
                                            @error('conphone')
                                            <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <label class="block text-sm font-semibold mb-2" for="email">Email Address <span
                                                class="text-red-600">*</span></label>
                                        <input
                                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none @error('conphone') border-red-500 @enderror"
                                            id="email" type="email"
                                            value="{{ old('conemail') ?: auth()->user()?->email }}" name="conemail"
                                            placeholder="someone@gmail.com" />
                                        @error('conemail')
                                        <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                </div>

                <div class="col-span-12 md:col-span-8 order-3 md:order-4">
                    <div class="rounded-lg border border-gray-300 px-4 py-3 md:px-6 md:py-6 bg-white">
                        <div class="flex flex-col gap-3">
                            <h6 class="text-lg font-semibold">Book Tickets</h6>
                            <p class="text-gray-400 text-sm font-medium">
                                You can issue tickets in the orders section. the booking will
                                be cancelled automatically after this Period of time passes.
                            </p>
                            <p class="text-gray-400 text-sm font-medium">
                                <span class="text-black">Please note:</span> the airline has
                                the right to cancel the booking before the ticket time limit
                                expires
                            </p>

                            <div class="flex">
                                <input
                                    class="shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                    id="terms" type="checkbox">
                                <label class="text-sm text-gray-500 ms-3" for="terms">I agree that I have
                                    accepted the
                                    <a class="text-secondary" href="{{ route('terms.conditions') }}">Terms &amp;
                                        Conditions</a>
                                    and Privacy Policy.
                                </label>
                            </div>

                            <button class="g-button-primary px-4 py-4 max-w-fit text-white font-medium rounded-lg"
                                id="sendToReviewPassengerBtn">
                                Book Now
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-span-12 md:col-span-8 order-1 md:order-1 review-passenger-form hidden">
                <div class="flex justify-start">
                    <a class="px-4 py-2 bg-primary text-white text-base rounded-md mb-2 cursor-pointer review-edit-btn"
                        href=""><i class="fa-solid fa-arrow-left"></i> Back to Edit</a>
                </div>
                <div id="reviewFormList"></div>
                {{-- <div class="grid gap-4">
                            <div class="rounded-lg border border-gray-300 px-4 py-3 md:px-6 md:py-6 bg-white ">
                                <h3 class="text-xl font-semibold text-primary">Passenger 1. Adult</h3>
                                <div class="form-layout grid grid-cols-2 md:grid-cols-3 gap-4 mt-2 md:mt-4">
                                    <div class="w-full ">
                                        <div>
                                            <label for="fname"
                                                class="block text-sm font-medium mb-2 text-gray-400">Passenger Name <span
                                                    class="text-red-600">*</span></label>

                                            <p class="text-lg font-medium">
                                                Mr. John Smith
                                            </p>
                                        </div>
                                    </div>

                                    <div class="w-full ">
                                        <label for="dob" class="block text-sm font-medium mb-2 text-gray-400">Date of
                                            Birth <span class="text-red-600">*</span></label>
                                        <p class="text-lg font-medium">
                                            15/06/2022
                                        </p>
                                    </div>
                                    <div class="w-full ">
                                        <label for="dob"
                                            class="block text-sm font-medium mb-2 text-gray-400">Nationality
                                            <span class="text-red-600">*</span></label>
                                        <p class="text-lg font-medium">
                                            Nepal
                                        </p>
                                    </div>
                                    <div class="w-full ">
                                        <label for="dob"
                                            class="block text-sm font-medium mb-2 text-gray-400">Document
                                            Type <span class="text-red-600">*</span></label>
                                        <p class="text-lg font-medium">
                                            Passport
                                        </p>
                                    </div>
                                    <div class="w-full ">
                                        <label for="dob"
                                            class="block text-sm font-medium mb-2 text-gray-400">Passport
                                            Number <span class="text-red-600">*</span></label>
                                        <p class="text-lg font-medium">
                                            98976568238566
                                        </p>
                                    </div>
                                    <div class="w-full ">
                                        <label for="dob"
                                            class="block text-sm font-medium mb-2 text-gray-400">Expiration
                                            Date <span class="text-red-600">*</span></label>
                                        <p class="text-lg font-medium">
                                            15/06/2022
                                        </p>
                                    </div>
                                    <div class="w-full ">
                                        <label for="dob" class="block text-sm font-medium mb-2 text-gray-400">Issued
                                            Country <span class="text-red-600">*</span></label>
                                        <p class="text-lg font-medium">
                                            Nepal
                                        </p>
                                    </div>

                                </div>
                            </div>

                        </div> --}}
                <div class="col-span-12 md:col-span-8 order-3 md:order-4 mt-4">
                    <div class="rounded-lg border border-gray-300 px-4 py-3 md:px-6 md:py-6 bg-white">
                        <div class="flex flex-col gap-3">
                            <h6 class="text-lg font-semibold">Book Ticket</h6>

                            <p class="text-gray-400 text-sm font-medium">
                                <span class="text-black">Please note:</span> Check the instructions about the
                                passengers carefully before continue booking.
                            </p>
                            @if (Auth::check() && Auth::user()->user_type == 'AGENT')
                            <button
                                class="g-button-primary px-4 py-4 max-w-fit text-white font-medium rounded-lg"
                                id="submitFormAgent">
                                Continue Booking
                            </button>
                            @elseif(Auth::check() && Auth::user()->hasAnyRole('OFFICE STAFF'))
                            <button
                                class="g-button-primary px-4 py-4 max-w-fit text-white font-medium rounded-lg"
                                id="submitOfficeStaffForm">
                                Continue Booking
                            </button>
                            @else
                            <button
                                class="g-button-primary px-4 py-4 max-w-fit text-white font-medium rounded-lg"
                                id="submitForm" type="button">
                                Continue Booking
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summaray  -->
            <div class="col-span-12 md:col-span-4 order-4 md:order-2">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 sticky top-0">
                    <!-- Header -->
                    <div class="bg-gray-100 px-6 py-4 rounded-t-lg">
                        <h4 class="text-lg font-semibold text-gray-800">Order Summary</h4>
                    </div>

                    <!-- Body -->
                    <div class="p-6 space-y-4">
                        @foreach ($flights['breakdown'] as $breakdown)
                        <div class="flex justify-between items-center">
                            <h5 class="text-sm font-medium text-gray-600">
                                {{ $breakdown['type'] }} ({{ $breakdown['qty'] }} Adult)
                            </h5>
                            <p class="text-sm font-semibold text-gray-800">
                                {{ help_getRoundAmount($breakdown['mbasefare']) }}
                                <span class="text-gray-500">
                                    @if (session('apiprovider') == 'airiq')
                                    ({{ $breakdown['qty'] }})
                                    @else
                                    x {{ $breakdown['qty'] }}
                                    @endif
                                </span>
                            </p>
                        </div>
                        @endforeach

                        <!-- Flight Fare -->
                        <div class="flex justify-between items-center border-t pt-4">
                            <h5 class="text-sm font-medium text-gray-500">Flight Fare</h5>
                            @foreach ($flights['breakdown'] as $breakdown)
                            <p class="text-sm text-gray-600">
                                {{ help_getRoundAmount($breakdown['mbasefare']) }}
                            </p>
                            @endforeach
                        </div>

                        <!-- Taxes and Fees -->
                        <div class="flex justify-between items-center">
                            <h5 class="text-sm font-medium text-gray-500">Taxes and Airline Fees</h5>
                            @foreach ($flights['breakdown'] as $breakdown)
                            <p class="text-sm text-gray-600">
                                {{ help_getRoundAmount($breakdown['tax']) }}
                            </p>
                            @endforeach
                        </div>

                        <div class="hidden" id="nq_tax_view">
                            <div class="flex justify-between items-center ">
                                <h5 class="text-sm font-medium text-gray-500">NQ Tax</h5>
                                <p class="text-sm text-gray-600" id="nq_tax_amount"></p>
                            </div>
                        </div>

                        @if ($flights['pricing']['discountAmount'] > 0)
                        <div class="flex justify-between items-center ">
                            <h5 class="text-sm font-medium text-gray-500">Discount</h5>
                            <p class="text-sm text-gray-600">
                                {{ help_getRoundAmount($flights['pricing']['discount']) }}
                            </p>
                        </div>
                        @endif
                    </div>

                    <!-- Footer -->
                    <div class="bg-gray-50 px-6 py-4 border-t rounded-b-lg">
                        <div class="flex justify-between items-center">
                            <h5 class="text-lg font-bold text-gray-700">Total</h5>
                            <h5 class="text-lg font-bold text-gray-900" id="total_amount_view">
                                {{ help_getRoundAmount($flights['pricing']['markedfare']) }}
                            </h5>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Includes all applicable taxes and fees.</p>
                    </div>
                </div>
            </div>

    </div>
    <input id="paymentMethod" type="hidden" name="paymentMethod" value="Khalti">
    </form>
    </div>
</section>

@if (Auth::check() && Auth::user()->user_type == 'AGENT')
<div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden" id="modal">
    <!-- Modal Content -->
    <div class="bg-white rounded-lg shadow-lg p-8 w-[500px]">
        <!-- Modal Header -->
        <div class="flex items-center justify-between">
            <h3 class="text-xl font-semibold">Choose Your Payment Option</h3>
            <!-- Close Icon -->
            <button class="text-gray-600 hover:text-gray-900" onclick="toggleModal()">
                <!-- Close Icon SVG -->
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="my-6 grid grid-cols-2 gap-8">
            <!-- Image Section 1 -->
            <div class="border-red-500 flex flex-col items-center justify-center border-2 cursor-pointer p-2 transition-all duration-300 transform hover:scale-105 rounded-lg shadow-lg hover:shadow-xl hover:border-blue-500 bg-white"
                method="Khalti" onclick="setActiveOption(this,'Khalti')">
                <img class="object-cover transition duration-300 transform hover:scale-105 " id="img1"
                    src="{{ asset('frontend/images/khalti.png') }}" alt="Khalti">
            </div>

            <div class="flex flex-col items-center justify-center border-2 cursor-pointer p-2 transition-all duration-300 transform hover:scale-105 rounded-lg shadow-lg hover:shadow-xl hover:border-blue-500 bg-white"
                method="Wallet" onclick="setActiveOption(this,'Wallet')">
                <div class="text-2xl font-semibold">Wallet</div>
                <div class="text-2xl font-extrabold text-gray-800">NPR: <span
                        class="text-green-500">{{ remainingBalance(Auth::user()->id, 'NPR') }}</span></div>
            </div>

        </div>

        <!-- Modal Footer with Button -->
        <div class="flex justify-center mt-6">
            <button class="bg-green-600 text-white py-3 px-8 rounded-lg hover:bg-green-500 transition duration-200"
                id="submitForm">
                Proceed to payment
            </button>
        </div>
    </div>
</div>
@endif
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"
    integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {})
    $("#sendToReviewPassengerBtn").click(function(e) {
        e.preventDefault();

        const validationRules = {
            confullname: {
                required: true,
                minlength: 3
            },
            conphone: {
                required: true,
                minlength: 10
            },
            conemail: {
                required: true,
                email: true
            },
            terms: {
                required: true
            }
        };

        const validationMessages = {
            confullname: {
                required: "Please enter your full name",
                minlength: "Your full name must consist of at least 3 characters"
            },
            conphone: {
                required: "Please enter your phone number",
                minlength: "Your phone number must consist of at least 10 characters"
            },
            conemail: {
                required: "Please enter your email",
                email: "Please enter a valid email"
            },
            terms: {
                required: "Please accept the terms and conditions"
            }
        };

        const addPassengerValidation = (type, count) => {
            for (let i = 0; i < count; i++) {
                validationRules[`${type}firstname[${i}]`] = {
                    required: true,
                    minlength: 3
                };
                validationRules[`${type}lastname[${i}]`] = {
                    required: true,
                    minlength: 3
                };
                validationRules[`${type}dob[${i}]`] = {
                    required: true
                };
                validationRules[`${type}nation[${i}]`] = {
                    required: true
                };
                validationRules[`${type}passport[${i}]`] = {
                    required: true
                };
                validationRules[`${type}passportexpiry[${i}]`] = {
                    required: true
                };
                validationRules[`${type}passportcountry[${i}]`] = {
                    required: true
                };

                validationMessages[`${type}firstname[${i}]`] = {
                    required: "First name is required",
                    minlength: "First name must be at least 3 characters"
                };
                validationMessages[`${type}lastname[${i}]`] = {
                    required: "Last name is required",
                    minlength: "Last name must be at least 3 characters"
                };
                validationMessages[`${type}dob[${i}]`] = {
                    required: "Date of birth is required"
                };
                validationMessages[`${type}nation[${i}]`] = {
                    required: "Nationality is required"
                };
                validationMessages[`${type}passport[${i}]`] = {
                    required: "Passport number is required"
                };
                validationMessages[`${type}passportexpiry[${i}]`] = {
                    required: "Passport expiry date is required"
                };
                validationMessages[`${type}passportcountry[${i}]`] = {
                    required: "Issued country is required"
                };
            }
        };

        addPassengerValidation('adt', {
            {
                $search - > adults
            }
        });
        addPassengerValidation('chd', {
            {
                $search - > childs
            }
        });
        addPassengerValidation('inf', {
            {
                $search - > infants
            }
        });

        let validation = $("#bookingForm").validate({
            rules: validationRules,
            messages: validationMessages,
            onsubmit: false,
            errorClass: "text-red-600",
        });






        if ($("#bookingForm").valid()) {
            $(".review-passenger-form").removeClass("hidden")
            $(".passenger-form").addClass("hidden")

            const personForms = ["adult-form", "child-form", "infant-form"];
            const listItem = $("<div></div>")
            let prevFormCount = 0;


            personForms.forEach((form, formIdx) => {
                const formEl = $(`.${form}`);

                let formElType;
                let formElTypeFull;

                switch (form) {
                    case "adult-form":
                        formElType = "adt";
                        formElTypeFull = "Adult";
                        break;
                    case "child-form":
                        formElType = "chd";
                        formElTypeFull = "Child";
                        break;
                    case "infant-form":
                        formElType = "inf";
                        formElTypeFull = "Infant";
                        break;
                }

                formEl.each((idx, el) => {
                    const fName = $(el).find(`input[name="${formElType}firstname[${idx}]"]`);
                    const lName = $(el).find(`input[name="${formElType}lastname[${idx}]"]`);
                    const dob = $(el).find(`input[name="${formElType}dob[${idx}]"]`);
                    const nationality = $(`[name="${formElType}nation[${idx}]"]`);

                    const passport = $(el).find(`input[name="${formElType}passport[${idx}]"]`);
                    const passportExpiry = $(el).find(
                        `input[name="${formElType}passportexpiry[${idx}]"]`);
                    const issuedCountry = $(`[name="${formElType}passportcountry[${idx}]"]`);
                    const title = $(`[name="${formElType}title[${idx}]"]`);



                    const formItem = $("<div></div>")
                        .addClass('grid gap-4 mb-2')
                        .html(`
                            <div class="rounded-lg border border-gray-300 px-4 py-3 md:px-6 md:py-6 bg-white ">
                                <h3 class="text-xl font-semibold text-primary">Passenger ${(prevFormCount + idx) + 1}. ${formElTypeFull}</h3>
                                <div class="form-layout grid grid-cols-2 md:grid-cols-3 gap-4 mt-2 md:mt-4">
                                    <div class="w-full ">
                                        <div>
                                            <label for="fname" class="block text-sm font-medium mb-2 text-gray-400">Passenger Name <span class="text-red-600">*</span></label>

                                            <p class="text-lg font-medium">
                                                ${title.val()} ${fName.val()} ${lName.val()}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="w-full ">
                                        <label for="dob" class="block text-sm font-medium mb-2 text-gray-400">Date of
                                            Birth <span class="text-red-600">*</span></label>
                                        <p class="text-lg font-medium">
                                            ${dob.val()}
                                        </p>
                                    </div>
                                    <div class="w-full ">
                                        <label for="dob" class="block text-sm font-medium mb-2 text-gray-400">Nationality
                                            <span class="text-red-600">*</span></label>
                                        <p class="text-lg font-medium">
                                            ${nationality.val()}
                                        </p>
                                    </div>
                                    <div class="w-full ">
                                        <label for="dob" class="block text-sm font-medium mb-2 text-gray-400">Document
                                            Type <span class="text-red-600">*</span></label>
                                        <p class="text-lg font-medium">
                                            Passport
                                        </p>
                                    </div>
                                    <div class="w-full ">
                                        <label for="dob" class="block text-sm font-medium mb-2 text-gray-400">Passport
                                            Number <span class="text-red-600">*</span></label>
                                        <p class="text-lg font-medium">
                                        ${passport.val()}
                                        </p>
                                    </div>
                                    <div class="w-full ">
                                        <label for="dob" class="block text-sm font-medium mb-2 text-gray-400">Expiration
                                            Date <span class="text-red-600">*</span></label>
                                        <p class="text-lg font-medium">
                                        ${passportExpiry.val()}
                                        </p>
                                    </div>
                                    <div class="w-full ">
                                        <label for="dob" class="block text-sm font-medium mb-2 text-gray-400">Issued
                                            Country <span class="text-red-600">*</span></label>
                                        <p class="text-lg font-medium">
                                            ${issuedCountry.val()}
                                        </p>
                                    </div>

                                </div>
                            </div>`);
                    listItem.append(formItem);
                })
                prevFormCount += formEl.length;
            })

            const contfullname = $("#confullname").val();
            const phoneCode = $("#phone_code").val();
            const conphone = $("#phone").val();
            const conemail = $("#email").val();

            const emergencyForm = $("<div></div>").addClass(
                "rounded-lg border border-gray-300 px-4 py-3 md:px-6 md:py-6 bg-white mt-2")
            emergencyForm.html(`
                    <h3 class="text-2xl font-semibold text-secondary">Emergency Contact</h3>
                    <div class="form-layout grid grid-cols-2 md:grid-cols-3 gap-4 mt-2 md:mt-4">
                        <div class="w-full ">
                            <div>
                                <label for="fname" class="block text-sm font-medium mb-2 text-gray-400">Passenger Name <span class="text-red-600">*</span></label>

                                <p class="text-lg font-medium">
                                ${contfullname}
                                </p>
                            </div>
                        </div>

                        <div class="w-full ">
                            <label for="dob" class="block text-sm font-medium mb-2 text-gray-400">Phone Number<span class="text-red-600">*</span></label>
                            <p class="text-lg font-medium">
                ${phoneCode} ${conphone}
                            </p>
                        </div>
                        <div class="w-full ">
                            <label for="dob" class="block text-sm font-medium mb-2 text-gray-400">Email Address <span class="text-red-600">*</span></label>
                            <p class="text-lg font-medium">
                                ${conemail}
                            </p>
                        </div>
                    </div>
                    `)
            $("#reviewFormList").html(listItem).append(emergencyForm);

        }
    });

    $(".review-edit-btn").on("click", function(e) {
        e.preventDefault();
        $(".passenger-form").removeClass("hidden")
        $(".review-passenger-form").addClass("hidden")
    });

    // $('#submitForm').click(function(e) {
    //     e.preventDefault();
    //     confirmBooking();
    // })

    $('#submitFormAgent').click(function(e) {
        e.preventDefault();
        toggleModal();
    })

    function toggleModal() {
        const modal = document.getElementById("modal");
        modal.classList.toggle("hidden");
    }

    // Function to add 'active' class to clicked image
    function setActiveOption(element, method) {
        $('#paymentMethod').val(method);
        // Remove 'active' border from all images
        const images = document.querySelectorAll('.cursor-pointer');
        images.forEach(img => {
            img.classList.remove('border-2', 'border-red-500'); // Remove previous active styles
        });

        // Add 'active' border to the clicked image
        element.classList.add('border-2', 'border-red-500');
    }

    $('#submitForm').click(function(e) {
        e.preventDefault();
        if ($('#paymentMethod').val() == 'Wallet') {
            $.ajax({
                url: "{{ route('agent.check.balance.international') }}",
                method: 'GET',
                success: function(response) {
                    if (response == 'insufficient-balance') {
                        Swal.fire({
                            title: "Insufficient Balance",
                            text: "You do not have sufficient balance to book this flight",
                            icon: 'error',
                            animation: true,
                            allowOutsideClick: false,
                            showCancelButton: false,
                            showConfirmButton: true,
                            showCloseButton: false,
                            allowEscapeKey: false,
                        });
                    } else {
                        confirmBooking();
                    }

                },
            });
        } else {
            confirmBooking();
        }
    })

    $('#submitOfficeStaffForm').click(function(e) {
        e.preventDefault();
        Swal.fire({
            title: "Are you sure?",
            text: "Ticket will be issued directly without payment.",
            icon: 'warning',
            animation: true,
            allowOutsideClick: false,
            showCancelButton: true, // Enable Cancel button
            showConfirmButton: true, // Enable OK button
            cancelButtonText: 'Cancel', // Text for Cancel button
            // confirmButtonText: 'OK', // Text for OK button
            cancelButtonColor: '#d33', // Optional: Color for Cancel button (red)
            confirmButtonColor: '#3085d6', // Optional: Color for OK button (blue)
            allowEscapeKey: false,
        }).then((result) => {
            if (result.isConfirmed) {
                confirmBooking();
            }
        });
    })

    function confirmBooking() {
        Swal.fire({
            title: "Please Wait",
            text: "Confirming your Booking.",
            imageUrl: "/frontend/images/search-loader.gif",
            imageAlt: "FlightGyani",
            animation: true,
            allowOutsideClick: false,
            showCancelButton: false,
            showConfirmButton: false,
            showCloseButton: false,
            allowEscapeKey: false,
        });
        $('#bookingForm').submit();
    }
</script>
<script>
    $(document).on('change', '.nationality_check', function(e) {
        var allValues = $('.nationality_check').map(function() {
            return $(this).val();
        }).get();

        // Filter out the ones that are "NP"
        var cleanedValues = allValues.filter(function(item) {
            return item !== "NP";
        });

        let nqTax = 0;
        let totalAmt = "{{ help_getRoundAmount($flights['pricing']['markedfare']) }}";
        totalAmt = totalAmt.replace(/[A-Za-z ]/g, '');
        let totalAmtwithNq = 0;
        if (Number(cleanedValues.length) > 0) {
            nqTax = Number(cleanedValues.length) * 1130;
            totalAmtwithNq = Number(totalAmt) + nqTax;
            $('#nq_tax_view').show();
            let count = `NPR 1130 x ${cleanedValues.length}`;
            $('#nq_tax_amount').html(count);
        } else {
            nqTax = 0;
            totalAmtwithNq = Number(totalAmt) + nqTax;
            $('#nq_tax_view').hide();
        }
        $('#total_amount_view').html(`NPR ${totalAmtwithNq}`);
        console.log(nqTax);
    });
</script>
@endsection