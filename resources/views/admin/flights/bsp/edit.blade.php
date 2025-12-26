@extends('layouts.back')
@section('title')
    BSP Commission
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
            <strong>Success!</strong> {{ session('warning') }}
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
                    <h3 class="box-title">BSP Commission</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="form" action="{{ route('bspcommission.update',$commission )}}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="radio">
                                        <label for="siti">
                                            <input type="radio" name="type"
                                                   {{ (isset($commission->with_origin))?'checked':'' }} id="siti"
                                                   value="siti"> With Origin(SITI)
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="radio">
                                        <label for="soto">
                                            <input type="radio" name="type"
                                                   {{ (isset($commission->without_origin))?'checked':'' }} id="soto"
                                                   value="soto"> Without Origin(SOTO)
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="radio">
                                        <label for="all">
                                            <input type="radio" name="type"
                                                   {{ (!isset($commission->with_origin) && !isset($commission->without_origin))?'checked':'' }} id="all"
                                                   value="all"> All
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-4">
                                <label for="airline">Airine</label>
                                <input type="text" class="form-control airline-typeahead" id="airline" name="airline"
                                       value="{{ $commission->airline }}" required>
                                @if ($errors->has('airline'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('airline') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-4">
                                <label for="commission">Commission</label>
                                <input type="text" class="form-control" id="commission" name="commission"
                                       value="{{ $commission->commission }}" required>
                                @if ($errors->has('commission'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('commission') }}</strong>
                                </span>
                                @endif
                            </div>

                        </div>

                    </div>

                    <div class="box-footer">
                        <input type="submit" class="btn btn-primary" value="Update"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('#commissionTable').DataTable();
        $('input[name="type"]').on('change', function () {

            var type = $(this).val();
            if (type === 'all') {
                $('#origin').hide();
            } else {
                $('#origin').show();
            }
        })
    </script>
@endsection
