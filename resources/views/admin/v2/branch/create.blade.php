@extends('layouts.admin.app')
@section('content')
    @include('admin.v2.inc.messages')
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <!-- First Heading (Add New Branch) -->
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-800">Add New Branch</h3>
                </div>

                <!-- Last Heading (Back) -->
                <div class="flex-none">
                    <a class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400"
                        href="{{ route('v2.admin.branches.index') }}">
                        Back
                    </a>
                </div>
            </div>
            <!-- form start -->
            <form id="form" role="form" action="{{ route('v2.admin.branches.store') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <!-- Row 1 -->
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Name Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="title">Title<span
                                    class="text-red-500">*</span></label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="title" type="text" name="title" value="{{ old('title') }}">
                            @if ($errors->has('title'))
                                <span class="text-sm text-red-500">*{{ $errors->first('title') }}</span>
                            @endif
                        </div>

                        <!-- Location Code Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="code">Location<span
                                    class="text-red-500">*</span></label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="location" type="text" name="location" value="{{ old('location') }}">
                            @if ($errors->has('location'))
                                <span class="text-sm text-red-500">*{{ $errors->first('location') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Row 2 -->
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Primary Email Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="email">Primary Email <span
                                    class="text-red-500">*</span></label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="email" type="text" name="email" value="{{ old('email') }}">
                            @if ($errors->has('email'))
                                <span class="text-sm text-red-500">*{{ $errors->first('email') }}</span>
                            @endif
                        </div>

                        <!-- Secondary Email Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="email_2">Secondary Email</label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="email_2" type="text" name="email_2" value="{{ old('email_2') }}">
                            @if ($errors->has('email_2'))
                                <span class="text-sm text-red-500">*{{ $errors->first('email_2') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Row 3 -->
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Primary Contact Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="phone">Primary Contact<span
                                    class="text-red-500">*</span></label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="phone" type="text" name="phone" value="{{ old('phone') }}">
                            @if ($errors->has('phone'))
                                <span class="text-sm text-red-500">*{{ $errors->first('phone') }}</span>
                            @endif
                        </div>

                        <!-- Secondary Contact Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="phone_2">Secondary Contact</label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="phone_2" type="text" name="phone_2" value="{{ old('phone_2') }}">
                            @if ($errors->has('phone_2'))
                                <span class="text-sm text-red-500">*{{ $errors->first('phone_2') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Row 4 -->
                    <div class="grid grid-cols-2 gap-6">
                        <!-- order Date Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="order">Order</label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="order" type="number" min="1" name="order" value="{{ old('order') }}">
                            @if ($errors->has('order'))
                                <span class="text-sm text-red-500">*{{ $errors->first('order') }}</span>
                            @endif
                        </div>

                    </div>

                    <!-- Row 5 (Textarea Field) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700" for="description">Description</label>
                        <textarea class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm ckeditor" id="description"
                            name="description" rows="3">{{ old('description') }}</textarea>
                        @if ($errors->has('description'))
                            <span class="text-sm text-red-500">*{{ $errors->first('description') }}</span>
                        @endif
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
