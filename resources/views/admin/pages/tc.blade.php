@extends('layouts.back')
@section('title')
    Terms & Conditions
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
                    <h3 class="box-title">Terms & Conditions</h3>
                </div>
                <div class="box-body">
                    <form action="{{ route('terms.update') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="form-group col-4">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title"
                                       placeholder="Enter title" value="{{$tc->title}}" required>
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('title') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="title">Slug</label>
                                <input type="text" disabled readonly class="form-control" id="slug"
                                       value="{{$tc->slug}}">
                                @if ($errors->has('slug'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('slug') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Content</label>
                            <textarea name="description" id="description" class="ckeditor">{{$tc->content}}
                                </textarea>
                            @if ($errors->has('description'))
                                <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('description') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" value="Update">
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ URL::asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script>
        $(function () {
            $('#title').keyup(function () {
                var title = $(this).val();
                if (title === '') {
                    return;
                }
//                $('#h1_title').val(title);

                title = title.toLowerCase();
                title = title.replace(/[^a-z0-9 ]+/g, '');
                title = title.replace('  ', ' ');

                var url = title.replace(/\s/g, '-');
                $('#slug').val(url);
            });
        });
    </script>
@endsection
