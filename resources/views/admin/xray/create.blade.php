@extends('layouts.admindatatables')
@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Patient Management</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Upload Patient XRAY</li>
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
                                <h4 class="card-title">Patient XRAY</h4>
                                <p>Patient: {{$appointment->patient->full_name}}</p>
                                <p>Appoint: {{$appointment->appointment_date}}</p>
                            </div>
                            <div class="card-body">
                                <form action="{{route('admin.patient.xray.store')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="appointment" value="{{$appointment->id}}">
                                    <input type="hidden" name="document" value="{{$document_type[0]->id}}">
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Patient X-ray:<span class="text-danger">*</span></label>
                                        <div class="col-lg-9">
                                            <input type="file" accept="image/gif, image/jpeg, image/png, application/pdf" name="xray"  class="form-control" required>
                                            @error('xray')
                                            <span class="text-danger" role="alert">
                                                         <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <input type="submit" value="Upload" class="btn btn-primary ">
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

