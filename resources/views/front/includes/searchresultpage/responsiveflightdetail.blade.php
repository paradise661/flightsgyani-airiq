          <div class="block md:hidden result-card">
              <div class="bg-primary-background">
                  <div class="flex justify-between items-center">
                      <div class="airline flex items-center gap-2">
                          <div class="w-16                                                    ">
                              <img src="{{ URL::asset('/frontend/air-logos/' . $flight['detail'][0]['airline'] . '.png') }}"
                                  alt="">
                          </div>
                          <!-- <h6 class="text-base font-medium text-gray-600">
                              {{ help_getAirlineFromCode($flight['detail'][0]['airline'], false) }}
                          </h6> -->
                      </div>
                      <div>
                          <h4 class="text-xl font-semibold leading-5 text-primary">
                              {{ help_getRoundAmount($flight['pricing']['markedfarewithoutdiscount']) }} /-
                          </h4>
                          @if ($flight['pricing']['discountAmount'] > 0)
                              <div class="flex items-center gap-1 mt-1">
                                  <p class="text-xs font-medium text-gray-700">Cash Back: </p>
                                  <p class="text-xs font-semibold text-green-600">
                                      {{ help_getRoundAmount($flight['pricing']['discount']) }}
                                  </p>
                              </div>
                          @endif
                          {{-- @if ($flight['pricing']['discountAmount'] > 0)
                              <s class="text-lg font-semibold leading-5">
                                  {{ help_getRoundAmount($flight['pricing']['markedfarewithoutdiscount']) }} /-
                              </s>
                          @endif --}}
                      </div>
                  </div>
                  <div class="px-2 detail-wrap !pt-0 pb-2">
                      <div class="bg-white p-2">
                          <div class="detail-flights">
                              @foreach ($flight['detail'] as $detail)
                                  <div>
                                      <div class="flex items-center airport-part">
                                          <div class="airport-name min-w-fit">
                                              <h3 class="text-xl text-start font-semibold">
                                                  {{ $detail['origin'] }}
                                              </h3>

                                              <div class="text-[12px] font-medium uppercase text-gray-400 text-start">
                                                  {{ \Carbon\Carbon::parse($detail['origintime'])->format('H:i') }}
                                              </div>
                                              <div class="text-[10px] font-medium text-gray-400 text-start">
                                                  {{ \Carbon\Carbon::parse($detail['origindate'])->format('M d, D') }}
                                              </div>
                                          </div>
                                          <div
                                              class="r-airprogress w-full px-2 after:content-[ ] relative after:h-[1px] after:bg-gray-400 after:absolute after:right-0 after:top-2/4 after:w-4/5">
                                              <i class="fa-solid fa-plane text-primary float-start z-10 mt-[1px]"></i>
                                          </div>
                                          <div class="relative min-w-fit">
                                              <div class="w-full text-gray-400 font-medium mb-1">
                                                  {{ $detail['totaltime'] }}
                                              </div>
                                              <div class="w-full text-gray-400 font-medium mt-1">
                                                  {{ $detail['stops'] }} Stop
                                              </div>
                                          </div>
                                          <div
                                              class="r-airprogress w-full px-2 after:content-[ ] relative after:h-[1px] after:bg-gray-400 after:absolute after:left-0 after:top-2/4 after:w-4/5">
                                              <i
                                                  class="fa-solid fa-angle-right text-primary float-end text-base z-10 mt-[1px]"></i>
                                          </div>
                                          <div class="airport-name arrival min-w-fit">
                                              <h3 class="text-xl font-semibold  text-right">
                                                  {{ $detail['destination'] }}
                                              </h3>

                                              <h4 class="text-[12px] font-medium uppercase text-gray-400  text-right">
                                                  {{ \Carbon\Carbon::parse($detail['destinationtime'])->format('H:i') }}
                                              </h4>
                                              <h4 class="text-[10px] font-medium text-gray-400 text-right">
                                                  {{ \Carbon\Carbon::parse($detail['destinationdate'])->format('M d, D') }}
                                              </h4>
                                          </div>
                                      </div>
                                  </div>
                              @endforeach
                          </div>

                          <div class="hs-accordion-group w-full">
                              <div class="hs-accordion w-full" id="details-drop">
                                  <div class="flex items-start justify-end gap-4 mt-2">
                                      <button
                                          class="hs-accordion-toggle max-w-fit bg-primary px-4 py-2 text-white rounded-lg"
                                          aria-expanded="false" aria-controls="details-accordion">
                                          Details
                                      </button>
                                      <form class="book-form" method="post" action="{{ route('flight.book') }}">
                                          @csrf
                                          <input type="hidden" name="flight" value="{{ encrypt($flight) }}">
                                          <button class="bg-primary px-4 py-2 text-white rounded-lg">
                                              Book Now
                                          </button>
                                      </form>
                                  </div>

                                  <!-- flight details  -->
                                  <div class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300"
                                      id="details-accordion" role="region" aria-labelledby="details-drop">
                                      <div class="gap-3 mt-2">
                                          <div class="flex">
                                              <div
                                                  class="flex bg-primary-background hover:bg-primary-background rounded-lg transition p-1">
                                                  <nav class="flex gap-x-1 overflow-x-auto" aria-label="Tabs"
                                                      role="tablist" aria-orientation="horizontal">
                                                      <button
                                                          class="hs-tab-active:bg-white hs-tab-active:text-gray-700 hs-tab-active: hs-tab-active: py-3 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700 font-medium rounded-lg hover:hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none active"
                                                          id="r-segment-item-1"
                                                          data-hs-tab="#r-detail-drop-flights-{{ $key }}"
                                                          type="button" aria-selected="true"
                                                          aria-controls="r-detail-drop-flights-{{ $key }}"
                                                          role="tab">
                                                          Flights
                                                      </button>
                                                      {{-- <button type="button"
                                                          class="hs-tab-active:bg-white hs-tab-active:text-gray-700 hs-tab-active: hs-tab-active: py-3 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700 font-medium rounded-lg hover:hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none"
                                                          id="segment-item-2" aria-selected="true"
                                                          data-hs-tab="#r-detail-drop-penalty-{{ $key }}"
                                                      aria-controls="r-detail-drop-penalty-{{ $key }}"
                                                      role="tab">
                                                      Penalty
                                                      </button> --}}
                                                      <button
                                                          class="hs-tab-active:bg-white hs-tab-active:text-gray-700 hs-tab-active: hs-tab-active: py-3 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700 font-medium rounded-lg hover:hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none"
                                                          id="details-item-3"
                                                          data-hs-tab="#r-detail-drop-pricing-{{ $key }}"
                                                          type="button" aria-selected="false"
                                                          aria-controls="r-detail-drop-pricing-{{ $key }}"
                                                          role="tab">
                                                          Pricing
                                                      </button>
                                                      <button
                                                          class="hs-tab-active:bg-white hs-tab-active:text-gray-700 hs-tab-active: hs-tab-active: py-3 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700 font-medium rounded-lg hover:hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none"
                                                          id="details-item-4"
                                                          data-hs-tab="#r-detail-drop-baggage-{{ $key }}"
                                                          type="button" aria-selected="false"
                                                          aria-controls="r-detail-drop-baggage-{{ $key }}"
                                                          role="tab">
                                                          Baggage
                                                      </button>
                                                      <button
                                                          class="fare-rule min-w-fit hs-tab-active:bg-white hs-tab-active:text-gray-700 hs-tab-active: hs-tab-active: py-3 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700 font-medium rounded-lg hover:hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none"
                                                          id="details-item-4"
                                                          data-hs-tab="#r-detail-drop-farerule-{{ $key }}"
                                                          type="button" aria-selected="false"
                                                          aria-controls="r-detail-drop-farerule-{{ $key }}"
                                                          data="{{ $flight['rph'] }}" role="tab">
                                                          Fare Rule
                                                      </button>
                                                  </nav>
                                              </div>
                                          </div>

                                          <div class="mt-3">
                                              <!-- Flights Tab  -->
                                              <div id="r-detail-drop-flights-{{ $key }}" role="tabpanel"
                                                  aria-labelledby="r-segment-item-1">
                                                  @foreach ($flight['flight'] as $f)
                                                      @foreach ($f['sectors'] as $k => $value)
                                                          <div class="rounded-md overflow-hidden my-2">
                                                              {{-- <div
                                                                  class="bg-primary w-full py-3 text-center flex justify-center items-center gap-3">
                                                                  <i
                                                                      class="fa-solid fa-plane-departure text-white text-sm uppercase"></i>
                                                                  <div class="text-white text-sm uppercase font-medium">
                                                                      {{ $value['departure'] }}
                                                  </div>
                                                  <div class="text-white text-sm uppercase font-medium">
                                                      -
                                                  </div>
                                                  <div class="text-white text-sm uppercase font-medium">
                                                      {{ $value['arrival'] }}
                                                  </div>
                                                  <i
                                                      class="fa-solid fa-plane-arrival text-white text-sm uppercase"></i>
                                              </div> --}}
                                                              <div class="detail-flights mt-2 px-2 flex flex-col gap-4">

                                                                  <div>
                                                                      <div class="flex items-center airport-part">
                                                                          <div class="airport-name min-w-fit">
                                                                              <h3
                                                                                  class="text-xl text-start font-semibold">
                                                                                  {{ $value['departure'] }}
                                                                                  {{-- ,{{ $value['depterminal'] }} --}}
                                                                              </h3>

                                                                              <div
                                                                                  class="text-[12px] font-medium uppercase text-gray-400 text-start">
                                                                                  {{ \Carbon\Carbon::parse($value['departtime'])->format('H:i') }}
                                                                              </div>
                                                                              <div
                                                                                  class="text-[10px] font-medium text-gray-400 text-start">
                                                                                  {{ \Carbon\Carbon::parse($value['departdate'])->format('D, M d, Y') }}
                                                                              </div>
                                                                          </div>
                                                                          <div
                                                                              class="r-airprogress w-full px-2 after:content-[ ] relative after:h-[1px] after:bg-gray-400 after:absolute after:right-0 after:top-2/4 after:w-4/5">
                                                                              <i
                                                                                  class="fa-solid fa-plane text-primary float-start z-10 mt-[1px]"></i>
                                                                          </div>
                                                                          <div class="relative min-w-fit">
                                                                              <div
                                                                                  class="w-full text-gray-400 font-medium mb-1">
                                                                                  {{ $value['elapstime'] }}
                                                                              </div>
                                                                              <div
                                                                                  class="w-full text-gray-400 font-medium mt-1">
                                                                                  {{-- {{ $value['class'] }} --}}
                                                                                  Class: {{ $value['resbook'] }}
                                                                              </div>
                                                                              <div
                                                                                  class="w-full text-gray-400 font-medium mt-1">
                                                                                  {{ $value['marketingairline'] }}
                                                                                  {{ $value['flightnumber'] }}
                                                                              </div>
                                                                          </div>
                                                                          <div
                                                                              class="r-airprogress w-full px-2 after:content-[ ] relative after:h-[1px] after:bg-gray-400 after:absolute after:left-0 after:top-2/4 after:w-4/5">
                                                                              <i
                                                                                  class="fa-solid fa-angle-right text-primary float-end text-base z-10 mt-[1px]"></i>
                                                                          </div>
                                                                          <div class="airport-name arrival min-w-fit">
                                                                              <h3
                                                                                  class="text-xl text-right font-semibold">
                                                                                  {{ $value['arrival'] }}
                                                                                  {{-- , {{ $value['arrivalterminal'] }} --}}
                                                                              </h3>

                                                                              <h4
                                                                                  class="text-[12px] font-medium uppercase text-gray-400 text-right">
                                                                                  {{ \Carbon\Carbon::parse($value['arrivaltime'])->format('H:i') }}
                                                                              </h4>
                                                                              <h4
                                                                                  class="text-[10px] font-medium text-gray-400 text-right">
                                                                                  {{ \Carbon\Carbon::parse($value['arrivaldate'])->format('D, M d, Y') }}
                                                                              </h4>
                                                                          </div>
                                                                      </div>
                                                                  </div>
                                                                  <div class="relative items-center justify-center">
                                                                      @if (array_key_exists($loop->iteration, $f['sectors']))
                                                                          <button
                                                                              class="bg-red-500 text-white p-1 px-8 rounded-full absolute flex top-[50%] left-[50%] items-center justify-center w-60"
                                                                              style="transform: translate(-50%, -50%)">
                                                                              CT:
                                                                              {{ \App\Service\Sabre\SabreBasic::generateFlightTime(\Carbon\Carbon::parse($f['sectors'][$loop->iteration - 1]['arrivaldate'] . ' ' . $f['sectors'][$loop->iteration - 1]['arrivaltime'])->diffInRealMinutes(\Carbon\Carbon::parse($f['sectors'][$loop->iteration]['departdate'] . ' ' . $f['sectors'][$loop->iteration]['departtime']))) }}</span>
                                                                          </button>
                                                                          <hr class="my-4" />
                                                                      @endif
                                                                  </div>

                                                              </div>
                                                          </div>
                                                      @endforeach
                                                      @if (!$loop->last)
                                                          <hr class="border-2 border-green-600" />
                                                      @endif
                                                  @endforeach
                                              </div>
                                              <!-- / Flights Tab  -->

                                              <!-- Penalty Tab  -->
                                              <div class="hidden" id="r-detail-drop-penalty-{{ $key }}"
                                                  role="tabpanel" aria-labelledby="r-segment-item-2">
                                                  <div class="flex flex-col">
                                                      <div class="-m-1.5 overflow-x-auto">
                                                          <div class="p-1.5 min-w-full inline-block align-middle">
                                                              <div class="border rounded-lg overflow-hidden">
                                                                  <table class="min-w-full divide-y divide-gray-200">
                                                                      <thead>
                                                                          <tr>
                                                                              <th scope="col">Pax Type</th>
                                                                              <th scope="col">Penalty On</th>
                                                                              <th scope="col">Applicability
                                                                              </th>
                                                                              <th scope="col">Availability
                                                                              </th>
                                                                              <th scope="col">
                                                                                  Applicable Charges
                                                                              </th>
                                                                          </tr>
                                                                      </thead>
                                                                      <tbody class="divide-y divide-gray-200">
                                                                          <tr>
                                                                              <td
                                                                                  class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                                                  Pax Type
                                                                              </td>
                                                                              <td
                                                                                  class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                                  Refund
                                                                              </td>
                                                                              <td
                                                                                  class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                                  Before Flight
                                                                              </td>
                                                                              <td
                                                                                  class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                                  Yes
                                                                              </td>
                                                                              <td
                                                                                  class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                                  NPR 5000
                                                                              </td>
                                                                          </tr>
                                                                          <tr>
                                                                              <td
                                                                                  class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                                                  Pax Type
                                                                              </td>
                                                                              <td
                                                                                  class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                                  Refund
                                                                              </td>
                                                                              <td
                                                                                  class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                                  Before Flight
                                                                              </td>
                                                                              <td
                                                                                  class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                                  Yes
                                                                              </td>
                                                                              <td
                                                                                  class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                                  NPR 5000
                                                                              </td>
                                                                          </tr>
                                                                      </tbody>
                                                                  </table>
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                              <!-- / Penalty Tab  -->

                                              <!-- Pricing Tab  -->
                                              <div class="hidden" id="r-detail-drop-pricing-{{ $key }}"
                                                  role="tabpanel" aria-labelledby="details-item-3">
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
                                                                                      {{ help_getRoundAmount($breakdown['mbasefare']) }}
                                                                                      *
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
                                                                                      {{ help_getRoundAmount($breakdown['tax']) }}
                                                                                      *
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
                                                                                  {{ help_getRoundAmount($flight['pricing']['markedfare']) }}
                                                                              </td>
                                                                          </tr>
                                                                      </tbody>
                                                                  </table>
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                              <!-- / Pricing Tab  -->

                                              <!-- Baggage Tab  -->
                                              <div class="hidden" id="r-detail-drop-baggage-{{ $key }}"
                                                  role="tabpanel" aria-labelledby="details-item-4">
                                                  <div class="flex flex-col">
                                                      <div class="-m-1.5 overflow-x-auto">
                                                          <div class="p-1.5 min-w-full inline-block align-middle">
                                                              <div class="border rounded-lg overflow-hidden">
                                                                  <table class="min-w-full divide-y divide-gray-200">
                                                                      <thead>
                                                                          <tr>
                                                                              <th scope="col">
                                                                                  PAX
                                                                              </th>
                                                                              <th scope="col">Checking Bags
                                                                              </th>
                                                                              <th scope="col">Handcarry Bags
                                                                              </th>
                                                                          </tr>
                                                                      </thead>
                                                                      <tbody class="divide-y divide-gray-200">
                                                                          @foreach ($flight['baggage'] as $baggage)
                                                                              <tr>
                                                                                  <td
                                                                                      class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                                      {{ $baggage['pax'] }}
                                                                                  </td>
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
                                              <!-- / Baggage Tab  -->
                                              <div class="hidden" id="r-detail-drop-farerule-{{ $key }}"
                                                  role="tabpanel" aria-labelledby="segment-item-4">
                                                  <div class="p-4 bg-white rounded">
                                                      <div class=" fare-rule{{ $flight['rph'] }} max-h-[250px] overflow-y-auto overflow-x-hidden"
                                                          id="fare-rule{{ $flight['rph'] }}"
                                                          style="word-wrap: break-word;">
                                                          Rule
                                                      </div>

                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>

                                  <!-- / flight details  -->
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
