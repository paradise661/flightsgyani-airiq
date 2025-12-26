@extends('layouts.admin.app')
@section('content')
    @include('admin.v2.inc.messages')

    <div class="col-md-12 relative w-full h-screen">
        <!-- general form elements -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <!-- First Heading (Add New Branch) -->
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-800">Add New Blog</h3>
                </div>

                <!-- Last Heading (Back) -->
                <div class="flex-none">
                    <a class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400"
                        href="{{ route('v2.admin.blog.index') }}">
                        Back
                    </a>
                </div>
            </div>

            <form class="w-full mx-auto p-6" id="form" action="{{ route('v2.admin.blog.store') }}"
                enctype="multipart/form-data" method="post">
                @csrf

                <!-- Title Input -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700" for="title">Title</label>
                    <input required
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        id="title" type="text" name="title" value="{{ old('title') }}" placeholder="Enter Title">
                    @if ($errors->has('title'))
                        <span class="text-sm text-red-500">{{ $errors->first('title') }}</span>
                    @endif
                </div>

                <!-- Description Textarea -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700" for="description">Description</label>
                    <textarea
                        class="mt-1 block w-full h-32 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 ckeditor"
                        id="description" name="description" placeholder="Enter Description">{{ old('description') }}</textarea>
                    @if ($errors->has('description'))
                        <span class="text-sm text-red-500">{{ $errors->first('description') }}</span>
                    @endif
                </div>

                @include('admin.v2.inc.cropimage', ['image' => ''])

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
