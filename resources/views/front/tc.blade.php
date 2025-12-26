@extends('layouts.front')
@section('title')
{{ $tc->title }}
@endsection
@section('body')
<div class="container mx-auto">
    <h1 class="text-3xl py-4 font-medium text-primary text-center">Terms and Conditions</h1>
    <div class="terms-conditions text-base leading-7 px-4 md:px-0 !text-justify">
        {!! $tc->content ?? '' !!}
    </div>
</div>
@endsection