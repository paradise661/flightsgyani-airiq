@extends('layouts.back')
@section('title')
    Update Airline
@endsection
@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(session('warning'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ session('warning') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Update Airline</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="form" action="{{ route('airline.update') }}" method="POST"
                      enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="hidden" name="data" value="{{ $airline->id }}">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-4">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                       value="{{ $airline->name  }}" required>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="code">IATA Code</label>
                                <input type="text" class="form-control" id="code" name="code"
                                       value="{{ $airline->code }}" required>
                                @if ($errors->has('code'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('code') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="image">Image</label>
                                <input type="file" class="form-control" id="image" name="image">
                                <img src="{{ asset('frontend/air-logos/'.$airline->code.'.png') }}" height="200"
                                     width="200" class="img img-responsive" alt="">
                                @if ($errors->has('image'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('image') }}</strong>
                                </span>
                                @endif
                            </div>

                        </div>

                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>

            </div>
        </div>


    </div>
@endsection

