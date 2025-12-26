<header
    class="sticky top-0 inset-x-0 flex flex-wrap md:justify-start md:flex-nowrap z-[48] w-full bg-white border-b text-sm py-2.5 lg:ps-[260px] dark:bg-neutral-800 dark:border-neutral-700">
    <nav class="px-4 sm:px-6 flex basis-full items-center w-full mx-auto">
        <div class="me-5 lg:me-0 lg:hidden">
            <!-- Logo -->
            <a class="flex-none rounded-md text-xl inline-block font-semibold focus:outline-none focus:opacity-80"
                href="#" aria-label="Preline">
                <img src="{{ asset('frontend/images/logo.png') }}" width="100" height="60" alt="" />
            </a>
            <!-- End Logo -->
        </div>

        <div class="w-full flex items-center justify-between ms-auto gap-x-6">
            <div class="md:flex dark:bg-neutral-800 rounded-lg items-center space-x-6">
                @if (Auth::user()->user_type == 'AGENT')
                    <!-- Remaining Balance -->
                    <div class="flex items-center text-sm font-medium text-gray-700 dark:text-neutral-300">
                        <svg class="w-5 h-5 text-green-600 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 0v12h8V4H6z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>Remaining Balance:</span>
                        <span class="text-green-600 font-semibold ml-2">NPR
                            {{ remainingBalance(Auth::user()->id, 'NPR') }}</span>
                    </div>

                    <!-- Due Amount -->
                    <div class="flex items-center text-sm font-medium text-gray-700 dark:text-neutral-300">
                        <svg class="w-5 h-5 text-red-600 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M9 2a1 1 0 011 1v12a1 1 0 01-2 0V3a1 1 0 011-1zM5 6a1 1 0 011 1v6a1 1 0 01-2 0V7a1 1 0 011-1zM13 6a1 1 0 011 1v6a1 1 0 01-2 0V7a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>Due Amount:</span>
                        <span class="text-red-600 font-semibold ml-2">NPR
                            {{ paymentRecord(Auth::user()->id)->due ?? 0 }}</span>
                    </div>

                    <!-- Paid Amount -->
                    <div class="flex items-center text-sm font-medium text-gray-700 dark:text-neutral-300">
                        <svg class="w-5 h-5 text-blue-600 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd" d="M17 9a2 2 0 01-2 2H5a2 2 0 010-4h10a2 2 0 012 2z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>Paid Amount:</span>
                        <span class="text-blue-600 font-semibold ml-2">NPR
                            {{ paymentRecord(Auth::user()->id)->paid ?? 0 }}</span>
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-1">
                @if (Auth::user()->hasAnyRole('SUPER-ADMIN'))
                    <a class="bg-none text-sm text-gray-800 hover:text-gray-600 dark:text-white dark:hover:text-gray-400"
                        href="{{ route('admin.dashboard') }}">
                        Switch to old version
                    </a>
                @endif

                <div class="hs-dropdown relative inline-flex">
                    <button
                        class="size-[38px] inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 focus:outline-none disabled:opacity-50 disabled:pointer-events-none dark:text-white"
                        id="hs-dropdown-account" type="button" aria-haspopup="menu" aria-expanded="false"
                        aria-label="Dropdown">
                        <svg class="text-green-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <!-- Outer Border Circle -->
                            <circle cx="12" cy="12" r="11" stroke="currentColor" stroke-width="2"
                                fill="none" />
                            <!-- Head of the user -->
                            <circle cx="12" cy="7" r="4" fill="currentColor" />
                            <!-- Body of the user -->
                            <path d="M5 21c0-4 4-5 7-5s7 1 7 5" />
                        </svg>
                    </button>

                    <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-60 bg-white shadow-md rounded-lg mt-2 dark:bg-neutral-800 dark:border dark:border-neutral-700 dark:divide-neutral-700 after:h-4 after:absolute after:-bottom-4 after:start-0 after:w-full before:h-4 before:absolute before:-top-4 before:start-0 before:w-full"
                        role="menu" aria-orientation="vertical" aria-labelledby="hs-dropdown-account">
                        <div class="py-3 px-5 bg-gray-100 rounded-t-lg dark:bg-neutral-700">
                            <p class="text-sm text-gray-500 dark:text-neutral-500">Signed in as</p>
                            <p class="text-sm font-medium text-green-600 dark:text-neutral-200">
                                {{ Auth::user()->email ?? '' }}</p>
                        </div>
                        <div class="p-1.5 space-y-0.5">
                            <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300"
                                href="{{ route('v2.admin.change.password') }}">
                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <!-- Lock Icon -->
                                    <path d="M17 11V7a5 5 0 0 0-10 0v4" />
                                    <path d="M12 16v2" />
                                    <path d="M9 18h6" />
                                    <!-- Pen Icon for Changing -->
                                    <path d="M14 2l4 4" />
                                    <path d="M14 6l4-4" />
                                </svg>
                                Change Password
                            </a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button
                                    class="w-full flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M13 17l5-5-5-5" />
                                        <path d="M7 12H18" />
                                        <path d="M13 5H3v14h10" />
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </nav>
</header>
