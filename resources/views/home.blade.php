@extends('layouts.user-dashboard')



@section('content')
<div class="flex justify-between items-center">
    <div>
        <h4 class="text-2xl font-semibold">International Bookings</h4>
    </div>
    <div>
        <form action="{{ route("home") }}">
            <input value="{{ request()->query("q") }}" name="q" placeholder="Search.." class="py-3 px-4 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" type="text">
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
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                SN
                            </th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                Booking Date
                            </th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                Booking Code
                            </th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                PRN
                            </th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                Sector
                            </th>
                            <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">
                                Airline
                            </th>
                            <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">
                                Flight Date
                            </th>
                            <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">
                                Contact
                            </th>
                            <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">
                                Air Price
                            </th>
                            <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">
                                Ticket Status
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($booking as $k =>  $s)

                            <tr class="odd:bg-white even:bg-gray-100 hover:bg-gray-100">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                    {{ $k + $booking->firstItem() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                    {{ $s->created_at->toFormattedDateString() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                    <a
                                        href="{{ route('admin.view.flight.booking', $s->booking_code) }}">{{ $s->booking_code }}</a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                    {{ $s->pnr_id ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                    @php
                                        $sector = '';
                                        foreach (json_decode($s->flights, true)['flight'] as $val) {
                                            if (isset($val['sectors'])) {
                                                foreach ($val['sectors'] as $key) {
                                                    $sector .= $key['departure'] . '->' . $key['arrival'] . ',';
                                                }
                                            }
                                        }
                                    @endphp
                                    {{ $sector }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                    {{ $s->airline }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                    {{ $s->flight_date }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                @php
                                    $contact = json_decode($s->contact_details, true);
                                    $name = $contact['name'] ?? '';
                                    $mname = $contact['mname'] ?? '';
                                    $lname = $contact['lname'] ?? '';
                                    $phone = $contact['phone'] ?? '';
                                @endphp
                                {{ $name }} {{ $mname }} {{ $lname }}, {{ $phone }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                    {{ $s->currency . ' ' . $s->final_fare }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                    <a href="{{ route('home.booking.detail', $s->id) }}"
                                        class="inline-flex items-center text-xs bg-primary font-medium px-3 py-2 rounded-lg border border-transparent text-white focus:outline-none disabled:opacity-50 disabled:pointer-events-none">
                                        View
                                    </a>

                                    {{-- @if ($s->ticket_status)
                                                                    <a href="{{ route('show.ticket', $s->booking_code) }}"
                                                                        class="inline-flex items-center text-xs bg-primary font-medium px-3 py-2 rounded-lg border border-transparent text-white focus:outline-none disabled:opacity-50 disabled:pointer-events-none">
                                                                        View
                                                                        Ticket</a>
                                                                @else
                                                                    {{ 'Pending' }}
                                                                @endif --}}
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
        {{$booking->links()}}
    </div>
</div>

@endsection
