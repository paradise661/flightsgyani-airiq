@extends('layouts.front')
@section('title')
    Available Flights
@endsection
@section('body')
    <!-- Filters Tab  -->
    <div class="filters-tab hidden md:block">
        <form id="modifyForm" action="{{ route('domesticflights.result') }}" method="POST">
            @csrf
            <div class="container mx-auto">
                <div class="hs-accordion-group bg-secondary-lighter ps-2 pt-1 pb-1 mt-3 shadow-md">
                    <div class="hs-accordion" id="hs-basic-with-title-and-arrow-stretched-heading-three">
                        <div class="hs-accordion-toggle hs-accordion-active:primary cursor-pointer text-xl font-normal gap-x-3 w-full text-start text-gray-800 hover:text-gray-500 rounded-lg disabled:opacity-50 disabled:pointer-events-none "
                            aria-expanded="false" aria-controls="hs-basic-with-title-and-arrow-stretched-collapse-three">

                            <div class="flex items-center justify-between">
                                <div class="min-w-fit flex flex-col justify-between gap-2">
                                    Flight Search: {{ $data['from'] }} - {{ $data['to'] }}
                                    <div class="bg-secondary text-center px-4 py-2 hs-accordion-active:hidden block text-white text-base rounded-md"
                                        type=" button">Modify</div>
                                    <div class="bg-primary text-center px-4 py-2 hs-accordion-active:block hidden text-white text-base rounded-md"
                                        type="button">Modify</div>
                                </div>

                                <div class="flex-grow max-w-[954px]">
                                    <!-- <img class="max-h-[80px] w-full object-cover rounded-md" src="{{ asset('frontend/images/placeholder.png') }}" alt=""/> -->
                                    @if (getSiteSettings()->desktop_modify_ad ?? '')
                                        <img class="max-h-[80px] w-full object-cover rounded-md"
                                            src="{{ asset('uploads/site/' . getSiteSettings()->desktop_modify_ad) }}"
                                            alt="" />
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300"
                            id="hs-basic-with-title-and-arrow-stretched-collapse-three" role="region"
                            aria-labelledby="hs-basic-with-title-and-arrow-stretched-heading-three">
                            <div class="mt-2 px-1 pb-2">
                                <div class="flex gap-4">
                                    <!-- <h4 class="text-2xl font-normal ">Search Flights</h4> -->
                                    <div class="flex gap-3">
                                        <label
                                            class="flex px-3 py-1 w-full text-nowrap bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500  has-[:checked]:bg-primary has-[:checked]:text-white"
                                            for="filter-oneway">
                                            <input class="hidden" id="filter-oneway" type="radio" name="type"
                                                value="one-way" {{ $data['type'] == 'O' ? 'checked' : '' }} />

                                            One Way
                                        </label>

                                        <label
                                            class="flex px-3 py-1 w-full text-nowrap bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500  has-[:checked]:bg-primary has-[:checked]:text-white"
                                            for="filter-twoway">
                                            <input class="hidden" id="filter-twoway" type="radio" name="type"
                                                {{ $data['type'] == 'R' ? 'checked' : '' }} />

                                            Two Way
                                        </label>
                                    </div>
                                </div>
                                <div class="w-full gap-3 grid grid-cols-6 mt-2 one-two-container">
                                    <div class="col-span-3 md:col-span-1">
                                        <label class="block text-sm font-medium mb-2" for="filter-from">From</label>
                                        <select class="hidden"
                                            data-hs-select='{
                                              "hasSearch": true,
                                              "searchPlaceholder": "Search...",
                                              "searchClasses": "block w-full text-sm border-gray-200 rounded-lg focus:border-primary focus:ring-primary before:absolute before:inset-0 before:z-[1] py-2 px-3",
                                              "searchWrapperClasses": "bg-white p-2 -mx-1 sticky top-0",
                                              "placeholder": "Select country...",
                                              "toggleTag": "<button type=\"button\" aria-expanded=\"false\"><span class=\"me-2\" data-icon></span><span class=\"text-gray-800 \" data-title></span></button>",
                                              "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-primary",
                                              "dropdownClasses": "mt-2 max-h-72 z-[9999] pb-1 px-1 space-y-0.5 z-20 w-full bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300",
                                              "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100",
                                              "optionTemplate": "<div><div class=\"flex items-center\"><div class=\"me-2\" data-icon></div><div class=\"text-gray-800 \" data-title></div></div></div>",
                                              "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                                            }'
                                            name="from">
                                            @foreach ($sectors as $sector)
                                                <option {{ $sector->code == $data['from'] ? 'selected' : '' }}
                                                    value="{{ $sector->code }}">{{ $sector->name }} <span
                                                        class="font-black">({{ $sector->code }})</span></option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-span-3 md:col-span-1">
                                        <label class="block text-sm font-medium mb-2" for="filter-to">To</label>

                                        <select class="hidden"
                                            data-hs-select='{
                                         "hasSearch": true,
                                         "searchPlaceholder": "Search...",
                                            "searchClasses": "block w-full text-sm border-gray-200 rounded-lg focus:border-primary focus:ring-primary before:absolute before:inset-0 before:z-[1] py-2 px-3",
                                            "searchWrapperClasses": "bg-white p-2 -mx-1 sticky top-0",
                                             "placeholder": "Select country...",
                                             "toggleTag": "<button type=\"button\" aria-expanded=\"false\"><span class=\"me-2\" data-icon></span><span class=\"text-gray-800 \" data-title></span></button>",
                                             "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-primary",
                                             "dropdownClasses": "mt-2 max-h-72 z-[9999] pb-1 px-1 space-y-0.5 z-20 w-full bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300",
                                             "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100",
                                             "optionTemplate": "<div><div class=\"flex items-center\"><div class=\"me-2\" data-icon></div><div class=\"text-gray-800 \" data-title></div></div></div>",
                                             "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                                        }'
                                            name="to">
                                            @foreach ($sectors as $sector)
                                                <option {{ $sector->code == $data['to'] ? 'selected' : '' }}
                                                    value="{{ $sector->code }}">{{ $sector->name }} <span
                                                        class="font-black">({{ $sector->code }})</span>
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-span-3 md:col-span-1">
                                        <label class="block text-sm font-medium mb-2" for="filter-dep">Departure
                                            Date</label>
                                        <div class="relative">
                                            <input
                                                class="dep-date py-3 px-4 ps-11 block w-full departuredate border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                id="" type="text" autocomplete="off"
                                                value="{{ date('m/d/Y', strtotime($data['flightDate'])) }}"
                                                name="flightDate" placeholder="MM/DD/YYYY" />
                                            <div
                                                class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
                                                <svg class="shrink-0 size-4 text-gray-400"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <path
                                                            d="M3 9H21M7 3V5M17 3V5M6 12H10V16H6V12ZM6.2 21H17.8C18.9201 21 19.4802 21 19.908 20.782C20.2843 20.5903 20.5903 20.2843 20.782 19.908C21 19.4802 21 18.9201 21 17.8V8.2C21 7.07989 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V17.8C3 18.9201 3 19.4802 3.21799 19.908C3.40973 20.2843 3.71569 20.5903 4.09202 20.782C4.51984 21 5.07989 21 6.2 21Z"
                                                            stroke="#000000" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </g>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-span-3 md:col-span-1 relative twoway-block"
                                        style="{{ $data['type'] == 'O' ? 'opacity: 0.4' : '' }}">
                                        <label class="block text-sm font-medium mb-2" for="filter-return">Return
                                            Date</label>
                                        <div class="relative">
                                            <input
                                                class="return-date rdate py-3 px-4 ps-11 block w-full returndate border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                id="" type="text" name="returnDate" autocomplete="off"
                                                value="{{ $data['returnDate'] ? date('m/d/Y', strtotime($data['returnDate'])) : '' }}"
                                                placeholder="MM/DD/YYYY" />
                                            <div
                                                class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
                                                <svg class="shrink-0 size-4 text-gray-400"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <path
                                                            d="M3 9H21M7 3V5M17 3V5M6 12H10V16H6V12ZM6.2 21H17.8C18.9201 21 19.4802 21 19.908 20.782C20.2843 20.5903 20.5903 20.2843 20.782 19.908C21 19.4802 21 18.9201 21 17.8V8.2C21 7.07989 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V17.8C3 18.9201 3 19.4802 3.21799 19.908C3.40973 20.2843 3.71569 20.5903 4.09202 20.782C4.51984 21 5.07989 21 6.2 21Z"
                                                            stroke="#000000" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </g>
                                                </svg>
                                            </div>
                                        </div>
                                        <!-- <button class="z-50 absolute right-3 top-2/4 mt-1 border border-gray-600 rounded-full size-4 flex items-center justify-center"><i class="fa-solid fa-xmark"></i></button> -->
                                    </div>
                                    <div class="col-span-3 md:col-span-1">
                                        <label class="block text-sm font-medium mb-2" for="input-label">Traveller &amp;
                                            Class</label>

                                        <div class="hs-dropdown w-full [--auto-close:inside] relative sm:inline-flex z-5">
                                            <button
                                                class="hs-dropdown-toggle w-full py-3 px-4 shadow-sm inline-flex border-gray-200 items-center gap-x-2 text-sm font-normal rounded-lg bg-white text-gray-800 hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
                                                id="travellers-drop" type="button" aria-haspopup="menu"
                                                aria-expanded="false" aria-label="Dropdown">
                                                <span id="passenger-count">{{ $data['adult'] + $data['child'] }}</span>
                                                Traveller(s)
                                                <svg class="hs-dropdown-open:rotate-180 size-2.5" width="16"
                                                    height="16" viewBox="0 0 16 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                                </svg>
                                            </button>

                                            <div class="hs-dropdown-menu w-[300px] hs-dropdown-open:opacity-100 opacity-0 hidden bg-white shadow-md rounded-sm mt-2 filter-class-drop z-10 "
                                                id="intlTravellerFilter" role="menu" aria-orientation="vertical"
                                                aria-labelledby="travellers-drop">
                                                <div class="py-4 px-4 flex flex-col gap-4 bg-white">
                                                    <!-- Adult Number -->
                                                    <div class="hs-input-group"
                                                        data-hs-input-number='{"min": 1, "max": 9}'>
                                                        <div class="min-w-fit flex justify-between items-center gap-x-3">
                                                            <div class="min-w-fit">
                                                                <span class="block font-medium text-sm text-gray-800">
                                                                    Adults
                                                                </span>
                                                                <span class="block text-xs text-gray-500">
                                                                    (12+ Years)
                                                                </span>
                                                            </div>
                                                            <div class="flex items-center gap-x-1.5">
                                                                <button
                                                                    class="size-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-md border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none traveller-btn"
                                                                    data-hs-input-number-decrement="" type="button"
                                                                    tabindex="-1" aria-label="Decrease">
                                                                    <svg class="shrink-0 size-3.5"
                                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round">
                                                                        <path d="M5 12h14"></path>
                                                                    </svg>
                                                                </button>
                                                                <input
                                                                    class="p-0 w-6 bg-transparent border-0 text-gray-800 text-center focus:ring-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none traveller"
                                                                    id="flightsadults" data-hs-input-number-input=""
                                                                    value="{{ $data['adult'] ?? 1 }}"
                                                                    style="-moz-appearance: textfield" type="number"
                                                                    aria-roledescription="Number field" name="adult" />
                                                                <button
                                                                    class="size-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-md border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none traveller-btn"
                                                                    data-hs-input-number-increment="" type="button"
                                                                    tabindex="-1" aria-label="Increase">
                                                                    <svg class="shrink-0 size-3.5"
                                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round">
                                                                        <path d="M5 12h14"></path>
                                                                        <path d="M12 5v14"></path>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Adult Number -->
                                                    <!-- Children Number -->
                                                    <div class="hs-input-group" data-hs-input-number="">
                                                        <div class="min-w-fit flex justify-between items-center gap-x-3">
                                                            <div class="min-w-fit">
                                                                <span class="block font-medium text-sm text-gray-800">
                                                                    Children
                                                                </span>
                                                                <span class="block text-xs text-gray-500">
                                                                    (2 - 12 Years)
                                                                </span>
                                                            </div>
                                                            <div class="flex items-center gap-x-1.5">
                                                                <button
                                                                    class="size-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-md border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none traveller-btn"
                                                                    data-hs-input-number-decrement="" type="button"
                                                                    tabindex="-1" aria-label="Decrease">
                                                                    <svg class="shrink-0 size-3.5"
                                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round">
                                                                        <path d="M5 12h14"></path>
                                                                    </svg>
                                                                </button>
                                                                <input
                                                                    class="p-0 w-6 bg-transparent border-0 text-gray-800 text-center focus:ring-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none traveller"
                                                                    id="flightchilds" data-hs-input-number-input=""
                                                                    style="-moz-appearance: textfield" type="number"
                                                                    aria-roledescription="Number field"
                                                                    value="{{ $data['child'] ?? 0 }}" name="child" />
                                                                <button
                                                                    class="size-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-md border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none traveller-btn"
                                                                    data-hs-input-number-increment="" type="button"
                                                                    tabindex="-1" aria-label="Increase">
                                                                    <svg class="shrink-0 size-3.5"
                                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round">
                                                                        <path d="M5 12h14"></path>
                                                                        <path d="M12 5v14"></path>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Children Number -->

                                                    <!-- Nationality  -->

                                                    <div>
                                                        <label class="text-xs font-medium pb-1"
                                                            for="">Nationality</label>
                                                        <select class="hidden"
                                                            data-hs-select='{
                                                        "placeholder": "Select Nationality...",
                                                        "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                                        "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500",
                                                        "dropdownClasses": "mt-2 z-50 w-full max-h-72 z-[9999] p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300",
                                                        "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50",
                                                        "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 \" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                                                        "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                                                        }'
                                                            name="nationality">
                                                            <option {{ $data['nationality'] == 'NP' ? 'selected' : '' }}
                                                                value="NP">Nepal</option>
                                                            <option {{ $data['nationality'] == 'IN' ? 'selected' : '' }}
                                                                value="IN">India</option>
                                                            {{-- <option {{ $data['nationality'] == 'CN' ? 'selected' : '' }}
                                                        value="CN">China</option> --}}
                                                        </select>
                                                    </div>

                                                    <!-- End Nationality  -->

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-baseline col-span-3 md:col-span-1">
                                        <button
                                            class="w-full mt-auto py-3 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent g-button-secondary text-white hover:primary focus:outline-none focus:primary disabled:opacity-50 disabled:pointer-events-none"
                                            id="btnModify" type="submit">
                                            Modify
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- / Filters Tab  -->

    <!-- Page Content   -->
    <div class="page-content hidden md:block">
        <div class="container mx-auto">
            <div class="grid grid-cols-4 gap-4 mt-6">
                <div class="filters-sidebar hidden md:block">
                    <div class="drop-shadow-sm bg-secondary-lighter px-4 py-5 rounded-lg sticky top-0">
                        <h4 class="text-xl font-semibold tracking-widest px-5 mb-5 text-secondary">
                            Filters
                        </h4>

                        <div class="hs-accordion-group mb-4">
                            <div class="hs-accordion hs-accordion-active:border-gray-200 active bg-white border border-transparent rounded-xl"
                                id="hs-active-bordered-heading-two">
                                <button
                                    class="hs-accordion-toggle hs-accordion-active:text-primary inline-flex justify-between items-center gap-x-3 w-full font-semibold text-start text-gray-800 py-4 px-5 hover:text-gray-500 disabled:opacity-50 disabled:pointer-events-none"
                                    aria-expanded="true" aria-controls="arr-collapse">
                                    Time
                                    <svg class="hs-accordion-active:hidden block size-3.5"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 12h14"></path>
                                        <path d="M12 5v14"></path>
                                    </svg>
                                    <svg class="hs-accordion-active:block hidden size-3.5"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 12h14"></path>
                                    </svg>
                                </button>
                                <div class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                                    id="arr-collapse" role="region" aria-labelledby="hs-active-bordered-heading-two">
                                    <div class="pb-4 px-5">
                                        <div class="flex py-1">
                                            <input
                                                class="filter-checkbox shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none"
                                                id="arr-one" data-filter="departure_time" value="00:00-06:00"
                                                type="checkbox" />
                                            <label class="text-base text-gray-500 ms-3" for="arr-one">00:00 -
                                                05:59</label>
                                        </div>
                                        <div class="flex py-1">
                                            <input
                                                class="filter-checkbox shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none"
                                                id="arr-two" data-filter="departure_time" value="06:00-12:00"
                                                type="checkbox" />
                                            <label class="text-base text-gray-500 ms-3" for="arr-two">06:00 -
                                                11:59</label>
                                        </div>
                                        <div class="flex py-1">
                                            <input
                                                class="filter-checkbox shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none"
                                                id="arr-three" data-filter="departure_time" value="12:00-18:00"
                                                type="checkbox" />
                                            <label class="text-base text-gray-500 ms-3" for="arr-three">12:00 -
                                                17:59</label>
                                        </div>
                                        <div class="flex py-1">
                                            <input
                                                class="filter-checkbox shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none"
                                                id="arr-four" data-filter="departure_time" value="18:00-24:00"
                                                type="checkbox" />
                                            <label class="text-base text-gray-500 ms-3" for="arr-four">18:00 -
                                                00:00</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="hs-accordion-group mb-4">
                            <div class="hs-accordion hs-accordion-active:border-gray-200 active bg-white border border-transparent rounded-xl"
                                id="hs-active-bordered-heading-two">
                                <button
                                    class="hs-accordion-toggle hs-accordion-active:text-primary text-base inline-flex justify-between items-center gap-x-3 w-full font-semibold text-start text-gray-800 py-4 px-5 hover:text-gray-500 disabled:opacity-50 disabled:pointer-events-none"
                                    aria-expanded="true" aria-controls="airlies-collapse">
                                    Airlines
                                    <svg class="hs-accordion-active:hidden block size-3.5"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 12h14"></path>
                                        <path d="M12 5v14"></path>
                                    </svg>
                                    <svg class="hs-accordion-active:block hidden size-3.5"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 12h14"></path>
                                    </svg>
                                </button>
                                <div class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                                    id="airlies-collapse" role="region"
                                    aria-labelledby="hs-active-bordered-heading-two">
                                    <div class="pb-4 px-5">
                                        @foreach ($airlines ?? [] as $airline)
                                            <div class="flex py-1">
                                                <input
                                                    class="filter-checkbox shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none"
                                                    id="airline-one" data-filter="airline" type="checkbox"
                                                    value="{{ $airline }}" />
                                                <label class="text-base text-gray-500 ms-3"
                                                    for="airline-one">{{ $airDataName[$airline] }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hs-accordion-group mb-4">
                            <div class="hs-accordion hs-accordion-active:border-gray-200 active bg-white border border-transparent rounded-xl"
                                id="hs-active-bordered-heading-two">
                                <button
                                    class="hs-accordion-toggle hs-accordion-active:text-primary inline-flex justify-between items-center gap-x-3 w-full font-semibold text-start text-gray-800 py-4 px-5 hover:text-gray-500 disabled:opacity-50 disabled:pointer-events-none"
                                    aria-expanded="true" aria-controls="depart-collapse">
                                    Ticket Type
                                    <svg class="hs-accordion-active:hidden block size-3.5"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 12h14"></path>
                                        <path d="M12 5v14"></path>
                                    </svg>
                                    <svg class="hs-accordion-active:block hidden size-3.5"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 12h14"></path>
                                    </svg>
                                </button>
                                <div class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                                    id="depart-collapse" role="region" aria-labelledby="hs-active-bordered-heading-two">
                                    <div class="pb-4 px-5">
                                        <div class="flex py-1">
                                            <input
                                                class="filter-checkbox shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none"
                                                id="depart-one" data-filter="refundable" type="checkbox"
                                                value="T" />
                                            <label class="text-base text-gray-500 ms-3"
                                                for="depart-one">Refundable</label>
                                        </div>
                                        <div class="flex py-1">
                                            <input
                                                class="filter-checkbox shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none"
                                                id="depart-two" data-filter="refundable" type="checkbox"
                                                value="F" />
                                            <label class="text-base text-gray-500 ms-3"
                                                for="depart-two">Non-Refundable</label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="flight-detail col-span-4 md:col-span-3">
                    @include('front.domestic.outbound')
                </div>
            </div>
        </div>
    </div>
    <!-- / Page Content   -->

    <!-- Responsive Page Content  -->
    @include('front.domestic.mobile.searchresult')
    <!-- Responsive Page Content  -->

    <div
        class="round-book-details round-book-large fixed  hidden bottom-0 bg-white py-3 w-full border-t border-primary z-[999]">
        <div class="container mx-auto">
            <div class="flex items-center justify-between md:justify-around">
                <div class="domestic-round-departure-view hidden">
                    <div class="domestic-round-departure flex gap-2">
                        <img class="w-[45px] xl:w-[65px] h-[32px] xl:h-[50px] mt-1 hidden md:block" id="dep_airline_logo"
                            src="{{ asset('frontend/images/emirates.png') }}">
                        <div class="flex flex-col gap-1">
                            <h4 class="text-lg font-medium">Departure Flight</h4>
                            <h6 class="uppercase text-sm font-medium" id="dep_ariline_name">buddha airlines</h6>
                            <div class="flex gap-3 text-sm font-normal">
                                <p>{{ date('Y-m-d', strtotime($data['flightDate'])) }}</p>
                                <p id="dep_airline_time">20:24</p>
                            </div>
                        </div>
                        <div class="flex flex-col justify-between text-sm py-1 font-normal">
                            <p class="text-secondary" id="dep_flightid">U4665</p>
                            <p id="dep_airline_price">NPR 3,576</p>
                        </div>
                    </div>
                </div>
                <div class="domestic-round-return-view hidden">
                    <div class="domestic-round-return flex gap-2">
                        <img class="w-[45px] xl:w-[65px] h-[32px] xl:h-[50px] mt-1 hidden md:block" id="arr_airline_logo"
                            src="{{ asset('frontend/images/emirates.png') }}">
                        <div class="flex flex-col gap-1">
                            <h4 class="text-lg font-medium">Arrival Flight</h4>
                            <h6 class="uppercase text-sm font-medium" id="arr_ariline_name">buddha airlines</h6>
                            <div class="flex gap-3 text-sm font-normal">
                                <p>{{ date('Y-m-d', strtotime($data['returnDate'])) }}</p>
                                <p id="arr_airline_time">20:24</p>
                            </div>
                        </div>
                        <div class="flex flex-col justify-between text-sm py-1 font-normal">
                            <p class="text-secondary" id="arr_flightid">U4665</p>
                            <p id="arr_airline_price">NPR 3,576</p>
                        </div>
                    </div>
                </div>

                <div class="domestic-round-book">
                    <h4 class="text-lg font-medium">NPR <span id="totalPrice"></span></h4>
                    <form action="{{ route('domesticflights.passengerdetails') }}" method="POST">
                        @csrf
                        <input id="oneway_flightid" type="hidden" name="oneway_flightid">
                        <input id="twoway_flightid" type="hidden" name="twoway_flightid">
                        <input id="selectedoutboundflightdetails" type="hidden" name="selectedoutboundflightdetails"
                            value="">
                        <input id="selectedinboundflightdetails" type="hidden" name="selectedinboundflightdetails"
                            value="">
                        <button class="text-white bg-secondary px-4 py-2 text-base font-medium rounded-md"
                            id="btn_booknow">Book
                            Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function timeToMinutes(timeStr) {
            // Convert a time string (HH:mm) into total minutes since midnight
            var timeParts = timeStr.split(':');
            return parseInt(timeParts[0]) * 60 + parseInt(timeParts[1]);
        }

        $(document).ready(function() {
            // Function to filter the flight list based on selected filters
            function filterFlights() {
                var selectedFilters = {};

                // Collect selected filters from the checkboxes
                $('.filter-checkbox:checked').each(function() {
                    var filterType = $(this).data('filter');
                    var filterValue = $(this).val();

                    // Initialize the array if it doesn't exist
                    if (!selectedFilters[filterType]) {
                        selectedFilters[filterType] = [];
                    }
                    selectedFilters[filterType].push(filterValue);
                });

                // Show or hide flights based on the selected filters
                $('.flight-item').each(function() {
                    var flight = $(this);

                    // Collect the flight's attributes for filtering
                    var flightAirline = flight.data('airline');
                    var flightRefundable = flight.data('refundable');
                    var flightDepartureTime = flight.data('departure_time'); // e.g., "06:30"

                    // Convert flight's departure time to minutes
                    var flightDepartureTimeInMinutes = timeToMinutes(flightDepartureTime);

                    // Check if the selected filters match the flight's attributes
                    var matchesAirline = !selectedFilters['airline'] || selectedFilters['airline'].includes(
                        flightAirline);
                    var matchesRefundable = !selectedFilters['refundable'] || selectedFilters['refundable']
                        .includes(flightRefundable.toString());

                    // For the departure_time filter, check if the flight's departure time falls within the selected range
                    var matchesDepartureTime = true;
                    if (selectedFilters['departure_time']) {
                        matchesDepartureTime = selectedFilters['departure_time'].some(function(range) {
                            // Extract the start and end times of the range
                            var [startTime, endTime] = range.split('-');
                            var startTimeInMinutes = timeToMinutes(startTime);
                            var endTimeInMinutes = timeToMinutes(endTime);

                            // Check if the flight's departure time is within the range
                            return flightDepartureTimeInMinutes >= startTimeInMinutes &&
                                flightDepartureTimeInMinutes < endTimeInMinutes;
                        });
                    }

                    // If the flight matches all selected filters, show it; otherwise, hide it
                    if (matchesAirline && matchesRefundable && matchesDepartureTime) {
                        flight.show();
                    } else {
                        flight.hide();
                    }
                });
            }

            // Bind the filter function to checkbox changes
            $('.filter-checkbox').on('change', function() {
                filterFlights();
            });

            // Initial filter call to apply any filters already selected (if the page is reloaded with some filters selected)
            filterFlights();
        });

        var depPrice = 0;
        var arrPrice = 0;
        $(document).on('click', '.outbound_flight', function(e) {
            // alert("yes")
            $('.domestic-round-departure-view').show();
            $('.outbound_flight').addClass('bg-white').removeClass('border-primary bg-primary-background');
            $(this).removeClass('bg-white').addClass('border-primary bg-primary-background');
            $('.dep_btnfirst').show();
            $('.dep_btnsecond').hide();
            $(this).find('.dep_btnfirst').hide();
            $(this).find('.dep_btnsecond').show();

            $('#dep_airline_logo').attr('src', $(this).attr('data-logo'));
            $('#dep_flightid').html($(this).attr('data-flightno'));
            $('#dep_ariline_name').html($(this).attr('data-airline-fullname'));
            $('#dep_airline_time').html($(this).attr('data-time'));
            $('#dep_airline_price').html('NPR ' + Math.ceil($(this).attr('data-price')));
            depPrice = $(this).attr('data-amount');
            calculateFullPrice();

            $('#oneway_flightid').val($(this).attr('data-flightid'));
            $('#selectedoutboundflightdetails').val($(this).attr('data-details-outbound'));
        })

        $(document).on('click', '.inbound_flight', function(e) {
            // alert("yes")
            $('.domestic-round-return-view').show();
            $('.inbound_flight').addClass('bg-white').removeClass('border-primary bg-primary-background');
            $(this).removeClass('bg-white').addClass('border-primary bg-primary-background');
            $('.arr_btnfirst').show();
            $('.arr_btnsecond').hide();
            $(this).find('.arr_btnfirst').hide();
            $(this).find('.arr_btnsecond').show();

            $('#arr_airline_logo').attr('src', $(this).attr('data-logo'));
            $('#arr_flightid').html($(this).attr('data-flightno'));
            $('#arr_ariline_name').html($(this).attr('data-airline-fullname'));
            $('#arr_airline_time').html($(this).attr('data-time'));
            $('#arr_airline_price').html('NPR ' + Math.ceil($(this).attr('data-price')));

            arrPrice = $(this).attr('data-amount');
            calculateFullPrice();

            $('#twoway_flightid').val($(this).attr('data-flightid'));
            $('#selectedinboundflightdetails').val($(this).attr('data-details-inbound'));
        })

        $('#btn_booknow').click(function(e) {
            e.preventDefault();
            if ($('#oneway_flightid').val() && $('#twoway_flightid').val()) {
                Swal.fire({
                    title: "Please Wait",
                    text: "Confirming your Flight.",
                    imageUrl: "/frontend/images/search-loader.gif",
                    imageAlt: "FlightGyani",
                    animation: true,
                    allowOutsideClick: false,
                    showCancelButton: false,
                    showConfirmButton: false,
                    showCloseButton: false,
                    allowEscapeKey: false,
                });
                $(this).closest('form').submit();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: '',
                    html: 'Please select both departure and arrival flights.'
                });
            }
        })

        $(function() {
            // alert("{{ date('m/d/Y', strtotime($data['flightDate'])) }}");
            $(".rdate").datepicker();
            $(".return-date").datepicker("option", "minDate",
                "{{ date('m/d/Y', strtotime($data['flightDate'])) }}");
        })

        $('#filter-oneway').click(function() {
            $('.twoway-block').css('opacity', '0.4')
        })
        $('#filter-twoway').click(function() {
            $('.twoway-block').css('opacity', '1')
        })

        function calculateFullPrice() {
            let price = Number(depPrice) + Number(arrPrice);
            $('#totalPrice').html(Math.ceil(price))
        }

        $('#btnModify').click(function(e) {
            Swal.fire({
                title: "Please Wait",
                text: "Searching Flights.",
                imageUrl: "/frontend/images/search-loader.gif",
                imageAlt: "FlightGyani",
                animation: true,
                allowOutsideClick: false,
                showCancelButton: false,
                showConfirmButton: false,
                showCloseButton: false,
                allowEscapeKey: false,
            });
        })
    </script>

    <script>
        setTimeout(function() {
            Swal.fire({
                title: "Search Again",
                text: "All fares has been changed.",
                imageUrl: "/frontend/images/search-loader.gif",
                imageAlt: "FlightGyani",
                animation: true,
                allowOutsideClick: false,
                showCancelButton: false,
                showConfirmButton: true,
                showCloseButton: false,
                allowEscapeKey: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#modifyForm').submit();
                }
            });
        }, 300000);
    </script>
@endsection
