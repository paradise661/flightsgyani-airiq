<div class=" flex border-e">
    <div class="hs-dropdown relative inline-flex [--auto-close:inside] w-[270px] multi-dep-drop"
        id="international-departure-drop-{{ $iteration }}">
        <div class="innercol hs-dropdwon-toggle" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
            <p class="font-semibold text-xs text-gray-400">FROM</p>
            <input id="multiFromCity{{ $iteration }}" type="hidden" name="depcity" value="" />
            <input id="multiFromAirport{{ $iteration }}" type="hidden" name="int_multi_from[]" value="" />

            <div class="text-2xl font-semibold d-depcity-{{ $iteration }}" id="d-depcity-{{ $iteration }}"> <span
                    class="text-muted text-sm"></span> KTM </div>
            <div class="font-medium text-xs d-depairport-{{ $iteration }}" id="d-depairport-{{ $iteration }}">
                KTM- Tribhuvan,Kathmandu-Nepal </div>

        </div>
        <div class="!absolute px-4 py-3 z-50 hs-dropdown-menu search-d-transform duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-72 bg-white shadow-md rounded-lg mt-2 top-0"
            role="menu" aria-orientation="vertical" aria-labelledby="international-departure-drop">
            <div class="w-full flex justify-between items-center">
                <h4>Flying From</h4>
            </div>
            <div class="relative mt-2">
                <div class="widget__input">
                    <input
                        class="peer py-3 px-4 ps-11 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none multi-city-dep-typeahead"
                        id="multiCityDepInput{{ $iteration }}" data-index="{{ $iteration }}" type="text"
                        value="{{ old('departure') }}" placeholder="Origin Airport" autofocus />
                    @if ($errors->has('departure'))
                        <span class="error">
                            {{ $errors->first('departure') }}
                        </span>
                    @endif

                </div>
                <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4 peer-disabled:opacity-50 peer-disabled:pointer-events-none"
                    style="height:44px;">
                    <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M12 21C15.5 17.4 19 14.1764 19 10.2C19 6.22355 15.866 3 12 3C8.13401 3 5 6.22355 5 10.2C5 14.1764 8.5 17.4 12 21Z"
                                stroke="#929292" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                            <path
                                d="M12 12C13.1046 12 14 11.1046 14 10C14 8.89543 13.1046 8 12 8C10.8954 8 10 8.89543 10 10C10 11.1046 10.8954 12 12 12Z"
                                stroke="#929292" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                        </g>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>
<div class=" flex border-e">
    <div class="hs-dropdown relative inline-flex [--auto-close:inside] w-[270px] multi-dest-drop"
        id="international-destination-drop-{{ $iteration }}">
        <div class="innercol hs-dropdwon-toggle" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
            <p class="font-semibold text-xs text-gray-400">TO</p>
            <input id="multiToCity{{ $iteration }}" type="hidden" name="destinationcity" value="" />
            <input id="multiToAirport{{ $iteration }}" type="hidden" name="int_multi_to[]" value="" />

            <div class="text-2xl font-semibold d-arrcity-{{ $iteration }}" id="d-arrcity-{{ $iteration }}">
                <span class="text-muted text-sm"></span> DEL
            </div>
            <div class="font-medium text-xs d-arrairport-{{ $iteration }}" id="d-arrairport-{{ $iteration }}">
                DEL- Indira Gandhi International,Delhi-India</div>
        </div>
        <div class="!absolute !-left-[300px]  px-4 py-3 z-50 hs-dropdown-menu search-t-transform duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-72 bg-white shadow-md rounded-lg mt-2 top-0"
            role="menu" aria-orientation="vertical" aria-labelledby="international-destination-drop">
            <div class="w-full flex justify-between items-center">
                <h4>Flying To</h4>
            </div>
            <div class="relative mt-2">
                <input
                    class="peer py-3 px-4 ps-11 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none multi-city-dest-typeahead"
                    id="multiCityDestInput{{ $iteration }}" data-index="{{ $iteration }}" type="text"
                    value="{{ old('destination') }}" placeholder="Destination Airport">
                <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4 peer-disabled:opacity-50 peer-disabled:pointer-events-none"
                    style="height:44px;">
                    <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M12 21C15.5 17.4 19 14.1764 19 10.2C19 6.22355 15.866 3 12 3C8.13401 3 5 6.22355 5 10.2C5 14.1764 8.5 17.4 12 21Z"
                                stroke="#929292" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                            <path
                                d="M12 12C13.1046 12 14 11.1046 14 10C14 8.89543 13.1046 8 12 8C10.8954 8 10 8.89543 10 10C10 11.1046 10.8954 12 12 12Z"
                                stroke="#929292" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                        </g>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>
<div class=" flex border-e depdate_col ">
    <div class="innercol">
        <p class="font-semibold text-xs text-gray-400">
            DEPARTURE DATE
        </p>
        <div class="flex items-center">
            <input
                class="multidepdate peer px-0 block w-full bg-transparent border-0 text-base text-black font-semibold disabled:opacity-50 disabled:pointer-events-none tracking-wide focus:shadow-none focus:ring-0"
                type="text" name="int_multi_departure[]" placeholder="yyyy-mm-dd" autocomplete="off" />
            <img class="w-[17px] h-[17px] float-right mt-[8px]" src="{{ asset('images/icons/calendar.svg') }}"
                alt="" />
        </div>

        <!-- <p class="font-medium text-xs">Saturday</p> -->
    </div>
</div>

<script>
    $(function() {
        $("#depdate").datepicker({
            minDate: "0",
            dateFormat: "yy-mm-dd",
            onSelect: function(date) {
                $('[name="flightdate"]').val(date);
                $(".multidepdate").datepicker("option", "minDate", date);
                $("#returndate").datepicker("option", "minDate", date);
            },
        });

        $(".multidepdate").datepicker({
            minDate: "0",
            format: "yyyy-mm-dd",
            startDate: "today",
            dateFormat: "yy-mm-dd",
            autoclose: true,
            todayHighlight: true,
            toggleActive: true,
            onSelect: function(selectedDate) {
                updateMinDate()
            },
        });
    })

    function updateMinDate() {
        var datepickers = $('.multidepdate'); // Get all datepickers

        // Loop through all datepickers
        datepickers.each(function(index) {
            var currentValue = $(this).val(); // Get the value of the current datepicker

            // Loop through future datepickers and set their min date
            datepickers.each(function(futureIndex) {
                if (futureIndex > index && currentValue) {
                    // Only set minDate for datepickers after the current one
                    $(this).datepicker('option', 'minDate', currentValue);
                }
            });
        });
    }
</script>
