@extends('layouts.admin.app')
@section('content')
    @include('admin.v2.inc.messages')
    <div class="flex flex-col">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div
                    class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-neutral-800 dark:border-neutral-700">
                    <!-- Header -->
                    <div
                        class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-neutral-700">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                                Inquery Details
                            </h2>
                        </div>
                        <div>
                            <a class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400"
                                href="{{ route('v2.admin.inquery.details') }}">
                                Back
                            </a>

                        </div>
                    </div>
                    <!-- End Header -->

                    <div class="w-full mx-auto p-6 bg-white rounded-lg shadow-lg">

                        <div class="space-y-4">
                            <!-- Name -->
                            <div class="flex items-center space-x-4">
                                <label class="text-sm font-medium text-gray-600 w-32">Name:</label>
                                <span class="text-gray-800">{{ $inquery->name }}</span>
                            </div>

                            <!-- Email -->
                            <div class="flex items-center space-x-4">
                                <label class="text-sm font-medium text-gray-600 w-32">Email:</label>
                                <span class="text-gray-800">{{ $inquery->email }}</span>
                            </div>

                            <!-- Phone -->
                            <div class="flex items-center space-x-4">
                                <label class="text-sm font-medium text-gray-600 w-32">Phone:</label>
                                <span class="text-gray-800">{{ $inquery->phone }}</span>
                            </div>

                            <!-- Type -->
                            <div class="flex items-center space-x-4">
                                <label class="text-sm font-medium text-gray-600 w-32">Type:</label>
                                <span class="text-gray-800">{{ $inquery->type ?? 'Not specified' }}</span>
                            </div>

                            <!-- City -->
                            <div class="flex items-center space-x-4">
                                <label class="text-sm font-medium text-gray-600 w-32">City:</label>
                                <span class="text-gray-800">{{ $inquery->city }}</span>
                            </div>

                            <!-- Created At -->
                            <div class="flex items-center space-x-4">
                                <label class="text-sm font-medium text-gray-600 w-32">Created At:</label>
                                <span
                                    class="text-gray-800">{{ \Carbon\Carbon::parse($inquery->created_at)->format('M d, Y h:i A') }}</span>
                            </div>

                            <!-- Status -->
                            <div class="flex items-center space-x-4">
                                <label class="text-sm font-medium text-gray-600 w-32">Status:</label>
                                <span class="text-gray-800">{{ $inquery->status == 1 ? 'Seen' : '' }}</span>
                            </div>

                            <!-- Message -->
                            <div class="flex items-center space-x-4">
                                <label class="text-sm font-medium text-gray-600 w-32">Message:</label>
                                <span class="text-gray-800">{{ $inquery->message }}</span>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
