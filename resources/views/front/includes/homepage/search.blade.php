@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li class="text-red-500">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
{{-- New Design --}}
<!-- Search Box  -->
<div class="search-box" style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">
    <div class="search-inner-wrap">
        <div class="sf-card relative sf-card-default z-20 drop-shadow-md w-full rounded-lg py-4">
            <!-- Flight Type Navigation Tab  -->
            <div class="flex justify-start">
                <div class="flex ms-8 hover:bg-gray-200 bg-gray-200 rounded-lg transition p-1">
                    <nav class="flex gap-x-1" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
                        <button
                            class="hs-tab-active:bg-white hs-tab-active:text-primary py-2 px-5 inline-flex items-center gap-x-2 bg-transparent text-sm text-black hover:text-gray-700 focus:outline-none focus:text-gray-700 font-medium rounded-lg hover:hover:text-primary disabled:opacity-50 disabled:pointer-events-none active"
                            id="international-item-tab" data-hs-tab="#international-tab" type="button"
                            aria-selected="true" aria-controls="international-tab" role="tab">
                            International
                        </button>
                        <button
                            class="hs-tab-active:bg-white hs-tab-active:text-primary py-2 px-5 inline-flex items-center gap-x-2 bg-transparent text-sm text-black hover:text-gray-700 focus:outline-none focus:text-gray-700 font-medium rounded-lg hover:hover:text-primary disabled:opacity-50 disabled:pointer-events-none"
                            id="domestic-item-tab" data-hs-tab="#domestic-tab" type="button" aria-selected="false"
                            aria-controls="domestic-tab" role="tab">
                            Domestic
                        </button>
                    </nav>
                </div>
            </div>
            <!--/ Flight Type Navigation Tab  -->

            <div class="px-8">
                <form id="search_box" action="{{ route('flight.search') }}" method="POST">
                    @csrf
                    <!-- International Tab  -->
                    <div id="international-tab" role="tabpanel" aria-labelledby="international-item-tab">
                        <!-- Trip Type Dropdown  -->
                        <div class="absolute top-4 left-[300px]">
                            <div class="relative">
                                <select class="border-0 py-3 text-sm font-medium rounded-md focus:ring-0 bg-none"
                                    id="tripType" name="type">
                                    <option class="hover:bg-secondary" value="O">One Way</option>
                                    <option class="hover:bg-secondary" value="R">Two Way</option>
                                    <option class="hover:bg-secondary" value="M">Multi City</option>
                                </select>
                                <div class="absolute top-1/2 end-2.5 -translate-y-1/2">
                                    <svg class="shrink-0 size-4 text-gray-500 " xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="m7 15 5 5 5-5"></path>
                                        <path d="m7 9 5-5 5 5"></path>
                                    </svg>
                                </div>
                            </div>

                        </div>
                        <!-- / Trip Type Dropdown  -->

                        <!-- International Search  -->
                        <div class="mt-3">
                            <!-- International OneTwo Way  -->
                            <div class="search-wrap oneTwoWayLayout w-full items-center bg-white rounded-md">
                                <div class="flex justify-items-center items-center">
                                    <div class="depcity_col flex border-e">
                                        <div class="hs-dropdown relative inline-flex [--auto-close:inside] w-[270px] intDepartureDrop"
                                            id="intDepartureDrop">
                                            <div class="innercol hs-dropdwon-toggle @error('departure') text-red-600 @enderror"
                                                id="international-departure-drop" aria-haspopup="menu"
                                                aria-expanded="false" aria-label="Dropdown">
                                                <p class="font-semibold text-xs text-gray-400">FROM</p>
                                                <input id="depcity" type="hidden" name="depcity" value="KTM" />
                                                <input id="depairport" type="hidden" name="departure"
                                                    value="KTM- Tribhuvan,Kathmandu-Nepal" />
                                                <div class="text-2xl font-semibold d-depcity" id="d-depcity"><span
                                                        class="text-muted text-sm"></span> KTM</div>
                                                <div class="font-medium text-xs d-depairport" id="d-depairport">[KTM]
                                                    Tribhuwan International Airport</div>
                                            </div>
                                            <div class="px-4 py-3 z-50 hs-dropdown-menu search-d-transform duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-72 bg-white shadow-md rounded-lg mt-2 top-0"
                                                role="menu" aria-orientation="vertical"
                                                aria-labelledby="international-departure-drop">
                                                <div class="w-full flex justify-between items-center">
                                                    <h4>Flying From</h4>
                                                </div>
                                                <div class="relative mt-2">
                                                    <div class="widget__input">
                                                        <input
                                                            class="intSearchInput peer py-3 px-4 ps-11 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                            id="intOrigin" data-direction="from" type="text"
                                                            autocomplete="off" placeholder="Origin Airport" autofocus />
                                                        @if ($errors->has('departure'))
                                                            <span class="error">
                                                                {{ $errors->first('departure') }}
                                                            </span>
                                                        @endif

                                                    </div>
                                                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4 peer-disabled:opacity-50 peer-disabled:pointer-events-none"
                                                        style="height:44px;">
                                                        <svg width="24px" height="24px" viewBox="0 0 24 24"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                                stroke-linejoin="round"></g>
                                                            <g id="SVGRepo_iconCarrier">
                                                                <path
                                                                    d="M12 21C15.5 17.4 19 14.1764 19 10.2C19 6.22355 15.866 3 12 3C8.13401 3 5 6.22355 5 10.2C5 14.1764 8.5 17.4 12 21Z"
                                                                    stroke="#929292" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                </path>
                                                                <path
                                                                    d="M12 12C13.1046 12 14 11.1046 14 10C14 8.89543 13.1046 8 12 8C10.8954 8 10 8.89543 10 10C10 11.1046 10.8954 12 12 12Z"
                                                                    stroke="#929292" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                </path>
                                                            </g>
                                                        </svg>
                                                    </div>
                                                </div>
                                                {{-- Dropdown --}}
                                                <div class="dropdown-content max-h-64 max-w-72 overflow-x-auto overflow-y-auto flex flex-col gap-1 mt-2 -me-2 [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-track]:bg-gray-100
                                                     [&::-webkit-scrollbar-thumb]:bg-gray-300 [&::-webkit-scrollbar-thumb]:rounded-full"
                                                    id="dropdownList">
                                                </div>
                                                {{-- ./Dropdown --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swipesector" id="desktop-swipesector"></div>
                                    <div class="arrcity_col flex border-e">
                                        <div class="hs-dropdown relative inline-flex [--auto-close:inside] w-[270px] intDestinationDrop"
                                            id="intDestinationDrop">
                                            <div class="innercol hs-dropdwon-toggle @error('destination') text-red-600 @enderror"
                                                id="international-departure-drop" aria-haspopup="menu"
                                                aria-expanded="false" aria-label="Dropdown">
                                                <p class="font-semibold text-xs text-gray-400">TO</p>
                                                <input id="arrcity" type="hidden" name="destinationcity"
                                                    value="DEL" />
                                                <input id="arrairport" type="hidden" name="destination"
                                                    value="DEL- Indira Gandhi International,Delhi-India" />

                                                <div class="text-2xl font-semibold d-arrcity"><span
                                                        class="text-sm text-muted"></span> DEL</div>
                                                <div class="font-medium text-xs d-arrairport">[DEL] Indira Gandhi
                                                    International Airport</div>
                                            </div>
                                            <div class="px-4 py-3 z-50 hs-dropdown-menu search-t-transform duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-72 bg-white shadow-md rounded-lg mt-2 top-0"
                                                role="menu" aria-orientation="vertical"
                                                aria-labelledby="international-destination-drop">
                                                <div class="w-full flex justify-between items-center">
                                                    <h4>Flying To</h4>
                                                </div>
                                                <div class="relative mt-2">
                                                    <input
                                                        class="intSearchInput peer py-3 px-4 ps-11 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                        id="intDestination" data-direction="to" type="text"
                                                        autocomplete="off" placeholder="Destination Airport">
                                                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4 peer-disabled:opacity-50 peer-disabled:pointer-events-none"
                                                        style="height:44px;">
                                                        <svg width="24px" height="24px" viewBox="0 0 24 24"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                                stroke-linejoin="round"></g>
                                                            <g id="SVGRepo_iconCarrier">
                                                                <path
                                                                    d="M12 21C15.5 17.4 19 14.1764 19 10.2C19 6.22355 15.866 3 12 3C8.13401 3 5 6.22355 5 10.2C5 14.1764 8.5 17.4 12 21Z"
                                                                    stroke="#929292" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                </path>
                                                                <path
                                                                    d="M12 12C13.1046 12 14 11.1046 14 10C14 8.89543 13.1046 8 12 8C10.8954 8 10 8.89543 10 10C10 11.1046 10.8954 12 12 12Z"
                                                                    stroke="#929292" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                </path>
                                                            </g>
                                                        </svg>
                                                    </div>
                                                </div>
                                                {{-- Dropdown --}}
                                                <div class="dropdown-content max-h-64 max-w-72 overflow-x-auto overflow-y-auto flex flex-col gap-1 mt-2 -me-2 [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 [&::-webkit-scrollbar-thumb]:rounded-full"
                                                    id="dropdownList">
                                                </div>
                                                {{-- ./Dropdown --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex border-e depdate_col">
                                        <div class="innercol">
                                            <p class="font-semibold text-xs text-gray-400">
                                                DEPARTURE DATE
                                            </p>
                                            <div class="flex items-center">
                                                <input
                                                    class="peer px-0 block w-full bg-transparent border-0 text-base text-black font-semibold disabled:opacity-50 disabled:pointer-events-none tracking-wide focus:shadow-none focus:ring-0"
                                                    id="depdate" type="text" name="flightdate"
                                                    value="{{ date('Y-m-d') }}" placeholder="yyyy-mm-dd"
                                                    autocomplete="off" />
                                                <img class="w-[17px] h-[17px] float-right mt-[8px]"
                                                    src="{{ asset('images/icons/calendar.svg') }}" alt="" />
                                            </div>

                                            {{-- <p class="font-medium text-xs">Saturday</p> --}}
                                        </div>
                                    </div>
                                    <div class="flex border-e depdate_col ret-date-col" style="opacity: 0.4">
                                        <div class="innercol relative">
                                            <p class="font-semibold text-xs text-gray-400">
                                                RETURN DATE
                                            </p>
                                            <div class="flex items-center">
                                                <input
                                                    class="peer px-0 block w-full bg-transparent border-0 text-base text-black font-semibold disabled:opacity-50 disabled:pointer-events-none tracking-wide focus:shadow-none focus:ring-0"
                                                    id="returndate" type="text" placeholder="mm/dd/yyyy"
                                                    autocomplete="off" name="returndate" />
                                                <img class="w-[17px] h-[17px] float-right mt-[8px]"
                                                    src="{{ asset('images/icons/calendar.svg') }}" alt="" />
                                            </div>
                                            {{-- <p class="font-medium text-xs">Saturday</p> --}}
                                            <div class="absolute top-1 right-2 bg-gray-100 p-2 size-1 rounded-full flex items-center justify-center"
                                                id="intReturnCross">
                                                <i class="fa-solid fa-xmark"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="search-col">
                                        <div class="innercol">
                                            <p class="font-semibold text-xs text-gray-400">
                                                TRAVELLER & CLASS
                                            </p>
                                            <div
                                                class="mt-1 py-2 mx-1 sm:mt-1 hs-dropdown [--auto-close:inside] relative sm:inline-flex z-20">
                                                <button
                                                    class="hs-dropdown-toggle inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-white text-gray-800 hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
                                                    id="travellers-drop" type="button" aria-haspopup="menu"
                                                    aria-expanded="false" aria-label="Dropdown">
                                                    <span id="passenger-count">1</span> Traveller(s)
                                                    <svg class="hs-dropdown-open:rotate-180 size-2.5" width="16"
                                                        height="16" viewBox="0 0 16 16" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" />
                                                    </svg>
                                                </button>

                                                <div class="hs-dropdown-menu w-[300px] traveller-drop hs-dropdown-open:opacity-100 opacity-0 hidden bg-white shadow-md rounded-sm mt-2"
                                                    id="intlTravellerFilter" role="menu"
                                                    aria-orientation="vertical" aria-labelledby="travellers-drop">
                                                    <div class="py-4 px-4 flex flex-col gap-4 bg-white">
                                                        <!-- Adult Number -->
                                                        <div class="hs-input-group"
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
                                                        <div class="hs-input-group" data-hs-input-number="">
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
                                                        <div class="hs-input-group" data-hs-input-number="">
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
                                                                "hasSearch": true,
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
                                                                        {{ $countryName }}
                                                                    </option>
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
                                            <div class="font-medium text-xs text-gray-700 intl-seat-class">
                                                Economy
                                            </div>
                                        </div>
                                    </div>
                                    <div class="search-col primary-intl-search">
                                        <button
                                            class="bg-secondary py-10 w-full text-xl text-white font-semibold rounded-tr-md rounded-br-md"
                                            type="submit">
                                            SEARCH
                                        </button>
                                    </div>
                                </div>
                                <div class="items-center hidden" id="multiAction">
                                    <div class="multi-container pb-4">

                                        @for ($i = 0; $i <= 4; $i++)
                                            <div class="flex justify-items-center items-center"
                                                style="display:{{ $i === 0 ? 'flex' : 'none' }};">
                                                @include('front.includes.homepage.flight-select-input', [
                                                    'iteration' => $i,
                                                ])
                                            </div>
                                        @endfor

                                    </div>
                                    <div class="py-3">
                                        <div class="innercol">
                                            <div class="flex gap-2 w-full items-center">
                                                <button
                                                    class="primary-intl-search search bg-secondary text-white px-6 w-full py-3 text-lg font-medium uppercase rounded-full min-w-fit"
                                                    type="submit">
                                                    search
                                                </button>
                                                <button
                                                    class="addmultibtn border uppercase text-base rounded-full px-5 py-3 text-primary font-medium border-primary min-w-fit"
                                                    style="display: inline-block" type="button"
                                                    onclick="addMultiRow()">
                                                    + Add city
                                                </button>
                                                <button
                                                    class="removemultibtn border uppercase text-sm items-center gap-1 rounded-full h-[16px] w-[16px] py-3 px-2 text-gray-600 font-medium border-gratext-gray-600 min-w-fit"
                                                    style="display: none" type="button" onclick="removeMultiRow()">
                                                    <i class="fa-solid fa-xmark text-gray-600"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- / International OneTwo Way  -->

                            <!-- / International Multi City -->
                        </div>
                        <!-- / International Search  -->
                    </div>
                    <!--/ International Tab  -->
                </form>

                @include('front.domestic.search')
            </div>
        </div>
    </div>
</div>

<div class="r-search-box ">
    <div class="container mx-auto">
        <div class="px-4 pb-4">
            <div class="bg-white rounded-lg shadow-md px-4 py-4">
                <!-- Tab Header  -->
                <nav class="flex justify-center gap-x-1" aria-label="Tabs" role="tablist"
                    aria-orientation="horizontal">
                    <button
                        class="hs-tab-active:bg-secondary hs-tab-active:text-white hs-tab-active:hover:text-white hs-tab-active: py-2 px-6 inline-flex items-center gap-x-2 bg-transparent text-base font-medium text-center text-gray-500 hover:text-secondary focus:outline-none focus:text-secondary-lighter rounded-lg disabled:opacity-50 disabled:pointer-events-none active"
                        id="pills-with-brand-color-item-1" data-hs-tab="#pills-with-brand-color-1" type="button"
                        aria-selected="true" aria-controls="pills-with-brand-color-1" role="tab">
                        International
                    </button>
                    <button
                        class="hs-tab-active:bg-secondary hs-tab-active:text-white hs-tab-active:hover:text-white hs-tab-active: py-2 px-6 inline-flex items-center gap-x-2 bg-transparent text-base font-medium text-center text-gray-500 hover:text-secondary focus:outline-none focus:text-secondary-lighter rounded-lg disabled:opacity-50 disabled:pointer-events-none"
                        id="pills-with-brand-color-item-2" data-hs-tab="#pills-with-brand-color-2" type="button"
                        aria-selected="false" aria-controls="pills-with-brand-color-2" role="tab">
                        Domestic
                    </button>
                </nav>
                <!-- / Tab Header  -->

                <div class="mt-3">
                    <form id="search_box" action="{{ route('flight.search') }}" method="POST">
                        @csrf
                        <!-- International Tab  -->
                        <div id="pills-with-brand-color-1" role="tabpanel"
                            aria-labelledby="pills-with-brand-color-item-1">
                            <div class="flex">
                                <label
                                    class="flex items-center py-1 px-5 w-full text-center bg-white rounded-3xl text-sm focus:border-primary focus:ring-primary text-gray-500 has-[:checked]:bg-primary has-[:checked]:text-white"
                                    for="international-radio-one">
                                    <input
                                        class="hidden shrink-0 mt-0.5 border-gray-200 rounded-full text-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                        id="international-radio-one" type="radio" name="type" checked=""
                                        value="O">
                                    <span class="text-sm text-center w-full">One Way</span>
                                </label>
                                <label
                                    class="flex items-center py-1 px-5 w-full text-center bg-white rounded-3xl text-sm focus:border-primary focus:ring-primary text-gray-500 has-[:checked]:bg-primary has-[:checked]:text-white"
                                    for="international-radio-two">
                                    <input
                                        class="hidden shrink-0 mt-0.5 border-gray-200 rounded-full text-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                        id="international-radio-two" type="radio" name="type" value="R" />
                                    <span class="text-sm text-center w-full">Two Way</span>
                                </label>
                                <label
                                    class="flex items-center py-1 px-5 w-full text-center bg-white rounded-3xl text-sm focus:border-primary focus:ring-primary text-gray-500 has-[:checked]:bg-primary has-[:checked]:text-white"
                                    for="international-radio-multi">
                                    <input
                                        class="hidden shrink-0 mt-0.5 border-gray-200 rounded-full text-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                        id="international-radio-multi" type="radio" name="type"
                                        value="M" />
                                    <span class="text-sm text-center w-full">Multi City</span>
                                </label>
                            </div>

                            <!-- One / Two Way  -->
                            <div class="grid grid-cols-2 gap-4 mt-3 r-singlecity" style="display: grid">
                                <div class="r-from relative">
                                    <div class="border border-primary px-2 py-3 rounded-lg">
                                        <div class="relative inline-flex w-full">
                                            <div class="flex flex-col items-center justify-center w-full">
                                                <input id="r-depcity" name="depcity" type="hidden" readonly=""
                                                    value="KTM">
                                                <input id="r-depairport" name="departure" type="hidden"
                                                    readonly="" value="KTM- Tribhuvan,Kathmandu-Nepal">
                                                <input id="r-depcityfull" name="depcityfull" type="hidden"
                                                    readonly="" value="Kathmandu">
                                                <p class="text-xs text-gray-400 font-medium capitalize">
                                                    FROM
                                                </p>
                                                <div
                                                    class="text-2xl text-black font-bold uppercase leading-10 boarder-0 d-depcity">
                                                    KTM
                                                </div>
                                                <div class="text-xs text-black font-semibold uppercase overflow-hidden text-ellipsis r-depcityfull"
                                                    style="overflow-wrap: anywhere;">
                                                    Kathmandu
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="open-international-search stretched-link"></div>

                                    <div class="r-swipesector absolute top-7 -right-7 border border-primary"
                                        id="r-swapinput"></div>
                                </div>
                                <div class="r-to relative">
                                    <div class="border border-primary px-2 py-3 rounded-lg">
                                        <div class="relative inline-flex w-full ">
                                            <div class="flex flex-col items-center justify-center w-full">
                                                <input id="r-arrcity" name="destinationcity" type="hidden"
                                                    readonly="" value="DEL">
                                                <input id="r-arrairport" name="destination" type="hidden"
                                                    readonly=""
                                                    value="DEL- Indira Gandhi International,Delhi-India">
                                                <input id="r-arrcityfull" name="arrcityfull" type="hidden"
                                                    readonly="" value="Delhi">
                                                <p class="text-xs text-gray-400 font-medium capitalize">
                                                    TO
                                                </p>
                                                <div class="text-2xl text-black font-bold uppercase border-0 leading-10 d-arrcity"
                                                    id="display-arrairport">DEL</div>
                                                <div class="text-xs text-black font-semibold uppercase overflow-hidden text-ellipsis r-arrcityfull"
                                                    id="display-arrcity" style="overflow-wrap: anywhere;">
                                                    Delhi
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="open-international-search stretched-link"></div>
                                </div>
                                <div class="r-dep">
                                    <div
                                        class="border border-primary px-2 py-3 rounded-lg flex flex-col items-start justify-center">
                                        <p class="text-xs text-gray-400 font-medium capitalize">
                                            Departure Date
                                        </p>
                                        <div class="relative">
                                            <input
                                                class="peer pe-2 pt-2 pb-2 ps-8 block w-full bg-transparent border-0 text-base text-black font-semibold disabled:opacity-50 disabled:pointer-events-none tracking-wide focus:shadow-none focus:ring-0"
                                                id="r-depdate" type="text" name="flightdate"
                                                value="{{ date('Y-m-d') }}" placeholder="mm/dd/yyyy"
                                                autocomplete="off" readonly />
                                            <div
                                                class="absolute inset-y-0 start-0 flex items-center pointer-events-none peer-disabled:opacity-50 peer-disabled:pointer-events-none">
                                                <svg width="25px" height="25px" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <path
                                                            d="M3 9H21M7 3V5M17 3V5M6 12H8M11 12H13M16 12H18M6 15H8M11 15H13M16 15H18M6 18H8M11 18H13M16 18H18M6.2 21H17.8C18.9201 21 19.4802 21 19.908 20.782C20.2843 20.5903 20.5903 20.2843 20.782 19.908C21 19.4802 21 18.9201 21 17.8V8.2C21 7.07989 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V17.8C3 18.9201 3 19.4802 3.21799 19.908C3.40973 20.2843 3.71569 20.5903 4.09202 20.782C4.51984 21 5.07989 21 6.2 21Z"
                                                            stroke="#929292" stroke-width="1" stroke-linecap="round">
                                                        </path>
                                                    </g>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="r-return" style="opacity: 0.4">
                                    <div
                                        class="relative border border-primary px-2 py-3 rounded-lg flex flex-col items-start justify-center">
                                        <p class="text-xs text-gray-400 font-medium capitalize">
                                            Return Date
                                        </p>
                                        <div class="relative">
                                            <input
                                                class="peer pe-2 pt-2 pb-2 ps-8 block w-full bg-transparent border-0 text-base text-black font-semibold disabled:opacity-50 disabled:pointer-events-none tracking-wide focus:shadow-none focus:ring-0"
                                                id="r-returndate" name="returndate" type="text"
                                                placeholder="mm/dd/yyyy" autocomplete="off" readonly />
                                            <div
                                                class="absolute inset-y-0 start-0 flex items-center pointer-events-none peer-disabled:opacity-50 peer-disabled:pointer-events-none">
                                                <svg width="25px" height="25px" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <path
                                                            d="M3 9H21M7 3V5M17 3V5M6 12H8M11 12H13M16 12H18M6 15H8M11 15H13M16 15H18M6 18H8M11 18H13M16 18H18M6.2 21H17.8C18.9201 21 19.4802 21 19.908 20.782C20.2843 20.5903 20.5903 20.2843 20.782 19.908C21 19.4802 21 18.9201 21 17.8V8.2C21 7.07989 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V17.8C3 18.9201 3 19.4802 3.21799 19.908C3.40973 20.2843 3.71569 20.5903 4.09202 20.782C4.51984 21 5.07989 21 6.2 21Z"
                                                            stroke="#929292" stroke-width="1" stroke-linecap="round">
                                                        </path>
                                                    </g>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="absolute top-2 right-2 bg-gray-100 p-2 size-1 rounded-full flex items-center justify-center"
                                            id="returnCross">
                                            <i class="fa-solid fa-xmark"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="r-travellers">
                                    <div
                                        class="relative border border-primary px-2 py-3 rounded-lg flex flex-col items-start justify-center">
                                        <p class="text-xs text-gray-400 font-medium capitalize">
                                            Traveller(s)
                                        </p>
                                        <!-- Travellers Count  -->
                                        <div class="travellers-count">
                                            <button class="py-1 text-sm text-black font-semibold"
                                                id="travellers-count"
                                                data-hs-overlay="#hs-offcanvas-bottom-international" type="button"
                                                aria-haspopup="dialog" aria-expanded="false"
                                                aria-controls="hs-offcanvas-bottom-international">
                                                1
                                            </button>
                                            <div class="hs-overlay hs-overlay-open:translate-y-0 translate-y-full fixed bottom-0 inset-x-0 transition-all duration-300 transform max-h-[32rem] size-full z-[9999] bg-white border-b hidden"
                                                id="hs-offcanvas-bottom-international" role="dialog" tabindex="-1"
                                                aria-labelledby="hs-offcanvas-bottom-label">
                                                <div class="flex justify-between items-center py-3 px-4 border-b">
                                                    <h3 class="font-medium text-lg text-gray-800"
                                                        id="hs-offcanvas-bottom-label">
                                                        No. of Travellers
                                                    </h3>
                                                    <div class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none"
                                                        data-hs-overlay="#hs-offcanvas-bottom-international"
                                                        type="button" aria-label="Close">
                                                        <span class="sr-only">Close</span>
                                                        <svg class="shrink-0 size-4"
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M18 6 6 18"></path>
                                                            <path d="m6 6 12 12"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <!-- No of Travellers Select  -->
                                                <div class="p-4" id="rTravellerRadio">
                                                    <!-- Adult Travellers  -->
                                                    <div class="adult-travellers">
                                                        <label class="" for="adultcount">
                                                            <span class="font-semibold">Adults</span> (12+
                                                            yrs)</label>
                                                        <div class="flex gap-2 mt-2">
                                                            <label
                                                                class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary"
                                                                for="adult-1">
                                                                <input class="hidden" id="adult-1" type="radio"
                                                                    name="flightadults" value="1" checked>
                                                                <span class="text-sm">1</span>
                                                            </label>

                                                            <label
                                                                class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary"
                                                                for="adult-2">
                                                                <input class="hidden" id="adult-2" type="radio"
                                                                    name="flightadults" value="2">
                                                                <span class="text-sm">2</span>
                                                            </label>

                                                            <label
                                                                class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary"
                                                                for="adult-3">
                                                                <input class="hidden" id="adult-3" type="radio"
                                                                    name="flightadults" value="3">
                                                                <span class="text-sm">3</span>
                                                            </label>
                                                            <label
                                                                class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary"
                                                                for="adult-4">
                                                                <input class="hidden" id="adult-4" type="radio"
                                                                    name="flightadults" value="4">
                                                                <span class="text-sm">4</span>
                                                            </label>
                                                            <label
                                                                class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary"
                                                                for="adult-5">
                                                                <input class="hidden" id="adult-5" type="radio"
                                                                    name="flightadults" value="5">
                                                                <span class="text-sm">5</span>
                                                            </label>
                                                            <label
                                                                class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary"
                                                                for="adult-6">
                                                                <input class="hidden" id="adult-6" type="radio"
                                                                    name="flightadults" value="6">
                                                                <span class="text-sm">6</span>
                                                            </label>
                                                            <label
                                                                class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary"
                                                                for="adult-7">
                                                                <input class="hidden" id="adult-7" type="radio"
                                                                    name="flightadults" value="7">
                                                                <span class="text-sm">7</span>
                                                            </label>
                                                            <label
                                                                class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary"
                                                                for="adult-8">
                                                                <input class="hidden" id="adult-8" type="radio"
                                                                    name="flightadults" value="8">
                                                                <span class="text-sm">8</span>
                                                            </label>
                                                            <label
                                                                class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary"
                                                                for="adult-9">
                                                                <input class="hidden" id="adult-9" type="radio"
                                                                    name="flightadults" value="9">
                                                                <span class="text-sm">9</span>
                                                            </label>
                                                        </div>
                                                        <input id="adultcount" name="adultcount" type="hidden">
                                                    </div>
                                                    <!-- / Adult Travellers  -->

                                                    <!-- Children Travellers -->
                                                    <div class="children-travellers mt-6">
                                                        <label class="" for="childrencount">
                                                            <span class="font-semibold">Children</span>
                                                            (2-12 yrs)</label>
                                                        <div class="flex gap-2 mt-2">
                                                            <label
                                                                class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary"
                                                                for="children-0">
                                                                <input class="hidden" id="children-0" type="radio"
                                                                    name="flightchilds" value="0">
                                                                <span class="text-sm">0</span>
                                                            </label>
                                                            <label
                                                                class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary"
                                                                for="children-1">
                                                                <input class="hidden" id="children-1" type="radio"
                                                                    name="flightchilds" value="1">
                                                                <span class="text-sm">1</span>
                                                            </label>

                                                            <label
                                                                class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary"
                                                                for="children-2">
                                                                <input class="hidden" id="children-2" type="radio"
                                                                    name="flightchilds" value="2">
                                                                <span class="text-sm">2</span>
                                                            </label>

                                                            <label
                                                                class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary"
                                                                for="children-3">
                                                                <input class="hidden" id="children-3" type="radio"
                                                                    name="flightchilds" value="3">
                                                                <span class="text-sm">3</span>
                                                            </label>
                                                            <label
                                                                class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary"
                                                                for="children-4">
                                                                <input class="hidden" id="children-4" type="radio"
                                                                    name="flightchilds" value="4">
                                                                <span class="text-sm">4</span>
                                                            </label>
                                                            <label
                                                                class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary"
                                                                for="children-5">
                                                                <input class="hidden" id="children-5" type="radio"
                                                                    name="flightchilds" value="5">
                                                                <span class="text-sm">5</span>
                                                            </label>
                                                            <label
                                                                class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary"
                                                                for="children-6">
                                                                <input class="hidden" id="children-6" type="radio"
                                                                    name="flightchilds" value="6">
                                                                <span class="text-sm">6</span>
                                                            </label>
                                                            <label
                                                                class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary"
                                                                for="children-7">
                                                                <input class="hidden" id="children-7" type="radio"
                                                                    name="flightchilds" value="7">
                                                                <span class="text-sm">7</span>
                                                            </label>
                                                            <label
                                                                class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary"
                                                                for="children-8">
                                                                <input class="hidden" id="children-8" type="radio"
                                                                    name="flightchilds" value="8">
                                                                <span class="text-sm">8</span>
                                                            </label>
                                                        </div>
                                                        <input id="childrencount" name="childrencount"
                                                            type="hidden">
                                                    </div>
                                                    <!-- / Children Travellers -->

                                                    <!-- Infant Travellers  -->
                                                    <div class="infant-travellers mt-6">
                                                        <label class="" for="infantcount">
                                                            <span class="font-semibold">Infant</span> (0-2
                                                            yrs)</label>
                                                        <div class="flex gap-2 mt-2">
                                                            <label
                                                                class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary"
                                                                for="infant-0">
                                                                <input class="hidden" id="infant-0" type="radio"
                                                                    name="flightinfants" value="0">
                                                                <span class="text-sm">0</span>
                                                            </label>
                                                            <label
                                                                class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary"
                                                                for="infant-1">
                                                                <input class="hidden" id="infant-1" type="radio"
                                                                    name="flightinfants" value="1">
                                                                <span class="text-sm">1</span>
                                                            </label>
                                                            <label
                                                                class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary"
                                                                for="infant-2">
                                                                <input class="hidden" id="infant-2" type="radio"
                                                                    name="flightinfants" value="2">
                                                                <span class="text-sm">2</span>
                                                            </label>
                                                            <label
                                                                class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary"
                                                                for="infant-3">
                                                                <input class="hidden" id="infant-3" type="radio"
                                                                    name="flightinfants" value="3">
                                                                <span class="text-sm">3</span>
                                                            </label>
                                                            <label
                                                                class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary"
                                                                for="infant-4">
                                                                <input class="hidden" id="infant-4" type="radio"
                                                                    name="flightinfants" value="4">
                                                                <span class="text-sm">4</span>
                                                            </label>
                                                        </div>
                                                        <input id="infantcount" name="infantcount" type="hidden">
                                                    </div>
                                                    <!-- / Infant Travellers  -->
                                                    <!-- Nationality Travellers  -->
                                                    <div class="nationality mt-6">
                                                        <label for="">
                                                            <span class="font-semibold">Nationality</span></label>

                                                        <div class="hs-select relative">
                                                            <select class="hidden"
                                                                data-hs-select="{
                                                                    &quot;placeholder&quot;: &quot;Select Nationality...&quot;,
                                                                    &quot;toggleTag&quot;: &quot;<button type=\&quot;button\&quot; aria-expanded=\&quot;false\&quot;></button>&quot;,
                                                                    &quot;toggleClasses&quot;: &quot;hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500&quot;,
                                                                    &quot;dropdownClasses&quot;: &quot;mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&amp;::-webkit-scrollbar]:w-2 [&amp;::-webkit-scrollbar-thumb]:rounded-full [&amp;::-webkit-scrollbar-track]:bg-gray-100 [&amp;::-webkit-scrollbar-thumb]:bg-gray-300&quot;,
                                                                    &quot;optionClasses&quot;: &quot;py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50&quot;,
                                                                    &quot;optionTemplate&quot;: &quot;<div class=\&quot;flex justify-between items-center w-full\&quot;><span data-title></span><span class=\&quot;hidden hs-selected:block\&quot;><svg class=\&quot;shrink-0 size-3.5 text-blue-600 \&quot; xmlns=\&quot;http:.w3.org/2000/svg\&quot; width=\&quot;24\&quot; height=\&quot;24\&quot; viewBox=\&quot;0 0 24 24\&quot; fill=\&quot;none\&quot; stroke=\&quot;currentColor\&quot; stroke-width=\&quot;2\&quot; stroke-linecap=\&quot;round\&quot; stroke-linejoin=\&quot;round\&quot;><polyline points=\&quot;20 6 9 17 4 12\&quot;/></svg></span></div>&quot;,
                                                                    &quot;extraMarkup&quot;: &quot;<div class=\&quot;absolute top-1/2 end-3 -translate-y-1/2\&quot;><svg class=\&quot;shrink-0 size-3.5 text-gray-500 \&quot; xmlns=\&quot;http://www.w3.org/2000/svg\&quot; width=\&quot;24\&quot; height=\&quot;24\&quot; viewBox=\&quot;0 0 24 24\&quot; fill=\&quot;none\&quot; stroke=\&quot;currentColor\&quot; stroke-width=\&quot;2\&quot; stroke-linecap=\&quot;round\&quot; stroke-linejoin=\&quot;round\&quot;><path d=\&quot;m7 15 5 5 5-5\&quot;/><path d=\&quot;m7 9 5-5 5 5\&quot;/></svg></div>&quot;
                                                                }"
                                                                name="nationality" style="display: none;">
                                                                @php
                                                                    $countries = collect(listCountries());
                                                                    $countries = $countries->prepend('Nepal', 'NP');
                                                                @endphp
                                                                @foreach ($countries as $countryCode => $countryName)
                                                                    <option value="{{ $countryCode }}">
                                                                        {{ $countryName }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <div class="absolute top-full hidden mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&amp;::-webkit-scrollbar]:w-2 [&amp;::-webkit-scrollbar-thumb]:rounded-full [&amp;::-webkit-scrollbar-track]:bg-gray-100 [&amp;::-webkit-scrollbar-thumb]:bg-gray-300"
                                                                data-hs-select-dropdown="" role="listbox"
                                                                tabindex="-1" aria-orientation="vertical">
                                                                <div class="cursor-pointer selected py-2 px-4 w-full text-sm text-gray-800 hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50"
                                                                    data-value="Nepal" data-title-value="Nepal"
                                                                    tabindex="0">
                                                                    <div
                                                                        class="flex justify-between items-center w-full">
                                                                        <span data-title="">Nepal</span><span
                                                                            class="hidden hs-selected:block"><svg
                                                                                class="shrink-0 size-3.5 text-blue-600 "
                                                                                xmlns="http:.w3.org/2000/svg"
                                                                                width="24" height="24"
                                                                                viewBox="0 0 24 24" fill="none"
                                                                                stroke="currentColor" stroke-width="2"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round">
                                                                                <polyline points="20 6 9 17 4 12">
                                                                                </polyline>
                                                                            </svg></span>
                                                                    </div>
                                                                </div>
                                                                <div class="cursor-pointer py-2 px-4 w-full text-sm text-gray-800 hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50"
                                                                    data-value="India" data-title-value="India"
                                                                    tabindex="1">
                                                                    <div
                                                                        class="flex justify-between items-center w-full">
                                                                        <span data-title="">India</span><span
                                                                            class="hidden hs-selected:block"><svg
                                                                                class="shrink-0 size-3.5 text-blue-600 "
                                                                                xmlns="http:.w3.org/2000/svg"
                                                                                width="24" height="24"
                                                                                viewBox="0 0 24 24" fill="none"
                                                                                stroke="currentColor" stroke-width="2"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round">
                                                                                <polyline points="20 6 9 17 4 12">
                                                                                </polyline>
                                                                            </svg></span>
                                                                    </div>
                                                                </div>
                                                                <div class="cursor-pointer py-2 px-4 w-full text-sm text-gray-800 hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50"
                                                                    data-value="China" data-title-value="China"
                                                                    tabindex="2">
                                                                    <div
                                                                        class="flex justify-between items-center w-full">
                                                                        <span data-title="">China</span><span
                                                                            class="hidden hs-selected:block"><svg
                                                                                class="shrink-0 size-3.5 text-blue-600 "
                                                                                xmlns="http:.w3.org/2000/svg"
                                                                                width="24" height="24"
                                                                                viewBox="0 0 24 24" fill="none"
                                                                                stroke="currentColor" stroke-width="2"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round">
                                                                                <polyline points="20 6 9 17 4 12">
                                                                                </polyline>
                                                                            </svg></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="absolute top-1/2 end-3 -translate-y-1/2"><svg
                                                                    class="shrink-0 size-3.5 text-gray-500 "
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <path d="m7 15 5 5 5-5"></path>
                                                                    <path d="m7 9 5-5 5 5"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- / Nationality Travellers  -->

                                                    <div
                                                        class="py-1 px-2 rounded text-base font-medium mt-6 bg-primary-lighter">
                                                        For 10 Passengers or above kindly send the email
                                                        on
                                                        <span class="text-primary">flights@flights.com</span>
                                                    </div>
                                                </div>
                                                <!-- / No of Travellers Select  -->
                                            </div>
                                        </div>
                                        <!-- / Travellers Count  -->
                                    </div>
                                </div>
                                <div class="r-class">
                                    <div
                                        class="border border-primary px-2 py-3 rounded-lg flex flex-col items-start justify-center">
                                        <p class="text-xs text-gray-400 font-medium capitalize">
                                            Class
                                        </p>

                                        <div class="w-full">
                                            <div class="hs-select relative">
                                                <select class="hidden"
                                                    data-hs-select="{
                                                    &quot;toggleTag&quot;: &quot;<button type=\&quot;button\&quot; aria-expanded=\&quot;false\&quot;></button>&quot;,
                                                    &quot;toggleClasses&quot;: &quot;hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-1 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white rounded-lg text-start text-sm text-black font-semibold&quot;,
                                                    &quot;dropdownClasses&quot;: &quot;mt-2 z-50 w-full max-h-72 p-1 rounded-lg overflow-hidden overflow-y-auto bg-white m-w-fit&quot;,
                                                    &quot;optionClasses&quot;: &quot;py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg m-w-fit text-sm text-black font-semibold&quot;,
                                                    &quot;optionTemplate&quot;: &quot;<div class=\&quot;flex justify-between items-center w-full m-w-fit\&quot;><span data-title></span><span class=\&quot;hidden hs-selected:block\&quot;><svg class=\&quot;shrink-0 size-3.5 text-blue-600 \&quot; xmlns=\&quot;http:.w3.org/2000/svg\&quot; width=\&quot;24\&quot; height=\&quot;24\&quot; viewBox=\&quot;0 0 24 24\&quot; fill=\&quot;none\&quot; stroke=\&quot;currentColor\&quot; stroke-width=\&quot;2\&quot; stroke-linecap=\&quot;round\&quot; stroke-linejoin=\&quot;round\&quot;><polyline points=\&quot;20 6 9 17 4 12\&quot;/></svg></span></div>&quot;,
                                                    &quot;extraMarkup&quot;: &quot;<div class=\&quot;absolute top-1/2 end-3 -translate-y-1/2\&quot;><svg class=\&quot;shrink-0 size-3.5 text-gray-500 \&quot; xmlns=\&quot;http://www.w3.org/2000/svg\&quot; width=\&quot;24\&quot; height=\&quot;24\&quot; viewBox=\&quot;0 0 24 24\&quot; fill=\&quot;none\&quot; stroke=\&quot;currentColor\&quot; stroke-width=\&quot;2\&quot; stroke-linecap=\&quot;round\&quot; stroke-linejoin=\&quot;round\&quot;><path d=\&quot;m7 15 5 5 5-5\&quot;/><path d=\&quot;m7 9 5-5 5 5\&quot;/></svg></div>&quot;
                                                    }"
                                                    name="class" style="display: none;">
                                                    <option value="Economy">Economy</option>
                                                    <option value="First Class">First Class</option>
                                                    <option value="Business">Business</option>
                                                </select>
                                                <div class="absolute top-full hidden mt-2 z-50 w-full max-h-72 p-1 rounded-lg overflow-hidden overflow-y-auto bg-white m-w-fit"
                                                    data-hs-select-dropdown="" role="listbox" tabindex="-1"
                                                    aria-orientation="vertical">
                                                    <div class="cursor-pointer selected py-2 px-4 w-full text-sm text-gray-800 hover:bg-gray-100 rounded-lg m-w-fit text-black font-semibold"
                                                        data-value="Economy" data-title-value="Economy"
                                                        tabindex="0">
                                                        <div class="flex justify-between items-center w-full m-w-fit">
                                                            <span data-title="">Economy</span><span
                                                                class="hidden hs-selected:block"><svg
                                                                    class="shrink-0 size-3.5 text-blue-600 "
                                                                    xmlns="http:.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                                </svg></span>
                                                        </div>
                                                    </div>
                                                    <div class="cursor-pointer py-2 px-4 w-full text-sm text-gray-800 hover:bg-gray-100 rounded-lg m-w-fit text-black font-semibold"
                                                        data-value="Premium Economy"
                                                        data-title-value="Premium Economy" tabindex="1">
                                                        <div class="flex justify-between items-center w-full m-w-fit">
                                                            <span data-title="">Premium Economy</span><span
                                                                class="hidden hs-selected:block"><svg
                                                                    class="shrink-0 size-3.5 text-blue-600 "
                                                                    xmlns="http:.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                                </svg></span>
                                                        </div>
                                                    </div>
                                                    <div class="cursor-pointer py-2 px-4 w-full text-sm text-gray-800 hover:bg-gray-100 rounded-lg m-w-fit text-black font-semibold"
                                                        data-value="Business" data-title-value="Business"
                                                        tabindex="2">
                                                        <div class="flex justify-between items-center w-full m-w-fit">
                                                            <span data-title="">Business</span><span
                                                                class="hidden hs-selected:block"><svg
                                                                    class="shrink-0 size-3.5 text-blue-600 "
                                                                    xmlns="http:.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                                </svg></span>
                                                        </div>
                                                    </div>
                                                    <div class="cursor-pointer py-2 px-4 w-full text-sm text-gray-800 hover:bg-gray-100 rounded-lg m-w-fit text-black font-semibold"
                                                        data-value="First Class" data-title-value="First Class"
                                                        tabindex="3">
                                                        <div class="flex justify-between items-center w-full m-w-fit">
                                                            <span data-title="">First Class</span><span
                                                                class="hidden hs-selected:block"><svg
                                                                    class="shrink-0 size-3.5 text-blue-600 "
                                                                    xmlns="http:.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                                </svg></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="absolute top-1/2 end-3 -translate-y-1/2"><svg
                                                        class="shrink-0 size-3.5 text-gray-500 "
                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="m7 15 5 5 5-5"></path>
                                                        <path d="m7 9 5-5 5 5"></path>
                                                    </svg></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="r-search col-span-2">
                                    <button class="bg-primary w-full py-3 text-white rounded-3xl">
                                        SEARCH
                                    </button>
                                </div> --}}
                            </div>
                            <!-- / One / Two Way  -->

                            <!-- Main From To Search  -->
                            <div class="international-from-to-search" style="display: none;">
                                <div class="absolute top-0 left-0 w-full h-auto bg-white z-30 ">
                                    <div class="fixed top-0 bg-primary px-4 py-3 w-full">
                                        <div class="flex gap-2 w-full items-start">
                                            <div class="p-2 close-international-search cursor-pointer"><i
                                                    class="fa-solid fa-chevron-left text-white text-xl"></i></div>
                                            <div class="flex flex-col gap-2 flex-grow">
                                                <div class="relative">
                                                    <input
                                                        class="r-from-input intSearchInputMobile peer py-3 px-4 ps-11 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                        data-direction="from" type="text"
                                                        placeholder="Search Airports, Cities">
                                                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4 peer-disabled:opacity-50 peer-disabled:pointer-events-none"
                                                        style="height: 44px;">
                                                        <svg width="24px" height="24px" viewBox="0 0 24 24"
                                                            version="1.1" xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                                            fill="#000000">
                                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                                stroke-linejoin="round"></g>
                                                            <g id="SVGRepo_iconCarrier">
                                                                <title>flight_takeoff_line</title>
                                                                <g id="页面-1" stroke="none" stroke-width="1"
                                                                    fill="none" fill-rule="evenodd">
                                                                    <g id="Transport"
                                                                        transform="translate(-624.000000, 0.000000)">
                                                                        <g id="flight_takeoff_line"
                                                                            transform="translate(624.000000, 0.000000)">
                                                                            <path id="MingCute"
                                                                                d="M24,0 L24,24 L0,24 L0,0 L24,0 Z M12.5934901,23.257841 L12.5819402,23.2595131 L12.5108777,23.2950439 L12.4918791,23.2987469 L12.4918791,23.2987469 L12.4767152,23.2950439 L12.4056548,23.2595131 C12.3958229,23.2563662 12.3870493,23.2590235 12.3821421,23.2649074 L12.3780323,23.275831 L12.360941,23.7031097 L12.3658947,23.7234994 L12.3769048,23.7357139 L12.4804777,23.8096931 L12.4953491,23.8136134 L12.4953491,23.8136134 L12.5071152,23.8096931 L12.6106902,23.7357139 L12.6232938,23.7196733 L12.6232938,23.7196733 L12.6266527,23.7031097 L12.609561,23.275831 C12.6075724,23.2657013 12.6010112,23.2592993 12.5934901,23.257841 L12.5934901,23.257841 Z M12.8583906,23.1452862 L12.8445485,23.1473072 L12.6598443,23.2396597 L12.6498822,23.2499052 L12.6498822,23.2499052 L12.6471943,23.2611114 L12.6650943,23.6906389 L12.6699349,23.7034178 L12.6699349,23.7034178 L12.678386,23.7104931 L12.8793402,23.8032389 C12.8914285,23.8068999 12.9022333,23.8029875 12.9078286,23.7952264 L12.9118235,23.7811639 L12.8776777,23.1665331 C12.8752882,23.1545897 12.8674102,23.1470016 12.8583906,23.1452862 L12.8583906,23.1452862 Z M12.1430473,23.1473072 C12.1332178,23.1423925 12.1221763,23.1452606 12.1156365,23.1525954 L12.1099173,23.1665331 L12.0757714,23.7811639 C12.0751323,23.7926639 12.0828099,23.8018602 12.0926481,23.8045676 L12.108256,23.8032389 L12.3092106,23.7104931 L12.3186497,23.7024347 L12.3186497,23.7024347 L12.3225043,23.6906389 L12.340401,23.2611114 L12.337245,23.2485176 L12.337245,23.2485176 L12.3277531,23.2396597 L12.1430473,23.1473072 Z"
                                                                                fill-rule="nonzero">
                                                                            </path>
                                                                            <path id="形状"
                                                                                d="M20.9999,20 C21.5522,20 21.9999,20.4477 21.9999,21 C21.9999,21.51285 21.613873,21.9355092 21.1165239,21.9932725 L20.9999,22 L2.99988,22 C2.44759,22 1.99988,21.5523 1.99988,21 C1.99988,20.48715 2.38591566,20.0644908 2.8832579,20.0067275 L2.99988,20 L20.9999,20 Z M7.26152,3.77234 C7.60270875,3.68092 7.96415594,3.73859781 8.25798121,3.92633426 L8.37951,4.0147 L14.564,9.10597 L18.3962,8.41394 C19.7562,8.16834 21.1459,8.64954 22.0628,9.68357 C22.5196,10.1987 22.7144,10.8812 22.4884,11.5492 C22.1394625,12.580825 21.3287477,13.3849891 20.3041894,13.729249 L20.0965,13.7919 L5.02028,17.8315 C4.629257,17.93626 4.216283,17.817298 3.94116938,17.5298722 L3.85479,17.4279 L0.678249,13.1819 C0.275408529,12.6434529 0.504260903,11.8823125 1.10803202,11.640394 L1.22557,11.6013 L3.49688,10.9927 C3.85572444,10.8966111 4.23617877,10.9655 4.53678409,11.1757683 L4.64557,11.2612 L5.44206,11.9612 L7.83692,11.0255 L3.97034,6.11174 C3.54687,5.57357667 3.77335565,4.79203787 4.38986791,4.54876405 L4.50266,4.51158 L7.26152,3.77234 Z M7.40635,5.80409 L6.47052,6.05484 L10.2339,10.8375 C10.6268063,11.3368125 10.463277,12.0589277 9.92111759,12.3504338 L9.80769,12.4028 L5.60866,14.0433 C5.29604667,14.1654333 4.9460763,14.123537 4.67296914,13.9376276 L4.57438,13.8612 L3.6268,13.0285 L3.15564,13.1547 L5.09121,15.7419 L19.5789,11.86 C20.0227,11.7411 20.3838,11.4227 20.5587,11.0018 C20.142625,10.53815 19.5333701,10.3022153 18.9191086,10.3592364 L18.7516,10.3821 L14.4682,11.1556 C14.218,11.2007714 13.9615551,11.149698 13.7491184,11.0154781 L13.6468,10.9415 L7.40635,5.80409 Z"
                                                                                fill="#00a652">
                                                                            </path>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="relative">
                                                    <input
                                                        class="r-to-input destination-typeahead intSearchInputMobile peer py-3 px-4 ps-11 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                                        data-direction="to" type="text"
                                                        placeholder="Search Airports, Cities">
                                                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4 peer-disabled:opacity-50 peer-disabled:pointer-events-none"
                                                        style="height: 44px;">
                                                        <svg width="24px" height="24px" viewBox="0 0 24 24"
                                                            version="1.1" xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                                            fill="#000000">
                                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                                stroke-linejoin="round"></g>
                                                            <g id="SVGRepo_iconCarrier">
                                                                <title>flight_land_line</title>
                                                                <g id="页面-1" stroke="none" stroke-width="1"
                                                                    fill="none" fill-rule="evenodd">
                                                                    <g id="Transport"
                                                                        transform="translate(-576.000000, 0.000000)">
                                                                        <g id="flight_land_line"
                                                                            transform="translate(576.000000, 0.000000)">
                                                                            <path id="MingCute"
                                                                                d="M24,0 L24,24 L0,24 L0,0 L24,0 Z M12.5934901,23.257841 L12.5819402,23.2595131 L12.5108777,23.2950439 L12.4918791,23.2987469 L12.4918791,23.2987469 L12.4767152,23.2950439 L12.4056548,23.2595131 C12.3958229,23.2563662 12.3870493,23.2590235 12.3821421,23.2649074 L12.3780323,23.275831 L12.360941,23.7031097 L12.3658947,23.7234994 L12.3769048,23.7357139 L12.4804777,23.8096931 L12.4953491,23.8136134 L12.4953491,23.8136134 L12.5071152,23.8096931 L12.6106902,23.7357139 L12.6232938,23.7196733 L12.6232938,23.7196733 L12.6266527,23.7031097 L12.609561,23.275831 C12.6075724,23.2657013 12.6010112,23.2592993 12.5934901,23.257841 L12.5934901,23.257841 Z M12.8583906,23.1452862 L12.8445485,23.1473072 L12.6598443,23.2396597 L12.6498822,23.2499052 L12.6498822,23.2499052 L12.6471943,23.2611114 L12.6650943,23.6906389 L12.6699349,23.7034178 L12.6699349,23.7034178 L12.678386,23.7104931 L12.8793402,23.8032389 C12.8914285,23.8068999 12.9022333,23.8029875 12.9078286,23.7952264 L12.9118235,23.7811639 L12.8776777,23.1665331 C12.8752882,23.1545897 12.8674102,23.1470016 12.8583906,23.1452862 L12.8583906,23.1452862 Z M12.1430473,23.1473072 C12.1332178,23.1423925 12.1221763,23.1452606 12.1156365,23.1525954 L12.1099173,23.1665331 L12.0757714,23.7811639 C12.0751323,23.7926639 12.0828099,23.8018602 12.0926481,23.8045676 L12.108256,23.8032389 L12.3092106,23.7104931 L12.3186497,23.7024347 L12.3186497,23.7024347 L12.3225043,23.6906389 L12.340401,23.2611114 L12.337245,23.2485176 L12.337245,23.2485176 L12.3277531,23.2396597 L12.1430473,23.1473072 Z"
                                                                                fill-rule="nonzero">
                                                                            </path>
                                                                            <path id="形状"
                                                                                d="M20.99989,20.0001 C21.5522,20.0001 21.99989,20.4478 21.99989,21.0001 C21.99989,21.51295 21.6138716,21.9356092 21.1165158,21.9933725 L20.99989,22.0001 L2.99989,22.0001 C2.4476,22.0001 1.99989,21.5524 1.99989,21.0001 C1.99989,20.48725 2.38592566,20.0645908 2.8832679,20.0068275 L2.99989,20.0001 L20.99989,20.0001 Z M8.10346,3.20538 C8.00550211,2.52548211 8.59636283,1.96050997 9.25436746,2.06249271 L9.36455,2.08576 L12.1234,2.82499 C12.4699778,2.91787 12.7577704,3.15444975 12.9168957,3.47137892 L12.9704,3.59387 L15.7807,11.0953 L19.4455,12.4121 C20.7461,12.8794 21.709,13.991 21.9861,15.3449 C22.1241,16.0194 21.9516,16.7079 21.4218,17.1734 C20.6038313,17.8923687 19.4996906,18.183398 18.4402863,17.9692815 L18.2291,17.9197 L3.15287,13.8799 C2.75789727,13.7740818 2.45767661,13.459338 2.36633273,13.0674492 L2.34531,12.9477 L1.71732,7.68232 C1.63740111,7.01225556 2.22049639,6.4660062 2.86699575,6.56318572 L2.98162,6.58712 L5.25293,7.19571 C5.61177444,7.29186111 5.90680062,7.54177815 6.06199513,7.87418144 L6.11349,8.00256 L6.45329,9.00701 L8.99512,9.39414 L8.10346,3.20538 Z M10.2971,4.4062 L11.165,10.4298 C11.2559176,11.0610471 10.7489114,11.6064588 10.1303657,11.5834026 L10.0132,11.5723 L5.5565,10.8935 C5.22469556,10.8429222 4.94258198,10.6316333 4.79900425,10.3341508 L4.75183,10.2187 L4.34758,9.02368 L3.87642,8.89743 L4.25907,12.1058 L18.7467,15.9878 C19.1906,16.1067 19.6625,16.0115 20.0243,15.7345 C19.8949769,15.1206538 19.4803805,14.6088858 18.9139056,14.3528832 L18.7692,14.2943 L14.673,12.8225 C14.4336857,12.7364429 14.2371306,12.5639857 14.1203003,12.3415274 L14.0687,12.2263 L11.233,4.65695 L10.2971,4.4062 Z"
                                                                                fill="#00a652">
                                                                            </path>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-[123px] overflow-x-hidden overflow-y-auto h-full w-full">
                                        <div class="px-5 py-3 h-full">
                                            <h6 class="text-sm font-normal">POPULAR CITIES</h6>
                                            <div class="flex flex-col gap-2 mt-2 popular-city-suggestion">
                                                <div class="flight-search-suggestion">
                                                    <div>
                                                        <h5 class="text-sm font-semibold">New Delhi</h5>
                                                        <p class="text-xs font-normal">Indira Gandhi International
                                                            Airport</p>
                                                    </div>
                                                    <div class="bg-secondary px-3 py-1 text-white rounded-sm">DEL
                                                    </div>
                                                </div>
                                                <div class="flight-search-suggestion">
                                                    <div>
                                                        <h5 class="text-sm font-semibold">New Delhi</h5>
                                                        <p class="text-xs font-normal">Indira Gandhi International
                                                            Airport</p>
                                                    </div>
                                                    <div class="bg-secondary px-3 py-1 text-white rounded-sm">DEL
                                                    </div>
                                                </div>
                                                <div class="flight-search-suggestion">
                                                    <div>
                                                        <h5 class="text-sm font-semibold">New Delhi</h5>
                                                        <p class="text-xs font-normal">Indira Gandhi International
                                                            Airport</p>
                                                    </div>
                                                    <div class="bg-secondary px-3 py-1 text-white rounded-sm">DEL
                                                    </div>
                                                </div>
                                                <div class="flight-search-suggestion">
                                                    <div>
                                                        <h5 class="text-sm font-semibold">New Delhi</h5>
                                                        <p class="text-xs font-normal">Indira Gandhi International
                                                            Airport</p>
                                                    </div>
                                                    <div class="bg-secondary px-3 py-1 text-white rounded-sm">DEL
                                                    </div>
                                                </div>
                                                <div class="flight-search-suggestion">
                                                    <div>
                                                        <h5 class="text-sm font-semibold">New Delhi</h5>
                                                        <p class="text-xs font-normal">Indira Gandhi International
                                                            Airport</p>
                                                    </div>
                                                    <div class="bg-secondary px-3 py-1 text-white rounded-sm">DEL
                                                    </div>
                                                </div>
                                                <div class="flight-search-suggestion">
                                                    <div>
                                                        <h5 class="text-sm font-semibold">New Delhi</h5>
                                                        <p class="text-xs font-normal">Indira Gandhi International
                                                            Airport</p>
                                                    </div>
                                                    <div class="bg-secondary px-3 py-1 text-white rounded-sm">DEL
                                                    </div>
                                                </div>
                                                <div class="flight-search-suggestion">
                                                    <div>
                                                        <h5 class="text-sm font-semibold">New Delhi</h5>
                                                        <p class="text-xs font-normal">Indira Gandhi International
                                                            Airport</p>
                                                    </div>
                                                    <div class="bg-secondary px-3 py-1 text-white rounded-sm">DEL
                                                    </div>
                                                </div>
                                                <div class="flight-search-suggestion">
                                                    <div>
                                                        <h5 class="text-sm font-semibold">New Delhi</h5>
                                                        <p class="text-xs font-normal">Indira Gandhi International
                                                            Airport</p>
                                                    </div>
                                                    <div class="bg-secondary px-3 py-1 text-white rounded-sm">DEL
                                                    </div>
                                                </div>
                                                <div class="flight-search-suggestion">
                                                    <div>
                                                        <h5 class="text-sm font-semibold">New Delhi</h5>
                                                        <p class="text-xs font-normal">Indira Gandhi International
                                                            Airport</p>
                                                    </div>
                                                    <div class="bg-secondary px-3 py-1 text-white rounded-sm">DEL
                                                    </div>
                                                </div>
                                                <div class="flight-search-suggestion">
                                                    <div>
                                                        <h5 class="text-sm font-semibold">New Delhi</h5>
                                                        <p class="text-xs font-normal">Indira Gandhi International
                                                            Airport</p>
                                                    </div>
                                                    <div class="bg-secondary px-3 py-1 text-white rounded-sm">DEL
                                                    </div>
                                                </div>
                                                <div class="flight-search-suggestion">
                                                    <div>
                                                        <h5 class="text-sm font-semibold">New Delhi</h5>
                                                        <p class="text-xs font-normal">Indira Gandhi International
                                                            Airport</p>
                                                    </div>
                                                    <div class="bg-secondary px-3 py-1 text-white rounded-sm">DEL
                                                    </div>
                                                </div>
                                                <div class="flight-search-suggestion">
                                                    <div>
                                                        <h5 class="text-sm font-semibold">New Delhi</h5>
                                                        <p class="text-xs font-normal">Indira Gandhi International
                                                            Airport</p>
                                                    </div>
                                                    <div class="bg-secondary px-3 py-1 text-white rounded-sm">DEL
                                                    </div>
                                                </div>
                                                <div class="flight-search-suggestion">
                                                    <div>
                                                        <h5 class="text-sm font-semibold">New Delhi</h5>
                                                        <p class="text-xs font-normal">Indira Gandhi International
                                                            Airport</p>
                                                    </div>
                                                    <div class="bg-secondary px-3 py-1 text-white rounded-sm">DEL
                                                    </div>
                                                </div>
                                                <div class="flight-search-suggestion">
                                                    <div>
                                                        <h5 class="text-sm font-semibold">New Delhi</h5>
                                                        <p class="text-xs font-normal">Indira Gandhi International
                                                            Airport</p>
                                                    </div>
                                                    <div class="bg-secondary px-3 py-1 text-white rounded-sm">DEL
                                                    </div>
                                                </div>
                                                <div class="flight-search-suggestion">
                                                    <div>
                                                        <h5 class="text-sm font-semibold">New Delhi</h5>
                                                        <p class="text-xs font-normal">Indira Gandhi International
                                                            Airport</p>
                                                    </div>
                                                    <div class="bg-secondary px-3 py-1 text-white rounded-sm">DEL
                                                    </div>
                                                </div>
                                                <div class="flight-search-suggestion">
                                                    <div>
                                                        <h5 class="text-sm font-semibold">New Delhi</h5>
                                                        <p class="text-xs font-normal">Indira Gandhi International
                                                            Airport</p>
                                                    </div>
                                                    <div class="bg-secondary px-3 py-1 text-white rounded-sm">DEL
                                                    </div>
                                                </div>
                                                <div class="flight-search-suggestion">
                                                    <div>
                                                        <h5 class="text-sm font-semibold">New Delhi</h5>
                                                        <p class="text-xs font-normal">Indira Gandhi International
                                                            Airport</p>
                                                    </div>
                                                    <div class="bg-secondary px-3 py-1 text-white rounded-sm">DEL
                                                    </div>
                                                </div>
                                                <div class="flight-search-suggestion">
                                                    <div>
                                                        <h5 class="text-sm font-semibold">New Delhi</h5>
                                                        <p class="text-xs font-normal">Indira Gandhi International
                                                            Airport</p>
                                                    </div>
                                                    <div class="bg-secondary px-3 py-1 text-white rounded-sm">DEL
                                                    </div>
                                                </div>
                                                <div class="flight-search-suggestion">
                                                    <div>
                                                        <h5 class="text-sm font-semibold">New Delhi</h5>
                                                        <p class="text-xs font-normal">Indira Gandhi International
                                                            Airport</p>
                                                    </div>
                                                    <div class="bg-secondary px-3 py-1 text-white rounded-sm">DEL
                                                    </div>
                                                </div>
                                                <div class="flight-search-suggestion">
                                                    <div>
                                                        <h5 class="text-sm font-semibold">New Delhi</h5>
                                                        <p class="text-xs font-normal">Indira Gandhi International
                                                            Airport</p>
                                                    </div>
                                                    <div class="bg-secondary px-3 py-1 text-white rounded-sm">DEL
                                                    </div>
                                                </div>
                                                <div class="flight-search-suggestion">
                                                    <div>
                                                        <h5 class="text-sm font-semibold">New Delhi</h5>
                                                        <p class="text-xs font-normal">Indira Gandhi International
                                                            Airport</p>
                                                    </div>
                                                    <div class="bg-secondary px-3 py-1 text-white rounded-sm">DEL
                                                    </div>
                                                </div>
                                                <div class="flight-search-suggestion">
                                                    <div>
                                                        <h5 class="text-sm font-semibold">New Delhi</h5>
                                                        <p class="text-xs font-normal">Indira Gandhi International
                                                            Airport</p>
                                                    </div>
                                                    <div class="bg-secondary px-3 py-1 text-white rounded-sm">DEL
                                                    </div>
                                                </div>
                                                <div class="flight-search-suggestion">
                                                    <div>
                                                        <h5 class="text-sm font-semibold">New Delhi</h5>
                                                        <p class="text-xs font-normal">Indira Gandhi International
                                                            Airport</p>
                                                    </div>
                                                    <div class="bg-secondary px-3 py-1 text-white rounded-sm">DEL
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="fixed w-full h-full bg-white top-0 z-20 left-0"></div>
                            </div>
                            <!-- / Main From To Search  -->

                            <!-- Multi City  -->
                            <div class="r-multicity row-container gap-2" style="display: none">
                                @for ($i = 0; $i <= 4; $i++)
                                    @include('front.includes.homepage.flight-search-input-mobile', [
                                        'iteration' => $i,
                                    ])
                                @endfor

                                <!-- Add Remove Buttons  -->
                                <button
                                    class="addbtn border uppercase text-xs rounded-lg p-2 mt-2 text-primary font-medium border-primary"
                                    style="display: inline-block" type="button" onclick="addRow()">
                                    Add city
                                </button>
                                <button
                                    class="removebtn border uppercase text-xs rounded-lg p-2 mt-2 font-medium border-gray-400 text-gray-400"
                                    style="display: none" type="button" onclick="removeRow()">
                                    Remove
                                </button>
                                <!-- / Add Remove Buttons  -->
                            </div>
                            <!-- / Multi City  -->

                            @include('front.includes.homepage.search-offcanvas')

                            <div class="r-search col-span-2 mt-4 primary-intl-search">
                                <button class="bg-primary w-full py-3 text-white rounded-3xl">
                                    SEARCH
                                </button>
                            </div>
                        </div>
                        <!-- / International Tab  -->
                    </form>

                    <!-- Domestic Tab  -->
                    @include('front.domestic.mobile.search')

                    <!-- / Domestic Tab  -->
                </div>
            </div>
        </div>
    </div>
</div>

@if (getSiteSettings()->homepage_mobile_ad ?? '')
    <div class="block md:hidden">
        <div class="w-full h-[130px]">
            <img class="w-full h-full object-cover"
                src="{{ asset('uploads/site/' . getSiteSettings()->homepage_mobile_ad) }}" alt="">
        </div>
    </div>
@endif

<!-- / Search Box  -->
{{-- ./New Design --}}

<script>
    function searchAirport(filter, direction, multiInputIndex) {
        const popularCity = $('.popular-city-suggestion');

        $.get("/flight/autocomplete/airport", {
            term: filter
        }, function(data) {
            popularCity.empty(); // Clear the existing list
            data.forEach(function(item) {
                var listItem = $('<div></div>')
                    .attr('data-airport', item.airport)
                    .attr('data-city', item.city)
                    .attr('data-city-full', item.city_full)
                    .attr('data-direction', direction)
                    .attr('data-multi-input-index', multiInputIndex)
                    .addClass(
                        'intl-search-result-click flight-search-suggestion'
                    )
                    .html(`
                       <div>
                            <h5 class="text-sm font-semibold">
                                ${item.city}
                            </h5>
                            <p class="text-xs font-normal">
                            ${item.airport}
                            </p>
                        </div>
                        <div class="bg-secondary px-3 py-1 text-white rounded-sm">
                            ${item.city}
                        </div>

                    `);
                popularCity.append(listItem);
            });
        });
    }

    $('.intSearchInputMobile').on('keyup', function() {
        var filter = $(this).val();
        var inputElement = $(this);

        const direction = inputElement.data('direction');
        const multiInputIndex = inputElement.data('multi-input-index');

        searchAirport(filter, direction, multiInputIndex);
    });

    $('.intSearchInputMobile').on('focus', function() {
        $(".popular-city-suggestion").text("Loading...");
        const data = $(this).data("direction");
        const multiInputIndex = $(this).data('multi-input-index');

        searchAirport('', data, multiInputIndex);
    })


    $(document).on('click', '.intl-search-result-click', function(e) {
        const multiInputIndex = $(this).data("multi-input-index");
        var airport = $(this).attr('data-airport');
        var city = $(this).attr('data-city');
        var cityFull = $(this).attr('data-city-full');
        const direction = $(this).data('direction')


        if (multiInputIndex) {
            switch (direction) {
                case "from":
                    const fromInput = $('[name="int_multi_from[]"]').eq(multiInputIndex);
                    fromInput.siblings(".multi-depairport").text(airport);
                    fromInput.val(airport);
                    break;

                case "to":
                    const toInput = $('[name="int_multi_to[]"]').eq(multiInputIndex);
                    toInput.siblings(".multi-arrairport").text(airport);
                    toInput.val(airport);
                    break;
            }

            $(".multi-search-offcanvas").css({
                display: 'none'
            });
        } else {
            if (direction === "from") {
                const depCity = $('[name="depcity"]');
                const depAirport = $('[name="departure"]');
                $('[name="depcityfull"]').val(cityFull);


                $(".d-depcity").html(city);
                $(".d-depairport").html(airport);
                $(".r-depcityfull").html(cityFull);

                depCity.val(city);
                depAirport.val(airport);
            } else if (direction === "to") {
                const arrCity = $('[name="destinationcity"]');
                const arrAirport = $('[name="destination"]');
                $('[name="arrcityfull"]').val(cityFull);

                $(".d-arrcity").html(city);
                $(".d-arrairport").html(airport);
                $(".r-arrcityfull").html(cityFull);

                arrCity.val(city);
                arrAirport.val(airport);
            }
        }





        $(".international-from-to-search").css({
            display: 'none'
        });
    });


    $('.searchInput').on('keyup', function() {
        var filter = $(this).val().toUpperCase();
        var dropdown = $(this).closest('.hs-dropdown-menu').find('#dropdownList');
        var items = dropdown.find('a');

        items.each(function() {
            var txtValue = $(this).text();
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    $(document).on('click', '.sector_click', function(e) {
        e.preventDefault();
        let scode = $(this).attr('sectorCode');
        let sname = $(this).attr('sectorName');
        $('.depairport-domestic-value').val(scode);
        $('.d-domestic-dvalue').text(sname);
        $('.d-domestic-dvaluecode').text(scode);

        $('.hs-dropdown').removeClass("open");
        $('.hs-dropdown-menu').removeClass("block").addClass('hidden');

    })

    $(document).on('click', '.sector2_click', function(e) {
        e.preventDefault();
        let scode = $(this).attr('sectorCode');
        let sname = $(this).attr('sectorName');
        $('.arrairport-domestic-value').val(scode);
        $('.d-domestic-arrcity').text(sname);
        $('.d-domestic-arrairport').text(scode);

        $('.hs-dropdown').removeClass("open");
        $('.hs-dropdown-menu').removeClass("block").addClass('hidden');
    })

    $(document).on('click', '.domestic-swipesector', function(e) {
        var a = $('.depairport-domestic-value').val();
        var b = $('.d-domestic-dvalue:first').text();
        var c = $('.d-domestic-dvaluecode:first').text();


        var d = $('.arrairport-domestic-value').val();
        var e = $('.d-domestic-arrcity:first').text();
        var f = $('.d-domestic-arrairport:first').text();

        $('.arrairport-domestic-value').val(a);
        $('.d-domestic-arrcity:first').text(b);
        $('.d-domestic-arrairport:first').text(c);

        $('.depairport-domestic-value').val(d);
        $('.d-domestic-dvalue:first').text(e);
        $('.d-domestic-dvaluecode:first').text(f);
    })

    $(document).on('click', '.domestic-r-swipesector', function(e) {
        var a = $('.depairport-domestic-value').val();
        var b = $('.d-domestic-dvalue:last').text();
        var c = $('.d-domestic-dvaluecode:last').text();


        var d = $('.arrairport-domestic-value').val();
        var e = $('.d-domestic-arrcity:last').text();
        var f = $('.d-domestic-arrairport:last').text();

        $('.arrairport-domestic-value').val(a);
        $('.d-domestic-arrcity:last').text(b);
        $('.d-domestic-arrairport:last').text(c);

        $('.depairport-domestic-value').val(d);
        $('.d-domestic-dvalue:last').text(e);
        $('.d-domestic-dvaluecode:last').text(f);
    })


    $('.primary-intl-search').on('click', function() {
        $('#main_content').hide();
        $('#loader_screen').show();

        $('#view_dep').text($('[name="depcity"]').val());
        $('#view_arr').text($('[name="destinationcity"]').val());

        const date = $('[name="flightdate"]').val();


        const formattedDate = (new Date(date)).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        })


        $('#view_depdate').text(formattedDate);
    })




    // MultiCity Container Functions
    function getMultiDisplayedRowCount() {
        let rows = document.querySelectorAll(".multi-container > div");
        let count = 0;
        rows.forEach((row) => {
            if (row.style.display !== "none") {
                count++;
            }
        });
        return count;
    }

    function addMultiRow() {
        let rows = document.querySelectorAll(".multi-container > div");
        for (let i = 0; i < rows.length; i++) {
            if (rows[i].style.display === "none") {
                rows[i].style.display = "flex";
                toggleMultiButtons();
                return;
            }
        }
    }


    function toggleMultiButtons() {
        let displayedRowCount = getMultiDisplayedRowCount();
        let addBtn = document.querySelector(".addmultibtn");
        let removeBtn = document.querySelector(".removemultibtn");

        if (displayedRowCount > 1) {
            removeBtn.style.display = "flex";
        } else {
            removeBtn.style.display = "none";
        }

        if (displayedRowCount === 4) {
            addBtn.style.display = "none";
        } else {
            addBtn.style.display = "flex";
        }
    }


    function removeMultiRow() {

        let rows = document.querySelectorAll(".multi-container > div");
        for (let i = rows.length - 1; i >= 0; i--) {
            if (rows[i].style.display !== "none") {
                rows[i].style.display = "none";
                toggleMultiButtons();
                return;
            }
        }
    }


    var inputClick = 'dep';

    $('.r-from-domestic').click(function() {
        inputClick = 'dep';
        $('.searchInput_mobile').val('');
        $('.searchInput_mobile').focus();
        $('.searchInput2_mobile').val($('#arrairport-domestic-value').val());
        $('.sector_click_mobile').show();
    })

    $('.r-to-domestic').click(function() {
        inputClick = 'arr';
        $('.searchInput2_mobile').val('');
        $('.searchInput2_mobile').focus();
        $('.searchInput_mobile').val($('#depairport-domestic-value').val());
        $('.sector_click_mobile').show();
    })

    $('.searchInput_mobile').click(function() {
        inputClick = 'dep';
        $('.searchInput_mobile').val('');
        $('.searchInput_mobile').focus();
        $('.searchInput2_mobile').val($('#arrairport-domestic-value').val());
        $('.sector_click_mobile').show();

    })

    $('.searchInput2_mobile').click(function() {
        inputClick = 'arr';
        $('.searchInput2_mobile').val('');
        $('.searchInput2_mobile').focus();
        $('.searchInput_mobile').val($('#depairport-domestic-value').val());
        $('.sector_click_mobile').show();

    })

    $('.sector_click_mobile').click(function(e) {
        console.log(inputClick);

        e.preventDefault();
        let scode = $(this).attr('sectorCode');
        let sname = $(this).attr('sectorName');

        if (inputClick === 'dep') {
            $('.depairport-domestic-value').val(scode);
            $('.d-domestic-dvalue').text(sname);
            $('.d-domestic-dvaluecode').text(scode);
        } else {
            $('.arrairport-domestic-value').val(scode);
            $('.d-domestic-arrcity').text(sname);
            $('.d-domestic-arrairport').text(scode);
        }

        $('.close-domestic-search').click();

    })

    $('.searchInput_mobile').on('keyup', function() {
        var filter = $(this).val().toUpperCase();
        var dropdown = $(this).closest('.domestic-data-filter').find('#dropdownList');
        var items = dropdown.find('a');

        items.each(function() {
            var nthis = $(this);
            var txtValue = nthis.find('h5').text() + ' ' + $(this).find('p').text();
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                nthis.show();
            } else {
                nthis.hide();
            }
        });
    });

    $('.searchInput2_mobile').on('keyup', function() {
        var filter = $(this).val().toUpperCase();
        var dropdown = $(this).closest('.domestic-data-filter').find('#dropdownList');
        var items = dropdown.find('a');

        items.each(function() {
            var nthis = $(this);
            var txtValue = nthis.find('h5').text() + ' ' + $(this).find('p').text();
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                nthis.show();
            } else {
                nthis.hide();
            }
        });
    });


    for (let i = 0; i < 5; i++) {
        $(`#international-departure-drop-${i}`).on('click', function() {
            $(`#multiCityDepInput${i}`).trigger('focus');
        })
        $(`#international-destination-drop-${i}`).on('click', function() {
            console.log("Destination");
            $(`#multiCityDestInput${i}`).trigger('focus');
        })
    }
</script>
