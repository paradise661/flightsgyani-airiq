@extends('layouts.admin.app')
@section('content')
    @include('admin.v2.inc.messages')

    <div class="col-md-12 relative w-full h-screen">
        <!-- general form elements -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <!-- First Heading (Add New Branch) -->
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-800">Add New Slider</h3>
                </div>

                <!-- Last Heading (Back) -->
                <div class="flex-none">
                    <a class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400"
                        href="{{ route('v2.admin.sliders.index') }}">
                        Back
                    </a>
                </div>
            </div>

            <form id="form" action="{{ route('v2.admin.sliders.store') }}" enctype="multipart/form-data" method="post"
                class="w-full mx-auto p-6">
                @csrf

                @include('admin.v2.inc.slidercrop', ['image' => ''])

                <!-- Title Input -->
                <div class="mb-4">
                    <label for="order" class="block text-sm font-medium text-gray-700">Order</label>
                    <input type="number" name="order" value=""
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        id="order" placeholder="Enter Order">
                    @if ($errors->has('order'))
                        <span class="text-sm text-red-500">{{ $errors->first('order') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <div class="flex items-center space-x-2">
                        <label for="status" id="statusLabel"
                            class="text-sm font-medium text-gray-700">Active</label>
                        <input type="checkbox" id="status" name="status" checked value="1"
                            class="h-5 w-5 text-indigo-600 border-gray-300 rounded" >
                    </div>
                    @if ($errors->has('status'))
                        <span class="text-red-500 text-sm">{{ $errors->first('status') }}</span>
                    @endif
                </div>

                <div class="mt-6">
                    <button
                        class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none"
                        type="submit">
                        Submit
                    </button>
                </div>
            </form>

        </div>

    </div>
@endsection
