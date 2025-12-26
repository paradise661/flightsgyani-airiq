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
                                Sliders
                            </h2>
                        </div>
                        <div>
                            @can('create slider')
                                <a class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                    href="{{ route('v2.admin.sliders.create') }}">
                                    Create
                                </a>
                            @endcan
                        </div>
                    </div>
                    <!-- End Header -->

                    <div class="flex flex-col px-8 py-6 bg-gray-50 dark:bg-neutral-900 rounded-lg shadow-lg">
                        <!-- Table Section -->
                        <div class="overflow-x-auto">
                            <div class="inline-block align-middle w-full bg-white rounded-lg shadow-md">
                                <!-- Table -->
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                                    <thead class="bg-gray-100 dark:bg-neutral-800">
                                        <tr>
                                            <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-neutral-200"
                                                scope="col">
                                                #
                                            </th>
                                            <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-neutral-200"
                                                scope="col">
                                                Image
                                            </th>
                                            <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-neutral-200"
                                                scope="col">
                                                Order
                                            </th>
                                            <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-neutral-200"
                                                scope="col">
                                                Status
                                            </th>
                                            <th class="py-3 px-6 text-right text-sm font-medium text-gray-600 dark:text-neutral-200"
                                                scope="col">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white divide-y divide-gray-200 dark:bg-neutral-900 dark:divide-neutral-700">
                                        @if ($sliders->isNotEmpty())
                                            @foreach ($sliders as $key => $slider)
                                                <tr
                                                    class="hover:bg-gray-50 dark:hover:bg-neutral-700 transition duration-200 ease-in-out">
                                                    <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                                        {{ $key + $sliders->firstItem() }}</td>
                                                    <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                                        <img src="{{ $slider->image }}" width="50" height="50"
                                                            alt="">
                                                    </td>
                                                    <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                                        {{ $slider->order }}
                                                    </td>
                                                    <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                                        {{ $slider->status ? 'Active' : 'Inactive' }}
                                                    </td>

                                                    <td class="py-3 px-6 text-sm text-right flex justify-end">
                                                        @can('edit slider')
                                                            <a class="px-4 py-1 mr-2 text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition duration-200 ease-in-out text-sm"
                                                                href="{{ route('v2.admin.sliders.edit', $slider->id) }}">
                                                                Edit
                                                            </a>
                                                        @endcan
                                                        @can('delete slider')
                                                            <form action="{{ route('v2.admin.sliders.destroy', $slider->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button
                                                                    class="btn_delete px-4 py-1 text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition duration-200 ease-in-out text-sm"
                                                                    type="submit">
                                                                    Delete
                                                                </button>
                                                            </form>
                                                        @endcan

                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td class="py-6 text-center text-gray-500 dark:text-neutral-400"
                                                    colspan="5">
                                                    <p class="text-lg font-semibold">No data available</p>
                                                    <p class="mt-2 text-sm">There are no records to display at the moment.
                                                        Please check
                                                        again later
                                                    </p>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{ $sliders->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
