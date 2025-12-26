@extends('layouts.front')
@section('body')
    <div class="banner h-[100px] w-full overflow-hidden relative flex items-end justify-center">
        <img class="absolute top-0 right-0 hidden md:block" src="./../../public/images/banner-plane.png" alt="" />
        <div class="max-h-fit text-center items-baseline">
            <h1 class="text-white text-4xl font-bold tracking-wide z-10 relative">
                Find Your Ticket
            </h1>
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
                    Find your ticket
                </li>
            </ol>
        </div>
    </div>
    <section class="findticket min-h-[400px] py-16">
        <div class="container mx-auto px-6">


            <!-- Form Section -->
            <form class="bg-white shadow-lg rounded-lg p-8 max-w-5xl mx-auto" id="bookingInfoForm" action=""
                method="GET">
                <div class="my-6">
                    @include('messages')
                </div>
                <h2 class="text-3xl font-semibold text-gray-800 mb-6 text-center">Enter Your Booking Information</h2>

                <!-- Form Fields -->
                <!-- Form Fields -->
                <div class="grid grid-cols-3 sm:grid-cols-3 gap-8">
                    <!-- Booking Code Field -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="search-booking_code">Booking
                            Code</label>
                        <input
                            class="w-full py-4 px-5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all placeholder-gray-500"
                            id="search-booking_code" type="text" name="booking_code" required
                            placeholder="Enter your Booking Code">
                    </div>

                    <!-- Email Address Field -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="search-email">Email Address</label>
                        <input
                            class="w-full py-4 px-5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all placeholder-gray-500"
                            id="search-email" type="email" name="email" required placeholder="Enter your Email Address">
                    </div>

                    <!-- Type Field -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="search-type">Type</label>
                        <select
                            class="w-full py-4 px-5 border border-gray-300 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all placeholder-gray-500"
                            name="type" id="search-type">
                            <option value="domestic">Domestic Flight</option>
                            <option value="international">International Flight</option>
                        </select>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-6 text-center">
                    <button
                        class="bg-primary text-white py-3 px-8 rounded-lg font-semibold text-lg shadow-md hover:bg-primary-dark focus:ring-4 focus:ring-primary-light active:scale-95 transition-all duration-300 transform"
                        id="btnSearchTicket" type="submit">
                        Search Ticket
                    </button>
                </div>
            </form>
        </div>
    </section>

    <script>
        $('#btnSearchTicket').click(function(e) {
            e.preventDefault();
            var form = $('#bookingInfoForm')[0];
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            let bcode = $('#search-booking_code').val();
            let email = $('#search-email').val();
            let type = $('#search-type').val();
            if (bcode && email) {
                window.open("{{ url('viewyourticket') }}/" + bcode + "/" + email + "/" + type, '_blank');
            }
        })
    </script>
@endsection
