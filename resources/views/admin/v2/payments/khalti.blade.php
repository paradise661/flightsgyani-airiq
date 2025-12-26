@extends('layouts.admin.app')
@section('content')
    @include('admin.v2.inc.messages')
    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="mb-6">
            <h3 class="text-xl font-semibold text-gray-800">Update Khalti credentials</h3>
        </div>

        <form role="form" id="form" action="{{ route('v2.admin.khalti.store') }}" method="POST"
            enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="space-y-6">

                <!-- Public Key -->
                <div class="form-group">
                    <label for="public" class="block text-sm font-medium text-gray-700">Public Key</label>
                    <input type="text" id="public" name="publicKey"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        value="{{ $khalti->public_key }}" required>
                    @if ($errors->has('publicKey'))
                        <span class="text-red-500 text-sm">{{ $errors->first('publicKey') }}</span>
                    @endif
                </div>

                <!-- Private Key -->
                <div class="form-group">
                    <label for="private" class="block text-sm font-medium text-gray-700">Private Key</label>
                    <input type="text" id="private" name="privateKey"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        value="{{ $khalti->secret_key }}" required>
                    @if ($errors->has('privateKey'))
                        <span class="text-red-500 text-sm">{{ $errors->first('privateKey') }}</span>
                    @endif
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" id="status" name="status"
                            class="h-5 w-5 text-indigo-600 border-gray-300 rounded" {{ $khalti->status ? 'checked' : '' }}>
                        <label for="status" id="statusLabel"
                            class="text-sm font-medium text-gray-700">{{ $khalti->status ? 'Enabled' : 'Disabled' }}</label>
                    </div>
                    @if ($errors->has('status'))
                        <span class="text-red-500 text-sm">{{ $errors->first('status') }}</span>
                    @endif
                </div>

                <!-- Submit Button -->
                <div class="mt-6 flex">
                    <button type="submit" class="bg-primary px-6 py-3 rounded-md text-white">Update</button>
                </div>
            </div>
        </form>
    </div>
    <script>
        $("#status").on("click", function() {
            if ($(this).is(':checked')) {
                $('#statusLabel').html('Enabled');
            } else {
                $('#statusLabel').html("Disabled");
            }
        })
    </script>
@endsection
