<!--Modify Search -->
<div class="collapse" id="modify_search">
    <!-- Search Box -->
    <div class="search-outer b-s-none" style="position:unset;">
        <div class="search-content">
            <form action="{{ route('flight.search') }}" method="post" id="search_box"
                  style="padding: 20px;">
                @csrf
                <div class="row">
                    <div class="col-xs-6">
                        <h3 class="h2" style="margin-top: 0;font-weight: 300; padding-bottom: 0;">Search Flights</h3>
                    </div>
                    <div class="col-xs-6 text-right">
                        <label class="radio-inline"><input type="radio" value="O"
                                                           {{ (!(isset($search->return_date)))?'checked':'' }} name="type"
                                                           id="one-way-radio">One-Way</label>
                        <label class="radio-inline"><input type="radio"
                                                           {{ (isset($search->return_date))?'checked':'' }} value="R"
                                                           name="type" id="two-way-radio">Round
                            Trip</label>
                        <label class="radio-inline"><input type="radio"
                                                           {{ (isset($search->sectors))?'checked':'' }} name="type"
                                                           value="M" id="multi-city-radio">Multi City</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-xs-6">
                        <div class="form-group">
                            <label for="dep_from">From</label>
                            <input type="text" name="departure" autocomplete="off" id="dep_from"
                                   value="{{ help_getAirportFromCode($search->departure) }}" placeholder="Leaving From"
                                   class="form-control typeahead" required>
                            @if($errors->has('departure'))
                                <span class="error">
                                {{ $errors->first('departure') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-xs-6">
                        <div class="form-group">
                            <label for="arr_to">To</label>
                            <input type="text" name="destination" autocomplete="off" id="arr_to" placeholder="Going To"
                                   value="{{ help_getAirportFromCode($search->destination) }}"
                                   class="form-control typeahead" required>
                            @if($errors->has('destination'))
                                <span class="error">
                                {{ $errors->first('destination') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-xs-6">
                        <div class="form-group">
                            <label for="arr_to">Departure Date</label>
                            <input type="text" name="flightdate" id="dep_date" placeholder="Departing"
                                   value="{{ $search->flight_date->format('Y-m-d') }}"
                                   class="form-control" autocomplete="off" required>
                            @if($errors->has('flightdate'))
                                <span class="error">
                                {{ $errors->first('flightdate') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-xs-6 {{ (isset($search->return_date))?'':'hide' }}"
                         id="ret_date_div">
                        <div class="form-group">
                            <label for="arr_to">Return Date</label>
                            <input type="text" name="returndate" id="ret_date" placeholder="Returning"
                                   value="{{ (isset($search->return_date))?$search->return_date->format('Y-m-d'):'' }}"
                                   class="form-control" autocomplete="off" readonly>
                            @if($errors->has('returndate'))
                                <span class="error">
                                {{ $errors->first('returndate') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-xs-6">
                        <div class="form-group">
                            <label for="arr_to">Nationality</label>
                            <select name="nationality" id="nationality" class="form-control" required>
                                <option value="" hidden selected disabled>Nationality</option>
                                <option value="NP" {{ ($search->nationality == 'NP')?'selected':'' }}>Nepali</option>
                                <option value="IN" {{ ($search->nationality == 'IN')?'selected':'' }}>Indian</option>
                                <option value="US" {{ ($search->nationality == 'US')?'selected':'' }}>Others</option>
                            </select>
                            @if($errors->has('nationality'))
                                <span class="error">
                                            {{ $errors->first('nationality') }}
                                        </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-12 {{ (isset($search->sectors))?'':'hide' }} parent-multi-city-class"
                         id="parent-multi-city"
                         style="margin-bottom: 10px;">
                        <div class="padd-0 multi-city-area" id="multi-city-input" style="margin-top:15px;">


                            <div class="row padd-0">

                                <div class="col-md-4 col-xs-6">
                                    <label for="multi_from1">From</label>
                                    <input type="text" class="form-control takeoff typeahead" id="multi_from1"
                                           autocomplete="off" placeholder="From" name="int_multi_from[]">
                                </div>
                                <div class="col-md-4 col-xs-6">
                                    <label for="multi_to1">To</label>
                                    <input type="text" class="form-control landing typeahead" autocomplete="off"
                                           onblur="valueTransfer(this)" id="multi_to1" placeholder="To"
                                           name="int_multi_to[]">
                                </div>
                                <div class="col-md-4 col-xs-6">
                                    <label for="dep1">Departure</label>
                                    <input placeholder="Departure" class="form-control datepicker" id="dep1"
                                           type="text" name="int_multi_departure[]" autocomplete="off">
                                </div>
                            </div>


                        </div>
                        <div class="multi-city-area hide" id="multi-city-input1" style="margin-top:15px;">
                            <div class="row">
                                <div style=" margin: 0 15px; margin-bottom: 5px;
                                            border-bottom: 1px solid white;">
                                    <strong></strong>
                                    <button type="button" class="close" aria-label="Close">
                                            <span aria-hidden="true" class="pos-abs close-button-multi-city"
                                                  id="multi-city-close-button" onclick="hideMultiCity(this)"
                                                  style="color:black;">&times;</span>
                                    </button>
                                </div>
                            </div>

                            <div class="row padd-0">

                                <div class="col-md-4 col-xs-6">
                                    <label for="multi_from2">From</label>
                                    <input type="text" class="form-control takeoff typeahead" autocomplete="off"
                                           placeholder="From" id="multi_from2" name="int_multi_from[]">
                                </div>
                                <div class="col-md-4 col-xs-6">
                                    <label for="multi_to2">To</label>
                                    <input type="text" class="form-control landing typeahead" autocomplete="off"
                                           onblur="valueTransfer(this)" placeholder="To" name="int_multi_to[]"
                                           id="multi_to2">
                                </div>
                                <div class="col-md-4 col-xs-6">
                                    <label for="dep2">Departure</label>
                                    <input placeholder="Departure" class="form-control datepicker" id="dep2"
                                           type="text" autocomplete="off" name="int_multi_departure[]">
                                </div>
                            </div>
                        </div>
                        <div class="multi-city-area hide" id="multi-city-input2" style="margin-top:15px;">
                            <div class="row">
                                <div style="margin: 0 15px; margin-bottom: 5px;
                                            border-bottom: 1px solid white;">
                                    <strong></strong>
                                    <button type="button" class="close" aria-label="Close">
                                            <span aria-hidden="true" class="pos-abs close-button-multi-city"
                                                  id="multi-city-close-button" onclick="hideMultiCity(this)"
                                                  style="color:black;">&times;</span>
                                    </button>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-4 col-xs-6">
                                    <label for="multi_from3">From</label>
                                    <input type="text" class="form-control takeoff typeahead" autocomplete="off"
                                           placeholder="From" id="multi_from3" name="int_multi_from[]">
                                </div>
                                <div class="col-md-4 col-xs-6">
                                    <label for="multi_to3">To</label>
                                    <input type="text" class="form-control landing typeahead" autocomplete="off"
                                           onblur="valueTransfer(this)" placeholder="To" id="multi_to3"
                                           name="int_multi_to[]">
                                </div>
                                <div class="col-lg-4 col-md-4 col-xs-6">
                                    <label for="dep3">Departure</label>
                                    <input placeholder="Departure" class="form-control datepicker" id="dep3"
                                           type="text" autocomplete="off" name="int_multi_departure[]">
                                </div>
                            </div>
                        </div>
                        <div class="multi-city-area hide" id="multi-city-input3" style="margin-top:15px;">
                            <div class="row">
                                <div style="margin: 0 15px; margin-bottom: 5px;
                                            border-bottom: 1px solid white;">
                                    <strong></strong>
                                    <button type="button" class="close" aria-label="Close">
                                            <span aria-hidden="true" class="pos-abs close-button-multi-city"
                                                  id="multi-city-close-button" onclick="hideMultiCity(this)"
                                                  style="color:black;">&times;</span>
                                    </button>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-4 col-xs-6">
                                    <label for="multi_from4">From</label>
                                    <input type="text" class="form-control takeoff typeahead" autocomplete="off"
                                           placeholder="From" id="multi_from4" name="int_multi_from[]">
                                </div>
                                <div class="col-md-4 col-xs-6">
                                    <label for="multi_to4">To</label>
                                    <input type="text" class="form-control landing typeahead" autocomplete="off"
                                           onblur="valueTransfer(this)" placeholder="To" id="multi_to4"
                                           name="int_multi_to[]">
                                </div>
                                <div class="col-md-4 col-xs-6">
                                    <label for="dep4">Departure</label>
                                    <input placeholder="Departure" class="form-control calendar" id="dep4"
                                           type="text" autocomplete="off" name="int_multi_departure[]">
                                </div>
                            </div>
                        </div>

                        <div class="padd-0 multi-city-area" style="margin-top:15px;">

                            <div class="row">
                                <div class="padd-5p-t padd-5p-b" style="margin-bottom: 5px;">
                                    <strong></strong>
                                    <button type="button" class="close add-more" onclick="duplicate()"
                                            aria-label="Close">
                                        <small>Add Sector</small>
                                        <span aria-hidden="true" class="pos-abs close-button-multi-city"
                                              id="multi-city-close-button" style="color:black;">+</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-2 col-md-3 col-xs-6">
                        <div class="form-group">
                            <label for="adult_no">
                                <small>Adult(12+ years)</small>
                            </label>
                            <select name="flightadults" id="adult_no" class="form-control" required>
                                <option value="1" {{ ($search->adults == 1)?'selected':'' }}>1</option>
                                <option value="2" {{ ($search->adults == 2)?'selected':'' }}>2</option>
                                <option value="3" {{ ($search->adults == 3)?'selected':'' }}>3</option>
                                <option value="4" {{ ($search->adults == 4)?'selected':'' }}>4</option>
                                <option value="5" {{ ($search->adults == 5)?'selected':'' }}>5</option>
                                <option value="6" {{ ($search->adults == 6)?'selected':'' }}>6</option>
                                <option value="7" {{ ($search->adults == 7)?'selected':'' }}>7</option>
                                <option value="8" {{ ($search->adults == 8)?'selected':'' }}>8</option>
                                <option value="9" {{ ($search->adults == 9)?'selected':'' }}>9</option>
                            </select>
                            @if($errors->has('flightadults'))
                                <span class="error">
                                {{ $errors->first('flightadults') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-xs-6">
                        <div class="form-group">
                            <label for="child_no">
                                <small>Child(2-12years)</small>
                            </label>
                            <select name="flightchilds" id="child_no" class="form-control">
                                <option value="0" {{ ($search->childs == 0)?'selected':'' }}>0</option>
                                <option value="1" {{ ($search->childs == 1)?'selected':'' }}>1</option>
                                <option value="2" {{ ($search->childs == 2)?'selected':'' }}>2</option>
                                <option value="3" {{ ($search->childs == 3)?'selected':'' }}>3</option>
                                <option value="4" {{ ($search->childs == 4)?'selected':'' }}>4</option>
                                <option value="5" {{ ($search->childs == 5)?'selected':'' }}>5</option>
                                <option value="6" {{ ($search->childs == 6)?'selected':'' }}>6</option>
                                <option value="7" {{ ($search->childs == 7)?'selected':'' }}>7</option>
                                <option value="8" {{ ($search->childs == 8)?'selected':'' }}>8</option>
                            </select>
                            @if($errors->has('flightchilds'))
                                <span class="error">
                                {{ $errors->first('flightchilds') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-xs-6">
                        <div class="form-group">
                            <label for="infant_no">
                                <small>Infant(0-2years)</small>
                            </label>
                            <select name="flightinfants" id="infant_no" class="form-control">
                                <option value="0" {{ ($search->infants == 0)?'selected':'' }}>0</option>
                                <option value="1" {{ ($search->infants == 1)?'selected':'' }}>1</option>
                                <option value="2" {{ ($search->infants == 2)?'selected':'' }}>2</option>
                                <option value="3" {{ ($search->infants == 3)?'selected':'' }}>3</option>
                                <option value="4" {{ ($search->infants == 4)?'selected':'' }}>4</option>
                            </select>
                            @if($errors->has('flightinfants'))
                                <span class="error">
                                {{ $errors->first('flightinfants') }}
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-xs-6">
                        <div class="form-group">
                            <label for="class_type">
                                <small>Class</small>
                            </label>
                            <select name="class" id="class_type" class="form-control" required>
                                <option value="Economy">Economy</option>
                                <option value="First Class">First Class</option>
                                <option value="Business">Business</option>
                            </select>
                            @if($errors->has('class'))
                                <span class="error">
                                            {{ $errors->first('class') }}
                                        </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-xs-6">
                        <div class="form-group">
                            <input type="submit" name="submit" id="homepage_search_btn" class="btn btn-blue"
                                   value="SEARCH"
                                   style="display: block;width: 100%;margin-top: 27px;">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Search Box Ends -->
</div>
