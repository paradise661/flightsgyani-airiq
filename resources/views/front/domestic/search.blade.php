<form action="{{route('domesticflights.result')}}" method="POST">
    @csrf
    <!-- Domestic Tab  -->
    <div class="hidden" id="domestic-tab" role="tabpanel" aria-labelledby="domestic-item-tab">
        <!-- Domestic Trip Type Dropdown  -->
        <div class="absolute top-4 left-[300px]">
            <div class="relative">
                <select name="type" id="domesticTripType" class="border-0 py-3 text-sm font-medium rounded-md focus:ring-0 bg-none">
                    <option value="one-way">One Way</option>
                    <option value="two-way">Two Way</option>
                </select>

                <div class="absolute top-1/2 end-2.5 -translate-y-1/2">
                    <svg class="shrink-0 size-4 text-gray-500 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m7 15 5 5 5-5"></path>
                        <path d="m7 9 5-5 5 5"></path>
                    </svg>
                </div>
            </div>
        </div>
        <!-- / Domestic Trip Type Dropdown  -->

        <!-- Domestic Search  -->
        <div class="mt-3">
            <div
                class="search-wrap oneTwoWayDomesticLayout w-full flex justify-items-center items-center bg-white rounded-md">
                <div class="depcity_col_domestic flex border-e md:min-w-[245px]">
                    <div class="hs-dropdown relative inline-flex [--auto-close:inside] w-full">
                        <div class="innercol hs-dropdwon-toggle" aria-haspopup="menu" aria-expanded="false"
                            aria-label="Dropdown" id="domestic-departure-drop">
                            <p class="font-semibold text-xs text-gray-400">FROM</p>
                            {{-- <input type="hidden" id="depcity-domestic" value="Kathmandu" />
                        <input type="hidden" id="depairport-domestic" value="[KTM] Tribhuwan International Airport" />
                        <div class="text-2xl font-semibold" id="d-domestic-depcity"></div>
                        <div class="font-medium text-xs" id="d-domestic-depairport"></div> --}}
                            <input type="hidden" class="depairport-domestic-value" id="depairport-domestic-value" name="from" value="KTM" />
                            <div class="text-2xl font-semibold d-domestic-dvalue" id="d-domestic-depcity">Kathmandu</div>
                            <div class="font-medium text-xs" id="d-domestic-depairport">[<span class="d-domestic-dvaluecode">KTM</span>]</div>
                        </div>
                        <div class="px-2 py-3 z-50 hs-dropdown-menu search-d-transform duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-72 bg-white shadow-md rounded-lg mt-2 top-0"
                            role="menu" aria-orientation="vertical" aria-labelledby="domestic-departure-drop">
                            <div class="w-full flex justify-between items-center">
                                <h4>Flying From</h4>
                                <!-- <button
                                class="bg-gray-100 p-3 size-4 rounded-full flex items-center justify-center"
                              >
                                <i class="fa-solid fa-xmark"></i>
                              </button> -->
                            </div>
                            <div class="relative mt-2">
                                <input type="text"
                                    class="searchInput peer py-3 px-4 ps-11 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                    placeholder="Search Airports, Cities" autocomplete="off" />
                                <div
                                    class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4 peer-disabled:opacity-50 peer-disabled:pointer-events-none">
                                    <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path
                                                d="M12 21C15.5 17.4 19 14.1764 19 10.2C19 6.22355 15.866 3 12 3C8.13401 3 5 6.22355 5 10.2C5 14.1764 8.5 17.4 12 21Z"
                                                stroke="#929292" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                            </path>
                                            <path
                                                d="M12 12C13.1046 12 14 11.1046 14 10C14 8.89543 13.1046 8 12 8C10.8954 8 10 8.89543 10 10C10 11.1046 10.8954 12 12 12Z"
                                                stroke="#929292" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                            <div id="dropdownList" class="dropdown-content max-h-64 overflow-y-auto flex flex-col gap-1 mt-2 -me-2">
                                @foreach ($sectors as $sector)
                                <a sectorCode="{{ $sector->code ?? '' }}" sectorName="{{ $sector->name ?? '' }}"
                                    class="sector_click block w-full px-4 py-3 pr-10 border-b   hover:bg-primary-background"
                                    href="javascript:void(0)">{{ $sector->name ?? '' }} <span class="font-semibold">({{ $sector->code ?? '' }})</span> </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="domestic-swipesector swipesector"></div>
                <div class="arrcity_col_domestic flex border-e md:min-w-[245px]">
                    <div class="hs-dropdown relative inline-flex [--auto-close:inside] w-full">
                        <div class="innercol hs-dropdwon-toggle" aria-haspopup="menu" aria-expanded="false"
                            aria-label="Dropdown" id="domestic-departure-drop">
                            <p class="font-semibold text-xs text-gray-400">TO</p>
                            {{-- <input type="hidden" id="arrcity-domestic" value="Delhi" />
                        <input type="hidden" id="arrairport-domestic"
                            value="[DEL] Indira Gandhi International Airport" />
                        <div class="text-2xl font-semibold" id="d-domestic-arrcity"></div>
                        <div class="font-medium text-xs" id="d-domestic-arrairport"></div> --}}
                            <input type="hidden" class="arrairport-domestic-value" id="arrairport-domestic-value" name="to" value="PKR" />
                            <div class="text-2xl font-semibold d-domestic-arrcity" id="d-domestic-arrcity">POKHARA</div>
                            <div class="font-medium text-xs" id="d-domestic-arrairport">[<span class="d-domestic-arrairport">PKR</span>]</div>
                        </div>
                        <div class="px-2 py-3 z-50 hs-dropdown-menu search-t-transform duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-72 bg-white shadow-md rounded-lg mt-2 top-0"
                            role="menu" aria-orientation="vertical" aria-labelledby="domestic-departure-drop">
                            <div class="w-full flex justify-between items-center">
                                <h4>Flying To</h4>
                                <!-- <button
                              class="bg-gray-100 p-3 size-4 rounded-full flex items-center justify-center"
                            >
                              <i class="fa-solid fa-xmark"></i>
                            </button> -->
                            </div>
                            <div class="relative mt-2">
                                <input type="text"
                                    class="searchInput peer py-3 px-4 ps-11 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                    placeholder="Search Airports, Cities" autocomplete="off" />
                                <div
                                    class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4 peer-disabled:opacity-50 peer-disabled:pointer-events-none">
                                    <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path
                                                d="M12 21C15.5 17.4 19 14.1764 19 10.2C19 6.22355 15.866 3 12 3C8.13401 3 5 6.22355 5 10.2C5 14.1764 8.5 17.4 12 21Z"
                                                stroke="#929292" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                            </path>
                                            <path
                                                d="M12 12C13.1046 12 14 11.1046 14 10C14 8.89543 13.1046 8 12 8C10.8954 8 10 8.89543 10 10C10 11.1046 10.8954 12 12 12Z"
                                                stroke="#929292" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                            <div id="dropdownList" class="dropdown-content max-h-64 overflow-y-auto flex flex-col gap-1 mt-2 -me-2">
                                @foreach ($sectors as $sector)
                                <a sectorCode="{{ $sector->code ?? '' }}" sectorName="{{ $sector->name ?? '' }}"
                                    class="sector2_click block w-full px-4 py-3 pr-10 border-b   hover:bg-primary-background"
                                    href="javascript:void(0)">{{ $sector->name ?? '' }} <span class="font-semibold"> ({{ $sector->code ?? '' }})</span></a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex border-e depdate_col">
                    <div class="innercol">
                        <p class="font-semibold text-xs text-gray-400">
                            DEPARTURE DATE
                        </p>

                        <!-- <span class="text-2xl font-semibold">19</span>
                          <span class="text-sm font-medium">Oct'2024</span> -->
                        <div class="flex items-center">
                            <input type="text" id="" value="{{date('m/d/Y')}}" name="flightDate" autocomplete="off"
                                class="dep-date peer px-0 block w-full bg-transparent border-0 text-base text-black font-semibold disabled:opacity-50 disabled:pointer-events-none tracking-wide focus:shadow-none focus:ring-0"
                                placeholder="MM/DD/YYYY" />
                            <img class="w-[17px] h-[17px] float-right mt-[8px]" src="{{asset('images/icons/calendar.svg')}}"
                                alt="" />
                        </div>

                        {{-- <p class="font-medium text-xs">Saturday</p> --}}
                    </div>
                </div>
                <div class="flex border-e depdate_col ret-date-col-domestic" style="opacity: 0.4">
                    <div class="innercol relative">
                        <p class="font-semibold text-xs text-gray-400">
                            RETRUN DATE
                        </p>
                        <div class="flex items-center">
                            <input type="text" id="" name="returnDate" autocomplete="off"
                                class="return-date peer px-0 block w-full bg-transparent border-0 text-base text-black font-semibold disabled:opacity-50 disabled:pointer-events-none tracking-wide focus:shadow-none focus:ring-0"
                                placeholder="MM/DD/YYYY" />
                            <img class="w-[17px] h-[17px] float-right mt-[8px]" src="{{asset('images/icons/calendar.svg')}}"
                                alt="" />
                        </div>
                        {{-- <p class="font-medium text-xs">Saturday</p> --}}
                        <div class="absolute top-1 right-2 bg-gray-100 p-2 size-1 rounded-full flex items-center justify-center"
                            id="domReturnCross">
                            <i class="fa-solid fa-xmark"></i>
                        </div>
                    </div>
                </div>
                <div class="search-col">
                    <div class="innercol">
                        <p class="font-semibold text-xs text-gray-400">
                            TRAVELLER & CLASS
                        </p>
                        <div class="mt-1 py-2 mx-1 sm:mt-1 hs-dropdown [--auto-close:inside] relative sm:inline-flex z-20">
                            <button id="travellers-drop-domestic" type="button"
                                class="hs-dropdown-toggle inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-white text-gray-800 hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
                                aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                                <span id="domestic-passenger-count">1</span> Traveller(s)
                                <svg class="hs-dropdown-open:rotate-180 size-2.5" width="16" height="16"
                                    viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                </svg>
                            </button>

                            <div class="hs-dropdown-menu w-[300px] traveller-drop hs-dropdown-open:opacity-100 opacity-0 hidden bg-white shadow-md rounded-sm mt-2"
                                role="menu" aria-orientation="vertical" aria-labelledby="travellers-drop-domestic">
                                <div class="py-4 px-4 flex flex-col gap-4 bg-white">
                                    <!-- Adult Number -->
                                    <div class="d-hs-input-group" data-hs-input-number='{"min": 1, "max": 9}'>
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
                                                <button type="button"
                                                    class="passCount size-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-md border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
                                                    tabindex="-1" aria-label="Decrease"
                                                    data-hs-input-number-decrement="">
                                                    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="M5 12h14"></path>
                                                    </svg>
                                                </button>
                                                <input name="adult"
                                                    class="p-0 w-6 bg-transparent border-0 text-gray-800 text-center focus:ring-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none"
                                                    style="-moz-appearance: textfield" type="number"
                                                    aria-roledescription="Number field" value="1"
                                                    data-hs-input-number-input="" />
                                                <button type="button"
                                                    class="passCount size-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-md border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
                                                    tabindex="-1" aria-label="Increase"
                                                    data-hs-input-number-increment="">
                                                    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
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
                                    <div class="d-hs-input-group" data-hs-input-number="">
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
                                                <button type="button"
                                                    class="passCount size-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-md border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
                                                    tabindex="-1" aria-label="Decrease"
                                                    data-hs-input-number-decrement="">
                                                    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="M5 12h14"></path>
                                                    </svg>
                                                </button>
                                                <input name="child"
                                                    class="p-0 w-6 bg-transparent border-0 text-gray-800 text-center focus:ring-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none"
                                                    style="-moz-appearance: textfield" type="number"
                                                    aria-roledescription="Number field" value="0"
                                                    data-hs-input-number-input="" />
                                                <button type="button"
                                                    class="passCount size-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-md border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
                                                    tabindex="-1" aria-label="Increase"
                                                    data-hs-input-number-increment="">
                                                    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
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
                                    {{-- <div class="" data-hs-input-number="">
                                    <div class="min-w-fit flex justify-between items-center gap-x-3">
                                        <div class="min-w-fit">
                                            <span class="block font-medium text-sm text-gray-800">
                                                Infant
                                            </span>
                                            <span class="block text-xs text-gray-500">
                                                (0 - 2 Years)
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-x-1.5">
                                            <button type="button"
                                                class="size-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-md border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
                                                tabindex="-1" aria-label="Decrease"
                                                data-hs-input-number-decrement="">
                                                <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path d="M5 12h14"></path>
                                                </svg>
                                            </button>
                                            <input
                                                class="p-0 w-6 bg-transparent border-0 text-gray-800 text-center focus:ring-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none"
                                                style="-moz-appearance: textfield" type="number"
                                                aria-roledescription="Number field" value="0"
                                                data-hs-input-number-input="" />
                                            <button type="button"
                                                class="size-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-md border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
                                                tabindex="-1" aria-label="Increase"
                                                data-hs-input-number-increment="">
                                                <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path d="M5 12h14"></path>
                                                    <path d="M12 5v14"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div> --}}
                                    <!-- End Infant Number -->

                                    <div>
                                        <label for="" class="text-xs font-medium pb-1">Nationality</label>
                                        <select name="nationality"
                                            data-hs-select='{
                                  "placeholder": "Select Nationality...",
                                  "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                  "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500",
                                  "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300",
                                  "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50",
                                  "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 \" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                                  "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                                }'
                                            class="hidden">
                                            <option value="NP">Nepal</option>
                                            <option value="IN">India</option>
                                            {{-- <option value="CN">China</option> --}}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="search-col">
                    <button type="desktop" class="btn_domestic_search bg-secondary py-10 w-full text-xl text-white font-semibold rounded-tr-md rounded-br-md">
                        SEARCH
                    </button>
                </div>
            </div>
        </div>
        <!-- / Domestic Search  -->
    </div>
    <!--/ Domestic Tab  -->
</form>
