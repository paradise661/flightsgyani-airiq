@extends('layouts.back')
@section('title')
    BSP Commission
@endsection
@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(session('warning'))
        <div class="alert alert-danger alert-dismissible show" role="alert">
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
                <form role="form" id="form" action="{{ route('bspcommission.store') }}" method="POST"
                      enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="radio">
                                        <label for="siti">
                                            <input type="radio" name="type" id="siti" value="siti"> With Origin(SITI)
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="radio">
                                        <label for="soto">
                                            <input type="radio" name="type" id="soto" value="soto"> Without Origin(SOTO)
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="radio">
                                        <label for="all">
                                            <input type="radio" name="type" id="all" checked value="all"> All
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4 col-lg-4 col-sm-12 col-xs-12">
                                <label for="airline">Airine</label>
                                <input type="text" class="form-control airline-typeahead" id="airline" name="airline"
                                       value="{{ old('airline') }}" required>
                                @if($errors->has('airline'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('airline') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-4 col-lg-4 col-sm-12 col-xs-12">
                                <label for="commission">Commission</label>
                                <input type="text" class="form-control" id="commission" name="commission"
                                       value="{{ old('commission') }}" required>
                                @if ($errors->has('commission'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('commission') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="submit" class="btn btn-primary" value="Submit">
                    </div>
                </form>

            </div>
        </div>

        <div class="col-md-12">
            <div class="box box-secondary">
                <div class="box-header with-border">
                    <h3 class="box-title">BSP Commissions</h3>
                </div>

                <table class="table table-hover" id="commissionTable">
                    <thead>
                    <tr>
                        <th class="datatable-nosort">#</th>
                        <th>Airline</th>
                        <th>Commission</th>
                        <th>With Origin</th>
                        <th>Without Origin</th>
                        <th class="datatable-nosort">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(\App\Models\InternationalFlight\BSPCommission::all() as $bsp)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $bsp->airline }}</td>
                            <td>{{ $bsp->commission }}</td>
                            <td>{{ (isset($bsp->with_origin))?'SITI':'-' }}</td>
                            <td>{{ (isset($bsp->without_origin))?'SOTO':'-' }}</td>
                            <td>
                                <div class="dropdown">
                                    <a class="btn btn-outline-primary dropdown-toggle" href="#" role="button"
                                       data-toggle="dropdown">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item"
                                           href="{{ route('bspcommission.edit',base64_encode(serialize($bsp))) }}"><i
                                                class="fa fa-eye"></i> Edit</a>
                                        {{--                                            <a class="dropdown-item" href="{{ route('bspcommission.destroy',$commission->id) }}" ><i class="fa fa-eye"></i> Delete</a>--}}
                                        <form method="post"
                                              action="{{ route('bspcommission.destroy',base64_encode(serialize($bsp))) }}">
                                            @csrf
                                            @method('DELETE')
                                            <p><input type="submit" class="dropdown-item" value=" Delete"><i
                                                    class="fa fa-bin"></i></p>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

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
