@extends('layouts.admin.app')
@section('content')
    @include('admin.v2.inc.messages')
    <div class="max-w-full mx-auto">
        <!-- left column -->
        <div class="w-full">
            <!-- general form elements -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-gray-800">Change Password</h3>
                </div>

                <form id="form" role="form" action="{{ route('v2.admin.change.password.store') }}" method="POST"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-6">
                        <!-- First Row -->
                        <div class="form-group">
                            <label class="text-gray-700" for="current_password">Current Password</label>
                            <input class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full"
                                id="current_password" type="password" name="current_password" value="" >
                            @if ($errors->has('current_password'))
                                <span class="text-sm text-red-600">{{ $errors->first('current_password') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="text-gray-700" for="new_password">New Password</label>
                            <input class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" id="new_password"
                                type="password" name="new_password" value="" >
                            @if ($errors->has('new_password'))
                                <span class="text-sm text-red-600">{{ $errors->first('new_password') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="text-gray-700" for="new_password_confirmation">Confirm New Password</label>
                            <input class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full"
                                id="new_password_confirmation" type="password" name="new_password_confirmation"
                                value="" >
                            @if ($errors->has('new_password_confirmation'))
                                <span class="text-sm text-red-600">{{ $errors->first('new_password_confirmation') }}</span>
                            @endif
                        </div>

                    </div>
                    <div class="mt-5">
                        <button
                            class="px-6 py-2 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700 focus:outline-none"
                            type="submit">
                            Save Changes
                        </button>
                    </div>


                </form>

            </div>

        </div>
    </div>
@endsection
