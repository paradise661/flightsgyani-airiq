          <div class="detail-list">
              <div class="hidden md:block detail-wrap transition">
                  <div class="hs-accordion-group">
                    <div class="hs-accordion mb-5" id="hs-basic-no-arrow-heading-two">
                        <!-- MAIN CARD -->
                        <div class="grid grid-cols-12 gap-5 bg-white rounded-2xl p-3 transition">
                            <!-- FLIGHT SUMMARY -->
                            <div class="col-span-7 space-y-5">
                                @foreach ($flight['detail'] as $detail)
                                    <div class="flex gap-5">
                                        <!-- Airline -->
                                        <div class="flex flex-col items-center">
                                            <div class="w-14 h-14 flex items-center justify-center bg-gray-100 rounded-xl">
                                                <img src="{{ asset('/frontend/air-logos/' . $detail['airline'] . '.png') }}"
                                                     class="w-10 object-contain">
                                            </div>
                                            <div class="h-full w-px border-l border-dashed border-gray-300 my-2"></div>
                                        </div>
                                        <!-- Route -->
                                        <div class="flex-1 space-y-3">
                                            <!-- Origin -->
                                            <div>
                                                <h4 class="text-lg font-semibold text-gray-800">
                                                    {{ $detail['origin'] }}
                                                </h4>
                                                <p class="text-sm text-gray-500">
                                                    {{ \Carbon\Carbon::parse($detail['origindate'])->format('M d, D') }} •
                                                    {{ \Carbon\Carbon::parse($detail['origintime'])->format('H:i') }}
                                                </p>
                                            </div>
                                            <!-- Duration -->
                                            <div class="flex items-center gap-3 text-sm">
                                                <span class="px-3 py-1 rounded-full bg-gray-100 font-medium text-gray-700">
                                                    {{ $detail['totaltime'] }}
                                                </span>
                                                <span class="px-3 py-1 rounded-full bg-secondary/10 text-secondary text-xs font-medium">
                                                    {{ $detail['stops'] }} Stop
                                                </span>
                                            </div>
                                            <!-- Destination -->
                                            <div>
                                                <h4 class="text-lg font-semibold text-gray-800">
                                                    {{ $detail['destination'] }}
                                                </h4>
                                                <p class="text-sm text-gray-500">
                                                    {{ \Carbon\Carbon::parse($detail['destinationdate'])->format('M d, D') }} •
                                                    {{ \Carbon\Carbon::parse($detail['destinationtime'])->format('H:i') }}
                                                </p>
                                            </div>
                    
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- PRICE -->
                            <div class="col-span-3 flex flex-col items-center justify-center border-l border-dashed px-5">
                                <h4 class="text-2xl font-bold text-secondary">
                                    {{ help_getRoundAmount($flight['pricing']['markedfarewithoutdiscount']) }}
                                    <span class="text-sm font-medium text-gray-500">NPR</span>
                                </h4>
                                <div class="flex gap-4 mt-4">
                                    <img class="w-6" src="{{ asset($detail['refundable'] == 'true'
                                        ? 'frontend/images/refundable.png'
                                        : 'frontend/images/non-refundable.png') }}">
                                    <img class="w-6" src="{{ asset('frontend/images/luggage.png') }}">
                                    <img class="w-6" src="{{ asset('frontend/images/seat.png') }}">
                                </div>
                                @if ($flight['pricing']['discountAmount'] > 0)
                                    <p class="mt-3 text-xs font-semibold text-green-600">
                                        Cashback: {{ help_getRoundAmount($flight['pricing']['discount']) }}
                                    </p>
                                @endif
                            </div>
                            <!-- ACTIONS -->
                            <div class="col-span-2 flex flex-col justify-center gap-3">
                                <form method="post" action="{{ route('flight.book') }}">
                                    @csrf
                                    <input type="hidden" name="flight" value="{{ encrypt($flight) }}">
                                    <button class="w-full py-3 rounded-xl bg-primary text-white font-semibold hover:opacity-90 transition">
                                        Book Now
                                    </button>
                                </form>
                    
                                <button
                                    class="hs-accordion-toggle w-full py-3 rounded-xl border border-primary text-primary font-medium hover:bg-secondary hover:text-white transition"
                                    aria-expanded="false">
                                    View Details
                                </button>
                    
                            </div>
                        </div>  
                        <!-- DETAILS -->
                        <div class="hs-accordion-content hidden overflow-hidden transition-[height] duration-300 mt-3">
                            <!-- TABS -->
                            <div class="bg-white rounded-xl p-4">
                                <nav class="flex gap-2 bg-gray-100 p-2 rounded-xl w-fit">
                                    <button class="hs-tab-active:bg-secondary hs-tab-active:text-white px-5 py-2 rounded-lg text-sm font-medium"
                                            data-hs-tab="#detail-drop-flights-{{ $key }}">
                                        Flights
                                    </button>
                                    <button class="hs-tab-active:bg-secondary hs-tab-active:text-white px-5 py-2 rounded-lg text-sm font-medium"
                                            data-hs-tab="#detail-drop-pricing-{{ $key }}">
                                        Pricing
                                    </button>
                                    <button class="hs-tab-active:bg-secondary hs-tab-active:text-white px-5 py-2 rounded-lg text-sm font-medium"
                                            data-hs-tab="#detail-drop-baggage-{{ $key }}">
                                        Baggage
                                    </button>
                                    <button class="hs-tab-active:bg-secondary hs-tab-active:text-white px-5 py-2 rounded-lg text-sm font-medium"
                                            data-hs-tab="#detail-drop-farerule-{{ $key }}">
                                        Fare Rule
                                    </button>
                                </nav>
                    
                                <!-- FLIGHTS DETAIL -->
                                <div id="detail-drop-flights-{{ $key }}" class="mt-5">
                                    @foreach ($flight['flight'] as $f)
                                        @foreach ($f['sectors'] as $value)
                                            <div class="bg-gray-50 rounded-xl p-4 mb-4">
                                                <div class="grid grid-cols-12 gap-4 items-center">
                    
                                                    <div class="col-span-2 flex items-center gap-2">
                                                        <img class="w-10"
                                                             src="{{ asset('/frontend/air-logos/' . $value['operatingairline'] . '.png') }}">
                                                        <span class="text-sm font-medium">
                                                            {{ $value['operatingairline'] }} {{ $value['flightnumber'] }}
                                                        </span>
                                                    </div>
                    
                                                    <div class="col-span-4">
                                                        <h3 class="text-xl font-semibold">
                                                            {{ \Carbon\Carbon::parse($value['departtime'])->format('H:i') }}
                                                        </h3>
                                                        <p class="text-sm text-gray-500">
                                                            {{ $value['departure'] }} • {{ $value['depterminal'] }}
                                                        </p>
                                                    </div>
                    
                                                    <div class="col-span-2 text-center">
                                                        <p class="text-sm font-medium text-gray-600">
                                                            {{ $value['elapstime'] }}
                                                        </p>
                                                        <p class="text-xs text-gray-400">{{ $value['class'] }}</p>
                                                    </div>
                    
                                                    <div class="col-span-4 text-right">
                                                        <h3 class="text-xl font-semibold">
                                                            {{ \Carbon\Carbon::parse($value['arrivaltime'])->format('H:i') }}
                                                        </h3>
                                                        <p class="text-sm text-gray-500">
                                                            {{ $value['arrival'] }} • {{ $value['arrivalterminal'] }}
                                                        </p>
                                                    </div>
                    
                                                </div>
                                            </div>
                                        @endforeach
                                    @endforeach
                                </div>
                    
                            </div>
                        </div>
                    </div>                  
                  </div>
              </div>
          </div>
