@php
    $outbound_flight = Session::get('outbound_flight');
    $inbound_flight = Session::get('inbound_flight');
    $request_data = Session::get('request_data');
@endphp

<div class="flight-details-accordion mt-4 md:mt-8">
    <div class="container mx-auto">
        <div class="hs-accordion-group bg-white rounded-lg shadow-md px-0 md:px-6 py-4">
            <div class="hs-accordion" id="hs-basic-with-title-and-arrow-stretched-heading-two">
                <button
                    class="hs-accordion-toggle overflow-hidden hs-accordion-active:text-blue-600 py-3 px-4 inline-flex items-center justify-between gap-x-3 w-full font-semibold text-start text-gray-800 hover:text-gray-500 disabled:opacity-50 disabled:pointer-events-none"
                    aria-expanded="false" aria-controls="hs-basic-with-title-and-arrow-stretched-collapse-two">
                    <div>
                        <h3 class="text-xl font-semibold tracking-wider text-gray-700">
                            {{ $outbound_flight->Departure }} to {{ $outbound_flight->Arrival }}
                        </h3>
                        <p class="text-sm font-medium tracking-wide text-gray-400">
                            Departure On {{ $outbound_flight->FlightDate }} At {{ $outbound_flight->DepartureTime }}
                            Direct Flight Travel Time
                            {{ timeCalculation($outbound_flight->DepartureTime, $outbound_flight->ArrivalTime) }}
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
                <div id="hs-basic-with-title-and-arrow-stretched-collapse-two"
                    class="hs-accordion-content hidden w-full overflow-hidden px-2 md:px-4 py-4 transition-[height] duration-300"
                    role="region" aria-labelledby="hs-basic-with-title-and-arrow-stretched-heading-two">
                    <div class="accordion-flight-detail rounded-lg overflow-hidden shadow-md">
                        <div class="bg-primary w-full px-4 py-3 flex items-center justify-center gap-2 text-base">
                            <div class="flex items-center justify-center gap-3">
                                <i class="fa-solid fa-plane-departure text-white"></i>
                                <p class="text-white text-base font-bold tracking-wider">
                                    {{ $request_data['from'] }}
                                </p>
                                <i class="fa-solid fa-minus text-white"></i>
                                <p class="text-white text-base font-bold tracking-wider">
                                    {{ $request_data['to'] }}
                                </p>
                                <i class="fa-solid fa-plane-arrival text-white"></i>
                            </div>
                        </div>
                        <div class="bg-white py-3 px-3 md:px-14">
                            <div class="traveller-flights">
                                <div class="airport-name md:min-w-fit">
                                    <h4 class="text-sm font-medium text-gray-500 text-start">
                                        {{ date('D, M d, Y', strtotime($request_data['flightDate'])) }},
                                        {{ date('h:i A', strtotime($outbound_flight->DepartureTime)) }}
                                    </h4>
                                    <h4 class="text-base font-semibold text-gray-700 text-start">
                                        {{ $request_data['from'] }} - {{ $outbound_flight->Departure }}
                                    </h4>
                                </div>

                                <div class="airport-progress">
                                    <i class="fa-regular fa-circle-dot text-primary float-start"></i>
                                    <i class="fa-regular fa-circle-dot text-primary float-end"></i>
                                </div>

                                <div class="airport-name arrival md:min-w-fit">
                                    <h4 class="text-sm font-medium text-gray-500 text-start">
                                        {{ date('D, M d, Y', strtotime($request_data['flightDate'])) }},
                                        {{ date('h:i A', strtotime($outbound_flight->ArrivalTime)) }}

                                    </h4>
                                    <h4 class="text-base font-semibold text-gray-700 text-start">
                                        {{ $request_data['to'] }} - {{ $outbound_flight->Arrival }}
                                    </h4>
                                </div>
                            </div>
                            <div class="flex gap-4 md:gap-6 mt-4 items-center text-base">
                                <div class="flight-logo">
                                    <img src="./../../public/images/qatar.png" alt="" width="72px"
                                        height="auto" />
                                    <p class="text-xs font-bold text-gray-400">
                                        {{ airlinesFullName($outbound_flight->Airline) }},
                                        {{ $outbound_flight->FlightNo }}</p>
                                </div>
                                <h6 class="text-base text-gray-400 font-medium">
                                    Direct :
                                    {{ timeCalculation($outbound_flight->DepartureTime, $outbound_flight->ArrivalTime) }}
                                </h6>
                            </div>
                        </div>
                    </div>

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
                                    {{-- <div class="flex items-center justify-between">
                                        <div class="flex gap-2 items-center">
                                            <i class="fa-solid fa-suitcase-rolling text-primary text-2xl"></i>
                                            <div>
                                                <h6 class="text-xs text-primary font-medium">
                                                    1 Carry-On Bag
                                                </h6>
                                                <p class="text-sm font-normal text-gray-400">
                                                    Max Weight 5 kg
                                                </p>
                                            </div>
                                        </div>
                                        <p class="text-xs font-medium text-gray-400 tracking-wider">
                                            Included
                                        </p>
                                    </div> --}}
                                    <div class="flex items-center justify-between">
                                        <div class="flex gap-2 items-center">
                                            <i class="fa-solid fa-bag-shopping text-primary text-2xl"></i>
                                            <div>
                                                <h6 class="text-xs text-primary font-medium">
                                                    1 Checked Bag
                                                </h6>
                                                <p class="text-sm font-normal text-gray-400">
                                                    Max Weight {{ $outbound_flight->FreeBaggage }}
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

@if ($request_data['type'] == 'R')
    <div class="flight-details-accordion mt-4 md:mt-8">
        <div class="container mx-auto">
            <div class="hs-accordion-group bg-white rounded-lg shadow-md px-0 md:px-6 py-4">
                <div class="hs-accordion" id="hs-basic-with-title-and-arrow-stretched-heading-two">
                    <button
                        class="hs-accordion-toggle overflow-hidden hs-accordion-active:text-blue-600 py-3 px-4 inline-flex items-center justify-between gap-x-3 w-full font-semibold text-start text-gray-800 hover:text-gray-500 disabled:opacity-50 disabled:pointer-events-none"
                        aria-expanded="false" aria-controls="hs-basic-with-title-and-arrow-stretched-collapse-two">
                        <div>
                            <h3 class="text-xl font-semibold tracking-wider text-gray-700">
                                {{ $inbound_flight->Departure }} to {{ $inbound_flight->Arrival }}
                            </h3>
                            <p class="text-sm font-medium tracking-wide text-gray-400">
                                Departure On {{ $inbound_flight->FlightDate }} At {{ $inbound_flight->DepartureTime }}
                                Direct Flight Travel Time
                                {{ timeCalculation($inbound_flight->DepartureTime, $inbound_flight->ArrivalTime) }}
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
                    <div id="hs-basic-with-title-and-arrow-stretched-collapse-two"
                        class="hs-accordion-content hidden w-full overflow-hidden px-2 md:px-4 py-4 transition-[height] duration-300"
                        role="region" aria-labelledby="hs-basic-with-title-and-arrow-stretched-heading-two">
                        <div class="accordion-flight-detail rounded-lg overflow-hidden shadow-md">
                            <div class="bg-primary w-full px-4 py-3 flex items-center justify-center gap-2 text-base">
                                <div class="flex items-center justify-center gap-3">
                                    <i class="fa-solid fa-plane-departure text-white"></i>
                                    <p class="text-white text-base font-bold tracking-wider">
                                        {{ $request_data['to'] }}
                                    </p>
                                    <i class="fa-solid fa-minus text-white"></i>
                                    <p class="text-white text-base font-bold tracking-wider">
                                        {{ $request_data['from'] }}
                                    </p>
                                    <i class="fa-solid fa-plane-arrival text-white"></i>
                                </div>
                            </div>
                            <div class="bg-white py-3 px-3 md:px-14">
                                <div class="traveller-flights">
                                    <div class="airport-name md:min-w-fit">
                                        <h4 class="text-sm font-medium text-gray-500 text-start">
                                            {{ date('D, M d, Y', strtotime($request_data['returnDate'])) }},
                                            {{ date('h:i A', strtotime($inbound_flight->DepartureTime)) }}
                                        </h4>
                                        <h4 class="text-base font-semibold text-gray-700 text-start">
                                            {{ $request_data['to'] }} - {{ $inbound_flight->Departure }}
                                        </h4>
                                    </div>

                                    <div class="airport-progress">
                                        <i class="fa-regular fa-circle-dot text-primary float-start"></i>
                                        <i class="fa-regular fa-circle-dot text-primary float-end"></i>
                                    </div>

                                    <div class="airport-name arrival md:min-w-fit">
                                        <h4 class="text-sm font-medium text-gray-500 text-start">
                                            {{ date('D, M d, Y', strtotime($request_data['returnDate'])) }},
                                            {{ date('h:i A', strtotime($inbound_flight->ArrivalTime)) }}

                                        </h4>
                                        <h4 class="text-base font-semibold text-gray-700 text-start">
                                            {{ $request_data['from'] }} - {{ $inbound_flight->Arrival }}
                                        </h4>
                                    </div>
                                </div>
                                <div class="flex gap-4 md:gap-6 mt-4 items-center text-base">
                                    <div class="flight-logo">
                                        <img src="./../../public/images/qatar.png" alt="" width="72px"
                                            height="auto" />
                                        <p class="text-xs font-bold text-gray-400">
                                            {{ airlinesFullName($inbound_flight->Airline) }},
                                            {{ $inbound_flight->FlightNo }}</p>
                                    </div>
                                    <h6 class="text-base text-gray-400 font-medium">
                                        Direct :
                                        {{ timeCalculation($inbound_flight->DepartureTime, $inbound_flight->ArrivalTime) }}
                                    </h6>
                                </div>
                            </div>
                        </div>

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
                                        {{-- <div class="flex items-center justify-between">
                                        <div class="flex gap-2 items-center">
                                            <i class="fa-solid fa-suitcase-rolling text-primary text-2xl"></i>
                                            <div>
                                                <h6 class="text-xs text-primary font-medium">
                                                    1 Carry-On Bag
                                                </h6>
                                                <p class="text-sm font-normal text-gray-400">
                                                    Max Weight 5 kg
                                                </p>
                                            </div>
                                        </div>
                                        <p class="text-xs font-medium text-gray-400 tracking-wider">
                                            Included
                                        </p>
                                    </div> --}}
                                        <div class="flex items-center justify-between">
                                            <div class="flex gap-2 items-center">
                                                <i class="fa-solid fa-bag-shopping text-primary text-2xl"></i>
                                                <div>
                                                    <h6 class="text-xs text-primary font-medium">
                                                        1 Checked Bag
                                                    </h6>
                                                    <p class="text-sm font-normal text-gray-400">
                                                        Max Weight {{ $inbound_flight->FreeBaggage }}
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
@endif
