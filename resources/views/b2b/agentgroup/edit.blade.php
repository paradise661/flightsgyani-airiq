@extends('layouts.admin.app')
@section('content')
    @include('admin.v2.inc.messages')
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-800">Update Agent Group</h3>
                </div>

                <!-- Last Heading (Back) -->
                <div class="flex-none">
                    <a class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400"
                        href="{{ route('v2.admin.agentgroups.index') }}">
                        Back
                    </a>
                </div>
            </div>
            <!-- form start -->
            <form id="form" role="form" action="{{ route('v2.admin.agentgroups.update', $agentgroup->id) }}"
                method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Row 1: Name -->
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="name">Name<span
                                    class="text-red-500">*</span></label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="name" type="text" name="name" value="{{ old('name', $agentgroup->name) }}">
                            @if ($errors->has('name'))
                                <i class="text-sm text-red-500">*{{ $errors->first('name') }}</i>
                            @endif
                        </div>
                    </div>

                    <!-- Row 3: Order -->
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="order">Order</label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="order" type="number" min="1" name="order"
                                value="{{ old('order', $agentgroup->order) }}">
                            @if ($errors->has('order'))
                                <i class="text-sm text-red-500">*{{ $errors->first('order') }}</i>
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
                                <option value="1" {{ $agentgroup->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $agentgroup->status == 0 ? 'selected' : '' }}>Inactive</option>
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
