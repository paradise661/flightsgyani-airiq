          <div class="detail-list">
              <div class="hidden md:block detail-wrap transition">
                  <div class="hs-accordion-group">
                      <div class="hs-accordion" id="hs-basic-no-arrow-heading-two">
                          <div class="grid grid-cols-12 px-4 gap-1">
                              <div class="col-span-7 flex flex-col gap-4">
                                  @foreach ($flight['detail'] as $detail)
                                      <div class="grid grid-cols-10">
                                          <div class="col-span-2">
                                              <div class="logo-sec">
                                                  <img class="hidden-xs"
                                                      src="{{ URL::asset('/frontend/air-logos/' . $detail['airline'] . '.png') }}"
                                                      alt="{{ $detail['airline'] }}">
                                                  <!-- <span class="title">{{ help_getAirlineFromCode($detail['airline'], false) }}</span>  -->
                                              </div>
                                          </div>
                                          <div class="col-span-8">
                                              <div class="airport-part">
                                                  <div class="airport-name min-w-fit">
                                                      <h4 class="city-name">
                                                          {{ $detail['origin'] }}
                                                      </h4>
                                                      <h4 class="date">
                                                          {{ \Carbon\Carbon::parse($detail['origindate'])->format('M d, D') }}
                                                      </h4>
                                                      <h3 class="time">
                                                          {{ \Carbon\Carbon::parse($detail['origintime'])->format('H:i') }}
                                                      </h3>
                                                  </div>
                                                  <div class="airport-progress">
                                                      <i class="fa-solid fa-circle text-secondary float-start"></i>
                                                      <i class="fa-solid fa-circle text-secondary float-end"></i>
                                                      <div class="stop-time">
                                                          {{ $detail['totaltime'] }}
                                                      </div>
                                                      <div class="stop">{{ $detail['stops'] }} Stop</div>
                                                  </div>
                                                  <div class="airport-name arrival min-w-fit">
                                                      <h4 class="city-name">
                                                          {{ $detail['destination'] }}
                                                      </h4>
                                                      <h4 class="date">
                                                          {{ \Carbon\Carbon::parse($detail['destinationdate'])->format('M d, D') }}
                                                      </h4>
                                                      <h3 class="time">
                                                          {{ \Carbon\Carbon::parse($detail['destinationtime'])->format('H:i') }}
                                                      </h3>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  @endforeach
                              </div>
                              <div class="col-span-3">
                                  <div class="price">
                                      <div class="items-center flex flex-col">
                                          {{-- <div class="flex items-center gap-1 mb-2 italic">
                                              <p class="text-sm font-medium text-gray-700">Cash Back: </p>
                                              <p class="text-sm font-semibold text-green-600"> Rs
                                                  2000
                                              </p>

                                          </div> --}}

                                          <h4 class="text-xl font-semibold">
                                              {{ help_getRoundAmount($flight['pricing']['markedfarewithoutdiscount']) }} /-
                                          </h4>
                                          {{-- @if ($flight['pricing']['discountAmount'] > 0)
                                              <s class="text-lg font-semibold" data-toggle="tooltip"
                                                  title="Cash Back: {{ help_getRoundAmount($flight['pricing']['discount']) }}">
                                                  {{ help_getRoundAmount($flight['pricing']['markedfarewithoutdiscount']) }}
                                                  /-
                                              </s>
                                          @else
                                              <span class="mb-1"></span>
                                          @endif --}}
                                          <div class="flex gap-2">
                                              <div>
                                                  @if ($detail['refundable'] == 'true')
                                                      <img class="img img-responsive" data-toggle="tooltip"
                                                          src="{{ asset('frontend/images/refundable.png') }}"
                                                          title="Refundable" alt="">
                                                  @else
                                                      <img class="img img-responsive" data-toggle="tooltip"
                                                          src="{{ asset('frontend/images/non-refundable.png') }}"
                                                          title="Non-Refundable" alt="">
                                                  @endif
                                                  </li>
                                              </div>
                                              <div>
                                                  <img class="img img-responsive" data-toggle="tooltip"
                                                      src="{{ asset('frontend/images/luggage.png') }}"
                                                      title="{{ $detail['bag'] }}" alt="">
                                              </div>
                                              <div>
                                                  <img class="img img-responsive" data-toggle="tooltip"
                                                      src="{{ asset('frontend/images/seat.png') }}" alt=""
                                                      title="{{ $detail['seat'] }} Seats Available">
                                              </div>
                                              </ul>
                                          </div>
                                          @if ($flight['pricing']['discountAmount'] > 0)
                                              <div class="flex items-center gap-1 mt-1">
                                                  <p class="text-xs font-medium text-gray-700">Cash Back: </p>
                                                  <p class="text-xs font-semibold text-green-600">
                                                      {{ help_getRoundAmount($flight['pricing']['discount']) }}
                                                  </p>
                                              </div>
                                          @endif
                                      </div>
                                  </div>
                              </div>
                              <div class="col-span-2 h-full flex flex-col justify-center ">
                                  <div class="book-flight">
                                      <form class="book-form" method="post" action="{{ route('flight.book') }}">
                                          @csrf
                                          <input type="hidden" name="flight" value="{{ encrypt($flight) }}">
                                          <button class="g-button-primary" type="submit">
                                              Book Now
                                          </button>
                                      </form>
                                  </div>
                                  <div class="flight-details">
                                      <!-- <button type="button">Flight Details</button> -->
                                      <button
                                          class="hs-accordion-toggle g-button-primary focus:outline-none focus:text-gray-500 rounded-lg disabled:opacity-50 disabled:pointer-events-none"
                                          aria-expanded="false" aria-controls="hs-basic-no-arrow-collapse-two">
                                          Flights Details
                                      </button>
                                  </div>
                              </div>
                          </div>
                          <div class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300 px-4 py-3"
                              id="hs-basic-no-arrow-collapse-two" role="region"
                              aria-labelledby="hs-basic-no-arrow-heading-two">
                              <div class="flex">
                                  <div class="flex bg-white rounded-sm transition py-1 px-2">
                                      <nav class="flex gap-x-1" aria-label="Tabs" role="tablist"
                                          aria-orientation="horizontal">
                                          <button
                                              class="hs-tab-active:bg-secondary hs-tab-active:text-white hs-tab-active: hs-tab-active: py-2 px-5 inline-flex items-center gap-x-2 bg-transparent text-base text-gray-500 font-medium tracking-widest hover:text-gray-700 focus:outline-none focus:text-gray-700 rounded-sm hover:hover:text-primary disabled:opacity-50 disabled:pointer-events-none active"
                                              id="segment-item-1"
                                              data-hs-tab="#detail-drop-flights-{{ $key }}" type="button"
                                              aria-selected="true"
                                              aria-controls="detail-drop-flights-{{ $key }}" role="tab">
                                              Flights
                                          </button>
                                          <button
                                              class="hs-tab-active:bg-secondary hs-tab-active:text-white hs-tab-active: hs-tab-active: py-2 px-5 inline-flex items-center gap-x-2 bg-transparent text-base text-gray-500 font-medium tracking-widest hover:text-gray-700 focus:outline-none focus:text-gray-700 rounded-sm hover:hover:text-primary disabled:opacity-50 disabled:pointer-events-none"
                                              id="segment-item-2"
                                              data-hs-tab="#detail-drop-pricing-{{ $key }}" type="button"
                                              aria-selected="false"
                                              aria-controls="detail-drop-pricing-{{ $key }}" role="tab">
                                              Pricing
                                          </button>
                                          <button
                                              class="hs-tab-active:bg-secondary hs-tab-active:text-white hs-tab-active: hs-tab-active: py-2 px-5 inline-flex items-center gap-x-2 bg-transparent text-base text-gray-500 font-medium tracking-widest hover:text-gray-700 focus:outline-none focus:text-gray-700 rounded-sm hover:hover:text-primary disabled:opacity-50 disabled:pointer-events-none"
                                              id="segment-item-3"
                                              data-hs-tab="#detail-drop-baggage-{{ $key }}" type="button"
                                              aria-selected="false"
                                              aria-controls="detail-drop-baggage-{{ $key }}" role="tab">
                                              Baggage
                                          </button>
                                          <button
                                              class="fare-rule hs-tab-active:bg-secondary hs-tab-active:text-white hs-tab-active: hs-tab-active: py-2 px-5 inline-flex items-center gap-x-2 bg-transparent text-base text-gray-500 font-medium tracking-widest hover:text-gray-700 focus:outline-none focus:text-gray-700 rounded-sm hover:hover:text-primary disabled:opacity-50 disabled:pointer-events-none"
                                              id="segment-item-3"
                                              data-hs-tab="#detail-drop-farerule-{{ $key }}" type="button"
                                              aria-selected="false"
                                              aria-controls="detail-drop-farerule-{{ $key }}"
                                              data="{{ $flight['rph'] }}" role="tab">
                                              Fare Rule
                                          </button>
                                      </nav>
                                  </div>
                              </div>
                              <div class="mt-2">
                                  <div id="detail-drop-flights-{{ $key }}" role="tabpanel"
                                      aria-labelledby="segment-item-1">
                                      <div class="detail-flights">
                                          @foreach ($flight['flight'] as $flightKey => $f)
                                              {{-- <div class="detail-flights-head">
                                                  <div class="flex items-center justify-center gap-3">
                                                      <i class="fa-solid fa-plane-departure text-white"></i>
                                                      <p class="place">{{ $flight['detail'][$flightKey]['origin'] }}
                                          </p>
                                          <i class="fa-solid fa-minus text-white"></i>

                                          <p class="place">
                                              {{ $flight['detail'][$flightKey]['destination'] }}
                                          </p>
                                          <i class="fa-solid fa-plane-arrival text-white"></i>
                                      </div>
                                  </div> --}}
                                              @foreach ($f['sectors'] as $k => $value)
                                                  <div class="detail-flights-body">
                                                      <div class="grid grid-cols-12 mb-6 pt-3">
                                                          <div class="col-span-2">
                                                              <div class="transit-flight">
                                                                  <div class="logo-sec">
                                                                      <img src="{{ URL::asset('/frontend/air-logos/' . $value['operatingairline'] . '.png') }}"
                                                                          alt="">
                                                                      <span
                                                                          class="title">{{ $value['operatingairline'] }}
                                                                          {{ $value['flightnumber'] }}</span>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                          <div class="col-span-10">
                                                              <div class="detail-airport-part">
                                                                  <div class="grid grid-cols-12">
                                                                      <div class="col-span-4 ">
                                                                          <h3
                                                                              class="text-2xl text-left font-semibold ">
                                                                              {{ \Carbon\Carbon::parse($value['departtime'])->format('H:i') }}
                                                                          </h3>
                                                                          <h4
                                                                              class="text-base uppercase font-semibold text-left text-gray-400 ">
                                                                              {{ $value['departure'] }},
                                                                              {{ $value['depterminal'] }}

                                                                          </h4>
                                                                          <h4
                                                                              class="text-sm font-medium text-gray-400 text-left ">
                                                                              {{ $value['departport'] }}
                                                                          </h4>
                                                                          <h4
                                                                              class="text-xs font-medium text-gray-400 text-left ">
                                                                              {{ \Carbon\Carbon::parse($value['departdate'])->format('M d, Y') }}
                                                                          </h4>
                                                                      </div>
                                                                      <div class="col-span-4">
                                                                          <div
                                                                              class="w-full h-full flex flex-col items-center justify-center">
                                                                              <div
                                                                                  class="detail-flight-duration pb-1 border-b-2 w-4/5 border-dashed border-primary text-center text-gray-600 font-medium relative">
                                                                                  {{ $value['elapstime'] }}
                                                                              </div>
                                                                              <div
                                                                                  class="detail-flight-class text-center w-4/5 pt-1 text-gray-400 font-medium">
                                                                                  {{ $value['class'] }}
                                                                              </div>
                                                                          </div>
                                                                      </div>
                                                                      <div class="col-span-4">

                                                                          <h3
                                                                              class="text-2xl text-right font-semibold">
                                                                              {{ \Carbon\Carbon::parse($value['arrivaltime'])->format('H:i') }}
                                                                          </h3>
                                                                          <h4
                                                                              class="text-base uppercase font-semibold text-right text-gray-400">
                                                                              {{ $value['arrival'] }},
                                                                              {{ $value['arrivalterminal'] }}
                                                                          </h4>
                                                                          <h4
                                                                              class="text-sm font-medium text-gray-400 text-right">
                                                                              {{ $value['arrivalport'] }}
                                                                          </h4>
                                                                          <h4
                                                                              class="text-xs font-medium text-gray-400 text-right">
                                                                              {{ \Carbon\Carbon::parse($value['arrivaldate'])->format('M d, Y') }}
                                                                          </h4>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                      </div>
                                                      <div class="relative items-center justify-center">
                                                          @if (array_key_exists($loop->iteration, $f['sectors']))
                                                              <button
                                                                  class="bg-red-500 text-white p-2 px-8 rounded-full absolute flex top-[50%] left-[50%]"
                                                                  style="transform: translate(-25%, -50%)">
                                                                  Connection Time:
                                                                  {{ \App\Service\Sabre\SabreBasic::generateFlightTime(\Carbon\Carbon::parse($f['sectors'][$loop->iteration - 1]['arrivaldate'] . ' ' . $f['sectors'][$loop->iteration - 1]['arrivaltime'])->diffInRealMinutes(\Carbon\Carbon::parse($f['sectors'][$loop->iteration]['departdate'] . ' ' . $f['sectors'][$loop->iteration]['departtime']))) }}</span>
                                                              </button>
                                                              <hr class="my-4 " />
                                                          @endif
                                                      </div>

                                                  </div>
                                              @endforeach

                                              @if (!$loop->last)
                                                  <hr class="border-2 border-green-600" />
                                              @endif
                                          @endforeach
                                      </div>
                                  </div>
                                  <div class="hidden" id="detail-drop-pricing-{{ $key }}" role="tabpanel"
                                      aria-labelledby="segment-item-3">
                                      <div class="flights-drop-table">
                                          <div class="flex flex-col">
                                              <div class="-m-1.5 overflow-x-auto">
                                                  <div class="p-1.5 min-w-full inline-block align-middle">
                                                      <div class="border rounded-lg overflow-hidden">
                                                          <table class="min-w-full divide-y divide-gray-200">
                                                              <thead>
                                                                  <tr>
                                                                      <th scope="col">Price Title</th>
                                                                      <th scope="col">Price</th>
                                                                  </tr>
                                                              </thead>
                                                              <tbody class="divide-y divide-gray-200">
                                                                  <tr>
                                                                      <td
                                                                          class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                                          Type
                                                                      </td>
                                                                      <td
                                                                          class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                          @foreach ($flight['breakdown'] as $breakdown)
                                                                              {{ $breakdown['type'] }} *
                                                                              {{ $breakdown['qty'] }}
                                                                          @endforeach
                                                                      </td>
                                                                  </tr>
                                                                  <tr>
                                                                      <td
                                                                          class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                                          Base Fare (Per Person)
                                                                      </td>
                                                                      <td
                                                                          class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                          @foreach ($flight['breakdown'] as $breakdown)
                                                                              {{ $breakdown['mbasefare'] }} *
                                                                              {{ $breakdown['qty'] }}
                                                                          @endforeach
                                                                      </td>
                                                                  </tr>
                                                                  <tr>
                                                                      <td
                                                                          class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                                          TAX
                                                                      </td>
                                                                      <td
                                                                          class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                          @foreach ($flight['breakdown'] as $breakdown)
                                                                              {{ $breakdown['tax'] }} *
                                                                              {{ $breakdown['qty'] }}
                                                                          @endforeach
                                                                      </td>
                                                                  </tr>
                                                                  <tr>
                                                                      <td
                                                                          class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                                          Total
                                                                      </td>
                                                                      <td
                                                                          class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                          {{ $flight['pricing']['markedfare'] }}
                                                                      </td>
                                                                  </tr>
                                                              </tbody>
                                                          </table>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="hidden" id="detail-drop-baggage-{{ $key }}" role="tabpanel"
                                      aria-labelledby="segment-item-4">
                                      <div class="flights-drop-table">
                                          <div class="flex flex-col">
                                              <div class="-m-1.5 overflow-x-auto">
                                                  <div class="p-1.5 min-w-full inline-block align-middle">
                                                      <div class="border rounded-lg overflow-hidden">
                                                          <table class="min-w-full divide-y divide-gray-200">
                                                              <thead>
                                                                  <tr>
                                                                      <th scope="col">PAX</th>
                                                                      <th scope="col">Checking Bags</th>
                                                                      <th scope="col">Hand Carry Bags</th>
                                                                  </tr>
                                                              </thead>
                                                              <tbody class="divide-y divide-gray-200">
                                                                  @foreach ($flight['baggage'] as $baggage)
                                                                      <tr>
                                                                          <td
                                                                              class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                                              {{ $baggage['pax'] }} </td>
                                                                          <td
                                                                              class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                                              {{ $baggage['unit'] }}
                                                                              {{ $baggage['type'] }}
                                                                              {{ $baggage['description'] }}
                                                                          </td>
                                                                          <td
                                                                              class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                              7 kg
                                                                          </td>
                                                                      </tr>
                                                                  @endforeach

                                                              </tbody>
                                                          </table>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="hidden" id="detail-drop-farerule-{{ $key }}" role="tabpanel"
                                      aria-labelledby="segment-item-4">
                                      <div class="p-4 bg-white rounded">
                                          <div class="fare-rule{{ $flight['rph'] }} max-h-[250px] overflow-y-auto overflow-x-hidden capitalize"
                                              style="word-wrap: break-word;">
                                              Rule
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
