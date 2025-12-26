@extends('layouts.admin.app')
@section('content')
    @include('admin.v2.inc.messages')
    <div class="col-md-12">
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <!-- Heading -->
                <h3 class="text-lg font-semibold text-gray-800">Add New Permission</h3>
                <!-- Back Button -->
                <a class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400"
                    href="{{ route('v2.admin.permissions.index') }}">
                    Back
                </a>
            </div>

            <!-- Form Start -->
            <form id="form" action="{{ route('v2.admin.permissions.store') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <!-- Title Field -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700" for="name">Name<span
                                class="text-red-500">*</span></label>
                        <input
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm @error('name') border-red-500 @enderror"
                            id="name" type="text" name="name" value="{{ old('name') }}"
                            placeholder="Enter name">
                        @error('name')
                            <span class="text-sm text-red-500">*{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700" for="parent">Parent<span
                                class="text-red-500">*</span></label>
                        <input
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm @error('parent') border-red-500 @enderror"
                            id="parent" type="text" name="parent" value="{{ old('parent') }}"
                            placeholder="eg. Admin_Dashboard">
                        @error('parent')
                            <span class="text-sm text-red-500">*{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button
                        class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none"
                        type="submit">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
