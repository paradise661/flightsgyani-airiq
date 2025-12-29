<header
    class="@if (request()->is('/') ||
            request()->is('about-us') ||
            request()->is('contact-us') ||
            request()->is('flight/passenger-details') ||
            Route::is('flight.payment')) md:absolute  @endif
    w-full z-50">

    <nav class="  px-6 py-2  bg-primary md:bg-transparent ">
        <div
            class="  container mx-auto  flex items-center justify-between gap-6">

            <!-- LOGO -->
            <a href="{{ route('frontend.index') }}" class="flex items-center shrink-0">
                <img src="{{ isset($site->primary_logo) ? asset('uploads/site/' . $site->primary_logo) : asset('frontend/images/logonew.png') }}"
                    alt="Flights Gyani" class="h-12 object-contain">
            </a>
            <!-- PHONE & EMAIL (CENTER) -->
            <div class=" hidden lg:flex flex items-center gap-6 text-sm text-white">
                <a href="tel:01-4547791" class="flex items-center gap-2 hover:text-primary">
                    <i class="fa-solid fa-phone text-white"></i>
                    01-4547791 / 9802368063 / 9860146706
                </a>
                <span class="h-4 w-px bg-gray-300"></span>
                <a href="mailto:info@flightsgyani.com" class="flex items-center gap-2 hover:text-white">
                    <i class="fa-solid fa-envelope text-white"></i>
                    info@flightsgyani.com
                </a>
            </div>

            <!-- RIGHT ACTIONS -->
            <div class="flex items-center gap-3">

                @guest
                    <a href="{{ route('login') }}"
                        class="hidden md:inline-flex px-4 py-2 text-sm border border-white text-white rounded-full hover:bg-primary hover:text-white transition">
                        Sign In
                    </a>

                    <a href="{{ route('agent.login') }}"
                        class="hidden md:inline-flex px-5 py-2 text-sm font-semibold rounded-full bg-white text-[#1567ae] hover:opacity-90 transition">
                        Agent Login
                    </a>
                @else
                    @if (Auth::user()->user_type == 'ADMIN')
                        <a href="{{ route('v2.admin.dashboard') }}"
                            class="hidden md:inline-flex px-6 py-2 rounded-full bg-primary text-white text-sm font-semibold">
                            Cockpit
                        </a>
                    @elseif (Auth::user()->user_type == 'AGENT')
                        <span
                            class="hidden md:inline-flex px-4 py-2 rounded-full border border-primary text-primary text-sm font-semibold">
                            NPR: {{ remainingBalance(Auth::user()->id, 'NPR') }}
                        </span>

                        <a href="{{ route('b2b.agent.dashboard') }}"
                            class="hidden md:inline-flex px-6 py-2 rounded-full bg-primary text-white text-sm font-semibold">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('home') }}"
                            class="hidden md:inline-flex px-6 py-2 rounded-full bg-primary text-white text-sm font-semibold">
                            My Bookings
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="hidden md:block">
                        @csrf
                        <button
                            class="px-4 py-2 rounded-full bg-red-500 text-white text-sm hover:bg-red-600 transition">
                            Logout
                        </button>
                    </form>
                @endguest

                <!-- MOBILE MENU -->
                <button
                    class="md:hidden size-10 flex items-center justify-center rounded-full border border-white text-gray-700 text-white"
                    data-hs-overlay="#hs-offcanvas-right">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
            </div>
           
        </div>
    </nav>

    <!-- MOBILE OFFCANVAS (UNCHANGED) -->
    <div id="hs-offcanvas-right"
        class="hs-overlay hs-overlay-open:translate-x-0 hidden translate-x-full fixed top-0 end-0 w-72 h-full bg-white shadow-xl z-50 transition-all">

        <div class="flex items-center justify-between px-5 py-4 border-b">
            <h3 class="font-semibold text-lg">Flights Gyani</h3>
            <button data-hs-overlay="#hs-offcanvas-right">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <div class="p-5 space-y-4 text-sm">
            <a class="block nav-item" href="{{ route('frontend.index') }}">Home</a>
            <a class="block nav-item" href="https://gyaniholidays.com/" target="_blank">Tours</a>
            <a class="block nav-item" href="{{ route('frontend.about') }}">About Us</a>
            <a class="block nav-item" href="{{ route('frontend.contact') }}">Contact Us</a>

            <hr>

            @guest
                <a href="{{ route('login') }}"
                    class="block text-center py-2 rounded-full bg-primary text-white">Sign In</a>

                <a href="{{ route('agent.login') }}"
                    class="block text-center py-2 rounded-full bg-primary text-white">Agent Login</a>
            @else
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="w-full py-2 rounded-full bg-red-500 text-white">
                        Logout
                    </button>
                </form>
            @endguest
        </div>
    </div>
</header>
