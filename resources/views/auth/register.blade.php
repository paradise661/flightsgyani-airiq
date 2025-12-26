@extends('layouts.front')

@section('body')
    <section class="w-full container mx-auto p-6 px-2">
        <div class="mt-7 bg-white border rounded-xl shadow-md grid grid-cols-12">
            <div class="col-span-6 hidden md:block">
                <img class="login-side-img" src="{{ asset('images/signup2.png') }}" alt="" />
            </div>
            <div class="col-span-12 md:col-span-6 py-5">
                <div class="p-4 sm:p-7">
                    <h1 class="block text-3xl text-primary font-bold">Sign up</h1>
                    <div class="mt-5">
                        <!-- Form -->
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div>
                                <div></div>
                            </div>
                            <div class="grid gap-y-4">
                                <!-- Form Group -->
                                <div>
                                    <label class="block text-sm mb-2 font-semibold" for="full">Full Name</label>
                                    <div class="relative">
                                        <input
                                            class="@error('name') border-red-600 @else border-gray-200 @enderror  bg-gray-100 py-3 px-4 block w-full  rounded-lg text-sm focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                            id="name" type="text" name="name" value="{{ old('name') }}" />
                                    </div>
                                    @error('name')
                                        <i class="text-xs text-red-600 mt-2" id="email-error">
                                            *{{ $message }}
                                        </i>
                                    @enderror
                                </div>
                                <!-- End Form Group -->
                                <!-- Form Group -->
                                <div>
                                    <label class="block text-sm mb-2 font-semibold" for="email">Email address</label>
                                    <div class="relative">
                                        <input
                                            class="@error('email') border-red-600 @else border-gray-200 @enderror  bg-gray-100 py-3 px-4 block w-full  rounded-lg text-sm focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                            id="email" type="email" name="email" aria-describedby="email-error"
                                            value="{{ old('email') }}" />
                                    </div>
                                    @error('email')
                                        <i class="text-xs text-red-600 mt-2" id="email-error">
                                            *{{ $message }}
                                        </i>
                                    @enderror
                                </div>
                                <!-- End Form Group -->

                                <div>
                                    <label class="block text-sm mb-2 font-semibold" for="phonenumber">Phone Number</label>
                                    <div class="relative">
                                        <input
                                            class="@error('phonenumber') border-red-600 @else border-gray-200 @enderror  bg-gray-100 py-3 px-4 block w-full  rounded-lg text-sm focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                            id="phonenumber" type="number" name="phonenumber"
                                            value="{{ old('phonenumber') }}" />
                                    </div>
                                    @error('phonenumber')
                                        <i class="text-xs text-red-600 mt-2" id="email-error">
                                            *{{ $message }}
                                        </i>
                                    @enderror
                                </div>

                                <!-- Form Group -->
                                <div>
                                    <label class="block text-sm mb-2 font-semibold" for="password">Password</label>
                                    <div class="relative">
                                        <input
                                            class="@error('password') border-red-600 @else border-gray-200  @enderror py-3 px-4 block bg-gray-100 w-full  rounded-lg text-sm focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                            id="password" type="password" name="password"
                                            aria-describedby="password-error" />
                                    </div>
                                    @error('password')
                                        <i class="text-xs text-red-600 mt-2" id="password-error">
                                            * {{ $message }}
                                        </i>
                                    @enderror
                                </div>
                                <!-- End Form Group -->

                                <!-- Form Group -->
                                <div>
                                    <label class="block text-sm mb-2 font-semibold" for="confirm-password">
                                        Confirm
                                        Password
                                    </label>
                                    <div class="relative">
                                        <input
                                            class="py-3 px-4 block w-full bg-gray-100 appearance-none @error('password_confirmation') border-red-600 @else border-gray-200 @enderror rounded-lg text-sm focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                            id="confirm-password" type="password" name="password_confirmation"
                                            aria-describedby="confirm-password-error" />
                                    </div>
                                    @error('password_confirmation')
                                        <p class="text-xs text-red-600 mt-2" id="confirm-password-error">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Checkbox -->
                                <div class="flex items-center">
                                    <div class="flex">
                                        <input
                                            class="shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-primary"
                                            id="remember-me" name="remember-me" type="checkbox" />
                                    </div>
                                    <div class="ms-3">
                                        <label class="text-sm" for="remember-me">I accept the
                                            <a class="text-primary decoration-2 hover:underline focus:outline-none focus:underline font-medium"
                                                href="{{ route('terms.conditions') }}" target="_blank">Terms and
                                                Conditions</a></label>
                                    </div>
                                </div>
                                <!-- End Checkbox -->

                                <!-- ReCaptcha -->
                                <div class="w-full">
                                    <label class="block text-sm font-semibold mb-2" for="g-recaptcha">
                                        ReCaptcha <span class="text-red-600">*</span>
                                    </label>
                                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha_v2.siteKey') }}">
                                    </div>
                                    @if ($errors->has('g-recaptcha-response'))
                                        <i class="text-red-600 text-sm">
                                            *{{ $errors->first('g-recaptcha-response') }}
                                        </i>
                                    @endif
                                </div>

                                <button
                                    class="registerBtn w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-primary text-white hover:bg-secondary focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                                    type="submit">
                                    Sign up <svg class="w-5 h-5 animate-spin hidden loaderRegisterSubmit text-white"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                    </svg>
                                </button>
                                <div class="text-center">
                                    <p class="mt-2 text-sm text-gray-600">
                                        Already have an account?
                                        <a class="text-primary decoration-2 hover:underline focus:outline-none focus:underline font-medium"
                                            href="{{ route('login') }}">
                                            Sign in here
                                        </a>
                                    </p>
                                    <div
                                        class="py-3 flex items-center text-xs text-gray-400 uppercase before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6">
                                        Or
                                    </div>
                                    <a class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
                                        href="{{ route('google.redirect') }}">
                                        <svg class="w-4 h-auto" width="46" height="47" viewBox="0 0 46 47"
                                            fill="none">
                                            <path
                                                d="M46 24.0287C46 22.09 45.8533 20.68 45.5013 19.2112H23.4694V27.9356H36.4069C36.1429 30.1094 34.7347 33.37 31.5957 35.5731L31.5663 35.8669L38.5191 41.2719L38.9885 41.3306C43.4477 37.2181 46 31.1669 46 24.0287Z"
                                                fill="#4285F4" />
                                            <path
                                                d="M23.4694 47C29.8061 47 35.1161 44.9144 39.0179 41.3012L31.625 35.5437C29.6301 36.9244 26.9898 37.8937 23.4987 37.8937C17.2793 37.8937 12.0281 33.7812 10.1505 28.1412L9.88649 28.1706L2.61097 33.7812L2.52296 34.0456C6.36608 41.7125 14.287 47 23.4694 47Z"
                                                fill="#34A853" />
                                            <path
                                                d="M10.1212 28.1413C9.62245 26.6725 9.32908 25.1156 9.32908 23.5C9.32908 21.8844 9.62245 20.3275 10.0918 18.8588V18.5356L2.75765 12.8369L2.52296 12.9544C0.909439 16.1269 0 19.7106 0 23.5C0 27.2894 0.909439 30.8731 2.49362 34.0456L10.1212 28.1413Z"
                                                fill="#FBBC05" />
                                            <path
                                                d="M23.4694 9.07688C27.8699 9.07688 30.8622 10.9863 32.5344 12.5725L39.1645 6.11C35.0867 2.32063 29.8061 0 23.4694 0C14.287 0 6.36607 5.2875 2.49362 12.9544L10.0918 18.8588C11.9987 13.1894 17.25 9.07688 23.4694 9.07688Z"
                                                fill="#EB4335" />
                                        </svg>
                                        Sign in with Google
                                    </a>
                                </div>
                            </div>
                        </form>
                        <!-- End Form -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $('.registerBtn').click(function(e) {
            $(this).prop('disabled', true);
            $('.loaderRegisterSubmit').show();
            $(this).closest('form').submit();
        })
    </script>
@endsection
