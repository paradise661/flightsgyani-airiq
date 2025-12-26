@if(session('success_msg'))
    <div class="alert fade in alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Success!</h4>
        {{ session('success_msg') }}
    </div>
@elseif(session('error_msg'))
    <div class="alert fade in alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> Error!</h4>
        {{ session('error_msg') }}
    </div>
@elseif(session('warning_msg'))
    <div class="alert fade in alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-warning"></i> Warning!</h4>
        {{ session('warning_msg') }}
    </div>
@elseif(session('info_msg'))
    <div class="alert fade in alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-info"></i> Info!</h4>
        {{ session('info_msg') }}
    </div>
@endif

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&chi;</button>
        <ul class="list list-group">
            @foreach ($errors->all() as $error)
                <li class="error text text-white text-bold" style="list-style:none;"><i class="fa fa-times"></i>
                    Error: {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (session('success'))
    <div class="alert alert-info alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&chi;</button>
        {{session('success')}}
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&chi;</button>
        {{session('error')}}
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
