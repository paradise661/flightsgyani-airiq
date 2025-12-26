@extends('layouts.admin.app')
@section('content')
    @include('admin.v2.inc.messages')
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-800">Update Agent</h3>
                </div>

                <!-- Last Heading (Back) -->
                <div class="flex-none">
                    <a class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400"
                        href="{{ route('v2.admin.agents.index') }}">
                        Back
                    </a>
                </div>
            </div>
            <!-- form start -->
            <form id="form" role="form" action="{{ route('v2.admin.agents.update', $agent->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="name">Name<span
                                    class="text-red-500">*</span></label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="name" type="text" name="name" value="{{ old('name', $agent->name) }}">
                            @if ($errors->has('name'))
                                <i class="text-sm text-red-500">*{{ $errors->first('name') }}</i>
                            @endif
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="email">Email<span
                                    class="text-red-500">*</span></label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="email" type="email" name="email" value="{{ old('email', $agent->email) }}">
                            @if ($errors->has('email'))
                                <i class="text-sm text-red-500">*{{ $errors->first('email') }}</i>
                            @endif
                        </div>
                    </div>

                    <!-- Row 2: Address and PAN/VAT -->
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Address -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="address">Address<span
                                    class="text-red-500">*</span></label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="address" type="text" name="address" value="{{ old('address', $agent->address) }}">
                            @if ($errors->has('address'))
                                <i class="text-sm text-red-500">*{{ $errors->first('address') }}</i>
                            @endif
                        </div>

                        <!-- PAN/VAT -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="pan_vat_number">PAN/VAT<span
                                    class="text-red-500">*</span></label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="pan_vat_number" type="text" name="pan_vat_number"
                                value="{{ old('pan_vat_number', $agent->pan_vat_number) }}">
                            @if ($errors->has('pan_vat_number'))
                                <i class="text-sm text-red-500">*{{ $errors->first('pan_vat') }}</i>
                            @endif
                        </div>
                    </div>

                    <!-- Row 3: Contact Person and Contact Number -->
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Contact Person -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="contact_person">Contact
                                Person<span class="text-red-500">*</span></label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="contact_person" type="text" name="contact_person"
                                value="{{ old('contact_person', $agent->contact_person) }}">
                            @if ($errors->has('contact_person'))
                                <i class="text-sm text-red-500">*{{ $errors->first('contact_person') }}</i>
                            @endif
                        </div>

                        <!-- Contact Number -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="phonenumber">Contact
                                Number<span class="text-red-500">*</span></label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="phonenumber" type="text" name="phonenumber"
                                value="{{ old('phonenumber', $agent->phonenumber) }}">
                            @if ($errors->has('phonenumber'))
                                <i class="text-sm text-red-500">*{{ $errors->first('phonenumber') }}</i>
                            @endif
                        </div>
                    </div>

                    <!-- Row 4: Email and Account Status -->
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Agent Group -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="agent_group_id">Agent Group</label>
                            <select
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm @error('agent_group_id') border-red-500 @enderror"
                                id="agent_group_id" name="agent_group_id">
                                <option value="">Please Select</option>
                                @foreach ($agentGroups as $group)
                                    <option {{ $agent->agent_group_id == $group->id ? 'selected' : '' }}
                                        value="{{ $group->id ?? '' }}">
                                        {{ $group->name ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('agent_group_id')
                                <i class="text-sm text-red-500">*{{ $message }}</i>
                            @enderror
                        </div>

                        <!-- Account Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="status">Account
                                Status</label>
                            <select
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm @error('status') border-red-500 @enderror"
                                id="status" name="status">
                                <option {{ $agent->status == 'Pending' ? 'selected' : '' }} value="Pending">Pending
                                </option>
                                <option {{ $agent->status == 'Active' ? 'selected' : '' }} value="Active">Active</option>
                                <option {{ $agent->status == 'Suspended' ? 'selected' : '' }} value="Suspended">Suspended
                                </option>
                            </select>
                            @error('status')
                                <i class="text-sm text-red-500">*{{ $message }}</i>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <!-- Password -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="password">Password (Enter to
                                change)<span class="text-red-500"></span></label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="password" type="password" name="password" value="{{ old('password') }}">
                            @error('password')
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
