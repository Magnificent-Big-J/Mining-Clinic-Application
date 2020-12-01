@extends('layouts.admindatatables')
@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Patients Management</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Update Patient Information</li>
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
                                <h4 class="card-title">Patient Information</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{route('admin.patients.update', $patient->id)}}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">First Name:</label>
                                                <div class="col-lg-9">
                                                    <input type="text" name="first_name" value="{{ $patient->first_name }}" class="form-control">
                                                    @error('first_name')
                                                    <span class="text-danger" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Gender:</label>
                                                <div class="col-lg-9">
                                                    <select name="gender" id="gender" class="form-control">
                                                        <option value="Male" @if ($patient->gender == 'Male') selected @endif>Male</option>
                                                        <option value="Female" @if ($patient->gender == 'Female') selected @endif>Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">ID Number/Passport Number:</label>
                                                <div class="col-lg-9">
                                                    <input type="text" name="identity_number" value="{{ $patient->identity_number }}" class="form-control">
                                                    @error('identity_number')
                                                    <span class="text-danger" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">South African:</label>
                                                <div class="col-lg-9">
                                                    <select name="is_local" id="is_local"  class="form-control">
                                                        <option value="1" @if ($patient->is_south_african == 1) selected @endif>Yes</option>
                                                        <option value="0" @if ($patient->is_south_african == 0) selected @endif>No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Work Number:</label>
                                                <div class="col-lg-9">
                                                    <input type="text" name="work_number" value="{{ $patient->work_number}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Cellphone Number:</label>
                                                <div class="col-lg-9">
                                                    <input type="text" name="cellphone" value="{{ $patient->cell_number }}" class="form-control">
                                                    @error('cellphone')
                                                    <span class="text-danger" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Second Name:</label>
                                                <div class="col-lg-9">
                                                    <input type="text" name="second_name"  value="{{ $patient->second_name }}"class="form-control">
                                                    @error('second_name')
                                                    <span class="text-danger" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Last Name:</label>
                                                <div class="col-lg-9">
                                                    <input type="text" name="last_name" value="{{ $patient->last_name }}" class="form-control">
                                                    @error('last_name')
                                                    <span class="text-danger" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Date of Birth:</label>
                                                <div class="col-lg-9">
                                                    <input type="date" name="date_of_birth" value="{{ $patient->date_of_birth }}" class="form-control">
                                                    @error('date_of_birth')
                                                    <span class="text-danger" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Have Medical Aid:</label>
                                                <div class="col-lg-9">
                                                    <select name="have_medical" id="have_medical" class="form-control">
                                                        <option @if ( $patient->has_medical_aid == 1) selected @endif value="1">Yes</option>
                                                        <option @if ( $patient->has_medical_aid == 0) selected @endif value="0">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Landline Number:</label>
                                                <div class="col-lg-9">
                                                    <input type="text" name="landline" value="{{ $patient->landline }}" class="form-control">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="submit" value="Update" class="btn btn-primary ">
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

