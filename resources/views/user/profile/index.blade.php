@extends('layouts.user-dashboard')

@section('content')
    <div class="bg-white px-4 py-6 rounded-lg">
        <h4 class="text-2xl font-semibold">General Details</h4>
        <!-- general details form  -->
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            <div class="general-details mt-4 grid grid-cols-2 gap-4">
                <div class="w-full col-span-2 md:col-span-1">
                    <label for="lname" class="block text-sm font-semibold mb-2">Full Name <span
                            class="text-red-600">*</span></label>
                    <input type="text" id="lname" name="name"
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                        placeholder="Full Name" value="{{ old('name') ?: $user->name }}">
                </div>
                <div class="w-full col-span-2 md:col-span-1">
                    <label for="lname" class="block text-sm font-semibold mb-2">Email <span
                            class="text-red-600">*</span></label>
                    <input type="email" id="email" name="email" readonly
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                        value="{{ old('email') ?: $user->email }}" placeholder="user@example.com">
                </div>
                <div class="w-full col-span-2 md:col-span-1">
                    <label for="address" class="block text-sm font-semibold mb-2">Phone <span
                            class="text-red-600">*</span></label>
                    <input type="text" id="phoneNumber" name="phonenumber"
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                        value="{{ old('phonenumber') ?: $user->phonenumber }}" placeholder="Phone Number">
                </div>
                <div class="col-span-2">
                    <div class="flex justify-end">
                        <button type="submit" class="bg-primary px-6 py-3 text-white rounded-md">
                            Update
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- / general details form  -->
    </div>
@endsection
