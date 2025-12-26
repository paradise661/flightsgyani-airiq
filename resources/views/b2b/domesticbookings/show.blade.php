@extends('layouts.admin.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary flex justify-between">
                <div class="box-header">
                    <strong>Flight Booking ID :-</strong> {{ $booking->booking_code ?? '' }}
                    <div class="">
                        <strong>Ticket Status :-</strong> {{ $booking->ticket_status ?? '-' }}
                    </div>
                </div>
                <div class="box-header">
                    <a class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400"
                        href="{{ route('b2b.agent.domestic.flight.bookings') }}">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="w-full mx-auto">

            <div class="w-full mx-auto bg-white p-6 rounded-lg shadow-xl">
                <!-- Tab Buttons -->
                <div class="flex space-x-6 border-b-2 pb-4 mb-6">
                    <button
                        class="tab-button w-full py-3 text-center text-gray-600 hover:text-white hover:bg-primary focus:outline-none"
                        id="tab1">
                        Contact Details
                    </button>
                    <button
                        class="tab-button w-full py-3 text-center text-gray-600 hover:text-white hover:bg-primary focus:outline-none"
                        id="tab2">
                        Flight Details
                    </button>
                    <button
                        class="tab-button w-full py-3 text-center text-gray-600 hover:text-white hover:bg-primary focus:outline-none"
                        id="tab3">
                        Passenger/Ticket Details
                    </button>
                    <button
                        class="tab-button w-full py-3 text-center text-gray-600 hover:text-white hover:bg-primary focus:outline-none"
                        id="tab4">
                        Payment Details
                    </button>

                </div>

                <!-- Tab Content -->
                <div class="tab-content ">
                    <!-- Tab 1 Content -->
                    <div class="tab-panel tab-content-box hidden" id="content1">
                        {{-- <h2 class="text-xl font-semibold mb-3">Tab 1 Content</h2> --}}

                        <div class="">
                            <dl class="space-y-4 text-gray-700">
                                <!-- Name -->
                                <div class="flex">
                                    <dt class="w-1/3 font-semibold">Name</dt>
                                    <dd class="w-2/3">{{ $booking->emergency_contact_fullname ?? '' }}
                                    </dd>
                                </div>

                                <!-- Email -->
                                <div class="flex">
                                    <dt class="w-1/3 font-semibold">Email</dt>
                                    <dd class="w-2/3">{{ $booking->emergency_contact_email ?? '' }}
                                    </dd>
                                </div>

                                <!-- Phone -->
                                <div class="flex">
                                    <dt class="w-1/3 font-semibold">Phone</dt>
                                    <dd class="w-2/3">{{ $booking->emergency_contact_phone ?? '' }}
                                    </dd>
                                </div>

                                <hr>
                                @if ($booking->is_office_staff)
                                    <h2><strong>Staff Details</strong></h2>
                                    <!-- Name -->
                                    <div class="flex">
                                        <dt class="w-1/3 font-semibold">Name</dt>
                                        <dd class="w-2/3">{{ $booking->user->name ?? '' }}
                                        </dd>
                                    </div>

                                    <!-- Email -->
                                    <div class="flex">
                                        <dt class="w-1/3 font-semibold">Email</dt>
                                        <dd class="w-2/3">{{ $booking->user->email ?? '' }}
                                        </dd>
                                    </div>

                                    <!-- Phone -->
                                    <div class="flex">
                                        <dt class="w-1/3 font-semibold">Phone</dt>
                                        <dd class="w-2/3">{{ $booking->user->phonenumber ?? '' }}
                                        </dd>
                                    </div>
                                @endif

                            </dl>
                        </div>

                    </div>
                    <!-- Tab 2 Content -->
                    <div class="tab-panel tab-content-box hidden" id="content2">
                        <div class="">
                            @foreach ($booking->flightInfo ?? [] as $flight)
                                <div class="col-md-6 mb-5">
                                    <div class="">
                                        <h4 class="text-xl font-semibold mb-4">
                                            {{ $flight->flight_type == 'O' ? 'Departure' : 'Return' }} Flight
                                        </h4>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <!-- PNR -->
                                            <div class="detail-item">
                                                <span class="text-gray-600 font-medium">PNR:</span>
                                                <span class="text-gray-900">{{ $flight->pnr_no ?? 'N/A' }}</span>
                                            </div>

                                            <!-- Flight -->
                                            <div class="detail-item">
                                                <span class="text-gray-600 font-medium">Flight:</span>
                                                <span class="text-gray-900">{{ $flight->airline ?? 'N/A' }}
                                                    {{ $flight->flight_no ?? 'N/A' }}</span>
                                            </div>

                                            <!-- Departure -->
                                            <div class="detail-item">
                                                <span class="text-gray-600 font-medium">Departure:</span>
                                                <span class="text-gray-900">{{ $flight->departure ?? 'N/A' }}</span>
                                            </div>

                                            <!-- Departure Time -->
                                            <div class="detail-item">
                                                <span class="text-gray-600 font-medium">Departure Time:</span>
                                                <span
                                                    class="text-gray-900">{{ date('h:i A', strtotime($flight->departure_time)) }}</span>
                                            </div>

                                            <!-- Arrival -->
                                            <div class="detail-item">
                                                <span class="text-gray-600 font-medium">Arrival:</span>
                                                <span class="text-gray-900">{{ $flight->arrival ?? 'N/A' }}</span>
                                            </div>

                                            <!-- Arrival Time -->
                                            <div class="detail-item">
                                                <span class="text-gray-600 font-medium">Arrival Time:</span>
                                                <span
                                                    class="text-gray-900">{{ date('h:i A', strtotime($flight->arrival_time)) }}</span>
                                            </div>

                                            <div class="detail-item">
                                                <span class="text-gray-600 font-medium">Flight Date:</span>
                                                <span
                                                    class="text-gray-900">{{ date('Y-m-d', strtotime($flight->flight_date)) }}</span>
                                            </div>

                                            <!-- Ticket Type -->
                                            <div class="detail-item">
                                                <span class="text-gray-600 font-medium">Ticket Type:</span>
                                                <span class="text-gray-900">
                                                    {{ $flight->refundable == 'T' ? 'Refundable' : 'Non-Refundable' }}
                                                </span>
                                            </div>

                                            <!-- Class -->
                                            <div class="detail-item">
                                                <span class="text-gray-600 font-medium">Class:</span>
                                                <span
                                                    class="text-gray-900">{{ $flight->flight_class_code ?? 'N/A' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                    <!-- Tab 3 Content -->
                    <div class="tab-panel tab-content-box hidden" id="content3">
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
                                    @if ($booking->ticket_status == 'Issued')
                                        @foreach ($booking->flightTicket ?? [] as $ticket)
                                            <tr class="border-b hover:bg-gray-50">
                                                <td class="px-4 py-3">{{ $ticket->title }}. {{ $ticket->first_name }}
                                                    {{ $ticket->last_name }}
                                                    ({{ $ticket->pax_type }})
                                                </td>
                                                <td class="px-4 py-3">{{ $ticket->ticket_no }}</td>
                                                <td class="px-4 py-3">{{ $ticket->gender }}</td>
                                                <td class="px-4 py-3">{{ $ticket->nationality }}</td>
                                                <td class="px-4 py-3">{{ $ticket->sector }}</td>
                                                <td class="px-4 py-3">{{ $ticket->flight_date }}</td>
                                                <td class="px-4 py-3">{{ $ticket->flight_no }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        @foreach ($booking->flightPassengers ?? [] as $ticket)
                                            <tr class="border-b hover:bg-gray-50">
                                                <td class="px-4 py-3">{{ $ticket->title }} {{ $ticket->first_name }}
                                                    {{ $ticket->last_name }}
                                                    ({{ $ticket->pax_type }})
                                                </td>
                                                <td class="px-4 py-3">-</td>
                                                <td class="px-4 py-3">{{ $ticket->gender }}</td>
                                                <td class="px-4 py-3">{{ $ticket->nationality }}</td>
                                                <td class="px-4 py-3">
                                                    {{ $booking->sector_from }}-{{ $booking->sector_to }}</td>
                                                <td class="px-4 py-3">{{ $booking->departure_date }}</td>
                                                <td class="px-4 py-3">-</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>

                            <a class="mt-4 inline-block px-4 py-2 text-white bg-green-500 font-medium text-sm rounded-md shadow-md hover:bg-green-600 focus:outline-none focus:ring-transparent"
                                href="{{ route('viewTicket', ['booking_code' => $booking->booking_code, 'email' => $booking->emergency_contact_email, 'type' => 'domestic']) }}"
                                target="_blank">
                                View Ticket
                            </a>
                        </div>

                    </div>
                    <!-- Tab 4 Content -->
                    <div class="tab-panel tab-content-box hidden" id="content4">
                        <div class="">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Payment Method -->
                                <div class="flex items-center space-x-2">
                                    <span class="font-semibold text-gray-700">Payment Method:</span>
                                    <span class="text-gray-600">{{ $booking->payment->payment_type ?? 'N/A' }}</span>
                                </div>

                                <!-- Amount Paid -->
                                <div class="flex items-center justify-end space-x-2 text-right">
                                    <span class="font-semibold text-gray-700">Amount After Commission:</span>
                                    <span class="text-gray-600">
                                        {{ $booking->payment->currency ?? 'N/A' }}
                                        {{ number_format($booking->payment->total_booking_amount, 2) ?? '0.00' }}
                                    </span>
                                    <span class="text-sm text-gray-500">
                                        ({{ $booking->payment->payment_status ?? 'N/A' }})
                                    </span>
                                </div>

                                <div class="flex items-center justify-end space-x-2 text-right">
                                    <span class="font-semibold text-gray-700">Total Amount</span>
                                    <span class="text-gray-600">
                                        {{ $booking->payment->currency ?? 'N/A' }}
                                        {{ number_format($booking->payment->total_booking_amount + $booking->discount_amount, 2) ?? '0.00' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function() {
                    // Initially activate the first tab
                    $('#tab1').addClass('active bg-primary text-white');
                    $('#content1').removeClass('hidden').addClass('tab-panel-visible');

                    // Event listener for tab clicks
                    $('.tab-button').click(function() {
                        // Remove active class from all tabs and hide all content
                        $('.tab-button').removeClass('active bg-primary text-white');
                        $('.tab-panel').removeClass('tab-panel-visible').addClass('hidden');

                        // Get the id of the clicked tab and set it as active
                        var tabId = $(this).attr('id');
                        var contentId = '#content' + tabId.replace('tab', '');

                        // Add active class to the clicked tab and show the content
                        $(this).addClass('active bg-primary text-white');
                        $(contentId).removeClass('hidden').addClass('tab-panel-visible');
                    });
                });
            </script>
        </div>

    </div>
@endsection
