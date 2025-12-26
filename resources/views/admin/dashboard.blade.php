@extends('layouts.back')
@section('title')
    Dashboard
@stop
@section('content')

    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-light-blue">
                <div class="inner">
                    <h3>{{$packageCount}}</h3>
                    <p>Packages</p>
                </div>
                <div class="icon">
                    <i class="fa fa-user"></i>
                </div>
                <a href="{{route('package.index')}}" class="small-box-footer">More info <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{$partnerCount}}</h3>
                    <p>Partners</p>
                </div>
                <div class="icon">
                    <i class="fa fa-briefcase"></i>
                </div>
                <a href="{{route('partner.index')}}" class="small-box-footer">More info <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{$blogCount}}</h3>
                    <p>Blogs</p>
                </div>
                <div class="icon">
                    <i class="fa fa-briefcase"></i>
                </div>
                <a href="{{route('blog.index')}}" class="small-box-footer">More info <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{$blogCount}}</h3>
                    <p>Ticket Issued</p>
                </div>
                <div class="icon">
                    <i class="fa fa-briefcase"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

    </div>
@stop
@section('scripts')
@stop
