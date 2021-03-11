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
                    <a href="{{route('admin.patients.index')}}"><i class="fe fe-user"></i> <span>Patients</span></a>
                </li>
                <li>
                    <a href="{{route('admin.specialists.index')}}"><i class="fe fe-users"></i> <span>Specialities</span></a>
                </li>
                <li class="submenu">
                    <a href="#" ><i class="fe fe-layout"></i> <span> Mining Clinics</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="{{route('admin.clinic.index')}}">Clinics</a></li>
                        <li><a href="{{route('admin.specific.clinic.product')}}">Clinic Product</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{route('admin.screeningQuestionnaire.index')}}"><i class="fe fe-user"></i> <span>Questionnaires</span></a>
                </li>
                <li class="submenu">
                    <a href="#" ><i class="fe fe-bookmark"></i> <span> Consultations</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="{{route('admin.consultation-category.index')}}">Consultation Categories</a></li>
                        <li><a href="{{route('admin.consultation.index')}}">Consultation</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{route('admin.doctors.index')}}"><i class="fe fe-user-plus"></i> <span>Doctors</span></a>
                </li>
                <li class="submenu">
                    <a href="#" ><i class="fe fe-feed"></i> <span> Product Management</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="{{route('admin.product-category.index')}}">Product Categories</a></li>
                        <li><a href="{{route('admin.product.index')}}">Products</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{route('admin.appointments.index')}}"><i class="fe fe-layout"></i> <span>Appointments</span></a>
                </li>

                <li>
                    <a href="{{route('admin.users.index')}}"><i class="fe fe-users"></i> <span>Users</span></a>
                </li>
                <li class="submenu">
                    <a href="#"><i class="fe fe-document"></i> <span> Reports</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="{{route('admin.historic-appointment.index')}}">Appointments</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</div>
