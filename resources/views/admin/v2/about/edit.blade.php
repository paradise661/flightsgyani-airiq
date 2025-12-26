@extends('layouts.admin.app')
@section('content')
    @include('admin.v2.inc.messages')
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <!-- First Heading (Add New Branch) -->
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-800">Update About</h3>
                </div>

                <!-- Last Heading (Back) -->
                <div class="flex-none">
                    <a class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400"
                        href="{{ route('v2.admin.aboutus.index') }}">
                        Back
                    </a>
                </div>
            </div>

            <!-- form start -->
            <form id="form" role="form" action="{{ route('v2.admin.aboutus.update', $aboutu->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-6">
                    <!-- Row 1 -->
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Name Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="name">Name <span
                                    class="text-red-500">*</span></label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="name" type="text" name="name" value="{{ old('name', $aboutu->name) }}">
                            @if ($errors->has('name'))
                                <span class="text-sm text-red-500">*{{ $errors->first('name') }}</span>
                            @endif
                        </div>

                        <!-- Location Code Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="address">Address</label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="address" type="text" name="address" value="{{ old('address', $aboutu->address) }}">
                            @if ($errors->has('address'))
                                <span class="text-sm text-red-500">*{{ $errors->first('address') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Row 2 -->
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Primary Email Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="phone">Phone</label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="phone" type="text" name="phone" value="{{ old('phone', $aboutu->phone) }}">
                            @if ($errors->has('phone'))
                                <span class="text-sm text-red-500">*{{ $errors->first('phone') }}</span>
                            @endif
                        </div>

                        <!-- Secondary Email Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="email">Email</label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="email" type="text" name="email" value="{{ old('email', $aboutu->email) }}">
                            @if ($errors->has('email'))
                                <span class="text-sm text-red-500">*{{ $errors->first('email_2') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Row 3 -->
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Primary Contact Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="fb">Facebook Link</label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="fb" type="text" name="fb" value="{{ old('fb', $aboutu->fb) }}">
                            @if ($errors->has('fb'))
                                <span class="text-sm text-red-500">*{{ $errors->first('fb') }}</span>
                            @endif
                        </div>

                        <!-- Secondary Contact Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="instagram">Instagram Link</label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="instagram" type="text" name="instagram"
                                value="{{ old('instagram', $aboutu->instagram) }}">
                            @if ($errors->has('instagram'))
                                <span class="text-sm text-red-500">*{{ $errors->first('instagram') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Row 4 -->
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Primary Contact Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="linkedin">Linkedin Link</label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="linkedin" type="text" name="linkedin"
                                value="{{ old('linkedin', $aboutu->linkedin) }}">
                            @if ($errors->has('linkedin'))
                                <span class="text-sm text-red-500">*{{ $errors->first('linkedin') }}</span>
                            @endif
                        </div>

                        <!-- Secondary Contact Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="twitter">Twitter Link</label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="twitter" type="text" name="twitter"
                                value="{{ old('twitter', $aboutu->twitter) }}">
                            @if ($errors->has('twitter'))
                                <span class="text-sm text-red-500">*{{ $errors->first('twitter') }}</span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700" for="short_description">Short
                            Description</label>
                        <textarea class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm" id="description"
                            name="short_description" rows="3">{{ old('short_description', $aboutu->short_description) }}</textarea>
                        @if ($errors->has('short_description'))
                            <span class="text-sm text-red-500">*{{ $errors->first('short_description') }}</span>
                        @endif
                    </div>

                    <!-- Row 5 (Textarea Field) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700" for="description">Description <span
                                class="text-red-500">*</span></label>
                        <textarea class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm ckeditor" id="description"
                            name="description" rows="3">{{ old('description', $aboutu->description) }}</textarea>
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
                        Update
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection
