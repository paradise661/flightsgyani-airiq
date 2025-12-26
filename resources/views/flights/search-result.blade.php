@extends('layouts.front')
@section('title')
    Available Flights
@endsection
@section('body')
    {{-- New Design --}}
    @php
        $removeAirlines = ['AC'];
    @endphp

    @include('front.includes.searchresultpage.modifysearch')

    {{-- Main Search Result Content --}}
    <div class="page-content hidden md:block">
        <div class="container mx-auto">
            <div class="grid grid-cols-4 gap-4 mt-6">
                <div class="filters-sidebar hidden md:block ">
                    <div class="drop-shadow-sm bg-secondary-lighter px-4 py-5 rounded-lg filter-call sticky top-0"
                        data-type="desktop">
                        <h4 class="text-xl font-semibold tracking-widest px-5 mb-5 text-secondary">
                            Filters
                        </h4>
                        <div class="hs-accordion-group mb-4">
                            <div class="hs-accordion hs-accordion-active:border-gray-200 active bg-white border border-transparent rounded-xl"
                                id="hs-active-bordered-heading-two">
                                <button
                                    class="hs-accordion-toggle hs-accordion-active:text-primary inline-flex justify-between items-center gap-x-3 w-full font-semibold text-start text-gray-800 py-4 px-5 hover:text-gray-500 disabled:opacity-50 disabled:pointer-events-none"
                                    aria-expanded="true" aria-controls="depart-collapse">
                                    Stops
                                    <svg class="hs-accordion-active:hidden block size-3.5"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M5 12h14"></path>
                                        <path d="M12 5v14"></path>
                                    </svg>
                                    <svg class="hs-accordion-active:block hidden size-3.5"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M5 12h14"></path>
                                    </svg>
                                </button>
                                <div class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                                    id="depart-collapse" role="region" aria-labelledby="hs-active-bordered-heading-two">
                                    <div class="pb-4 px-5">
                                        <div class="flex py-1">
                                            <input
                                                class="shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none stop"
                                                id="stop-zero" type="checkbox" name="stop[]" value="0">
                                            <label class="text-base text-gray-500 ms-3" for="stop-zero">
                                                0 Stop(s)
                                            </label>
                                        </div>
                                        <div class="flex py-1">
                                            <input
                                                class="shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none stop"
                                                id="stop-one" type="checkbox" name="stop[]" value="1">
                                            <label class="text-base text-gray-500 ms-3" for="stop-one">
                                                1 Stop(s)
                                            </label>
                                        </div>
                                        <div class="flex py-1">
                                            <input
                                                class="shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none stop"
                                                id="stop-two" type="checkbox" name="stop[]" value="2">
                                            <label class="text-base text-gray-500 ms-3" for="stop-two">
                                                2 Stop(s)
                                            </label>
                                        </div>
                                        <div class="flex py-1">
                                            <input
                                                class="shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none stop"
                                                id="stop-two-plus" type="checkbox" name="stop[]" value="2+">
                                            <label class="text-base text-gray-500 ms-3" for="stop-two-plus">
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
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M5 12h14"></path>
                                        <path d="M12 5v14"></path>
                                    </svg>
                                    <svg class="hs-accordion-active:block hidden size-3.5"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M5 12h14"></path>
                                    </svg>
                                </button>
                                <div class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                                    id="airlies-collapse" role="region" aria-labelledby="hs-active-bordered-heading-two">
                                    <div class="pb-4 px-5">
                                        <div class="flex py-1">
                                            <input
                                                class="shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none"
                                                id="airline-all" type="checkbox" name="air">
                                            <label class="text-base text-gray-500 ms-3" for="airline-all">All
                                                Airlines</label>
                                        </div>
                                        @if ($airlines)
                                            @foreach ($airlines as $airline)
                                                @if (!in_array($airline, $removeAirlines))
                                                    <div class="flex py-1">
                                                        <input
                                                            class="shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none air"
                                                            id="airline-{{ $airline }}" type="checkbox"
                                                            name="air[]" value="{{ $airline }}">
                                                        <label class="text-base text-gray-500 ms-3"
                                                            for="airline-{{ $airline }}">
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
                                                class="shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none depart"
                                                id="depart-one" type="checkbox" name="departime[]" value="00:00-06:00">
                                            <label class="text-base text-gray-500 ms-3" for="depart-one">00:00 -
                                                06:00</label>
                                        </div>
                                        <div class="flex py-1">
                                            <input
                                                class="shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none depart"
                                                id="depart-two" type="checkbox" name="departime[]" value="06:00-12:00">
                                            <label class="text-base text-gray-500 ms-3" for="depart-two">06:00 -
                                                12:00</label>
                                        </div>
                                        <div class="flex py-1">
                                            <input
                                                class="shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none depart"
                                                id="depart-three" type="checkbox" name="departime[]"
                                                value="12:00-18:00">
                                            <label class="text-base text-gray-500 ms-3" for="depart-three">12:00 -
                                                18:00</label>
                                        </div>
                                        <div class="flex py-1">
                                            <input
                                                class="shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none depart"
                                                id="depart-four" type="checkbox" name="departime[]" value="18:00-24:00">
                                            <label class="text-base text-gray-500 ms-3" for="depart-four">18:00 -
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
                                    aria-expanded="true" aria-controls="arr-collapse">
                                    Arrival Time
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
                                                class="shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none arrival"
                                                id="arr-one" type="checkbox" name="arrivaltime[]" value="00:00-06:00">
                                            <label class="text-base text-gray-500 ms-3" for="arr-one">00:00 -
                                                06:00</label>
                                        </div>
                                        <div class="flex py-1">
                                            <input
                                                class="shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none arrival"
                                                id="arr-two" type="checkbox" name="arrivaltime[]" value="06:00-12:00">
                                            <label class="text-base text-gray-500 ms-3" for="arr-two">06:00 -
                                                12:00</label>
                                        </div>
                                        <div class="flex py-1">
                                            <input
                                                class="shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none arrival"
                                                id="arr-three" type="checkbox" name="arrivaltime[]" value="12:00-18:00">
                                            <label class="text-base text-gray-500 ms-3" for="arr-three">12:00 -
                                                16:00</label>
                                        </div>
                                        <div class="flex py-1">
                                            <input
                                                class="shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none arrival"
                                                id="arr-four" type="checkbox" name="arrivaltime[]" value="18:00-24:00">
                                            <label class="text-base text-gray-500 ms-3" for="arr-four">18:00 -
                                                24:00</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flight-detail col-span-4 md:col-span-3 gap-4 flex flex-col flight-data">
                    @forelse($flights as $key => $flight)
                        @if (!in_array($flight['airline'], $removeAirlines))
                            @include('front.includes.searchresultpage.flightdetail', [
                                'flight' => $flight,
                                'key' => $key,
                            ])
                        @endif
                    @empty
                        <span>No Flights Found</span>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    {{-- ./Main Search Result Content --}}

    {{-- Responsive Search Result Content --}}

    <!-- Responsive Page Content  -->
    <div class="block md:hidden">
        <!-- <section class="heading">
                                <div class="container mx-auto">
                                   
                                </div>
                            </section> -->

        @include('front.includes.searchresultpage.responsivemodifysearch')
        <section class="results mt-3 px-2">
            <div class="container mx-auto">
                <div class="flex flex-col gap-4 responsive-flight-data">
                    @forelse($flights as $key => $flight)
                        @if (!in_array($flight['airline'], $removeAirlines))
                            @include('front.includes.searchresultpage.responsiveflightdetail', [
                                'flight' => $flight,
                                'key' => $key,
                            ])
                        @endif
                    @empty
                        <span>No Flights Found</span>
                    @endforelse

                </div>
            </div>
        </section>
    </div>
    <!-- Responsive Page Content  -->
    {{-- ./Responsive Search Result Content --}}

    {{-- ./New Design --}}

@endsection
@section('scripts')
    <script src="{{ asset('frontend/js/filter.js') }}"></script>
    {{-- <script src="{{ asset('frontend/js/datepicker.js') }}"></script> --}}
    <script>
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

        $('#homepage_search_btn').on('click', function() {

            if ($('#search_box').valid()) {
                var searchType = $('input[name="type"]').val();
                console.log(searchType);
                if (searchType === 'O' || searchType === 'R') {
                    $('#sectors').html($('#dep_from').val().split('-', 1) + ' <i class="fa fa-fighter-jet"></i> ' +
                        $('#arr_to').val().split('-', 1));
                    $('#depart-date').html($('#dep_date').val());
                    if (searchType === 'O') {
                        $('#depart-date').closest('.col-md-6').removeClass('col-md-6').addClass('col-md-12');
                    }

                    if (searchType === 'R') {
                        $('#sectors').html($('#dep_from').val().split('-', 1) +
                            ' <i class="fa fa-fighter-jet"></i> ' + $('#arr_to').val().split('-', 1) +
                            ' <i class="fa fa-fighter-jet"></i> ' + $('#dep_from').val().split('-', 1));
                        $('#return-date').parent('.text-center').removeClass('hide');
                        $('#return-date').html($('#ret_date').val());
                    }
                } else if (searchType === 'M') {
                    function transpose(a) {
                        return Object.keys(a[0]).map(function(c) {
                            return a.map(function(r) {
                                return r[c];
                            });
                        });
                    }

                    $('#depart-date').closest('p').hide();
                    var sectors = '<br>' + $('#dep_from').val().split('-', 1) +
                        ' <i class="fa fa-fighter-jet"></i> ' + $('#arr_to').val().split('-', 1) +
                        ' <i class="fa fa-calendar"></i> ' + $('#dep_date').val() + '<br>';
                    var multiSectors = [];
                    var multiFroms = (function() {
                        var multiFrom = [];
                        $('input[name="int_multi_from[]').each(function() {
                            multiFrom.push($(this).val().split('-', 1));
                        });
                        return multiFrom;
                    })();
                    multiSectors.push(multiFroms);
                    var multiTos = (function() {
                        var multiTo = [];
                        $('input[name="int_multi_to[]"]').each(function() {
                            multiTo.push($(this).val().split('-', 1));
                        });
                        return multiTo;
                    })();
                    multiSectors.push(multiTos);
                    var multiDepartures = (function() {
                        var multiDeparture = [];
                        $('input[name="int_multi_departure[]"]').each(function() {
                            multiDeparture.push($(this).val());
                        });
                        return multiDeparture;
                    })();
                    multiSectors.push(multiDepartures);
                    console.log(multiSectors);
                    var tMultiSectors = transpose(multiSectors);
                    console.log(tMultiSectors);
                    tMultiSectors.forEach(function(item, index) {

                        singleSector = item.toString().split(',');
                        sectors += singleSector[0] + ' <i class="fa fa-fighter-jet"></i> ' + singleSector[
                            1] + ' <i class="fa fa-calendar"></i> ' + singleSector[2] + '<br>';
                    })
                    console.log('sectors = ' + sectors);
                    $('#sectors').html(sectors);
                }


                $('.loader').removeClass('hide');
            }

        });

        $('#one-way-radio').on('click', function() {

            if ($(this).is(':checked')) {
                $('#ret_date_div input').removeAttr('required');
                $('#ret_date_div').addClass('hide');

                $('#parent-multi-city').addClass('hide');
                $('.add-more-btn').addClass('hide');
            }

        });

        $('#two-way-radio').on('click', function() {
            if ($(this).is(':checked')) {

                $('#ret_date_div input').attr('required', 'required');
                $('#ret_date_div').removeClass('hide');

                $('#parent-multi-city').addClass('hide');
                $('.add-more-btn').addClass('hide');
            }

        });

        $('#multi-city-radio').on('click', function() {
            if ($(this).is(':checked')) {
                // console.log('sdasdsadasd');
                $('#ret_date_div input').removeAttr('required');
                $('#ret_date_div').addClass('hide');

                $('#parent-multi-city').removeClass('hide');
                $('.add-more-btn').removeClass('hide');

            }
        });

        var i = 0;

        function duplicate() {

            if (i < 3) {
                var displayedCopy = $('#parent-multi-city').find('#multi-city-input' + ++i);
                displayedCopy.removeClass('hide');
                displayedCopy.find('.takeoff').attr({
                    'name': 'int_multi_from[]',
                    'required': 'required'
                });
                displayedCopy.find('.landing').attr({
                    'name': 'int_multi_to[]',
                    'required': 'required'
                });
                displayedCopy.find('.datepicker').attr({
                    'name': 'int_multi_departure[]',
                    'required': 'required'
                });

            }
            if (i === 3) {
                $('.close.add-more').addClass('hide');
            }
        }

        function hideMultiCity(elem) {
            $(elem).parents('.multi-city-area').addClass('hide');
            $(elem).parents('.multi-city-area').find('.takeoff').removeAttr('name required');
            $(elem).parents('.multi-city-area').find('.landing').removeAttr('name required');
            $(elem).parents('.multi-city-area').find('.datepicker').removeAttr('name required');
            --i;
            checkValueOfI();
        }

        function checkValueOfI() {
            if (i < 3) {

                $('.close.add-more').removeClass('hide');
            }
        }

        $('.flight-details-button').on('click', function() {

            $(this).find('i').toggleClass('fa-minus');
            $(this).toggleClass('details-shown');

            if (($(this).hasClass('details-shown'))) {
                $(this).closest('.flight-single').find('.flight-more-details').slideDown(300);
            } else {
                $(this).closest('.flight-single').find('.flight-more-details').slideUp(300);
            }

        });

        function openNav() {

            $('.filter-search-form').toggleClass('sidebar-visible');
            $('#page-overlay').toggleClass('page-overlay-visible');
        }

        $('#page-overlay').on('click', function() {
            $('.filter-search-form').toggleClass('sidebar-visible');
            $('#page-overlay').toggleClass('page-overlay-visible');
        });

        $('[data-toggle="tooltip"]').tooltip()
    </script>
@endsection
