<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main</span>
                </li>
                <li>
                    <a href="{{route('home')}}"><i class="fe fe-home"></i> <span>Dashboard</span></a>
                </li>
                <li>
                    <a href="{{route('admin.appointments.index')}}"><i class="fe fe-layout"></i> <span>Appointments</span></a>
                </li>
                <li>
                    <a href="{{route('admin.specialists.index')}}"><i class="fe fe-users"></i> <span>Specialities</span></a>
                </li>
                <li>
                    <a href="{{route('admin.doctors.index')}}"><i class="fe fe-user-plus"></i> <span>Doctors</span></a>
                </li>
                <li>
                    <a href="{{route('admin.patients.index')}}"><i class="fe fe-user"></i> <span>Patients</span></a>
                </li>
                <li>
                    <a href="{{route('admin.question.index')}}"><i class="fe fe-user"></i> <span>Questionnaires</span></a>
                </li>
                <li class="submenu">
                    <a href="#" class="active"><i class="fe fe-document"></i> <span> Reports</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="{{route('admin.historic-appointment.index')}}">Appointments</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</div>
