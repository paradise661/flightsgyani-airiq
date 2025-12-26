@extends('layouts.front')
@section('body')
{{-- New Design --}}
<!-- Banner  -->
<div class="banner h-[237px] w-full overflow-hidden relative flex items-end justify-center">
    <img class="absolute top-0 right-0" src="{{ asset('images/banner-plane.png') }}" alt="" />
    <div class="max-h-fit text-center items-baseline">
        <h4 class="text-white text-4xl font-bold tracking-wide z-10 relative">
            About Us
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

            <li class="text-lg font-medium text-gray-300 truncate" aria-current="page">
                About Us
            </li>
        </ol>
    </div>
</div>
<!-- /Banner  -->

<section class="about mt-4 md:mt-8 px-4 md:px-0">
    <div class="container mx-auto">
        <div class="about-intro col-span-12 md:col-span-7">
            <h5 class="text-4xl font-semibold capitalize">
                <span class="text-primary">Book A Call</span> With Us
            </h5>
            <div class="about-description text-base text-gray-500 font-normal py-3 text-justify flex flex-col gap-3 leading-7 ">
                {!! $about[0]->description ?? '' !!}
            </div>

        </div>
        <div class="grid grid-cols-12 gap-5">
            <!-- <div class="grid grid-cols-4 gap-2 col-span-12 md:col-span-5">
                    <div class="col-span-4 rounded-md overflow-hidden">
                        <img src="./../../public/images/about1.webp" alt="" />
                    </div>
                    <div class="col-span-2 rounded-md overflow-hidden">
                        <img src="./../../public/images/about1.webp" alt="" />
                    </div>
                    <div class="col-span-2 rounded-md overflow-hidden">
                        <img src="./../../public/images/about1.webp" alt="" />
                    </div>
                </div> -->
        </div>
    </div>
</section>

<section class="mission bg-primary mt-4 md:mt-8 py-4 md:py-[32px] ">
    <div class="container mx-auto">
        <div class="max-w-[800px] px-4 md:px-0">
            <h5 class="text-4xl font-semibold capitalize text-gray-300">
                Guiding the Way to <br />
                Brighter Tomorrows!
            </h5>
            <p class="text-base font-normal mt-4 text-black">
                {!! $about[0]->short_description ?? '' !!}
            </p>
        </div>
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 p-4 gap-4 items-center">
            @foreach ($whatwedos as $key => $w)
            <div class="grid self-stretch bg-secondary-background rounded-xl py-4 px-4 md:py-12 md:px-16 w-full">
                <div class="flex items-center gap-4">
                    @if ($key == 0)
                    <i class="fa-regular fa-smile text-primary-lighter text-4xl"></i>
                    @elseif($key == 1)
                    <i class="fa-regular fa-hand-peace text-primary-lighter text-4xl"></i>
                    @elseif($key == 2)
                    {{-- <i class="fa fa-exchange" aria-hidden="true"></i> --}}
                    <i class="fa-solid fa-exchange text-primary-lighter text-4xl"></i>
                    @elseif($key == 3)
                    <i class="fa-solid fa-plane text-primary-lighter text-4xl"></i>
                    @endif
                    <p class="text-2xl text-white font-medium">{{ $w->title ?? '' }}</p>
                </div>
                <div class="mt-4 text-white font-light text-base">
                    {!! $w->description ?? '' !!}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
{{-- ./New Design --}}
@endsection
@section('scripts')
@include('front.partials.map')
@endsection