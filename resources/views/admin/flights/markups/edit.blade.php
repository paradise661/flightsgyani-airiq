@extends('layouts.back')
@section('title')
    Update Markup
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
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Update Markup Rule</h3>
                </div>
                <div class="ml-5">
                    <form method="post" action="{{ route('markup.update') }}">
                        @csrf
                        <input type="hidden" name="markup" value="{{ $markup->id }}">
                        <div class="form-group row {{ ($errors->has('type'))?'has-danger':'' }}">
                            <label class="col-sm-12 col-md-2 col-form-label">Type</label>
                            <div class="col-sm-12 col-md-10">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="custom-control custom-checkbox mb-5">
                                            <input type="checkbox"
                                                   {{ ($errors->has('airline')?'checked':'') }} {{ (isset($markup->airline))?'checked':'' }} id="airline"
                                                   value="airline" name="type[]" class="custom-control-input">
                                            <label for="airline" class="custom-control-label">By Airline</label>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="custom-control custom-checkbox mb-5">
                                            <input type="checkbox"
                                                   {{ ($errors->has('origin') || $errors->has('destination')?'checked':'') }} {{ ($markup->origin || $markup->destination)?'checked':'' }} value="sector"
                                                   name="type[]" id="sector" class="custom-control-input">
                                            <label for="sector" class="custom-control-label">By Sector</label>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="custom-control custom-checkbox mb-5">
                                            <input type="checkbox"
                                                   {{ ($errors->has('triptype')?'checked':'') }} {{ ($markup->trip_type == 'O' || $markup->trip_type == 'R')?'checked':'' }} value="trip"
                                                   name="type[]" id="trip" class="custom-control-input">
                                            <label for="trip" class="custom-control-label">By Trip Type</label>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="custom-control custom-checkbox mb-5">
                                            <input type="checkbox"
                                                   {{ ($errors->has('class')?'checked':'') }} {{ (isset($markup->class))?'checked':'' }} value="Class"
                                                   name="type[]" id="class" class="custom-control-input">
                                            <label for="class" class="custom-control-label">By Class</label>
                                        </div>
                                    </div>
                                </div>
                                @if($errors->has('type'))
                                    <p style="color: red">{{ $errors->first('type') }}</p>
                                @endif
                            </div>
                        </div>
                        <div id="airline-form" style="display: {{ ($errors->has('airline'))?'':'none' }};">
                            <div class="form-group row {{ ($errors->has('airline'))?'has-danger':'' }}">
                                <label class="col-sm-12 col-md-2 col-form-label">Airline</label>
                                <div class="col-sm-12 col-md-10">
                                    <input type="text"
                                           class="form-control airline-input {{ ($errors->has('airline'))?'form-control-danger':'' }}"
                                           data-provide="typeahead" value="{{ ($markup->airline)?$markup->airline:'' }}"
                                           name="airline">
                                    @if($errors->has('airline'))
                                        <p style="color: red">{{ $errors->first('airline') }}</p>
                                    @endif
                                </div>
                            </div>

                        </div>


                        {{--                    sector    --}}
                        <div id="sector-form"
                             style="display: {{ ($errors->has('origin') || ($errors->has('destination')))?'':'none' }};">
                            <div class="form-group row {{ ($errors->has('origin'))?'has-danger':'' }}">
                                <label class="col-sm-12 col-md-2 col-form-label">Origin</label>
                                <div class="col-sm-12 col-md-10">
                                    <input
                                        class="form-control typeahead {{ ($errors->has('origin'))?'form-control-danger':'' }}"
                                        data-provide="typeahead" id="origin-input"
                                        value="{{($markup->origin)?$markup->origin:''}}" name="origin"
                                        placeholder="Origin" type="text">
                                    @if($errors->has('origin'))
                                        <p style="color: red">{{ $errors->first('origin') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row {{ ($errors->has('destination'))?'has-danger':'' }}">
                                <label class="col-sm-12 col-md-2 col-form-label">Destination</label>
                                <div class="col-sm-12 col-md-10">
                                    <input
                                        class="form-control {{ ($errors->has('destination'))?'form-control-danger':'' }} typeahead"
                                        id="destination-input" data-provide="typeahead"
                                        value="{{ ($markup->destination)?$markup->destination:'' }}" name="destination"
                                        placeholder="Destination" type="text">
                                    @if($errors->has('destination'))
                                        <p style="color: red">{{ $errors->first('destination') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>


                        {{--                    sector end  --}}
                        <div id="trip-form" style="display: {{ ($errors->has('pax'))?'':'none' }};">
                            <div class="form-group row {{ ($errors->has('pax'))?'has-danger':'' }}">
                                <label class="col-sm-12 col-md-2 col-form-label">Trip Type</label>
                                <div class="col-sm-12 col-md-10">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="custom-control custom-radio mb-5">
                                                <input type="radio" value="O" id="oneway"
                                                       {{ ($markup->trip_type == 'O')?'checked':'' }} name="triptype"
                                                       class="custom-control-input">
                                                <label for="oneway" class="custom-control-label">One Way</label>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="custom-control custom-radio mb-5">
                                                <input type="radio" id="roundtrip" value="R"
                                                       {{ ($markup->trip_type == 'R')?'checked':'' }} name="triptype"
                                                       class="custom-control-input">
                                                <label for="roundtrip" class="custom-control-label">Round Trip</label>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="custom-control custom-radio mb-5">
                                                <input type="radio" checked id="all" value="A"
                                                       {{ ($markup->trip_type != 'O' && $markup->trip_type != 'R')?'checked':'' }} name="triptype"
                                                       class="custom-control-input">
                                                <label for="all" class="custom-control-label">Both</label>
                                            </div>
                                        </div>

                                    </div>

                                    @if($errors->has('triptype'))
                                        <p style="color: red">{{ $errors->first('triptype') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div id="class-form" style="display: none;">
                            <div class="form-group row">
                                <label class="col-sm-12 col-md-2 col-form-label">Class</label>
                                <div class="col-sm-12 col-md-10">
                                    <div class="row">
                                        <div class="col-1">
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input type="checkbox"
                                                       {{ (isset($markup->class))?(in_array('A',json_decode($markup->class)))?'checked':'':'' }} value="A"
                                                       name="class[]" id="A" class="custom-control-input">
                                                <label for="A" class="custom-control-label">A</label>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input type="checkbox"
                                                       {{ (isset($markup->class))?(in_array('B',json_decode($markup->class)))?'checked':'':'' }}  value="B"
                                                       name="class[]" id="B" class="custom-control-input">
                                                <label for="B" class="custom-control-label">B</label>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input type="checkbox"
                                                       {{ (isset($markup->class))?(in_array('C',json_decode($markup->class)))?'checked':'':'' }} value="C"
                                                       name="class[]" id="C" class="custom-control-input">
                                                <label for="C" class="custom-control-label">C</label>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input type="checkbox"
                                                       {{ (isset($markup->class))?(in_array('D',json_decode($markup->class)))?'checked':'':'' }} value="D"
                                                       name="class[]" id="D" class="custom-control-input">
                                                <label for="D" class="custom-control-label">D</label>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input type="checkbox"
                                                       {{ (isset($markup->class))?(in_array('E',json_decode($markup->class)))?'checked':'':'' }} value="E"
                                                       name="class[]" id="E" class="custom-control-input">
                                                <label for="E" class="custom-control-label">E</label>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input type="checkbox"
                                                       {{ (isset($markup->class))?(in_array('F',json_decode($markup->class)))?'checked':'':'' }} value="F"
                                                       name="class[]" id="F" class="custom-control-input">
                                                <label for="F" class="custom-control-label">F</label>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input type="checkbox"
                                                       {{ (isset($markup->class))?(in_array('G',json_decode($markup->class)))?'checked':'':'' }} value="G"
                                                       name="class[]" id="G" class="custom-control-input">
                                                <label for="G" class="custom-control-label">G</label>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input type="checkbox"
                                                       {{ (isset($markup->class))?(in_array('H',json_decode($markup->class)))?'checked':'':'' }} value="H"
                                                       name="class[]" id="H" class="custom-control-input">
                                                <label for="H" class="custom-control-label">H</label>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input type="checkbox"
                                                       {{ (isset($markup->class))?(in_array('I',json_decode($markup->class)))?'checked':'':'' }} value="I"
                                                       name="class[]" id="I" class="custom-control-input">
                                                <label for="I" class="custom-control-label">I</label>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input type="checkbox"
                                                       {{ (isset($markup->class))?(in_array('J',json_decode($markup->class)))?'checked':'':'' }} value="J"
                                                       name="class[]" id="J" class="custom-control-input">
                                                <label for="J" class="custom-control-label">J</label>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input type="checkbox"
                                                       {{ (isset($markup->class))?(in_array('K',json_decode($markup->class)))?'checked':'':'' }} value="K"
                                                       name="class[]" id="K" class="custom-control-input">
                                                <label for="K" class="custom-control-label">K</label>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input type="checkbox"
                                                       {{ (isset($markup->class))?(in_array('L',json_decode($markup->class)))?'checked':'':'' }} value="L"
                                                       name="class[]" id="L" class="custom-control-input">
                                                <label for="L" class="custom-control-label">L</label>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input type="checkbox"
                                                       {{ (isset($markup->class))?(in_array('M',json_decode($markup->class)))?'checked':'':'' }} value="M"
                                                       name="class[]" id="M" class="custom-control-input">
                                                <label for="M" class="custom-control-label">M</label>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input type="checkbox"
                                                       {{ (isset($markup->class))?(in_array('N',json_decode($markup->class)))?'checked':'':'' }} value="N"
                                                       name="class[]" id="N" class="custom-control-input">
                                                <label for="N" class="custom-control-label">N</label>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input type="checkbox"
                                                       {{ (isset($markup->class))?(in_array('O',json_decode($markup->class)))?'checked':'':'' }} value="O"
                                                       name="class[]" id="O" class="custom-control-input">
                                                <label for="O" class="custom-control-label">O</label>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input type="checkbox" value="P" name="class[]" id="P"
                                                       class="custom-control-input">
                                                <label for="P" class="custom-control-label">P</label>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input type="checkbox"
                                                       {{ (isset($markup->class))?(in_array('Q',json_decode($markup->class)))?'checked':'':'' }} value="Q"
                                                       name="class[]" id="Q" class="custom-control-input">
                                                <label for="Q" class="custom-control-label">Q</label>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input type="checkbox"
                                                       {{ (isset($markup->class))?(in_array('R',json_decode($markup->class)))?'checked':'':'' }} value="R"
                                                       name="class[]" id="R" class="custom-control-input">
                                                <label for="R" class="custom-control-label">R</label>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input type="checkbox"
                                                       {{ (isset($markup->class))?(in_array('S',json_decode($markup->class)))?'checked':'':'' }} value="S"
                                                       name="class[]" id="S" class="custom-control-input">
                                                <label for="S" class="custom-control-label">S</label>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input type="checkbox"
                                                       {{ (isset($markup->class))?(in_array('T',json_decode($markup->class)))?'checked':'':'' }} value="T"
                                                       name="class[]" id="T" class="custom-control-input">
                                                <label for="T" class="custom-control-label">T</label>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input type="checkbox"
                                                       {{ (isset($markup->class))?(in_array('U',json_decode($markup->class)))?'checked':'':'' }} value="U"
                                                       name="class[]" id="U" class="custom-control-input">
                                                <label for="U" class="custom-control-label">U</label>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input type="checkbox"
                                                       {{ (isset($markup->class))?(in_array('V',json_decode($markup->class)))?'checked':'':'' }} value="V"
                                                       name="class[]" id="V" class="custom-control-input">
                                                <label for="V" class="custom-control-label">V</label>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input type="checkbox"
                                                       {{ (isset($markup->class))?(in_array('W',json_decode($markup->class)))?'checked':'':'' }} value="W"
                                                       name="class[]" id="W" class="custom-control-input">
                                                <label for="W" class="custom-control-label">W</label>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input type="checkbox"
                                                       {{ (isset($markup->class))?(in_array('X',json_decode($markup->class)))?'checked':'':'' }} value="X"
                                                       name="class[]" id="X" class="custom-control-input">
                                                <label for="X" class="custom-control-label">X</label>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input type="checkbox"
                                                       {{ (isset($markup->class))?(in_array('Y',json_decode($markup->class)))?'checked':'':'' }} value="Y"
                                                       name="class[]" id="Y" class="custom-control-input">
                                                <label for="Y" class="custom-control-label">Y</label>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="custom-control custom-checkbox mb-5">
                                                <input type="checkbox"
                                                       {{ (isset($markup->class))?(in_array('Z',json_decode($markup->class)))?'checked':'':'' }} value="Z"
                                                       name="class[]" id="Z" class="custom-control-input">
                                                <label for="Z" class="custom-control-label">Z</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div
                            class="form-group row {{ ($errors->has('adtnprmargin')) || ($errors->has('usdmargin'))?'has-danger':'' }}">
                            <label class="col-sm-12 col-md-2 col-form-label">Adult</label>
                            <div class="col-sm-6 col-md-5">
                                <input
                                    class="form-control  {{ ($errors->has('adtnprmargin'))?'form-control-danger':'' }}"
                                    name="adtnprmargin" placeholder="In NPR"
                                    value="{{ $np->adt_calc_type == '+'?'':'-' }}{{ $np->adt_margin }}{{ ($np->adt_amount_type == '0')?'':'%' }}"
                                    type="text">
                                @if($errors->has('adtnprmargin'))
                                    <p style="color: red">{{ $errors->first('adtnprmargin') }}</p>
                                @endif
                            </div>
                            <div class="col-sm-6 col-md-5">
                                <input
                                    class="form-control  {{ ($errors->has('adtusdmargin'))?'form-control-danger':'' }}"
                                    value="{{ $us->adt_calc_type == '+'?'':'-' }}{{ $us->adt_margin }}{{ ($us->adt_amount_type == '0')?'':'%' }}"
                                    name="adtusdmargin" placeholder="In USD" type="text">
                                @if($errors->has('adtusdmargin'))
                                    <p style="color: red">{{ $errors->first('adtusdmargin') }}</p>
                                @endif
                            </div>
                        </div>


                        <div
                            class="form-group row {{ ($errors->has('chdnprmargin')|| $errors->has('chdusdmargin'))?'has-danger':'' }}">
                            <label class="col-sm-12 col-md-2 col-form-label">Child</label>
                            <div class="col-sm-6 col-md-5">
                                <input
                                    class="form-control  {{ ($errors->has('chdnprmargin'))?'form-control-danger':'' }}"
                                    value="{{ $np->chd_calc_type == '+'?'':'-' }}{{ $np->chd_margin }}{{ ($np->chd_amount_type == 0)?'':'%' }}"
                                    name="chdnprmargin" placeholder="In NPR" type="text">
                                @if($errors->has('chdnprmargin'))
                                    <p style="color: red">{{ $errors->first('chdnprmargin') }}</p>
                                @endif
                            </div>
                            <div class="col-sm-6 col-md-5">
                                <input
                                    class="form-control  {{ ($errors->has('chdusdmargin'))?'form-control-danger':'' }}"
                                    value="{{ $us->chd_calc_type == '+'?'':'-' }}{{ $us->chd_margin }}{{ ($us->chd_amount_type == 0)?'':'%' }}"
                                    name="chdusdmargin" placeholder="In USD" type="text">
                                @if($errors->has('chdusdmargin'))
                                    <p style="color: red">{{ $errors->first('chdusdmargin') }}</p>
                                @endif
                            </div>
                        </div>

                        <div
                            class="form-group row {{ ($errors->has('infnprmargin')|| $errors->has('infchdusdmargin'))?'has-danger':'' }}">
                            <label class="col-sm-12 col-md-2 col-form-label">Infant</label>
                            <div class="col-sm-6 col-md-5">
                                <input
                                    class="form-control  {{ ($errors->has('infnprmargin'))?'form-control-danger':'' }}"
                                    value="{{ ($np->inf_calc_type == '+'?'':'-') }}{{ $np->inf_margin }}{{ ($np->inf_amount_type == 0)?'':'%' }}"
                                    name="infnprmargin" placeholder="In NPR" type="text">
                                @if($errors->has('infnprmargin'))
                                    <p style="color: red">{{ $errors->first('infnprmargin') }}</p>
                                @endif
                            </div>
                            <div class="col-sm-6 col-md-5">
                                <input
                                    class="form-control  {{ ($errors->has('infusdmargin'))?'form-control-danger':'' }}"
                                    value="{{ $us->inf_calc_type == '+'?'':'-' }}{{ $us->inf_margin }}{{ ($us->inf_amount_type == 0)?'':'%' }}"
                                    name="infusdmargin" placeholder="In USD" type="text">
                                @if($errors->has('infusdmargin'))
                                    <p style="color: red">{{ $errors->first('infusdmargin') }}</p>
                                @endif
                            </div>
                        </div>

                        <div
                            class="form-group row {{ ($errors->has('stdnprmargin')|| $errors->has('stdusdmargin'))?'has-danger':'' }}">
                            <label class="col-sm-12 col-md-2 col-form-label">Student</label>
                            <div class="col-sm-6 col-md-5">
                                <input
                                    class="form-control  {{ ($errors->has('stdnprmargin'))?'form-control-danger':'' }}"
                                    value="{{ $np->std_calc_type == '+'?'':'-' }}{{ $np->std_margin }}{{ ($np->std_amount_type == 0)?'':'%' }}"
                                    name="stdnprmargin" placeholder="In NPR" type="text">
                                @if($errors->has('stdnprmargin'))
                                    <p style="color: red">{{ $errors->first('stdnprmargin') }}</p>
                                @endif
                            </div>
                            <div class="col-sm-6 col-md-5">
                                <input
                                    class="form-control  {{ ($errors->has('stdusdmargin'))?'form-control-danger':'' }}"
                                    value="{{ $us->std_calc_type == '+'?'':'-' }}{{ $us->std_margin }}{{ ($us->std_amount_type == 0)?'':'%' }}"
                                    name="stdusdmargin" placeholder="In USD" type="text">
                                @if($errors->has('stdusdmargin'))
                                    <p style="color: red">{{ $errors->first('stdusdmargin') }}</p>
                                @endif
                            </div>
                        </div>

                        <div
                            class="form-group row {{ ($errors->has('lbrnprmargin')|| $errors->has('lbrusdmargin'))?'has-danger':'' }}">
                            <label class="col-sm-12 col-md-2 col-form-label">Labour</label>
                            <div class="col-sm-6 col-md-5">
                                <input
                                    class="form-control  {{ ($errors->has('lbrnprmargin'))?'form-control-danger':'' }}"
                                    value="{{ $np->lbr_calc_type == '+'?'':'-' }}{{ $np->lbr_margin }}{{ ($np->lbr_amount_type == 0)?'':'%' }}"
                                    name="lbrnprmargin" placeholder="In NPR" type="text">
                                @if($errors->has('lbrnprmargin'))
                                    <p style="color: red">{{ $errors->first('lbrnprmargin') }}</p>
                                @endif
                            </div>
                            <div class="col-sm-6 col-md-5">
                                <input
                                    class="form-control  {{ ($errors->has('lbrusdmargin'))?'form-control-danger':'' }}"
                                    value="{{ $us->lbr_calc_type == '+'?'':'-' }}{{ $us->lbr_margin }}{{ ($us->lbr_amount_type == 0)?'':'%' }}"
                                    name="lbrusdmargin" placeholder="In USD" type="text">
                                @if($errors->has('lbrusdmargin'))
                                    <p style="color: red">{{ $errors->first('lbrusdmargin') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row {{ ($errors->has('priority'))?'has-danger':'' }}">
                            <label class="col-sm-12 col-md-2 col-form-label">Priority</label>
                            <div class="col-sm-12 col-md-10">
                                <input class="form-control" name="priority" placeholder="Priority for Rule Application"
                                       value="{{ $markup->priority }}"
                                       type="number" {{ ($errors->has('priority'))?'form-control-danger':'' }}>
                                @if($errors->has('priority'))
                                    <p style="color: red">{{ $errors->first('priority') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row {{ ($errors->has('status'))?'has-danger':'' }}">
                            <label class="col-sm-12 col-md-2 col-form-label">Status</label>
                            <div class="col-sm-12 col-md-10">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="custom-control custom-radio mb-5">
                                            <input type="radio" value="1"
                                                   {{ ($markup->status)?'checked':'' }} id="apply" name="status"
                                                   class="custom-control-input">
                                            <label for="apply" class="custom-control-label">Apply</label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="custom-control custom-radio mb-5">
                                            <input type="radio" id="hold" value="0" name="status"
                                                   class="custom-control-input">
                                            <label for="hold" class="custom-control-label">Hold</label>
                                        </div>
                                    </div>


                                </div>

                                @if($errors->has('status'))
                                    <p style="color: red">{{ $errors->first('status') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12 col-md-2 col-form-label"></div>
                            <div class="col-sm-12 col-md-10">
                                <input type="submit" id="add-markup" class="btn btn-block btn-success" value="Update">
                            </div>
                        </div>

                    </form>
                </div>


            </div>
        </div>
    </div>

@endsection
@section('scripts')

    <script>
        $(document).ready(function () {
            if ($('#airline').is(':checked')) {
                $('#airline-form').show();

            } else {
                $('#airline-form').hide();

            }

            $('#airline').on('click', function () {
                if ($(this).is(':checked')) {
                    $('#airline-form').show();

                } else {
                    $('#airline-form').hide();

                }
            });

            if ($('#class').is(':checked')) {
                $('#class-form').show();
            } else {
                $('#class-form').hide();
            }

            $('#class').on('click', function () {
                if ($(this).is(':checked')) {
                    $('#class-form').show();
                } else {
                    $('#class-form').hide();
                }
            });

            //check for sector form
            if ($('#sector').is(':checked')) {
                $('#sector-form').show();

            } else {
                $('#sector-form').hide();
            }
            $('#sector').on('click', function () {
                if ($(this).is(':checked')) {
                    $('#sector-form').show();
                } else {
                    $('#sector-form').hide();
                }
            });

//    check for passenger type form
            if ($('#trip').is(':checked')) {
                $('#trip-form').show();

            } else {
                $('#trip-form').hide();
            }
            $('#trip').on('click', function () {
                if ($(this).is(':checked')) {
                    $('#trip-form').show();
                } else {
                    $('#trip-form').hide();
                }
            });
        });
    </script>

@endsection
