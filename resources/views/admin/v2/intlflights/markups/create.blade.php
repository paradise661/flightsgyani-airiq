@extends('layouts.admin.app')
@section('content')
    @include('admin.v2.inc.messages')
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <!-- First Heading (Add New Airport) -->
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-800">Add New Markup Rule</h3>
                </div>

                <!-- Last Heading (Back) -->
                <div class="flex-none">
                    <a class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400"
                        href="{{ route('v2.admin.markups.index') }}">
                        Back
                    </a>
                </div>
            </div>

            <form class=" mx-auto p-4 bg-white shadow-md rounded-lg" method="post"
                action="{{ route('v2.admin.markups.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-lg font-semibold text-gray-700 mb-2">SOTO/SITI</label>
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center space-x-2" for="soto">
                            <input class="soto_siti" id="soto" {{ old('soto_siti') == 'soto' ? 'checked' : '' }}
                                type="radio" name="soto_siti" value="soto">
                            <span>SOTO</span>
                        </label>
                        <label class="flex items-center space-x-2" for="siti">
                            <input class="soto_siti" id="siti" {{ old('soto_siti') == 'siti' ? 'checked' : '' }}
                                type="radio" name="soto_siti" value="siti">
                            <span>SITI</span>
                        </label>
                    </div>
                </div>

                <!-- Type Selection -->
                <div class="mb-4">
                    <label class="block text-lg font-semibold text-gray-700 mb-2">Type</label>
                    <div class="grid grid-cols-4 sm:grid-cols-4 gap-4">
                        <div class="flex items-center">
                            <input class="form-checkbox h-4 w-4 text-blue-500 border-gray-300 rounded" id="airline"
                                type="checkbox" {{ in_array('Airline', old('type', [])) ? 'checked' : '' }} value="Airline"
                                name="type[]">
                            <label class="ml-2 text-gray-700" for="airline">By Airline</label>
                        </div>
                        <div class="flex items-center">
                            <input class="form-checkbox h-4 w-4 text-blue-500 border-gray-300 rounded" id="sector"
                                type="checkbox" {{ in_array('Sector', old('type', [])) ? 'checked' : '' }} value="Sector"
                                name="type[]">
                            <label class="ml-2 text-gray-700" for="sector">By Sector</label>
                        </div>
                        <div class="flex items-center">
                            <input class="form-checkbox h-4 w-4 text-blue-500 border-gray-300 rounded" id="trip"
                                type="checkbox" {{ in_array('TripType', old('type', [])) ? 'checked' : '' }}
                                value="TripType" name="type[]">
                            <label class="ml-2 text-gray-700" for="trip">By Trip Type</label>
                        </div>
                        <div class="flex items-center">
                            <input class="form-checkbox h-4 w-4 text-blue-500 border-gray-300 rounded" id="class"
                                type="checkbox" {{ in_array('Class', old('type', [])) ? 'checked' : '' }} value="Class"
                                name="type[]">
                            <label class="ml-2 text-gray-700" for="class">By Flight Class</label>
                        </div>
                    </div>
                    @if ($errors->has('type'))
                        <p class="text-red-500 text-sm mt-1">{{ $errors->first('type') }}</p>
                    @endif
                </div>

                <div class="airline-form {{ $errors->has('airline') ? 'block' : 'hidden' }}" id="airline-form">
                    <div class="form-group row {{ $errors->has('airline') ? 'has-danger' : '' }}">
                        <label class="block text-lg font-semibold text-gray-700 mb-2">Airline</label>
                        <div class="col-sm-12 col-md-10">
                            <input
                                class="form-control airline-typeahead {{ $errors->has('airline') ? 'form-control-danger' : '' }} w-full px-4 py-2 border border-gray-300 rounded-md"
                                id="airline" type="text" name="airline" value="{{ old('airline') }}">
                            @if ($errors->has('airline'))
                                <div class="text-red-500 text-sm mt-1">{{ $errors->first('airline') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="class-form hidden" id="class-form">
                    <div class="form-group row">
                        <label class="block text-lg font-semibold text-gray-700 mb-2">Class</label>
                        <div class="col-sm-12 col-md-10">
                            <div class="grid grid-cols-6 gap-3">
                                <!-- A to Z Checkboxes -->
                                @foreach (range('A', 'Z') as $letter)
                                    <div class="flex items-center mb-2">
                                        <input class="form-checkbox text-blue-500" id="{{ $letter }}" type="checkbox"
                                            value="{{ $letter }}" name="class[]"
                                            {{ in_array($letter, old('class', json_decode($markup->class ?? '[]', true))) ? 'checked' : '' }}>
                                        <label class="ml-2" for="{{ $letter }}">{{ $letter }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sector-form {{ $errors->has('origin') || $errors->has('destination') ? 'block' : 'hidden' }}"
                    id="sector-form">
                    <div class="form-group row {{ $errors->has('origin') ? 'has-danger' : '' }}">
                        <label class="block text-lg font-semibold text-gray-700 mb-2">Origin</label>
                        <div class="col-sm-12 col-md-10">
                            <input
                                class="form-control typeahead {{ $errors->has('origin') ? 'form-control-danger' : '' }} w-full px-4 py-2 border border-gray-300 rounded-md"
                                id="origin-input" type="text" name="origin" placeholder="Origin" autocomplete="off"
                                value="{{ old('origin') }}">
                            @if ($errors->has('origin'))
                                <div class="text-red-500 text-sm mt-1">{{ $errors->first('origin') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('destination') ? 'has-danger' : '' }}">
                        <label class="block text-lg font-semibold text-gray-700 mb-2">Destination</label>
                        <div class="col-sm-12 col-md-10">
                            <input
                                class="form-control typeahead {{ $errors->has('destination') ? 'form-control-danger' : '' }} w-full px-4 py-2 border border-gray-300 rounded-md"
                                id="destination-input" type="text" name="destination" placeholder="Destination"
                                autocomplete="off" value="{{ old('destination') }}">
                            @if ($errors->has('destination'))
                                <div class="text-red-500 text-sm mt-1">{{ $errors->first('destination') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="trip-form {{ $errors->has('pax') ? 'block' : 'hidden' }}" id="trip-form">
                    <div class="form-group row {{ $errors->has('pax') ? 'has-danger' : '' }}">
                        <label class="block text-lg font-semibold text-gray-700 mb-2">Trip Type</label>
                        <div class="col-sm-12 col-md-10">
                            <div class="grid grid-cols-3 gap-4">
                                <div class="col-span-1">
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" id="oneway" type="radio"
                                            name="triptype" value="O" {{ old('triptype') == 'O' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="oneway">One Way</label>
                                    </div>
                                </div>
                                <div class="col-span-1">
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" id="roundtrip" type="radio"
                                            name="triptype" value="R" {{ old('triptype') == 'R' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="roundtrip">Round Trip</label>
                                    </div>
                                </div>
                                <div class="col-span-1">
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" id="all" type="radio"
                                            name="triptype" value="A" {{ old('triptype') == 'A' ? 'checked' : '' }}
                                            checked>
                                        <label class="custom-control-label" for="all">Both</label>
                                    </div>
                                </div>
                            </div>
                            @if ($errors->has('triptype'))
                                <div class="text-red-500 text-sm mt-1">{{ $errors->first('triptype') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Adult Margin -->
                <div class="mb-4 mt-2">
                    <label class="block text-lg font-semibold text-gray-700 mb-2">Adult</label>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <input
                                class="form-input w-full p-2 border rounded-md {{ $errors->has('adtnprmargin') ? 'border-red-500' : 'border-gray-300' }}"
                                name="adtnprmargin" placeholder="In NPR" type="text"
                                value="{{ old('adtnprmargin') }}">
                            @if ($errors->has('adtnprmargin'))
                                <p class="text-red-500 text-sm mt-1">{{ $errors->first('adtnprmargin') }}</p>
                            @endif
                        </div>
                        <div>
                            <input
                                class="form-input w-full p-2 border rounded-md {{ $errors->has('adtusdmargin') ? 'border-red-500' : 'border-gray-300' }}"
                                name="adtusdmargin" placeholder="In USD" type="text"
                                value="{{ old('adtusdmargin') }}">
                            @if ($errors->has('adtusdmargin'))
                                <p class="text-red-500 text-sm mt-1">{{ $errors->first('adtusdmargin') }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Child Margin -->
                <div class="mb-4">
                    <label class="block text-lg font-semibold text-gray-700 mb-2">Child</label>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <input
                                class="form-input w-full p-2 border rounded-md {{ $errors->has('chdnprmargin') ? 'border-red-500' : 'border-gray-300' }}"
                                name="chdnprmargin" placeholder="In NPR" type="text"
                                value="{{ old('chdnprmargin') }}">
                            @if ($errors->has('chdnprmargin'))
                                <p class="text-red-500 text-sm mt-1">{{ $errors->first('chdnprmargin') }}</p>
                            @endif
                        </div>
                        <div>
                            <input
                                class="form-input w-full p-2 border rounded-md {{ $errors->has('chdusdmargin') ? 'border-red-500' : 'border-gray-300' }}"
                                name="chdusdmargin" placeholder="In USD" type="text"
                                value="{{ old('chdusdmargin') }}">
                            @if ($errors->has('chdusdmargin'))
                                <p class="text-red-500 text-sm mt-1">{{ $errors->first('chdusdmargin') }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Infant Margin -->
                <div class="mb-4">
                    <label class="block text-lg font-semibold text-gray-700 mb-2">Infant</label>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <input
                                class="form-input w-full p-2 border rounded-md {{ $errors->has('infnprmargin') ? 'border-red-500' : 'border-gray-300' }}"
                                name="infnprmargin" placeholder="In NPR" type="text"
                                value="{{ old('infnprmargin') }}">
                            @if ($errors->has('infnprmargin'))
                                <p class="text-red-500 text-sm mt-1">{{ $errors->first('infnprmargin') }}</p>
                            @endif
                        </div>
                        <div>
                            <input
                                class="form-input w-full p-2 border rounded-md {{ $errors->has('infusdmargin') ? 'border-red-500' : 'border-gray-300' }}"
                                name="infusdmargin" placeholder="In USD" type="text"
                                value="{{ old('infusdmargin') }}">
                            @if ($errors->has('infusdmargin'))
                                <p class="text-red-500 text-sm mt-1">{{ $errors->first('infusdmargin') }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Student Margin -->
                <div class="mb-4">
                    <label class="block text-lg font-semibold text-gray-700 mb-2">Student</label>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <input
                                class="form-input w-full p-2 border rounded-md {{ $errors->has('stdnprmargin') ? 'border-red-500' : 'border-gray-300' }}"
                                name="stdnprmargin" placeholder="In NPR" type="text"
                                value="{{ old('stdnprmargin') }}">
                            @if ($errors->has('stdnprmargin'))
                                <p class="text-red-500 text-sm mt-1">{{ $errors->first('stdnprmargin') }}</p>
                            @endif
                        </div>
                        <div>
                            <input
                                class="form-input w-full p-2 border rounded-md {{ $errors->has('stdusdmargin') ? 'border-red-500' : 'border-gray-300' }}"
                                name="stdusdmargin" placeholder="In USD" type="text"
                                value="{{ old('stdusdmargin') }}">
                            @if ($errors->has('stdusdmargin'))
                                <p class="text-red-500 text-sm mt-1">{{ $errors->first('stdusdmargin') }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Labour Margin -->
                <div class="mb-4">
                    <label class="block text-lg font-semibold text-gray-700 mb-2">Labour</label>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <input
                                class="form-input w-full p-2 border rounded-md {{ $errors->has('lbrnprmargin') ? 'border-red-500' : 'border-gray-300' }}"
                                name="lbrnprmargin" placeholder="In NPR" type="text"
                                value="{{ old('lbrnprmargin') }}">
                            @if ($errors->has('lbrnprmargin'))
                                <p class="text-red-500 text-sm mt-1">{{ $errors->first('lbrnprmargin') }}</p>
                            @endif
                        </div>
                        <div>
                            <input
                                class="form-input w-full p-2 border rounded-md {{ $errors->has('lbrusdmargin') ? 'border-red-500' : 'border-gray-300' }}"
                                name="lbrusdmargin" placeholder="In USD" type="text"
                                value="{{ old('lbrusdmargin') }}">
                            @if ($errors->has('lbrusdmargin'))
                                <p class="text-red-500 text-sm mt-1">{{ $errors->first('lbrusdmargin') }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Priority -->
                <div class="mb-4">
                    <label class="block text-lg font-semibold text-gray-700 mb-2">Priority</label>
                    <input
                        class="form-input w-full p-2 border rounded-md {{ $errors->has('priority') ? 'border-red-500' : 'border-gray-300' }}"
                        placeholder="Priority for Rule Application" value="{{ old('priority') }}" name="priority"
                        type="number">
                    @if ($errors->has('priority'))
                        <p class="text-red-500 text-sm mt-1">{{ $errors->first('priority') }}</p>
                    @endif
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label class="block text-lg font-semibold text-gray-700 mb-2">Status</label>
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center">
                            <input class="form-radio h-5 w-5 text-blue-500" id="apply" type="radio" checked
                                value="1" name="status" {{ old('status') == 1 ? 'checked' : '' }}>
                            <label class="ml-2 text-gray-700" for="apply">Apply</label>
                        </div>
                        <div class="flex items-center">
                            <input class="form-radio h-5 w-5 text-blue-500" id="hold" type="radio" value="0"
                                name="status" {{ old('status') == 0 ? 'checked' : '' }}>
                            <label class="ml-2 text-gray-700" for="hold">Hold</label>
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
                        Submit
                    </button>
                </div>
            </form>

        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.soto_siti').click(function(e) {
                if ($("input[name='soto_siti']:checked").val() == 'soto') {
                    $('#sector').prop('disabled', true);
                } else {
                    $('#sector').prop('disabled', false);
                }

            })

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
