@extends('layouts.admin.app')
@section('content')
    @include('admin.v2.inc.messages')

    <div class="col-md-12 relative w-full h-screen">
        <!-- general form elements -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <!-- First Heading (Add New Branch) -->
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-800">Edit What we do</h3>
                </div>

                <!-- Last Heading (Back) -->
                <div class="flex-none">
                    <a class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400"
                        href="{{ route('v2.admin.whatwedo.index') }}">
                        Back
                    </a>
                </div>
            </div>

            <form id="form" action="{{ route('v2.admin.whatwedo.update', $whatwedo->id) }}" enctype="multipart/form-data"
                method="post" class="w-full mx-auto p-6">
                @csrf
                @method('PUT')

                <!-- Title Input -->
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" value="{{ old('title', $whatwedo->title) }}"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        id="title" placeholder="Enter Title" required>
                </div>

                <!-- Description Textarea -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description"
                        class="mt-1 block w-full h-32 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 ckeditor"
                        placeholder="Enter Description">{{ old('description', $whatwedo->description) }}</textarea>
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
