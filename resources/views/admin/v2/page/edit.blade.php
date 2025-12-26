@extends('layouts.admin.app')
@section('content')
    @include('admin.v2.inc.messages')
    <div class="col-md-12">
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <!-- First Heading (Add New Page) -->
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-800">Edit Page</h3>
                </div>
                <!-- Back Button -->
                <div class="flex-none">
                    <a class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400"
                        href="{{ route('v2.admin.pages.index') }}">
                        Back
                    </a>
                </div>
            </div>
            <!-- Form Start -->
            <form id="form" role="form" action="{{ route('v2.admin.pages.update', $page->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Row 1: Title and Link -->
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Title Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="title">Title<span
                                    class="text-red-500">*</span></label>
                            <input
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm @error('title') border-red-500 @enderror"
                                id="title" type="text" name="title" value="{{ old('title', $page->title) }}"
                                placeholder="Enter the page title">
                            @error('title')
                                <span class="text-sm text-red-500">*{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Link Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="link">Link</label>
                            <input
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm @error('link') border-red-500 @enderror"
                                id="link" type="text" name="link" value="{{ old('link', $page->link) }}"
                                placeholder="Enter the page link">
                            @error('link')
                                <span class="text-sm text-red-500">*{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Row 2: Short Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700" for="short_description">Short
                            Description</label>
                        <textarea
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm @error('short_description') border-red-500 @enderror"
                            id="short_description" name="short_description" rows="3" placeholder="Enter a short description">{{ old('short_description', $page->short_description) }}</textarea>
                        @error('short_description')
                            <span class="text-sm text-red-500">*{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Row 3: Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700" for="description">Description<span
                                class="text-red-500">*</span></label>
                        <textarea
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm ckeditor @error('description') border-red-500 @enderror"
                            id="description" name="description" rows="4" placeholder="Enter detailed description">{{ old('description', $page->description) }}</textarea>
                        @error('description')
                            <span class="text-sm text-red-500">*{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Row 4: Order and Status -->
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Order Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="order">Order</label>
                            <input
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm @error('order') border-red-500 @enderror"
                                id="order" type="number" name="order" value="{{ old('order', $page->order) }}"
                                min="1" placeholder="Enter the display order">
                            @error('order')
                                <span class="text-sm text-red-500">*{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Status Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="status">Status</label>
                            <select
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm @error('status') border-red-500 @enderror"
                                id="status" name="status">
                                <option value="1" {{ $page->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $page->status == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <span class="text-sm text-red-500">*{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Row 5: Image -->
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Image Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="image">Image
                            </label>
                            <input
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm image @error('image') border-red-500 @enderror"
                                id="image" type="file" name="image">
                            <img class="view-image mt-2" src="" style="max-height: 100px; width: auto;">
                            @if ($page->image)
                                <img class="mt-2 old-image" src="{{ asset('uploads/page/' . $page->image) }}"
                                    width="100">
                                <i class="fa fa-times text-danger remove-image cursor-pointer" column="image"
                                    module="{{ $page->id }}" aria-hidden="true"></i>
                            @endif
                            @error('image')
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
