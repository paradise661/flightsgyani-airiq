@extends('layouts.admin.app')
@section('content')
    @include('admin.v2.inc.messages')
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <!-- First Heading (Add New Branch) -->
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-800">Add New Discount</h3>
                </div>

                <!-- Last Heading (Back) -->
                <div class="flex-none">
                    <a class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400"
                        href="{{ route('v2.admin.domestic.commissions.index') }}">
                        Back
                    </a>
                </div>
            </div>
            <!-- form start -->
            <form id="form" role="form" action="{{ route('v2.admin.domestic.commissions.store') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <!-- Row 1: Name -->
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="name">Airline<span
                                    class="text-red-500">*</span></label>
                            <select
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm @error('status') border-red-500 @enderror"
                                id="status" name="domestic_airline_id">
                                @foreach ($airlines as $airline)
                                    <option value="{{ $airline->id ?? '' }}"
                                        {{ old('status') == $airline->id ? 'selected' : '' }}>
                                        {{ $airline->name ?? '' }} ({{ $airline->code ?? '' }})</option>
                                @endforeach
                            </select>
                            @if ($errors->has('domestic_airline_id'))
                                <i class="text-sm text-red-500">*{{ $errors->first('domestic_airline_id') }}</i>
                            @endif
                        </div>
                    </div>

                    <!-- Row 2: Code -->
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="code">Discount Amount For Normal Customers</label>
                            <input min="1" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="commission" type="number" name="commission" value="{{ old('commission') }}">
                            @if ($errors->has('commission'))
                                <i class="text-sm text-red-500">*{{ $errors->first('commission') }}</i>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="code">Discount Amount For Agents</label>
                            <input min="1" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="agent_commission" type="number" name="agent_commission" value="{{ old('agent_commission') }}">
                            @if ($errors->has('agent_commission'))
                                <i class="text-sm text-red-500">*{{ $errors->first('agent_commission') }}</i>
                            @endif
                        </div>
                    </div>

                    <!-- Row 4: Status -->
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="status">Status</label>
                            <select
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm @error('status') border-red-500 @enderror"
                                id="status" name="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            @error('status')
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
                        Submit
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection
