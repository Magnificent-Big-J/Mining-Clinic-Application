<div class="profile-sidebar">
    <div class="widget-profile pro-widget-content">
        <div class="profile-info-widget">
            <a href="#" class="booking-doc-img">
                <img src="{{asset('/avatar/doctor-avatar.png')}}" alt="User Image">
            </a>
            <div class="profile-det-info">
                <h3>{{ $user->title  }}. {{ $user->first_name  }} {{ $user->last_name  }}</h3>

                <div class="patient-details">
                    <h5 class="mb-0">{{ $user->doctor->getSpecialization() }}</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="dashboard-widget">
        <nav class="dashboard-menu">
            <ul>
                <li>
                    <a href="/">
                        <i class="fas fa-columns"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="active">
                    <a href="{{route('doctor.new.appointments')}}">
                        <i class="fas fa-calendar-check"></i>
                        <span>Appointments</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('doctor.profile.settings')}}">
                        <i class="fas fa-user-cog"></i>
                        <span>Profile Settings</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('doctor.all.appointments')}}">
                        <i class="fas fa-calendar-check"></i>
                        <span>Appointments History</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('doctor.referrals.index')}}">
                        <i class="fa fa-book-reader"></i>
                        <span>Referrals</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('doctor.my.referrals')}}">
                        <i class="fa fa-book-open"></i>
                        <span>My Referrals</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</div>
