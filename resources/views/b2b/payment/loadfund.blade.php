@extends('layouts.admin.app')
@section('content')
    <style>
        /* Increase height of select2 */
        .select2 {
            height: 40px;
        }

        .select2-container .select2-selection--single {
            height: 40px !important;
        }

        .select2-container .select2-selection__rendered {
            line-height: 30px !important;
        }

        /* Center the placeholder text inside the select2 input */
        .select2-container .select2-selection--single .select2-selection__placeholder {
            text-align: center;
            width: 100%;
        }

        /* Optional: Make sure the text is vertically centered */
        .select2-container .select2-selection--single {
            display: flex;
            align-items: center;
        }
    </style>
    @include('admin.v2.inc.messages')
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <!-- First Heading (Add New Branch) -->
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-800">Load Fund for Agent</h3>
                </div>

                <!-- Last Heading (Back) -->
                <div class="flex-none">
                    <a class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400"
                        href="{{ route('v2.admin.transactions.list') }}">
                        Back
                    </a>
                </div>
            </div>
            <!-- form start -->
            <form id="form" role="form" action="{{ route('v2.admin.load.fund.store') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <!-- Row 1: Name -->
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="name">Agent<span
                                    class="text-red-500">*</span></label>
                            <select id="agent-select"
                                class="select2 mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                name="agent_id">
                                <option value="">Select Agent</option>
                                @foreach ($agents as $agent)
                                    <option value="{{ $agent->id }}" @if ($agent->id == old('agent_id')) selected @endif>
                                        {{ $agent->name ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('agent_id'))
                                <i class="text-sm text-red-500">*{{ $errors->first('agent_id') }}</i>
                            @endif
                        </div>
                    </div>

                    @foreach ($agents as $agent)
                        <div class="balance-section space-y-4 hidden view-currentbalance-{{ $agent->id }}">
                            @php
                                $amount = remainingBalance($agent->id);
                            @endphp
                            <div
                                class="p-4 bg-white border rounded-lg shadow-sm hover:shadow-md transition duration-200 ease-in-out">
                                <h2 class="text-lg font-semibold text-gray-800 mb-3">Current Remaining Balance</h2>
                                <div class="text-sm text-gray-700">
                                    <p class="mb-1">NPR: <span
                                            class="font-bold text-green-500">{{ $amount['NPR'] }}</span></p>
                                    <p class="mb-1">USD: <span class="font-bold text-blue-500">{{ $amount['USD'] }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="name">Currency<span
                                    class="text-red-500">*</span></label>
                            <select id="multiselect"
                                class="select2 mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                name="currency_type">
                                <option value="NPR" {{ old('currency_type') == 'NPR' ? 'selected' : '' }}>NPR</option>
                                <option value="USD" {{ old('currency_type') == 'USD' ? 'selected' : '' }}>USD</option>
                            </select>
                            @if ($errors->has('currency_type'))
                                <i class="text-sm text-red-500">*{{ $errors->first('currency_type') }}</i>
                            @endif
                        </div>
                    </div>

                    <!-- Row 3: Order -->
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="amount">Amount</label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="amount" type="number" min="1" name="amount" value="{{ old('amount') }}">
                            @if ($errors->has('amount'))
                                <i class="text-sm text-red-500">*{{ $errors->first('amount') }}</i>
                            @endif
                        </div>
                    </div>

                    <!-- Row 4: Status -->
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="remarks">Remarks</label>
                            <input type="text"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm @error('remarks') border-red-500 @enderror"
                                name="remarks">
                            @error('remarks')
                                <i class="text-sm text-red-500">*{{ $message }}</i>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button
                        class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none"
                        type="submit">
                        Load
                    </button>
                </div>
            </form>

        </div>
    </div>
    <script>
        $('#agent-select').change(function(e) {
            let id = $(this).val();
            $('.balance-section').hide();
            $('.view-currentbalance-' + id).show();
        })
    </script>
@endsection
