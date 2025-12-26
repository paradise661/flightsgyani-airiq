

@extends('layouts.front')
@section('body')
    <div class="banner h-[237px] w-full overflow-hidden relative flex items-end justify-center">
        <img class="absolute top-0 right-0" src="{{ asset('images/banner-plane.png') }}" alt="" />
        <div class="max-h-fit text-center items-baseline">
            <h4 class="text-white text-4xl font-bold tracking-wide z-10 relative">
                Blogs
            </h4>
            <ol class="flex items-center justify-center whitespace-nowrap p-2">
                <li class="inline-flex items-center">
                    <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600"
                        href="{{ route('frontend.index') }}">
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

                <li class="text-lg font-medium text-gray-300 truncate" aria-current="page">
                    Blogs
                </li>
            </ol>
        </div>
    </div>

    <section class="max-w-7xl mx-auto px-4 mt-8">
        <!-- Recent Posts Grid -->
        <div class="grid md:grid-cols-3 gap-6">
            @foreach ($blogs as $blog)
                <a href="{{ route('frontend.blog.detail', $blog->slug) }}">
                    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition p-5">
                        <img class="rounded mb-4" src="{{ $blog->image ? $blog->image : '' }}">
                        <h3 class="text-xl font-semibold mb-2">{{ $blog->title }}</h3>
                        <p class="text-gray-600 text-sm mb-2">{{ $blog->author ? 'By ' . $blog->author->name . ' - ' : '' }}
                            {{ date_format($blog->created_at, 'D, d M, Y') }}</p>
                        <p class="text-gray-700 text-sm">Short preview of the blog post content...</p>
                    </div>
                </a>
            @endforeach
        </div>
        {{ $blogs->links('vendor.pagination.front') }}
    </section>
@endsection
