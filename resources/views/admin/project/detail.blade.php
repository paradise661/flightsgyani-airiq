@extends('layouts.app')
@section('title')
    NanghKhel Project (5-3-3-0), Surya Binayak, Bhaktapur
@stop
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-light-blue">
                    <div class="inner">
                        <h3>8 Plot</h3>
                        <p>Kharid</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>9 Plot</h3>
                        <p>Bikri</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-briefcase"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>2-2-0-3</h3>
                        <p>Baki</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-dashboard"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>Rs.969696</h3>
                        <p>Kharcha</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-dashboard"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="row">
                            <div class="col-lg-12">
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill"
                                           href="#pills-home" role="tab" aria-controls="pills-home"
                                           aria-selected="true">Kharid</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill"
                                           href="#pills-profile" role="tab" aria-controls="pills-profile"
                                           aria-selected="false">Bikri</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-contact-tab" data-toggle="pill"
                                           href="#pills-contact" role="tab" aria-controls="pills-contact"
                                           aria-selected="false">Kharcha</a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                             aria-labelledby="pills-home-tab">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h3 id="sub-title">Kharid Bibaran</h3>
                                </div>
                                <div class="col-lg-6">
                                    <a class="btn btn-primary pull-right" href=""> Add <i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                            <table id="table" class="table table-hover">
                                <thead>
                                <tr>
                                    {{--<th></th>--}}
                                    <th>S NO.</th>
                                    <th>Jilla.</th>
                                    <th>Na.pa/ Ga. bi. a</th>
                                    <th>Woda no.</th>
                                    <th>Sabik kitta no.</th>
                                    <th>Kitta no.</th>
                                    <th>Sabik Jagga Dhani</th>
                                    <th>Prati anna</th>
                                    <th>jamma Mulya</th>
                                    <th>hal ko jagga dhani</th>
                                    <th>Ra no.</th>
                                    <th>Miti</th>
                                    <th>Bagina</th>
                                    <th>Baki</th>
                                    <th>pass gareko</th>
                                    <th width="10%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>

                                    <td>1</td>
                                    <td>Bhaktapur</td>
                                    <td>Surya Binak Nagarpalika</td>
                                    <td>5</td>
                                    <td>110</td>
                                    <td>210</td>
                                    <td>Ram Bahadur</td>
                                    <td>Rs 2,00,000</td>
                                    <td>Rs 25,00,000</td>
                                    <td>Gopal Bahdur</td>
                                    <td>99</td>
                                    <td>2075-08-69</td>
                                    <td>10,00,000</td>
                                    <td>15,00,000</td>
                                    <td>clear</td>
                                    <td><a href="" class="btn-sm btn-primary"><i class="fa fa-edit"></i> </a>
                                        <a href="{{route('project.detail',Auth::user()->company->slug)}}"
                                           class="btn-sm btn-info"><i class="fa fa-eye"></i> </a>
                                        {{--<a href="" class="btn-sm btn-danger"><i class="fa fa-trash"></i> </a>--}}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                             aria-labelledby="pills-profile-tab">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h3 id="sub-title">Bikri Bibaran</h3>
                                </div>
                                <div class="col-lg-6">
                                    <a class="btn btn-primary pull-right" href=""> Add <i class="fa fa-plus"></i></a>

                                </div>

                            </div>
                            <table id="table" class="table table-hover">
                                <thead>
                                <tr>
                                    {{--<th></th>--}}
                                    <th>S NO.</th>
                                    <th>Jilla.</th>
                                    <th>Na.pa/ Ga. bi. a</th>
                                    <th>Woda no.</th>
                                    <th>Sabik kitta no.</th>
                                    <th>Kitta no.</th>
                                    <th>Sabik Jagga Dhani</th>
                                    <th>Prati anna</th>
                                    <th>jamma Mulya</th>
                                    <th>hal ko jagga dhani</th>
                                    <th>Ra no.</th>
                                    <th>Miti</th>
                                    <th>Bagina</th>
                                    <th>Baki</th>
                                    <th>pass gareko</th>
                                    <th width="10%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>

                                    <td>1</td>
                                    <td>Bhaktapur</td>
                                    <td>Surya Binak Nagarpalika</td>
                                    <td>5</td>
                                    <td>110</td>
                                    <td>210</td>
                                    <td>Ram Bahadur</td>
                                    <td>Rs 2,00,000</td>
                                    <td>Rs 25,00,000</td>
                                    <td>Gopal Bahdur</td>
                                    <td>99</td>
                                    <td>2075-08-69</td>
                                    <td>10,00,000</td>
                                    <td>15,00,000</td>
                                    <td>clear</td>
                                    <td><a href="" class="btn-sm btn-primary"><i class="fa fa-edit"></i> </a>
                                        <a href="{{route('project.detail',Auth::user()->company->slug)}}"
                                           class="btn-sm btn-info"><i class="fa fa-eye"></i> </a>
                                        {{--<a href="" class="btn-sm btn-danger"><i class="fa fa-trash"></i> </a>--}}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                             aria-labelledby="pills-contact-tab">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h3 id="sub-title">Kharcha Bibaran</h3>
                                </div>
                                <div class="col-lg-6">
                                    <a class="btn btn-primary pull-right" href=""> Add <i class="fa fa-plus"></i></a>
                                </div>

                            </div>
                            <table id="table" class="table table-hover">
                                <thead>
                                <tr>
                                    {{--<th></th>--}}
                                    <th>S NO.</th>
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>Area</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>

                                    <td>1</td>
                                    <td>Nangkhel Project</td>
                                    <td>Nangkhel,Bhaktapur</td>
                                    <td>1-8-9-6</td>
                                    <td><a href="" class="btn-sm btn-primary"><i class="fa fa-edit"></i> </a>
                                        <a href="{{route('project.detail',Auth::user()->company->slug)}}"
                                           class="btn-sm btn-info"><i class="fa fa-eye"></i> </a>
                                        <a href="" class="btn-sm btn-danger"><i class="fa fa-trash"></i> </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@stop

