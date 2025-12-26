@extends('layouts.front')
@section('title')
    Ticket Download
@endsection
@section('body')
    <!-- Banner -->
    <div class="banner h-[100px] w-full overflow-hidden relative flex items-end justify-center">
        <img class="absolute top-0 right-0" src="./../../public/images/banner-plane.png" alt="" />
        <div class="max-h-fit text-center items-baseline">
            <h4 class="text-white text-3xl font-bold tracking-wide z-10 relative">
                Ticket Success
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
                    Success
                </li>
            </ol>
        </div>
    </div>
    <!-- /Banner -->

    <section class="py-10 bg-gray-50 flex flex-col items-center justify-center mt-5">
        <div class="p-8 rounded-xl text-center transform transition-all duration-300">
            <h4 class="font-bold text-3xl text-gray-900 mb-4">
                Ticket Purchased <span class="text-primary">Successfully</span>
            </h4>
            <p class="text-lg text-gray-600 mb-6">
                Your ticket has been successfully purchased. You can download your ticket by clicking the button below.
            </p>
            <a class="inline-block bg-primary text-white py-3 px-8 text-lg font-medium rounded-md shadow-md transition-all duration-300 ease-in-out hover:bg-primary hover:text-white hover:shadow-2xl hover:scale-105"
                href="{{ route('download.ticket', $booking_code) }}">
                Download Your Ticket
            </a>
        </div>
    </section>
@endsection
