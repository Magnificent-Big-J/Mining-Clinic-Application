@extends('layouts.admindatatables')
@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Doctors Management</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Doctor Profile</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class="row">
            <div class="col-md-12">
                <div class="profile-header">
                    <div class="row align-items-center">
                        <div class="col-auto profile-image">
                            <a href="#">
                                <img class="rounded-circle" alt="User Image" src="{{$doctor->user->profile}}">
                            </a>
                        </div>
                        <div class="col ml-md-n2 profile-user-info">
                            <h4 class="user-name mb-0">{{$doctor->user->full_names}}</h4>
                            <h6 class="text-muted">{{$doctor->email}}</h6>
                            <div class="user-Location"><i class="fa fa-map-marker"></i> {{$doctor->address}}</div>
                        </div>

                    </div>
                </div>
                <div class="profile-menu">
                    <ul class="nav nav-tabs nav-tabs-solid">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#per_details_tab">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#password_tab">Password</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content profile-tab-cont">

                    <!-- Personal Details Tab -->
                    <div class="tab-pane fade show active" id="per_details_tab">

                        <div class="card">
                            <div class="card-header">
                                <a class="edit-link float-right" href="{{route('admin.doctors.edit', $doctor->id)}}" ><i class="fa fa-edit mr-1"></i>Edit</a>
                            </div>
                            <div class="card-body">
                                <!-- Personal Details -->
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title d-flex justify-content-between">
                                                    <span>Doctor Details</span>

                                                </h5>
                                                <div class="row">
                                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Specialities</p>
                                                    <ul >
                                                        @foreach($doctor->specialists as $specialist)
                                                            <li >{{$specialist->name}}</li>
                                                        @endforeach
                                                    </ul>

                                                </div>
                                                @if ($doctor->has_entity === \App\Models\Doctor::HAS_ENTITY_STATE)
                                                    <div class="row">
                                                        <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Entity Name</p>
                                                        <p class="col-sm-10">{{$doctor->doctorEntity->entity_name}}</p>
                                                    </div>
                                                    <div class="row">
                                                        <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Entity Status</p>
                                                        <p class="col-sm-10 text-uppercase">{{$doctor->doctorEntity->entity_status}}</p>
                                                    </div>
                                                @endif
                                                <div class="row">
                                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Practice Number</p>
                                                    <p class="col-sm-10">{{$doctor->practice_number}}</p>
                                                </div>
                                                <div class="row">
                                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Registration Number</p>
                                                    <p class="col-sm-10">{{$doctor->reg_number}}</p>
                                                </div>
                                                <div class="row">
                                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Telephone Number</p>
                                                    <p class="col-sm-10">{{$doctor->tele_number}}</p>
                                                </div>
                                                <div class="row">
                                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Fax Number</p>
                                                    <p class="col-sm-10">{{$doctor->fax}}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Edit Details Modal -->
                                        <div class="modal fade" id="edit_personal_details" aria-hidden="true" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document" >
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Personal Details</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form>
                                                            <div class="row form-row">
                                                                <div class="col-12 col-sm-6">
                                                                    <div class="form-group">
                                                                        <label>First Name</label>
                                                                        <input type="text" class="form-control" value="John">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-sm-6">
                                                                    <div class="form-group">
                                                                        <label>Last Name</label>
                                                                        <input type="text"  class="form-control" value="Doe">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label>Date of Birth</label>
                                                                        <div class="cal-icon">
                                                                            <input type="text" class="form-control" value="24-07-1983">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-sm-6">
                                                                    <div class="form-group">
                                                                        <label>Email ID</label>
                                                                        <input type="email" class="form-control" value="johndoe@example.com">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-sm-6">
                                                                    <div class="form-group">
                                                                        <label>Mobile</label>
                                                                        <input type="text" value="+1 202-555-0125" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <h5 class="form-title"><span>Address</span></h5>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label>Address</label>
                                                                        <input type="text" class="form-control" value="4663 Agriculture Lane">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-sm-6">
                                                                    <div class="form-group">
                                                                        <label>City</label>
                                                                        <input type="text" class="form-control" value="Miami">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-sm-6">
                                                                    <div class="form-group">
                                                                        <label>State</label>
                                                                        <input type="text" class="form-control" value="Florida">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-sm-6">
                                                                    <div class="form-group">
                                                                        <label>Zip Code</label>
                                                                        <input type="text" class="form-control" value="22434">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-sm-6">
                                                                    <div class="form-group">
                                                                        <label>Country</label>
                                                                        <input type="text" class="form-control" value="United States">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Edit Details Modal -->

                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title d-flex justify-content-between">
                                                    <span>Address Information</span>
                                                </h5>
                                                <div class="row">
                                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Street</p>
                                                    <p class="col-sm-10 text-uppercase">{{$doctor->street}}</p>
                                                </div>
                                                <div class="row">
                                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Complex</p>
                                                    <p class="col-sm-10 text-uppercase">{{$doctor->complex}}</p>
                                                </div>
                                                <div class="row">
                                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Suburb</p>
                                                    <p class="col-sm-10">{{$doctor->suburb}}</p>
                                                </div>
                                                <div class="row">
                                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">City</p>
                                                    <p class="col-sm-10">{{$doctor->city}}</p>
                                                </div>
                                                <div class="row">
                                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Postal Code</p>
                                                    <p class="col-sm-10">{{$doctor->code}}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Edit Details Modal -->
                                        <div class="modal fade" id="edit_personal_details" aria-hidden="true" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document" >
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Personal Details</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form>
                                                            <div class="row form-row">
                                                                <div class="col-12 col-sm-6">
                                                                    <div class="form-group">
                                                                        <label>First Name</label>
                                                                        <input type="text" class="form-control" value="John">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-sm-6">
                                                                    <div class="form-group">
                                                                        <label>Last Name</label>
                                                                        <input type="text"  class="form-control" value="Doe">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label>Date of Birth</label>
                                                                        <div class="cal-icon">
                                                                            <input type="text" class="form-control" value="24-07-1983">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-sm-6">
                                                                    <div class="form-group">
                                                                        <label>Email ID</label>
                                                                        <input type="email" class="form-control" value="johndoe@example.com">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-sm-6">
                                                                    <div class="form-group">
                                                                        <label>Mobile</label>
                                                                        <input type="text" value="+1 202-555-0125" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <h5 class="form-title"><span>Address</span></h5>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label>Address</label>
                                                                        <input type="text" class="form-control" value="4663 Agriculture Lane">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-sm-6">
                                                                    <div class="form-group">
                                                                        <label>City</label>
                                                                        <input type="text" class="form-control" value="Miami">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-sm-6">
                                                                    <div class="form-group">
                                                                        <label>State</label>
                                                                        <input type="text" class="form-control" value="Florida">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-sm-6">
                                                                    <div class="form-group">
                                                                        <label>Zip Code</label>
                                                                        <input type="text" class="form-control" value="22434">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-sm-6">
                                                                    <div class="form-group">
                                                                        <label>Country</label>
                                                                        <input type="text" class="form-control" value="United States">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Edit Details Modal -->

                                    </div>

                                </div>
                                <!-- /Personal Details -->
                            </div>
                        </div>

                    </div>
                    <!-- /Personal Details Tab -->

                    <!-- Change Password Tab -->
                    <div id="password_tab" class="tab-pane fade">

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Change Password</h5>
                                <div class="row">
                                    <div class="col-md-10 col-lg-6">
                                        <form>
                                            <div class="form-group">
                                                <label>New Password</label>
                                                <input type="password" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                                <input type="password" class="form-control">
                                            </div>
                                            <button class="btn btn-primary" type="submit">Save Changes</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Change Password Tab -->

                </div>
            </div>
        </div>
    </div>
@endsection




