@extends('layouts.front')

@section('body')
    <div class="w-1/3 mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold text-center mb-6">{{ __('Reset Password') }}</h2>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email Address') }}</label>
                <input id="email" type="email" readonly
                    class="w-full mt-1 p-2 border border-gray-300 rounded-md @error('email') border-red-500 @enderror"
                    name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                <input id="password" type="password"
                    class="w-full mt-1 p-2 border border-gray-300 rounded-md @error('password') border-red-500 @enderror"
                    name="password" required autocomplete="new-password">

                @error('password')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-6">
                <label for="password-confirm"
                    class="block text-sm font-medium text-gray-700">{{ __('Confirm Password') }}</label>
                <input id="password-confirm" type="password" class="w-full mt-1 p-2 border border-gray-300 rounded-md"
                    name="password_confirmation" required autocomplete="new-password">
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center">
                <button type="submit"
                    class="w-full py-2 px-4 bg-primary text-white rounded-md hover:bg-primary focus:outline-none focus:ring-2 focus:ring-primary">
                    {{ __('Reset Password') }}
                </button>
            </div>
        </form>
    </div>
@endsection
