@extends('layouts.admin.app')
@section('content')
    @include('admin.v2.inc.messages')
    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <!-- First Heading (Add New Airport) -->
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-800">Edit Agent Markup Rule</h3>
            </div>

            <!-- Last Heading (Back) -->
            <div class="flex-none">
                <a class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400"
                    href="{{ route('v2.admin.b2b.markups.index') }}">
                    Back
                </a>
            </div>
        </div>
        <form class=" mx-auto p-4 bg-white shadow-md rounded-lg" method="post"
            action="{{ route('v2.admin.b2b.markups.update', $markup->id) }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="markup" value="{{ $markup->id }}">

            <div class="mb-4">
                <label class="block text-lg font-semibold text-gray-700 mb-2">SOTO/SITI</label>
                <div class="flex items-center space-x-4">
                    <label class="flex items-center space-x-2" for="soto">
                        <input class="soto_siti" id="soto" {{ $markup->soto == 1 ? 'checked' : '' }} type="radio"
                            name="soto_siti" value="soto">
                        <span>SOTO</span>
                    </label>
                    <label class="flex items-center space-x-2" for="siti">
                        <input class="soto_siti" id="siti" {{ $markup->siti == 1 ? 'checked' : '' }} type="radio"
                            name="soto_siti" value="siti">
                        <span>SITI</span>
                    </label>
                </div>
            </div>

            <!-- Type Selection Section -->
            <div class="mb-4 {{ $errors->has('type') ? 'text-red-500' : '' }}">
                <label class="block text-lg font-semibold text-gray-700 mb-2">Type</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- By Airline -->
                    <div class="flex items-center">
                        <input class="form-checkbox h-4 w-4 text-blue-500 border-gray-300 rounded" id="airline"
                            type="checkbox" value="airline" name="type[]"
                            {{ in_array('airline', old('type', [])) || isset($markup->airline) ? 'checked' : '' }}>
                        <label class="ml-2 text-gray-700" for="airline">By Airline</label>
                    </div>

                    <!-- By Sector -->
                    <div class="flex items-center">
                        <input class="form-checkbox h-4 w-4 text-blue-500 border-gray-300 rounded" id="sector"
                            type="checkbox" value="sector" name="type[]"
                            {{ in_array('sector', old('type', [])) || $markup->origin || $markup->destination ? 'checked' : '' }}>
                        <label class="ml-2 text-gray-700" for="sector">By Sector</label>
                    </div>

                    <!-- By Trip Type -->
                    <div class="flex items-center">
                        <input class="form-checkbox h-4 w-4 text-blue-500 border-gray-300 rounded" id="trip"
                            type="checkbox" value="trip" name="type[]"
                            {{ in_array('trip', old('type', [])) || ($markup->trip_type == 'O' || $markup->trip_type == 'R') ? 'checked' : '' }}>
                        <label class="ml-2 text-gray-700" for="trip">By Trip Type</label>
                    </div>

                    <!-- By Flight Class -->
                    <div class="flex items-center">
                        <input class="form-checkbox h-4 w-4 text-blue-500 border-gray-300 rounded" id="class"
                            type="checkbox" value="Class" name="type[]"
                            {{ in_array('Class', old('type', [])) || isset($markup->class) ? 'checked' : '' }}>
                        <label class="ml-2 text-gray-700" for="class">By Flight Class</label>
                    </div>
                </div>

                <!-- Display error message if exists -->
                @if ($errors->has('type'))
                    <p class="text-red-500 text-sm mt-1">{{ $errors->first('type') }}</p>
                @endif
            </div>

            <div id="airline-form" style="display: {{ $errors->has('airline') ? '' : 'none' }};">
                <div class="mb-4 {{ $errors->has('airline') ? 'border-red-500' : '' }}">
                    <label class="block text-lg font-semibold text-gray-700 mb-2">Airline</label>
                    <div>
                        <input
                            class="form-input w-full p-2 border rounded-md {{ $errors->has('airline') ? 'border-red-500' : 'border-gray-300' }}"
                            data-provide="typeahead" type="text" name="airline"
                            value="{{ old('airline', $markup->airline ? $markup->airline : '') }}"
                            placeholder="Enter airline">
                        @if ($errors->has('airline'))
                            <p class="text-red-500 text-sm mt-1">{{ $errors->first('airline') }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <div id="sector-form"
                style="display: {{ $errors->has('origin') || $errors->has('destination') ? '' : 'none' }};">
                <div class="mb-4 {{ $errors->has('origin') ? 'border-red-500' : '' }}">
                    <label class="block text-lg font-semibold text-gray-700 mb-2">Origin</label>
                    <div>
                        <input
                            class="form-input w-full p-2 border rounded-md {{ $errors->has('origin') ? 'border-red-500' : 'border-gray-300' }}"
                            id="origin-input" data-provide="typeahead" type="text" name="origin"
                            value="{{ old('origin', $markup->origin ? $markup->origin : '') }}" placeholder="Origin">
                        @if ($errors->has('origin'))
                            <p class="text-red-500 text-sm mt-1">{{ $errors->first('origin') }}</p>
                        @endif
                    </div>
                </div>

                <div class="mb-4 {{ $errors->has('destination') ? 'border-red-500' : '' }}">
                    <label class="block text-lg font-semibold text-gray-700 mb-2">Destination</label>
                    <div>
                        <input
                            class="form-input w-full p-2 border rounded-md {{ $errors->has('destination') ? 'border-red-500' : 'border-gray-300' }}"
                            id="destination-input" data-provide="typeahead" type="text" name="destination"
                            value="{{ old('destination', $markup->destination ? $markup->destination : '') }}"
                            placeholder="Destination">
                        @if ($errors->has('destination'))
                            <p class="text-red-500 text-sm mt-1">{{ $errors->first('destination') }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <div id="trip-form" style="display: {{ $errors->has('pax') ? '' : 'none' }};">
                <div class="mb-4 {{ $errors->has('pax') ? 'border-red-500' : '' }}">
                    <label class="block text-lg font-semibold text-gray-700 mb-2">Trip Type</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input class="form-radio text-blue-500" id="oneway" type="radio" name="triptype"
                                value="O" {{ $markup->trip_type == 'O' ? 'checked' : '' }}>
                            <label class="ml-2" for="oneway">One Way</label>
                        </div>
                        <div class="flex items-center">
                            <input class="form-radio text-blue-500" id="roundtrip" type="radio" name="triptype"
                                value="R" {{ $markup->trip_type == 'R' ? 'checked' : '' }}>
                            <label class="ml-2" for="roundtrip">Round Trip</label>
                        </div>
                        <div class="flex items-center">
                            <input class="form-radio text-blue-500" id="all" type="radio" name="triptype"
                                value="A"
                                {{ $markup->trip_type != 'O' && $markup->trip_type != 'R' ? 'checked' : '' }}>
                            <label class="ml-2" for="all">Both</label>
                        </div>
                    </div>

                    @if ($errors->has('triptype'))
                        <p class="text-red-500 text-sm mt-1">{{ $errors->first('triptype') }}</p>
                    @endif
                </div>
            </div>

            <div class="class-form hidden" id="class-form">
                <div class="form-group row">
                    <label class="block text-lg font-semibold text-gray-700 mb-2">Class</label>
                    <div class="col-sm-12 col-md-10">
                        <div class=" flex gap-2"> <!-- Reduced gap value -->
                            @foreach (range('A', 'Z') as $letter)
                                <div class="flex items-center mb-1"> <!-- Reduced margin-bottom value -->
                                    <input class="custom-control-input" id="{{ $letter }}" type="checkbox"
                                        value="{{ $letter }}" name="class[]"
                                        {{ isset($markup->class) && in_array($letter, json_decode($markup->class)) ? 'checked' : '' }}>
                                    <label class="custom-control-label ml-1"
                                        for="{{ $letter }}">{{ $letter }}</label>
                                    <!-- Reduced left margin -->
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Adult Margin Inputs -->
            <div
                class="mb-4 mt-2 {{ $errors->has('adtnprmargin') || $errors->has('adtusdmargin') ? 'border-red-500' : '' }}">
                <label class="block text-lg font-semibold text-gray-700 mb-2">Adult</label>
                <div class="grid grid-cols-2 gap-4">
                    <!-- NPR Margin Input -->
                    <div>
                        <input
                            class="form-input w-full p-2 border rounded-md {{ $errors->has('adtnprmargin') ? 'border-red-500' : 'border-gray-300' }}"
                            name="adtnprmargin" placeholder="In NPR" type="text"
                            value="{{ old('adtnprmargin', $np->adt_calc_type == '+' ? '' : '-') }}{{ old('adtnprmargin', $np->adt_margin) }}{{ old('adtnprmargin', $np->adt_amount_type == '0' ? '' : '%') }}">
                        @if ($errors->has('adtnprmargin'))
                            <p class="text-red-500 text-sm mt-1">{{ $errors->first('adtnprmargin') }}</p>
                        @endif
                    </div>

                    <!-- USD Margin Input -->
                    <div>
                        <input
                            class="form-input w-full p-2 border rounded-md {{ $errors->has('adtusdmargin') ? 'border-red-500' : 'border-gray-300' }}"
                            name="adtusdmargin" placeholder="In USD" type="text"
                            value="{{ old('adtusdmargin', $us->adt_calc_type == '+' ? '' : '-') }}{{ old('adtusdmargin', $us->adt_margin) }}{{ old('adtusdmargin', $us->adt_amount_type == '0' ? '' : '%') }}">
                        @if ($errors->has('adtusdmargin'))
                            <p class="text-red-500 text-sm mt-1">{{ $errors->first('adtusdmargin') }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Child Section -->
            <div
                class="mb-4 mt-2 {{ $errors->has('chdnprmargin') || $errors->has('chdusdmargin') ? 'border-red-500' : '' }}">
                <label class="block text-lg font-semibold text-gray-700 mb-2">Child</label>
                <div class="grid grid-cols-2 gap-4">
                    <!-- NPR Margin Input -->
                    <div>
                        <input
                            class="form-input w-full p-2 border rounded-md {{ $errors->has('chdnprmargin') ? 'border-red-500' : 'border-gray-300' }}"
                            name="chdnprmargin" placeholder="In NPR" type="text"
                            value="{{ old('chdnprmargin', $np->chd_calc_type == '+' ? '' : '-') }}{{ old('chdnprmargin', $np->chd_margin) }}{{ old('chdnprmargin', $np->chd_amount_type == 0 ? '' : '%') }}">
                        @if ($errors->has('chdnprmargin'))
                            <p class="text-red-500 text-sm mt-1">{{ $errors->first('chdnprmargin') }}</p>
                        @endif
                    </div>

                    <!-- USD Margin Input -->
                    <div>
                        <input
                            class="form-input w-full p-2 border rounded-md {{ $errors->has('chdusdmargin') ? 'border-red-500' : 'border-gray-300' }}"
                            name="chdusdmargin" placeholder="In USD" type="text"
                            value="{{ old('chdusdmargin', $us->chd_calc_type == '+' ? '' : '-') }}{{ old('chdusdmargin', $us->chd_margin) }}{{ old('chdusdmargin', $us->chd_amount_type == 0 ? '' : '%') }}">
                        @if ($errors->has('chdusdmargin'))
                            <p class="text-red-500 text-sm mt-1">{{ $errors->first('chdusdmargin') }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Infant Section -->
            <div
                class="mb-4 mt-2 {{ $errors->has('infnprmargin') || $errors->has('infusdmargin') ? 'border-red-500' : '' }}">
                <label class="block text-lg font-semibold text-gray-700 mb-2">Infant</label>
                <div class="grid grid-cols-2 gap-4">
                    <!-- NPR Margin Input -->
                    <div>
                        <input
                            class="form-input w-full p-2 border rounded-md {{ $errors->has('infnprmargin') ? 'border-red-500' : 'border-gray-300' }}"
                            name="infnprmargin" placeholder="In NPR" type="text"
                            value="{{ old('infnprmargin', $np->inf_calc_type == '+' ? '' : '-') }}{{ old('infnprmargin', $np->inf_margin) }}{{ old('infnprmargin', $np->inf_amount_type == 0 ? '' : '%') }}">
                        @if ($errors->has('infnprmargin'))
                            <p class="text-red-500 text-sm mt-1">{{ $errors->first('infnprmargin') }}</p>
                        @endif
                    </div>

                    <!-- USD Margin Input -->
                    <div>
                        <input
                            class="form-input w-full p-2 border rounded-md {{ $errors->has('infusdmargin') ? 'border-red-500' : 'border-gray-300' }}"
                            name="infusdmargin" placeholder="In USD" type="text"
                            value="{{ old('infusdmargin', $us->inf_calc_type == '+' ? '' : '-') }}{{ old('infusdmargin', $us->inf_margin) }}{{ old('infusdmargin', $us->inf_amount_type == 0 ? '' : '%') }}">
                        @if ($errors->has('infusdmargin'))
                            <p class="text-red-500 text-sm mt-1">{{ $errors->first('infusdmargin') }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Student Section -->
            <div
                class="mb-4 mt-2 {{ $errors->has('stdnprmargin') || $errors->has('stdusdmargin') ? 'border-red-500' : '' }}">
                <label class="block text-lg font-semibold text-gray-700 mb-2">Student</label>
                <div class="grid grid-cols-2 gap-4">
                    <!-- NPR Margin Input -->
                    <div>
                        <input
                            class="form-input w-full p-2 border rounded-md {{ $errors->has('stdnprmargin') ? 'border-red-500' : 'border-gray-300' }}"
                            name="stdnprmargin" placeholder="In NPR" type="text"
                            value="{{ old('stdnprmargin', $np->std_calc_type == '+' ? '' : '-') }}{{ old('stdnprmargin', $np->std_margin) }}{{ old('stdnprmargin', $np->std_amount_type == 0 ? '' : '%') }}">
                        @if ($errors->has('stdnprmargin'))
                            <p class="text-red-500 text-sm mt-1">{{ $errors->first('stdnprmargin') }}</p>
                        @endif
                    </div>

                    <!-- USD Margin Input -->
                    <div>
                        <input
                            class="form-input w-full p-2 border rounded-md {{ $errors->has('stdusdmargin') ? 'border-red-500' : 'border-gray-300' }}"
                            name="stdusdmargin" placeholder="In USD" type="text"
                            value="{{ old('stdusdmargin', $us->std_calc_type == '+' ? '' : '-') }}{{ old('stdusdmargin', $us->std_margin) }}{{ old('stdusdmargin', $us->std_amount_type == 0 ? '' : '%') }}">
                        @if ($errors->has('stdusdmargin'))
                            <p class="text-red-500 text-sm mt-1">{{ $errors->first('stdusdmargin') }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Labour Section -->
            <div
                class="mb-4 mt-2 {{ $errors->has('lbrnprmargin') || $errors->has('lbrusdmargin') ? 'border-red-500' : '' }}">
                <label class="block text-lg font-semibold text-gray-700 mb-2">Labour</label>
                <div class="grid grid-cols-2 gap-4">
                    <!-- NPR Margin Input -->
                    <div>
                        <input
                            class="form-input w-full p-2 border rounded-md {{ $errors->has('lbrnprmargin') ? 'border-red-500' : 'border-gray-300' }}"
                            name="lbrnprmargin" placeholder="In NPR" type="text"
                            value="{{ old('lbrnprmargin', $np->lbr_calc_type == '+' ? '' : '-') }}{{ old('lbrnprmargin', $np->lbr_margin) }}{{ old('lbrnprmargin', $np->lbr_amount_type == 0 ? '' : '%') }}">
                        @if ($errors->has('lbrnprmargin'))
                            <p class="text-red-500 text-sm mt-1">{{ $errors->first('lbrnprmargin') }}</p>
                        @endif
                    </div>

                    <!-- USD Margin Input -->
                    <div>
                        <input
                            class="form-input w-full p-2 border rounded-md {{ $errors->has('lbrusdmargin') ? 'border-red-500' : 'border-gray-300' }}"
                            name="lbrusdmargin" placeholder="In USD" type="text"
                            value="{{ old('lbrusdmargin', $us->lbr_calc_type == '+' ? '' : '-') }}{{ old('lbrusdmargin', $us->lbr_margin) }}{{ old('lbrusdmargin', $us->lbr_amount_type == 0 ? '' : '%') }}">
                        @if ($errors->has('lbrusdmargin'))
                            <p class="text-red-500 text-sm mt-1">{{ $errors->first('lbrusdmargin') }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Priority Section -->
            <div class="mb-4 mt-2 {{ $errors->has('priority') ? 'border-red-500' : '' }}">
                <label class="block text-lg font-semibold text-gray-700 mb-2">Priority</label>
                <div>
                    <input
                        class="form-input w-full p-2 border rounded-md {{ $errors->has('priority') ? 'border-red-500' : 'border-gray-300' }}"
                        name="priority" placeholder="Priority for Rule Application"
                        value="{{ old('priority', $markup->priority) }}" type="number">
                    @if ($errors->has('priority'))
                        <p class="text-red-500 text-sm mt-1">{{ $errors->first('priority') }}</p>
                    @endif
                </div>
            </div>

            <!-- Status Section -->
            <div class="mb-4 mt-2 {{ $errors->has('status') ? 'border-red-500' : '' }}">
                <label class="block text-lg font-semibold text-gray-700 mb-2">Status</label>
                <div class="flex space-x-4">
                    <div class="flex items-center">
                        <input class="mr-2" id="apply" type="radio" value="1"
                            {{ $markup->status ? 'checked' : '' }} name="status">
                        <label class="text-gray-700" for="apply">Apply</label>
                    </div>
                    <div class="flex items-center">
                        <input class="mr-2" id="hold" type="radio" value="0"
                            {{ !$markup->status ? 'checked' : '' }} name="status">
                        <label class="text-gray-700" for="hold">Hold</label>
                    </div>
                </div>
                @if ($errors->has('status'))
                    <p class="text-red-500 text-sm mt-1">{{ $errors->first('status') }}</p>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="mb-4">
                <button
                    class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                    type="submit">
                    Update
                </button>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            sitisoto()

            $('.soto_siti').click(function(e) {
                sitisoto()
            })

            function sitisoto() {
                if ($("input[name='soto_siti']:checked").val() == 'soto') {
                    $('#sector').prop('disabled', true);
                } else {
                    $('#sector').prop('disabled', false);
                }
            }


            if ($('#airline').is(':checked')) {
                $('#airline-form').show();

            } else {
                $('#airline-form').hide();

            }

            $('#airline').on('click', function() {
                if ($(this).is(':checked')) {
                    $('#airline-form').show();

                } else {
                    $('#airline-form').hide();

                }
            });

            if ($('#class').is(':checked')) {
                $('#class-form').show();
            } else {
                $('#class-form').hide();
            }

            $('#class').on('click', function() {
                if ($(this).is(':checked')) {
                    $('#class-form').show();
                } else {
                    $('#class-form').hide();
                }
            });

            //check for sector form
            if ($('#sector').is(':checked')) {
                $('#sector-form').show();

            } else {
                $('#sector-form').hide();
            }
            $('#sector').on('click', function() {
                if ($(this).is(':checked')) {
                    $('#sector-form').show();
                } else {
                    $('#sector-form').hide();
                }
            });

            //    check for passenger type form
            if ($('#trip').is(':checked')) {
                $('#trip-form').show();

            } else {
                $('#trip-form').hide();
            }
            $('#trip').on('click', function() {
                if ($(this).is(':checked')) {
                    $('#trip-form').show();
                } else {
                    $('#trip-form').hide();
                }
            });
        });
    </script>
@endsection
