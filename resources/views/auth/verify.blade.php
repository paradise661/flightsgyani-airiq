@extends('layouts.front')

@section('body')
<div class="mx-auto px-4 mt-8">
    <div class="flex justify-center">
        <div class="w-full max-w-7xl">
            <div class="bg-white shadow-lg rounded-lg">
                <div class="bg-primary px-8 py-6">
                    <h2 class="text-2xl font-semibold text-white">{{ __('Verify Your Email Address') }}</h2>
                </div>

                <div class="px-8 py-6">
                    @if (session('resent'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif
                    @include('messages')

                    <p class="text-gray-700 mb-4">{{ __('Before proceeding, please check your email for a verification link.') }}</p>
                    <p class="text-gray-700 mb-4">{{ __('If you did not receive the email') }},</p>
                    <form class="inline" method="POST" action="{{ route('user.verification.resend') }}">
                        @csrf
                        <button type="submit" class="text-primary hover:underline">{{ __('Click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
