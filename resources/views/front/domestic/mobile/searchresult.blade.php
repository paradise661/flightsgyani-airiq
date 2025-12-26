<div class="block md:hidden">
    @include('front.domestic.mobile.modify')
    <section class="results mt-3 px-2">
        <div class="container mx-auto">
            <!-- Two Way Result  -->
            <div class="departure">
                <div class="bg-primary px-3 text-white text-xs font-medium tracking-wider py-4 rounded-md relative flex justify-between"
                    id="outboundflight_view_mobile">
                    <span>
                        Departure Flights:
                        <span class="text-white font-semibold text-sm">
                            {{ $data['from'] }} - {{ $data['to'] }}
                        </span>
                        ({{ date('m/d/Y', strtotime($data['flightDate'])) }})
                    </span>
                    <span class="">
                        <svg class="hs-dropdown-open:rotate-180 size-4 hidden" id="down-arrow-mobile" width="16"
                            height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                        </svg>
                        <svg class="hs-dropdown-open:rotate-180 size-4" id="up-arrow-mobile" width="16"
                            height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 11L8.16086 5.3131C8.35239 5.1363 8.64761 5.1363 8.83914 5.3131L15 11"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                        </svg>

                    </span>
                </div>

                <div id="{{ $data['type'] == 'R' ? 'outboundflight_data_mobile' : '' }}">
                    <div
                        class="{{ $data['type'] == 'R' ? 'max-h-[300px]' : 'max-h-[500px]' }} flex flex-col gap-2 mt-2  overflow-y-auto">

                        @if (count($flights['Outbound']['Availability'] ?? []))
                            @foreach ($flights['Outbound']['Availability'] ?? [] as $outbound)
                                <div class="{{ $data['type'] == 'R' ? 'outbound-detail-list-mobile' : '' }} result-card mobile_outbound_flight flight-item-mobile"
                                    data-flightid="{{ $outbound['FlightId'] }}"
                                    data-amount="{{ $outbound['TotalAmount'] - $outbound['Discount'] }}"
                                    data-logo="{{ asset('uploads/domestic/airlines/' . $airData[$outbound['Airline']]) }}"
                                    data-flightno="{{ $outbound['FlightNo'] }}"
                                    data-time="{{ $outbound['DepartureTime'] }}"
                                    data-price="{{ $outbound['TotalAmount'] - $outbound['Discount'] }}"
                                    data-airline="{{ $outbound['Airline'] }}"
                                    data-airline-fullname="{{ airlinesFullName($outbound['Airline']) }}"
                                    data-details-outbound="{{ encrypt($outbound) }}"
                                    data-refundable="{{ $outbound['Refundable'] }}"
                                    data-departure_time="{{ $outbound['DepartureTime'] }}">
                                    <div class="px-3 py-2 border border-primary rounded-lg flex items-center relative">
                                        <div
                                            class="r-domestic-details border-e-2 border-gray-400 pe-2 flex flex-col flex-grow">
                                            <div
                                                class="r-domestic-details-top flex items-center justify-between gap-3 w-full">
                                                <div>

                                                    <p class="text-xs font-normal text-secondary">
                                                        {{ $outbound['Refundable'] == 'T' ? 'Refundable' : 'Non-Refundable' }}
                                                    </p>
                                                </div>
                                                @if ($outbound['Discount'])
                                                    <div class="flex items-center gap-1 italic">
                                                        <p class="text-xs font-medium text-gray-700">Cash Back: </p>
                                                        <p class="text-xs font-semibold text-green-600"> Rs
                                                            {{ $outbound['Discount'] }}
                                                        </p>

                                                    </div>
                                                @endif
                                            </div>
                                            <div class="r-domestic-details-bottom flex items-center gap-2">
                                                <div class="flex items-center flex-col gap-2">
                                                    <img class="h-[32px] "
                                                        src="{{ asset('uploads/domestic/airlines/' . $airData[$outbound['Airline']]) }}"
                                                        alt="">
                                                    <p class="text-xs font-normal text-secondary">
                                                        {{ $outbound['FlightNo'] }}
                                                    </p>
                                                </div>
                                                <div
                                                    class="arrival-departure flex justify-center items-center flex-grow">
                                                    <div class="departure flex flex-col gap-1">
                                                        <div class="text-xs font-semibold departure-time">
                                                            {{ $outbound['DepartureTime'] }}
                                                        </div>
                                                        <div class="text-xs font-semibold">
                                                            {{ $data['from'] }}
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="w-full h-full flex flex-col items-center justify-center">
                                                        <div
                                                            class=" pb-1 border-b-2 w-4/5 border-dashed border-primary text-gray-600 font-medium relative">
                                                            <div
                                                                class="flex gap-1 items-center justify-center text-gray-500">
                                                                <i class="fa-regular fa-clock text-xs"></i>
                                                                <p class="text-xs">
                                                                    {{ timeCalculation($outbound['DepartureTime'], $outbound['ArrivalTime']) }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class=" text-center w-4/5 pt-1 text-gray-400 font-medium">
                                                            <div
                                                                class="flex gap-1 items-center justify-center text-gray-500">
                                                                <i class="fa-solid fa-suitcase-rolling text-xs"></i>
                                                                <p class="text-xs">{{ $outbound['FreeBaggage'] }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="arrival flex flex-col gap-1">
                                                        <div class="text-xs font-semibold departure-time">
                                                            {{ $outbound['ArrivalTime'] }}
                                                        </div>
                                                        <div class="text-xs font-semibold">
                                                            {{ $data['to'] }}
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                        <div class="r-pricing-details min-w-fit ms-2">
                                            <div class="flex flex-col gap-1 text-xs font-semibold items-center">
                                                <p>{{ $outbound['Currency'] }}
                                                    {{ ceil($outbound['TotalAmount'] - $outbound['Discount']) }}</p>
                                                @if ($outbound['Discount'] > 0)
                                                    <s class="text-secondary">{{ $outbound['Currency'] }}
                                                        {{ ceil($outbound['TotalAmount']) }}</s>
                                                @endif

                                                @if ($data['type'] == 'O')
                                                    <form action="{{ route('domesticflights.passengerdetails') }}"
                                                        method="POST">
                                                        @csrf
                                                        <input id="" type="hidden"
                                                            name="selectedoutboundflightdetails"
                                                            value="{{ encrypt($outbound) }}">
                                                        <input type="hidden" name="oneway_flightid"
                                                            value="{{ $outbound['FlightId'] }}">
                                                        <input type="hidden" name="twoway_flightid">
                                                        <button
                                                            class="btn_onewayclick px-3 py-2 bg-primary text-white rounded-md text-xs md:px-4 md:py-2 md:text-sm book-btn"
                                                            type="submit">Book
                                                            Now</button>
                                                    </form>
                                                @else
                                                    <button
                                                        class="dep_btnfirst_mobile px-3 py-2 bg-primary text-white rounded-md text-xs book-btn dep_btnfirst flight-select stretched-link ">Select</button>
                                                    <button
                                                        class="dep_btnsecond_mobile hidden px-3 py-2 bg-primary-lighter text-white rounded-md text-xs book-btn dep_btnfirst flight-select stretched-link ">Selected</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <h2 class="text-2xl text-secondary text-center"><i
                                    class="fa-solid fa-plane-slash me-3"></i>No
                                Flights Found</h2>
                        @endif
                    </div>
                </div>

            </div>
            @if ($data['type'] == 'R')
                <div class="arrival mt-4">
                    <div
                        class="bg-primary px-3 text-white text-xs font-medium tracking-wider py-4 rounded-md relative flex">
                        <span>
                            Arrival Flights:
                            <span class="text-white font-semibold text-sm">
                                {{ $data['to'] }} - {{ $data['from'] }}
                            </span>
                            ({{ date('m/d/Y', strtotime($data['returnDate'])) }})
                        </span>
                    </div>

                    <div class="flex flex-col gap-2 mt-2 max-h-[300px] overflow-y-auto">
                        @if (count($flights['Inbound']['Availability'] ?? []))
                            @foreach ($flights['Inbound']['Availability'] ?? [] as $inbound)
                                <div class="result-card mobile_inbound_flight flight-item-mobile"
                                    data-flightid="{{ $inbound['FlightId'] }}"
                                    data-amount="{{ $inbound['TotalAmount'] - $inbound['Discount'] }}"
                                    data-logo="{{ asset('uploads/domestic/airlines/' . $airData[$inbound['Airline']]) }}"
                                    data-flightno="{{ $inbound['FlightNo'] }}"
                                    data-time="{{ $inbound['DepartureTime'] }}"
                                    data-price="{{ $inbound['TotalAmount'] - $inbound['Discount'] }}"
                                    data-airline="{{ $inbound['Airline'] }}"
                                    data-airline-fullname="{{ airlinesFullName($inbound['Airline']) }}"
                                    data-details-inbound="{{ encrypt($inbound) }}"
                                    data-refundable="{{ $inbound['Refundable'] }}"
                                    data-departure_time="{{ $inbound['DepartureTime'] }}">
                                    <div class="px-3 py-2 border border-primary rounded-lg flex items-center relative">
                                        <div
                                            class="r-domestic-details border-e-2 border-gray-400 pe-2 flex flex-col flex-grow">
                                            <div
                                                class="r-domestic-details-top flex items-center justify-between gap-3 w-full">
                                                <div>
                                                    <p class="text-xs font-normal text-secondary">
                                                        {{ $inbound['Refundable'] == 'T' ? 'Refundable' : 'Non-Refundable' }}
                                                    </p>
                                                </div>
                                                @if ($inbound['Discount'])
                                                    <div class="flex items-center gap-1 italic">
                                                        <p class="text-xs font-medium text-gray-700">Cash Back: </p>
                                                        <p class="text-xs font-semibold text-green-600"> Rs
                                                            {{ $inbound['Discount'] }}
                                                        </p>

                                                    </div>
                                                @endif
                                            </div>
                                            <div class="r-domestic-details-bottom flex items-center gap-2">
                                                <div class="flex items-center flex-col gap-2">
                                                    <img class="h-[32px] "
                                                        src="{{ asset('uploads/domestic/airlines/' . $airData[$inbound['Airline']]) }}"
                                                        alt="">
                                                    <p class="text-xs font-normal text-secondary">
                                                        {{ $inbound['FlightNo'] }}
                                                    </p>
                                                </div>
                                                <div
                                                    class="arrival-departure flex justify-center items-center flex-grow">
                                                    <div class="departure flex flex-col gap-1">
                                                        <div class="text-xs font-semibold departure-time">
                                                            {{ $inbound['DepartureTime'] }}
                                                        </div>
                                                        <div class="text-xs font-semibold">
                                                            {{ $data['to'] }}
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="w-full h-full flex flex-col items-center justify-center">
                                                        <div
                                                            class=" pb-1 border-b-2 w-4/5 border-dashed border-primary text-gray-600 font-medium relative">
                                                            <div
                                                                class="flex gap-1 items-center justify-center text-gray-500">
                                                                <i class="fa-regular fa-clock text-xs"></i>
                                                                <p class="text-xs">
                                                                    {{ timeCalculation($inbound['DepartureTime'], $inbound['ArrivalTime']) }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class=" text-center w-4/5 pt-1 text-gray-400 font-medium">
                                                            <div
                                                                class="flex gap-1 items-center justify-center text-gray-500">
                                                                <i class="fa-solid fa-suitcase-rolling text-xs"></i>
                                                                <p class="text-xs">{{ $inbound['FreeBaggage'] }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="arrival flex flex-col gap-1">
                                                        <div class="text-xs font-semibold departure-time">
                                                            {{ $inbound['ArrivalTime'] }}
                                                        </div>
                                                        <div class="text-xs font-semibold">
                                                            {{ $data['from'] }}
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                        <div class="r-pricing-details min-w-fit ms-2">
                                            <div class="flex flex-col gap-1 text-xs font-semibold items-center">
                                                <p>{{ $inbound['Currency'] }}
                                                    {{ ceil($inbound['TotalAmount'] - $inbound['Discount']) }}</p>
                                                @if ($inbound['Discount'] > 0)
                                                    <s class="text-secondary">{{ $inbound['Currency'] }}
                                                        {{ ceil($inbound['TotalAmount']) }}</s>
                                                @endif

                                                <button
                                                    class="arr_btnfirst_mobile px-3 py-2 bg-primary text-white rounded-md text-xs book-btn dep_btnfirst flight-select stretched-link ">Select</button>
                                                <button
                                                    class="arr_btnsecond_mobile hidden px-3 py-2 bg-primary-lighter text-white rounded-md text-xs book-btn dep_btnfirst flight-select stretched-link ">Selected</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <h2 class="text-2xl text-secondary text-center"><i
                                    class="fa-solid fa-plane-slash me-3"></i>No Flights Found
                            </h2>
                        @endif
                    </div>

                </div>
            @endif

            <!-- / Two Way Result  -->
        </div>
    </section>
</div>

<div
    class="hidden round-book-details round-book-small fixed bottom-0 bg-white py-3 w-full border-t border-primary z-[999999]">
    <div class="container mx-auto">
        <div class="flex justify-between px-2">
            <div class="domestic-round-departure-view domestic_mobile_outbound_view hidden">
                <div class="domestic-round-departure flex gap-2 justify-between">
                    <!-- <img class="w-[45px] xl:w-[65px] h-[32px] xl:h-[50px] mt-1  md:block" id="dep_airline_logo_mobile" src="{{ asset('frontend/images/emirates.png') }}"> -->
                    <div class="flex flex-col gap-1">
                        <h4 class="text-sm font-semibold">Departure Flight</h4>
                        <h4 class="text-xs font-medium" id="dep_ariline_name_mobile">Buddha Airlines</h4>
                        <!-- <h6 class="uppercase text-sm font-medium" id="dep_ariline_name_mobile">buddha airlines</h6> -->
                        <div class="flex gap-3 text-xs font-normal">
                            <p>{{ date('Y-m-d', strtotime($data['flightDate'])) }}</p>
                            <p id="dep_airline_time_mobile">20:24</p>
                        </div>
                    </div>
                    <!-- <div class="flex flex-col justify-between text-sm py-1 font-normal">
                        <p class="text-secondary" id="dep_flightid_mobile">U4665</p>
                        <p id="dep_airline_price_mobile">NPR 3,576</p>
                    </div> -->
                </div>
            </div>
            <div class="domestic-round-return-view domestic_mobile_inbound_view hidden">
                <div class="domestic-round-return flex gap-2 justify-between">
                    <!-- <img class="w-[45px] xl:w-[65px] h-[32px] xl:h-[50px] mt-1  md:block" id="arr_airline_logo_mobile" src="{{ asset('frontend/images/emirates.png') }}"> -->
                    <div class="flex flex-col gap-1">
                        <h4 class="text-sm font-semibold">Arrival Flight</h4>
                        <h4 class="text-xs font-medium" id="arr_ariline_name_mobile">Buddha Airlines</h4>
                        <!-- <h6 class="uppercase text-sm font-medium" id="arr_ariline_name_mobile">buddha airlines</h6> -->
                        <div class="flex gap-3 text-xs font-normal">
                            <p>{{ date('Y-m-d', strtotime($data['returnDate'])) }}</p>
                            <p id="arr_airline_time_mobile">20:24</p>
                        </div>
                    </div>
                    <!-- <div class="flex flex-col justify-between text-sm py-1 font-normal">
                        <p class="text-secondary" id="arr_flightid_mobile">U4665</p>
                        <p id="arr_airline_price_mobile">NPR 3,576</p>
                    </div> -->
                </div>
            </div>

            <div class="domestic-round-book flex flex-col justify-between items-center ">
                <h4 class="text-lg font-medium">NPR <span id="totalPriceMobile"></span></h4>
                <form action="{{ route('domesticflights.passengerdetails') }}" method="POST">
                    @csrf
                    <input id="oneway_flightid_mobile" type="hidden" name="oneway_flightid">
                    <input id="twoway_flightid_mobile" type="hidden" name="twoway_flightid">
                    <input id="selectedoutboundflightdetails_mobile" type="hidden"
                        name="selectedoutboundflightdetails" value="">
                    <input id="selectedinboundflightdetails_mobile" type="hidden"
                        name="selectedinboundflightdetails" value="">
                    <button class="text-white bg-secondary px-3 py-2 text-sm font-medium rounded-md"
                        id="btn_booknow_mobile">Book
                        Now</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    var depPriceMobile = 0;
    var arrPriceMobile = 0;
    $(document).on('click', '.mobile_outbound_flight', function(e) {
        // alert("yes")
        $('.domestic_mobile_outbound_view').show();
        $('.mobile_outbound_flight').addClass('bg-white').removeClass('border-primary bg-primary-background');
        $(this).removeClass('bg-white').addClass('border-primary bg-primary-background');
        $('.dep_btnfirst_mobile').show();
        $('.dep_btnsecond_mobile').hide();
        $(this).find('.dep_btnfirst_mobile').hide();
        $(this).find('.dep_btnsecond_mobile').show();

        $('#dep_airline_logo_mobile').attr('src', $(this).attr('data-logo'));
        $('#dep_flightid_mobile').html($(this).attr('data-flightno'));
        $('#dep_ariline_name_mobile').html($(this).attr('data-airline-fullname'));
        $('#dep_airline_time_mobile').html($(this).attr('data-time'));
        $('#dep_airline_price_mobile').html('NPR ' + $(this).attr('data-price'));
        depPriceMobile = $(this).attr('data-amount');
        calculateFullPriceMobile();

        $('#oneway_flightid_mobile').val($(this).attr('data-flightid'));
        $('#selectedoutboundflightdetails_mobile').val($(this).attr('data-details-outbound'));
    })

    $(document).on('click', '.mobile_inbound_flight', function(e) {
        // alert("yes")
        $('.domestic_mobile_inbound_view').show();
        $('.mobile_inbound_flight').addClass('bg-white').removeClass('border-primary bg-primary-background');
        $(this).removeClass('bg-white').addClass('border-primary bg-primary-background');
        $('.arr_btnfirst_mobile').show();
        $('.arr_btnsecond_mobile').hide();
        $(this).find('.arr_btnfirst_mobile').hide();
        $(this).find('.arr_btnsecond_mobile').show();

        $('#arr_airline_logo_mobile').attr('src', $(this).attr('data-logo'));
        $('#arr_flightid_mobile').html($(this).attr('data-flightno'));
        $('#arr_ariline_name_mobile').html($(this).attr('data-airline-fullname'));
        $('#arr_airline_time_mobile').html($(this).attr('data-time'));
        $('#arr_airline_price_mobile').html('NPR ' + $(this).attr('data-price'));

        arrPriceMobile = $(this).attr('data-amount');
        calculateFullPriceMobile();

        $('#twoway_flightid_mobile').val($(this).attr('data-flightid'));
        $('#selectedinboundflightdetails_mobile').val($(this).attr('data-details-inbound'));
    })

    function calculateFullPriceMobile() {
        let priceMobile = Number(depPriceMobile) + Number(arrPriceMobile);
        $('#totalPriceMobile').html(Math.ceil(priceMobile))
    }

    $('#outboundflight_view_mobile').click(function(e) {
        outboundMobile();
    })
    $('.outbound-detail-list-mobile').click(function(e) {
        outboundMobile()
    })

    function outboundMobile() {
        if ($('#outboundflight_data_mobile').is(":visible")) {

            $('#down-arrow-mobile').show();
            $('#up-arrow-mobile').hide();
            // Animate the element to collapse (hide it with the "down to up" effect)
            $('#outboundflight_data_mobile').animate({
                height: "0px",
                paddingTop: "0px",
                paddingBottom: "0px"
            }, 1000, function() {
                $('#outboundflight_data_mobile').hide(); // Hide the element after the animation is finished
            });
        } else {
            $('#down-arrow-mobile').hide();
            $('#up-arrow-mobile').show();
            // Show the element with the "up to down" effect
            $('#outboundflight_data_mobile').show().animate({
                height: $('#outboundflight_data_mobile')[0]
                    .scrollHeight, // You can adjust this to your desired height
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

    $('#btn_booknow_mobile').click(function(e) {
        e.preventDefault();
        if ($('#oneway_flightid_mobile').val() && $('#twoway_flightid_mobile').val()) {
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

    $(document).ready(function() {
        // Function to filter the flight list based on selected filters
        function filterFlightsMobile() {
            var selectedFilters = {};

            // Collect selected filters from the checkboxes
            $('.filter-checkbox_mobile:checked').each(function() {
                var filterType = $(this).data('filter');
                var filterValue = $(this).val();

                // Initialize the array if it doesn't exist
                if (!selectedFilters[filterType]) {
                    selectedFilters[filterType] = [];
                }
                selectedFilters[filterType].push(filterValue);
            });

            // Show or hide flights based on the selected filters
            $('.flight-item-mobile').each(function() {
                var flight = $(this);
                var flightAirline = flight.data('airline');
                var flightRefundable = flight.data('refundable');
                var flightDepartureTime = flight.data('departure_time'); // e.g., "06:30"

                // Convert flight's departure time to minutes
                var flightDepartureTimeInMinutes = timeToMinutes(flightDepartureTime);

                var matchesAirline = !selectedFilters['airline'] || selectedFilters['airline'].includes(
                    flightAirline);
                var matchesRefundable = !selectedFilters['refundable'] || selectedFilters['refundable']
                    .includes(flightRefundable);

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

                // If a flight matches all the selected filters, show it; otherwise, hide it
                if (matchesAirline && matchesRefundable && matchesDepartureTime) {
                    flight.show();
                } else {
                    flight.hide();
                }
            });
        }

        // Bind the filter function to checkbox changes
        $('.filter-checkbox_mobile').on('change', function() {
            filterFlightsMobile();
            // $('#btn_filter_mobile').click();
        });

        // Initial filter call to apply any filters already selected (if the page is reloaded with some filters selected)
        filterFlightsMobile();
    });
</script>
