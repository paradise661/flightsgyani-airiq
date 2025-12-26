@extends('layouts.front')
@section('body')
    <!-- Banner  -->
    <div class="banner h-[237px] w-full overflow-hidden relative flex items-end justify-center">
        <img class="absolute top-0 right-0" src="{{ asset('images/banner-plane.png') }}" alt="" />
        <div class="max-h-fit text-center items-baseline">
            <h4 class="text-white text-4xl font-bold tracking-wide z-10 relative">
                Contact Us
            </h4>
            <ol class="flex items-center justify-center whitespace-nowrap p-2">
                <li class="inline-flex items-center">
                    <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600"
                        href="#">
                        <svg class="icon flat-color" id="home-alt-3" data-name="Flat Color" fill="#000000" width="20px"
                            height="20px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path id="primary"
                                    d="M21.71,11.29l-9-9a1,1,0,0,0-1.42,0l-9,9a1,1,0,0,0-.21,1.09A1,1,0,0,0,3,13H4v7.3A1.77,1.77,0,0,0,5.83,22H8.5a1,1,0,0,0,1-1V16.1a1,1,0,0,1,1-1h3a1,1,0,0,1,1,1V21a1,1,0,0,0,1,1h2.67A1.77,1.77,0,0,0,20,20.3V13h1a1,1,0,0,0,.92-.62A1,1,0,0,0,21.71,11.29Z"
                                    style="fill: #ffffff"></path>
                            </g>
                        </svg>
                    </a>
                    <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M10 7L15 12L10 17" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                        </g>
                    </svg>
                </li>

                <li class="text-lg font-medium text-gray-300 truncate" aria-current="page">
                    Contact Us
                </li>
            </ol>
        </div>
    </div>
    <!-- /Banner  -->

    <section class="contact-info mt-4 md:mt-8 px-4 md:px-0">
        <div class="container mx-auto">
            <div class="grid grid-cols-12 md:grid-cols-12 gap-4">
                {{-- <div class="hidden md:block"></div> --}}
                <div class="location bg-secondary-lighter px-2 py-2 rounded-lg col-span-12 md:col-span-4">
                    <div class="text-center text-xl font-medium capitalize text-primary ">
                        <i class="fa-solid fa-location-dot text-xl me-2"></i> Flights Gyani Head Office
                    </div>
                    <div class="flex flex-col gap-2 mt-2">
                        <div class="flex items-center gap-3">
                            <div
                                class="size-10 flex items-center justify-center bg-primary-background rounded-full min-w-[40px]">
                                <i class="fa-solid fa-map-location-dot text-lg text-primary"></i>
                            </div>
                            <div>
                                <p class="text-base font-normal text-gray-500">
                                    Lazimpat Opposite to British Embassy, Kathmandu
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="size-10 flex items-center justify-center bg-primary-background rounded-full">
                                <i class="fa-solid fa-envelope text-lg text-primary"></i>
                            </div>
                            <div>
                                <p class="text-base font-normal text-gray-500">
                                    info@flightsgyani.com
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="size-10 flex items-center justify-center bg-primary-background rounded-full">
                                <i class="fa-solid fa-phone text-lg text-primary"></i>
                            </div>
                            <div>
                                <p class="text-base font-normal text-gray-500">
                                    01-4547791/980-2368063/+977 986-0146706
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="location bg-secondary-lighter px-2 py-2 rounded-lg col-span-12 md:col-span-4">
                    <div class="text-center text-xl font-medium capitalize text-primary">
                        <i class="fa-solid fa-location-dot text-xl me-2"></i> Flights Gyani Butwal Office
                    </div>
                    <div class="flex flex-col gap-2 mt-2">
                        <div class="flex items-center gap-3">
                            <div
                                class="size-10 flex items-center justify-center bg-primary-background rounded-full min-w-[40px]">
                                <i class="fa-solid fa-map-location-dot text-lg text-primary"></i>
                            </div>
                            <div>
                                <p class="text-base font-normal text-gray-500">
                                    Milan Chowk - Butwal, Nepal
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="size-10 flex items-center justify-center bg-primary-background rounded-full">
                                <i class="fa-solid fa-envelope text-lg text-primary"></i>
                            </div>
                            <div>
                                <p class="text-base font-normal text-gray-500">
                                    padam.karki@flightsgyani.com
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="size-10 flex items-center justify-center bg-primary-background rounded-full">
                                <i class="fa-solid fa-phone text-lg text-primary"></i>
                            </div>
                            <div>
                                <p class="text-base font-normal text-gray-500">
                                    071-591346/+9779857053346
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="location bg-secondary-lighter px-2 py-2 rounded-lg col-span-12 md:col-span-4">
                    <div class="text-center text-xl font-medium capitalize text-primary">
                        <i class="fa-solid fa-location-dot text-xl me-2"></i> Flights Gyani Nepalgunj Office
                    </div>
                    <div class="flex flex-col gap-2 mt-2">
                        <div class="flex items-center gap-3">
                            <div
                                class="size-10 flex items-center justify-center bg-primary-background rounded-full min-w-[40px]">
                                <i class="fa-solid fa-map-location-dot text-lg text-primary"></i>
                            </div>
                            <div>
                                <p class="text-base font-normal text-gray-500">
                                    BP Chowk - Nepalgunj, Nepal
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="size-10 flex items-center justify-center bg-primary-background rounded-full">
                                <i class="fa-solid fa-envelope text-lg text-primary"></i>
                            </div>
                            <div>
                                <p class="text-base font-normal text-gray-500">
                                    rooma@flightsgyani.com
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="size-10 flex items-center justify-center bg-primary-background rounded-full">
                                <i class="fa-solid fa-phone text-lg text-primary"></i>
                            </div>
                            <div>
                                <p class="text-base font-normal text-gray-500">
                                    081-590577/+9779802349242
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="hidden md:block"></div> --}}
            </div>
        </div>
    </section>

    <section class="contact mt-4 md:mt-8 px-4 md:px-0">
        <div class="container mx-auto">
            <div class="contact-intro">
                <h5 class="text-4xl font-semibold capitalize">
                    <span class="text-primary">Book A Call</span> With Us
                </h5>
                <p class="text-base text-gray-500 font-normal py-3">
                    At Flights Gyani, we believe in making your travel seamless and stress-free. Whether you need assistance
                    with flight bookings, hotel reservations, or holiday packages, our dedicated team is ready to assist
                    you.
                </p>
            </div>

            <div class="contact-form mt-4">
                <div class="grid grid-cols-2 gap-6">
                    <div class="col-span-2 md:col-span-1">
                        <!-- <img class="rounded-2xl max-h-[300px] md:max-h-[610px]" src="{{ asset('images/contact.webp') }}" width="100%" alt=""> -->
                        <iframe class="rounded-2xl max-h-[300px] md:max-h-[610px]" src="{{ $site_setting->map ?? '' }}"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <form class="space-y-6 bg-white p-6 rounded-lg shadow-md" method="POST"
                            action="{{ route('inquiry.submit') }}">
                            @csrf
                            <div class="grid gap-4">
                                <!-- Full Name -->
                                <div class="w-full">
                                    <label class="block text-sm font-semibold mb-2" for="fname">
                                        Full Name <span class="text-red-600">*</span>
                                    </label>
                                    <input
                                        class="py-3 px-4 block w-full @error('name') border-red-600 @else border-gray-300 @enderror rounded-lg text-sm focus:border-blue-500 focus:ring focus:ring-blue-500/30"
                                        id="fname" name="name" type="text" placeholder="Full Name">
                                    @error('name')
                                        <i class="text-red-600 text-sm">
                                            * {{ $message }}
                                        </i>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="w-full">
                                    <label class="block text-sm font-semibold mb-2" for="email">
                                        Email <span class="text-red-600">*</span>
                                    </label>
                                    <input
                                        class="py-3 px-4 block w-full @error('email') border-red-600 @else border-gray-300 @enderror rounded-lg text-sm focus:border-blue-500 focus:ring focus:ring-blue-500/30"
                                        id="email" name="email" type="email" placeholder="example@example.com">
                                    @error('email')
                                        <i class="text-red-600 text-sm">
                                            *{{ $message }}
                                        </i>
                                    @enderror
                                </div>

                                <!-- Address -->
                                <div class="w-full">
                                    <label class="block text-sm font-semibold mb-2" for="city">
                                        Address <span class="text-red-600">*</span>
                                    </label>
                                    <input
                                        class="py-3 px-4 block w-full @error('city') border-red-600 @else border-gray-300 @enderror rounded-lg text-sm focus:border-blue-500 focus:ring focus:ring-blue-500/30"
                                        id="city" name="city" type="text" placeholder="City">
                                    @error('city')
                                        <i class="text-red-600 text-sm">
                                            * {{ $message }}
                                        </i>
                                    @enderror
                                </div>

                                <!-- Mobile -->
                                <div class="w-full">
                                    <label class="block text-sm font-semibold mb-2" for="mobile">
                                        Mobile <span class="text-red-600">*</span>
                                    </label>
                                    <input
                                        class="py-3 px-4 block w-full @error('phone') border-red-600 @else border-gray-300 @enderror rounded-lg text-sm focus:border-blue-500 focus:ring focus:ring-blue-500/30"
                                        id="mobile" name="phone" type="text" placeholder="+977 9808283223">
                                    @error('phone')
                                        <i class="text-red-600 text-sm">
                                            *{{ $message }}
                                        </i>
                                    @enderror
                                </div>

                                <!-- Message -->
                                <div class="w-full">
                                    <label class="block text-sm font-semibold mb-2" for="message">
                                        Message <span class="text-red-600">*</span>
                                    </label>
                                    <textarea
                                        class="py-3 px-4 block w-full @error('message') border-red-600 @else border-gray-300 @enderror rounded-lg text-sm focus:border-blue-500 focus:ring focus:ring-blue-500/30"
                                        id="message" name="message" rows="5" placeholder="Your Message"></textarea>
                                    @error('message')
                                        <i class="text-red-600 text-sm">
                                            *{{ $message }}
                                        </i>
                                    @enderror
                                </div>

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
                            </div>

                            <!-- Buttons -->
                            <div class="flex items-center justify-start space-x-4">
                                <button
                                    class="inquirybtn px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors"
                                    type="submit">
                                    Submit
                                </button>
                                <button
                                    class="px-6 py-3 bg-gray-600 text-white font-semibold rounded-lg hidden loaderInquirySubmit flex items-center"
                                    type="submit" disabled>
                                    <span class="loader-text flex gap-1">
                                        Submitting
                                        <svg class="w-5 h-5 animate-spin text-white" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                        </svg>
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <!-- @include('front.partials.map') -->
    <script>
        $('.inquirybtn').click(function(e) {
            $('.loaderInquirySubmit').show();
            $(this).hide();
        })
    </script>

    <script>
        @if (session('success'))
            window.Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'Ok'
            });
        @endif
    </script>

    {{-- <script src="{{URL::to('frontend/js/custom-map.js')}}"></script> --}}
    {{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4JwWo5VPt9WyNp3Ne2uc2FMGEePHpqJ8&amp;callback=initMap" --}}
    {{-- async defer></script> --}}
@endsection
