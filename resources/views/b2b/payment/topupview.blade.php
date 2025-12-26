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
                href="{{ route('v2.admin.transactions.list') }}">
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
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $transaction->agent->name ?? '' }}</td>
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
                    <td class="px-4 py-2 text-sm font-medium text-gray-700">Loaded By</td>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $transaction->user->name ?? '' }}</td>
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
    <div class="max-w-md p-4 bg-white shadow-md rounded-lg">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Update Status</h2>
        <form action="{{ route('v2.admin.transactions.edit', $transaction->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600" for="status">Status</label>
                <select
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md text-gray-700 focus:ring-indigo-500 focus:border-indigo-500"
                    id="status" name="status">
                    <option {{ $transaction->status == 'DUE' ? 'selected' : '' }} value="DUE">DUE</option>
                    <option {{ $transaction->status == 'PAID' ? 'selected' : '' }} value="PAID">PAID</option>
                    <option {{ $transaction->status == 'CANCELLED' ? 'selected' : '' }} value="CANCELLED">CANCELLED
                    </option>
                </select>
            </div>
            <div class="flex ">
                <button
                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
                    type="submit">Update Status</button>
            </div>
        </form>
    </div>
@endsection
