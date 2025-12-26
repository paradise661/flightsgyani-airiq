@extends('layouts.admin.app')
@section('content')
    @include('admin.v2.inc.messages')
    <div class="col-md-12">
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-800"><i>Update Company Ticket Details</i></h3>
                </div>
            </div>
            <!-- form start -->
            <form id="form" role="form" action="{{ route('b2b.agent.update.ticket') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="space-y-6">
                    <span class="mb-3 text-red-500">Note: These details are specific to the ticket information only. </span>

                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="company_name">Company Name<span
                                    class="text-red-500">*</span></label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="company_name" type="text" name="company_name"
                                value="{{ old('company_name', $ticket->company_name ?? '') }}">
                            @if ($errors->has('company_name'))
                                <i class="text-sm text-red-500">*{{ $errors->first('company_name') }}</i>
                            @endif
                        </div>
                    </div>

                    <!-- Row 2: Company Email and Contact -->
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="company_email">Company Email<span
                                    class="text-red-500">*</span></label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="company_email" type="email" name="company_email"
                                value="{{ old('company_email', $ticket->company_email ?? '') }}">
                            @if ($errors->has('company_email'))
                                <i class="text-sm text-red-500">*{{ $errors->first('company_email') }}</i>
                            @endif
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="company_contact">Company
                                Contact<span class="text-red-500">*</span></label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="company_contact" type="text" name="company_contact"
                                value="{{ old('company_contact', $ticket->company_contact ?? '') }}">
                            @if ($errors->has('company_contact'))
                                <i class="text-sm text-red-500">*{{ $errors->first('company_contact') }}</i>
                            @endif
                        </div>
                    </div>

                    <!-- Row 3: Emergency Contact and Company Address -->
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="emergency_contact">Emergency
                                Contact<span class="text-red-500">*</span></label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="emergency_contact" type="text" name="emergency_contact"
                                value="{{ old('emergency_contact', $ticket->emergency_contact ?? '') }}">
                            @if ($errors->has('emergency_contact'))
                                <i class="text-sm text-red-500">*{{ $errors->first('emergency_contact') }}</i>
                            @endif
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="company_address">Company
                                Address<span class="text-red-500">*</span></label>
                            <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm"
                                id="company_address" type="text" name="company_address"
                                value="{{ old('company_address', $ticket->company_address ?? '') }}">
                            @if ($errors->has('company_address'))
                                <i class="text-sm text-red-500">*{{ $errors->first('company_address') }}</i>
                            @endif
                        </div>
                    </div>

                    <!-- Row 4: Contact Details and Domestic Flight Rules -->
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="contact_details">Contact
                                Details</label>
                            <textarea class="mt-1 block w-full h-32 px-4 py-2 border border-gray-300 rounded-md shadow-sm ckeditor"
                                id="contact_details" name="contact_details" placeholder="Enter Contact Details">{{ $ticket->contact_details ?? '' }}</textarea>
                            @if ($errors->has('contact_details'))
                                <span class="text-sm text-red-500">*{{ $errors->first('contact_details') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Row 6: Logo -->
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="company_logo">Logo<span
                                    class="text-red-500">*</span> <span>(100 X 60PX)</span>
                            </label>
                            <input
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm image @error('company_logo') border-red-500 @enderror"
                                id="image" type="file" name="company_logo">
                            <img class="view-image mt-2" src="" style="max-height: 100px; width: auto;">
                            @if ($ticket && $ticket->company_logo)
                                <img class="mt-2 old-image" src="{{ asset('uploads/ticket/' . $ticket->company_logo) }}"
                                    width="100">
                                <i class="fa fa-times text-danger remove-image cursor-pointer" column="image"
                                    module="{{ $ticket->id ?? '' }}" aria-hidden="true"></i>
                            @endif
                            @error('company_logo')
                                <i class="text-sm text-red-500">*{{ $message }}</i>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="status">Status</label>
                            <select
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm @error('status') border-red-500 @enderror"
                                id="status" name="status">
                                <option value="1" {{ $ticket && $ticket->status == 1 ? 'selected' : '' }}>Active
                                </option>
                                <option value="0" {{ $ticket && $ticket->status == 0 ? 'selected' : '' }}>Inactive
                                </option>
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
@section('scripts')
    <script>
        $(".image").change(function() {
            input = this;
            var nthis = $(this);

            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    nthis.siblings('.old-image').hide();
                    nthis.siblings('.view-image').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        });
    </script>
@endsection
