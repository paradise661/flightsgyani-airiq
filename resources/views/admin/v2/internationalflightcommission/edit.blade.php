@extends('layouts.admin.app')
@section('content')
    <style>
        .select2-selection {
            height: 40px !important;
        }

        .text-strikethrough {
            text-decoration: line-through;
            color: gray;
            align-content: center;
        }
    </style>
    @include('admin.v2.inc.messages')
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <!-- First Heading (Add New Branch) -->
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-800">Update Discount</h3>
                </div>

                <!-- Last Heading (Back) -->
                <div class="flex-none">
                    <a class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400"
                        href="{{ route('v2.admin.commissions.index') }}">
                        Back
                    </a>
                </div>
            </div>
            <!-- form start -->
            <form id="form" role="form"
                action="{{ route('v2.admin.commissions.update', $commission->id) }}"
                method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Row 1: Name -->
                    <div class="grid grid-cols-1">
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="name">Airline<span
                                    class="text-red-500">*</span></label>
                            <select
                                class="select2 mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm @error('international_airline_id') border-red-500 @enderror"
                                id="international_airline_id" name="international_airline_id">
                                @foreach ($airlines as $airline)
                                    <option value="{{ $airline->id ?? '' }}"
                                        {{ $commission->international_airline_id == $airline->id ? 'selected' : '' }}>
                                        {{ $airline->name ?? '' }} ({{ $airline->code ?? '' }})</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('international_airline_id'))
                            <i class="text-sm text-red-500">*{{ $errors->first('international_airline_id') }}</i>
                        @endif
                    </div>

                    <div class="relative border border-gray-300 rounded-md px-4 pt-4 pb-4 mt-6">
                        <!-- Floating label -->
                        <div class="absolute left-4 bg-white px-2 text-sm font-semibold text-gray-700" style="top:-10px">
                            Discount For Normal Customers
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Adult -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="adult">Adult</label>
                                <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                    id="adult"  type="number" name="commission"
                                    value="{{ old('commission', $commission->commission) }}">
                                @error('commission')
                                    <i class="text-sm text-red-500">*{{ $message }}</i>
                                @enderror
                            </div>

                            <!-- Child -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="child">Child</label>
                                <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                    id="child"  type="number" name="child_commission"
                                    value="{{ old('child_commission', $commission->child_commission) }}">
                                @error('child_commission')
                                    <i class="text-sm text-red-500">*{{ $message }}</i>
                                @enderror
                            </div>

                            <!-- Infant -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="infant">Infant</label>
                                <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                    id="infant"  type="number" name="infant_commission"
                                    value="{{ old('infant_commission', $commission->infant_commission) }}">
                                @error('infant_commission')
                                    <i class="text-sm text-red-500">*{{ $message }}</i>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="relative border border-gray-300 rounded-md px-4 pt-4 pb-4 mt-6">
                        <!-- Floating label -->
                        <div class="absolute left-4 bg-white px-2 text-sm font-semibold text-gray-700" style="top:-10px">
                            Discount For Agents
                        </div>
                        <div class="grid grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Adult</label>
                                <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                    id="adult"  type="number" name="agent_commission"
                                    value="{{ old('agent_commission', $commission->agent_commission) }}">
                                @error('agent_commission')
                                    <i class="text-sm text-red-500">*{{ $message }}</i>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Child</label>
                                <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                    id="child"  type="number" name="agent_child_commission"
                                    value="{{ old('agent_child_commission', $commission->agent_child_commission) }}">
                                @error('agent_child_commission')
                                    <i class="text-sm text-red-500">*{{ $message }}</i>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Infant</label>
                                <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                    id="infant"  type="number" name="agent_infant_commission"
                                    value="{{ old('agent_infant_commission', $commission->agent_infant_commission) }}">
                                @error('agent_infant_commission')
                                    <i class="text-sm text-red-500">*{{ $message }}</i>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Row 4: Status -->
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="status">Status</label>
                            <select
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm @error('status') border-red-500 @enderror"
                                id="status" name="status">
                                <option {{ $commission->status == 1 ? 'selected' : '' }} value="1">
                                    Active
                                </option>
                                <option {{ $commission->status == 0 ? 'selected' : '' }} value="0">
                                    Inactive</option>
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
                        Update
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection
