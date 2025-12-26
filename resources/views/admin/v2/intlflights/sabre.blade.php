@extends('layouts.admin.app')
@section('content')
    @include('admin.v2.inc.messages')
    <div class="max-w-full mx-auto">
        <!-- left column -->
        <div class="w-full">
            <!-- general form elements -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-gray-800">Update Sabre Credentials</h3>
                </div>
                <!-- form start -->
                <form id="form" role="form" action="{{ route('v2.admin.sabre.details.update') }}" method="POST"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                        <!-- First Row -->
                        <div class="form-group">
                            <label class="text-gray-700" for="sabrepcc">PCC</label>
                            <input class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" id="sabrepcc"
                                type="text" name="sabrepcc" value="{{ config('sabre.pcc') }}" required>
                            @if ($errors->has('sabrepcc'))
                                <span class="text-sm text-red-600">{{ $errors->first('sabrepcc') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="text-gray-700" for="sabreurl">EndPoint</label>
                            <input class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" id="sabreurl"
                                type="text" name="sabreurl" value="{{ config('sabre.url') }}" required>
                            @if ($errors->has('sabreurl'))
                                <span class="text-sm text-red-600">{{ $errors->first('sabreurl') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="text-gray-700" for="sabreuser">Username</label>
                            <input class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" id="sabreuser"
                                type="text" name="sabreuser" value="{{ config('sabre.username') }}" required>
                            @if ($errors->has('sabreuser'))
                                <span class="text-sm text-red-600">{{ $errors->first('sabreuser') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="text-gray-700" for="sabrepassword">Password</label>
                            <input class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" id="sabrepassword"
                                type="text" name="sabrepassword" value="{{ config('sabre.password') }}" required>
                            @if ($errors->has('sabrepassword'))
                                <span class="text-sm text-red-600">{{ $errors->first('sabrepassword') }}</span>
                            @endif
                        </div>

                        <!-- Second Row -->
                        <div class="form-group">
                            <label class="text-gray-700" for="sabrelniata">LNIATA</label>
                            <input class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" id="sabrelniata"
                                type="text" name="sabrelniata" value="{{ config('sabre.lniata') }}" required>
                            @if ($errors->has('sabrelniata'))
                                <span class="text-sm text-red-600">{{ $errors->first('sabrelniata') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="text-gray-700" for="sabrecitycode">City Code</label>
                            <input class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" id="sabrecitycode"
                                type="text" name="sabrecitycode" value="{{ config('sabre.citycode') }}" required>
                            @if ($errors->has('sabrecitycode'))
                                <span class="text-sm text-red-600">{{ $errors->first('sabrecitycode') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="text-gray-700" for="sabreaddressline">Address Line</label>
                            <input class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full"
                                id="sabreaddressline" type="text" name="sabreaddressline"
                                value="{{ config('sabre.addressline') }}" required>
                            @if ($errors->has('sabreaddressline'))
                                <span class="text-sm text-red-600">{{ $errors->first('sabreaddressline') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="text-gray-700" for="sabrecityname">City Name</label>
                            <input class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" id="sabrecityname"
                                type="text" name="sabrecityname" value="{{ config('sabre.cityname') }}" required>
                            @if ($errors->has('sabrecityname'))
                                <span class="text-sm text-red-600">{{ $errors->first('sabrecityname') }}</span>
                            @endif
                        </div>

                        <!-- Third Row -->
                        <div class="form-group">
                            <label class="text-gray-700" for="sabrecountrycode">Country Code</label>
                            <input class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full"
                                id="sabrecountrycode" type="text" name="sabrecountrycode"
                                value="{{ config('sabre.cityname') }}" required>
                            @if ($errors->has('sabrecountrycode'))
                                <span class="text-sm text-red-600">{{ $errors->first('sabrecountrycode') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="text-gray-700" for="sabrepostal">Postal Code</label>
                            <input class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" id="sabrepostal"
                                type="text" name="sabrepostal" value="{{ config('sabre.postal') }}">
                            @if ($errors->has('sabrepostal'))
                                <span class="text-sm text-red-600">{{ $errors->first('sabrepostal') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="text-gray-700" for="sabrestreet">Street Number</label>
                            <input class="form-control mt-1 p-2 border border-gray-300 rounded-md w-full" id="sabrestreet"
                                type="text" name="sabrestreet" value="{{ config('sabre.streetnumber') }}">
                            @if ($errors->has('sabrestreet'))
                                <span class="text-sm text-red-600">{{ $errors->first('sabrestreet') }}</span>
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
