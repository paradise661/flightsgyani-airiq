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
                            Image
                        </th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-neutral-200"
                            scope="col">
                            Name
                        </th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-neutral-200"
                            scope="col">
                            Position
                        </th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-neutral-200"
                            scope="col">
                            Status
                        </th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-neutral-200"
                            scope="col">
                            Order
                        </th>

                        <th class="py-3 px-6 text-right text-sm font-medium text-gray-600 dark:text-neutral-200"
                            scope="col">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-neutral-900 dark:divide-neutral-700">
                    @if ($teams->isNotEmpty())
                        @foreach ($teams as $key => $team)
                            <tr class="hover:bg-gray-50 dark:hover:bg-neutral-700 transition duration-200 ease-in-out">
                                <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                    {{ $key + $teams->firstItem() }}</td>

                                <td class="py-3 px-6">
                                    <img src="{{ asset('uploads/team/' . $team->image) ?: 'avatar.png' }}"
                                        alt="{{ $team->name }}" width="80px">
                                </td>
                                <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                    {{ $team->name ?? '-' }}</td>

                                <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                    {{ $team->position ?? '-' }}
                                </td>

                                <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                    {{ $team->status == 1 ? 'Active' : 'Inactive' }}</td>

                                <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                    {{ $team->order ?? '-' }}
                                </td>

                                <td class="py-3 px-6 text-sm text-right flex justify-end">
                                    @can('edit team')
                                        <a class="px-4 py-1 mr-2 text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition duration-200 ease-in-out text-sm"
                                            href="{{ route('v2.admin.teams.edit', $team->id) }}">
                                            Edit
                                        </a>
                                    @endcan
                                    @can('delete team')
                                        <form action="{{ route('v2.admin.teams.destroy', $team->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                class="px-4 py-1 text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition duration-200 ease-in-out text-sm btn_delete"
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
                            <td class="py-6 text-center text-gray-500 dark:text-neutral-400" colspan="7">
                                <p class="text-lg font-semibold">No data available</p>
                                <p class="mt-2 text-sm">There are no records to display at the moment. Please check
                                    again later or
                                    <span>
                                        @can('create team')
                                            <a class="text-blue-600 hover:text-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-200 ease-in-out"
                                                href="{{ route('v2.admin.teams.create') }}">
                                                add new entries.
                                            </a>
                                        @endcan
                                    </span>
                                </p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    {{ $teams->links() }}
</div>
