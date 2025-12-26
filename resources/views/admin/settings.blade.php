@extends('layouts.back')
@section('title')
    Update Site Settings
@endsection
@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible  show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(session('warning'))
        <div class="alert alert-danger alert-dismissible  show" role="alert">
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
                    <h3 class="box-title">Site Settings</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form action="{{route('site.update')}}" method="post">
                        @csrf
                        <div class="row">

                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           value="{{ $site->name }}" required>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-8 col-md-8 col-sm-12">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                           value="{{ $site->title }}" required>
                                    @if ($errors->has('title'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="primaryLogo">Primary Logo</label>
                                    <div class="input-group">
                                       <span class="input-group-btn">
                                         <a data-input="pri-thumbnail" data-preview="pri-holder"
                                            class="lfm btn btn-primary">
                                           <i class="fa fa-picture-o"></i> Choose
                                         </a>
                                       </span>
                                        <input id="pri-thumbnail" class="form-control" type="text" name="primaryLogo">
                                    </div>
                                    <img id="pri-holder" style="margin-top:15px;max-height:100px;">
                                    @if ($errors->has('primaryLogo'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('primaryLogo') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="primaryLogo">Secondary Logo</label>
                                    <div class="input-group">
                                       <span class="input-group-btn">
                                         <a data-input="sec-thumbnail" data-preview="sec-holder"
                                            class="lfm btn btn-primary">
                                           <i class="fa fa-picture-o"></i> Choose
                                         </a>
                                       </span>
                                        <input id="sec-thumbnail" class="form-control" type="text" name="secondaryLogo">
                                    </div>
                                    <img id="sec-holder" style="margin-top:15px;max-height:100px;">
                                    @if ($errors->has('secondaryLogo'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('secondaryLogo') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="homePopup">Homepage Popup</label>
                                    <div class="input-group">
                                       <span class="input-group-btn">
                                         <a data-input="home-popup" data-preview="homePopup"
                                            class="lfm btn btn-primary">
                                           <i class="fa fa-picture-o"></i> Choose
                                         </a>
                                       </span>
                                        <input id="home-popup" class="form-control" type="text" name="homePopup">
                                    </div>
                                    <img id="homePopup" style="margin-top:15px;max-height:100px;">
                                    @if ($errors->has('homePopup'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('homePopup') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Show Popup at Homepage</label><br>
                                    <input type="checkbox"
                                           {{ ($site->homepage_popup_status)?'checked':'' }} id="popupStatus"
                                           name="popupStatus">
                                    <label for="popupStatus"
                                           id="statusLabel">{{ ($site->homepage_popup_status)?'Shown':'Hidden' }}</label>
                                    @if ($errors->has('popupStatus'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('popupStatus') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="searchPopup">Searchpage Popup</label>
                                <div class="input-group">
                                       <span class="input-group-btn">
                                         <a data-input="search-popup" data-preview="searchPopup"
                                            class="lfm btn btn-primary">
                                           <i class="fa fa-picture-o"></i> Choose
                                         </a>
                                       </span>
                                    <input id="search-popup" class="form-control" type="text" name="searchPopup">
                                </div>
                                <img id="searchPopup" style="margin-top:15px;max-height:100px;">
                                @if ($errors->has('searchPopup'))
                                    <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('searchPopup') }}</strong>
                                        </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="primaryOffice">Primary Office</label>
                                    <input type="text" class="form-control" id="primaryOffice" name="primaryOffice"
                                           value="{{ $site->primary_office }}" required>
                                    @if ($errors->has('primaryOffice'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('primaryOffice') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="secondaryOffice">Secondary Office</label>
                                    <input type="text" class="form-control" id="secondaryOffice" name="secondaryOffice"
                                           value="{{ $site->secondary_office }}" required>
                                    @if ($errors->has('secondaryOffice'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('secondaryOffice') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="primaryAddress">Primary Address</label>
                                    <input type="text" class="form-control" id="primaryAddress" name="primaryAddress"
                                           value="{{ $site->primary_address }}" required>
                                    @if ($errors->has('primaryAddress'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('primaryAddress') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="secondaryAddress">Secondary Address</label>
                                    <input type="text" class="form-control" id="secondaryAddress"
                                           name="secondaryAddress"
                                           value="{{ $site->secondary_address }}" required>
                                    @if ($errors->has('secondaryAddress'))
                                        <span class="help-block">
                                            <strong
                                                class="text-danger">{{ $errors->first('secondaryAddress') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="primaryContact">Primary Contact</label>
                                    <input type="text" class="form-control" id="primaryContact" name="primaryContact"
                                           value="{{ $site->primary_contact }}" required>
                                    @if ($errors->has('primaryContact'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('primaryContact') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="secondaryContact">Secondary Contact</label>
                                    <input type="text" class="form-control" id="secondaryContact"
                                           name="secondaryContact"
                                           value="{{ $site->secondary_contact }}" required>
                                    @if ($errors->has('secondaryContact'))
                                        <span class="help-block">
                                            <strong
                                                class="text-danger">{{ $errors->first('secondaryContact') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="huntingLine">Hunting Line</label>
                                    <input type="text" class="form-control" id="huntingLine" name="huntingLine"
                                           value="{{ $site->hunting_line }}" required>
                                    @if ($errors->has('huntingLine'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('huntingLine') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="contactEmail">Contact Email</label>
                                    <input type="text" class="form-control" id="contactEmail" name="contactEmail"
                                           value="{{ $site->contact_email }}" required>
                                    @if ($errors->has('contactEmail'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('contactEmail') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="facebook">Facebook</label>
                                    <input type="text" class="form-control" id="facebook" name="facebook"
                                           value="{{ $site->facebook_link }}" required>
                                    @if ($errors->has('facebook'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('facebook') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="twitter">Twitter</label>
                                    <input type="text" class="form-control" id="twitter" name="twitter"
                                           value="{{ $site->twitter_link }}" required>
                                    @if ($errors->has('twitter'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('twitter') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="instagram">Instagram</label>
                                    <input type="text" class="form-control" id="instagram" name="instagram"
                                           value="{{ $site->instagram_link }}" required>
                                    @if ($errors->has('instagram'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('instagram') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="linkedin">Linkedin</label>
                                    <input type="text" class="form-control" id="linkedin" name="linkedin"
                                           value="{{ $site->linkedin_link }}" required>
                                    @if ($errors->has('linkedin'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('linkedin') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Update">
                        </div>

                    </form>
                </div>
            </div>
        </div>


    </div>
@endsection
@section('scripts')
    @include('admin.partials.jquery_validation')

    <script src="{{ asset('/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script>
        $('.lfm').filemanager('image', {prefix: '/admin/filemanager'});
    </script>
    <script>
        $("#popupStatus").on("click", function () {
            if ($(this).is(':checked')) {
                $('#statusLabel').html('Shown');
            } else {
                $('#statusLabel').html("Hidden");
            }
        })
    </script>
@endsection

