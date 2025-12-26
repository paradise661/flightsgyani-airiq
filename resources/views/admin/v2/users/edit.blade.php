@extends('layouts.admin.app')
@section('content')
    @include('admin.v2.inc.messages')
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <!-- First Heading (Add New Branch) -->
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-800">Update Staff</h3>
                </div>

                <!-- Last Heading (Back) -->
                <div class="flex-none">
                    <a class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400"
                        href="{{ route('v2.admin.users.index') }}">
                        Back
                    </a>
                </div>
            </div>
            <!-- form start -->
            <form id="form" role="form" action="{{ route('v2.admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-6">
                    <!-- Row 1 -->
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="name">Name<span
                                    class="text-red-500">*</span></label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="name" type="text" name="name" value="{{ old('name', $user->name) }}">
                            @if ($errors->has('name'))
                                <span class="text-sm text-red-500">*{{ $errors->first('name') }}</span>
                            @endif
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="email">Email<span
                                    class="text-red-500">*</span></label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="email" type="email" name="email" value="{{ old('email', $user->email) }}">
                            @if ($errors->has('email'))
                                <span class="text-sm text-red-500">*{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="phonenumber">Phone<span
                                    class="text-red-500">*</span></label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="phonenumber" type="phonenumber" name="phonenumber"
                                value="{{ old('phonenumber', $user->phonenumber) }}">
                            @if ($errors->has('phonenumber'))
                                <span class="text-sm text-red-500">*{{ $errors->first('phonenumber') }}</span>
                            @endif
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="password">Password (Enter to change)<span
                                    class="text-red-500"></span></label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="password" type="password" name="password" value="{{ old('password') }}">
                            @if ($errors->has('password'))
                                <span class="text-sm text-red-500">*{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="">
                            <label for="multiselect" class="block text-sm font-medium text-gray-700">Select Role</label>
                            <select id="multiselect"
                                class="select2 mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                name="roles[]" multiple>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" @if (in_array($role->name, old('roles', $assignedRoles))) selected @endif>
                                        {{ $role->name ?? '' }}
                                    </option>
                                @endforeach
                            </select>
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
