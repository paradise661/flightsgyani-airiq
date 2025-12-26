<header class="main-header">
    <a href="{{ URL::to('/') }}" class="logo">
        <span class="logo-mini"><b>F</b>G</span>
        <span class="logo-lg"><b>Flights</b> Gyani</span>
    </a>
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <!-- Navbar Right Menu -->

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li>
                    <a href="{{ route('v2.admin.dashboard') }}">Switch to V2</a>
                </li>
                <!-- Notifications: style can be found in dropdown.less -->
                <li class="dropdown messages-menu ">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                        <i class="fa fa-bell"></i>
                        <span class="label label-success">{{ Auth::user()->unreadnotifications()->count() }}</span>
                    </a>
                    <ul class="dropdown-menu" style="width: 400px;">
                        <li class="header">You have {{ Auth::user()->unreadnotifications()->count() }} unread
                            notifications
                        </li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                @foreach (Auth::user()->unreadnotifications()->get() as $notification)
                                    <li id="{{ $notification->id }}" style="background-color:#befde2;position:relative">
                                        <!-- start message -->
                                        <a class="single-notification" href="{{ $notification->data['url'] }}">
                                            <div class="pull-left">
                                                <img src="{{ $notification->data['image'] }}" class="img-circle">
                                            </div>
                                            <h4>
                                                {{ $notification->data['title'] }}
                                                <small><i class="fa fa-clock-o"></i>
                                                    {{ $notification->created_at->diffForHumans() }}
                                                    s</small>
                                            </h4>
                                            <p>{{ $notification->data['data'] }}</p>
                                        </a>
                                    </li>
                                @endforeach
                                @foreach (Auth::user()->readnotifications()->get() as $notification)
                                    <li id="{{ $notification->id }}"
                                        style="background-color:#ffffff;position: relative;"><!-- start message -->
                                        <a class="single-notification" href="{{ $notification->data['url'] }}">
                                            <div class="pull-left">
                                                <img src="{{ $notification->data['image'] }}" class="img-circle">
                                            </div>
                                            <h4>
                                                {{ $notification->data['title'] }}
                                                <small><i class="fa fa-clock-o"></i>
                                                    {{ $notification->created_at->diffForHumans() }}
                                                    s</small>
                                            </h4>
                                            <p>{{ $notification->data['data'] }}</p>
                                        </a>
                                    </li>
                                @endforeach
                                <!-- end message -->

                            </ul>
                        </li>
                        <li class="footer"><a href="#">Mark all as read.</a></li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('/frontend/images/avatar.png') }}" class="user-image" alt="User Image">
                        <span class="hidden-xs">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{ asset('/frontend/images/avatar.png') }}" class="img-circle" alt="User Image">

                            <p>
                                {{ Auth::user()->name }}

                            </p>
                        </li>
                        <!-- Menu Body -->

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="#" class="btn btn-default btn-flat"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">Sign
                                    out</a>
                                <form action="{{ route('logout') }}" method="post" id="logout-form"
                                    style="display: none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
            </ul>
        </div>
    </nav>
</header>
