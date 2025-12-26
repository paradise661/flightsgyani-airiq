@extends('layouts.admin.app')
@section('content')
    @include('admin.v2.inc.messages')
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-800">Edit Airline</h3>
                </div>

                <div class="flex-none">
                    <a href="{{ route('v2.admin.airline.index') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400">
                        Back
                    </a>
                </div>
            </div>
            <!-- form start -->
            <form role="form" id="form" action="{{ route('v2.admin.airline.update', $airline->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="data" value="{{ $airline->id }}">

                <div class="space-y-6"> <!-- Adds space between form groups -->

                    <!-- Airline Name Input -->
                    <div class="w-full">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            id="name" name="name" value="{{ $airline->name }}" required>
                        @if ($errors->has('name'))
                            <span class="text-sm text-red-500">{{ $errors->first('name') }}</span>
                        @endif
                    </div>

                    <!-- IATA Code Input -->
                    <div class="w-full">
                        <label for="code" class="block text-sm font-medium text-gray-700">IATA Code</label>
                        <input type="text"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            id="code" name="code" value="{{ $airline->code }}" required>
                        @if ($errors->has('code'))
                            <span class="text-sm text-red-500">{{ $errors->first('code') }}</span>
                        @endif
                    </div>

                    <!-- Image Upload Input -->
                    <div class="w-full">
                        <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                        <input type="file"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            id="image" name="image">
                        <div class="mt-2">
                            <img src="{{ asset('frontend/air-logos/' . $airline->code . '.png') }}"
                                alt="{{ $airline->code }} Logo"
                                class="img img-responsive h-48 w-48 object-cover rounded-md">
                        </div>
                        @if ($errors->has('image'))
                            <span class="text-sm text-red-500">{{ $errors->first('image') }}</span>
                        @endif
                    </div>

                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
