@extends('layouts.front')
@section('title')
Passenger Details
@endsection
@section('body')
<div class="banner h-[100px] w-full overflow-hidden relative flex items-end justify-center">
    <img class="absolute top-0 right-0 hidden md:block" src="./../../public/images/banner-plane.png" alt="" />
    <div class="max-h-fit text-center items-baseline">
        <h4 class="text-white text-4xl font-bold tracking-wide z-10 relative">
            Review Your Details
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
<div class="flight-details-accordion mt-2 md:mt-8 px-2 md:px-0">
    <div class="container mx-auto">
        <div
            class="hs-accordion-group bg-white rounded-lg shadow-md px-0 md:px-6 py-4">
            <div
                class="hs-accordion"
                id="hs-basic-with-title-and-arrow-stretched-heading-two">
                <button
                    class="hs-accordion-toggle overflow-hidden hs-accordion-active:text-blue-600 py-3 px-4 inline-flex items-center justify-between gap-x-3 w-full font-semibold text-start text-gray-800 hover:text-gray-500 disabled:opacity-50 disabled:pointer-events-none"
                    aria-expanded="false"
                    aria-controls="hs-basic-with-title-and-arrow-stretched-collapse-two">
                    <div>
                        <h3 class="text-xl font-semibold tracking-wider text-gray-700">
                            Kathmandu to Delhi
                        </h3>
                        <p class="text-sm font-medium tracking-wide text-gray-400">
                            Departure On Sep 17 At 13:25 Direct Flight Travel Time 1h
                            40min
                        </p>
                    </div>
                    <svg
                        class="hs-accordion-active:hidden block size-5"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="m6 9 6 6 6-6"></path>
                    </svg>
                    <svg
                        class="hs-accordion-active:block hidden size-5"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="m18 15-6-6-6 6"></path>
                    </svg>
                </button>
                <div
                    id="hs-basic-with-title-and-arrow-stretched-collapse-two"
                    class="hs-accordion-content hidden w-full overflow-hidden px-2 md:px-4 py-4 transition-[height] duration-300"
                    role="region"
                    aria-labelledby="hs-basic-with-title-and-arrow-stretched-heading-two">
                    <div
                        class="accordion-flight-detail rounded-lg overflow-hidden shadow-md">
                        <div
                            class="bg-primary w-full px-4 py-3 flex items-center justify-center gap-2 text-base">
                            <div class="flex items-center justify-center gap-3">
                                <i class="fa-solid fa-plane-departure text-white"></i>
                                <p class="text-white text-base font-bold tracking-wider">
                                    KTM
                                </p>
                                <i class="fa-solid fa-minus text-white"></i>
                                <p class="text-white text-base font-bold tracking-wider">
                                    DEL
                                </p>
                                <i class="fa-solid fa-plane-arrival text-white"></i>
                            </div>
                        </div>
                        <div class="bg-white py-3 px-3 md:px-14">
                            <div class="traveller-flights">
                                <div class="airport-name md:min-w-fit">
                                    <h4 class="text-sm font-medium text-gray-500 text-start">
                                        Tue, Aug 1, 2024
                                    </h4>
                                    <h4
                                        class="text-base font-semibold text-gray-700 text-start">
                                        KTM - Tribhuvan International Airport
                                    </h4>
                                </div>

                                <div class="airport-progress">
                                    <i
                                        class="fa-regular fa-circle-dot text-primary float-start"></i>
                                    <i
                                        class="fa-regular fa-circle-dot text-primary float-end"></i>
                                </div>

                                <div class="airport-name arrival md:min-w-fit">
                                    <h4 class="text-sm font-medium text-gray-500 text-start">
                                        Mon, Oct 16, 11:30 AM
                                    </h4>
                                    <h4
                                        class="text-base font-semibold text-gray-700 text-start">
                                        DEL - Delhi International Airport
                                    </h4>
                                </div>
                            </div>
                            <div class="flex gap-4 md:gap-6 mt-4 items-center text-base">
                                <div class="flight-logo">
                                    <img
                                        src="./../../public/images/qatar.png"
                                        alt=""
                                        width="72px"
                                        height="auto" />
                                    <p class="text-xs font-bold text-gray-400">BDT 4,271</p>
                                </div>
                                <h6 class="text-base text-gray-400 font-medium">
                                    Direct : 1h 40m
                                </h6>
                            </div>
                        </div>
                    </div>

                    <div class="mt-2 md:mt-8 shadow-md rounded-lg">
                        <div class="px-3 md:px-14 py-5 grid grid-cols-4">
                            <div class="col-span-4 md:col-span-1">
                                <h5 class="text-base font-semibold text-gray-600">
                                    Baggage
                                </h5>
                                <p class="text-sm font-medium text-gray-400">
                                    Total baggage included in the price
                                </p>
                            </div>
                            <div class="col-span-4 gap-5 md:col-span-3">
                                <div class="flex flex-col gap-3">
                                    <div class="flex items-center justify-between">
                                        <div class="flex gap-2 items-center">
                                            <i
                                                class="fa-solid fa-briefcase text-primary text-2xl"></i>
                                            <div>
                                                <h6 class="text-xs text-primary font-medium">
                                                    1 Personal Item
                                                </h6>
                                                <p class="text-sm font-normal text-gray-400">
                                                    fits under the seat in front of you
                                                </p>
                                            </div>
                                        </div>
                                        <p
                                            class="text-xs font-medium text-gray-400 tracking-wider">
                                            Included
                                        </p>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex gap-2 items-center">
                                            <i
                                                class="fa-solid fa-suitcase-rolling text-primary text-2xl"></i>
                                            <div>
                                                <h6 class="text-xs text-primary font-medium">
                                                    1 Carry-On Bag
                                                </h6>
                                                <p class="text-sm font-normal text-gray-400">
                                                    Max Weight 5 kg
                                                </p>
                                            </div>
                                        </div>
                                        <p
                                            class="text-xs font-medium text-gray-400 tracking-wider">
                                            Included
                                        </p>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex gap-2 items-center">
                                            <i
                                                class="fa-solid fa-bag-shopping text-primary text-2xl"></i>
                                            <div>
                                                <h6 class="text-xs text-primary font-medium">
                                                    1 Checked Bag
                                                </h6>
                                                <p class="text-sm font-normal text-gray-400">
                                                    Max Weight 15 Kg
                                                </p>
                                            </div>
                                        </div>
                                        <p
                                            class="text-xs font-medium text-gray-400 tracking-wider">
                                            Included
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="border-t border-gray-300">
                  <div
                    class="w-full flex items-center justify-end gap-8 px-3 md:px-14 py-2"
                  >
                    <h5 class="text-3xl font-semibold tracking-normal">
                      Rs 1500 /-
                    </h5>
                    <button
                      class="g-button-primary text-white px-8 py-3 text-sm font-medium tracking-wider rounded-lg"
                    >
                      Select
                    </button>
                  </div>
                </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / Flight Details Heading Accordion  -->


<!-- Page Layout  -->
<section class="traveller-details mt-2 px-2 md:px-0">
    <div class="container mx-auto">
        <div class="grid grid-cols-12 gap-4">

            <!-- Passenger Info  -->
            <div class="col-span-12 md:col-span-8 order-1 md:order-1">
                <div class="flex justify-start">
                    <a href="" class="px-4 py-2 bg-primary text-white text-base rounded-md mb-2 cursor-pointer"><i class="fa-solid fa-arrow-left"></i> Back to Edit</a>
                </div>
                <!-- Passenger Display Layout  -->
                <div class="grid gap-4">
                    <div
                        class="rounded-lg border border-gray-300 px-4 py-3 md:px-6 md:py-6 bg-white ">
                        <h3 class="text-xl font-semibold text-primary">Passenger 1. Adult</h3>

                        <div
                            class="form-layout grid grid-cols-2 md:grid-cols-3 gap-4 mt-2 md:mt-4">
                            <div class="w-full ">
                                <div>
                                    <label for="fname" class="block text-sm font-medium mb-2 text-gray-400">Passenger Name <span class="text-red-600">*</span></label>

                                    <p class="text-lg font-medium">
                                        Mr. John Smith
                                    </p>
                                </div>
                            </div>

                            <div class="w-full ">
                                <label for="dob" class="block text-sm font-medium mb-2 text-gray-400">Date of Birth <span class="text-red-600">*</span></label>
                                <p class="text-lg font-medium">
                                    15/06/2022
                                </p>
                            </div>
                            <div class="w-full ">
                                <label for="dob" class="block text-sm font-medium mb-2 text-gray-400">Nationality <span class="text-red-600">*</span></label>
                                <p class="text-lg font-medium">
                                    Nepal
                                </p>
                            </div>
                            <div class="w-full ">
                                <label for="dob" class="block text-sm font-medium mb-2 text-gray-400">Document Type <span class="text-red-600">*</span></label>
                                <p class="text-lg font-medium">
                                    Passport
                                </p>
                            </div>
                            <div class="w-full ">
                                <label for="dob" class="block text-sm font-medium mb-2 text-gray-400">Passport Number <span class="text-red-600">*</span></label>
                                <p class="text-lg font-medium">
                                    98976568238566
                                </p>
                            </div>
                            <div class="w-full ">
                                <label for="dob" class="block text-sm font-medium mb-2 text-gray-400">Expiration Date <span class="text-red-600">*</span></label>
                                <p class="text-lg font-medium">
                                    15/06/2022
                                </p>
                            </div>
                            <div class="w-full ">
                                <label for="dob" class="block text-sm font-medium mb-2 text-gray-400">Issued Country <span class="text-red-600">*</span></label>
                                <p class="text-lg font-medium">
                                    Nepal
                                </p>
                            </div>

                        </div>
                    </div>
                    <div
                        class="rounded-lg border border-gray-300 px-4 py-3 md:px-6 md:py-6 bg-white ">
                        <h3 class="text-xl font-semibold text-primary">Passenger 2. Adult</h3>

                        <div
                            class="form-layout grid grid-cols-2 md:grid-cols-3 gap-4 mt-2 md:mt-4">
                            <div class="w-full ">
                                <div>
                                    <label for="fname" class="block text-sm font-medium mb-2 text-gray-400">Passenger Name <span class="text-red-600">*</span></label>

                                    <p class="text-lg font-medium">
                                        Mr. John Smith
                                    </p>
                                </div>
                            </div>

                            <div class="w-full ">
                                <label for="dob" class="block text-sm font-medium mb-2 text-gray-400">Date of Birth <span class="text-red-600">*</span></label>
                                <p class="text-lg font-medium">
                                    15/06/2022
                                </p>
                            </div>
                            <div class="w-full ">
                                <label for="dob" class="block text-sm font-medium mb-2 text-gray-400">Nationality <span class="text-red-600">*</span></label>
                                <p class="text-lg font-medium">
                                    Nepal
                                </p>
                            </div>
                            <div class="w-full ">
                                <label for="dob" class="block text-sm font-medium mb-2 text-gray-400">Document Type <span class="text-red-600">*</span></label>
                                <p class="text-lg font-medium">
                                    Passport
                                </p>
                            </div>
                            <div class="w-full ">
                                <label for="dob" class="block text-sm font-medium mb-2 text-gray-400">Passport Number <span class="text-red-600">*</span></label>
                                <p class="text-lg font-medium">
                                    98976568238566
                                </p>
                            </div>
                            <div class="w-full ">
                                <label for="dob" class="block text-sm font-medium mb-2 text-gray-400">Expiration Date <span class="text-red-600">*</span></label>
                                <p class="text-lg font-medium">
                                    15/06/2022
                                </p>
                            </div>
                            <div class="w-full ">
                                <label for="dob" class="block text-sm font-medium mb-2 text-gray-400">Issued Country <span class="text-red-600">*</span></label>
                                <p class="text-lg font-medium">
                                    Nepal
                                </p>
                            </div>

                        </div>
                    </div>
                    <div
                        class="rounded-lg border border-gray-300 px-4 py-3 md:px-6 md:py-6 bg-white ">
                        <h3 class="text-xl font-semibold text-primary">Passenger 3. Adult</h3>

                        <div
                            class="form-layout grid grid-cols-2 md:grid-cols-3 gap-4 mt-2 md:mt-4">
                            <div class="w-full ">
                                <div>
                                    <label for="fname" class="block text-sm font-medium mb-2 text-gray-400">Passenger Name <span class="text-red-600">*</span></label>

                                    <p class="text-lg font-medium">
                                        Mr. John Smith
                                    </p>
                                </div>
                            </div>

                            <div class="w-full ">
                                <label for="dob" class="block text-sm font-medium mb-2 text-gray-400">Date of Birth <span class="text-red-600">*</span></label>
                                <p class="text-lg font-medium">
                                    15/06/2022
                                </p>
                            </div>
                            <div class="w-full ">
                                <label for="dob" class="block text-sm font-medium mb-2 text-gray-400">Nationality <span class="text-red-600">*</span></label>
                                <p class="text-lg font-medium">
                                    Nepal
                                </p>
                            </div>
                            <div class="w-full ">
                                <label for="dob" class="block text-sm font-medium mb-2 text-gray-400">Document Type <span class="text-red-600">*</span></label>
                                <p class="text-lg font-medium">
                                    Passport
                                </p>
                            </div>
                            <div class="w-full ">
                                <label for="dob" class="block text-sm font-medium mb-2 text-gray-400">Passport Number <span class="text-red-600">*</span></label>
                                <p class="text-lg font-medium">
                                    98976568238566
                                </p>
                            </div>
                            <div class="w-full ">
                                <label for="dob" class="block text-sm font-medium mb-2 text-gray-400">Expiration Date <span class="text-red-600">*</span></label>
                                <p class="text-lg font-medium">
                                    15/06/2022
                                </p>
                            </div>
                            <div class="w-full ">
                                <label for="dob" class="block text-sm font-medium mb-2 text-gray-400">Issued Country <span class="text-red-600">*</span></label>
                                <p class="text-lg font-medium">
                                    Nepal
                                </p>
                            </div>

                        </div>
                    </div>

                </div>
                <!-- / Passenger Display Layout  -->
                <div
                    class="rounded-lg border border-gray-300 px-4 py-3 md:px-6 md:py-6 bg-white mt-2">
                    <h3 class="text-2xl font-semibold text-secondary">Emergency Contact</h3>
                    <!-- Form Layout  -->
                    <div
                        class="form-layout grid grid-cols-2 md:grid-cols-3 gap-4 mt-2 md:mt-4">
                        <div class="w-full ">
                            <div>
                                <label for="fname" class="block text-sm font-medium mb-2 text-gray-400">Passenger Name <span class="text-red-600">*</span></label>

                                <p class="text-lg font-medium">
                                    Mr. John Smith
                                </p>
                            </div>
                        </div>

                        <div class="w-full ">
                            <label for="dob" class="block text-sm font-medium mb-2 text-gray-400">Phone Number<span class="text-red-600">*</span></label>
                            <p class="text-lg font-medium">
                                9876543210
                            </p>
                        </div>
                        <div class="w-full ">
                            <label for="dob" class="block text-sm font-medium mb-2 text-gray-400">Email Address <span class="text-red-600">*</span></label>
                            <p class="text-lg font-medium">
                                someone@example.com
                            </p>
                        </div>


                    </div>
                    <!-- / Form Layout  -->
                </div>
            </div>
            <!-- / Passenger Info  -->

            <!-- Order Summaray  -->
            <div
                class="col-span-12 md:col-span-4 order-4 md:order-2 hidden md:block md:mt-12">

                <div
                    class="rounded-lg border border-gray-300 px-4 py-3 md:px-6 md:py-6 sticky top-0 bg-white">
                    <h4 class="text-xl font-semibold text-primary">Order Summary</h4>
                    <div class="mt-2 flex flex-col gap-2 py-4">
                        <div class="flex items-center justify-between">
                            <h5 class="text-base font-semibold">Ticket (1 Adult )</h5>
                            <p class="text-base font-semibold">Rs 1500</p>
                        </div>
                        <div class="flex items-center justify-between">
                            <h5 class="text-sm font-medium text-gray-400">Flight Fare</h5>
                            <p class="text-sm font-medium text-gray-400">Rs 1500</p>
                        </div>
                        <div class="flex items-center justify-between">
                            <h5 class="text-sm font-medium text-gray-400">
                                Taxes and Airline Fees
                            </h5>
                            <p class="text-sm font-medium text-gray-400">Rs 1500</p>
                        </div>
                    </div>
                    <div class="mt-2 border-t border-gray-200 py-4">
                        <div class="flex justify-between items-center">
                            <h5 class="font-semibold text-2xl">Total</h5>
                            <h5 class="font-semibold text-2xl">Rs 1500</h5>
                        </div>
                        <p class="text-xs font-medium text-gray-400">
                            Individual Taxes and Charges
                        </p>
                    </div>
                </div>
            </div>
            <!-- / Order Summaray  -->

            <!-- Book Ticket  -->
            <div class="col-span-12 md:col-span-8 order-3 md:order-4">
                <div
                    class="rounded-lg border border-gray-300 px-4 py-3 md:px-6 md:py-6 bg-white">
                    <div class="flex flex-col gap-3">
                        <h6 class="text-lg font-semibold">Book Ticket</h6>

                        <p class="text-gray-400 text-sm font-medium">
                            <span class="text-black">Please note:</span> Check the instructions about the passengers carefully before continue booking.
                        </p>

                        <button
                            class="g-button-primary px-4 py-4 max-w-fit text-white font-medium rounded-lg">
                            Continue Booking
                        </button>
                    </div>
                </div>
            </div>
            <!-- / Book Ticket  -->
        </div>
    </div>
</section>
<!-- / Page Layout  -->

@endsection