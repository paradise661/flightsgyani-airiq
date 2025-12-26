@extends('layouts.admin.app')
@section('content')
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div
            class="bg-white shadow-lg rounded-xl p-6 flex items-center space-x-6 hover:shadow-2xl transition-shadow duration-300">
            <!-- Profile Icon (SVG) -->
            <svg class="w-16 h-16 text-white bg-red-500 p-4 rounded-full" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path
                    d="M12 12c2.485 0 4.5-2.015 4.5-4.5S14.485 3 12 3 7.5 5.015 7.5 7.5 9.515 12 12 12zM12 14c-3.5 0-7 1.75-7 5.25v1.75h14v-1.75c0-3.5-3.5-5.25-7-5.25z">
                </path>
            </svg>
            <div>
                <h5 class="font-semibold text-xl text-gray-800">{{ Auth::user()->name }}</h5>
                <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                <p class="text-sm text-gray-500">{{ Auth::user()->phonenumber }}</p>
            </div>
        </div>

        <!-- Wallet Card -->
        <div
            class="bg-white shadow-lg rounded-xl p-6 flex items-center space-x-6 hover:shadow-2xl transition-shadow duration-300">
            <!-- Wallet Icon (SVG) -->
            <svg class="w-16 h-16 text-white bg-green-500 p-4 rounded-full" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path
                    d="M3 7h18M3 12h18M3 17h18M6 2h12c1.1 0 1.99.9 1.99 2L20 19c0 1.1-.89 2-1.99 2H4c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2z">
                </path>
            </svg>
            <div>
                <h5 class="font-semibold text-xl text-gray-800">Current Balance</h5>
                <p class="text-sm text-gray-500">NPR: <span
                        class="text-green-600">{{ remainingBalance(Auth::user()->id, 'NPR') }}</span></p>
                <p class="text-sm text-gray-500">USD: <span
                        class="text-green-600">{{ remainingBalance(Auth::user()->id, 'USD') }}</span></p>
            </div>
        </div>

        <div
            class="bg-white shadow-lg rounded-xl p-6 flex items-center space-x-6 hover:shadow-2xl transition-shadow duration-300">
            <!-- Wallet Icon (SVG) -->
            <div class="flex justify-center items-center">
                <svg class="w-16 h-16 text-white bg-green-500 p-4 rounded-full" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC"
                        stroke-width="0.1"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path
                            d="M24.794 16.522l-.281-2.748-10.191-5.131s.091-1.742 0-4.31c-.109-1.68-.786-3.184-1.839-4.339l.005.006h-.182c-1.048 1.15-1.726 2.653-1.834 4.312l-.001.021c-.091 2.567 0 4.31 0 4.31l-10.19 5.131-.281 2.748 6.889-2.074 3.491-.582c-.02.361-.031.783-.031 1.208 0 2.051.266 4.041.764 5.935l-.036-.162-2.728 1.095v1.798l3.52-.8c.155.312.3.566.456.812l-.021-.035v.282c.032-.046.062-.096.093-.143.032.046.061.096.094.143v-.282c.135-.21.28-.464.412-.726l.023-.051 3.52.8v-1.798l-2.728-1.095c.463-1.733.728-3.723.728-5.774 0-.425-.011-.847-.034-1.266l.003.058 3.492.582 6.888 2.074z">
                        </path>
                    </g>
                </svg>
            </div>

            <div>
                <h5 class="font-semibold text-xl text-gray-800">Domestic Bookings</h5>
                <p class="text-sm text-gray-500"><span
                        class="font-bold text-green-600 text-lg">{{ $agent->domesticBookings->count() }}</span>
                </p>
                <p class="text-sm text-gray-500">Last Booked Date: <span
                        class="text-green-600">{{ $agent->domesticBookings->first()->created_at ?? 'No Booking Found' }}</span>
                </p>
            </div>
        </div>

        <div
            class="bg-white shadow-lg rounded-xl p-6 flex items-center space-x-6 hover:shadow-2xl transition-shadow duration-300">
            <svg class="w-16 h-16 text-white bg-red-500 p-4 rounded-full" xmlns="http://www.w3.org/2000/svg" width="24"
                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC"
                    stroke-width="0.1"></g>
                <g id="SVGRepo_iconCarrier">
                    <path
                        d="M24.794 16.522l-.281-2.748-10.191-5.131s.091-1.742 0-4.31c-.109-1.68-.786-3.184-1.839-4.339l.005.006h-.182c-1.048 1.15-1.726 2.653-1.834 4.312l-.001.021c-.091 2.567 0 4.31 0 4.31l-10.19 5.131-.281 2.748 6.889-2.074 3.491-.582c-.02.361-.031.783-.031 1.208 0 2.051.266 4.041.764 5.935l-.036-.162-2.728 1.095v1.798l3.52-.8c.155.312.3.566.456.812l-.021-.035v.282c.032-.046.062-.096.093-.143.032.046.061.096.094.143v-.282c.135-.21.28-.464.412-.726l.023-.051 3.52.8v-1.798l-2.728-1.095c.463-1.733.728-3.723.728-5.774 0-.425-.011-.847-.034-1.266l.003.058 3.492.582 6.888 2.074z">
                    </path>
                </g>
            </svg>
            <div>
                <h5 class="font-semibold text-xl text-gray-800">Intl Bookings</h5>
                <p class="text-sm text-gray-500"><span
                        class="text-green-600 font-bold text-lg">{{ $agent->internationalBookings->count() }}</span></p>
                <p class="text-sm text-gray-500">Last Booked Date: <span
                        class="text-green-600">{{ $agent->internationalBookings->first()->created_at ?? 'No Booking Found' }}</span>
                </p>
            </div>
        </div>

        <div
            class="bg-white shadow-lg rounded-xl p-6 flex items-center space-x-6 hover:shadow-2xl transition-shadow duration-300">
            <svg class="w-16 h-16 text-white bg-green-500 p-4 rounded-full" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path
                    d="M3 7h18M3 12h18M3 17h18M6 2h12c1.1 0 1.99.9 1.99 2L20 19c0 1.1-.89 2-1.99 2H4c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2z">
                </path>
            </svg>
            <div>
                <h5 class="font-semibold text-xl text-gray-800">Payment</h5>
                <p class="text-sm text-gray-500">DUE: <span
                        class="text-green-600">{{ paymentRecord($agent->id)->due ?? 0 }}</span></p>
                <p class="text-sm text-gray-500">PAID: <span
                        class="text-green-600">{{ paymentRecord($agent->id)->paid ?? 0 }}</span></p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6 bg-white p-6 rounded-md">

        <div id="domestic-agent-chart"></div>
        <div id="international-agent-chart"></div>
    </div>

    <livewire:b2b.agenttransaction :agent="$agent->id" />

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
                height: 400,
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
                height: 400,
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
