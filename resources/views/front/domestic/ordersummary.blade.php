@php
    $summary = totalDomesticAmount();
@endphp

<div class="col-span-12 md:col-span-4 order-4 md:order-2">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 sticky top-0">
        <!-- Header -->
        <div class="bg-gray-100 px-6 py-4 rounded-t-lg">
            <h4 class="text-lg font-semibold text-gray-800">Order Summary</h4>
        </div>

        <!-- Body -->
        <div class="p-6 space-y-4">
            <!-- Adult Ticket -->
            <div class="flex justify-between">
                <h5 class="text-sm font-medium text-gray-600">Ticket (1 Adult)</h5>
                <p class="text-sm font-semibold text-gray-800">
                    {{ $summary['Currency'] }} {{ ceil($summary['adult_fare']) }}
                    <span class="text-gray-500">x {{ $summary['request_data']['adult'] ?? 0 }}</span>
                </p>
            </div>

            <!-- Child Ticket -->
            @if ($summary['request_data']['child'] ?? 0)
                <div class="flex justify-between">
                    <h5 class="text-sm font-medium text-gray-600">Ticket (1 Child)</h5>
                    <p class="text-sm font-semibold text-gray-800">
                        {{ $summary['Currency'] }} {{ ceil($summary['child_fare']) }}
                        <span class="text-gray-500">x {{ $summary['request_data']['child'] ?? 0 }}</span>
                    </p>
                </div>
            @endif

            <!-- Fuel Charge -->
            <div class="flex justify-between border-t pt-4">
                <h5 class="text-sm font-medium text-gray-500">Fuel Charge</h5>
                <p class="text-sm text-gray-600">
                    {{ $summary['Currency'] }} {{ $summary['fuel_surcharge'] }}
                    @if ($summary['fuel_surcharge'])
                        <span class="text-gray-500">x
                            {{ ($summary['request_data']['adult'] ?? 0) + ($summary['request_data']['child'] ?? 0) }}</span>
                    @endif
                </p>
            </div>

            <!-- Taxes and Fees -->
            <div class="flex justify-between">
                <h5 class="text-sm font-medium text-gray-500">Taxes & Airline Fees</h5>
                <p class="text-sm text-gray-600">
                    {{ $summary['Currency'] }} {{ $summary['tax'] }}
                    @if ($summary['tax'])
                        <span class="text-gray-500">x
                            {{ ($summary['request_data']['adult'] ?? 0) + ($summary['request_data']['child'] ?? 0) }}</span>
                    @endif
                </p>
            </div>

            <!-- Discount -->
            @if ($summary['totalDiscount'] > 0)
                <div class="flex justify-between">
                    <h5 class="text-sm font-medium text-gray-500">Discount</h5>
                    <p class="text-sm text-gray-600">
                        {{ $summary['Currency'] }} {{ $summary['totalDiscount'] }}
                    </p>
                </div>
            @endif

        </div>

        <!-- Footer -->
        <div class="bg-gray-50 px-6 py-4 border-t rounded-b-lg">
            <div class="flex justify-between items-center">
                <h5 class="text-lg font-bold text-gray-700">Total</h5>
                <h5 class="text-lg font-bold text-gray-900">
                    {{ $summary['Currency'] }} {{ nepaliCurrencyFormat(ceil($summary['totalAmount'])) }}
                </h5>
            </div>
            <p class="text-xs text-gray-500 mt-1">
                Includes all applicable taxes and fees.
            </p>
        </div>
    </div>
</div>
