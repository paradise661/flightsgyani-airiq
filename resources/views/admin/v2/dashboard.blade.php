@extends('layouts.admin.app')
@section('content')
    <!-- Card -->
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
                                Dashboard
                            </h2>
                        </div>
                    </div>
                    <!-- End Header -->

                </div>
            </div>
        </div>
    </div>
    <!-- End Card -->

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Card 1: Domestic Bookings -->
        <a class="bg-white shadow-lg rounded-lg p-6 flex items-center space-x-6 hover:shadow-xl transition-shadow duration-300 hover:bg-green-50"
            href="{{ route('v2.admin.domestic.flight.bookings') }}">
            <!-- Wallet Icon (SVG) -->
            <div class="flex justify-center items-center p-4 rounded-full bg-green-500">
                <svg class="w-10 h-10 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M24.794 16.522l-.281-2.748-10.191-5.131s.091-1.742 0-4.31c-.109-1.68-.786-3.184-1.839-4.339l.005.006h-.182c-1.048 1.15-1.726 2.653-1.834 4.312l-.001.021c-.091 2.567 0 4.31 0 4.31l-10.19 5.131-.281 2.748 6.889-2.074 3.491-.582c-.02.361-.031.783-.031 1.208 0 2.051.266 4.041.764 5.935l-.036-.162-2.728 1.095v1.798l3.52-.8c.155.312.3.566.456.812l-.021-.035v.282c.032-.046.062-.096.093-.143.032.046.061.096.094.143v-.282c.135-.21.28-.464.412-.726l.023-.051 3.52.8v-1.798l-2.728-1.095c.463-1.733.728-3.723.728-5.774 0-.425-.011-.847-.034-1.266l.003.058 3.492.582 6.888 2.074z">
                    </path>
                </svg>
            </div>
            <div>
                <h5 class="text-2xl font-semibold text-gray-800">Domestic Bookings</h5>
                <p class="text-lg text-gray-600">
                    <span class="font-bold text-green-600 text-3xl">{{ $domesticBookingCount }}</span>
                </p>
            </div>
        </a>

        <!-- Card 2: International Bookings -->
        <a class="bg-white shadow-lg rounded-lg p-6 flex items-center space-x-6 hover:shadow-xl transition-shadow duration-300 hover:bg-red-50"
            href="{{ route('v2.admin.flight.bookings') }}">
            <!-- Wallet Icon (SVG) -->
            <div class="flex justify-center items-center p-4 rounded-full bg-red-500">
                <svg class="w-10 h-10 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M24.794 16.522l-.281-2.748-10.191-5.131s.091-1.742 0-4.31c-.109-1.68-.786-3.184-1.839-4.339l.005.006h-.182c-1.048 1.15-1.726 2.653-1.834 4.312l-.001.021c-.091 2.567 0 4.31 0 4.31l-10.19 5.131-.281 2.748 6.889-2.074 3.491-.582c-.02.361-.031.783-.031 1.208 0 2.051.266 4.041.764 5.935l-.036-.162-2.728 1.095v1.798l3.52-.8c.155.312.3.566.456.812l-.021-.035v.282c.032-.046.062-.096.093-.143.032.046.061.096.094.143v-.282c.135-.21.28-.464.412-.726l.023-.051 3.52.8v-1.798l-2.728-1.095c.463-1.733.728-3.723.728-5.774 0-.425-.011-.847-.034-1.266l.003.058 3.492.582 6.888 2.074z">
                    </path>
                </svg>
            </div>
            <div>
                <h5 class="text-2xl font-semibold text-gray-800">Intl Bookings</h5>
                <p class="text-lg text-gray-600">
                    <span class="font-bold text-red-600 text-3xl">{{ $intlBookingCount }}</span>
                </p>
            </div>
        </a>

        <!-- Card 3: Inquiries -->
        <a class="bg-white shadow-lg rounded-lg p-6 flex items-center space-x-6 hover:shadow-xl transition-shadow duration-300 hover:bg-green-50"
            href="{{ route('v2.admin.inquery.details') }}">
            <!-- Inquiries Icon (SVG) -->
            <div class="flex justify-center items-center p-4 rounded-full bg-green-500">
                <svg class="w-10 h-10 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v2h-2zm0 4h2v6h-2z" />
                </svg>
            </div>
            <div>
                <h5 class="text-2xl font-semibold text-gray-800">Inquiries</h5>
                <p class="text-lg text-gray-600">
                    <span class="font-bold text-green-600 text-3xl">{{ $inqueriesCount }}</span>
                </p>
            </div>
        </a>

        <!-- Card 4: Registered Users -->
        <a class="bg-white shadow-lg rounded-lg p-6 flex items-center space-x-6 hover:shadow-xl transition-shadow duration-300 hover:bg-red-50"
            href="{{ route('v2.admin.registered.users') }}">
            <!-- Users Icon (SVG) -->
            <div class="flex justify-center items-center p-4 rounded-full bg-red-500">
                <svg class="w-10 h-10 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="7" r="4" />
                    <path d="M12 13c-5 0-7 3-7 3v4h14v-4s-2-3-7-3z" />
                </svg>

            </div>
            <div>
                <h5 class="text-2xl font-semibold text-gray-800">Registered Users</h5>
                <p class="text-lg text-gray-600">
                    <span class="font-bold text-red-600 text-3xl">{{ $registeredUsers }}</span>
                </p>
            </div>
        </a>

    </div>

    <div class="grid grid-cols-1 gap-6">
        <div id="domestic-agent-chart"></div>
        <div id="international-agent-chart"></div>
    </div>

    <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
        Latest Transactions
    </h2>
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
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-neutral-200"
                            scope="col">
                            Agent
                        </th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-neutral-200"
                            scope="col">
                            Type
                        </th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-neutral-200"
                            scope="col">
                            Amount
                        </th>

                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-neutral-200"
                            scope="col">
                            Remarks
                        </th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-neutral-200"
                            scope="col">
                            Method
                        </th>

                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-neutral-200"
                            scope="col">
                            Date
                        </th>
                        <th class="py-3 px-6 text-right text-sm font-medium text-gray-600 dark:text-neutral-200"
                            scope="col">
                            Action
                        </th>

                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-neutral-900 dark:divide-neutral-700">
                    @if ($transactions->isNotEmpty())
                        @foreach ($transactions as $key => $transaction)
                            <tr class="hover:bg-gray-50 dark:hover:bg-neutral-700 transition duration-200 ease-in-out">
                                <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                    {{ $key + 1 }}</td>
                                <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                    {{ $transaction->invoice_id ?? '-' }}</td>
                                <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                    @if ($transaction->agent->name ?? '')
                                        <a class="text-blue-700 underline"
                                            href="{{ route('v2.admin.agents.show', $transaction->agent_id) }}">
                                            {{ $transaction->agent->name ?? '-' }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                    @if ($transaction->transaction_type == 'DEBITED')
                                        <span class="bg-red-500 px-2 text-white rounded-md">DEBITED</span>
                                    @else
                                        <span class="bg-green-500 px-2 text-white rounded-md">CREDITED</span>
                                    @endif
                                </td>
                                <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                    {{ $transaction->currency_type ?? '-' }} {{ $transaction->amount ?? '-' }}
                                </td>
                                <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                    {{ $transaction->remarks ?? '-' }}
                                </td>
                                <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                    {{ $transaction->load_type ?? '-' }}
                                </td>

                                <td class="py-3 px-6 text-sm text-gray-800 dark:text-neutral-200">
                                    {{ $transaction->created_at ?? '-' }}
                                </td>

                                <td class="py-3 px-6 text-sm text-right flex justify-end">
                                    <a class="px-4 py-1 mr-2 text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition duration-200 ease-in-out text-sm"
                                        href="{{ route('v2.admin.transactions.details', $transaction->id) }}">
                                        View
                                    </a>
                                    {{-- <form action="{{ route('v2.admin.transactions.destroy', $agent->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="px-4 py-1 text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition duration-200 ease-in-out text-sm btn_delete"
                                            type="submit">
                                            Delete
                                        </button>
                                    </form> --}}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="py-6 text-center text-gray-500 dark:text-neutral-400" colspan="8">
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

    <script>
        var options = {
            series: [{
                    name: "Searched",
                    data: @json($domesticData['search'])
                },
                {
                    name: "Booked",
                    data: @json($domesticData['bookings'])
                }
            ],
            chart: {
                height: 500,
                type: 'line',
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'straight'
            },
            title: {
                text: 'Domestic Bookings Analytics (Past 7 days)',
                align: 'left',
                style: {
                    fontSize: '20px', // Equivalent to text-xl in Tailwind CSS
                    fontWeight: '600', // Equivalent to font-semibold in Tailwind CSS
                    color: '#4B5563' // Equivalent to text-gray-800 in Tailwind CSS (a dark gray color)
                }
            },
            grid: {
                row: {
                    colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.5
                },
            },
            xaxis: {
                categories: @json($domesticData['dates']),
            },
            colors: ['#22c55e', 'red']
        };

        var chart = new ApexCharts(document.querySelector("#domestic-agent-chart"), options);
        chart.render();

        var intloptions = {
            series: [{
                    name: "Searched",
                    data: @json($internationalData['search'])
                },
                {
                    name: "Booked",
                    data: @json($internationalData['bookings'])
                }
            ],
            chart: {
                height: 500,
                type: 'line',
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'straight'
            },
            title: {
                text: 'International Bookings Analytics (Past 7 days)',
                align: 'left',
                style: {
                    fontSize: '20px', // Equivalent to text-xl in Tailwind CSS
                    fontWeight: '600', // Equivalent to font-semibold in Tailwind CSS
                    color: '#4B5563' // Equivalent to text-gray-800 in Tailwind CSS (a dark gray color)
                }
            },
            grid: {
                row: {
                    colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.5
                },
            },
            xaxis: {
                categories: @json($internationalData['dates']),
            },
            colors: ['#22c55e', 'red']
        };

        var intlchart = new ApexCharts(document.querySelector("#international-agent-chart"), intloptions);
        intlchart.render();
    </script>
@endsection
