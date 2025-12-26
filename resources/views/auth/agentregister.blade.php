@extends('layouts.front')

@section('body')
    <section class="w-full container mx-auto p-6 px-2">
        @include('messages')
        <div class="mt-7 bg-white border rounded-xl shadow-md grid grid-cols-12">
            <div class="col-span-6 hidden md:block">
                <img class="login-side-img" src="{{ asset('images/signup2.png') }}" alt="" />
            </div>
            <div class="col-span-12 md:col-span-6 py-5">
                <div class="p-4 sm:p-7">
                    <h1 class="block text-3xl text-primary font-bold">Agent Registration Request</h1>
                    <div class="mt-5">
                        <!-- Form -->
                        <form method="POST" action="{{ route('agent.register.store') }}">
                            @csrf
                            <div>
                                <div></div>
                            </div>
                            <div class="grid gap-y-4">
                                <!-- Form Group -->
                                <div>
                                    <label class="block text-sm mb-2 font-semibold" for="full">Agency Name</label>
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
                                <div>
                                    <label class="block text-sm mb-2 font-semibold" for="full">Address</label>
                                    <div class="relative">
                                        <input
                                            class="@error('address') border-red-600 @else border-gray-200 @enderror  bg-gray-100 py-3 px-4 block w-full  rounded-lg text-sm focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                            id="address" type="text" name="address" value="{{ old('address') }}" />
                                    </div>
                                    @error('address')
                                        <i class="text-xs text-red-600 mt-2" id="email-error">
                                            *{{ $message }}
                                        </i>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm mb-2 font-semibold" for="full">PAN/VAT Number</label>
                                    <div class="relative">
                                        <input
                                            class="@error('pan_vat_number') border-red-600 @else border-gray-200 @enderror  bg-gray-100 py-3 px-4 block w-full  rounded-lg text-sm focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                            id="pan_vat_number" type="text" name="pan_vat_number"
                                            value="{{ old('pan_vat_number') }}" />
                                    </div>
                                    @error('pan_vat_number')
                                        <i class="text-xs text-red-600 mt-2" id="email-error">
                                            *{{ $message }}
                                        </i>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm mb-2 font-semibold" for="full">Contact Person</label>
                                    <div class="relative">
                                        <input
                                            class="@error('contact_person') border-red-600 @else border-gray-200 @enderror  bg-gray-100 py-3 px-4 block w-full  rounded-lg text-sm focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                            id="contact_person" type="text" name="contact_person"
                                            value="{{ old('contact_person') }}" />
                                    </div>
                                    @error('contact_person')
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
                                    Submit <svg class="w-5 h-5 animate-spin hidden loaderRegisterSubmit text-white"
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
                                            href="{{ route('agent.login') }}">
                                            Sign in here
                                        </a>
                                    </p>

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
