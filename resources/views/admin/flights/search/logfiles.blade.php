@extends('layouts.back')
@section('title')
    Log Files
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    Log Files
                </div>
                <div class="list-group">
                    @foreach($files as $file)
                        <h4><a href="{{ URL::asset('/storage/'.$file) }}"
                               class="list-group-item list-group-item-danger list-group-item-action active"
                               target="_blank">{{ basename($file) }}</a><br></h4>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
