@extends('layouts.front')
@section('title')
    Payment
@endsection

@section('body')
    {{-- New Payment Page --}}
    <div class="banner h-[100px] w-full overflow-hidden relative flex items-end justify-center">
        <img class="absolute top-0 right-0" src="{{ asset('images/banner-plane.png') }}" alt="" />
        <div class="max-h-fit text-center items-baseline">
            <h4 class="text-white text-4xl font-bold tracking-wide z-10 relative">
                Traveller's Details
            </h4>
            <ol class="flex items-center justify-center whitespace-nowrap p-2">
                <li class="inline-flex items-center">
                    <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600"
                        href="#">
                        <svg class="icon flat-color" id="home-alt-3" data-name="Flat Color" fill="#000000" width="20px"
                            height="20px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path id="primary"
                                    d="M21.71,11.29l-9-9a1,1,0,0,0-1.42,0l-9,9a1,1,0,0,0-.21,1.09A1,1,0,0,0,3,13H4v7.3A1.77,1.77,0,0,0,5.83,22H8.5a1,1,0,0,0,1-1V16.1a1,1,0,0,1,1-1h3a1,1,0,0,1,1,1V21a1,1,0,0,0,1,1h2.67A1.77,1.77,0,0,0,20,20.3V13h1a1,1,0,0,0,.92-.62A1,1,0,0,0,21.71,11.29Z"
                                    style="fill: #ffffff"></path>
                            </g>
                        </svg>
                    </a>
                    <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M10 7L15 12L10 17" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                        </g>
                    </svg>
                </li>
                <li class="inline-flex items-center">
                    <a class="flex text-lg font-medium text-white truncate items-center hover:text-primary focus:outline-none focus:text-secondary"
                        href="#">
                        Flights
                    </a>
                    <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M10 7L15 12L10 17" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                        </g>
                    </svg>
                </li>

                <li class="text-lg font-medium text-gray-300 truncate" aria-current="page">
                    Details
                </li>
            </ol>
        </div>
    </div>

    @foreach ($flights['detail'] as $fdk => $flightDetail)
        <!-- Flight Details Heading Accordion  -->
        <div class="flight-details-accordion mt-4 md:mt-8">
            <div class="container mx-auto">
                <div class="hs-accordion-group bg-white rounded-lg shadow-md px-0 md:px-6 py-4">
                    <div class="hs-accordion" id="hs-basic-with-title-and-arrow-stretched-heading-two">
                        <button
                            class="hs-accordion-toggle overflow-hidden hs-accordion-active:text-blue-600 py-3 px-4 inline-flex items-center justify-between gap-x-3 w-full font-semibold text-start text-gray-800 hover:text-gray-500 disabled:opacity-50 disabled:pointer-events-none"
                            aria-expanded="false" aria-controls="hs-basic-with-title-and-arrow-stretched-collapse-two">
                            <div>
                                <h3 class="text-xl font-semibold tracking-wider text-gray-700">
                                    {{ $flightDetail['origin'] }} to {{ $flightDetail['destination'] }}
                                </h3>
                                <p class="text-sm font-medium tracking-wide text-gray-400">
                                    Departure On {{ \Carbon\Carbon::parse($flightDetail['origindate'])->format('M d, Y') }}
                                    At {{ $flightDetail['origintime'] }} Direct Flight Travel Time
                                    {{ $flightDetail['totaltime'] }}
                                </p>
                            </div>
                            <svg class="hs-accordion-active:hidden block size-5" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m6 9 6 6 6-6"></path>
                            </svg>
                            <svg class="hs-accordion-active:block hidden size-5" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m18 15-6-6-6 6"></path>
                            </svg>
                        </button>
                        <div class="hs-accordion-content hidden w-full overflow-hidden px-2 md:px-4 py-4 transition-[height] duration-300"
                            id="hs-basic-with-title-and-arrow-stretched-collapse-two" role="region"
                            aria-labelledby="hs-basic-with-title-and-arrow-stretched-heading-two">
                            @php
                                $flight = $flights['flight'][$fdk];
                            @endphp
                            <div class="accordion-flight-detail rounded-lg overflow-hidden shadow-md mb-4">
                                <div class="bg-primary w-full px-4 py-3 flex items-center justify-center gap-2 text-base">
                                    <div class="flex items-center justify-center gap-3">
                                        <i class="fa-solid fa-plane-departure text-white"></i>
                                        <p class="text-white text-base font-bold tracking-wider">
                                            {{ $flightDetail['origin'] }}
                                        </p>
                                        <i class="fa-solid fa-minus text-white"></i>
                                        <p class="text-white text-base font-bold tracking-wider">
                                            {{ $flightDetail['destination'] }}
                                        </p>
                                        <i class="fa-solid fa-plane-arrival text-white"></i>
                                    </div>
                                </div>
                                @foreach ($flight['sectors'] as $sector)
                                    <div class="bg-white py-3 px-3 md:px-14">
                                        <div class="traveller-flights">
                                            <div class="airport-name md:min-w-fit">
                                                <h4 class="text-sm font-medium text-gray-500 text-start">
                                                    Tue, Aug 1, 2024
                                                </h4>
                                                <h4 class="text-base font-semibold text-gray-700 text-start">
                                                    {{ $sector['departport'] }}
                                                </h4>
                                            </div>

                                            <div class="airport-progress">
                                                <i class="fa-regular fa-circle-dot text-primary float-start"></i>
                                                <i class="fa-regular fa-circle-dot text-primary float-end"></i>
                                            </div>

                                            <div class="airport-name arrival md:min-w-fit">
                                                <h4 class="text-sm font-medium text-gray-500 text-start">
                                                    {{ \Carbon\Carbon::parse($sector['departdate'])->format('D M d, Y') }}
                                                </h4>
                                                <h4 class="text-base font-semibold text-gray-700 text-start">
                                                    {{ $sector['arrivalport'] }}
                                                </h4>
                                            </div>
                                        </div>
                                        <div class="flex gap-4 md:gap-6 mt-4 items-center text-base">
                                            <div class="flight-logo">
                                                <img src="./../../public/images/qatar.png" alt="" width="72px"
                                                    height="auto" />
                                                <p class="text-xs font-bold text-gray-400">BDT 4,271</p>
                                            </div>
                                            <h6 class="text-base text-gray-400 font-medium">
                                                Direct : 1h 40m
                                            </h6>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-2 md:mt-8 shadow-md rounded-lg">
                                <div class="px-3 md:px-14 py-5 grid grid-cols-4">
                                    <div class="col-span-4 md:col-span-1">
                                        <h5 class="text-base font-semibold text-gray-600">
                                            Baggage
                                        </h5>
                                        <p class="text-sm font-medium text-gray-400">
                                            Total baggage included in the price
                                        </p>
                                    </div>
                                    <div class="col-span-4 gap-5 md:col-span-3">
                                        <div class="flex flex-col gap-3">
                                            <div class="flex items-center justify-between">
                                                <div class="flex gap-2 items-center">
                                                    <i class="fa-solid fa-briefcase text-primary text-2xl"></i>
                                                    <div>
                                                        <h6 class="text-xs text-primary font-medium">
                                                            1 Personal Item
                                                        </h6>
                                                        <p class="text-sm font-normal text-gray-400">
                                                            fits under the seat in front of you
                                                        </p>
                                                    </div>
                                                </div>
                                                <p class="text-xs font-medium text-gray-400 tracking-wider">
                                                    Included
                                                </p>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <div class="flex gap-2 items-center">
                                                    <i class="fa-solid fa-suitcase-rolling text-primary text-2xl"></i>
                                                    <div>
                                                        <h6 class="text-xs text-primary font-medium">
                                                            1 Carry-On Bag
                                                        </h6>
                                                        <p class="text-sm font-normal text-gray-400">
                                                            Max Weight 5 kg
                                                        </p>
                                                    </div>
                                                </div>
                                                <p class="text-xs font-medium text-gray-400 tracking-wider">
                                                    Included
                                                </p>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <div class="flex gap-2 items-center">
                                                    <i class="fa-solid fa-bag-shopping text-primary text-2xl"></i>
                                                    <div>
                                                        <h6 class="text-xs text-primary font-medium">
                                                            1 Checked Bag
                                                        </h6>
                                                        <p class="text-sm font-normal text-gray-400">
                                                            Max Weight 15 Kg
                                                        </p>
                                                    </div>
                                                </div>
                                                <p class="text-xs font-medium text-gray-400 tracking-wider">
                                                    Included
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Flight Details Heading Accordion  -->
    @endforeach

    <section class="payment-layout mt-4 md:mt-8">
        <div class="container mx-auto">
            <div class="container mx-auto">
                <div class="grid grid-cols-12 gap-4">
                    <!-- Payment Method  -->
                    <div class="col-span-12 md:col-span-8 order-1 md:order-1">
                        <div class="rounded-lg border border-gray-300 px-4 py-3 md:px-6 md:py-6 bg-white">
                            <h3 class="text-2xl font-semibold">Payment Method</h3>
                            <p class="text-sm text-gray-400 font-normal py-1">
                                Payment can be done with any card through the banks below.
                            </p>

                            <div class="bank-listing mt-2 px-1 md:px-4">
                                <div class="grid sm:grid-cols-2 gap-2">
                                    @if ($khalti)
                                        <label
                                            class="InstrumentCode min-h-[6rem] flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 has-[:checked]:ring-1 has-[:checked]:ring-primary"
                                            for="khalti">
                                            <input
                                                class="shrink-0 mt-0.5 hidden border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                                id="khalti" data-val="khalti"
                                                data-content="{{ $booking->booking_code }}" type="radio"
                                                name="payment-radio">
                                            <div class="flex gap-4 items-center">
                                                <img src="{{ asset('frontend/images/khalti.png') }}" alt=""
                                                    width="78px" height="78px">
                                                <h6 class="text-xl text-gray-500 font-semibold">
                                                    Khalti
                                                </h6>
                                            </div>
                                        </label>
                                        <form id="khaltiForm" style="display: none;" action="{{ route('khalti.init') }}"
                                            method="POST">
                                            @csrf
                                            <input type="text" name="booking_code"
                                                value="{{ $booking->booking_code }}" />
                                        </form>
                                    @endif
                                    {{-- @foreach ($paymentMethods['CheckoutGateway'] as $paymentMethod)
                                        <label for="{{ $paymentMethod['InstrumentCode'] }}"
                                            class="InstrumentCode flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 has-[:checked]:ring-1 has-[:checked]:ring-primary">
                                            <input type="radio" name="payment-radio"
                                                class="shrink-0 mt-0.5 hidden border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                                data-val="{{ $paymentMethod['InstrumentCode'] }}"
                                                data-content="{{ $booking->booking_code }}"
                                                id="{{ $paymentMethod['InstrumentCode'] }}">
                                            <div class="flex gap-4 items-center">
                                                <img src="{{ $paymentMethod['LogoUrl'] }}" alt="" width="78px"
                                                    height="78px">
                                                <h6 class="text-xl text-gray-500 font-semibold">
                                                    {{ $paymentMethod['InstrumentName'] }}
                                                </h6>
                                            </div>
                                        </label>
                                    @endforeach --}}

                                </div>
                                <button
                                    class="bg-primary px-5 py-3 max-w-fit text-white text-base font-medium rounded-lg mt-4"
                                    id="payNow" type="button">
                                    Pay Now
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- / Payment Method  -->

                    <!-- Order Summaray  -->
                    <div class="col-span-12 md:col-span-4 order-4 md:order-2 hidden md:block">
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                            <!-- Header -->
                            <div class="bg-gray-100 px-6 py-4 rounded-t-lg">
                                <h4 class="text-lg font-semibold text-gray-800">Order Summary</h4>
                            </div>

                            <!-- Body -->
                            <div class="p-6 space-y-4">
                                @foreach ($flights['breakdown'] as $breakdown)
                                    <div class="flex justify-between items-center">
                                        <h5 class="text-sm font-medium text-gray-600">
                                            {{ $breakdown['type'] }} ({{ $breakdown['qty'] }} Adult)
                                        </h5>
                                        <p class="text-sm font-semibold text-gray-800">
                                            {{ $breakdown['mbasefare'] }}
                                            <span class="text-gray-500">x {{ $breakdown['qty'] }}</span>
                                        </p>
                                    </div>
                                @endforeach

                                <!-- Flight Fare -->
                                <div class="flex justify-between items-center border-t pt-4">
                                    <h5 class="text-sm font-medium text-gray-500">Flight Fare</h5>
                                    <div class="flex flex-col text-right space-y-1">
                                        @foreach ($flights['breakdown'] as $breakdown)
                                            <p class="text-sm text-gray-600">{{ $breakdown['mbasefare'] }}</p>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Taxes and Fees -->
                                <div class="flex justify-between items-center border-t pt-4">
                                    <h5 class="text-sm font-medium text-gray-500">Taxes and Airline Fees</h5>
                                    <div class="flex flex-col text-right space-y-1">
                                        @foreach ($flights['breakdown'] as $breakdown)
                                            <p class="text-sm text-gray-600">{{ $breakdown['tax'] }}</p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="bg-gray-50 px-6 py-4 border-t rounded-b-lg">
                                <div class="flex justify-between items-center">
                                    <h5 class="text-lg font-bold text-gray-700">Total</h5>
                                    <h5 class="text-lg font-bold text-gray-900">{{ $flights['pricing']['markedfare'] }}
                                    </h5>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Includes all applicable taxes and fees.</p>
                            </div>
                        </div>
                    </div>

                    <!-- / Order Summaray  -->

                </div>
            </div>
        </div>
    </section>
    {{-- ./New Payment Page --}}

    @if ($ips)
        <div class="col-md-6">
            <button class="connectIps" id="connectIps" data-content="{{ $booking->booking_code }}">

            </button>
        </div>
    @endif
    @if ($NPSOnePG)
        <div id="NPS">

        </div>
    @endif

    {{-- Old Form --}}

    @if ($ips)
        <form id="connectIpsPayment" action="https://uat.connectips.com:7443/connectipswebgw/loginpage" method="post"
            style="display: none">
            <input id="merchantId" type="hidden" name="MERCHANTID">
            <input id="appId" type="hidden" name="APPID">
            <input id="appName" type="hidden" name="APPNAME">
            <input id="txnId" type="hidden" name="TXNID">
            <input id="txnDate" type="hidden" name="TXNDATE">
            <input id="txnCrncy" type="hidden" name="TXNCRNCY">
            <input id="txnAmt" type="hidden" name="TXNAMT">
            <input id="referenceId" type="hidden" name="REFERENCEID">
            <input id="reMarks" type="hidden" name="REMARKS">
            <input id="particulars" type="hidden" name="PARTICULARS">
            <input id="token" type="hidden" name="TOKEN">
        </form>
    @endif
@endsection
@section('scripts')
    @if ($khalti)
        <script src="https://khalti.com/static/khalti-checkout.js"></script>
        <script>
            var config = {
                // replace the publicKey with yours
                "publicKey": "test_public_key_e5af8c516bba4b48b9a62ed8bd0c62b5",
                "productIdentity": "{{ $booking->booking_code }}",
                "productName": "Flight Ticket",
                "productUrl": "http://flightsgyani.com",
                "eventHandler": {
                    onSuccess(payload) {
                        // hit merchant api for initiating verfication
                        console.log(payload);
                        $.ajax({
                            'method': 'post',
                            'data': {
                                payload: payload,
                                _token: $('meta[name="csrf_token"]').attr('content')
                            },
                            'url': '/flight/khalti-payment',
                            success: function(data) {
                                console.log(data);
                                window.location.href = '{{ route('generate.pnr', $booking->booking_code) }}';
                            },
                            error: function(data) {
                                console.log(data);
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'error',
                                    title: 'Error in processing payment.',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        })
                    },
                    onError(error) {
                        console.log(error);
                    },
                    onClose() {
                        console.log('widget is closing');
                    }
                }
            };
            var checkout = new KhaltiCheckout(config);
            var btn = document.getElementById("payment-button");
            btn.onclick = function() {
                checkout.show({
                    amount: '{{ $booking->final_fare * 100 }}'
                });
            }
        </script>
    @endif
    @if ($NPSOnePG)
        <script>
            $("#payNow").click(function() {
                let selected = $("input[name='payment-radio']:checked");
                let newcode = selected.attr('data-val');
                let bookingCode = selected.attr('data-content');

                if (newcode === "khalti") {
                    $('#khaltiForm').submit();
                } else {
                    $.ajax({
                        type: "GET",
                        cache: false,
                        processContent: false,
                        url: "/onepg-payment-forms/" + bookingCode + "/" + newcode + "/",

                        success: function(response) {
                            console.log(response);
                            $('#NPS').empty().html(response);
                            $('#form').hide();
                            $('#form').submit();
                            //$('#MerchantId').addClass('hide');
                        },
                        error: function(output) {
                            alert("fail");
                        }
                    });
                }

            })
        </script>
    @endif
    @if ($errors->any())
        @foreach ($errors->getMessages() as $key => $error)
            @if ($key === 'detail')
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: '{{ $error[0] }}'
                    });
                </script>
            @endif
        @endforeach
    @endif
@endsection
