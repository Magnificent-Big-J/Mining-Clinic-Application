@extends('layouts.doctor')
@section('title')Mining Clinic - Patient Medical Record @endsection
@section('styles')
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
@endsection
@section('breadcrumb')
    <div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-12 col-12">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Patient Medical Record</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">Patient Medical Record</h2>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">Edit Patient Medical Record</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="biller-info">
                        <h4 class="d-block">{{$medicalRecord->patient->full_name}}</h4>
                        <span class="d-block text-sm text-muted"><i class="fas fa-{{strtolower($medicalRecord->patient->gender)}} mr-1"></i>{{$medicalRecord->patient->gender}}</span>
                        <span class="d-block text-sm text-muted">
                            <h5 class="mb-0">
                            @if((boolean)$medicalRecord->patient->has_medical_aid)
                                    <i class="fas fa-credit-card"></i>Medical Aid
                                @else
                                    <i class="fas fa-money-bill-alt"></i>Cash Payment
                                @endif
                        </h5>
                        </span>
                    </div>
                </div>

            </div>
            <hr>
            <div class="row">
                <div class="col-lg-12">
                    <form action="{{route('medical.record.update', $medicalRecord->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Medical Record Date<strong class="text-danger">*</strong>:</label>
                            <div class="col-lg-9">
                                <input type="date"  name="record_date"  class="form-control" value="{{$medicalRecord->record_date}}">
                                @error('record_date')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Description<strong class="text-danger">*</strong>:</label>
                            <div class="col-lg-9">
                                <textarea name="description" id="description" cols="30" rows="2" class="form-control"> {{$medicalRecord->description}}</textarea>
                                @error('description')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Medical Record File :</label>
                            <div class="col-lg-9">
                                <input type="file" accept="image/gif, image/jpeg, image/png, application/pdf" name="medical_record"  class="form-control" >
                            </div>
                        </div>
                        <input type="submit" value="Update Patient Record" class="btn btn-primary ">
                    </form>
                </div>
            </div>


        </div>
    </div>
@endsection
