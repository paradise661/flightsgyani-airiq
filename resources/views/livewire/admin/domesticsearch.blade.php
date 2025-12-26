<div class="flex flex-col px-8 py-6 bg-gray-50 dark:bg-neutral-900 rounded-lg shadow-lg">
    <!-- Search Section -->
    <div class="flex items-center justify-between mb-6 space-x-4">
        <!-- Search Bar -->
        <div class="relative flex-1 max-w-xs">
            <label class="sr-only" for="hs-table-export-search">Search</label>
            <input
                class="py-2 px-4 pl-10 block w-full border border-gray-300 rounded-lg shadow-sm text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:placeholder-neutral-500"
                id="hs-table-export-search" type="text" wire:model="searchTerms" autocomplete="off"
                placeholder="Search for items" />
            <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="w-5 h-5 text-gray-500 dark:text-neutral-400" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.3-4.3"></path>
                </svg>
            </div>
        </div>

        <!-- Limit Dropdown with Icon -->
        <div class="flex items-center space-x-3">
            <label class="text-sm font-medium text-gray-700 dark:text-white" for="items-limit">Items per page:</label>
            <div class="relative">
                <select
                    class="py-2 px-4 pl-4 pr-10 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:focus:ring-blue-500"
                    id="items-limit" wire:model="limit">
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <!-- Icon in the dropdown -->
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <svg class="w-4 h-4 text-gray-500 dark:text-neutral-400" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 9l6 6 6-6"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

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
                            User
                        </th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-neutral-200"
                            scope="col">
                            Departure
                        </th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-neutral-200"
                            scope="col">
                            Arrival
                        </th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-neutral-200"
                            scope="col">
                            Departure Date
                        </th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-neutral-200"
                            scope="col">
                            Return Date
                        </th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-neutral-200"
                            scope="col">
                            Type
                        </th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-neutral-200"
                            scope="col">
                            Adult
                        </th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-neutral-200"
                            scope="col">
                            Child
                        </th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-neutral-200"
                            scope="col">
                            Nationality
                        </th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-neutral-200"
                            scope="col">
                            Search Date
                        </th>
                        <th class="py-3 px-6 text-right text-sm font-medium text-gray-600 dark:text-neutral-200"
                            scope="col">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-neutral-900 dark:divide-neutral-700">
                    @if ($searches->isNotEmpty())
                        @foreach ($searches as $key => $search)
                            <tr class="hover:bg-gray-50 dark:hover:bg-neutral-700 transition duration-200 ease-in-out">
                                <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                    {{ $key + $searches->firstItem() }}</td>
                                <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                    {{ $search->user->name ?? '-' }}
                                </td>
                                <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                    {{ $search->departure ?? '' }}
                                </td>
                                <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                    {{ $search->arrival ?? '' }}
                                </td>
                                <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                    {{ $search->departure_date }}
                                </td>
                                <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                    {{ $search->return_date ? $search->return_date : '-' }}
                                </td>
                                <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                    {{ $search->type ?? '' }}
                                </td>
                                <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                    {{ $search->adults ?? '' }}
                                </td>
                                <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                    {{ $search->childs ?? '' }}
                                </td>
                                <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                    {{ $search->nationality ?? '' }}
                                </td>
                                <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                    {{ $search->created_at->toFormattedDateString() }}
                                </td>

                                <td class="py-3 px-6 text-sm text-right flex justify-end">
                                    @can('delete domesticsearchlog')
                                        <a class="delete-record px-4 py-1 text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition duration-200 ease-in-out text-sm"
                                            href="{{ route('v2.admin.domestic.flight.deletesearch', $search->id) }}">
                                            Delete
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="py-6 text-center text-gray-500 dark:text-neutral-400" colspan="12">
                                <p class="text-lg font-semibold">No data available</p>
                                <p class="mt-2 text-sm">There are no records to display at the moment. Please check
                                    again later
                                </p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    {{ $searches->links() }}
</div>

<script>
    $(document).on('click', '.delete-record', function(e) {
        e.preventDefault();
        let nthis = $(this).attr('href');

        Swal.fire({
            title: "Are you sure?",
            text: "If you delete this, it will be gone forever.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = nthis;
            }
        });
    });
</script>
