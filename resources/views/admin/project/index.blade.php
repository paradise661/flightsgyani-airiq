@extends('layouts.app')
@section('title')
    Add Booking
@stop
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="row">
                            <div class="col-lg-6">
                                <h3 class="box-title">Booking</h3>
                            </div>
                            <div class="col-lg-6">
                                <a class="btn btn-primary pull-right" href=""> Add
                                    Booking </a>
                            </div>

                        </div>
                    </div>
                    <table id="tabled" class="table table-hover">
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
                                {{--<a href="" class="btn-sm btn-danger"><i class="fa fa-trash"></i> </a>--}}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>
@stop

