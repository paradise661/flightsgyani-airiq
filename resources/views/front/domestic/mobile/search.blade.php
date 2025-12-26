<form action="{{ route('domesticflights.result') }}" method="POST">
    @csrf
    <div id="pills-with-brand-color-2" class="hidden" role="tabpanel" aria-labelledby="pills-with-brand-color-item-2">
        <div class="flex">
            <label for="domestic-radio-one"
                class="flex py-1 px-5 w-full text-center bg-white rounded-3xl text-sm focus:border-primary focus:ring-primary text-gray-500 has-[:checked]:bg-primary has-[:checked]:text-white">
                <input type="radio" value="one-way" name="type"
                    class="hidden shrink-0 mt-0.5 border-gray-200 rounded-full text-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                    id="domestic-radio-one" checked="">
                <span class="text-sm text-center w-full">One Way</span>
            </label>
            <label for="domestic-radio-two"
                class="flex py-1 px-5 w-full text-center bg-white rounded-3xl text-sm focus:border-primary focus:ring-primary text-gray-500 has-[:checked]:bg-primary has-[:checked]:text-white">
                <input type="radio" name="type" value="two-way"
                    class="hidden shrink-0 mt-0.5 border-gray-200 rounded-full text-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                    id="domestic-radio-two">
                <span class="text-sm text-center w-full">Two Way</span>
            </label>
        </div>

        <!-- Domestic One / Two Way  -->
        <div class="grid grid-cols-2 gap-4 mt-3 r-singlecity-domestic" style="display: grid">
            <div class="r-from-domestic relative">
                <div class="border border-primary px-2 py-3 rounded-lg">
                    <div class="relative inline-flex w-full">
                        <div class="flex flex-col items-center justify-center w-full">
                            {{-- <input id="r-depairport-domestic" type="hidden" readonly="" value="TIA">
                              <input id="r-depcity-domestic" type="hidden" readonly="" value="ktm"> --}}
                            <input type="hidden" class="depairport-domestic-value" id="depairport-domestic-value"
                                name="from" value="KTM" />

                            <p class="text-xs text-gray-400 font-medium capitalize">
                                FROM
                            </p>
                            <div class="d-domestic-dvaluecode text-2xl text-black font-bold uppercase leading-10 boarder-0"
                                id="display-depairport-domestic">KTM</div>
                            <div class="d-domestic-dvalue text-xs text-black font-semibold uppercase overflow-hidden text-ellipsis"
                                id="display-depcity-domestic">KATHMANDU</div>
                        </div>
                        <div class="open-domestic-search stretched-link"></div>
                        <!-- <div class="px-4 py-3 z-50 hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-72 bg-white shadow-md rounded-lg mt-2 -top-24"
                            role="menu" aria-orientation="vertical" aria-labelledby="departure-dropdown-domestic">
                            <div class="w-full flex justify-between items-center">
                                <h4>Flying From</h4>
                                <div type="button"
                                    class="bg-gray-100 p-3 size-4 rounded-full flex items-center justify-center hs-dropdown-close"
                                    aria-expanded="false" aria-label="Menu">
                                    <i class="fa-solid fa-xmark"></i>
                                </div>
                            </div>
                            <div class="relative mt-2">
                                <input type="text"
                                    class="searchInput peer py-3 px-4 ps-11 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                    placeholder="Search Airports, Cities">
                                <div
                                    class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4 peer-disabled:opacity-50 peer-disabled:pointer-events-none">
                                    <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
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
                            <div id="dropdownList"
                                class="dropdown-content max-h-64 overflow-y-auto flex flex-col gap-1 mt-2 -me-2">
                                @foreach ($sectors['Sector'] ?? [] as $sector)
<a sectorCode="{{ $sector['SectorCode'] }}" sectorName="{{ $sector['SectorName'] }}"
                                    class="sector_click block w-full px-4 py-3 pr-10 border-b   hover:bg-primary-background"
                                    href="javascript:void(0)">{{ $sector['SectorName'] }} <span
                                        class="font-semibold">({{ $sector['SectorCode'] }})</span> </a>
@endforeach
                            </div>
                        </div> -->
                    </div>
                </div>

                <div class="r-swipesector absolute top-7 -right-7 border border-primary domestic-r-swipesector"
                    id="r-swapinput-domestic"></div>
            </div>
            <div class="r-to-domestic relative">
                <div class="border border-primary px-2 py-3 rounded-lg">
                    <div class="hs-dropdown relative inline-flex [--auto-close:inside] w-full">
                        <div class="hs-dropdown-toggle flex flex-col items-center justify-center w-full"
                            aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown"
                            id="return-dropdown-domestic">
                            {{-- <input id="r-arrairport-domestic" type="hidden" readonly="" value="PA">
                        <input id="r-arrcity-domestic" type="hidden" readonly="" value="Pokhara"> --}}
                            <input type="hidden" class="arrairport-domestic-value" id="arrairport-domestic-value"
                                name="to" value="PKR" />

                            <p class="text-xs text-gray-400 font-medium capitalize">
                                TO
                            </p>
                            <div class="d-domestic-arrairport text-2xl text-black font-bold uppercase border-0 leading-10"
                                id="display-arrairport-domestic">PKR</div>
                            <div class="d-domestic-arrcity text-xs text-black font-semibold uppercase overflow-hidden text-ellipsis"
                                id="display-arrcity-domestic">Pokhara</div>
                        </div>
                        <!-- <div class="px-4 py-3 z-50 hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-72 bg-white shadow-md rounded-lg mt-2 -top-24"
                            role="menu" aria-orientation="vertical" aria-labelledby="return-dropdown-domestic">
                            <div class="w-full flex justify-between items-center">
                                <h4>Flying To</h4>
                                <div type="button"
                                    class="bg-gray-100 p-3 size-4 rounded-full flex items-center justify-center hs-dropdown-close"
                                    aria-expanded="false" aria-label="Menu">
                                    <i class="fa-solid fa-xmark"></i>
                                </div>
                            </div>
                            <div class="relative mt-2">
                                <input type="text"
                                    class="searchInput peer py-3 px-4 ps-11 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                    placeholder="Search Airports, Cities">
                                <div
                                    class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4 peer-disabled:opacity-50 peer-disabled:pointer-events-none">
                                    <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
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
                            <div id="dropdownList"
                                class="dropdown-content max-h-64 overflow-y-auto flex flex-col gap-1 mt-2 -me-2">
                                @foreach ($sectors['Sector'] ?? [] as $sector)
<a sectorCode="{{ $sector['SectorCode'] }}"
                                    sectorName="{{ $sector['SectorName'] }}"
                                    class="sector2_click block w-full px-4 py-3 pr-10 border-b   hover:bg-primary-background"
                                    href="javascript:void(0)">{{ $sector['SectorName'] }} <span
                                        class="font-semibold"> ({{ $sector['SectorCode'] }})</span></a>
@endforeach
                            </div>
                        </div> -->
                    </div>
                </div>
                <div class="open-domestic-search stretched-link"></div>
            </div>
            <div class="r-dep-domestic">
                <div class="border border-primary px-2 py-3 rounded-lg flex flex-col items-start justify-center">
                    <p class="text-xs text-gray-400 font-medium capitalize">
                        Departure Date
                    </p>

                    <div class="relative">
                        <input autocomplete="off" type="text" name="flightDate" id="rdep_date_value" readonly
                            value="{{ date('m/d/Y') }}"
                            class="dep-date peer pe-2 pt-2 pb-2 ps-8 block w-full bg-transparent border-0 text-base text-black font-semibold disabled:opacity-50 disabled:pointer-events-none tracking-wide focus:shadow-none focus:ring-0 "
                            placeholder="MM/DD/YYYY">
                        <div
                            class="absolute inset-y-0 start-0 flex items-center pointer-events-none peer-disabled:opacity-50 peer-disabled:pointer-events-none">
                            <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M3 9H21M7 3V5M17 3V5M6 12H8M11 12H13M16 12H18M6 15H8M11 15H13M16 15H18M6 18H8M11 18H13M16 18H18M6.2 21H17.8C18.9201 21 19.4802 21 19.908 20.782C20.2843 20.5903 20.5903 20.2843 20.782 19.908C21 19.4802 21 18.9201 21 17.8V8.2C21 7.07989 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V17.8C3 18.9201 3 19.4802 3.21799 19.908C3.40973 20.2843 3.71569 20.5903 4.09202 20.782C4.51984 21 5.07989 21 6.2 21Z"
                                        stroke="#929292" stroke-width="1" stroke-linecap="round"></path>
                                </g>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="r-return-domestic" style="opacity: 0.4">
                <div
                    class="relative border border-primary px-2 py-3 rounded-lg flex flex-col items-start justify-center">
                    <p class="text-xs text-gray-400 font-medium capitalize">
                        Return Date
                    </p>
                    <div class="relative">
                        <input type="text" id="" name="returnDate" autocomplete="off" readonly
                            class="return-date peer pe-2 pt-2 pb-2 ps-8 block w-full bg-transparent border-0 text-base text-black font-semibold disabled:opacity-50 disabled:pointer-events-none tracking-wide focus:shadow-none focus:ring-0"
                            placeholder="mm/dd/yyyy">
                        <div
                            class="absolute inset-y-0 start-0 flex items-center pointer-events-none peer-disabled:opacity-50 peer-disabled:pointer-events-none">
                            <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M3 9H21M7 3V5M17 3V5M6 12H8M11 12H13M16 12H18M6 15H8M11 15H13M16 15H18M6 18H8M11 18H13M16 18H18M6.2 21H17.8C18.9201 21 19.4802 21 19.908 20.782C20.2843 20.5903 20.5903 20.2843 20.782 19.908C21 19.4802 21 18.9201 21 17.8V8.2C21 7.07989 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V17.8C3 18.9201 3 19.4802 3.21799 19.908C3.40973 20.2843 3.71569 20.5903 4.09202 20.782C4.51984 21 5.07989 21 6.2 21Z"
                                        stroke="#929292" stroke-width="1" stroke-linecap="round"></path>
                                </g>
                            </svg>
                        </div>
                    </div>
                    <div class="absolute top-2 right-2 bg-gray-100 p-2 size-1 rounded-full flex items-center justify-center"
                        id="returnCross-domestic">
                        <i class="fa-solid fa-xmark"></i>
                    </div>
                </div>
            </div>
            <div class="r-travellers-domestic r-travellers">
                <div
                    class="relative border border-primary px-2 py-3 rounded-lg flex flex-col items-start justify-center">
                    <p class="text-xs text-gray-400 font-medium capitalize">
                        Traveller(s)
                    </p>
                    <!-- Travellers Count  -->
                    <div class="travellers-count">
                        <button id="domestic-travellers-count" type="button" aria-haspopup="dialog"
                            aria-expanded="false" aria-controls="domestic-travellers-drop"
                            data-hs-overlay="#domestic-travellers-drop" class="py-1 text-sm text-black font-semibold">
                            1
                        </button>
                        <div id="domestic-travellers-drop"
                            class="hs-overlay hs-overlay-open:translate-y-0 translate-y-full fixed bottom-0 inset-x-0 transition-all duration-300 transform max-h-[32rem] size-full z-[99999] bg-white border-b hidden"
                            role="dialog" tabindex="-1" aria-labelledby="hs-offcanvas-bottom-label">
                            <div class="flex justify-between items-center py-3 px-4 border-b">
                                <h3 id="hs-offcanvas-bottom-label" class="font-medium text-lg text-gray-800">
                                    No. of Travellers
                                </h3>
                                <div type="button"
                                    class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none"
                                    aria-label="Close" data-hs-overlay="#domestic-travellers-drop">
                                    <span class="sr-only">Close</span>
                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M18 6 6 18"></path>
                                        <path d="m6 6 12 12"></path>
                                    </svg>
                                </div>
                            </div>
                            <!-- No of Travellers Select  -->
                            <div class="p-4" id="rDomesticTravellerRadio">
                                <!-- Adult Travellers  -->
                                <div class="domestic-adult-travellers">
                                    <label class="" for="domesticadultcount">
                                        <span class="font-semibold">Adults</span> (12+
                                        yrs)</label>
                                    <div class="flex gap-2 mt-2">
                                        <label for="domestic-adult-1"
                                            class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary">
                                            <input checked type="radio" name="domesticadultcount" class="hidden"
                                                id="domestic-adult-1" value="1 ">
                                            <span class="text-sm">1</span>
                                        </label>

                                        <label for="domestic-adult-2"
                                            class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary">
                                            <input type="radio" name="domesticadultcount" class="hidden"
                                                id="domestic-adult-2" value="2">
                                            <span class="text-sm">2</span>
                                        </label>

                                        <label for="domestic-adult-3"
                                            class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary">
                                            <input type="radio" name="domesticadultcount" class="hidden"
                                                id="domestic-adult-3" value="3">
                                            <span class="text-sm">3</span>
                                        </label>
                                        <label for="domestic-adult-4"
                                            class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary">
                                            <input type="radio" name="domesticadultcount" class="hidden"
                                                id="domestic-adult-4" value="4">
                                            <span class="text-sm">4</span>
                                        </label>
                                        <label for="domestic-adult-5"
                                            class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary">
                                            <input type="radio" name="domesticadultcount" class="hidden"
                                                id="domestic-adult-5" value="5">
                                            <span class="text-sm">5</span>
                                        </label>
                                        <label for="domestic-adult-6"
                                            class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary">
                                            <input type="radio" name="domesticadultcount" class="hidden"
                                                id="domestic-adult-6" value="6">
                                            <span class="text-sm">6</span>
                                        </label>
                                        <label for="domestic-adult-7"
                                            class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary">
                                            <input type="radio" name="domesticadultcount" class="hidden"
                                                id="domestic-adult-7" value="7">
                                            <span class="text-sm">7</span>
                                        </label>
                                        <label for="domestic-adult-8"
                                            class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary">
                                            <input type="radio" name="domesticadultcount" class="hidden"
                                                id="domestic-adult-8" value="8">
                                            <span class="text-sm">8</span>
                                        </label>
                                        <label for="domestic-adult-9"
                                            class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary">
                                            <input type="radio" name="domesticadultcount" class="hidden"
                                                id="domestic-adult-9" value="9">
                                            <span class="text-sm">9</span>
                                        </label>
                                    </div>
                                    <input name="adult" id="domesticadultcount" value="1" type="hidden">
                                </div>
                                <!-- / Adult Travellers  -->

                                <!-- Children Travellers -->
                                <div class="children-travellers mt-6">
                                    <label class="" for="domestichildrencount">
                                        <span class="font-semibold">Children</span>
                                        (2-12 yrs)</label>
                                    <div class="flex gap-2 mt-2">
                                        <label for="domestic-children-0"
                                            class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary">
                                            <input type="radio" name="domestichildrencount" class="hidden"
                                                id="domestic-children-0" value="0">
                                            <span class="text-sm">0</span>
                                        </label>
                                        <label for="domestic-children-1"
                                            class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary">
                                            <input type="radio" name="domestichildrencount" class="hidden"
                                                id="domestic-children-1" value="1">
                                            <span class="text-sm">1</span>
                                        </label>

                                        <label for="domestic-children-2"
                                            class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary">
                                            <input type="radio" name="domestichildrencount" class="hidden"
                                                id="domestic-children-2" value="2">
                                            <span class="text-sm">2</span>
                                        </label>

                                        <label for="domestic-children-3"
                                            class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary">
                                            <input type="radio" name="domestichildrencount" class="hidden"
                                                id="domestic-children-3" value="3">
                                            <span class="text-sm">3</span>
                                        </label>
                                        <label for="domestic-children-4"
                                            class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary">
                                            <input type="radio" name="domestichildrencount" class="hidden"
                                                id="domestic-children-4" value="4">
                                            <span class="text-sm">4</span>
                                        </label>
                                        <label for="domestic-children-5"
                                            class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary">
                                            <input type="radio" name="domestichildrencount" class="hidden"
                                                id="domestic-children-5" value="5">
                                            <span class="text-sm">5</span>
                                        </label>
                                        <label for="domestic-children-6"
                                            class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary">
                                            <input type="radio" name="domestichildrencount" class="hidden"
                                                id="domestic-children-6" value="6">
                                            <span class="text-sm">6</span>
                                        </label>
                                        <label for="domestic-children-7"
                                            class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary">
                                            <input type="radio" name="domestichildrencount" class="hidden"
                                                id="domestic-children-7" value="7">
                                            <span class="text-sm">7</span>
                                        </label>
                                        <label for="domestic-children-8"
                                            class="flex justify-center items-center w-full p-2 bg-white border border-gray-200 rounded-sm text-sm has-[:checked]:text-white has-[:checked]:bg-primary">
                                            <input type="radio" name="domestichildrencount" class="hidden"
                                                id="domestic-children-8" value="8">
                                            <span class="text-sm">8</span>
                                        </label>
                                    </div>
                                    <input name="child" id="domestichildrencount" type="hidden">
                                </div>
                                <!-- / Children Travellers -->

                                <!-- Nationality  -->
                                <div class="nationality mt-6">
                                    <label for="">
                                        <span class="font-semibold">Nationality</span></label>

                                    <div class="hs-select relative">
                                        <select name="nationality"
                                            data-hs-select="{
                                &quot;placeholder&quot;: &quot;Select Nationality...&quot;,
                                &quot;toggleTag&quot;: &quot;<button type=\&quot;button\&quot; aria-expanded=\&quot;false\&quot;></button>&quot;,
                                &quot;toggleClasses&quot;: &quot;hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500&quot;,
                                &quot;dropdownClasses&quot;: &quot;mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&amp;::-webkit-scrollbar]:w-2 [&amp;::-webkit-scrollbar-thumb]:rounded-full [&amp;::-webkit-scrollbar-track]:bg-gray-100 [&amp;::-webkit-scrollbar-thumb]:bg-gray-300&quot;,
                                &quot;optionClasses&quot;: &quot;py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50&quot;,
                                &quot;optionTemplate&quot;: &quot;<div class=\&quot;flex justify-between items-center w-full\&quot;><span data-title></span><span class=\&quot;hidden hs-selected:block\&quot;><svg class=\&quot;shrink-0 size-3.5 text-blue-600 \&quot; xmlns=\&quot;http:.w3.org/2000/svg\&quot; width=\&quot;24\&quot; height=\&quot;24\&quot; viewBox=\&quot;0 0 24 24\&quot; fill=\&quot;none\&quot; stroke=\&quot;currentColor\&quot; stroke-width=\&quot;2\&quot; stroke-linecap=\&quot;round\&quot; stroke-linejoin=\&quot;round\&quot;><polyline points=\&quot;20 6 9 17 4 12\&quot;/></svg></span></div>&quot;,
                                &quot;extraMarkup&quot;: &quot;<div class=\&quot;absolute top-1/2 end-3 -translate-y-1/2\&quot;><svg class=\&quot;shrink-0 size-3.5 text-gray-500 \&quot; xmlns=\&quot;http://www.w3.org/2000/svg\&quot; width=\&quot;24\&quot; height=\&quot;24\&quot; viewBox=\&quot;0 0 24 24\&quot; fill=\&quot;none\&quot; stroke=\&quot;currentColor\&quot; stroke-width=\&quot;2\&quot; stroke-linecap=\&quot;round\&quot; stroke-linejoin=\&quot;round\&quot;><path d=\&quot;m7 15 5 5 5-5\&quot;/><path d=\&quot;m7 9 5-5 5 5\&quot;/></svg></div>&quot;
                              }"
                                            class="hidden" style="display: none;">
                                            <option value="NP">Nepal</option>
                                            <option value="IN">India</option>
                                            {{-- <option value="CN">China</option> --}}
                                        </select>
                                        <div data-hs-select-dropdown=""
                                            class="absolute top-full hidden mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&amp;::-webkit-scrollbar]:w-2 [&amp;::-webkit-scrollbar-thumb]:rounded-full [&amp;::-webkit-scrollbar-track]:bg-gray-100 [&amp;::-webkit-scrollbar-thumb]:bg-gray-300"
                                            role="listbox" tabindex="-1" aria-orientation="vertical">
                                            <div data-value="Nepal" data-title-value="Nepal" tabindex="0"
                                                class="cursor-pointer selected py-2 px-4 w-full text-sm text-gray-800 hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50">
                                                <div class="flex justify-between items-center w-full">
                                                    <span data-title="">Nepal</span><span
                                                        class="hidden hs-selected:block"><svg
                                                            class="shrink-0 size-3.5 text-blue-600 "
                                                            xmlns="http:.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <polyline points="20 6 9 17 4 12">
                                                            </polyline>
                                                        </svg></span>
                                                </div>
                                            </div>
                                            <div data-value="India" data-title-value="India" tabindex="1"
                                                class="cursor-pointer py-2 px-4 w-full text-sm text-gray-800 hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50">
                                                <div class="flex justify-between items-center w-full">
                                                    <span data-title="">India</span><span
                                                        class="hidden hs-selected:block"><svg
                                                            class="shrink-0 size-3.5 text-blue-600 "
                                                            xmlns="http:.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <polyline points="20 6 9 17 4 12">
                                                            </polyline>
                                                        </svg></span>
                                                </div>
                                            </div>
                                            <div data-value="China" data-title-value="China" tabindex="2"
                                                class="cursor-pointer py-2 px-4 w-full text-sm text-gray-800 hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50">
                                                <div class="flex justify-between items-center w-full">
                                                    <span data-title="">China</span><span
                                                        class="hidden hs-selected:block"><svg
                                                            class="shrink-0 size-3.5 text-blue-600 "
                                                            xmlns="http:.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <polyline points="20 6 9 17 4 12">
                                                            </polyline>
                                                        </svg></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="absolute top-1/2 end-3 -translate-y-1/2"><svg
                                                class="shrink-0 size-3.5 text-gray-500 "
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="m7 15 5 5 5-5"></path>
                                                <path d="m7 9 5-5 5 5"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- / Nationality  -->

                                <div class="py-1 px-2 rounded text-base font-medium mt-6 bg-primary-lighter">
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

            <div class="r-search-domestic col-span-2">
                <button type="mobile" class="btn_domestic_search bg-primary w-full py-3 text-white rounded-3xl">
                    SEARCH
                </button>
            </div>
        </div>
        <!-- / Domestic One / Two Way  -->


        <!-- Domestic From To Search  -->
        <div class="domestic-from-to-search" style="display: none;">
            <div class="absolute top-0 left-0 w-full h-auto bg-white z-30 domestic-data-filter">
                <div class="fixed top-0 bg-primary px-4 py-3 w-full">
                    <div class="flex gap-2 w-full items-start">
                        <div class="p-2 close-domestic-search cursor-pointer"><i
                                class="fa-solid fa-chevron-left text-white text-xl"></i></div>
                        <div class="flex flex-col gap-2 flex-grow">
                            <div class="relative">
                                <input type="text"
                                    class="searchInput_mobile peer py-3 px-4 ps-11 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                    placeholder="Search Airports, Cities">
                                <div style="height: 44px;"
                                    class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4 peer-disabled:opacity-50 peer-disabled:pointer-events-none">
                                    <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        fill="#000000">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>flight_takeoff_line</title>
                                            <g id="页面-1" stroke="none" stroke-width="1" fill="none"
                                                fill-rule="evenodd">
                                                <g id="Transport" transform="translate(-624.000000, 0.000000)">
                                                    <g id="flight_takeoff_line"
                                                        transform="translate(624.000000, 0.000000)">
                                                        <path
                                                            d="M24,0 L24,24 L0,24 L0,0 L24,0 Z M12.5934901,23.257841 L12.5819402,23.2595131 L12.5108777,23.2950439 L12.4918791,23.2987469 L12.4918791,23.2987469 L12.4767152,23.2950439 L12.4056548,23.2595131 C12.3958229,23.2563662 12.3870493,23.2590235 12.3821421,23.2649074 L12.3780323,23.275831 L12.360941,23.7031097 L12.3658947,23.7234994 L12.3769048,23.7357139 L12.4804777,23.8096931 L12.4953491,23.8136134 L12.4953491,23.8136134 L12.5071152,23.8096931 L12.6106902,23.7357139 L12.6232938,23.7196733 L12.6232938,23.7196733 L12.6266527,23.7031097 L12.609561,23.275831 C12.6075724,23.2657013 12.6010112,23.2592993 12.5934901,23.257841 L12.5934901,23.257841 Z M12.8583906,23.1452862 L12.8445485,23.1473072 L12.6598443,23.2396597 L12.6498822,23.2499052 L12.6498822,23.2499052 L12.6471943,23.2611114 L12.6650943,23.6906389 L12.6699349,23.7034178 L12.6699349,23.7034178 L12.678386,23.7104931 L12.8793402,23.8032389 C12.8914285,23.8068999 12.9022333,23.8029875 12.9078286,23.7952264 L12.9118235,23.7811639 L12.8776777,23.1665331 C12.8752882,23.1545897 12.8674102,23.1470016 12.8583906,23.1452862 L12.8583906,23.1452862 Z M12.1430473,23.1473072 C12.1332178,23.1423925 12.1221763,23.1452606 12.1156365,23.1525954 L12.1099173,23.1665331 L12.0757714,23.7811639 C12.0751323,23.7926639 12.0828099,23.8018602 12.0926481,23.8045676 L12.108256,23.8032389 L12.3092106,23.7104931 L12.3186497,23.7024347 L12.3186497,23.7024347 L12.3225043,23.6906389 L12.340401,23.2611114 L12.337245,23.2485176 L12.337245,23.2485176 L12.3277531,23.2396597 L12.1430473,23.1473072 Z"
                                                            id="MingCute" fill-rule="nonzero"> </path>
                                                        <path
                                                            d="M20.9999,20 C21.5522,20 21.9999,20.4477 21.9999,21 C21.9999,21.51285 21.613873,21.9355092 21.1165239,21.9932725 L20.9999,22 L2.99988,22 C2.44759,22 1.99988,21.5523 1.99988,21 C1.99988,20.48715 2.38591566,20.0644908 2.8832579,20.0067275 L2.99988,20 L20.9999,20 Z M7.26152,3.77234 C7.60270875,3.68092 7.96415594,3.73859781 8.25798121,3.92633426 L8.37951,4.0147 L14.564,9.10597 L18.3962,8.41394 C19.7562,8.16834 21.1459,8.64954 22.0628,9.68357 C22.5196,10.1987 22.7144,10.8812 22.4884,11.5492 C22.1394625,12.580825 21.3287477,13.3849891 20.3041894,13.729249 L20.0965,13.7919 L5.02028,17.8315 C4.629257,17.93626 4.216283,17.817298 3.94116938,17.5298722 L3.85479,17.4279 L0.678249,13.1819 C0.275408529,12.6434529 0.504260903,11.8823125 1.10803202,11.640394 L1.22557,11.6013 L3.49688,10.9927 C3.85572444,10.8966111 4.23617877,10.9655 4.53678409,11.1757683 L4.64557,11.2612 L5.44206,11.9612 L7.83692,11.0255 L3.97034,6.11174 C3.54687,5.57357667 3.77335565,4.79203787 4.38986791,4.54876405 L4.50266,4.51158 L7.26152,3.77234 Z M7.40635,5.80409 L6.47052,6.05484 L10.2339,10.8375 C10.6268063,11.3368125 10.463277,12.0589277 9.92111759,12.3504338 L9.80769,12.4028 L5.60866,14.0433 C5.29604667,14.1654333 4.9460763,14.123537 4.67296914,13.9376276 L4.57438,13.8612 L3.6268,13.0285 L3.15564,13.1547 L5.09121,15.7419 L19.5789,11.86 C20.0227,11.7411 20.3838,11.4227 20.5587,11.0018 C20.142625,10.53815 19.5333701,10.3022153 18.9191086,10.3592364 L18.7516,10.3821 L14.4682,11.1556 C14.218,11.2007714 13.9615551,11.149698 13.7491184,11.0154781 L13.6468,10.9415 L7.40635,5.80409 Z"
                                                            id="形状" fill="#00a652"> </path>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                            <div class="relative">
                                <input type="text"
                                    class="searchInput2_mobile peer py-3 px-4 ps-11 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                    placeholder="Search Airports, Cities">
                                <div style="height: 44px;"
                                    class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4 peer-disabled:opacity-50 peer-disabled:pointer-events-none">
                                    <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        fill="#000000">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <title>flight_land_line</title>
                                            <g id="页面-1" stroke="none" stroke-width="1" fill="none"
                                                fill-rule="evenodd">
                                                <g id="Transport" transform="translate(-576.000000, 0.000000)">
                                                    <g id="flight_land_line"
                                                        transform="translate(576.000000, 0.000000)">
                                                        <path
                                                            d="M24,0 L24,24 L0,24 L0,0 L24,0 Z M12.5934901,23.257841 L12.5819402,23.2595131 L12.5108777,23.2950439 L12.4918791,23.2987469 L12.4918791,23.2987469 L12.4767152,23.2950439 L12.4056548,23.2595131 C12.3958229,23.2563662 12.3870493,23.2590235 12.3821421,23.2649074 L12.3780323,23.275831 L12.360941,23.7031097 L12.3658947,23.7234994 L12.3769048,23.7357139 L12.4804777,23.8096931 L12.4953491,23.8136134 L12.4953491,23.8136134 L12.5071152,23.8096931 L12.6106902,23.7357139 L12.6232938,23.7196733 L12.6232938,23.7196733 L12.6266527,23.7031097 L12.609561,23.275831 C12.6075724,23.2657013 12.6010112,23.2592993 12.5934901,23.257841 L12.5934901,23.257841 Z M12.8583906,23.1452862 L12.8445485,23.1473072 L12.6598443,23.2396597 L12.6498822,23.2499052 L12.6498822,23.2499052 L12.6471943,23.2611114 L12.6650943,23.6906389 L12.6699349,23.7034178 L12.6699349,23.7034178 L12.678386,23.7104931 L12.8793402,23.8032389 C12.8914285,23.8068999 12.9022333,23.8029875 12.9078286,23.7952264 L12.9118235,23.7811639 L12.8776777,23.1665331 C12.8752882,23.1545897 12.8674102,23.1470016 12.8583906,23.1452862 L12.8583906,23.1452862 Z M12.1430473,23.1473072 C12.1332178,23.1423925 12.1221763,23.1452606 12.1156365,23.1525954 L12.1099173,23.1665331 L12.0757714,23.7811639 C12.0751323,23.7926639 12.0828099,23.8018602 12.0926481,23.8045676 L12.108256,23.8032389 L12.3092106,23.7104931 L12.3186497,23.7024347 L12.3186497,23.7024347 L12.3225043,23.6906389 L12.340401,23.2611114 L12.337245,23.2485176 L12.337245,23.2485176 L12.3277531,23.2396597 L12.1430473,23.1473072 Z"
                                                            id="MingCute" fill-rule="nonzero"> </path>
                                                        <path
                                                            d="M20.99989,20.0001 C21.5522,20.0001 21.99989,20.4478 21.99989,21.0001 C21.99989,21.51295 21.6138716,21.9356092 21.1165158,21.9933725 L20.99989,22.0001 L2.99989,22.0001 C2.4476,22.0001 1.99989,21.5524 1.99989,21.0001 C1.99989,20.48725 2.38592566,20.0645908 2.8832679,20.0068275 L2.99989,20.0001 L20.99989,20.0001 Z M8.10346,3.20538 C8.00550211,2.52548211 8.59636283,1.96050997 9.25436746,2.06249271 L9.36455,2.08576 L12.1234,2.82499 C12.4699778,2.91787 12.7577704,3.15444975 12.9168957,3.47137892 L12.9704,3.59387 L15.7807,11.0953 L19.4455,12.4121 C20.7461,12.8794 21.709,13.991 21.9861,15.3449 C22.1241,16.0194 21.9516,16.7079 21.4218,17.1734 C20.6038313,17.8923687 19.4996906,18.183398 18.4402863,17.9692815 L18.2291,17.9197 L3.15287,13.8799 C2.75789727,13.7740818 2.45767661,13.459338 2.36633273,13.0674492 L2.34531,12.9477 L1.71732,7.68232 C1.63740111,7.01225556 2.22049639,6.4660062 2.86699575,6.56318572 L2.98162,6.58712 L5.25293,7.19571 C5.61177444,7.29186111 5.90680062,7.54177815 6.06199513,7.87418144 L6.11349,8.00256 L6.45329,9.00701 L8.99512,9.39414 L8.10346,3.20538 Z M10.2971,4.4062 L11.165,10.4298 C11.2559176,11.0610471 10.7489114,11.6064588 10.1303657,11.5834026 L10.0132,11.5723 L5.5565,10.8935 C5.22469556,10.8429222 4.94258198,10.6316333 4.79900425,10.3341508 L4.75183,10.2187 L4.34758,9.02368 L3.87642,8.89743 L4.25907,12.1058 L18.7467,15.9878 C19.1906,16.1067 19.6625,16.0115 20.0243,15.7345 C19.8949769,15.1206538 19.4803805,14.6088858 18.9139056,14.3528832 L18.7692,14.2943 L14.673,12.8225 C14.4336857,12.7364429 14.2371306,12.5639857 14.1203003,12.3415274 L14.0687,12.2263 L11.233,4.65695 L10.2971,4.4062 Z"
                                                            id="形状" fill="#00a652"> </path>
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
                        <div class=" h-full">
                            <h6 class="text-sm font-normal">POPULAR CITIES</h6>
                            <div class="flex flex-col gap-2 mt-2" id="dropdownList">
                                @foreach ($sectors as $sector)
                                    <a class="flight-search-suggestion sector_click_mobile"
                                        sectorCode="{{ $sector->code ?? '' }}"
                                        sectorName="{{ $sector->name ?? '' }}">
                                        <div>
                                            <h5 class="text-sm font-semibold">{{ $sector->code ?? '' }}</h5>
                                            <p class="text-xs font-normal">{{ $sector->name ?? '' }}</p>
                                        </div>
                                        <div class="bg-secondary px-3 py-1 text-white rounded-sm">
                                            {{ $sector->code ?? '' }}</div>
                                    </a>
                                @endforeach

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="fixed w-full h-full bg-white top-0 z-20 left-0"></div>
        </div>
        <!-- / Domestic From To Search  -->
    </div>
</form>

<script>
    $('[name="domesticadultcount"]').click(function(e) {
        $('#domesticadultcount').val($(this).val());
    })
    $('[name="domestichildrencount"]').click(function(e) {
        $('#domestichildrencount').val($(this).val());
    })
</script>
