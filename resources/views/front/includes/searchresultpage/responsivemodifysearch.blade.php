    @php
        $departureAirport = App\Models\InternationalFlight\Airport::where('code', $search['departure'])->first();
        $destinationAirport = App\Models\InternationalFlight\Airport::where('code', $search['destination'])->first();
        $sectors = $search['sectors'] ? json_decode($search['sectors']) : [];

        $sectors = collect($sectors)
            ->map(function ($sector) {
                $sector->depart = help_getAirportFromCode($sector->depart);
                $sector->arrival = help_getAirportFromCode($sector->arrival);
                return $sector;
            })
            ->toArray();

        $departure =
            $departureAirport->code .
            '- ' .
            $departureAirport->airport .
            ',' .
            $departureAirport->city .
            '-' .
            $departureAirport->country;
        $arrival =
            $destinationAirport->code .
            '- ' .
            $destinationAirport->airport .
            ',' .
            $destinationAirport->city .
            '-' .
            $destinationAirport->country;
    @endphp

    <section class="modify">
        <div class="container mx-auto">
            <div class="w-full">
                <div class="hs-accordion-group">
                    <div class="hs-accordion" id="modify-drop">
                        <div class="flex align-center gap-2 bg-primary-background px-2 flex-wrap">

                            <button
                                class="hs-accordion-toggle bg-secondary order-1 max-w-fit px-4 py-2 text-sm tracking-wider text-white font-medium hs-accordion-active:text-white inline-flex items-center gap-x-3 w-full text-start white focus:outline-none focus:text-white rounded-lg disabled:opacity-50 disabled:pointer-events-none"
                                aria-expanded="false" aria-controls="modify-accordion">
                                Modify
                            </button>
                            <div class="hs-accordion-content hidden order-4 w-full overflow-hidden transition-[height] duration-300 flex-grow"
                                id="modify-accordion" role="region" aria-labelledby="modify-drop">
                                <div class="mt-2 px-1">
                                    <form action="{{ route('flight.search') }}" method="POST">
                                        @csrf
                                        <div class="flex gap-4 ">
                                            <div class="flex gap-3">
                                                <label
                                                    class="flex px-3 py-1 w-full text-nowrap bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 has-[:checked]:bg-primary has-[:checked]:text-white"
                                                    for="r-filter-oneway">
                                                    <input class="type-tab hidden" id="r-filter-oneway" type="radio"
                                                        name="type" value="O"
                                                        {{ is_null($search['return_date']) && !count($sectors) ? 'checked' : '' }} />
                                                    One Way
                                                </label>

                                                <label
                                                    class="flex px-3 py-1 w-full text-nowrap bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 has-[:checked]:bg-primary has-[:checked]:text-white"
                                                    for="r-filter-twoway">
                                                    <input class="type-tab hidden" id="r-filter-twoway" value="R"
                                                        type="radio" name="type"
                                                        {{ !is_null($search['return_date']) && !count($sectors) ? 'checked' : '' }} />
                                                    Two Way
                                                </label>
                                                <label
                                                    class="flex px-3 py-1 w-full text-nowrap bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 has-[:checked]:bg-primary has-[:checked]:text-white"
                                                    for="r-filter-multi">
                                                    <input class="type-tab hidden" id="r-filter-multi" value="M"
                                                        type="radio" name="type"
                                                        {{ count($sectors) ? 'checked' : '' }} />
                                                    Multi City
                                                </label>

                                            </div>
                                        </div>
                                        <div class="w-full gap-3 grid grid-cols-12 mt-2 one-two-container"
                                            style="display: grid;">
                                            <div class="col-span-6 md:col-span-3">
                                                <label class="block text-sm font-medium mb-2"
                                                    for="filter-from">From</label>
                                                <div class="relative">
                                                    <input type="hidden" name="departure" value="{{ $departure }}">
                                                    <input
                                                        class="int-search-typeahead py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                        id="filter-from" data-type="mobile" type="text"
                                                        placeholder="Departure..." value="{{ $departureAirport->code }}"
                                                        autocomplete="off" />
                                                    <div
                                                        class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
                                                        <svg class="shrink-0 size-4 text-gray-400"
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <path
                                                                d="M12 21C15.5 17.4 19 14.1764 19 10.2C19 6.22355 15.866 3 12 3C8.13401 3 5 6.22355 5 10.2C5 14.1764 8.5 17.4 12 21Z"
                                                                stroke="#000000" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round"></path>
                                                            <path
                                                                d="M12 12C13.1046 12 14 11.1046 14 10C14 8.89543 13.1046 8 12 8C10.8954 8 10 8.89543 10 10C10 11.1046 10.8954 12 12 12Z"
                                                                stroke="#000000" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-span-6 md:col-span-3">
                                                <label class="block text-sm font-medium mb-2" for="filter-to">To</label>
                                                <div class="relative">
                                                    <input type="hidden" name="destination"
                                                        value="{{ $arrival }}">
                                                    <input
                                                        class="int-search-typeahead py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                        id="filter-to" data-type="mobile" type="text"
                                                        value="{{ $destinationAirport->code }}"
                                                        placeholder="Destination.." autocomplete="off" />
                                                    <div
                                                        class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
                                                        <svg class="shrink-0 size-4 text-gray-400"
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <path
                                                                d="M12 21C15.5 17.4 19 14.1764 19 10.2C19 6.22355 15.866 3 12 3C8.13401 3 5 6.22355 5 10.2C5 14.1764 8.5 17.4 12 21Z"
                                                                stroke="#000000" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path
                                                                d="M12 12C13.1046 12 14 11.1046 14 10C14 8.89543 13.1046 8 12 8C10.8954 8 10 8.89543 10 10C10 11.1046 10.8954 12 12 12Z"
                                                                stroke="#000000" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-span-6 md:col-span-3">
                                                <label class="block text-sm font-medium mb-2"
                                                    for="filter-dep">Departure
                                                    Date</label>

                                                <div class="relative">
                                                    <input
                                                        class="py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                        id="r-depdate" type="text" name="flightdate"
                                                        placeholder="Flight Date" autocomplete="off"
                                                        value="{{ $search->flight_date?->format('Y-m-d') }}" readonly>
                                                    <div
                                                        class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
                                                        <svg class="shrink-0 size-4 text-gray-400"
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                                stroke-linejoin="round"></g>
                                                            <g id="SVGRepo_iconCarrier">
                                                                <path
                                                                    d="M3 9H21M7 3V5M17 3V5M6 12H10V16H6V12ZM6.2 21H17.8C18.9201 21 19.4802 21 19.908 20.782C20.2843 20.5903 20.5903 20.2843 20.782 19.908C21 19.4802 21 18.9201 21 17.8V8.2C21 7.07989 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V17.8C3 18.9201 3 19.4802 3.21799 19.908C3.40973 20.2843 3.71569 20.5903 4.09202 20.782C4.51984 21 5.07989 21 6.2 21Z"
                                                                    stroke="#000000" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                </path>
                                                            </g>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-span-6 md:col-span-3 relative twoway-block"
                                                style="{{ !is_null($search['return_date']) && !count($sectors) ? 'opacity: 1;' : 'opacity: 0.4;' }}">
                                                <label class="block text-sm font-medium mb-2"
                                                    for="filter-return">Return
                                                    Date</label>

                                                <div class="relative">
                                                    <input
                                                        class="returndatevalue py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                        id="r-returndate" type="text" name="returndate"
                                                        value="{{ $search->return_date?->format('Y-m-d') }}"
                                                        placeholder="Return Date" autocomplete="off" readonly>
                                                    <div
                                                        class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
                                                        <svg class="shrink-0 size-4 text-gray-400"
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                                stroke-linejoin="round"></g>
                                                            <g id="SVGRepo_iconCarrier">
                                                                <path
                                                                    d="M3 9H21M7 3V5M17 3V5M6 12H10V16H6V12ZM6.2 21H17.8C18.9201 21 19.4802 21 19.908 20.782C20.2843 20.5903 20.5903 20.2843 20.782 19.908C21 19.4802 21 18.9201 21 17.8V8.2C21 7.07989 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V17.8C3 18.9201 3 19.4802 3.21799 19.908C3.40973 20.2843 3.71569 20.5903 4.09202 20.782C4.51984 21 5.07989 21 6.2 21Z"
                                                                    stroke="#000000" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                </path>
                                                            </g>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <!-- <button class="z-50 absolute right-3 top-2/4 mt-1 border border-gray-600 rounded-full size-4 flex items-center justify-center"><i class="fa-solid fa-xmark"></i></button> -->
                                            </div>
                                        </div>

                                        <div class="w-full gap-3 grid grid-cols-12 multi-container"
                                            style="display: none;">
                                            <div class="col-span-12 md:col-span-10">
                                                <div
                                                    class="w-full gap-3 grid grid-cols-12 mt-2 filter-multi filter-multi-1">
                                                    <div class="col-span-4 md:col-span-4">
                                                        <div class="relative">
                                                            <input
                                                                class="int-search-typeahead py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                                id="multi-from-1" type="text"
                                                                name="int_multi_from[]"
                                                                value="{{ isset($sectors[0]) ? $sectors[0]?->depart : null }}"
                                                                placeholder="Departure">
                                                            <div
                                                                class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
                                                                <svg class="shrink-0 size-4 text-gray-400"
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <path
                                                                        d="M12 21C15.5 17.4 19 14.1764 19 10.2C19 6.22355 15.866 3 12 3C8.13401 3 5 6.22355 5 10.2C5 14.1764 8.5 17.4 12 21Z"
                                                                        stroke="#000000" stroke-width="2"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path
                                                                        d="M12 12C13.1046 12 14 11.1046 14 10C14 8.89543 13.1046 8 12 8C10.8954 8 10 8.89543 10 10C10 11.1046 10.8954 12 12 12Z"
                                                                        stroke="#000000" stroke-width="2"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-span-4 md:col-span-4">
                                                        <div class="relative">
                                                            <input
                                                                class="int-search-typeahead py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                                id="multi-to-1" type="text" name="int_multi_to[]"
                                                                value="{{ isset($sectors[0]) ? $sectors[0]?->arrival : null }}"
                                                                placeholder="Destination">
                                                            <div
                                                                class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
                                                                <svg class="shrink-0 size-4 text-gray-400"
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <path
                                                                        d="M12 21C15.5 17.4 19 14.1764 19 10.2C19 6.22355 15.866 3 12 3C8.13401 3 5 6.22355 5 10.2C5 14.1764 8.5 17.4 12 21Z"
                                                                        stroke="#000000" stroke-width="2"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path
                                                                        d="M12 12C13.1046 12 14 11.1046 14 10C14 8.89543 13.1046 8 12 8C10.8954 8 10 8.89543 10 10C10 11.1046 10.8954 12 12 12Z"
                                                                        stroke="#000000" stroke-width="2"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-span-4 md:col-span-4">
                                                        <div class="relative">
                                                            <input
                                                                class="py-3 px-4 ps-11 block w-full multi-depdate border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                                type="text" name="int_multi_departure[]"
                                                                value="{{ isset($sectors[0]) ? $sectors[0]?->date : null }}"
                                                                placeholder="Depart Date" readonly>
                                                            <div
                                                                class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
                                                                <svg class="shrink-0 size-4 text-gray-400"
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                                    <g id="SVGRepo_tracerCarrier"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"></g>
                                                                    <g id="SVGRepo_iconCarrier">
                                                                        <path
                                                                            d="M3 9H21M7 3V5M17 3V5M6 12H10V16H6V12ZM6.2 21H17.8C18.9201 21 19.4802 21 19.908 20.782C20.2843 20.5903 20.5903 20.2843 20.782 19.908C21 19.4802 21 18.9201 21 17.8V8.2C21 7.07989 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V17.8C3 18.9201 3 19.4802 3.21799 19.908C3.40973 20.2843 3.71569 20.5903 4.09202 20.782C4.51984 21 5.07989 21 6.2 21Z"
                                                                            stroke="#000000" stroke-width="2"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round">
                                                                        </path>
                                                                    </g>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div
                                                    class="w-full gap-3 grid grid-cols-12 mt-2 filter-multi filter-multi-2">
                                                    <div class="col-span-4 md:col-span-4">

                                                        <div class="relative">
                                                            <input
                                                                class="int-search-typeahead py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                                id="multi-from-2" type="text"
                                                                name="int_multi_from[]"
                                                                value="{{ isset($sectors[1]) ? $sectors[1]?->depart : null }}"
                                                                placeholder="Departure">
                                                            <div
                                                                class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
                                                                <svg class="shrink-0 size-4 text-gray-400"
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <path
                                                                        d="M12 21C15.5 17.4 19 14.1764 19 10.2C19 6.22355 15.866 3 12 3C8.13401 3 5 6.22355 5 10.2C5 14.1764 8.5 17.4 12 21Z"
                                                                        stroke="#000000" stroke-width="2"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path
                                                                        d="M12 12C13.1046 12 14 11.1046 14 10C14 8.89543 13.1046 8 12 8C10.8954 8 10 8.89543 10 10C10 11.1046 10.8954 12 12 12Z"
                                                                        stroke="#000000" stroke-width="2"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-span-4 md:col-span-4">

                                                        <div class="relative">
                                                            <input
                                                                class="int-search-typeahead py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                                id="multi-to-2" type="text" name="int_multi_to[]"
                                                                value="{{ isset($sectors[1]) ? $sectors[1]?->arrival : null }}"
                                                                placeholder="Destination">
                                                            <div
                                                                class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
                                                                <svg class="shrink-0 size-4 text-gray-400"
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <path
                                                                        d="M12 21C15.5 17.4 19 14.1764 19 10.2C19 6.22355 15.866 3 12 3C8.13401 3 5 6.22355 5 10.2C5 14.1764 8.5 17.4 12 21Z"
                                                                        stroke="#000000" stroke-width="2"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path
                                                                        d="M12 12C13.1046 12 14 11.1046 14 10C14 8.89543 13.1046 8 12 8C10.8954 8 10 8.89543 10 10C10 11.1046 10.8954 12 12 12Z"
                                                                        stroke="#000000" stroke-width="2"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-span-4 md:col-span-4">

                                                        <div class="relative">
                                                            <input
                                                                class="py-3 px-4 ps-11 block w-full multi-depdate border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                                type="text" name="int_multi_departure[]"
                                                                value="{{ isset($sectors[1]) ? $sectors[1]?->date : null }}"
                                                                placeholder="Depart Date" readonly>
                                                            <div
                                                                class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
                                                                <svg class="shrink-0 size-4 text-gray-400"
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                                    <g id="SVGRepo_tracerCarrier"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"></g>
                                                                    <g id="SVGRepo_iconCarrier">
                                                                        <path
                                                                            d="M3 9H21M7 3V5M17 3V5M6 12H10V16H6V12ZM6.2 21H17.8C18.9201 21 19.4802 21 19.908 20.782C20.2843 20.5903 20.5903 20.2843 20.782 19.908C21 19.4802 21 18.9201 21 17.8V8.2C21 7.07989 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V17.8C3 18.9201 3 19.4802 3.21799 19.908C3.40973 20.2843 3.71569 20.5903 4.09202 20.782C4.51984 21 5.07989 21 6.2 21Z"
                                                                            stroke="#000000" stroke-width="2"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round">
                                                                        </path>
                                                                    </g>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="w-full gap-3 grid-cols-12 mt-2 filter-multi filter-multi-3"
                                                    style="display: {{ isset($sectors[2]) ? 'grid' : 'none' }};">
                                                    <div class="col-span-4 md:col-span-4">

                                                        <div class="relative">
                                                            <input
                                                                class="int-search-typeahead py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                                id="multi-from-3" type="text"
                                                                name="int_multi_from[]"
                                                                value="{{ isset($sectors[2]) ? $sectors[2]?->depart : null }}"
                                                                placeholder="Departure">
                                                            <div
                                                                class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
                                                                <svg class="shrink-0 size-4 text-gray-400"
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <path
                                                                        d="M12 21C15.5 17.4 19 14.1764 19 10.2C19 6.22355 15.866 3 12 3C8.13401 3 5 6.22355 5 10.2C5 14.1764 8.5 17.4 12 21Z"
                                                                        stroke="#000000" stroke-width="2"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path
                                                                        d="M12 12C13.1046 12 14 11.1046 14 10C14 8.89543 13.1046 8 12 8C10.8954 8 10 8.89543 10 10C10 11.1046 10.8954 12 12 12Z"
                                                                        stroke="#000000" stroke-width="2"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-span-4 md:col-span-4">

                                                        <div class="relative">
                                                            <input
                                                                class="int-search-typeahead py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                                id="multi-to-3" type="text" name="int_multi_to[]"
                                                                value="{{ isset($sectors[2]) ? $sectors[2]?->arrival : null }}"
                                                                placeholder="Destination">
                                                            <div
                                                                class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
                                                                <svg class="shrink-0 size-4 text-gray-400"
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <path
                                                                        d="M12 21C15.5 17.4 19 14.1764 19 10.2C19 6.22355 15.866 3 12 3C8.13401 3 5 6.22355 5 10.2C5 14.1764 8.5 17.4 12 21Z"
                                                                        stroke="#000000" stroke-width="2"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path
                                                                        d="M12 12C13.1046 12 14 11.1046 14 10C14 8.89543 13.1046 8 12 8C10.8954 8 10 8.89543 10 10C10 11.1046 10.8954 12 12 12Z"
                                                                        stroke="#000000" stroke-width="2"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-span-4 md:col-span-4">

                                                        <div class="relative">
                                                            <input
                                                                class="py-3 px-4 ps-11 block w-full multi-depdate border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                                type="text" name="int_multi_departure[]"
                                                                value="{{ isset($sectors[2]) ? $sectors[2]?->date : null }}"
                                                                placeholder="Depart Date" readonly>
                                                            <div
                                                                class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
                                                                <svg class="shrink-0 size-4 text-gray-400"
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                                    <g id="SVGRepo_tracerCarrier"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"></g>
                                                                    <g id="SVGRepo_iconCarrier">
                                                                        <path
                                                                            d="M3 9H21M7 3V5M17 3V5M6 12H10V16H6V12ZM6.2 21H17.8C18.9201 21 19.4802 21 19.908 20.782C20.2843 20.5903 20.5903 20.2843 20.782 19.908C21 19.4802 21 18.9201 21 17.8V8.2C21 7.07989 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V17.8C3 18.9201 3 19.4802 3.21799 19.908C3.40973 20.2843 3.71569 20.5903 4.09202 20.782C4.51984 21 5.07989 21 6.2 21Z"
                                                                            stroke="#000000" stroke-width="2"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round">
                                                                        </path>
                                                                    </g>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="w-full gap-3 grid-cols-12 mt-2 filter-multi filter-multi-4"
                                                    style="display: {{ isset($sectors[3]) ? 'grid' : 'none' }};">
                                                    <div class="col-span-4 md:col-span-4">

                                                        <div class="relative">
                                                            <input
                                                                class="int-search-typeahead py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                                id="multi-from-4" type="text"
                                                                name="int_multi_from[]"
                                                                value="{{ isset($sectors[3]) ? $sectors[3]?->depart : null }}"
                                                                placeholder="Departure">
                                                            <div
                                                                class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
                                                                <svg class="shrink-0 size-4 text-gray-400"
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <path
                                                                        d="M12 21C15.5 17.4 19 14.1764 19 10.2C19 6.22355 15.866 3 12 3C8.13401 3 5 6.22355 5 10.2C5 14.1764 8.5 17.4 12 21Z"
                                                                        stroke="#000000" stroke-width="2"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path
                                                                        d="M12 12C13.1046 12 14 11.1046 14 10C14 8.89543 13.1046 8 12 8C10.8954 8 10 8.89543 10 10C10 11.1046 10.8954 12 12 12Z"
                                                                        stroke="#000000" stroke-width="2"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-span-4 md:col-span-4">

                                                        <div class="relative">
                                                            <input
                                                                class="int-search-typeahead py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                                id="multi-to-4" type="text" name="int_multi_to[]"
                                                                value="{{ isset($sectors[3]) ? $sectors[3]?->arrival : null }}"
                                                                placeholder="Destination">
                                                            <div
                                                                class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
                                                                <svg class="shrink-0 size-4 text-gray-400"
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <path
                                                                        d="M12 21C15.5 17.4 19 14.1764 19 10.2C19 6.22355 15.866 3 12 3C8.13401 3 5 6.22355 5 10.2C5 14.1764 8.5 17.4 12 21Z"
                                                                        stroke="#000000" stroke-width="2"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path
                                                                        d="M12 12C13.1046 12 14 11.1046 14 10C14 8.89543 13.1046 8 12 8C10.8954 8 10 8.89543 10 10C10 11.1046 10.8954 12 12 12Z"
                                                                        stroke="#000000" stroke-width="2"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-span-4 md:col-span-4">

                                                        <div class="relative">
                                                            <input
                                                                class="py-3 px-4 ps-11 block w-full multi-depdate border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                                type="text" name="int_multi_departure[]"
                                                                value="{{ isset($sectors[3]) ? $sectors[3]?->date : null }}"
                                                                placeholder="Depart Date" readonly>
                                                            <div
                                                                class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
                                                                <svg class="shrink-0 size-4 text-gray-400"
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                                    <g id="SVGRepo_tracerCarrier"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"></g>
                                                                    <g id="SVGRepo_iconCarrier">
                                                                        <path
                                                                            d="M3 9H21M7 3V5M17 3V5M6 12H10V16H6V12ZM6.2 21H17.8C18.9201 21 19.4802 21 19.908 20.782C20.2843 20.5903 20.5903 20.2843 20.782 19.908C21 19.4802 21 18.9201 21 17.8V8.2C21 7.07989 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V17.8C3 18.9201 3 19.4802 3.21799 19.908C3.40973 20.2843 3.71569 20.5903 4.09202 20.782C4.51984 21 5.07989 21 6.2 21Z"
                                                                            stroke="#000000" stroke-width="2"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round">
                                                                        </path>
                                                                    </g>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-span-12 Smd:col-span-2 h-full">
                                                <div class="flex h-full gap-3 items-end">
                                                    <button
                                                        class="add-filter-multi bg-primary px-3 py-2 text-white rounded-full"><i
                                                            class="fa-solid fa-plus me-2"></i>Add</button>
                                                    <button
                                                        class="remove-filter-multi bg-secondary px-3 py-2 text-white rounded-full"
                                                        style="display: none;"><i
                                                            class="fa-solid fa-minus me-2"></i>Remove</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex items-end gap-4 mt-2 ">
                                            <div class="col-span-5 md:col-span-2">
                                                <label class="block text-sm font-medium mb-2"
                                                    for="input-label">Traveller
                                                    &amp; Class</label>

                                                <div
                                                    class=" hs-dropdown w-full [--auto-close:inside]  relative sm:inline-flex z-20">
                                                    <button
                                                        class="hs-dropdown-toggle w-full py-3 px-4 shadow-sm inline-flex border-gray-200  items-center gap-x-2 text-sm font-normal rounded-lg bg-white text-gray-800 hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
                                                        id="travellers-drop" type="button" aria-haspopup="menu"
                                                        aria-expanded="false" aria-label="Dropdown">
                                                        <span
                                                            id="m-passenger-count">{{ $search['adults'] + $search['childs'] + $search['infants'] }}</span>
                                                        Traveller(s)
                                                        <svg class="hs-dropdown-open:rotate-180 size-2.5"
                                                            width="16" height="16" viewBox="0 0 16 16"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" />
                                                        </svg>
                                                    </button>

                                                    <div class="hs-dropdown-menu w-[300px] hs-dropdown-open:opacity-100 opacity-0 hidden bg-white shadow-md rounded-sm mt-2 filter-class-drop"
                                                        id="intlTravellerFilter" role="menu"
                                                        aria-orientation="vertical" aria-labelledby="travellers-drop">
                                                        <div class="py-4 px-4 flex flex-col gap-4 bg-white">
                                                            <!-- Adult Number -->
                                                            <div class="m-hs-input-group"
                                                                data-hs-input-number='{"min": 1, "max": 9}'>
                                                                <div
                                                                    class="min-w-fit flex justify-between items-center gap-x-3">
                                                                    <div class="min-w-fit">
                                                                        <span
                                                                            class="block font-medium text-sm text-gray-800">
                                                                            Adults
                                                                        </span>
                                                                        <span class="block text-xs text-gray-500">
                                                                            (12+ Years)
                                                                        </span>
                                                                    </div>
                                                                    <div class="flex items-center gap-x-1.5">
                                                                        <button
                                                                            class="size-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-md border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none traveller-btn"
                                                                            data-hs-input-number-decrement=""
                                                                            type="button" tabindex="-1"
                                                                            aria-label="Decrease">
                                                                            <svg class="shrink-0 size-3.5"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24"
                                                                                viewBox="0 0 24 24" fill="none"
                                                                                stroke="currentColor" stroke-width="2"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round">
                                                                                <path d="M5 12h14"></path>
                                                                            </svg>
                                                                        </button>
                                                                        <input
                                                                            class="p-0 w-6 bg-transparent border-0 text-gray-800 text-center focus:ring-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none traveller"
                                                                            id="flightsadults"
                                                                            data-hs-input-number-input=""
                                                                            style="-moz-appearance: textfield"
                                                                            type="number"
                                                                            aria-roledescription="Number field"
                                                                            value="1" name="flightadults" />
                                                                        <button
                                                                            class="size-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-md border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none traveller-btn"
                                                                            data-hs-input-number-increment=""
                                                                            type="button" tabindex="-1"
                                                                            aria-label="Increase">
                                                                            <svg class="shrink-0 size-3.5"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24"
                                                                                viewBox="0 0 24 24" fill="none"
                                                                                stroke="currentColor" stroke-width="2"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round">
                                                                                <path d="M5 12h14"></path>
                                                                                <path d="M12 5v14"></path>
                                                                            </svg>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- End Adult Number -->
                                                            <!-- Children Number -->
                                                            <div class="m-hs-input-group" data-hs-input-number="">
                                                                <div
                                                                    class="min-w-fit flex justify-between items-center gap-x-3">
                                                                    <div class="min-w-fit">
                                                                        <span
                                                                            class="block font-medium text-sm text-gray-800">
                                                                            Children
                                                                        </span>
                                                                        <span class="block text-xs text-gray-500">
                                                                            (2 - 12 Years)
                                                                        </span>
                                                                    </div>
                                                                    <div class="flex items-center gap-x-1.5">
                                                                        <button
                                                                            class="size-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-md border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none traveller-btn"
                                                                            data-hs-input-number-decrement=""
                                                                            type="button" tabindex="-1"
                                                                            aria-label="Decrease">
                                                                            <svg class="shrink-0 size-3.5"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24"
                                                                                viewBox="0 0 24 24" fill="none"
                                                                                stroke="currentColor" stroke-width="2"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round">
                                                                                <path d="M5 12h14"></path>
                                                                            </svg>
                                                                        </button>
                                                                        <input
                                                                            class="p-0 w-6 bg-transparent border-0 text-gray-800 text-center focus:ring-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none traveller"
                                                                            id="flightchilds"
                                                                            data-hs-input-number-input=""
                                                                            style="-moz-appearance: textfield"
                                                                            type="number"
                                                                            aria-roledescription="Number field"
                                                                            value="0" name="flightchilds" />
                                                                        <button
                                                                            class="size-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-md border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none traveller-btn"
                                                                            data-hs-input-number-increment=""
                                                                            type="button" tabindex="-1"
                                                                            aria-label="Increase">
                                                                            <svg class="shrink-0 size-3.5"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24"
                                                                                viewBox="0 0 24 24" fill="none"
                                                                                stroke="currentColor" stroke-width="2"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round">
                                                                                <path d="M5 12h14"></path>
                                                                                <path d="M12 5v14"></path>
                                                                            </svg>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- End Children Number -->
                                                            <!-- Infant Number -->
                                                            <div class="m-hs-input-group" data-hs-input-number="">
                                                                <div
                                                                    class="min-w-fit flex justify-between items-center gap-x-3">
                                                                    <div class="min-w-fit">
                                                                        <span
                                                                            class="block font-medium text-sm text-gray-800">
                                                                            Infant
                                                                        </span>
                                                                        <span class="block text-xs text-gray-500">
                                                                            (0 - 2 Years)
                                                                        </span>
                                                                    </div>
                                                                    <div class="flex items-center gap-x-1.5">
                                                                        <button
                                                                            class="size-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-md border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none traveller-btn"
                                                                            data-hs-input-number-decrement=""
                                                                            type="button" tabindex="-1"
                                                                            aria-label="Decrease">
                                                                            <svg class="shrink-0 size-3.5"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24"
                                                                                viewBox="0 0 24 24" fill="none"
                                                                                stroke="currentColor" stroke-width="2"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round">
                                                                                <path d="M5 12h14"></path>
                                                                            </svg>
                                                                        </button>
                                                                        <input
                                                                            class="p-0 w-6 bg-transparent border-0 text-gray-800 text-center focus:ring-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none"
                                                                            data-hs-input-number-input=""
                                                                            style="-moz-appearance: textfield"
                                                                            type="number"
                                                                            aria-roledescription="Number field"
                                                                            value="0" name="flightinfants" />
                                                                        <button
                                                                            class="size-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-md border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none traveller-btn"
                                                                            data-hs-input-number-increment=""
                                                                            type="button" tabindex="-1"
                                                                            aria-label="Increase">
                                                                            <svg class="shrink-0 size-3.5"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24"
                                                                                viewBox="0 0 24 24" fill="none"
                                                                                stroke="currentColor" stroke-width="2"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round">
                                                                                <path d="M5 12h14"></path>
                                                                                <path d="M12 5v14"></path>
                                                                            </svg>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- End Infant Number -->

                                                            <!-- Nationality  -->

                                                            <div>
                                                                <label class="text-xs font-medium pb-1"
                                                                    for="">Nationality</label>
                                                                <select class="hidden"
                                                                    data-hs-select='{
                                            "placeholder": "Select Nationality...",
                                            "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                            "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500",
                                            "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300",
                                            "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50",
                                            "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 \" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                                            "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                                          }'
                                                                    name="nationality">
                                                                    @php
                                                                        $countries = collect(listCountries());
                                                                        $countries = $countries->prepend('Nepal', 'NP');
                                                                    @endphp
                                                                    @foreach ($countries as $countryCode => $countryName)
                                                                        <option value="{{ $countryCode }}">
                                                                            {{ $countryName }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <!-- End Nationality  -->

                                                            <!-- Class Radio  -->
                                                            <div class="flex flex-col gap-4" id="intl_class_radio">
                                                                <div class="flex">
                                                                    <input
                                                                        class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                                                        id="economy" type="radio" name="class"
                                                                        value="Economy" checked />
                                                                    <label class="text-sm text-gray-500 ms-2"
                                                                        for="economy">Economy</label>
                                                                </div>

                                                                <div class="flex">
                                                                    <input
                                                                        class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                                                        id="premium-economy" type="radio"
                                                                        name="class" value="First Class" />
                                                                    <label class="text-sm text-gray-500 ms-2"
                                                                        for="premium-economy">First
                                                                        Class</label>
                                                                </div>
                                                                <div class="flex">
                                                                    <input
                                                                        class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                                                        id="business" type="radio" name="class"
                                                                        value="Business" />
                                                                    <label class="text-sm text-gray-500 ms-2"
                                                                        for="business">Business</label>
                                                                </div>
                                                            </div>
                                                            <!-- End Class Radio -->
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <button
                                                class="primary-intl-search mt-3 px-7 py-3 text-sm font-medium rounded-lg border border-transparent g-button-secondary text-white hover:primary focus:outline-none focus:primary disabled:opacity-50 disabled:pointer-events-none"
                                                type="submit">
                                                Modify
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            @isset($search->sectors)
                            @else
                                <div
                                    class="flex items-center justify-center gap-4 py-1 order-2 flex-grow bg-primary rounded-md">
                                    <div class="text-center flex justify-center items-center gap-3 ">
                                        <!-- <i class="fa-solid fa-plane-departure text-white text-base uppercase"></i> -->
                                        <div class="text-white text-base uppercase font-medium">{{ $search->departure }}
                                        </div>
                                        <div class="text-white text-base uppercase font-medium">-</div>
                                        <div class="text-white text-base uppercase font-medium">{{ $search->destination }}
                                        </div>
                                        @if (isset($search->return_date))
                                            <div class="text-white text-base uppercase font-medium">-</div>
                                            <div class="text-white text-base uppercase font-medium">
                                                {{ $search->departure }}</div>
                                        @endif
                                        <!-- <i class="fa-solid fa-plane-arrival text-white text-base uppercase"></i> -->
                                    </div>

                                    <div class="text-white text-sm">
                                        <span class="font-medium">
                                            {{ $search->flight_date->toFormattedDateString() }}
                                        </span>
                                        </small>
                                        {{-- @if (isset($search->return_date))
                                    <small> with return flight of
                                        <strong>{{ $search->return_date->toFormattedDateString() }}</strong></small>
                                    @endif --}}
                                    </div>
                                </div>
                            @endisset

                            <div class="order-3 col-span-2">
                                <button
                                    class="w-full h-full py-2 px-3 flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-secondary text-white focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
                                    data-hs-overlay="#filter-offcanvas" type="button" aria-haspopup="dialog"
                                    aria-expanded="false" aria-controls="filter-offcanvas">
                                    <i class="fa-solid fa-filter"></i>
                                </button>

                                <div class="hs-overlay overflow-y-auto hs-overlay-open:translate-x-0 hidden translate-x-full fixed top-0 end-0 transition-all duration-300 transform h-full max-w-xs w-full z-[80] bg-white border-s filter-call "
                                    id="filter-offcanvas" data-type="mobile" role="dialog" tabindex="-1"
                                    aria-labelledby="filter-offcanvas-label">
                                    <div class="flex justify-between items-center py-3 px-4 border-b">
                                        <h3 class="font-bold text-primary text-xl" id="filter-offcanvas-label">
                                            Filters
                                        </h3>
                                        <button
                                            class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none"
                                            data-hs-overlay="#filter-offcanvas" type="button" aria-label="Close">
                                            <span class="sr-only">Close</span>
                                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M18 6 6 18"></path>
                                                <path d="m6 6 12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="p-4">
                                        <div class="hs-accordion-group mb-4">
                                            <div class="hs-accordion hs-accordion-active:border-gray-200 active bg-white border border-transparent rounded-xl"
                                                id="hs-active-bordered-heading-two">
                                                <button
                                                    class="hs-accordion-toggle hs-accordion-active:text-primary inline-flex justify-between items-center gap-x-3 w-full font-semibold text-start text-gray-800 py-4 px-5 hover:text-gray-500 disabled:opacity-50 disabled:pointer-events-none"
                                                    aria-expanded="true" aria-controls="depart-collapse">
                                                    Stops
                                                    <svg class="hs-accordion-active:hidden block size-3.5"
                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="M5 12h14"></path>
                                                        <path d="M12 5v14"></path>
                                                    </svg>
                                                    <svg class="hs-accordion-active:block hidden size-3.5"
                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="M5 12h14"></path>
                                                    </svg>
                                                </button>
                                                <div class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                                                    id="depart-collapse" role="region"
                                                    aria-labelledby="hs-active-bordered-heading-two">
                                                    <div class="pb-4 px-5">
                                                        <div class="flex py-1">
                                                            <input
                                                                class="shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none stop"
                                                                id="r-stop-zero" type="checkbox" name="stop[]"
                                                                value="0">
                                                            <label class="text-base text-gray-500 ms-3"
                                                                for="r-stop-zero">
                                                                0 Stop(s)
                                                            </label>
                                                        </div>
                                                        <div class="flex py-1">
                                                            <input
                                                                class="shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none stop"
                                                                id="r-stop-one" type="checkbox" name="stop[]"
                                                                value="1">
                                                            <label class="text-base text-gray-500 ms-3"
                                                                for="r-stop-one">
                                                                1 Stop(s)
                                                            </label>
                                                        </div>
                                                        <div class="flex py-1">
                                                            <input
                                                                class="shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none stop"
                                                                id="r-stop-two" type="checkbox" name="stop[]"
                                                                value="2">
                                                            <label class="text-base text-gray-500 ms-3"
                                                                for="r-stop-two">
                                                                2 Stop(s)
                                                            </label>
                                                        </div>
                                                        <div class="flex py-1">
                                                            <input
                                                                class="shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none stop"
                                                                id="r-stop-two-plus" type="checkbox" name="stop[]"
                                                                value="2+">
                                                            <label class="text-base text-gray-500 ms-3"
                                                                for="r-stop-two-plus">
                                                                2+ Stop(s)
                                                            </label>
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
                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="M5 12h14"></path>
                                                        <path d="M12 5v14"></path>
                                                    </svg>
                                                    <svg class="hs-accordion-active:block hidden size-3.5"
                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="M5 12h14"></path>
                                                    </svg>
                                                </button>
                                                <div class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                                                    id="airlies-collapse" role="region"
                                                    aria-labelledby="hs-active-bordered-heading-two">
                                                    <div class="pb-4 px-5">
                                                        <div class="flex py-1">
                                                            <input
                                                                class="shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none"
                                                                id="airline-all" type="checkbox" name="air">
                                                            <label class="text-base text-gray-500 ms-3"
                                                                for="airline-all">All
                                                                Airlines</label>
                                                        </div>
                                                        @if ($airlines)
                                                            @foreach ($airlines as $airline)
                                                                @if (!in_array($airline, $removeAirlines))
                                                                    <div class="flex py-1">
                                                                        <input
                                                                            class="shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none air"
                                                                            id="r-airline-{{ $airline }}"
                                                                            type="checkbox" name="air[]"
                                                                            value="{{ $airline }}">
                                                                        <label class="text-base text-gray-500 ms-3"
                                                                            for="r-airline-{{ $airline }}">
                                                                            {{ help_getAirlineFromCode($airline) }}
                                                                        </label>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        @endif
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
                                                    Departure Time
                                                    <svg class="hs-accordion-active:hidden block size-3.5"
                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="M5 12h14"></path>
                                                        <path d="M12 5v14"></path>
                                                    </svg>
                                                    <svg class="hs-accordion-active:block hidden size-3.5"
                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="M5 12h14"></path>
                                                    </svg>
                                                </button>
                                                <div class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                                                    id="depart-collapse" role="region"
                                                    aria-labelledby="hs-active-bordered-heading-two">
                                                    <div class="pb-4 px-5">
                                                        <div class="flex py-1">
                                                            <input
                                                                class="shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none depart"
                                                                id="r-depart-one" type="checkbox" name="departime[]"
                                                                value="00:00-06:00">
                                                            <label class="text-base text-gray-500 ms-3"
                                                                for="r-depart-one">00:00 -
                                                                06:00</label>
                                                        </div>
                                                        <div class="flex py-1">
                                                            <input
                                                                class="shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none depart"
                                                                id="r-depart-two" type="checkbox" name="departime[]"
                                                                value="06:00-12:00">
                                                            <label class="text-base text-gray-500 ms-3"
                                                                for="r-depart-two">06:00 -
                                                                12:00</label>
                                                        </div>
                                                        <div class="flex py-1">
                                                            <input
                                                                class="shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none depart"
                                                                id="r-depart-three" type="checkbox"
                                                                name="departime[]" value="12:00-18:00">
                                                            <label class="text-base text-gray-500 ms-3"
                                                                for="r-depart-three">12:00 -
                                                                18:00</label>
                                                        </div>
                                                        <div class="flex py-1">
                                                            <input
                                                                class="shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none depart"
                                                                id="r-depart-four" type="checkbox" name="departime[]"
                                                                value="18:00-24:00">
                                                            <label class="text-base text-gray-500 ms-3"
                                                                for="r-depart-four">18:00 -
                                                                24:00</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="hs-accordion-group mb-4">
                                            <div class="hs-accordion hs-accordion-active:border-gray-200 active bg-white border border-transparent rounded-xl"
                                                id="hs-active-bordered-heading-two">
                                                <button
                                                    class="hs-accordion-toggle hs-accordion-active:text-primary inline-flex justify-between items-center gap-x-3 w-full font-semibold text-start text-gray-800 py-4 px-5 hover:text-gray-500 disabled:opacity-50 disabled:pointer-events-none"
                                                    aria-expanded="true" aria-controls="r-arr-collapse">
                                                    Arrival Time
                                                    <svg class="hs-accordion-active:hidden block size-3.5"
                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="M5 12h14"></path>
                                                        <path d="M12 5v14"></path>
                                                    </svg>
                                                    <svg class="hs-accordion-active:block hidden size-3.5"
                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="M5 12h14"></path>
                                                    </svg>
                                                </button>
                                                <div class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                                                    id="r-arr-collapse" role="region"
                                                    aria-labelledby="hs-active-bordered-heading-two">
                                                    <div class="pb-4 px-5">
                                                        <div class="flex py-1">
                                                            <input
                                                                class="shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none arrival"
                                                                id="r-arr-one" type="checkbox" name="arrivaltime[]"
                                                                value="00:00-06:00">
                                                            <label class="text-base text-gray-500 ms-3"
                                                                for="r-arr-one">00:00 -
                                                                06:00</label>
                                                        </div>
                                                        <div class="flex py-1">
                                                            <input
                                                                class="shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none arrival"
                                                                id="r-arr-two" type="checkbox" name="arrivaltime[]"
                                                                value="06:00-12:00">
                                                            <label class="text-base text-gray-500 ms-3"
                                                                for="r-arr-two">06:00 -
                                                                12:00</label>
                                                        </div>
                                                        <div class="flex py-1">
                                                            <input
                                                                class="shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none arrival"
                                                                id="r-arr-three" type="checkbox" name="arrivaltime[]"
                                                                value="12:00-18:00">
                                                            <label class="text-base text-gray-500 ms-3"
                                                                for="r-arr-three">12:00 -
                                                                16:00</label>
                                                        </div>
                                                        <div class="flex py-1">
                                                            <input
                                                                class="shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none arrival"
                                                                id="r-arr-four" type="checkbox" name="arrivaltime[]"
                                                                value="18:00-24:00">
                                                            <label class="text-base text-gray-500 ms-3"
                                                                for="r-arr-four">18:00 -
                                                                24:00</label>
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
                </div>

            </div>
        </div>
    </section>
    <script>
        $(function() {
            $(".returndatevalue").datepicker("option", "minDate",
                "{{ date('Y-m-d', strtotime($search->flight_date)) }}");
        })
    </script>
