@extends('layouts.admin.app')
@section('content')
    @include('admin.v2.inc.messages')
    <div class="col-md-12">
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <!-- Heading -->
                <h3 class="text-lg font-semibold text-gray-800">Add New Role</h3>
                <!-- Back Button -->
                <a class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400"
                    href="{{ route('v2.admin.roles.index') }}">
                    Back
                </a>
            </div>

            <!-- Form Start -->
            <form id="form" action="{{ route('v2.admin.roles.store') }}" method="POST">
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

                </div>

                <div class="w-full mt-6">
                    <!-- Accordion Item: Permissions -->
                    <details class="mb-4 border border-gray-200 rounded-lg shadow-md">
                        <summary
                            class="flex justify-between items-center text-lg font-semibold p-4 bg-gray-100 hover:bg-gray-200 cursor-pointer transition duration-300 ease-in-out">
                            <span class="">
                                Permissions
                            </span>
                            <svg class="w-5 h-5 text-gray-600 transform transition-transform duration-300"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                :class="open ? 'rotate-180' : ''">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </summary>

                        <div class="p-4 bg-gray-50">
                            <span class="text-sm my-4">
                                <input class="mr-2" type="checkbox" name="" id="selectAllPermissions">Select All
                            </span>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mt-2">
                                @foreach ($permissions as $key => $permission)
                                    <div
                                        class="bg-white p-5 rounded-lg shadow-md border border-gray-200 hover:shadow-lg transition-shadow duration-200">
                                        <!-- Section Title -->
                                        <div class="flex items-center space-x-4 mb-4">
                                            <input type="checkbox" child-class="{{ $key }}"
                                                class="select-all form-checkbox text-blue-600 appearance-none w-6 h-6 border-2 border-gray-300 checked:border-blue-600 checked:bg-blue-600 rounded transition-all duration-200">
                                            <span
                                                class="text-lg font-semibold text-gray-800 capitalize">{{ ucwords(str_replace('_', ' ', $key)) }}</span>
                                        </div>

                                        <!-- Permissions List -->
                                        <div class="space-y-3">
                                            @foreach ($permission as $item)
                                                <div class="flex items-center space-x-4">
                                                    <input type="checkbox"
                                                        class="{{ $key }} all-select-items form-checkbox text-blue-600 appearance-none w-6 h-6 border-2 border-gray-300 checked:border-blue-600 checked:bg-blue-600 rounded transition-all duration-200"
                                                        name="permission[]" value="{{ $item->name }}">
                                                    <label for="permission[]"
                                                        class="text-gray-700 text-sm">{{ ucwords($item->name) }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Error Message -->
                                @error('permission')
                                    <div class="text-sm text-red-600 mt-6 col-span-1 sm:col-span-2 lg:col-span-3 xl:col-span-4">
                                        <div class="p-3 bg-red-100 rounded-lg shadow-sm">
                                            {{ $message }}
                                        </div>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </details>
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

    <script>
        $('.select-all').click(function(e) {
            var childclass = $(this).attr('child-class');
            if ($(this).prop('checked')) {
                $('.' + childclass).prop('checked', true);
            } else {
                $('.' + childclass).prop('checked', false);
            }
        })
        $('#selectAllPermissions').click(function(e) {
            if ($(this).prop('checked')) {
                $('.all-select-items').prop('checked', true);
            } else {
                $('.all-select-items').prop('checked', false);
            }
        })
    </script>
@endsection
