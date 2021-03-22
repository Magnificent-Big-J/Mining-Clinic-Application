@extends('layouts.doctor')
@section('title')Mining Clinic - Refer Patient @endsection
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
                            <li class="breadcrumb-item active" aria-current="page">Refer Patient</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">Refer Patient</h2>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">Refer Patient</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="biller-info">
                        <h4 class="d-block">{{$appointment->patient->full_name}}</h4>
                        <span class="d-block text-sm text-muted"><i class="fas fa-{{strtolower($appointment->patient->gender)}} mr-1"></i>{{$appointment->patient->gender}}</span>

                    </div>
                </div>
                <div class="col-sm-6 text-sm-right">
                    <div class="billing-info">
                        <h4 class="d-block">{{$appointment->appointment_date}}</h4>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-12">
                    <form action="{{route('doctor.referrals.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="appointment" value="{{$appointment->id}}">
                        <input type="hidden" name="patient" value="{{$appointment->patient->id}}">
                        <input type="hidden" name="doctor" value="{{$appointment->doctor->id}}">
                        <input type="hidden" name="document" value="{{$document_type[0]->id}}">
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Referral Reason:<strong class="text-danger">*</strong></label>
                            <div class="col-lg-9">
                                <textarea name="referral_reason" id="referral_reason" cols="30" rows="2" class="form-control"></textarea>
                                @error('referral_reason')
                                <span class="text-danger" role="alert">
                                                         <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Referral To:<strong class="text-danger">*</strong></label>
                            <div class="col-lg-9">
                                <select name="refer_to" id="doctor" style="width: 100%" class="form-control select2-width" required>
                                    @foreach($doctors as $doctor)
                                        <option  value="{{$doctor->id}}">{{$doctor->user->full_names}} </option>
                                    @endforeach
                                </select>
                                @error('refer_to')
                                <span class="text-danger" role="alert">
                                                         <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Referral Letter:</label>
                            <div class="col-lg-9">
                                <input type="file" accept="image/gif, image/jpeg, image/png, application/pdf" name="referral"  class="form-control" >
                            </div>
                        </div>
                        <input type="submit" value="Refer Patient" class="btn btn-primary ">
                    </form>
                </div>
            </div>


        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script>
        $(function (){
            $('#doctor').select2({
                theme: "classic",
                width: "resolve"
            });
        });

    </script>
@endsection
