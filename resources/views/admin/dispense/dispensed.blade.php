@extends('layouts.admindatatables')

@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Dispensed Patient Medication</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">View Patient Medication</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card ">
                            <div class="card-header">
                                <h4 class="card-title">Patient Personal Information</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">First Name</p>
                                    <p class="col-sm-10">{{$appointment->patient->first_name}}</p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Second Name</p>
                                    <p class="col-sm-10">{{$appointment->patient->second_name}}</p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Last Name</p>
                                    <p class="col-sm-10">{{$appointment->patient->last_name}}</p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Date of Birth</p>
                                    <p class="col-sm-10">{{$appointment->patient->date_of_birth}}</p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Identity Number/ Passport Number</p>
                                    <p class="col-sm-10">{{$appointment->patient->identity_number}}</p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Ages</p>
                                    <p class="col-sm-10">{{$appointment->patient->age}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Prescriptions</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                <tr>
                                    <th>Medicine</th>
                                    <th>Days</th>
                                    <th>Quantity</th>
                                    <th>Period</th>
                                    <th>Price</th>
                                    <th>Status</th>

                                </tr>
                                </thead>
                                <tbody>
                                <div style="display: none">
                                    {{ $total = 0 }}
                                </div>
                                @foreach($appointment->prescriptions as $prescription)
                                    <tr>
                                        <td>{{$prescription->clinicProduct->product->product_name}}</td>
                                        <td>{{$prescription->days}}</td>
                                        <td>{{$prescription->quantity}}</td>
                                        <td>{{$prescription->usage}}</td>
                                        <td>R {{$prescription->clinicProduct->price}}</td>
                                        <td>
                                            @if ($prescription->sales())
                                                <span>Dispensed</span>
                                            @else
                                                <span>Not dispensed or not enough medicine</span>
                                            @endif
                                        </td>
                                        <div style="display: none">{{$total += $prescription->clinicProduct->price}}</div>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4">Total</td>

                                    <td>R {{number_format($total, 2, '.', '')}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

