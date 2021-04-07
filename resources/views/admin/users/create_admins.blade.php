@extends('layouts.admindatatables')
@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">User Management</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Add New Admin</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class="row">
            <div class="col-md-12">

                <!-- Recent Orders -->
                <div class="card">
                    <div class="card-body">
                        <div class="card flex-fill">
                            <div class="card-header">
                                <h4 class="card-title">User Personal Information</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{route('admin.users.create.admins.store')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">First Name:<span class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control">
                                                    @error('first_name')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                 </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Title:<span class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <select name="title" id="title" class="form-control">
                                                        <option value="Mr">Mr</option>
                                                        <option value="Mrs">Mrs</option>
                                                        <option value="Ms">Ms</option>
                                                        <option value="Miss">Miss</option>
                                                        <option value="Prof">Professor</option>
                                                        <option value="Dr">Dr</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Avatar:</label>
                                                <div class="col-lg-9">
                                                    <input type="file" accept="image/gif, image/jpeg, image/png" name="avatar"  class="form-control">

                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-lg-6">

                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Last Name:<span class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control">
                                                    @error('last_name')
                                                    <span class="text-danger" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Email Address:<span class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <input type="text" name="email" value="{{ old('email') }}" class="form-control">
                                                    @error('email')
                                                    <span class="text-danger" role="alert">
                                                       <strong>{{ $message }}</strong>
                                                     </span>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                    <input type="submit" value="Submit" class="btn btn-primary ">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Recent Orders -->

            </div>
        </div>
    </div>
@endsection

