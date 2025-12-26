@extends('layouts.admin.app')
@section('content')
    @include('admin.v2.inc.messages')
    <div class="col-md-12">
        <!-- General form elements -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <!-- First Heading (Add New Airport) -->
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-800">Add New Airport</h3>
                </div>

                <!-- Last Heading (Back) -->
                <div class="flex-none">
                    <a href="{{ route('v2.admin.airport.index') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400">
                        Back
                    </a>
                </div>
            </div>

            <!-- Form start -->
            <form role="form" id="form" action="{{ route('v2.admin.airport.store') }}" method="POST"
                enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="space-y-4">
                    <!-- Country -->
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                        <input type="text"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            id="country" name="country" value="{{ old('country') }}" required>
                        @if ($errors->has('country'))
                            <span class="text-sm text-red-600">{{ $errors->first('country') }}</span>
                        @endif
                    </div>

                    <!-- City -->
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                        <input type="text"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            id="city" name="city" value="{{ old('city') }}" required>
                        @if ($errors->has('city'))
                            <span class="text-sm text-red-600">{{ $errors->first('city') }}</span>
                        @endif
                    </div>

                    <!-- Airport Name -->
                    <div>
                        <label for="airport" class="block text-sm font-medium text-gray-700">Airport Name</label>
                        <input type="text"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            id="airport" name="airport" value="{{ old('airport') }}" required>
                        @if ($errors->has('airport'))
                            <span class="text-sm text-red-600">{{ $errors->first('airport') }}</span>
                        @endif
                    </div>

                    <!-- IATA Code -->
                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700">IATA Code</label>
                        <input type="text"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            id="code" name="code" value="{{ old('code') }}" required>
                        @if ($errors->has('code'))
                            <span class="text-sm text-red-600">{{ $errors->first('code') }}</span>
                        @endif
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
