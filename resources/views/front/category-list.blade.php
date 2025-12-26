@extends('layouts.front')
@section('title')
    Categories
@endsection
@section('meta')
    @php $keywords = \App\Http\Services\HelperService::keywords(); @endphp
    @foreach($packages as $p)
        @php $keywords .= $p->key_words; @endphp
    @endforeach
    <meta name="keywords" content="{{$keywords}}"/>
@endsection
@section('body')
    <section class="list">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="sidebar">
                        <div class="sidebar-item">
                            <h3>{{$category->title ? ($category->parent ? strtoupper($category->parent->title) :'') :'' }}</h3>
                            <ul>
                                @if($categoriesType)
                                    @foreach($categoriesType as $c)
                                        <li>
                                            <a href="{{route('package.list',[$categorySlug,$c->slug])}}">{{strtoupper($c->title)}}</a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="list-content">
                        @if($packages)
                            @foreach($packages as $package)
                                <div class="list-item">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="item-image">
                                                <a href="{{route('package.detail',$package->slug)}}"> <img
                                                        src="{{$package->image}}"></a>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="tour-detail">
                                                <h3 style="margin-bottom: 0px;"><a
                                                        href="{{route('package.detail',$package->slug)}}">{{$package->title}}</a>
                                                </h3>
                                                <p>
                                                    <i class="flaticon-maps-and-flags">{{$package->destination ? $package->destination :''}}</i>
                                                    {!!  $package->description ? \Illuminate\Support\Str::words($package->description, 26) :'' !!}

                                                </p>
                                                <p class="package-days"><i class="flaticon-time"></i> Duration
                                                    : {{$package->days}} days
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="tour-btns">
                                                <p><span class="bold" style="font-size: 22px">NPR {{number_format($package->price)}} /-</span>
                                                </p>
                                                <a href="#" class="btn-blue booknow" data-id="{{$package->id}}"
                                                   tabindex="0">Book Now</a>
                                                <a href="{{route('package.detail',$package->slug)}}" class="btn-blue"
                                                   tabindex="0">Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="pagination-content">

                        {{ $packages->links() }}
                        {{--<ul class="pagination">--}}
                        {{--</ul>--}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
