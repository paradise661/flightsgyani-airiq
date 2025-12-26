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

    <div class="filters-tab hidden md:block">
        <div class="container mx-auto">
            <div class="hs-accordion-group bg-secondary-lighter ps-2 pt-1 pb-1 mt-3 shadow-md">
                <div class="hs-accordion" id="hs-basic-with-title-and-arrow-stretched-heading-three">
                    <div class="hs-accordion-toggle hs-accordion-active:primary cursor-pointer  flex items-center text-xl font-normal justify-between gap-x-3 w-full text-start text-gray-800 hover:text-gray-500 rounded-lg disabled:opacity-50 disabled:pointer-events-none "
                        aria-expanded="false" aria-controls="hs-basic-with-title-and-arrow-stretched-collapse-three">
                        <div class="min-w-fit flex flex-col justify-between gap-2">
                            Flight Search: {{ $search['departure'] }} - {{ $search['destination'] }}
                            <div
                                class="bg-secondary text-center px-4 py-2 hs-accordion-active:hidden block text-white text-base rounded-md">
                                Modify</div>
                            <div
                                class="bg-primary text-center px-4 py-2 hs-accordion-active:block hidden text-white text-base rounded-md">
                                Modify</div>
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
                    <div class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300"
                        id="hs-basic-with-title-and-arrow-stretched-collapse-three" role="region"
                        aria-labelledby="hs-basic-with-title-and-arrow-stretched-heading-three">
                        <div class="mt-2 px-1 pb-2">

                            <form action="{{ route('flight.search') }}" method="POST">
                                @csrf
                                <div class="flex gap-4 ">
                                    <!-- <h4 class="text-2xl font-normal ">Search Flights</h4> -->
                                    <div class="flex gap-3">
                                        <label
                                            class="flex px-3 py-1 w-full text-nowrap bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 has-[:checked]:bg-primary has-[:checked]:text-white"
                                            for="filter-oneway">
                                            <input class="hidden" id="filter-oneway" type="radio" name="type"
                                                value="O"
                                                {{ is_null($search['return_date']) && !count($sectors) ? 'checked' : '' }} />
                                            One Way
                                        </label>

                                        <label
                                            class="flex px-3 py-1 w-full text-nowrap bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 has-[:checked]:bg-primary has-[:checked]:text-white"
                                            for="filter-twoway">
                                            <input class="hidden" id="filter-twoway" value="R" type="radio"
                                                name="type"
                                                {{ !is_null($search['return_date']) && !count($sectors) ? 'checked' : '' }} />
                                            Two Way
                                        </label>
                                        <label id="mul-city-click"
                                            class="flex px-3 py-1 w-full text-nowrap bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 has-[:checked]:bg-primary has-[:checked]:text-white"
                                            for="filter-multi">
                                            <input class="hidden" id="filter-multi" value="M" type="radio"
                                                name="type" />
                                            Multi City
                                        </label>
                                    </div>
                                </div>
                                @if(count($sectors))
                                    <script>
                                        $(function(){
                                            setTimeout(() => {
                                                $("#mul-city-click").click()
                                                $("#filter-multi").click()
                                            }, 2000);
                                        })
                                    </script>
                                @endif
                                <div class="w-full gap-3 grid grid-cols-12 mt-2 one-two-container"
                                    style="display: grid;">
                                    <div class="col-span-5 md:col-span-3">
                                        <label class="block text-sm font-medium mb-2" for="filter-from">From</label>
                                        <div class="relative">
                                            <input type="hidden" name="depcity" value="{{ $search->departure }}">
                                            <input
                                                class="int-search-typeahead py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                id="filter-from" type="text" name="departure"
                                                placeholder="Departure..." value="{{ $departure }}"
                                                autocomplete="off" />
                                            <div
                                                class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
                                                <svg class="shrink-0 size-4 text-gray-400"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                                    <div class="col-span-5 md:col-span-3">
                                        <label class="block text-sm font-medium mb-2" for="filter-to">To</label>
                                        <div class="relative">
                                            <input type="hidden" name="destinationcity"
                                                value="{{ $search->destination }}">
                                            <input
                                                class="int-search-typeahead py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                id="filter-to" type="text" name="destination"
                                                value="{{ $arrival }}" placeholder="Destination.."
                                                autocomplete="off" />
                                            <div
                                                class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
                                                <svg class="shrink-0 size-4 text-gray-400"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                                    <div class="col-span-5 md:col-span-3">
                                        <label class="block text-sm font-medium mb-2" for="filter-dep">Departure
                                            Date</label>
                                        <div class="relative">
                                            <input
                                                class="py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                id="depdate" type="text" name="flightdate"
                                                placeholder="Flight Date" autocomplete="off"
                                                value="{{ $search->flight_date?->format('Y-m-d') }}" readonly>
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
                                                            stroke-linejoin="round">
                                                        </path>
                                                    </g>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-span-5 md:col-span-3 relative twoway-block" style="{{ !is_null($search['return_date']) && !count($sectors) ? 'opacity: 1;' : 'opacity: 0.4;' }}">
                                        <label class="block text-sm font-medium mb-2" for="filter-return">Return
                                            Date</label>
                                        <div class="relative">
                                            <input
                                                class="py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                id="returndate" type="text" name="returndate"
                                                value="{{ $search->return_date?->format('Y-m-d') }}"
                                                placeholder="Return Date" autocomplete="off" readonly>
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
                                </div>

                                <div class="w-full gap-3 grid grid-cols-12 multi-container" style="display: none;">
                                    <div class="col-span-9">
                                        <div class="w-full gap-3 grid grid-cols-12 mt-2 filter-multi filter-multi-1">
                                            <div class="col-span-4 md:col-span-4">
                                                <div class="relative">
                                                    <input
                                                        class="int-search-typeahead py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                        id="multi-from-1" type="text" name="int_multi_from[]"
                                                        value="{{ isset($sectors[0]) ? $sectors[0]?->depart : null }}"
                                                        placeholder="KTM">
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
                                            <div class="col-span-4 md:col-span-4">
                                                <div class="relative">
                                                    <input
                                                        class="int-search-typeahead py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                        id="multi-to-1" type="text" name="int_multi_to[]"
                                                        value="{{ isset($sectors[0]) ? $sectors[0]?->arrival : null }}"
                                                        placeholder="KTM">
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
                                            <div class="col-span-4 md:col-span-4">
                                                <div class="relative">
                                                    <input
                                                        class="py-3 px-4 ps-11 block w-full multi-depdate border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                        type="text" name="int_multi_departure[]"
                                                        value="{{ isset($sectors[0]) ? $sectors[0]?->date : null }}"
                                                        placeholder="2024/08/21">
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

                                        </div>
                                        <div class="w-full gap-3 grid grid-cols-12 mt-2 filter-multi filter-multi-2">
                                            <div class="col-span-4 md:col-span-4">

                                                <div class="relative">
                                                    <input
                                                        class="int-search-typeahead py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                        id="multi-from-2" type="text" name="int_multi_from[]"
                                                        value="{{ isset($sectors[1]) ? $sectors[1]?->depart : null }}"
                                                        placeholder="KTM">
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
                                            <div class="col-span-4 md:col-span-4">

                                                <div class="relative">
                                                    <input
                                                        class="int-search-typeahead py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                        id="multi-to-2" type="text" name="int_multi_to[]"
                                                        value="{{ isset($sectors[1]) ? $sectors[1]?->arrival : null }}"
                                                        placeholder="KTM">
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
                                            <div class="col-span-4 md:col-span-4">

                                                <div class="relative">
                                                    <input
                                                        class="py-3 px-4 ps-11 block w-full multi-depdate border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                        type="text" name="int_multi_departure[]"
                                                        value="{{ isset($sectors[1]) ? $sectors[1]?->date : null }}"
                                                        placeholder="2024/08/21">
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

                                        </div>
                                        <div class="w-full gap-3 grid-cols-12 mt-2 filter-multi filter-multi-3"
                                            style="display: {{ isset($sectors[2]) ? 'grid' : 'none' }};">
                                            <div class="col-span-4 md:col-span-4">

                                                <div class="relative">
                                                    <input
                                                        class="int-search-typeahead py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                        id="multi-from-3" type="text" name="int_multi_from[]"
                                                        value="{{ isset($sectors[2]) ? $sectors[2]?->depart : null }}"
                                                        placeholder="KTM">
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
                                            <div class="col-span-4 md:col-span-4">

                                                <div class="relative">
                                                    <input
                                                        class="int-search-typeahead py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                        id="multi-to-3" type="text" name="int_multi_to[]"
                                                        value="{{ isset($sectors[2]) ? $sectors[2]?->arrival : null }}"
                                                        placeholder="KTM">
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
                                            <div class="col-span-4 md:col-span-4">

                                                <div class="relative">
                                                    <input
                                                        class="py-3 px-4 ps-11 block w-full multi-depdate border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                        type="text" name="int_multi_departure[]"
                                                        value="{{ isset($sectors[2]) ? $sectors[2]?->date : null }}"
                                                        placeholder="2024/08/21">
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

                                        </div>
                                        <div class="w-full gap-3 grid-cols-12 mt-2 filter-multi filter-multi-4"
                                            style="display: {{ isset($sectors[3]) ? 'grid' : 'none' }};">
                                            <div class="col-span-4 md:col-span-4">

                                                <div class="relative">
                                                    <input
                                                        class="int-search-typeahead py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                        id="multi-from-4" type="text" name="int_multi_from[]"
                                                        value="{{ isset($sectors[3]) ? $sectors[3]?->depart : null }}"
                                                        placeholder="KTM">
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
                                            <div class="col-span-4 md:col-span-4">

                                                <div class="relative">
                                                    <input
                                                        class="int-search-typeahead py-3 px-4 ps-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                        id="multi-to-4" type="text" name="int_multi_to[]"
                                                        value="{{ isset($sectors[3]) ? $sectors[3]?->arrival : null }}"
                                                        placeholder="KTM">
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
                                            <div class="col-span-4 md:col-span-4">

                                                <div class="relative">
                                                    <input
                                                        class="py-3 px-4 ps-11 block w-full multi-depdate border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                        type="text" name="int_multi_departure[]"
                                                        value="{{ isset($sectors[3]) ? $sectors[3]?->date : null }}"
                                                        placeholder="2024/08/21">
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

                                        </div>
                                    </div>
                                    <div class="col-span-3 h-full">
                                        <div class="flex h-full gap-3 items-end">
                                            <button
                                                class="add-filter-multi bg-primary px-3 py-2 text-white rounded-full"
                                                type="button"><i class="fa-solid fa-plus me-2"></i>Add</button>
                                            <button
                                                class="remove-filter-multi bg-secondary px-3 py-2 text-white rounded-full"
                                                type="button" style="display: none;">
                                                <i class="fa-solid fa-minus me-2"></i> Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-end gap-4 mt-2 ">
                                    <div class="col-span-5 md:col-span-2">
                                        <label class="block text-sm font-medium mb-2" for="input-label">Traveller
                                            &amp;
                                            Class</label>

                                        <div
                                            class=" hs-dropdown w-full [--auto-close:inside]  relative sm:inline-flex">
                                            <button
                                                class="hs-dropdown-toggle w-full py-3 px-4 shadow-sm inline-flex border-gray-200  items-center gap-x-2 text-sm font-normal rounded-lg bg-white text-gray-800 hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
                                                id="travellers-drop" type="button" aria-haspopup="menu"
                                                aria-expanded="false" aria-label="Dropdown">
                                                <span
                                                    id="passenger-count">{{ $search['adults'] + $search['childs'] + $search['infants'] }}</span>
                                                Traveller(s)
                                                <svg class="hs-dropdown-open:rotate-180 size-2.5" width="16"
                                                    height="16" viewBox="0 0 16 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5"
                                                        stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" />
                                                </svg>
                                            </button>

                                            <div class="z-10 hs-dropdown-menu w-[300px] hs-dropdown-open:opacity-100 opacity-0 hidden bg-white shadow-md rounded-sm mt-2 filter-class-drop"
                                                id="intlTravellerFilter" role="menu" aria-orientation="vertical"
                                                aria-labelledby="travellers-drop">
                                                <div class="py-4 px-4 flex flex-col gap-4 bg-white">
                                                    <!-- Adult Number -->
                                                    <div class="hs-input-group"
                                                        data-hs-input-number='{"min": 1, "max": 9}'">
                                                        <div
                                                            class=" min-w-fit flex justify-between items-center gap-x-3">
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
                                                                    class="passCount size-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-md border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
                                                                    data-hs-input-number-decrement="" type="button"
                                                                    tabindex="-1" aria-label="Decrease">
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
                                                                    data-hs-input-number-input="" name="flightadults"
                                                                    style="-moz-appearance: textfield" type="number"
                                                                    aria-roledescription="Number field"
                                                                    value="{{ $search['adults'] }}" />
                                                                <button
                                                                    class="passCount size-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-md border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
                                                                    data-hs-input-number-increment="" type="button"
                                                                    tabindex="-1" aria-label="Increase">
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
                                                    <div class="hs-input-group" data-hs-input-number="">
                                                        <div
                                                            class="min-w-fit flex justify-between items-center gap-x-3">
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
                                                                    id="flightchilds" data-hs-input-number-input=""
                                                                    style="-moz-appearance: textfield" type="number"
                                                                    aria-roledescription="Number field"
                                                                    value="{{ $search['childs'] }}"
                                                                    name="flightchilds" />
                                                                <button
                                                                    class="size-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-md border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none traveller-btn"
                                                                    data-hs-input-number-increment="" type="button"
                                                                    tabindex="-1" aria-label="Increase">
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
                                                    <div class="hs-input-group" data-hs-input-number="">
                                                        <div
                                                            class="min-w-fit flex justify-between items-center gap-x-3">
                                                            <div class="min-w-fit">
                                                                <span class="block font-medium text-sm text-gray-800">
                                                                    Infant
                                                                </span>
                                                                <span class="block text-xs text-gray-500">
                                                                    (0 - 2 Years)
                                                                </span>
                                                            </div>
                                                            <div class="flex items-center gap-x-1.5">
                                                                <button
                                                                    class="size-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-md border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none traveller-btn"
                                                                    data-hs-input-number-decrement="" type="button"
                                                                    tabindex="-1" aria-label="Decrease">
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
                                                                    style="-moz-appearance: textfield" type="number"
                                                                    aria-roledescription="Number field"
                                                                    value="{{ $search['infants'] }}"
                                                                    name="flightinfants" />
                                                                <button
                                                                    class="size-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-md border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none traveller-btn"
                                                                    data-hs-input-number-increment="" type="button"
                                                                    tabindex="-1" aria-label="Increase">
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
                                                        <select
                                                            data-hs-select='{"value": "{{ $search->nationality }}", "hasSearch": true, "placeholder": "Select Nationality...", "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                                                        "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500",
                                                                        "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300",
                                                                        "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50",
                                                                        "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                                                                        "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                                                                    }'
                                                            class="hidden" name="nationality">
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
                                                                value="Economy" />
                                                            <label class="text-sm text-gray-500 ms-2"
                                                                for="economy">Economy</label>
                                                        </div>

                                                        <div class="flex">
                                                            <input
                                                                class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                                                id="premium-economy" type="radio" name="class"
                                                                value="First Class" />
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
                </div>
            </div>
        </div>
    </div>
