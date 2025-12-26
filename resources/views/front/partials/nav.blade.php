 <header
     class="flex flex-wrap  @if (request()->is('/') ||
             request()->is('about-us') ||
             request()->is('contact-us') ||
             request()->is('flight/passenger-details') ||
             Route::is(' flight.payment')) md:absolute md:top-2 @endif sm:justify-start w-full md:z-50 text-sm">
     <nav class="container navbar w-full bg-white rounded-xl mx-auto px-4 py-3 flex items-center justify-between">
         <a class="flex-none font-semibold text-xl text-black focus:outline-none focus:opacity-80"
             href="{{ route('frontend.index') }}" aria-label="Brand">
             <img src="{{ isset($site->primary_logo) ? asset('uploads/site/' . $site->primary_logo) : asset('frontend/images/logo.png') }}"
                 alt="" width="100px" height="60px" /></a>
         <div class="flex gap-3">
             <div class="flex flex-col gap-2">
                 <div class="hidden md:flex flex-row items-center justify-end mt-0 gap-5">
                     <a class="flex gap-2 text-xs items-center text-gray-500" href="tel: 01-4547791"><i
                             class="fa-solid fa-phone text-primary"></i> 01-4547791/9802368063/9860146706</a>
                     <a class="flex gap-2 text-xs items-center text-gray-500" href="mailto: info@flightsgyani.com">
                         <i class="fa-solid fa-envelope text-primary"></i>info@flightsgyani.com
                     </a>
                     <!-- <div class="flex gap-2 text-xs items-center text-gray-500"> <i class="fa-solid fa-map-location-dot text-primary"></i> Kathmandu</div> -->
                 </div>
                 <div class="flex flex-row items-center justify-end mt-0 gap-2">
                     <div class="gap-5 items-center hidden sm:flex">
                         {{-- <a class="nav-item" href="{{ route('frontend.index') }}">Home</a> --}}
                         {{-- <a class="nav-item" href="https://gyaniholidays.com/" target="_blank">Tours</a> --}}
                         <!-- <a class="nav-item" href="{{ route('frontend.about') }}">About Us</a>
                 <a class="nav-item" href="{{ route('frontend.contact') }}">Contact Us</a> -->
                         {{-- @auth()
                        @role('Admin')
                        <li>
                            <a href="{{route('admin.dashboard')}}" style="color: red">Cockpit</a>
                         </li>
                         @else
                         <li>
                             <a href="{{route('home')}}" style="color: red">My Bookings</a>
                         </li>
                         @endrole
                         @endauth --}}
                     </div>
                     @guest
                         <a class="py-2 px-4 hidden md:inline-flex border border-primary text-primary items-center gap-x-2 text-sm font-semibold tracking-wider rounded-lg focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
                             href="{{ route('login') }}">
                             Sign In
                         </a>
                         {{-- <a class="py-2 px-4 hidden md:inline-flex items-center gap-x-2 border border-primary text-sm font-semibold tracking-wider rounded-lg g-button-primary text-white focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
                             href="{{ route('register') }}">
                             Sign Up
                         </a> --}}
                         {{-- <a class="py-2 px-4 hidden md:inline-flex items-center gap-x-2 border border-primary text-sm font-semibold tracking-wider rounded-lg g-button-primary text-white focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
                             href="{{ route('agent.login') }}">
                             Agent Login
                         </a> --}}
                         <a class="py-2 px-4 hidden md:inline-flex items-center gap-x-2 border border-primary text-sm font-semibold tracking-wider rounded-lg g-button-primary text-white focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
                             href="{{ route('agent.login') }}">
                             Agent Login
                         </a>
                     @else
                         @if (Auth::user()->user_type == 'ADMIN')
                             <a class="py-3 px-8 hidden md:inline-flex items-center gap-x-2 text-sm font-semibold tracking-wider rounded-lg g-button-primary text-white focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
                                 href="{{ route('v2.admin.dashboard') }}">
                                 Cockpit
                             </a>
                         @elseif (Auth::user()->user_type == 'AGENT')
                             <span
                                 class="py-2.5 px-5 hidden md:inline-flex border border-primary text-primary items-center gap-x-2 text-sm font-semibold tracking-wider rounded-lg focus:outline-none disabled:opacity-50 disabled:pointer-events-none">
                                 NPR: {{ remainingBalance(Auth::user()->id, 'NPR') }}
                             </span>
                             <a class="py-3 px-8 hidden md:inline-flex items-center gap-x-2 text-sm font-semibold tracking-wider rounded-lg g-button-primary text-white focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
                                 href="{{ route('b2b.agent.dashboard') }}">
                                 Dashboard
                             </a>
                         @else
                             <a class="py-3 px-8 hidden md:inline-flex items-center gap-x-2 text-sm font-semibold tracking-wider rounded-lg g-button-primary text-white focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
                                 href="{{ route('home') }}">
                                 My Bookings
                             </a>
                         @endif
                         <form action="{{ route('logout') }}" method="POST">
                             @csrf
                             <button class="bg-red-500 text-white rounded py-3 px-4 ml-2">
                                 <i class="fa fa-right-from-bracket"></i>
                                 &nbsp;Logout
                             </button>
                         </form>
                     @endguest

                     <button
                         class="m-1 ms-0 py-3 px-4 md:hidden inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
                         data-hs-overlay="#hs-offcanvas-right" type="button" aria-haspopup="dialog"
                         aria-expanded="false" aria-controls="hs-offcanvas-right">
                         <i class="fa-solid fa-bars text-xl"></i>
                     </button>
                 </div>
             </div>
             <div class="hs-overlay hs-overlay-open:translate-x-0 hidden translate-x-full fixed top-0 end-0 transition-all duration-300 transform h-full max-w-56 w-full z-20 bg-white border-s"
                 id="hs-offcanvas-right" role="dialog" tabindex="-1" aria-labelledby="hs-offcanvas-right-label">
                 <div class="flex justify-between items-center py-3 px-4 border-b">
                     <h3 class="font-bold text-gray-800" id="hs-offcanvas-right-label">
                         Flights Gyani
                     </h3>
                     <button
                         class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none"
                         data-hs-overlay="#hs-offcanvas-right" type="button" aria-label="Close">
                         <span class="sr-only">Close</span>
                         <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                             <path d="M18 6 6 18"></path>
                             <path d="m6 6 12 12"></path>
                         </svg>
                     </button>
                 </div>
                 <div class="p-4">
                     <div class="gap-5 flex flex-col">

                         <a class="nav-item" href="{{ route('frontend.index') }}">Home</a>
                         <a class="nav-item" href="https://gyaniholidays.com/" target="_blank">Tours</a>
                         <a class="nav-item" href="{{ route('frontend.about') }}">About Us</a>
                         <a class="nav-item" href="{{ route('frontend.contact') }}">Contact Us</a>
                         @guest
                             <a class="text-center py-3 px-8 md:inline-flex items-center gap-x-2 text-sm font-semibold tracking-wider rounded-lg g-button-primary text-white focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
                                 href="{{ route('login') }}">
                                 Sign In
                             </a>
                             <a class="text-center py-3 px-8 md:inline-flex items-center gap-x-2 text-sm font-semibold tracking-wider rounded-lg g-button-primary text-white focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
                                 href="{{ route('agent.login') }}">
                                 Agent Login
                             </a>
                         @else
                             {{-- @role('Admin')
                                 <a class="py-3 px-8  md:inline-flex items-center gap-x-2 text-sm font-semibold tracking-wider rounded-lg g-button-primary text-white focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
                                     href="{{ route('admin.dashboard') }}">
                                     Cockpit
                                 </a>
                             @else
                                 <a class="py-3 px-8  md:inline-flex items-center gap-x-2 text-sm font-semibold tracking-wider rounded-lg g-button-primary text-white focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
                                     href="{{ route('home') }}">
                                     My Bookings
                                 </a>
                             @endrole --}}
                             @if (Auth::user()->user_type == 'ADMIN')
                                 <a class="py-3 px-8  md:inline-flex items-center gap-x-2 text-sm font-semibold tracking-wider rounded-lg g-button-primary text-white focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
                                     href="{{ route('v2.admin.dashboard') }}">
                                     Cockpit
                                 </a>
                             @elseif (Auth::user()->user_type == 'AGENT')
                                 <a class="py-3 px-8  md:inline-flex items-center gap-x-2 text-sm font-semibold tracking-wider rounded-lg g-button-primary text-white focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
                                     href="{{ route('b2b.agent.dashboard') }}">
                                     Dashboard
                                 </a>
                             @else
                                 <a class="py-3 px-8  md:inline-flex items-center gap-x-2 text-sm font-semibold tracking-wider rounded-lg g-button-primary text-white focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
                                     href="{{ route('home') }}">
                                     My Bookings
                                 </a>
                             @endif
                             <form action="{{ route('logout') }}" method="POST">
                                 @csrf
                                 <button class="bg-red-500 text-white rounded py-3 px-4 ml-2">
                                     <i class="fa fa-right-from-bracket"></i>
                                     &nbsp;Logout
                                 </button>
                             </form>
                         @endguest

                     </div>
                 </div>
             </div>
         </div>
     </nav>
 </header>
