<div class="flex flex-col px-8 py-6 bg-gray-50 dark:bg-neutral-900 rounded-lg shadow-lg">
    <div class="dark:bg-neutral-900 pb-4 rounded-lg">
        <div class="flex items-center justify-between gap-4">
            <!-- Left Section: Other Filters -->
            <div class="flex items-center flex-wrap gap-4">
                <form class="flex items-center flex-wrap gap-4" wire:submit.prevent="applyFilters">
                    <!-- From Date -->
                    <div class="flex flex-col">
                        <label class="mb-1 text-sm font-medium text-gray-700 dark:text-white" for="from-date">Date
                            Range</label>
                        <input
                            class="flatpicker py-2 px-4 w-60 border border-gray-300 rounded-lg shadow-sm text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white"
                            id="from-date" type="text" wire:model="dateRange" placeholder="Please Select Date"
                            autocomplete="off" />
                    </div>

                    @if (!$type)
                        <!-- Ticket Status -->
                        <div class="flex flex-col">
                            <label class="mb-1 text-sm font-medium text-gray-700 dark:text-white"
                                for="payment_status">Type</label>
                            <select
                                class="py-2 px-4 w-60 text-sm border border-gray-300 rounded-lg shadow-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white"
                                id="payment_status" wire:model="paymentStatus">
                                <option value="All" selected>All Types</option>
                                <option value="DEBITED">DEBITED</option>
                                <option value="CREDITED">CREDITED</option>
                            </select>
                        </div>
                    @endif

                    @if ($dateRange || $paymentStatus != 'All')
                        <div class="flex self-end">
                            <button
                                class="py-2 px-4 bg-red-500 text-white rounded-lg shadow-sm text-sm font-medium hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500"
                                type="button" wire:click="clearFilters">
                                Clear Filters
                            </button>
                        </div>
                    @endif
                </form>
            </div>

            <!-- Right Section: Search and Items Per Page -->
            <div class="flex items-center gap-4">
                <!-- Search Field -->
                <div class="flex flex-col">
                    <label class="mb-1 text-sm font-medium text-gray-700 dark:text-white"
                        for="search-bar">Search</label>
                    <div class="relative">
                        <input
                            class="py-2 px-4 pl-10 w-80 border border-gray-300 rounded-lg shadow-sm text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white"
                            id="search-bar" type="text" wire:model="searchTerms" autocomplete="off"
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
                </div>

                <!-- Items Per Page -->
                <div class="flex flex-col">
                    <label class="mb-1 text-sm font-medium text-gray-700 dark:text-white" for="items-per-page">Items per
                        Page</label>
                    <select
                        class="py-2 px-4 w-28 text-sm border border-gray-300 rounded-lg shadow-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white"
                        id="items-per-page" wire:model="limit">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
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
                            Invoice ID
                        </th>
                        @if (!request('type'))
                            <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-neutral-200"
                                scope="col">
                                Type
                            </th>
                        @endif

                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-neutral-200"
                            scope="col">
                            Amount
                        </th>
                        {{-- <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-neutral-200"
                            scope="col">
                            Loaded By
                        </th> --}}
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-neutral-200"
                            scope="col">
                            Payment via
                        </th>

                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-neutral-200"
                            scope="col">
                            Remarks
                        </th>
                        @if (!request('type'))
                            <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-neutral-200"
                                scope="col">
                                Remaining Balance
                            </th>
                        @endif

                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-neutral-200"
                            scope="col">
                            Date
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-neutral-900 dark:divide-neutral-700">
                    @if ($transactions->isNotEmpty())
                        @foreach ($transactions as $key => $transaction)
                            <tr class="hover:bg-gray-50 dark:hover:bg-neutral-700 transition duration-200 ease-in-out">
                                <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                    {{ $key + $transactions->firstItem() }}</td>
                                <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                    {{ $transaction->invoice_id ?? '-' }}</td>
                                @if (!request('type'))
                                    <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                        @if ($transaction->transaction_type == 'DEBITED')
                                            <span class="bg-red-500 px-2 text-white rounded-md">DEBITED</span>
                                        @else
                                            <span class="bg-green-500 px-2 text-white rounded-md">CREDITED</span>
                                        @endif
                                    </td>
                                @endif

                                <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                    {{ $transaction->currency_type ?? '-' }} {{ $transaction->amount ?? '-' }}
                                </td>
                                {{-- <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                    @if (auth()->user()->id == $transaction->load_by)
                                        Self
                                    @else
                                        {{ $transaction->user->name ?? '-' }}
                                    @endif
                                </td> --}}
                                <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                    {{ $transaction->load_type ?? '-' }}
                                </td>

                                <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                    {{ $transaction->remarks ?? '-' }}
                                </td>
                                @if (!request('type'))
                                    <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                        {{ $transaction->remaining_balance_npr ?? '-' }}
                                    </td>
                                @endif
                                <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                    {{ $transaction->created_at ?? '-' }}
                                </td>
                                {{-- <td class="py-3 px-6 text-sm text-right flex justify-end">
                                    <a class="px-4 py-1 mr-2 text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition duration-200 ease-in-out text-sm"
                                        href="{{ route('v2.admin.transactions.edit', $transaction->id) }}">
                                        Edit
                                    </a>
                                    <form action="{{ route('v2.admin.transactions.destroy', $transaction->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="px-4 py-1 text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition duration-200 ease-in-out text-sm btn_delete"
                                            type="submit">
                                            Delete
                                        </button>
                                    </form>
                                </td> --}}
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="py-6 text-center text-gray-500 dark:text-neutral-400" colspan="10">
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

    {{ $transactions->links() }}
</div>
