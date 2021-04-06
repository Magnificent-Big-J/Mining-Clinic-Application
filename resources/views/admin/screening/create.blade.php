@extends('layouts.admindatatables')

@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">{{$type}}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">{{$type}}</li>
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
                                <h4 class="card-title">Now Screening {{$patient->full_name}} For {{$type}}</h4>
                            </div>
                            <div class="card-body">

                                <form action="{{route('admin.covid.screening.store')}}" method="post" >
                                    @csrf
                                    <input type="hidden" name="patient" value="{{$patient->id}}">
                                    <input type="hidden" name="appointment" value="{{$appointment->id}}">
                                   @foreach($questions as  $key=>$question)
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">{{$question->name}}</label>
                                            <div class="col-lg-9">
                                                <div class="row">
                                                    <div class="offset-4 col-lg-4">
                                                        <label for="">
                                                            <input type="radio" name="answers_{{$key}}" id="answers" value="Yes" class="form-control"> Yes
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label for="">
                                                            <input type="radio" name="answers_{{$key}}" id="answers" value="No" class="form-control"> No
                                                        </label>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="questions[]" value="{{$question->id}}">
                                            </div>
                                        </div>
                                    @endforeach
                                    <input type="submit" value="Save" class="btn btn-primary">
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
