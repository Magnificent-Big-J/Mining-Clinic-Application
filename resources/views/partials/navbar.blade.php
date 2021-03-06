<div class="header">

    <!-- Logo -->
    <div class="header-left mr-5">
        <a href="{{route('home')}}" class="logo">
            <img src="/invoke.png" alt="Logo">
        </a>
        <a href="{{route('home')}}" class="logo logo-small">
            <img src="/invoke.png" alt="Logo" width="30" height="30">
        </a>
    </div>
    <!-- /Logo -->

    <a href="javascript:void(0);" id="toggle_btn">
        <i class="fe fe-text-align-left"></i>
    </a>


    <!-- Mobile Menu Toggle -->
    <a class="mobile_btn" id="ml-4 mobile_btn">
        <i class="fa fa-bars"></i>
    </a>
    <!-- /Mobile Menu Toggle -->

    <!-- Header Right Menu -->
    <ul class="nav user-menu">

        <!-- Notifications -->
{{--        <li class="nav-item dropdown noti-dropdown">--}}
{{--            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">--}}
{{--                <i class="fe fe-bell"></i> <span class="badge badge-pill">3</span>--}}
{{--            </a>--}}
{{--            <div class="dropdown-menu notifications">--}}
{{--                <div class="topnav-dropdown-header">--}}
{{--                    <span class="notification-title">Notifications</span>--}}
{{--                    <a href="javascript:void(0)" class="clear-noti"> Clear All </a>--}}
{{--                </div>--}}
{{--                <div class="noti-content">--}}
{{--                    <ul class="notification-list">--}}
{{--                        <li class="notification-message">--}}
{{--                            <a href="#">--}}
{{--                                <div class="media">--}}
{{--												<span class="avatar avatar-sm">--}}
{{--													<img class="avatar-img rounded-circle" alt="User Image" src="{{asset('/avatar/generic-avatar.png')}}">--}}
{{--												</span>--}}
{{--                                    <div class="media-body">--}}
{{--                                        <p class="noti-details"><span class="noti-title">Dr. Ruby Perrin</span> Schedule <span class="noti-title">her appointment</span></p>--}}
{{--                                        <p class="noti-time"><span class="notification-time">4 mins ago</span></p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--                <div class="topnav-dropdown-footer">--}}
{{--                    <a href="#">View all Notifications</a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </li>--}}
        <!-- /Notifications -->

        <!-- User Menu -->
        <li class="nav-item dropdown has-arrow">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                <span class="user-img"><img class="rounded-circle" src="{{asset('/avatar/generic-avatar.png')}}" width="31" alt="Ryan Taylor"></span>
            </a>
            <div class="dropdown-menu">
                <div class="user-header">
                    <div class="avatar avatar-sm">
                        <img src="{{asset('/avatar/generic-avatar.png')}}" alt="User Image" class="avatar-img rounded-circle">
                    </div>
                    <div class="user-text">
                        <h6>{{ $user->first_name }} {{ $user->last_name }}</h6>
                        <p class="text-muted mb-0">Administrator</p>
                    </div>
                </div>
                <a class="dropdown-item" href="{{route('admin.user.profile')}}">My Profile</a>

                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="material-icons">exit_to_app</i>
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
        <!-- /User Menu -->

    </ul>
    <!-- /Header Right Menu -->

</div>
