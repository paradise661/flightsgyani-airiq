@forelse($flights as $key => $flight)
    @if ($filterType === 'mobile')
        @include('front.includes.searchresultpage.responsiveflightdetail', [
            'flight' => $flight,
            'key' => $key,
        ])
    @else
        @include('front.includes.searchresultpage.flightdetail', [
            'flight' => $flight,
            'key' => $key,
        ])
    @endif
@empty
    No Flights Found
@endforelse
{{-- <script>
    window.HSStaticMethods.autoInit();
</script> --}}