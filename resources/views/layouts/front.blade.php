@include('front.partials.head')
<div id="main_content">
    @include('front.partials.nav')
    @yield('body')
    @include('front.partials.footer')
</div>
{{-- loader --}}
<div id="loader_screen" class="hidden">
    <div class="h-screen w-screen flex md:items-center mt-6 md:mt-0 justify-center">
        <div class="loading">
            <div class="loading-header flex flex-col justify-center items-center gap-4 ">
                <img src="{{ asset('frontend/images/search-loader.gif') }}" class="max-w-[200px]" alt="" />
                <div class="border-b-2 border-secondary flex">
                    <div class="px-6 py-3 text-base bg-secondary text-white">
                        Searching Flights
                    </div>
                    <div class="px-6 py-3 text-base">Please Wait</div>
                </div>
            </div>
            <div class="loading-body mt-3">
                <div class="flex flex-col gap-4 items-center justify center mx-4 md:mx-0">
                    <div class="searching-for text-lg">
                        Searching For: <span class="text-secondary uppercase" id="view_dep">KTM</span>
                        <i class="fa-solid fa-plane px-2"></i>
                        <span class="text-secondary uppercase" id="view_arr">PKR</span>
                        <span class="font-medium"> for <span id="view_depdate"></span>
                            {{-- || <span id="view_travellers">1</span> Travellers </span> --}}
                    </div>
                    <div class="flyer max-w-[600px] object-cover overflow-hidden">
                        @if (getSiteSettings()->loader_ad ?? '')
                            <img src="{{ asset('uploads/site/' . getSiteSettings()->loader_ad) }}" alt=""
                                class="" height="" width="450" />
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('click', '.btn_domestic_search', function(e) {

        let date = new Date($('.dep-date').val());
        if ($(this).attr('type') === 'mobile') {
            date = new Date($('#rdep_date_value').val());
        }
        let formattedDate = date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
        $('#view_dep').html($('#depairport-domestic-value').val());
        $('#view_arr').html($('#arrairport-domestic-value').val());
        $('#view_depdate').html(formattedDate);
        $('#view_travellers').html($('#domestic-passenger-count').html());

        $('#main_content').hide();
        $('#loader_screen').show();
    })

    $('.primary-search').on('click', function() {
        $('#main_content').hide();
        $('#loader_screen').show();
    })

    $(function(e) {
        $(".dep-date").datepicker({
            minDate: "0",
            format: "yyyy-mm-dd",
            startDate: "today",
            autoclose: true,
            todayHighlight: true,
            toggleActive: true,
            onSelect: function(selectedDate) {
                // Set the minDate for the return datepicker
                $(".return-date").datepicker("option", "minDate", selectedDate);
            },
        });
        $(".return-date").datepicker({
            minDate: "0",
            format: "yyyy-mm-dd",
            startDate: "today",
            autoclose: true,
            todayHighlight: true,
            toggleActive: true
        });

        // $(".dep_flatpicker").flatpickr({
        //     dateFormat: "Y-m-d",
        //     altInput: true,
        //     altFormat:'m/d/Y',
        //     // allowInput: true
        //     minDate:"today"
        // });
        // $("#rdep_date_value").flatpickr({
        //     dateFormat: "Y-m-d",
        //     altInput: true,
        //     altFormat:'m/d/Y',
        //     // allowInput: true
        //     minDate:"today"
        // });
        // $(".arr_flatpicker").flatpickr({
        //     dateFormat: "Y-m-d",
        //     altInput: true,
        //     altFormat:'m/d/Y',
        //     // allowInput: true
        //     minDate:"today"
        // });
    })
</script>

@include('front.partials.scripts')
