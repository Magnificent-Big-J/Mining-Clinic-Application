@extends('layouts.admindatatables')
@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Patients Medical Aid Management</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Patients Medical Aid</li>
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
                                <h4 class="card-title"> Medical Information of

                                        {{$medicalAid->patient->full_name}}
                                </h4>
                            </div>
                            <div class="card-body">
                                <form action="{{route('admin.medicalAid.update', $medicalAid->id)}}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Medical Aid Name:<strong class="text-danger">*</strong></label>
                                        <div class="col-lg-9">
                                            <input type="text" name="medical_name" value="{{ $medicalAid->medical_name }}" class="form-control">
                                            @error('medical_name')
                                            <span class="text-danger" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Medical Aid Number:<strong class="text-danger">*</strong></label>
                                        <div class="col-lg-9">
                                            <input type="text" name="medical_aid_number" value="{{ $medicalAid->medical_aid_number }}" class="form-control">
                                            @error('medical_aid_number')
                                            <span class="text-danger" role="alert">
                                                             <strong>{{ $message }}</strong>
                                                            </span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Medical Email Address:<strong class="text-danger">*</strong></label>
                                        <div class="col-lg-9">
                                            <input type="email" name="medical_email_address" value="{{ $medicalAid->medical_email_address}}" class="form-control">
                                            @error('medical_email_address')
                                            <span class="text-danger" role="alert">
                                                             <strong>{{ $message }}</strong>
                                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Medical Aid Plan:</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="plan" value="{{ $medicalAid->plan }}" class="form-control">

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Medical Aid Plan:</label>
                                        <div class="col-lg-9">
                                            <select name="status" id="status" class="form-control">
                                                @foreach($status as $key=> $stat)
                                                    <option @if ($key === $medicalAid->medical_aid_status) selected @endif value="{{$key}}">
                                                        {{$stat}}
                                                    </option>
                                                @endforeach
                                            </select>
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

