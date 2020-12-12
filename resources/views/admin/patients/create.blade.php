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
                        <li class="breadcrumb-item active">Add New patient</li>
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
                                <form action="{{route('admin.patients.store')}}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">First Name:<strong class="text-danger">*</strong></label>
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
                                                <label class="col-lg-3 col-form-label">Gender:<strong class="text-danger">*</strong></label>
                                                <div class="col-lg-9">
                                                    <select name="gender" id="gender" class="form-control">
                                                        <option value="Male" @if (old('gender') == 'Male') selected @endif>Male</option>
                                                        <option value="Female" @if (old('gender') == 'Female') selected @endif>Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">ID Number/Passport Number:<strong class="text-danger">*</strong></label>
                                                <div class="col-lg-9">
                                                    <input type="text" name="identity_number" value="{{ old('identity_number') }}" class="form-control">
                                                    @error('identity_number')
                                                    <span class="text-danger" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">South African:<strong class="text-danger">*</strong></label>
                                                <div class="col-lg-9">
                                                    <select name="is_local" id="is_local"  class="form-control">
                                                        <option value="1" @if (old('is_local') == 1) selected @endif>Yes</option>
                                                        <option value="0" @if (old('is_local') == 0) selected @endif>No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Work Number:</label>
                                                <div class="col-lg-9">
                                                    <input type="text" name="work_number" value="{{ old('work_number') }}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Cellphone Number:<strong class="text-danger">*</strong></label>
                                                <div class="col-lg-9">
                                                    <input type="text" name="cellphone" value="{{ old('cellphone') }}" class="form-control">
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
                                                    <input type="text" name="second_name"  value="{{ old('second_name') }}"class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Last Name:<strong class="text-danger">*</strong></label>
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
                                                <label class="col-lg-3 col-form-label">Date of Birth:<strong class="text-danger">*</strong></label>
                                                <div class="col-lg-9">
                                                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="form-control">
                                                    @error('date_of_birth')
                                                        <span class="text-danger" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Have Medical Aid:<strong class="text-danger">*</strong></label>
                                                <div class="col-lg-9">
                                                    <select name="have_medical" id="have_medical" class="form-control">
                                                        <option @if (old('have_medical') == 1) selected @endif value="1">Yes</option>
                                                        <option @if (old('have_medical') == 0) selected @endif value="0">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Landline Number:</label>
                                                <div class="col-lg-9">
                                                    <input type="text" name="landline" value="{{ old('landline') }}" class="form-control">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h4 class="card-title">Physical Address</h4>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Address 1:<strong class="text-danger">*</strong></label>
                                                <div class="col-lg-9">
                                                    <input type="text" name="address_1" value="{{ old('address_1') }}" class="form-control">
                                                    @error('address_1')
                                                    <span class="text-danger" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Address 2:<strong class="text-danger">*</strong></label>
                                                <div class="col-lg-9">
                                                    <input type="text" name="address_2" value="{{ old('address_2') }}" class="form-control">
                                                    @error('address_2')
                                                    <span class="text-danger" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Province:<strong class="text-danger">*</strong></label>
                                                <div class="col-lg-9">
                                                    <select name="province" id="province" class="form-control">
                                                        @foreach($provinces as $province)
                                                            <option @if (old('province') == $province->id) selected @endif value="{{$province->id}}">{{$province->province_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Postal Code:<strong class="text-danger">*</strong></label>
                                                <div class="col-lg-9">
                                                    <input type="text" name="postal_code" value="{{ old('postal_code') }}" class="form-control">
                                                    @error('postal_code')
                                                    <span class="text-danger" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <h4 class="card-title">Postal  Address</h4>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Address 1:</label>
                                                <div class="col-lg-9">
                                                    <input type="text" name="address_3" value="{{ old('address_3') }}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Address 2:</label>
                                                <div class="col-lg-9">
                                                    <input type="text" name="address_4" value="{{ old('address_4') }}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Province:</label>
                                                <div class="col-lg-9">
                                                    <select name="province2" id="province2" class="form-control">
                                                        @foreach($provinces as $province)
                                                            <option  @if (old('province2') == $province->id) selected @endif value="{{$province->id}}">{{$province->province_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">Postal Code:</label>
                                                <div class="col-lg-9">
                                                    <input type="text" name="postal_code2" value="{{ old('postal_code2') }}" class="form-control">
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

