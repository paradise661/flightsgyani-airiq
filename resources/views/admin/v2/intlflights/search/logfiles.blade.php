@extends('layouts.admin.app')
@section('content')
    @include('admin.v2.inc.messages')
    <div class="p-5">
        <div class="bg-white shadow-lg rounded-lg">
            <div
                class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-neutral-700">

                <div class="">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                        Log Files
                    </h2>
                </div>
                <div>
                    <a href="{{ route('v2.admin.flight.searchlog') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400">
                        Back
                    </a>
                </div>
            </div>
            <div class="list-group">
                @foreach ($files as $file)
                    <h4>
                        <a href="{{ URL::asset('/storage/' . $file) }}"
                            class="block px-4 py-2 text-red-600 bg-red-100 rounded-md hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-500"
                            target="_blank">
                            {{ basename($file) }}
                        </a>
                    </h4>
                @endforeach
            </div>
        </div>
    </div>
@endsection
