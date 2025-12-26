@php
$route = Request::route()->getName();
@endphp

<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu tree" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="{{ $route == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-folder"></i> <span>Flights <span class="badge badge-secondary"></span> </span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class=""><a href="{{ route('sabre.details') }}"><i
                                class="fa fa-angle-double-right"></i>Sabre</a></li>
                    <li class=""><a href="{{ route('airport.index') }}"><i
                                class="fa fa-angle-double-right"></i>Airports</a>
                    </li>
                    <li class=""><a href="{{ route('airline.index') }}"><i
                                class="fa fa-angle-double-right"></i>Airlines
                        </a></li>
                    <li class=""><a href="{{ route('bspcommission.index') }}"><i
                                class="fa fa-angle-double-right"></i>BSP
                            Commissions</a></li>
                    <li class=""><a href="{{ route('markup.index') }}"><i
                                class="fa fa-angle-double-right"></i>Markups</a></li>
                    <li class=""><a href="{{ route('admin.flight.searchlog') }}"><i
                                class="fa fa-angle-double-right"></i>Search Log</a></li>
                    <li class=""><a href="{{ route('admin.flight.bookings') }}"><i
                                class="fa fa-angle-double-right"></i>Bookings</a>
                    </li>
                    {{--                    <li class=""><a href="{{ route('admin.group.bookings') }}"><i class="fa fa-angle-double-right"></i>Group --}}
                    {{--                            Booking Requests</a></li> --}}
                    {{--                    <li class=""><a href="{{ route('admin.flight.sales.report') }}"><i --}}
                    {{--                                class="fa fa-angle-double-right"></i>Daily Sales Report</a></li> --}}
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-folder"></i> <span>Domestic Flights <span class="badge badge-secondary"></span> </span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class=""><a href="{{ route('admin.domestic.flight.bookings') }}"><i
                                class="fa fa-angle-double-right"></i>Bookings</a>
                    </li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-folder"></i> <span>Tour Packages <span class="badge badge-secondary"></span> </span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $route == 'category.index' ? 'active' : '' }}">
                        <a href="{{ route('category.index') }}"><i
                                class="fa fa-angle-double-right"></i><span>Categories</span></a>
                    </li>
                    <li class="{{ $route == 'package.index' ? 'active' : '' }}">
                        <a href="{{ route('package.index') }}"><i
                                class="fa fa-angle-double-right"></i><span>Packages</span></a>
                    </li>

                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-folder"></i> <span>Pages <span class="badge badge-secondary"></span> </span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $route == 'contact-us.index' ? 'active' : '' }}">
                        <a href="{{ route('contact-us.index') }}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Contact Us</span>
                        </a>
                    </li>
                    <li class="{{ $route == 'about-us.index' ? 'active' : '' }}">
                        <a href="{{ route('about-us.index') }}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>About Us</span>
                        </a>
                    </li>
                    <li class="{{ $route == 'team.index' ? 'active' : '' }}">
                        <a href="{{ route('team.index') }}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Our Team</span>
                        </a>
                    </li>
                    <li class="{{ $route == 'terms.index' ? 'active' : '' }}">
                        <a href="{{ route('terms.index') }}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Terms & Conditions</span>
                        </a>
                    </li>
                    <li class="{{ $route == 'policy.index' ? 'active' : '' }}">
                        <a href="{{ route('policy.index') }}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Privacy Policy</span>
                        </a>
                    </li>
                    <li class="{{ $route == 'faq.index' ? 'active' : '' }}">
                        <a href="{{ route('faq.index') }}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>FAQ</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-folder"></i> <span>User Management <span class="badge badge-secondary"></span>
                    </span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $route == 'user.list' ? 'active' : '' }}">
                        <a href="{{ route('user.list') }}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Users</span>
                        </a>
                    </li>
                    <li class="{{ $route == 'role.index' ? 'active' : '' }}">
                        <a href="{{ route('role.index') }}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>User Roles</span>
                        </a>
                    </li>
                    <li class="{{ $route == 'user.assignrole' ? 'active' : '' }}">
                        <a href="{{ route('user.assignrole') }}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Assign User->Role</span>
                        </a>
                    </li>

                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-folder"></i> <span>Settings <span class="badge badge-secondary"></span> </span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $route == 'slider.index' ? 'active' : '' }}">
                        <a href="{{ route('slider.index') }}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Homepage Slider</span>
                        </a>
                    </li>
                    <li class="{{ $route == 'site' ? 'active' : '' }}">
                        <a href="{{ route('site') }}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Site Settings</span>
                        </a>
                    </li>
                    <li class="{{ $route == 'filemanager' ? 'active' : '' }}">
                        <a href="{{ route('filemanager') }}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>File Manager</span>
                        </a>
                    </li>

                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-folder"></i> <span>Payment Gateways<span class="badge badge-secondary"></span>
                    </span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $route == 'ips.connect' ? 'active' : '' }}">
                        <a href="{{ route('ips.connect') }}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>connectIPS</span>
                        </a>
                    </li>
                    <li class="{{ $route == 'khalti' ? 'active' : '' }}">
                        <a href="{{ route('khalti') }}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>Khalti</span>
                        </a>
                    </li>
                    <li class="{{ $route == 'NPSOnePG' ? 'active' : '' }}">
                        <a href="{{ route('NPSOnePG') }}">
                            <i class="fa fa-angle-double-right"></i>
                            <span>NPSOnePG</span>
                        </a>
                    </li>

                </ul>
            </li>

            <li class="{{ $route == 'partner.index' ? 'active' : '' }}">
                <a href="{{ route('partner.index') }}">
                    <i class="fa fa-user"></i>
                    <span>Sister Companies</span>
                </a>
            </li>
            <li class="{{ $route == 'blog.index' ? 'active' : '' }}">
                <a href="{{ route('blog.index') }}">
                    <i class="fa fa-user"></i>
                    <span>Blogs</span>
                </a>
            </li>
            <li class="{{ $route == 'travel-agency.index' ? 'active' : '' }}">
                <a href="{{ route('travel-agency.index') }}">
                    <i class="fa fa-user"></i>
                    <span>Reviews</span>
                </a>
            </li>

            <li class="{{ $route == 'whatwedo.index' ? 'active' : '' }}">
                <a href="{{ route('whatwedo.index') }}">
                    <i class="fa fa-user"></i>
                    <span>What We Do</span>
                </a>
            </li>
            <li class="{{ $route == 'comment.index' ? 'active' : '' }}">
                <a href="{{ route('comment.index') }}">
                    <i class="fa fa-user"></i>
                    <span>Comment</span>
                </a>
            </li>
            <li
                class="treeview {{ $route == 'inquery.index' ||
                $route == 'downloaded.index' ||
                $route == 'emailed.index' ||
                $route == 'booking.index'
                    ? 'active'
                    : '' }}">
                <a href="#">
                    <i class="fa fa-folder"></i> <span>Inquery Detail <span
                            class="badge badge-secondary">{{ $bookingCount + $inqueryCount }}</span> </span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $route == 'booking.index' ? 'active' : '' }}"><a
                            href="{{ route('booking.index') }}"><i class="fa fa-angle-double-right"></i>Booking <span
                                class="badge badge-secondary pull-right">{{ $bookingCount }}</span></a></li>
                    <li class="{{ $route == 'inquery.index' ? 'active' : '' }}"><a
                            href="{{ route('inquery.index') }}"><i class="fa fa-angle-double-right"></i>Inquery <span
                                class="badge badge-secondary pull-right">{{ $inqueryCount }}</span></a></li>
                    <li class="{{ $route == 'downloaded.index' ? 'active' : '' }}"><a
                            href="{{ route('downloaded.index') }}"><i class="fa fa-angle-double-right"></i>Downloaded
                        </a></li>
                    <li class="{{ $route == 'emailed.index' ? 'active' : '' }}"><a
                            href="{{ route('emailed.index') }}"><i class="fa fa-angle-double-right"></i>Emailed</a>
                    </li>
                </ul>
            </li>
            </li>
        </ul>
    </section>
</aside>
