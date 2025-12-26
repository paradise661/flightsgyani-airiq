@extends('layouts.front')

@section('body')
    <div class="user-dash mt-3">
        <div class="container mx-auto">
            <div class="grid grid-cols-12 gap-4">
                <!-- responsive dashboard nav  -->
                <div class="block md:hidden col-span-12">
                    <div class="flex justify-between items-center px-4 py-2">
                        <div>
                            <button type="button"
                                class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-primary text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                                aria-haspopup="dialog" aria-expanded="false" aria-controls="dash-nav-offcanvas"
                                data-hs-overlay="#dash-nav-offcanvas">
                                <i class="fa-solid fa-bars"></i>
                            </button>

                            <div id="dash-nav-offcanvas"
                                class="hs-overlay hs-overlay-open:translate-x-0 hidden -translate-x-full fixed top-0 start-0 transition-all duration-300 transform h-full max-w-xs w-full z-[80] bg-white border-e"
                                role="dialog" tabindex="-1" aria-labelledby="dash-nav-offcanvas-label">
                                <div class="flex justify-between items-center py-3 px-4 border-b">
                                    <h3 id="dash-nav-offcanvas-label" class="font-bold text-gray-800">
                                        User Dashboard
                                    </h3>
                                    <button type="button"
                                        class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none"
                                        aria-label="Close" data-hs-overlay="#dash-nav-offcanvas">
                                        <span class="sr-only">Close</span>
                                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M18 6 6 18"></path>
                                            <path d="m6 6 12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="p-4">
                                    <div class="user-dash-nav py-4 bg-white rounded-lg">
                                        <div class="flex flex-col gap-3">
                                            <div class="dash-nav-item">
                                                <a href="{{ route('profile.index') }}">
                                                    <div
                                                        class="flex items-center gap-5 py-1 {{ Route::is('profile.index') ? 'active' : null }}">
                                                        <i class="fa-solid fa-user text-xl"></i>
                                                        <div>
                                                            <h6 class="text-base font-semibold leading-4 capitalize">
                                                                Account information
                                                            </h6>
                                                            <p class="text-xs capitalize py-1">
                                                                your account information
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="dash-nav-item">
                                                <a href="{{ route('home') }}">
                                                    <div
                                                        class="flex items-center gap-5 py-1  {{ Route::is('home') ? 'active' : null }}">
                                                        <i class="fa-solid fa-ticket text-xl"></i>
                                                        <div>
                                                            <h6 class="text-base font-semibold leading-4 capitalize">
                                                                International Bookings
                                                            </h6>
                                                            <p class="text-xs capitalize py-1">your international bookings</p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="dash-nav-item">
                                                <a href="{{ route('home.domesticbooking.detail') }}">
                                                    <div
                                                        class="flex items-center gap-5 py-1  {{ Route::is('home.domesticbooking.detail') ? 'active' : null }}">
                                                        <i class="fa-solid fa-ticket text-xl"></i>
                                                        <div>
                                                            <h6 class="text-base font-semibold leading-4 capitalize">
                                                                Domestic Bookings
                                                            </h6>
                                                            <p class="text-xs capitalize py-1">your domestic bookings</p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button class="flex items-center gap-5 py-1">
                                                    <i class="fa-solid fa-right-from-bracket text-xl"></i>
                                                    <div class="text-start">
                                                        <h6 class="text-base font-semibold leading-4 capitalize">
                                                            Log Out
                                                        </h6>
                                                        <p class="text-xs capitalize py-1">
                                                            log out of system
                                                        </p>
                                                    </div>
                                                </button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="r-profile bg-white rounded-lg">
                            <div class="flex items-center gap-4">
                                <div>
                                    <h6 class="font-bold text-xl">{{ auth()->user()->name }}</h6>
                                    <p class="font-medium text-xs leading-5">{{ auth()->user()->email }}</p>
                                </div>
                                {{-- <img class="rounded-full"
                                    src="https://images.pexels.com/photos/678783/pexels-photo-678783.jpeg?auto=compress&amp;cs=tinysrgb&amp;w=1260&amp;h=750&amp;dpr=1"
                                    alt=""> --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50">
                                    <!-- Circle for the Avatar -->
                                    <circle cx="25" cy="25" r="25" fill="#00a652" />

                                    <!-- Initials or Placeholder Text -->
                                    <text x="50%" y="50%" font-size="20" text-anchor="middle" fill="white"
                                        dy=".3em">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</text>
                                </svg>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- / responsive dashboard nav  -->
                <div class="hidden md:block col-span-4">
                    <div class="sidebar h-full p-3 bg-secondary-lighter rounded-2xl flex flex-col gap-3">
                        <div class="profile px-7 py-4 bg-white rounded-lg">
                            <div class="flex items-center gap-4">
                                {{-- <img class="rounded-full"
                                    src="https://images.pexels.com/photos/678783/pexels-photo-678783.jpeg?auto=compress&amp;cs=tinysrgb&amp;w=1260&amp;h=750&amp;dpr=1"
                                    alt=""> --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50">
                                    <!-- Circle for the Avatar -->
                                    <circle cx="25" cy="25" r="25" fill="#00a652" />

                                    <!-- Initials or Placeholder Text -->
                                    <text x="50%" y="50%" font-size="20" text-anchor="middle" fill="white"
                                        dy=".3em">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</text>
                                </svg>

                                <div>
                                    <h6 class="font-bold text-xl">{{ auth()->user()->name }}</h6>
                                    <p class="font-medium text-xs leading-5">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="user-dash-nav px-7 py-4 bg-white rounded-lg">
                            <div class="flex flex-col gap-3">
                                <div class="dash-nav-item">
                                    <a href="{{ route('profile.index') }}">
                                        <div
                                            class="flex items-center gap-5 py-1 {{ Route::is('profile.index') ? 'active' : null }}">
                                            <i class="fa-solid fa-user text-xl"></i>
                                            <div>
                                                <h6 class="text-base font-semibold leading-4 capitalize">
                                                    Account information
                                                </h6>
                                                <p class="text-xs capitalize py-1">
                                                    your account information
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="dash-nav-item">
                                    <a href="{{ route('home') }}">
                                        <div
                                            class="flex items-center gap-5 py-1  {{ Route::is('home') ? 'active' : null }}">
                                            <i class="fa-solid fa-ticket text-xl"></i>
                                            <div>
                                                <h6 class="text-base font-semibold leading-4 capitalize">
                                                    International Bookings
                                                </h6>
                                                <p class="text-xs capitalize py-1">your international bookings</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="dash-nav-item">
                                    <a href="{{ route('home.domesticbooking.detail') }}">
                                        <div
                                            class="flex items-center gap-5 py-1  {{ Route::is('home.domesticbooking.detail') ? 'active' : null }}">
                                            <i class="fa-solid fa-ticket text-xl"></i>
                                            <div>
                                                <h6 class="text-base font-semibold leading-4 capitalize">
                                                    Domestic Bookings
                                                </h6>
                                                <p class="text-xs capitalize py-1">your domestic bookings</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="dash-nav-item">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="flex items-center gap-5 py-1">
                                            <i class="fa-solid fa-right-from-bracket text-xl"></i>
                                            <div class="text-start">
                                                <h6 class="text-base font-semibold leading-4 capitalize">
                                                    Log Out
                                                </h6>
                                                <p class="text-xs capitalize py-1">
                                                    log out of system
                                                </p>
                                            </div>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-8">
                    <div class="bg-secondary-lighter rounded-2xl flex flex-col h-full p-4 gap-4">
                        @include('messages')

                        @if (auth()->user()?->email_verified_at == null)
                            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v4a1 1 0 002 0V7zm-1 8a1.5 1.5 0 110-3 1.5 1.5 0 010 3z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium">Warning!</h3>
                                        <div class="mt-2 text-sm">
                                            <p>You need to verify your email address. Please check your email for a
                                                verification link.</p>
                                        </div>
                                        <div class="mt-4">
                                            <form method="POST" action="{{ route('user.verification.resend') }}">
                                                @csrf
                                                <button type="submit"
                                                    class="text-sm font-medium text-red-600 hover:text-red-500 underline">
                                                    Resend Verification Email
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="bg-white px-4 py-6 rounded-lg">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
