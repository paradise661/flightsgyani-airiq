@extends('layouts.admin.app')
@section('content')
    @include('admin.v2.inc.messages')
    <div class="col-md-12">
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <!-- Heading -->
                <h3 class="text-lg font-semibold text-gray-800">Add New FAQ</h3>
                <!-- Back Button -->
                <a class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400"
                    href="{{ route('v2.admin.faqs.index') }}">
                    Back
                </a>
            </div>

            <!-- Form Start -->
            <form id="form" action="{{ route('v2.admin.faqs.store') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <!-- Title Field -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700" for="title">Title<span
                                class="text-red-500">*</span></label>
                        <input
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm @error('title') border-red-500 @enderror"
                            id="title" type="text" name="title" value="{{ old('title') }}"
                            placeholder="Enter title">
                        @error('title')
                            <span class="text-sm text-red-500">*{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Content Field -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700" for="content">Content<span
                                class="text-red-500">*</span></label>
                        <textarea
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm ckeditor @error('content') border-red-500 @enderror"
                            id="content" name="content" rows="4" placeholder="Enter content">{{ old('content') }}</textarea>
                        @error('content')
                            <span class="text-sm text-red-500">*{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Status and Order Fields -->
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Status Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="status">Status</label>
                            <select
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm @error('status') border-red-500 @enderror"
                                id="status" name="status">
                                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <span class="text-sm text-red-500">*{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Order Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="order">Order</label>
                            <input
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm @error('order') border-red-500 @enderror"
                                id="order" type="number" name="order" value="{{ old('order') }}" min="1"
                                placeholder="Enter display order">
                            @error('order')
                                <span class="text-sm text-red-500">*{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
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
