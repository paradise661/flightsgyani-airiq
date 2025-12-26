@extends('layouts.admin.app')
@section('content')
    @include('admin.v2.inc.messages')
    <div class="max-w-full mx-auto">
        <!-- left column -->
        <div class="w-full">
            <!-- general form elements -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-gray-800">Update Plasma Credentials</h3>
                </div>
                <!-- form start -->
                <form id="form" role="form" action="{{ route('v2.admin.plasma.update') }}" method="POST"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                        <!-- First Row -->
                        <div class="form-group">
                            <label class="text-gray-700" for="endpoint">Endpoint (LIVE)<span
                                    class="text-red-500">*</span></label>
                            <input class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" id="endpoint"
                                type="text" name="endpoint" value="{{ $plasma->endpoint ?? '' }}">
                            @if ($errors->has('endpoint'))
                                <i class="text-sm text-red-600">*{{ $errors->first('endpoint') }}</i>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="text-gray-700" for="username">Username (LIVE)<span
                                    class="text-red-500">*</span></label>
                            <input class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" id="username"
                                type="text" name="username" value="{{ $plasma->username ?? '' }}">
                            @if ($errors->has('username'))
                                <i class="text-sm text-red-600">*{{ $errors->first('username') }}</i>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="text-gray-700" for="password">Password (LIVE)<span
                                    class="text-red-500">*</span></label>
                            <input class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" id="password"
                                type="text" name="password" value="{{ $plasma->password ?? '' }}">
                            @if ($errors->has('password'))
                                <i class="text-sm text-red-600">*{{ $errors->first('password') }}</i>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="text-gray-700" for="agencyid">AgencyID (LIVE)<span
                                    class="text-red-500">*</span></label>
                            <input class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" id="agencyid"
                                type="text" name="agencyid" value="{{ $plasma->agencyid ?? '' }}">
                            @if ($errors->has('agencyid'))
                                <i class="text-sm text-red-600">*{{ $errors->first('agencyid') }}</i>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="text-gray-700" for="test_endpoint">Endpoint (TEST)<span
                                    class="text-red-500">*</span></label>
                            <input class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" id="test_endpoint"
                                type="text" name="test_endpoint" value="{{ $plasma->test_endpoint ?? '' }}">
                            @if ($errors->has('test_endpoint'))
                                <i class="text-sm text-red-600">*{{ $errors->first('test_endpoint') }}</i>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="text-gray-700" for="test_username">Username (TEST)<span
                                    class="text-red-500">*</span></label>
                            <input class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" id="test_username"
                                type="text" name="test_username" value="{{ $plasma->test_username ?? '' }}">
                            @if ($errors->has('test_username'))
                                <i class="text-sm text-red-600">*{{ $errors->first('test_username') }}</i>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="text-gray-700" for="test_password">Password (TEST)<span
                                    class="text-red-500">*</span></label>
                            <input class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" id="test_password"
                                type="text" name="test_password" value="{{ $plasma->test_password ?? '' }}">
                            @if ($errors->has('test_password'))
                                <i class="text-sm text-red-600">*{{ $errors->first('test_password') }}</i>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="text-gray-700" for="test_agencyid">AgencyID (TEST)<span
                                    class="text-red-500">*</span></label>
                            <input class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" id="test_agencyid"
                                type="text" name="test_agencyid" value="{{ $plasma->test_agencyid ?? '' }}">
                            @if ($errors->has('test_agencyid'))
                                <i class="text-sm text-red-600">*{{ $errors->first('test_agencyid') }}</i>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="text-gray-700" for="company">Company<span class="text-red-500">*</span></label>
                            <input class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" id="company"
                                type="text" name="company" value="{{ $plasma->company ?? '' }}">
                            @if ($errors->has('company'))
                                <i class="text-sm text-red-600">*{{ $errors->first('company') }}</i>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="text-gray-700" for="environment">Environment<span
                                    class="text-red-500">*</span></label>
                            <div class="flex items-center my-2">
                                <!-- Development / Production Toggle -->
                                <span class="text-gray-800">Development</span>
                                <label class="flex items-center cursor-pointer mx-5" for="toggle">
                                    <input class="sr-only peer" id="toggle" type="checkbox" name="environment"
                                        value="1" {{ ($plasma->environment ?? '') == 1 ? 'checked' : '' }}>
                                    <div
                                        class="block relative bg-primary w-16 h-9 p-1 rounded-full before:absolute before:bg-white before:w-7 before:h-7 before:p-1 before:rounded-full before:transition-all before:duration-500 before:left-1 peer-checked:before:left-8 peer-checked:before:bg-white">
                                    </div>
                                </label>
                                <span class="text-gray-800">Production</span>
                            </div>

                            @if ($errors->has('environment'))
                                <i class="text-sm text-red-600">*{{ $errors->first('environment') }}</i>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6">
                        <button class="bg-primary px-6 py-3 rounded-md text-white" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
