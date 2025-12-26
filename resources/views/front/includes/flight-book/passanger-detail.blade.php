                    <div
                        class="rounded-lg border border-gray-300 px-4 py-3 md:px-6 md:py-6 bg-white mb-2 {{ $type }}-form">
                        <h3 class="text-2xl font-semibold">Passenger {{ $idx }}. {{ ucwords($type) }} </h3>
                        <!-- Form Layout  -->
                        <div class="form-layout grid grid-cols-1 md:grid-cols-3 gap-4 mt-4 md:mt-8">
                            <div class="w-full grid grid-cols-1 md:grid-cols-2 md:col-span-3 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold mb-2">First Name <span
                                            class="text-red-600">*</span></label>
                                    <div class="flex items-center gap-1 relative">
                                        <select
                                            class="passanger-title block w-full border-transparent rounded-lg focus:ring-primary-lighter focus:border-primary"
                                            class="hidden"
                                            data-hs-select='{"value": "{{ old("{$inputName}title.$i") }}", "placeholder": "Mr.", "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>", "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500","dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300", "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50","optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 \" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>", "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"}'
                                            name="{{ $inputName }}title[{{ $i }}]">
                                            <option value="Mr." selected>Mr.&nbsp;</option>
                                            <option value="Mrs.">Mrs.</option>
                                            <option value="Ms.">Ms.&nbsp;</option>
                                        </select>
                                        <div class="flex flex-col w-full">
                                            <input
                                                class="@error("{$inputName}firstname.$i") border-red-600 @enderror py-3 px-4 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                                data-index="{{ $i }}"
                                                value='{{ old("{$inputName}firstname.$i") }}' type="text"
                                                name="{{ $inputName }}firstname[{{ $i }}]"
                                                placeholder="First Name" />
                                        </div>
                                    </div>
                                    @error("{$inputName}firstname.$i")
                                        <span class="text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold mb-2" for="lname">Last Name <span
                                            class="text-red-600">*</span></label>
                                    <input
                                        class="@error("{$inputName}lastname.$i") border-red-600 @enderror py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                        type="text" value="{{ old("{$inputName}lastname.$i") }}"
                                        name="{{ $inputName }}lastname[{{ $i }}]"
                                        placeholder="Last Name" />
                                    @error("{$inputName}lastname.$i")
                                        <span class="text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full">
                                <label class="block text-sm font-semibold mb-2">Date of Birth <span
                                        class="text-red-600">*</span></label>
                                <input
                                    class="@error("{$inputName}dob.$i") border-red-600 @enderror {{ $inputName }}-dob py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                    type="text" value="{{ old("{$inputName}dob.$i") }}"
                                    name="{{ $inputName }}dob[{{ $i }}]" placeholder="dob"
                                    autocomplete="off" readonly />
                                @error("{$inputName}dob.$i")
                                    <span class="text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="block text-sm font-semibold mb-2">Nationality <span
                                        class="text-red-600">*</span></label>
                                <!-- Select -->
                                <select
                                    class="hidden {{ session()->get('flight_origin') == 'KTM' && session()->get('flight_nationality') == 'NP' && $type != 'infant' ? 'nationality_check' : '' }} "
                                    data-hs-select='{"hasSearch": true, "value": "{{ old("{$inputName}nation.$i") ?: $search->nationality }}", "placeholder": "Select Country...","toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>","toggleClasses": "{{ $errors->has($inputName . 'nation.' . $i) ? 'border-red-600 ' : '' }}hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500","dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300","optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50",   "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 \" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",    "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"}'
                                    name="{{ $inputName }}nation[{{ $i }}]"
                                    value="{{ old("{$inputName}nation.$i") ?: $search->nationality }}">
                                    <option value="">Choose</option>
                                    @php
                                        $countries = collect(listCountries());
                                        $countries = $countries->prepend('Nepal', 'NP');
                                    @endphp
                                    @foreach ($countries as $countryCode => $countryName)
                                        <option value="{{ $countryCode }}"
                                            {{ old("{$inputName}nation.$i") ? (old("{$inputName}nation.$i") === $countryCode ? 'selected' : null) : ($search->nationality === $countryCode ? 'selected' : null) }}>
                                            {{ $countryName }}</option>
                                    @endforeach
                                </select>
                                <!-- End Select -->
                                @error("{$inputName}nation.$i")
                                    <span class="text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="block text-sm font-semibold mb-2" for="dnum">
                                    Document Type
                                    <span class="text-red-600">*</span></label>
                                <input
                                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                    type="text" name="{{ $inputName }}doctype[]" placeholder="Document Type"
                                    value="Passport" readonly />
                            </div>
                            <div class="w-full">
                                <label class="block text-sm font-semibold mb-2" for="dnum">
                                    Passport Number
                                    <span class="text-red-600">*</span></label>
                                <input
                                    class="@error("{$inputName}passport.$i") border-red-600 @enderror py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                    type="text" value='{{ old("{$inputName}passport.$i") }}'
                                    name="{{ $inputName }}passport[{{ $i }}]"
                                    placeholder="Enter number here" />
                                @error("{$inputName}passport.$i")
                                    <span class="text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="block text-sm font-semibold mb-2" for="expdate">Expiration Date <span
                                        class="text-red-600">*</span></label>
                                <input
                                    class="@error("{$inputName}passportexpiry.$i") border-red-600 @enderror passport py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                    type="text" value='{{ old("{$inputName}passportexpiry.$i") }}'
                                    name="{{ $inputName }}passportexpiry[{{ $i }}]"
                                    placeholder="Expiry Date" autocomplete="off" readonly />
                                @error("{$inputName}passportexpiry.$i")
                                    <span class="text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="w-full">
                                <label class="block text-sm font-semibold mb-2" for="pcitizenship">Issued Country <span
                                        class="text-red-600">*</span></label>
                                <!-- Select -->
                                <select class="hidden"
                                    data-hs-select='{"hasSearch": true,"value": "{{ old("{$inputName}passportcountry.$i") ?: $search->nationality }}", "placeholder": "Select Country...","toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>","toggleClasses": "{{ $errors->has($inputName . 'passportcountry.' . $i) ? 'border-red-600 ' : '' }}hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500","dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300","optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50",   "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 \" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",    "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"}'
                                    name="{{ $inputName }}passportcountry[{{ $i }}]">
                                    <option value="">Choose</option>
                                    @foreach (listCountries() as $countryCode => $countryName)
                                        <option value="{{ $countryCode }}"
                                            {{ old("{$inputName}passportcountry.$i") ? (old("{$inputName}passportcountry.$i") === $countryCode ? 'selected' : null) : ($search->nationality === $countryCode ? 'selected' : null) }}>
                                            {{ $countryName }}</option>
                                    @endforeach
                                </select>
                                <!-- End Select -->
                                @error("{$inputName}passportcountry.$i")
                                    <span class="text-red-600">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                        <!-- / Form Layout  -->
                    </div>
