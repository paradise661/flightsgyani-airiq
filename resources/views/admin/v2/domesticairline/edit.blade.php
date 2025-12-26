@extends('layouts.admin.app')
@section('content')
    @include('admin.v2.inc.messages')
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <!-- First Heading (Add New Branch) -->
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-800">Update Airline</h3>
                </div>

                <!-- Last Heading (Back) -->
                <div class="flex-none">
                    <a class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400"
                        href="{{ route('v2.admin.domestic.airlines.index') }}">
                        Back
                    </a>
                </div>
            </div>
            <!-- form start -->
            <form id="form" role="form" action="{{ route('v2.admin.domestic.airlines.update', $airline->id) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Row 1: Name -->
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="name">Name<span
                                    class="text-red-500">*</span></label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="name" type="text" name="name" value="{{ old('name', $airline->name) }}">
                            @if ($errors->has('name'))
                                <i class="text-sm text-red-500">*{{ $errors->first('name') }}</i>
                            @endif
                        </div>
                    </div>

                    <!-- Row 2: Code -->
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="code">Code<span
                                    class="text-red-500">*</span></label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="code" type="text" name="code" value="{{ old('code', $airline->code) }}">
                            @if ($errors->has('code'))
                                <i class="text-sm text-red-500">*{{ $errors->first('code') }}</i>
                            @endif
                        </div>
                    </div>

                    <!-- Row 3: Order -->
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="order">Order</label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="order" type="number" min="1" name="order"
                                value="{{ old('order', $airline->order) }}">
                            @if ($errors->has('order'))
                                <i class="text-sm text-red-500">*{{ $errors->first('order') }}</i>
                            @endif
                        </div>
                    </div>

                    <!-- Row 4: Status -->
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="status">Status</label>
                            <select
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm @error('status') border-red-500 @enderror"
                                id="status" name="status">
                                <option value="1" {{ $airline->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $airline->status == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <i class="text-sm text-red-500">*{{ $message }}</i>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <!-- Image Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="image">Image<span
                                    class="text-red-500">*</span><span>(60 X
                                    46PX)</span>
                            </label>
                            <input
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm image @error('image') border-red-500 @enderror"
                                id="image" type="file" name="image">
                            <img class="view-image mt-2" src="" style="max-height: 100px; width: auto;">
                            @if ($airline->image)
                                <img class="mt-2 old-image"
                                    src="{{ asset('uploads/domestic/airlines/' . $airline->image) }}" width="100">
                                <i class="fa fa-times text-danger remove-image cursor-pointer" column="image"
                                    module="{{ $airline->id }}" aria-hidden="true"></i>
                            @endif
                            @error('image')
                                <i class="text-sm text-red-500">*{{ $message }}</i>
                            @enderror
                        </div>
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
@section('scripts')
    <script>
        $(".image").change(function() {
            input = this;
            var nthis = $(this);

            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    nthis.siblings('.old-image').hide();
                    nthis.siblings('.view-image').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        });
    </script>
@endsection
