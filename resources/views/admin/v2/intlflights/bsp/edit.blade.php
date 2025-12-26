@extends('layouts.admin.app')
@section('content')
    @include('admin.v2.inc.messages')

    <div class="col-md-12">
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-800">Edit BSP Commission</h3>
                </div>

                <div class="flex-none">
                    <a href="{{ route('v2.admin.bspcommission.index') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400">
                        Back
                    </a>
                </div>
            </div>
            <!-- Form Start -->
            <form role="form" id="form" action="{{ route('v2.admin.bspcommission.update', $commission) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="space-y-6">

                    <!-- Radio Buttons Section -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- With Origin (SITI) -->
                        <div class="flex items-center">
                            <input type="radio" name="type" id="siti" value="siti"
                                class="h-5 w-5 text-blue-600 focus:ring-0 mr-2"
                                {{ isset($commission->with_origin) ? 'checked' : '' }}>
                            <label for="siti" class="text-lg text-gray-700">With Origin(SITI)</label>
                        </div>

                        <!-- Without Origin (SOTO) -->
                        <div class="flex items-center">
                            <input type="radio" name="type" id="soto" value="soto"
                                class="h-5 w-5 text-blue-600 focus:ring-0 mr-2"
                                {{ isset($commission->without_origin) ? 'checked' : '' }}>
                            <label for="soto" class="text-lg text-gray-700">Without Origin(SOTO)</label>
                        </div>

                        <!-- All Option -->
                        <div class="flex items-center">
                            <input type="radio" name="type" id="all" value="all"
                                class="h-5 w-5 text-blue-600 focus:ring-0 mr-2"
                                {{ !isset($commission->with_origin) && !isset($commission->without_origin) ? 'checked' : '' }}>
                            <label for="all" class="text-lg text-gray-700">All</label>
                        </div>
                    </div>

                    <!-- Airline and Commission Input Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                        <!-- Airline -->
                        <div class="relative">
                            <label for="airline" class="block text-sm font-medium text-gray-700">Airline</label>
                            <input type="text"
                                class="form-input mt-2 block w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                id="airline" name="airline" value="{{ $commission->airline }}" required>
                            @if ($errors->has('airline'))
                                <span class="text-sm text-red-600 mt-1">{{ $errors->first('airline') }}</span>
                            @endif
                        </div>

                        <!-- Commission -->
                        <div class="relative">
                            <label for="commission" class="block text-sm font-medium text-gray-700">Commission</label>
                            <input type="text"
                                class="form-input mt-2 block w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                id="commission" name="commission" value="{{ $commission->commission }}" required>
                            @if ($errors->has('commission'))
                                <span class="text-sm text-red-600 mt-1">{{ $errors->first('commission') }}</span>
                            @endif
                        </div>
                    </div>

                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-300 ease-in-out">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
