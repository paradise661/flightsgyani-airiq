<div>
    @if ($bookingView)
        <div class="p-2">
            <div class="">
                <div class="flex justify-between items-center">
                    <!-- Left section with booking details -->
                    <div class="flex space-x-6">
                        <div>
                            <strong class="font-semibold text-gray-700 text-sm">Flight Booking Code:</strong>
                            <span class="text-gray-600 text-sm">{{ $bookingView->booking_code ?? '' }}</span>
                        </div>
                        <div>
                            <strong class="font-semibold text-gray-700 text-sm">Ticket Status:</strong>
                            <span class="text-gray-600 text-sm">{{ $bookingView->ticket_status ?? '-' }}</span>
                        </div>
                    </div>

                    <!-- Right section with the Back button -->
                    <div>
                        <a href="" wire:click.prevent="backEvent()"
                            class="inline-block px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400 transition duration-300 text-sm">
                            Back
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <dl class="space-y-2">
                    <h2 class="text-xl font-semibold mb-2">Contact Details</h2>

                    <!-- Name -->
                    <div class="flex justify-between mb-2">
                        <dt class="w-1/3 font-semibold text-gray-600">Name</dt>
                        <dd class="w-2/3 text-gray-600">{{ $bookingView->emergency_contact_fullname ?? '' }}</dd>
                    </div>

                    <!-- Email -->
                    <div class="flex justify-between mb-2">
                        <dt class="w-1/3 font-semibold text-gray-600">Email</dt>
                        <dd class="w-2/3 text-gray-600">{{ $bookingView->emergency_contact_email ?? '' }}</dd>
                    </div>

                    <!-- Phone -->
                    <div class="flex justify-between mb-2">
                        <dt class="w-1/3 font-semibold text-gray-600">Phone</dt>
                        <dd class="w-2/3 text-gray-600">{{ $bookingView->emergency_contact_phone ?? '' }}</dd>
                    </div>
                </dl>
            </div>

            <hr class="my-4">

            <div class="">
                @foreach ($bookingView->flightInfo ?? [] as $flight)
                    <div class="col-md-6 mb-3">
                        <div class="">
                            <h4 class="text-xl font-semibold mb-2">
                                {{ $flight->flight_type == 'O' ? 'Departure' : 'Return' }} Flight
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                <!-- PNR -->
                                <div class="detail-item mb-2">
                                    <span class="text-gray-600 font-medium">PNR:</span>
                                    <span class="text-gray-600">{{ $flight->pnr_no ?? 'N/A' }}</span>
                                </div>

                                <!-- Flight -->
                                <div class="detail-item mb-2">
                                    <span class="text-gray-600 font-medium">Flight:</span>
                                    <span class="text-gray-600">{{ $flight->airline ?? 'N/A' }}
                                        {{ $flight->flight_no ?? 'N/A' }}</span>
                                </div>

                                <!-- Departure -->
                                <div class="detail-item mb-2">
                                    <span class="text-gray-600 font-medium">Departure:</span>
                                    <span class="text-gray-600">{{ $flight->departure ?? 'N/A' }}</span>
                                </div>

                                <!-- Departure Time -->
                                <div class="detail-item mb-2">
                                    <span class="text-gray-600 font-medium">Departure Time:</span>
                                    <span
                                        class="text-gray-600">{{ date('h:i A', strtotime($flight->departure_time)) }}</span>
                                </div>

                                <!-- Arrival -->
                                <div class="detail-item mb-2">
                                    <span class="text-gray-600 font-medium">Arrival:</span>
                                    <span class="text-gray-600">{{ $flight->arrival ?? 'N/A' }}</span>
                                </div>

                                <!-- Arrival Time -->
                                <div class="detail-item mb-2">
                                    <span class="text-gray-600 font-medium">Arrival Time:</span>
                                    <span
                                        class="text-gray-600">{{ date('h:i A', strtotime($flight->arrival_time)) }}</span>
                                </div>

                                <!-- Flight Date -->
                                <div class="detail-item mb-2">
                                    <span class="text-gray-600 font-medium">Flight Date:</span>
                                    <span
                                        class="text-gray-600">{{ date('Y-m-d', strtotime($flight->flight_date)) }}</span>
                                </div>

                                <!-- Ticket Type -->
                                <div class="detail-item mb-2">
                                    <span class="text-gray-600 font-medium">Ticket Type:</span>
                                    <span class="text-gray-600">
                                        {{ $flight->refundable == 'T' ? 'Refundable' : 'Non-Refundable' }}
                                    </span>
                                </div>

                                <!-- Class -->
                                <div class="detail-item mb-2">
                                    <span class="text-gray-600 font-medium">Class:</span>
                                    <span class="text-gray-600">{{ $flight->flight_class_code ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <hr class="my-4">
            <div class="">
                <table class="min-w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left border-b">
                            <th class="px-4 py-2 font-semibold text-gray-700">Passenger</th>
                            <th class="px-4 py-2 font-semibold text-gray-700">Ticket No</th>
                            <th class="px-4 py-2 font-semibold text-gray-700">Gender</th>
                            <th class="px-4 py-2 font-semibold text-gray-700">Nationality</th>
                            <th class="px-4 py-2 font-semibold text-gray-700">Sector</th>
                            <th class="px-4 py-2 font-semibold text-gray-700">Flight Date</th>
                            <th class="px-4 py-2 font-semibold text-gray-700">Flight No</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($bookingView->ticket_status == 'Issued')
                            @foreach ($bookingView->flightTicket ?? [] as $ticket)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3 text-gray-600">{{ $ticket->title }}.
                                        {{ $ticket->first_name }}
                                        {{ $ticket->last_name }} ({{ $ticket->pax_type }})
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">{{ $ticket->ticket_no }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $ticket->gender }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $ticket->nationality }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $ticket->sector }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $ticket->flight_date }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $ticket->flight_no }}</td>
                                </tr>
                            @endforeach
                        @else
                            @foreach ($booking->flightPassengers ?? [] as $ticket)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3 text-gray-600">{{ $ticket->title }} {{ $ticket->first_name }}
                                        {{ $ticket->last_name }} ({{ $ticket->pax_type }})
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">-</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $ticket->gender }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $ticket->nationality }}</td>
                                    <td class="px-4 py-3 text-gray-600">
                                        {{ $booking->sector_from }}-{{ $booking->sector_to }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $booking->departure_date }}</td>
                                    <td class="px-4 py-3 text-gray-600">-</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <hr class="my-4">

            <div class="">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Payment Method -->
                    <div class="flex items-center space-x-2 mb-2">
                        <span class="font-semibold text-gray-700">Payment Method:</span>
                        <span class="text-gray-600">{{ $bookingView->payment->payment_type ?? 'N/A' }}</span>
                    </div>

                    <!-- Amount Paid -->
                    <div class="flex items-center justify-end space-x-2 mb-2 text-right">
                        <span class="font-semibold text-gray-700">Amount Paid:</span>
                        <span class="text-gray-600">
                            {{ $bookingView->payment->currency ?? 'N/A' }}
                            {{ number_format($bookingView->payment->total_booking_amount, 2) ?? '0.00' }}
                        </span>
                        <span class="text-sm text-gray-500">
                            ({{ $bookingView->payment->payment_status ?? 'N/A' }})
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="flex justify-between items-center">
            <div>
                <h4 class="text-2xl font-semibold">Domestic Bookings</h4>
            </div>
            <div>
                <form action="">
                    <input value="" name="search" wire:model='search' placeholder="Search.."
                        class="py-3 px-4 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                        type="text">
                </form>
            </div>
        </div>
        <div class="flex flex-col">
            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                        SN
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                        Booking Code
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                        Sector
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                        Departure Date
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                        Arrival Date
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">
                                        Total Amount
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">
                                        Payment Status
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">
                                        Ticket Status
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">
                                        Booking Date
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $key =>  $booking)
                                    <tr class="odd:bg-white even:bg-gray-100 hover:bg-gray-100">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                            {{ $key + $bookings->firstItem() }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                            {{ $booking->booking_code ?? '' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                            {{ $booking->sector_from ?? '' }}-{{ $booking->sector_to ?? '' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                            {{ $booking->departure_date ?? '' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                            {{ $booking->flight_type == 'R' ? $booking->arrival_date : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                            {{ $booking->total_booking_amount ?? '' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                            {{ $booking->payment->payment_status ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                            {{ $booking->ticket_status ?? '' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                            {{ $booking->created_at->format('Y-m-d') ?? '' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                            <a href=""
                                                wire:click.prevent='viewBooking("{{ $booking->booking_code }}")'
                                                class="inline-flex items-center text-xs bg-primary font-medium px-3 py-2 rounded-lg border border-transparent text-white focus:outline-none disabled:opacity-50 disabled:pointer-events-none">
                                                View
                                            </a>
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td class="text-center p-4" colspan="9">
                                            {{ 'Sorry could not find ur booking' }}
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
            <div class="mt-8">
                {{ $bookings->links() }}
            </div>
        </div>


    @endif
</div>
