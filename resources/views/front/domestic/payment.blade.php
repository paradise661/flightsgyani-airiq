@extends('layouts.front')
@section('title')
    Payment Details
@endsection
@section('body')
    <div class="banner h-[100px] w-full overflow-hidden relative flex items-end justify-center">
        <img class="absolute top-0 right-0" src="./../../public/images/banner-plane.png" alt="" />
        <div class="max-h-fit text-center items-baseline">
            <h4 class="text-white text-4xl font-bold tracking-wide z-10 relative">
                Payment Details
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
                        Payment
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

    <section class="payment-layout mt-4 md:mt-8">
        <div class="container mx-auto">
            <div class="container mx-auto">
                <div class="grid grid-cols-12 gap-4">
                    <!-- Payment Method  -->
                    <div class="col-span-12 md:col-span-8 order-1 md:order-1">
                        <div class="rounded-lg border border-gray-300 px-4 py-3 md:px-6 md:py-6 bg-white">
                            <h3 class="text-2xl font-semibold">Payment Method</h3>
                            <p class="text-sm text-gray-400 font-normal py-1">
                                Payment can be done with any card through the banks below.
                            </p>
                            <div class="bank-listing mt-2 px-1 md:px-4">
                                <div class="grid sm:grid-cols-2 gap-2">

                                    <label
                                        class="flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 has-[:checked]:ring-1 has-[:checked]:ring-primary"
                                        for="khalti">
                                        <input
                                            class="shrink-0 mt-0.5 border-gray-200 hidden rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                            id="khalti" type="radio" name="payment-radio" />
                                        <div class="flex gap-4 items-center">
                                            <img src="{{ asset('frontend/images/khalti.png') }}" alt=""
                                                width="78px" height="78px" />
                                            <h6 class="text-xl text-gray-500 font-semibold">
                                                Khalti
                                            </h6>
                                        </div>
                                    </label>

                                </div>
                                <form action="{{ route('domesticflights.payment.store') }}" method="POST">
                                    @csrf
                                    <button
                                        class="bg-primary px-5 py-3 max-w-fit text-white text-base font-medium rounded-lg mt-4"
                                        id="payNow" type="submit">
                                        Pay Now
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- / Payment Method  -->

                    <!-- Order Summaray  -->
                    @include('front.domestic.ordersummary')
                    <!-- / Order Summaray  -->

                    <!-- Card Details  -->
                    {{-- <div class="col-span-12 md:col-span-8 order-2 md:order-3">
                        <div class="rounded-lg border border-gray-300 px-4 py-3 md:px-6 md:py-6 bg-white">
                            <!-- Card Form Layout  -->
                            <div class="flex">
                                <input type="radio" name="add-a-card"
                                    class="shrink-0 mt-0.5 border-gray-200 rounded-full text-secondary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                    id="add-card" />
                                <label for="add-card" class="text-sm text-gray-500 ms-2">Add a Card</label>
                            </div>
                            <div class="grid sm:grid-cols-2 gap-2 mt-2">
                                <label for="visa-check"
                                    class="flex items-center p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 has-[:checked]:ring-1 has-[:checked]:ring-primary">
                                    <div class="flex gap-4 items-center">
                                        <img src="./../../public/images/visa.png" alt="" width="70px"
                                            height="77px" />
                                        <div class="flex flex-col gap-1">
                                            <h6 class="text-xl font-medium text-primary">visa</h6>
                                            <p class="text-gray-400 text-xs">****7690</p>
                                        </div>
                                    </div>
                                    <input type="checkbox"
                                        class="shrink-0 size-6 ms-auto mt-0.5 border-gray-200 rounded-full text-secondary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none"
                                        id="visa-check" />
                                </label>
                            </div>
                            <div class="form-layout grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 md:mt-8">
                                <div class="w-full">
                                    <label for="ch-name" class="block text-sm font-semibold mb-2">Cardholder's Name
                                        <span class="text-red-600">*</span></label>
                                    <input type="text" id="ch-name"
                                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                        placeholder="Cardholder's Name" />
                                </div>
                                <div class="w-full">
                                    <label for="card-no" class="block text-sm font-semibold mb-2">Card Number <span
                                            class="text-red-600">*</span></label>
                                    <input type="number" id="card-no"
                                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                        placeholder="******" />
                                </div>
                                <div class="w-full">
                                    <label for="card-exp" class="block text-sm font-semibold mb-2">Expiration Date
                                        <span class="text-red-600">*</span></label>
                                    <input type="text" id="card-exp"
                                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                        placeholder="MM/YY" />
                                </div>
                                <div class="w-full">
                                    <label for="card-cvc" class="block text-sm font-semibold mb-2">Id/Document Number
                                        <span class="text-red-600">*</span></label>
                                    <input type="text" id="card-cvc"
                                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                        placeholder="MM/YY" />
                                </div>

                                <button type="button"
                                    class="bg-primary px-5 py-3 max-w-fit text-white text-base font-medium rounded-lg">
                                    Pay Now
                                </button>
                            </div>
                            <!-- / Card Form Layout  -->
                        </div>
                    </div> --}}
                    <!-- / Card Details  -->

                </div>
            </div>
        </div>
    </section>
@endsection
