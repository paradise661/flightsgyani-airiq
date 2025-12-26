@extends('layouts.admin.app')
@section('content')
    <div class="flex justify-between items-center mb-4">
        <!-- First Heading (Add New Branch) -->
        <div class="flex-1">
            <h3 class="text-lg font-semibold text-gray-800">Transaction Details</h3>
        </div>

        <!-- Last Heading (Back) -->
        <div class="flex-none">
            <a class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400"
                href="{{ route('v2.admin.transactions.all') }}">
                Back
            </a>
        </div>
    </div>
    @include('admin.v2.inc.messages')

    <div class="overflow-x-auto shadow-md sm:rounded-lg">
        <table class="min-w-full table-auto">
            <tbody>
                <tr class="border-t">
                    <td class="px-4 py-2 text-sm font-medium text-gray-700">Agent Name</td>
                    <td class="px-4 py-2 text-sm text-gray-900">
                        @if ($transaction->agent->name ?? '')
                            <a class="text-blue-700 underline"
                                href="{{ route('v2.admin.agents.show', $transaction->agent_id) }}">
                                {{ $transaction->agent->name ?? '-' }}
                            </a>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr class="border-t">
                    <td class="px-4 py-2 text-sm font-medium text-gray-700">Invoice ID</td>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $transaction->invoice_id }}</td>
                </tr>
                <tr class="border-t">
                    <td class="px-4 py-2 text-sm font-medium text-gray-700">Currency Type</td>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $transaction->currency_type }}</td>
                </tr>
                <tr class="border-t">
                    <td class="px-4 py-2 text-sm font-medium text-gray-700">Amount</td>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $transaction->amount }}</td>
                </tr>
                <tr class="border-t">
                    <td class="px-4 py-2 text-sm font-medium text-gray-700">Transaction Type</td>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $transaction->transaction_type }}</td>
                </tr>
                <tr class="border-t">
                    <td class="px-4 py-2 text-sm font-medium text-gray-700">Method</td>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $transaction->load_type ?? '' }}</td>
                </tr>
                <tr class="border-t">
                    <td class="px-4 py-2 text-sm font-medium text-gray-700">Status</td>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $transaction->status }}</td>
                </tr>
                <tr class="border-t">
                    <td class="px-4 py-2 text-sm font-medium text-gray-700">Invoice Date</td>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $transaction->created_at }}</td>
                </tr>
                <tr class="border-t">
                    <td class="px-4 py-2 text-sm font-medium text-gray-700">Remarks</td>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $transaction->remarks }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
