@php
    $route = Request::route()->getName();
    $actual_link =
        (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') .
        "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
@endphp

@extends('layouts.front')

@section('meta')
    <meta property="og:url" content="{{ $actual_link }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ $blog->title }}" />
    <meta property="og:description" content="{{ htmlentities($blog->description) }}" />
    <meta property="og:image" content="{{ URL::to($blog->image) }}" />
@endsection

@section('body')
    <div class="banner h-[237px] w-full overflow-hidden relative flex items-end justify-center">
        <img class="absolute top-0 right-0" src="{{ asset('images/banner-plane.png') }}" alt="" />
        <div class="max-h-fit text-center items-baseline">
            <h4 class="text-white text-4xl font-bold tracking-wide z-10 relative">Blog Details</h4>
            <ol class="flex items-center justify-center whitespace-nowrap p-2">
                <li class="inline-flex items-center">
                    <a href="{{ route('frontend.index') }}" class="text-sm text-gray-300 hover:text-white">
                        Home
                    </a>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path d="M10 7L15 12L10 17" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </li>
                <li class="text-sm text-gray-300 truncate hover:text-white">
                    <a href="{{ route('frontend.blog') }}">Blogs</a>
                </li>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M10 7L15 12L10 17" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <li class="text-sm text-gray-300 truncate">{{ $blog->title }}</li>
            </ol>
        </div>
    </div>

    <section class="max-w-5xl mx-auto px-4 mt-10">
        <div class="bg-white rounded-lg shadow p-6">
            <h1 class="text-3xl font-bold mb-4">{{ $blog->title }}</h1>
            <p class="text-sm text-gray-600 mb-4">
                {{-- {{ $blog->author ? 'By ' . $blog->author->name . ' - ' : '' }} --}}
                {{ $blog->created_at->format('D, d M Y') }}
            </p>
            @if($blog->image)
                <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="w-full rounded mb-6" />
            @endif
            <div class="max-w-none">
                {!! $blog->description !!}
            </div>
        </div>
    </section>
@endsection
