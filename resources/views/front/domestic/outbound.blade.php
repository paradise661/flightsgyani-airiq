<div class="day-tracker pb-4 cursor-pointer" id="outboundflight_view">
    <div
        class="bg-primary px-3 text-white text-base font-medium tracking-wider py-4 rounded-md relative flex justify-between">
        <span>
            Departure Flights:
            <span class="text-white font-semibold text-lg">
                {{ $data['from'] }} - {{ $data['to'] }}
            </span>
            ({{ date('m/d/Y', strtotime($data['flightDate'])) }})
        </span>
        <span class="">
            <svg class="hs-dropdown-open:rotate-180 size-4 hidden" id="down-arrow" width="16" height="16"
                viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
            </svg>
            <svg class="hs-dropdown-open:rotate-180 size-4" id="up-arrow" width="16" height="16"
                viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M2 11L8.16086 5.3131C8.35239 5.1363 8.64761 5.1363 8.83914 5.3131L15 11" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round"></path>
            </svg>

        </span>
    </div>
</div>

@if (count($flights['Outbound']['Availability'] ?? []))

    <div id="{{ $data['type'] == 'R' ? 'outboundflight_data' : '' }}">
        <div class="{{ $data['type'] == 'R' ? 'outbound-detail-list' : '' }} detail-list domestic-detail-list">
            @foreach ($flights['Outbound']['Availability'] ?? [] as $outbound)
                <div class="outbound_flight domestic-detail-wrap relative py-2 border rounded-md flight-item bg-white"
                    data-flightid="{{ $outbound['FlightId'] }}"
                    data-amount="{{ $outbound['TotalAmount'] - $outbound['Discount'] }}"
                    data-logo="{{ asset('uploads/domestic/airlines/' . $airData[$outbound['Airline']]) }}"
                    data-flightno="{{ $outbound['FlightNo'] }}" data-time="{{ $outbound['DepartureTime'] }}"
                    data-price="{{ $outbound['TotalAmount'] - $outbound['Discount'] }}"
                    data-airline="{{ $outbound['Airline'] }}"
                    data-airline-fullname="{{ airlinesFullName($outbound['Airline']) }}"
                    data-details-outbound="{{ encrypt($outbound) }}" data-refundable="{{ $outbound['Refundable'] }}"
                    data-departure_time="{{ $outbound['DepartureTime'] }}">
                    <div class="flight-container flex w-full p-[12px] sm:px-[16px] sm:py-[12px]">
                        <div class="flights-details flex-grow ">
                            <div class="flight-details-bottom flex items-center justify-between mt-2">
                                <div
                                    class="logo-wrap flex flex-col items-center justify-center gap-[4px] xs:gap-[8px] sm:gap-[12px] ml-0 xs:ml-1 sm:ml-[1rem]">
                                    <img class="airline-logo h-[24px] sm:h-[32px] object-contain"
                                        src="{{ asset('uploads/domestic/airlines/' . $airData[$outbound['Airline']]) }}">
                                    <!-- <p class="text-sm font-semibold xsm:text-base md:text-xl w-[65px] xs:w-auto">BUDDHA AIRLINES</p> -->
                                    <p class="text-[10px] font-medium md:font-normal md:text-xs text-[#EA2127]">
                                        {{ $outbound['FlightNo'] }}
                                    </p>
                                </div>
                                <div
                                    class="arrival-departure flex justify-center items-center ml-1 xxs:ml-2 xsm:ml-[2rem]">
                                    <div class="departure flex flex-col gap-1">
                                        <div class="text-sm font-semibold sm:text-base md:text-xl departure-time">
                                            {{ $outbound['DepartureTime'] }}
                                        </div>
                                        <div class="text-xs font-semibold sm:text-sm">
                                            {{ $outbound['Departure'] }}
                                        </div>
                                    </div>
                                    <img class="mx-[2px] xs:mx-2 w-[60px] xxs:w-[75px] sm:w-[80px] md:w-[100px]"
                                        src="{{ asset('frontend/images/flight-progress.png') }}" alt="">
                                    <div class="arrival flex flex-col gap-1">
                                        <div class="text-sm font-semibold sm:text-base md:text-xl departure-time">
                                            {{ $outbound['ArrivalTime'] }}
                                        </div>
                                        <div class="text-xs font-semibold sm:text-sm">
                                            {{ $outbound['Arrival'] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="duration flex flex-col gap-1">
                                    <p class="text-gray-500 font-medium">Duration</p>
                                    <div class="flex gap-1 items-center text-gray-500"><i
                                            class="fa-regular fa-clock"></i>
                                        <p>{{ timeCalculation($outbound['DepartureTime'], $outbound['ArrivalTime']) }}
                                        </p>
                                    </div>
                                </div>
                                <div class="duration flex flex-col gap-1">
                                    <p class="text-gray-500 font-medium">Luggage</p>
                                    <div class="flex gap-1 items-center text-gray-500"><i
                                            class="fa-solid fa-suitcase-rolling"></i>
                                        <p>{{ $outbound['FreeBaggage'] }}</p>
                                    </div>
                                </div>
                                {{-- <p class="text-[12px] text-right xxs:text-xs md:text-sm text-secondary ">
                                    {{ $outbound['Refundable'] == 'T' ? 'Refundable' : 'Non-Refundable' }}
                                </p> --}}

                                <div class="flex flex-col gap-1 p-4">
                                    @if ($outbound['Discount'])
                                        <div class="flex items-center gap-1 italic">
                                            <p class="text-xs font-medium text-gray-700">Cash Back: </p>
                                            <p class="text-xs font-semibold text-green-600"> Rs
                                                {{ $outbound['Discount'] }}
                                            </p>

                                        </div>
                                    @endif

                                    <p class="text-[12px] text-right xxs:text-xs md:text-sm text-secondary">
                                        {{ $outbound['Refundable'] == 'T' ? 'Refundable' : 'Non-Refundable' }}
                                    </p>
                                </div>

                            </div>
                        </div>
                        <div
                            class="flights-pricing flex flex-col gap-1 justify-center h-full items-center ml-2 sm:ml-[16px]">
                            <div class="flex flex-col text-secondary ">
                                <p class="new-price font-medium text-xs md:text-base">{{ $outbound['Currency'] }}
                                    {{ ceil($outbound['TotalAmount'] - $outbound['Discount']) }}
                                </p>
                                @if ($outbound['Discount'] > 0)
                                    <s class="text-xs font-medium md:text-base text-gray-500">{{ $outbound['Currency'] }}
                                        {{ ceil($outbound['TotalAmount']) }}</s>
                                @endif
                            </div>
                            @if ($data['type'] == 'O')
                                <form action="{{ route('domesticflights.passengerdetails') }}" method="POST">
                                    @csrf
                                    <input id="" type="hidden" name="selectedoutboundflightdetails"
                                        value="{{ encrypt($outbound) }}">
                                    <input type="hidden" name="oneway_flightid" value="{{ $outbound['FlightId'] }}">
                                    <input type="hidden" name="twoway_flightid">
                                    <button
                                        class="btn_onewayclick px-3 py-2 bg-primary text-white rounded-md text-xs md:px-4 md:py-2 md:text-sm book-btn"
                                        type="submit">Book
                                        Now</button>
                                </form>
                            @else
                                <button
                                    class="dep_btnfirst flight-select stretched-link px-3 py-2 bg-primary text-white rounded-md text-xs md:px-4 md:py-2 md:text-sm book-btn">Select
                                    Flight</button>
                                <button
                                    class="hidden dep_btnsecond flight-select px-3 py-2 bg-primary-lighter text-white rounded-md text-xs md:px-4 md:py-2 md:text-sm book-btn stretched-link">Selected
                                    Flight</button>
                            @endif

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@else
    <h2 class="text-2xl text-secondary text-center"><i class="fa-solid fa-plane-slash me-3"></i>No Flights Found</h2>
@endif

@if ($data['type'] == 'R')

    <div class="day-tracker pb-4 mt-5">
        <div class="bg-primary px-3 text-white text-base font-medium tracking-wider py-4 rounded-md relative">
            Arrival Flights:
            <span class="text-white font-semibold text-lg">
                {{ $data['to'] }} - {{ $data['from'] }}
            </span>
            ({{ date('m/d/Y', strtotime($data['returnDate'])) }})

        </div>
    </div>

    @if (count($flights['Inbound']['Availability'] ?? []))

        <div class="detail-list domestic-detail-list">
            @foreach ($flights['Inbound']['Availability'] ?? [] as $inbound)
                <div class="inbound_flight domestic-detail-wrap relative py-2 border rounded-md flight-item bg-white"
                    data-flightid="{{ $inbound['FlightId'] }}"
                    data-amount="{{ $inbound['TotalAmount'] - $inbound['Discount'] }}"
                    data-logo="{{ asset('uploads/domestic/airlines/' . $airData[$inbound['Airline']]) }}"
                    data-flightno="{{ $inbound['FlightNo'] }}" data-time="{{ $inbound['DepartureTime'] }}"
                    data-price="{{ $inbound['TotalAmount'] - $inbound['Discount'] }}"
                    data-airline="{{ $inbound['Airline'] }}"
                    data-airline-fullname="{{ airlinesFullName($inbound['Airline']) }}"
                    data-details-inbound="{{ encrypt($inbound) }}" data-refundable="{{ $inbound['Refundable'] }}"
                    data-departure_time="{{ $inbound['DepartureTime'] }}">
                    <div class="flight-container flex w-full p-[12px] sm:px-[16px] sm:py-[12px]">
                        <div class="flights-details flex-grow ">
                            <div class="flight-details-bottom flex items-center justify-between mt-2">
                                <div
                                    class="logo-wrap flex flex-col items-center justify-center gap-[4px] xs:gap-[8px] sm:gap-[12px] ml-0 xs:ml-1 sm:ml-[1rem]">
                                    <img class="airline-logo h-[24px] sm:h-[32px] object-contain"
                                        src="{{ asset('uploads/domestic/airlines/' . $airData[$inbound['Airline']]) }}">
                                    <!-- <p class="text-sm font-semibold xsm:text-base md:text-xl w-[65px] xs:w-auto">BUDDHA AIRLINES</p> -->
                                    <p class="text-[10px] font-medium md:font-normal md:text-xs text-[#EA2127]">
                                        {{ $inbound['FlightNo'] }}
                                    </p>
                                </div>
                                <div
                                    class="arrival-departure flex justify-center items-center ml-1 xxs:ml-2 xsm:ml-[2rem]">
                                    <div class="departure flex flex-col gap-1">
                                        <div class="text-sm font-semibold sm:text-base md:text-xl departure-time">
                                            {{ $inbound['DepartureTime'] }}
                                        </div>
                                        <div class="text-xs font-semibold sm:text-sm">
                                            {{ $inbound['Departure'] }}
                                        </div>
                                    </div>
                                    <img class="mx-[2px] xs:mx-2 w-[60px] xxs:w-[75px] sm:w-[80px] md:w-[100px]"
                                        src="{{ asset('frontend/images/flight-progress.png') }}" alt="">
                                    <div class="arrival flex flex-col gap-1">
                                        <div class="text-sm font-semibold sm:text-base md:text-xl departure-time">
                                            {{ $inbound['ArrivalTime'] }}
                                        </div>
                                        <div class="text-xs font-semibold sm:text-sm">
                                            {{ $inbound['Arrival'] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="duration flex flex-col gap-1">
                                    <p class="text-gray-500 font-medium">Duration</p>
                                    <div class="flex gap-1 items-center text-gray-500"><i
                                            class="fa-regular fa-clock"></i>
                                        <p>{{ timeCalculation($inbound['DepartureTime'], $inbound['ArrivalTime']) }}
                                        </p>
                                    </div>
                                </div>
                                <div class="duration flex flex-col gap-1">
                                    <p class="text-gray-500 font-medium">Luggage</p>
                                    <div class="flex gap-1 items-center text-gray-500"><i
                                            class="fa-solid fa-suitcase-rolling"></i>
                                        <p>{{ $inbound['FreeBaggage'] }}</p>
                                    </div>
                                </div>
                                <div class="min-w-[118px]">

                                    {{-- <p class="text-[12px] text-left xxs:text-xs md:text-sm text-secondary ">
                                        {{ $inbound['Refundable'] == 'T' ? 'Refundable' : 'Non-Refundable' }}
                                    </p> --}}
                                    <div class="flex flex-col gap-1 p-4">
                                        @if ($inbound['Discount'] > 0)
                                            <div class="flex items-center gap-1 italic">
                                                <p class="text-xs font-medium text-gray-700">Cash Back: </p>
                                                <p class="text-xs font-semibold text-green-600"> Rs
                                                    {{ $inbound['Discount'] }}
                                                </p>

                                            </div>
                                        @endif

                                        <p class="text-[12px] text-right xxs:text-xs md:text-sm text-secondary">
                                            {{ $inbound['Refundable'] == 'T' ? 'Refundable' : 'Non-Refundable' }}
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div
                            class="flights-pricing flex flex-col gap-1 justify-center h-full items-center ml-2 sm:ml-[16px]">
                            <div class="flex flex-col text-secondary ">
                                <p class="new-price font-medium text-xs md:text-base">{{ $inbound['Currency'] }}
                                    {{ ceil($inbound['TotalAmount'] - $inbound['Discount']) }}
                                </p>
                                @if ($inbound['Discount'] > 0)
                                    <s class="text-xs font-medium md:text-base text-gray-500">{{ $inbound['Currency'] }}
                                        {{ ceil($inbound['TotalAmount']) }}</s>
                                @endif
                            </div>
                            <button
                                class="arr_btnfirst flight-select stretched-link px-3 py-2 bg-primary text-white rounded-md text-xs md:px-4 md:py-2 md:text-sm book-btn">Select
                                Flight</button>
                            <button
                                class="hidden arr_btnsecond flight-select px-3 py-2 bg-primary-lighter text-white rounded-md text-xs md:px-4 md:py-2 md:text-sm book-btn stretched-link">Selected
                                Flight</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <h2 class="text-2xl text-secondary text-center"><i class="fa-solid fa-plane-slash me-3"></i>No Flights Found
        </h2>
    @endif
@endif

<script>
    $('#outboundflight_view').click(function(e) {
        outbound();
    })
    $('.outbound-detail-list').click(function(e) {
        outbound()
    })

    function outbound() {
        if ($('#outboundflight_data').is(":visible")) {

            $('#down-arrow').show();
            $('#up-arrow').hide();
            // Animate the element to collapse (hide it with the "down to up" effect)
            $('#outboundflight_data').animate({
                height: "0px",
                paddingTop: "0px",
                paddingBottom: "0px"
            }, 1000, function() {
                $('#outboundflight_data').hide(); // Hide the element after the animation is finished
            });
        } else {
            $('#down-arrow').hide();
            $('#up-arrow').show();
            // Show the element with the "up to down" effect
            $('#outboundflight_data').show().animate({
                height: $('#outboundflight_data')[0].scrollHeight, // You can adjust this to your desired height
                paddingTop: "initial",
                paddingBottom: "initial"
            }, 1000);
        }
    }

    $('.btn_onewayclick').click(function() {
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
    })
</script>
