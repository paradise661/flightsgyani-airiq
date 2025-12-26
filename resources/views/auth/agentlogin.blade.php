@extends('layouts.front')

@section('body')
    <section class="w-full container mx-auto p-6">
        <div class="mt-7 grid grid-cols-12 bg-white border border-gray-200 rounded-xl shadow-sm">
            <div class="col-span-12 md:col-span-6 py-5">
                <div class="p-4 sm:p-7">
                    <div class="text-center">
                        <h1 class="block text-2xl font-bold text-gray-800">Agent Login</h1>
                    </div>

                    <div class="mt-5">
                        @include('messages')
                        <!-- Form -->
                        <form method="POST" action="{{ route('agent.login.check') }}">
                            @csrf
                            <div class="grid gap-y-4">
                                <!-- Form Group -->
                                <div>
                                    <label for="email" class="block text-sm mb-2">Email address</label>
                                    <div class="relative">
                                        <input value="{{ old('email') }}" type="email" id="email" name="email"
                                            class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                            required aria-describedby="email-error" />
                                        <div class="hidden absolute inset-y-0 end-0 pointer-events-none pe-3">
                                            <svg class="size-5 text-red-500" width="16" height="16"
                                                fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                                <path
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                            </svg>
                                        </div>
                                    </div>
                                    @error('email')
                                        <p class="text-xs text-red-600 mt-2" id="email-error">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <!-- End Form Group -->

                                <!-- Form Group -->
                                <div>
                                    <div class="flex justify-between items-center">
                                        <label for="password" class="block text-sm mb-2">Password</label>
                                        @if (Route::has('password.request'))
                                            <a class="inline-flex items-center gap-x-1 text-sm text-primary decoration-2 hover:underline focus:outline-none focus:underline font-medium"
                                                href="{{ route('password.request') }}">Forgot password?</a>
                                        @endif
                                    </div>
                                    <div class="relative">
                                        <input type="password" id="password" name="password"
                                            class="py-3 px-4 block border w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                            required aria-describedby="password-error" />
                                        <div class="hidden absolute inset-y-0 end-0 pointer-events-none pe-3">
                                            <svg class="size-5 text-red-500" width="16" height="16"
                                                fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                                <path
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="hidden text-xs text-red-600 mt-2" id="password-error">
                                        8+ characters required
                                    </p>
                                </div>
                                <!-- End Form Group -->

                                <!-- Checkbox -->
                                <div class="flex items-center">
                                    <div class="flex">
                                        <input class="shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:secondary"
                                            type="checkbox" name="remember" id="remember-me"
                                            {{ old('remember') ? 'checked' : '' }}>
                                    </div>
                                    <div class="ms-3">
                                        <label for="remember-me" class="text-sm">Remember me</label>
                                    </div>
                                </div>
                                <!-- End Checkbox -->

                                <button type="submit"
                                    class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-primary text-white hover:bg-secondary focus:outline-none focus:bg-primary disabled:opacity-50 disabled:pointer-events-none">
                                    Sign in
                                </button>
                                <div class="text-center">
                                    <p class="mt-2 text-sm text-gray-600">
                                        Don't have an account yet?
                                        <a class="text-primary decoration-2 hover:underline focus:outline-none focus:underline font-medium"
                                            href="{{ route('agent.register') }}">
                                            Click here to register for Agent
                                        </a>
                                    </p>

                                </div>
                            </div>
                        </form>
                        <!-- End Form -->
                    </div>
                </div>
            </div>
            <div class="col-span-6 hidden md:block">
                <img src="{{ asset('images/sigin-img-1.png') }}" class="login-side-img" alt="" />
            </div>
        </div>
    </section>
@endsection
