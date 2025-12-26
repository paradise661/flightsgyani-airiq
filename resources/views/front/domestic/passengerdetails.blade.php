@extends('layouts.front')
@section('title')
    Passenger Details
@endsection
@section('body')
    <div class="banner h-[100px] w-full overflow-hidden relative flex items-end justify-center">
        <img class="absolute top-0 right-0 hidden md:block" src="./../../public/images/banner-plane.png" alt="" />
        <div class="max-h-fit text-center items-baseline">
            <h4 class="text-white text-4xl font-bold tracking-wide z-10 relative">
                Traveller's Details
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
                <li class="inline-flex items-center">
                    <a class="flex text-lg font-medium text-white truncate items-center hover:text-primary focus:outline-none focus:text-secondary"
                        href="#">
                        Flights
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
                    Details
                </li>
            </ol>
        </div>
    </div>
    <!-- /Banner  -->

    <!-- Flight Details Heading Accordion  -->
    @include('front.domestic.flightdetails')
    <!-- / Flight Details Heading Accordion  -->

    <!-- Page Layout  -->
    <form id="passengerForm" action="{{ route('domesticflights.passengerdetails.store') }}" method="POST">
        @csrf
        <section class="traveller-details mt-4">
            <div class="container mx-auto">
                <div class="grid grid-cols-12 gap-4">
                    <!-- Passenger Info  -->
                    <div class="col-span-12 md:col-span-8 order-1 md:order-1">
                        <div class="rounded-lg border border-gray-300 px-4 py-3 md:px-6 md:py-6 bg-white"
                            id="passengerInputData">

                            @for ($i = 1; $i <= $request_data['adult']; $i++)
                                <h3 class="text-xl font-semibold mt-2">Passenger {{ $i }}. Adult</h3>
                                <!-- Form Layout  -->
                                <div class="form-layout grid grid-cols-1 md:grid-cols-2 gap-4 mt-2 md:mt-4">
                                    <div class="w-full">
                                        <div>
                                            <label class="block text-sm font-semibold mb-2" for="fname">First Name
                                                <span class="text-red-600">*</span></label>
                                            <div class="flex items-center gap-1">
                                                <select
                                                    class="block w-full border-transparent rounded-lg focus:ring-primary-lighter focus:border-primary"
                                                    class="hidden"
                                                    data-hs-select='{
                                                "placeholder": "Mr.",
                                                "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                                "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500",
                                                "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300",
                                                "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50",
                                                "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 \" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                                                "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                                                }'
                                                    name="adult_title[]">
                                                    <option value="Mr."
                                                        {{ old('adult_title.' . ($i - 1)) == 'Mr.' ? 'selected' : '' }}>
                                                        Mr.&nbsp;</option>
                                                    <option value="Mrs."
                                                        {{ old('adult_title.' . ($i - 1)) == 'Mrs.' ? 'selected' : '' }}>
                                                        Mrs.
                                                    </option>
                                                    <option value="Ms."
                                                        {{ old('adult_title.' . ($i - 1)) == 'Ms.' ? 'selected' : '' }}>
                                                        Ms.&nbsp;</option>

                                                </select>
                                                <input
                                                    class="py-3 px-4 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                                    id="fname" type="text" name="adult_first_name[]" required
                                                    value="{{ old('adult_first_name.' . ($i - 1)) }}"
                                                    placeholder="First Name" />
                                            </div>
                                            @error('adult_first_name.' . ($i - 1))
                                                <span class="text-red-600">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <label class="block text-sm font-semibold mb-2" for="lname">Last Name <span
                                                class="text-red-600">*</span></label>
                                        <input
                                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                            id="lname" type="text" name="adult_last_name[]" required
                                            value="{{ old('adult_last_name.' . ($i - 1)) }}" placeholder="Last Name" />
                                        @error('adult_last_name.' . ($i - 1))
                                            <span class="text-red-600">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                                <hr class="mt-4">
                            @endfor
                            <div class="mt-5"></div>
                            @for ($i = 1; $i <= $request_data['child']; $i++)
                                <h3 class="text-xl font-semibold mt-2">Passenger {{ $i }}. Child</h3>
                                <!-- Form Layout  -->
                                <div class="form-layout grid grid-cols-1 md:grid-cols-2 gap-4 mt-2 md:mt-4">
                                    <div class="w-full">
                                        <div>
                                            <label class="block text-sm font-semibold mb-2" for="fname">First Name
                                                <span class="text-red-600">*</span></label>
                                            <div class="flex items-center gap-1">
                                                <select
                                                    class="block w-full border-transparent rounded-lg focus:ring-primary-lighter focus:border-primary"
                                                    class="hidden"
                                                    data-hs-select='{
                                                "placeholder": "Mr.",
                                                "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                                "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500",
                                                "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300",
                                                "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50",
                                                "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 \" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                                                "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                                                }'
                                                    name="child_title[]">
                                                    <option value="Mr."
                                                        {{ old('child_title.' . ($i - 1)) == 'Mr.' ? 'selected' : '' }}>
                                                        Mr.&nbsp;</option>
                                                    <option value="Mrs."
                                                        {{ old('child_title.' . ($i - 1)) == 'Mrs.' ? 'selected' : '' }}>
                                                        Mrs.
                                                    </option>
                                                    <option value="Ms."
                                                        {{ old('child_title.' . ($i - 1)) == 'Ms.' ? 'selected' : '' }}>
                                                        Ms.&nbsp;</option>

                                                </select>
                                                <input
                                                    class="py-3 px-4 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                                    id="fname" type="text" name="child_first_name[]" required
                                                    value="{{ old('child_first_name.' . ($i - 1)) }}"
                                                    placeholder="First Name" />
                                            </div>
                                            @error('child_first_name.' . ($i - 1))
                                                <span class="text-red-600">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <label class="block text-sm font-semibold mb-2" for="lname">Last Name <span
                                                class="text-red-600">*</span></label>
                                        <input
                                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                            id="lname" type="text" name="child_last_name[]" required
                                            value="{{ old('child_last_name.' . ($i - 1)) }}" placeholder="Last Name" />
                                        @error('child_last_name.' . ($i - 1))
                                            <span class="text-red-600">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                                <hr class="mt-4">
                            @endfor

                            <h3 class="text-2xl font-semibold mt-4 md:mt-8">
                                Passenger's emergency information
                            </h3>

                            <div class="form-layout grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 md:mt-8">
                                <div class="w-full">
                                    <label class="block text-sm font-semibold mb-2" for="fullname">Full Name <span
                                            class="text-red-600">*</span></label>
                                    <input
                                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                        id="fullname" type="text" name="emergency_full_name" required
                                        value="{{ old('emergency_full_name', Auth::user()->name ?? '') }}"
                                        placeholder="Full Name" />
                                    @error('emergency_full_name')
                                        <span class="text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-full">
                                    <label class="block text-sm font-semibold mb-2" for="phone">Phone Number <span
                                            class="text-red-600">*</span></label>
                                    <input
                                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                        id="phone" type="text" name="emergency_phone_number" required
                                        value="{{ old('emergency_phone_number', Auth::user()->phonenumber ?? '') }}"
                                        placeholder="Phone number" />
                                    @error('emergency_phone_number')
                                        <span class="text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-full">
                                    <label class="block text-sm font-semibold mb-2" for="email">Email Address <span
                                            class="text-red-600">*</span></label>
                                    <input
                                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                        id="email" type="email" name="emergency_email" required
                                        value="{{ old('emergency_email', Auth::user()->email ?? '') }}"
                                        placeholder="someone@gmail.com" />
                                    @error('emergency_email')
                                        <span class="text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <!-- / Form Layout  -->
                        </div>
                        <div class="hidden" id="reviewPassenger">
                            <div class="flex justify-start">
                                <a class="px-4 py-2 bg-primary text-white text-base rounded-md mb-2 cursor-pointer"
                                    id="backToEdit" href=""><i class="fa-solid fa-arrow-left"></i> Back to
                                    Edit</a>
                            </div>
                            <div class="rounded-lg border border-gray-300 px-4 py-3 md:px-6 md:py-6 bg-white"
                                id="reviewPassengerData"></div>
                        </div>
                    </div>
                    <!-- / Passenger Info  -->

                    <!-- Order Summaray  -->
                    @include('front.domestic.ordersummary')
                    <!-- / Order Summaray  -->

                    <!-- Book Ticket  -->
                    <div class="col-span-12 md:col-span-8 order-3 md:order-4" id="beforeClick">
                        <div class="rounded-lg border border-gray-300 px-4 py-3 md:px-6 md:py-6 bg-white">
                            <div class="flex flex-col gap-3">
                                <h6 class="text-lg font-semibold">Book Tickets</h6>
                                <p class="text-gray-400 text-sm font-medium">
                                    You can issue tickets in the orders section. the booking will
                                    be cancelled automatically after this Period of time passes.
                                </p>
                                <p class="text-gray-400 text-sm font-medium">
                                    <span class="text-black">Please note:</span> the airline has
                                    the right to cancel the booking before the ticket time limit
                                    expires
                                </p>

                                <div class="flex">
                                    <input
                                        class="shrink-0 mt-0.5 border-gray-200 rounded text-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                        id="terms" checked type="checkbox" required />
                                    <label class="text-sm text-gray-500 ms-3" for="terms">I agree that I have accepted
                                        the
                                        <a class="text-secondary" href="{{ route('terms.conditions') }}"
                                            target="_blank">Terms &
                                            Conditions</a>
                                        and Privacy Policy.
                                    </label>
                                </div>

                                <button class="g-button-primary px-4 py-4 max-w-fit text-white font-medium rounded-lg"
                                    id="btnFormData">
                                    Book Now
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="hidden col-span-12 md:col-span-8 order-3 md:order-4" id="afterClick">
                        <div class="rounded-lg border border-gray-300 px-4 py-3 md:px-6 md:py-6 bg-white">
                            <div class="flex flex-col gap-3">
                                <h6 class="text-lg font-semibold">Book Ticket</h6>

                                <p class="text-gray-400 text-sm font-medium">
                                    <span class="text-black">Please note:</span> Check the instructions about the
                                    passengers carefully before continue booking.
                                </p>

                                @if (Auth::check() && Auth::user()->user_type == 'AGENT')
                                    <button class="g-button-primary px-4 py-4 max-w-fit text-white font-medium rounded-lg"
                                        id="submitFormAgent">
                                        Continue Booking
                                    </button>
                                @elseif(Auth::check() && Auth::user()->hasAnyRole('OFFICE STAFF'))
                                    <button class="g-button-primary px-4 py-4 max-w-fit text-white font-medium rounded-lg"
                                        id="submitOfficeStaffForm">
                                        Continue Booking
                                    </button>
                                @else
                                    <button class="g-button-primary px-4 py-4 max-w-fit text-white font-medium rounded-lg"
                                        id="submitForm">
                                        Continue Booking
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- / Book Ticket  -->
                </div>
            </div>
        </section>
        <input id="paymentMethod" type="hidden" name="paymentMethod" value="Khalti">
    </form>

    @if (Auth::check() && Auth::user()->user_type == 'AGENT')
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden" id="modal">
            <!-- Modal Content -->
            <div class="bg-white rounded-lg shadow-lg p-8 w-[500px]">
                <!-- Modal Header -->
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-semibold">Choose Your Payment Option</h3>
                    <!-- Close Icon -->
                    <button class="text-gray-600 hover:text-gray-900" onclick="toggleModal()">
                        <!-- Close Icon SVG -->
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="my-6 grid grid-cols-2 gap-8">
                    <!-- Image Section 1 -->
                    <div class="border-red-500 flex flex-col items-center justify-center border-2 cursor-pointer p-2 transition-all duration-300 transform hover:scale-105 rounded-lg shadow-lg hover:shadow-xl hover:border-blue-500 bg-white"
                        method="Khalti" onclick="setActiveOption(this,'Khalti')">
                        <img class="object-cover transition duration-300 transform hover:scale-105 " id="img1"
                            src="{{ asset('frontend/images/khalti.png') }}" alt="Khalti">
                    </div>

                    <div class="flex flex-col items-center justify-center border-2 cursor-pointer p-2 transition-all duration-300 transform hover:scale-105 rounded-lg shadow-lg hover:shadow-xl hover:border-blue-500 bg-white"
                        method="Wallet" onclick="setActiveOption(this,'Wallet')">
                        <div class="text-2xl font-semibold">Wallet</div>
                        <div class="text-2xl font-extrabold text-gray-800">NPR: <span
                                class="text-green-500">{{ remainingBalance(Auth::user()->id, 'NPR') }}</span></div>
                    </div>

                </div>

                <!-- Modal Footer with Button -->
                <div class="flex justify-center mt-6">
                    <button class="bg-green-600 text-white py-3 px-8 rounded-lg hover:bg-green-500 transition duration-200"
                        id="submitForm">
                        Proceed to payment
                    </button>
                </div>
            </div>
        </div>
    @endif

    <script>
        // Function to toggle modal visibility
        function toggleModal() {
            const modal = document.getElementById("modal");
            modal.classList.toggle("hidden");
        }

        // Function to add 'active' class to clicked image
        function setActiveOption(element, method) {
            $('#paymentMethod').val(method);
            // Remove 'active' border from all images
            const images = document.querySelectorAll('.cursor-pointer');
            images.forEach(img => {
                img.classList.remove('border-2', 'border-red-500'); // Remove previous active styles
            });

            // Add 'active' border to the clicked image
            element.classList.add('border-2', 'border-red-500');
        }
    </script>

    <script>
        $('#btnFormData').click(function(e) {
            e.preventDefault();

            var form = $('#passengerForm')[0];
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            var formClone = $('#passengerInputData').clone();

            formClone.find('input, textarea, select').each(function() {
                var inputValue = $(this).val();
                if ($(this).is('select')) {
                    inputValue = $(this).siblings('button').text();
                }
                $(this).replaceWith('<label>' + inputValue + '</label>');
            });

            $('#reviewPassengerData').html(formClone.html());

            $('#reviewPassengerData').find('.hs-select').each(function() {
                $(this).find('button').addClass('hidden');
                $(this).find('div').addClass('hidden');
            });

            $('#passengerInputData').hide();
            $('#reviewPassenger').show();
            $('#beforeClick').hide();
            $('#afterClick').show();

            $('html, body, #passengerForm').animate({
                scrollTop: 0
            }, 'smooth');
        });

        $('#backToEdit').click(function(e) {
            e.preventDefault();
            $('#passengerInputData').show();
            $('#reviewPassenger').hide();
            $('#beforeClick').show();
            $('#afterClick').hide();
        })

        $('#submitFormAgent').click(function(e) {
            e.preventDefault();
            toggleModal();
        })

        $('#submitForm').click(function(e) {
            e.preventDefault();
            if ($('#paymentMethod').val() == 'Wallet') {
                $.ajax({
                    url: "{{ route('agent.check.balance') }}",
                    method: 'GET',
                    success: function(response) {
                        if (response == 'insufficient-balance') {
                            Swal.fire({
                                title: "Insufficient Balance",
                                text: "You do not have sufficient balance to book this flight",
                                icon: 'error',
                                animation: true,
                                allowOutsideClick: false,
                                showCancelButton: false,
                                showConfirmButton: true,
                                showCloseButton: false,
                                allowEscapeKey: false,
                            });
                        } else {
                            confirmBooking();
                        }

                    },
                });
            } else {
                confirmBooking();
            }
        })

        $('#submitOfficeStaffForm').click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "Ticket will be issued directly without payment.",
                icon: 'warning',
                animation: true,
                allowOutsideClick: false,
                showCancelButton: true, // Enable Cancel button
                showConfirmButton: true, // Enable OK button
                cancelButtonText: 'Cancel', // Text for Cancel button
                // confirmButtonText: 'OK', // Text for OK button
                cancelButtonColor: '#d33', // Optional: Color for Cancel button (red)
                confirmButtonColor: '#3085d6', // Optional: Color for OK button (blue)
                allowEscapeKey: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    confirmBooking();
                }
            });
        })

        function confirmBooking() {
            Swal.fire({
                title: "Please Wait",
                text: "Confirming your Booking.",
                imageUrl: "/frontend/images/search-loader.gif",
                imageAlt: "FlightGyani",
                animation: true,
                allowOutsideClick: false,
                showCancelButton: false,
                showConfirmButton: false,
                showCloseButton: false,
                allowEscapeKey: false,
            });
            $('#passengerForm').submit();
        }

        setTimeout(function() {
            Swal.fire({
                title: "Search Again",
                text: "All fares has been changed.",
                imageUrl: "/frontend/images/search-loader.gif",
                imageAlt: "FlightGyani",
                animation: true,
                allowOutsideClick: false,
                showCancelButton: false,
                showConfirmButton: true,
                showCloseButton: false,
                allowEscapeKey: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = "{{ route('frontend.index') }}";
                }
            });
        }, 600000); // 10 min
    </script>
@endsection
