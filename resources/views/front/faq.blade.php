@extends('layouts.front')
@section('title')
    {{ $faq->title }}
@endsection
@section('body')
    <div class="container">
        {!! $faq->content !!}
    </div>
@endsection
