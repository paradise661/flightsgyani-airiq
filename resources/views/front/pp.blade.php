@extends('layouts.front')
@section('title')
    {{ $pp->title }}
@endsection
@section('body')
    <div class="container">
        {!! $pp->content !!}
    </div>
@endsection
