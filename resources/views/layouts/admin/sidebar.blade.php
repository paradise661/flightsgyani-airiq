<div class="hs-overlay [--auto-close:lg] hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-300 transform w-[260px] h-full hidden fixed inset-y-0 start-0 z-[60] bg-white border-e border-gray-200 lg:block lg:translate-x-0 lg:end-auto lg:bottom-0 dark:bg-neutral-800 dark:border-neutral-700"
    id="hs-application-sidebar" role="dialog" tabindex="-1" aria-label="Sidebar">
    <div class="relative flex flex-col h-full max-h-full">
        <div class="px-6 pt-4">
            <!-- Logo -->
            <a class="flex-none rounded-xl text-xl inline-block font-semibold focus:outline-none focus:opacity-80"
                href="{{ route('frontend.index') }}" aria-label="Preline">
                <img src="{{ asset('frontend/images/logo.png') }}" width="100" height="60" alt="" />
            </a>
            <!-- End Logo -->
        </div>

        <!-- Content -->
        <div
            class="h-full overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
            <nav class="hs-accordion-group p-3 w-full flex flex-col flex-wrap" data-hs-accordion-always-open>
                <ul class="flex flex-col space-y-1">
                    @if (Auth::user()->user_type == 'ADMIN')

                        {{-- @can('view dashboard') --}}
                        <h3 class="uppercase text-sm text-gray-400 tracking-widest py-2">
                            Dashboard
                        </h3>
                        <li>
                            <a class=" w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg dark:bg-neutral-700 hover:bg-gray-100 dark:hover:bg-neutral-700 dark:text-neutral-200 dark:hover:text-neutral-300"
                                href="{{ route('v2.admin.dashboard') }}">
                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                    <polyline points="9 22 9 12 15 12 15 22" />
                                </svg> Dashboard
                            </a>
                        </li>
                        {{-- @endcan --}}

                        @canany([
                            'view sabre',
                            'view airport',
                            'view airline',
                            'view bspcommission',
                            'view markup',
                            'view
                            searchlog',
                            'view booking',
                            ])

                            <h3 class="uppercase text-sm text-gray-400 tracking-widest py-2">
                                International
                            </h3>
                            <li class="hs-accordion" id="international-accordion">
                                <button
                                    class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-500 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:text-neutral-200"
                                    type="button" aria-expanded="false" aria-controls="projects-accordion-child">
                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"
                                            stroke="#CCCCCC" stroke-width="0.1"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path
                                                d="m24.794 16.522-.281-2.748-10.191-5.131s.091-1.742 0-4.31c-.109-1.68-.786-3.184-1.839-4.339l.005.006h-.182c-1.048 1.15-1.726 2.653-1.834 4.312l-.001.021c-.091 2.567 0 4.31 0 4.31l-10.19 5.131-.281 2.748 6.889-2.074 3.491-.582c-.02.361-.031.783-.031 1.208 0 2.051.266 4.041.764 5.935l-.036-.162-2.728 1.095v1.798l3.52-.8c.155.312.3.566.456.812l-.021-.035v.282c.032-.046.062-.096.093-.143.032.046.061.096.094.143v-.282c.135-.21.28-.464.412-.726l.023-.051 3.52.8v-1.798l-2.728-1.095c.463-1.733.728-3.723.728-5.774 0-.425-.011-.847-.034-1.266l.003.058 3.492.582 6.888 2.074z">
                                            </path>
                                        </g>
                                    </svg>
                                    International Flights

                                    <svg class="hs-accordion-active:block ms-auto hidden size-4"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="m18 15-6-6-6 6" />
                                    </svg>

                                    <svg class="hs-accordion-active:hidden ms-auto block size-4"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="m6 9 6 6 6-6" />
                                    </svg>
                                </button>

                                <div class="hidden hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                                    id="projects-accordion-child" role="region" aria-labelledby="projects-accordion">
                                    <ul class="ps-8 pt-1 pgline space-y-1">
                                        @can('view sabre')
                                            <li>
                                                <a class=" flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-200"
                                                    href="{{ route('v2.admin.sabre.details') }}">
                                                    Sabre
                                                </a>
                                            </li>
                                        @endcan

                                        @can('view airport')
                                            <li>
                                                <a class=" flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-200"
                                                    href="{{ route('v2.admin.airport.index') }}">
                                                    Airports
                                                </a>
                                            </li>
                                        @endcan

                                        @can('view airline')
                                            <li>
                                                <a class=" flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-200"
                                                    href="{{ route('v2.admin.airline.index') }}">
                                                    Airlines
                                                </a>
                                            </li>
                                        @endcan

                                        @can('view bspcommission')
                                            <li>
                                                <a class=" flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-200"
                                                    href="{{ route('v2.admin.bspcommission.index') }}">
                                                    BSP Commissions
                                                </a>
                                            </li>
                                        @endcan

                                        @can('view markup')
                                            <li>
                                                <a class=" flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-200"
                                                    href="{{ route('v2.admin.markups.index') }}">
                                                    Markups
                                                </a>
                                            </li>
                                        @endcan

                                        @can('view searchlog')
                                            <li>
                                                <a class=" flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-200"
                                                    href="{{ route('v2.admin.flight.searchlog') }}">
                                                    Search Log
                                                </a>
                                            </li>
                                        @endcan

                                        @can('view booking')
                                            <li>
                                                <a class=" flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-200"
                                                    href="{{ route('v2.admin.flight.bookings') }}">
                                                    Bookings
                                                </a>
                                            </li>
                                        @endcan

                                        <li>
                                            <a class=" flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-200"
                                                href="{{ route('v2.admin.commissions.index') }}">
                                                Discounts
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endcanany

                        @canany([
                            'view plasma',
                            'view sector',
                            'view domesticairline',
                            'view domesticbooking',
                            'view
                            domesticsearchlog',
                            ])

                            <h3 class="uppercase text-sm text-gray-400 tracking-widest py-2">
                                Domestic
                            </h3>

                            <li class="hs-accordion" id="domestic-accordion">
                                <button
                                    class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-500 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:text-neutral-200"
                                    type="button" aria-expanded="false" aria-controls="projects-accordion-child">
                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"
                                            stroke="#CCCCCC" stroke-width="0.1"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path
                                                d="m24.794 16.522-.281-2.748-10.191-5.131s.091-1.742 0-4.31c-.109-1.68-.786-3.184-1.839-4.339l.005.006h-.182c-1.048 1.15-1.726 2.653-1.834 4.312l-.001.021c-.091 2.567 0 4.31 0 4.31l-10.19 5.131-.281 2.748 6.889-2.074 3.491-.582c-.02.361-.031.783-.031 1.208 0 2.051.266 4.041.764 5.935l-.036-.162-2.728 1.095v1.798l3.52-.8c.155.312.3.566.456.812l-.021-.035v.282c.032-.046.062-.096.093-.143.032.046.061.096.094.143v-.282c.135-.21.28-.464.412-.726l.023-.051 3.52.8v-1.798l-2.728-1.095c.463-1.733.728-3.723.728-5.774 0-.425-.011-.847-.034-1.266l.003.058 3.492.582 6.888 2.074z">
                                            </path>
                                        </g>
                                    </svg>
                                    Domestic Flights

                                    <svg class="hs-accordion-active:block ms-auto hidden size-4"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m18 15-6-6-6 6" />
                                    </svg>

                                    <svg class="hs-accordion-active:hidden ms-auto block size-4"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m6 9 6 6 6-6" />
                                    </svg>
                                </button>

                                <div class="hidden hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                                    id="projects-accordion-child" role="region" aria-labelledby="projects-accordion">
                                    <ul class="ps-8 pgline pt-1 space-y-1">
                                        @can('view plasma')
                                            <li>
                                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-200"
                                                    href="{{ route('v2.admin.plasma') }}">
                                                    Plasma
                                                </a>
                                            </li>
                                        @endcan

                                        @can('view sector')
                                            <li>
                                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-200"
                                                    href="{{ route('v2.admin.domestic.sectors.index') }}">
                                                    Sectors
                                                </a>
                                            </li>
                                        @endcan

                                        @can('view domesticairline')
                                            <li>
                                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-200"
                                                    href="{{ route('v2.admin.domestic.airlines.index') }}">
                                                    Airlines
                                                </a>
                                            </li>
                                        @endcan

                                        @can('view domesticairlinecommission')
                                            <li>
                                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-200"
                                                    href="{{ route('v2.admin.domestic.commissions.index') }}">
                                                    Discounts
                                                </a>
                                            </li>
                                        @endcan

                                        @can('view domesticbooking')
                                            <li>
                                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-200"
                                                    href="{{ route('v2.admin.domestic.flight.bookings') }}">
                                                    Bookings
                                                </a>
                                            </li>
                                        @endcan

                                        @can('view domesticsearchlog')
                                            <li>
                                                <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-200"
                                                    href="{{ route('v2.admin.domestic.flight.search') }}">
                                                    Search Log
                                                </a>
                                            </li>
                                        @endcan

                                    </ul>
                                </div>
                            </li>
                        @endcan

                        @canany([
                            'view branch',
                            'view about',
                            'view page',
                            'view faq',
                            'view team',
                            'view blog',
                            'view
                            whatwedo',
                            'view slider',
                            'view sitesetting',
                            ])

                            <h3 class="uppercase text-sm text-gray-400 tracking-widest py-2">
                                CMS
                            </h3>
                            <li class="hs-accordion" id="international-accordion">
                                <button
                                    class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-500 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:text-neutral-200"
                                    type="button" aria-expanded="false" aria-controls="projects-accordion-child">
                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <g>
                                            <rect x="2" y="4" width="14" height="16" rx="2"
                                                ry="2" stroke="currentColor" stroke-width="2"></rect>
                                            <path d="M8 2v2M16 6h4M16 10h4M16 14h4M8 12h4M8 16h4" stroke="currentColor"
                                                stroke-width="2"></path>
                                            <path d="M8 20h8" stroke="currentColor" stroke-width="2"></path>
                                        </g>
                                    </svg>

                                    Website Content

                                    <svg class="hs-accordion-active:block ms-auto hidden size-4"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m18 15-6-6-6 6" />
                                    </svg>

                                    <svg class="hs-accordion-active:hidden ms-auto block size-4"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m6 9 6 6 6-6" />
                                    </svg>
                                </button>

                                <div class="hidden hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                                    id="projects-accordion-child" role="region" aria-labelledby="projects-accordion">
                                    <ul class="ps-8 pt-1 pgline space-y-1">
                                        @can('view branch')
                                            <li>
                                                <a class=" flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-200"
                                                    href="{{ route('v2.admin.branches.index') }}">
                                                    Branch
                                                </a>
                                            </li>
                                        @endcan

                                        @can('view about')
                                            <li>
                                                <a class=" flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-200"
                                                    href="{{ route('v2.admin.aboutus.index') }}">
                                                    About
                                                </a>
                                            </li>
                                        @endcan

                                        @can('view page')
                                            <li>
                                                <a class=" flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-200"
                                                    href="{{ route('v2.admin.pages.index') }}">
                                                    Pages
                                                </a>
                                            </li>
                                        @endcan

                                        @can('view faq')
                                            <li>
                                                <a class=" flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-200"
                                                    href="{{ route('v2.admin.faqs.index') }}">
                                                    FAQs
                                                </a>
                                            </li>
                                        @endcan

                                        @can('view team')
                                            <li>
                                                <a class=" flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-200"
                                                    href="{{ route('v2.admin.teams.index') }}">
                                                    Teams
                                                </a>
                                            </li>
                                        @endcan

                                        @can('view blog')
                                            <li>
                                                <a class=" flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-200"
                                                    href="{{ route('v2.admin.blog.index') }}">
                                                    Blogs
                                                </a>
                                            </li>
                                        @endcan

                                        @can('view whatwedo')
                                            <li>
                                                <a class=" flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-200"
                                                    href="{{ route('v2.admin.whatwedo.index') }}">
                                                    What We Do
                                                </a>
                                            </li>
                                        @endcan

                                        @can('view slider')
                                            <li>
                                                <a class=" flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-200"
                                                    href="{{ route('v2.admin.sliders.index') }}">
                                                    Sliders
                                                </a>
                                            </li>
                                        @endcan

                                        @can('view sitesetting')
                                            <li>
                                                <a class=" flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-200"
                                                    href="{{ route('v2.admin.site.setting') }}">
                                                    Site Settings
                                                </a>
                                            </li>
                                        @endcan

                                    </ul>
                                </div>
                            </li>
                        @endcanany

                        @if (Auth::user()->hasAnyRole('SUPER-ADMIN'))
                            <h3 class="uppercase text-sm text-gray-400 tracking-widest py-2">
                                Management
                            </h3>
                            <li class="hs-accordion" id="international-accordion">
                                <button
                                    class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-500 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:text-neutral-200"
                                    type="button" aria-expanded="false" aria-controls="projects-accordion-child">
                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <g>
                                            <rect x="2" y="4" width="14" height="16" rx="2"
                                                ry="2" stroke="currentColor" stroke-width="2"></rect>
                                            <path d="M8 2v2M16 6h4M16 10h4M16 14h4M8 12h4M8 16h4" stroke="currentColor"
                                                stroke-width="2"></path>
                                            <path d="M8 20h8" stroke="currentColor" stroke-width="2"></path>
                                        </g>
                                    </svg>

                                    Staff Management

                                    <svg class="hs-accordion-active:block ms-auto hidden size-4"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m18 15-6-6-6 6" />
                                    </svg>

                                    <svg class="hs-accordion-active:hidden ms-auto block size-4"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m6 9 6 6 6-6" />
                                    </svg>
                                </button>

                                <div class="hidden hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                                    id="projects-accordion-child" role="region"
                                    aria-labelledby="projects-accordion">
                                    <ul class="ps-8 pt-1 pgline space-y-1">
                                        <li>
                                            <a class=" flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-200"
                                                href="{{ route('v2.admin.users.index') }}">
                                                Staffs
                                            </a>
                                        </li>

                                        <li>
                                            <a class=" flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-200"
                                                href="{{ route('v2.admin.roles.index') }}">
                                                Roles
                                            </a>
                                        </li>

                                        <li>
                                            <a class=" flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-200"
                                                href="{{ route('v2.admin.permissions.index') }}">
                                                Permissions
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>
                        @endif

                        @canany(['view khalti', 'view inquiry', 'view registeruser'])
                            <h3 class="uppercase text-sm text-gray-400 tracking-widest py-2">
                                Others
                            </h3>
                            <li class="hs-accordion" id="international-accordion">
                                <button
                                    class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-500 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:text-neutral-200"
                                    type="button" aria-expanded="false" aria-controls="projects-accordion-child">
                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <g>
                                            <rect x="2" y="4" width="14" height="16" rx="2"
                                                ry="2" stroke="currentColor" stroke-width="2"></rect>
                                            <path d="M8 2v2M16 6h4M16 10h4M16 14h4M8 12h4M8 16h4" stroke="currentColor"
                                                stroke-width="2"></path>
                                            <path d="M8 20h8" stroke="currentColor" stroke-width="2"></path>
                                        </g>
                                    </svg>

                                    Others

                                    <svg class="hs-accordion-active:block ms-auto hidden size-4"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m18 15-6-6-6 6" />
                                    </svg>

                                    <svg class="hs-accordion-active:hidden ms-auto block size-4"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m6 9 6 6 6-6" />
                                    </svg>
                                </button>

                                <div class="hidden hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                                    id="projects-accordion-child" role="region" aria-labelledby="projects-accordion">
                                    <ul class="ps-8 pt-1 pgline space-y-1">
                                        <li>
                                            @can('view khalti')
                                                <a class=" w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg dark:bg-neutral-700 hover:bg-gray-100 dark:hover:bg-neutral-700 dark:text-neutral-200 dark:hover:text-neutral-300"
                                                    href="{{ route('v2.admin.khalti') }}">
                                                    Khalti Credentials
                                                </a>
                                            @endcan

                                            @can('view inquiry')
                                                <a class=" w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg dark:bg-neutral-700 hover:bg-gray-100 dark:hover:bg-neutral-700 dark:text-neutral-200 dark:hover:text-neutral-300"
                                                    href="{{ route('v2.admin.inquery.details') }}">
                                                    Inquery
                                                </a>
                                            @endcan

                                            @can('view registeruser')
                                                <a class=" w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg dark:bg-neutral-700 hover:bg-gray-100 dark:hover:bg-neutral-700 dark:text-neutral-200 dark:hover:text-neutral-300"
                                                    href="{{ route('v2.admin.registered.users') }}">
                                                    Registered Users
                                                </a>
                                            @endcan
                                            @if (Auth::user()->hasAnyRole('SUPER-ADMIN'))
                                                <a class=" w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg dark:bg-neutral-700 hover:bg-gray-100 dark:hover:bg-neutral-700 dark:text-neutral-200 dark:hover:text-neutral-300"
                                                    href="{{ route('v2.admin.activitylogs.index') }}">
                                                    Logs
                                                </a>

                                                <a class=" w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg dark:bg-neutral-700 hover:bg-gray-100 dark:hover:bg-neutral-700 dark:text-neutral-200 dark:hover:text-neutral-300"
                                                    href="{{ route('v2.admin.tickets.index') }}">
                                                    Ticket Details
                                                </a>
                                            @endif

                                        </li>

                                    </ul>
                                </div>
                            </li>

                        @endcanany

                        @if (Auth::user()->hasAnyRole('SUPER-ADMIN'))
                            <h3 class="uppercase text-sm text-gray-400 tracking-widest py-2">
                                B2B
                            </h3>
                            <li class="hs-accordion" id="international-accordion">
                                <button
                                    class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-500 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:text-neutral-200"
                                    type="button" aria-expanded="false" aria-controls="projects-accordion-child">
                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <g>
                                            <rect x="2" y="4" width="14" height="16" rx="2"
                                                ry="2" stroke="currentColor" stroke-width="2"></rect>
                                            <path d="M8 2v2M16 6h4M16 10h4M16 14h4M8 12h4M8 16h4" stroke="currentColor"
                                                stroke-width="2"></path>
                                            <path d="M8 20h8" stroke="currentColor" stroke-width="2"></path>
                                        </g>
                                    </svg>
                                    Agents
                                    <svg class="hs-accordion-active:block ms-auto hidden size-4"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m18 15-6-6-6 6" />
                                    </svg>

                                    <svg class="hs-accordion-active:hidden ms-auto block size-4"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m6 9 6 6 6-6" />
                                    </svg>
                                </button>

                                <div class="hidden hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                                    id="projects-accordion-child" role="region"
                                    aria-labelledby="projects-accordion">
                                    <ul class="ps-8 pt-1 pgline space-y-1">
                                        <li>
                                            <a class=" flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-200"
                                                href="{{ route('v2.admin.agentgroups.index') }}">
                                                Agent Group
                                            </a>
                                        </li>

                                        <li>
                                            <a class=" flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-200"
                                                href="{{ route('v2.admin.agents.index') }}">
                                                Agents
                                            </a>
                                        </li>

                                        <li>
                                            <a class=" flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-200"
                                                href="{{ route('v2.admin.b2b.markups.index') }}">
                                                Markups
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li>
                                <a class=" w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg dark:bg-neutral-700 hover:bg-gray-100 dark:hover:bg-neutral-700 dark:text-neutral-200 dark:hover:text-neutral-300"
                                    href="{{ route('v2.admin.transactions.list') }}">
                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <g id="SVGRepo_iconCarrier">
                                            <!-- Wallet -->
                                            <path
                                                d="M3 8C3 6.34315 4.34315 5 6 5H18C19.6569 5 21 6.34315 21 8V16C21 17.6569 19.6569 19 18 19H6C4.34315 19 3 17.6569 3 16V8Z" />
                                            <!-- Dollar sign in wallet -->
                                            <path d="M12 12V8M9 10H15" />
                                            <!-- Plus Sign (top-up) -->
                                            <path d="M12 6V18M9 12H15" />
                                            <!-- Arrow Up (suggesting deposit) -->
                                            <path d="M12 3V6" />
                                            <path d="M9 5L12 3L15 5" />
                                        </g>
                                    </svg>
                                    Agent Topups
                                </a>
                            </li>
                            <li>
                                <a class=" w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg dark:bg-neutral-700 hover:bg-gray-100 dark:hover:bg-neutral-700 dark:text-neutral-200 dark:hover:text-neutral-300"
                                    href="{{ route('v2.admin.transactions.all') }}">
                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <g id="SVGRepo_iconCarrier">
                                            <path d="M3 12l2 2 4-4 6 6 4-4 2 2" />
                                            <path d="M2 19h20" />
                                            <path d="M2 5h20" />
                                        </g>
                                    </svg>
                                    Transactions
                                </a>
                            </li>
                        @endif
                    @endif

                    @if (Auth::user()->user_type == 'AGENT')
                        <li>
                            <a class=" w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg dark:bg-neutral-700 hover:bg-gray-100 dark:hover:bg-neutral-700 dark:text-neutral-200 dark:hover:text-neutral-300"
                                href="{{ route('b2b.agent.dashboard') }}">
                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                    <polyline points="9 22 9 12 15 12 15 22" />
                                </svg> Dashboard
                            </a>
                        </li>
                        <li>
                            <a class=" w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg dark:bg-neutral-700 hover:bg-gray-100 dark:hover:bg-neutral-700 dark:text-neutral-200 dark:hover:text-neutral-300"
                                href="{{ route('b2b.agent.transactions') }}">
                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M3 12l2 2 4-4 6 6 4-4 2 2" />
                                        <path d="M2 19h20" />
                                        <path d="M2 5h20" />
                                    </g>
                                </svg>

                                Transactions
                            </a>
                        </li>

                        <li>
                            <a class=" w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg dark:bg-neutral-700 hover:bg-gray-100 dark:hover:bg-neutral-700 dark:text-neutral-200 dark:hover:text-neutral-300"
                                href="{{ route('b2b.agent.edit.ticket') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M22 9V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v2a2 2 0 0 1 0 4v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a2 2 0 0 1 0-4z">
                                    </path>
                                    <line x1="8" y1="9" x2="8" y2="9.01"></line>
                                    <line x1="8" y1="15" x2="8" y2="15.01"></line>
                                    <line x1="16" y1="9" x2="16" y2="9.01"></line>
                                    <line x1="16" y1="15" x2="16" y2="15.01"></line>
                                    <line x1="12" y1="9" x2="12" y2="15"></line>
                                </svg>

                                My profile
                            </a>
                        </li>
                        <li>
                            <a class=" w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg dark:bg-neutral-700 hover:bg-gray-100 dark:hover:bg-neutral-700 dark:text-neutral-200 dark:hover:text-neutral-300"
                                href="{{ route('b2b.agent.domestic.flight.bookings') }}">
                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"
                                        stroke="#CCCCCC" stroke-width="0.1"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path
                                            d="m24.794 16.522-.281-2.748-10.191-5.131s.091-1.742 0-4.31c-.109-1.68-.786-3.184-1.839-4.339l.005.006h-.182c-1.048 1.15-1.726 2.653-1.834 4.312l-.001.021c-.091 2.567 0 4.31 0 4.31l-10.19 5.131-.281 2.748 6.889-2.074 3.491-.582c-.02.361-.031.783-.031 1.208 0 2.051.266 4.041.764 5.935l-.036-.162-2.728 1.095v1.798l3.52-.8c.155.312.3.566.456.812l-.021-.035v.282c.032-.046.062-.096.093-.143.032.046.061.096.094.143v-.282c.135-.21.28-.464.412-.726l.023-.051 3.52.8v-1.798l-2.728-1.095c.463-1.733.728-3.723.728-5.774 0-.425-.011-.847-.034-1.266l.003.058 3.492.582 6.888 2.074z">
                                        </path>
                                    </g>
                                </svg>
                                Domestic Bookings
                            </a>
                        </li>
                        <li>
                            <a class=" w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg dark:bg-neutral-700 hover:bg-gray-100 dark:hover:bg-neutral-700 dark:text-neutral-200 dark:hover:text-neutral-300"
                                href="{{ route('b2b.agent.flight.bookings') }}">
                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"
                                        stroke="#CCCCCC" stroke-width="0.1"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path
                                            d="m24.794 16.522-.281-2.748-10.191-5.131s.091-1.742 0-4.31c-.109-1.68-.786-3.184-1.839-4.339l.005.006h-.182c-1.048 1.15-1.726 2.653-1.834 4.312l-.001.021c-.091 2.567 0 4.31 0 4.31l-10.19 5.131-.281 2.748 6.889-2.074 3.491-.582c-.02.361-.031.783-.031 1.208 0 2.051.266 4.041.764 5.935l-.036-.162-2.728 1.095v1.798l3.52-.8c.155.312.3.566.456.812l-.021-.035v.282c.032-.046.062-.096.093-.143.032.046.061.096.094.143v-.282c.135-.21.28-.464.412-.726l.023-.051 3.52.8v-1.798l-2.728-1.095c.463-1.733.728-3.723.728-5.774 0-.425-.011-.847-.034-1.266l.003.058 3.492.582 6.888 2.074z">
                                        </path>
                                    </g>
                                </svg>
                                International Bookings
                            </a>
                        </li>

                        <li class="hs-accordion" id="international-accordion">
                            <button
                                class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-500 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:text-neutral-200"
                                type="button" aria-expanded="false" aria-controls="projects-accordion-child">
                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <g id="SVGRepo_iconCarrier">
                                        <!-- Wallet -->
                                        <path
                                            d="M3 8C3 6.34315 4.34315 5 6 5H18C19.6569 5 21 6.34315 21 8V16C21 17.6569 19.6569 19 18 19H6C4.34315 19 3 17.6569 3 16V8Z" />
                                        <!-- Dollar sign in wallet -->
                                        <path d="M12 12V8M9 10H15" />
                                        <!-- Plus Sign (top-up) -->
                                        <path d="M12 6V18M9 12H15" />
                                        <!-- Arrow Up (suggesting deposit) -->
                                        <path d="M12 3V6" />
                                        <path d="M9 5L12 3L15 5" />
                                    </g>
                                </svg>

                                Finance

                                <svg class="hs-accordion-active:block ms-auto hidden size-4"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m18 15-6-6-6 6" />
                                </svg>

                                <svg class="hs-accordion-active:hidden ms-auto block size-4"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </button>

                            <div class="hidden hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                                id="projects-accordion-child" role="region" aria-labelledby="projects-accordion">
                                <ul class="ps-8 pt-1 pgline space-y-1">
                                    <li>
                                        <a class=" flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-200"
                                            href="{{ route('b2b.agent.transactions', ['type' => 'paid']) }}">
                                            Paid Invoice
                                        </a>
                                    </li>

                                    <li>
                                        <a class=" flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:bg-neutral-800 dark:text-neutral-200"
                                            href="{{ route('b2b.agent.transactions', ['type' => 'due']) }}">
                                            Due Invoice
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>
                    @endif

                </ul>
            </nav>
        </div>
        <!-- End Content -->
    </div>
</div>

<script>
    // for active class
    $(function() {
        let fullUrl = window.location.href;
        let links = document.querySelectorAll('a');
        let matchingLinks = Array.from(links).filter(link => link.href === fullUrl);

        matchingLinks.forEach(link => {
            link.classList.add('bg-gray-100');
            link.closest('.hs-accordion-content').classList.remove('hidden');
            link.closest('.hs-accordion').classList.add('active');
        });
    })
</script>
