<!-- Footer -->
<footer>
    @php
        $site = getSite();
    @endphp
    <!-- Footer  -->
    <footer class="footer bg-primary pt-8 pb-4" style="margin-top: 0 !important;">
        <div class="container mx-auto">
            <div class="grid grid-cols-12 gap-8 px-4 md:px-0">
                <div class="col-span-12 md:col-span-3">
                    <div class="flex gap-3">

                        <!-- <a class="flex-none font-semibold text-xl text-black focus:outline-none focus:opacity-80" href="/" aria-label="Brand">
                            <img src="{{ isset($site->primary_logo) ? $site->logo : asset('frontend/images/logo.png') }}" alt="logo" width="110px" height="60px"/>
                        </a> -->
                        <a class="flex-none font-semibold text-xl text-black focus:outline-none focus:opacity-80"
                            href="/" aria-label="Brand">
                            <img class="max-h-[60px]"
                                src="{{ isset($site->secondary_logo) ? asset('uploads/site/' . $site->secondary_logo) : asset('frontend/images/footer_logo.png') }}"
                                alt="logo" width="250px" height="60px" />
                        </a>
                    </div>
                    <p class="text-gray-300 mt-3 leading-5 font-medium text-sm">
                        Flights Gyani Pvt Ltd is Nepal's trusted online travel company, offering licensed, reliable
                        services for flights, hotels, and holiday packages. We simplify travel planning with
                        user-friendly solutions for both domestic and international travelers.
                    </p>
                    <div class="social flex items-center gap-4 mt-3">
                        <a href="{{ $site->linkedin_link ?? '' }}" target="_blank">
                            <svg width="16px" height="16px" viewBox="0 0 20 20" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                fill="#ffffff">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <title>linkedin [#fffffffffff]</title>
                                    <desc>Created with Sketch.</desc>
                                    <defs></defs>
                                    <g id="Page-1" stroke="none" stroke-width="1" fill="none"
                                        fill-rule="evenodd">
                                        <g id="Dribbble-Light-Preview" transform="translate(-180.000000, -7479.000000)"
                                            fill="#ffffff">
                                            <g id="icons" transform="translate(56.000000, 160.000000)">
                                                <path id="linkedin-[#fffffffffff]"
                                                    d="M144,7339 L140,7339 L140,7332.001 C140,7330.081 139.153,7329.01 137.634,7329.01 C135.981,7329.01 135,7330.126 135,7332.001 L135,7339 L131,7339 L131,7326 L135,7326 L135,7327.462 C135,7327.462 136.255,7325.26 139.083,7325.26 C141.912,7325.26 144,7326.986 144,7330.558 L144,7339 L144,7339 Z M126.442,7323.921 C125.093,7323.921 124,7322.819 124,7321.46 C124,7320.102 125.093,7319 126.442,7319 C127.79,7319 128.883,7320.102 128.883,7321.46 C128.884,7322.819 127.79,7323.921 126.442,7323.921 L126.442,7323.921 Z M124,7339 L129,7339 L129,7326 L124,7326 L124,7339 Z">
                                                </path>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </a>

                        <a href="{{ $site->facebook_link ?? '' }}" target="_blank">
                            <svg width="16px" height="16px" viewBox="-5 0 20 20" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                fill="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <title>facebook [#fffffffffff]</title>
                                    <desc>Created with Sketch.</desc>
                                    <defs></defs>
                                    <g id="Page-1" stroke="none" stroke-width="1" fill="none"
                                        fill-rule="evenodd">
                                        <g id="Dribbble-Light-Preview" transform="translate(-385.000000, -7399.000000)"
                                            fill="#ffffff">
                                            <g id="icons" transform="translate(56.000000, 160.000000)">
                                                <path id="facebook-[#fffffffffff]"
                                                    d="M335.821282,7259 L335.821282,7250 L338.553693,7250 L339,7246 L335.821282,7246 L335.821282,7244.052 C335.821282,7243.022 335.847593,7242 337.286884,7242 L338.744689,7242 L338.744689,7239.14 C338.744689,7239.097 337.492497,7239 336.225687,7239 C333.580004,7239 331.923407,7240.657 331.923407,7243.7 L331.923407,7246 L329,7246 L329,7250 L331.923407,7250 L331.923407,7259 L335.821282,7259 Z">
                                                </path>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </a>

                        <a href="{{ $site->instagram_link ?? '' }}" target="_blank">
                            <svg width="16px" height="16px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M7.75 2C4.76 2 2.5 4.26 2.5 7.25v9.5c0 2.99 2.26 5.25 5.25 5.25h9.5c2.99 0 5.25-2.26 5.25-5.25V7.25C22 4.26 19.74 2 16.75 2h-9.5zM12 17.25c-2.85 0-5.25-2.4-5.25-5.25S9.15 6.75 12 6.75s5.25 2.4 5.25 5.25S14.85 17.25 12 17.25zm5.65-9.95c0 .4-.32.72-.72.72-.4 0-.72-.32-.72-.72s.32-.72.72-.72c.4 0 .72.32.72.72z" />
                            </svg>
                        </a>

                        <a href="{{ $site->twitter_link ?? '' }}" target="_blank">
                            <svg width="16px" height="16px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M23 3c-1.092.487-2.268.773-3.5.914C19.51 3.11 18.285 2 16.9 2c-2.685 0-4.872 2.157-4.872 4.828 0 .38.042.752.12 1.105-4.073-.202-7.691-2.134-10.14-5.148a4.759 4.759 0 0 0-.658 2.429c0 1.68.864 3.163 2.158 4.037a4.856 4.856 0 0 1-2.21-.62c-.054 1.853 1.293 3.592 3.197 3.986a4.907 4.907 0 0 1-2.115.084c.595 1.879 2.34 3.238 4.426 3.274-1.613 1.261-3.651 1.801-5.735 1.51 2.053 1.312 4.502 2.067 7.002 2.067 8.5 0 13.428-7.03 13.428-13.137 0-.2 0-.398-.02-.596A9.51 9.51 0 0 0 24 4.78a9.65 9.65 0 0 1-2.908.798 4.835 4.835 0 0 0 2.193-2.68z" />
                            </svg>
                        </a>

                    </div>
                </div>
                <div class="col-span-12 md:col-span-6">
                    <div class="grid grid-cols-3">
                        <div class="md:ps-16">
                            <h4 class="font-semibold text-xl text-white tracking-wider">
                                Useful Links
                            </h4>
                            <div class="footer-links">
                                <a href="{{ route('frontend.index') }}">Home</a>
                                <a href="{{ route('frontend.about') }}">About</a>
                                <a href="{{ route('frontend.contact') }}">Contact</a>
                                <a href="{{ route('frontend.blog') }}">Blogs</a>
                                <a href="{{ route('terms.conditions') }}">Terms & Conditions</a>
                                <a href="{{ route('findyourticket') }}">Find your ticket</a>
                            </div>
                        </div>
                        <div class="md:ps-16 col-span-2">
                            <h4 class="font-semibold text-xl text-white tracking-wider">
                                Contact Us
                            </h4>

                            <div class="mt-3 flex flex-col gap-3 border-gray-600 pb-3">
                                <div class="location flex items-center gap-4 text-white text-sm">
                                    <i class="fa-solid fa-location-dot"></i>
                                    Lazimpat Opposite to British Embassy, Kathmandu
                                </div>
                                <a class="phone flex items-center gap-4 text-white text-sm" href="tel:01-4547791">
                                    <i class="fa-solid fa-square-phone"></i>
                                    01-4547791/9802368063/9860146706
                                </a>
                                <a class="email flex items-center gap-4 text-white text-sm"
                                    href="mailto:info@flightsgyani.com">
                                    <i class="fa-solid fa-envelope"></i>
                                    info@flightsgyani.com
                                </a>
                            </div>
                            <div class="mt-3 flex flex-col gap-3 pb-3">
                                <div class="location flex items-center gap-4 text-white text-sm">
                                    <i class="fa-solid fa-location-dot"></i>
                                    Milan Chowk - Butwal, Nepal
                                </div>
                                <a class="phone flex items-center gap-4 text-white text-sm" href="tel: 071-591346">
                                    <i class="fa-solid fa-square-phone"></i>
                                    071-591346/+9779857053346
                                </a>
                                <a class="email flex items-center gap-4 text-white text-sm"
                                    href="mailto: padam.karki@flightsgyani.com">
                                    <i class="fa-solid fa-envelope"></i>
                                    padam.karki@flightsgyani.com
                                </a>
                            </div>
                            <div class="mt-3 flex flex-col gap-3">
                                <div class="location flex items-center gap-4 text-white text-sm">
                                    <i class="fa-solid fa-location-dot"></i>
                                    BP Chowk - Nepalgunj, Nepal
                                </div>
                                <a class="phone flex items-center gap-4 text-white text-sm" href="tel: 081-590577">
                                    <i class="fa-solid fa-square-phone"></i>
                                    081-590577/+9779802349242
                                </a>
                                <a class="email flex items-center gap-4 text-white text-sm"
                                    href="mailto: rooma@flightsgyani.com">
                                    <i class="fa-solid fa-envelope"></i>
                                    rooma@flightsgyani.com
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-3 hidden md:block">
                    <h4 class="font-semibold text-xl text-white tracking-wider">
                        Payment Partners
                    </h4>
                    {{-- <img class="max-h-[100px] rounded-md mt-2"
                        src="{{ $site->payment_partners_image ? asset('uploads/site/' . $site->payment_partners_image) : asset('frontend/images/footer-payment.jpg') }}"
                        alt="" width="100%" /> --}}
                    <h4 class="font-semibold text-xl text-white tracking-wider mt-4">
                        Affiliated Partners
                    </h4>
                    {{-- <img class="max-h-[100px] rounded-md mt-2"
                        src="{{ $site->affiliated_partners_image ? asset('uploads/site/' . $site->affiliated_partners_image) : asset('frontend/images/footer-affiliate.jpg') }}"
                        alt="" width="100%" /> --}}

                </div>
            </div>
        </div>

        <div class="border-t border-gray-500 mt-4 pt-4">
            <div class="flex items-center gap-5 justify-center">
                <!-- <a class="text-gray-300" href="">Terms</a>
                <a class="text-gray-300" href="">Privacy</a>
                <a class="text-gray-300" href="">Cookies</a> -->
                <p class="text-gray-200">Designed By <a href="https://paradiseit.com.np/" target="_blank"> Paradise
                        IT Solution Pvt.
                        Ltd.</a></p>
            </div>
        </div>
    </footer>

    <a class="fixed z-[999] bottom-[40px] right-[40px] bg-primary rounded-md" href="{{ $site->whatsapplink ?? '#' }}"
        target="_blank">
        <img src="{{ asset('frontend/images/whatsapp.png') }}" alt="" width="50px" height="50px">
    </a>
