@extends('layouts.admindatatables')
@section('styles')
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
@endsection
@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Appointments Management</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Appointments</li>
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
                        <form >
                            <div class="row">
                                <div class="col-lg-3">
                                    <select name="clinic" id="clinic" class="form-control">
                                        @foreach($clinics as $clinic)
                                            <option value="{{$clinic->id}}">{{$clinic->mininig_name}} {{$clinic->clinic_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <select name="doctors" id="doctors" class="form-control">
                                        @foreach($doctors as $doctor)
                                            <option value="{{$doctor->id}}">{{$doctor->user->full_names}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <select name="status" id="status" class="form-control">
                                        @foreach($statuses as $key=> $status)
                                            <option value="{{$key}}">{{$status}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <input type="date" name="date" id="appointment-date" class="form-control">

                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary" id="filter-appointments">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">

                            <table class="table table-hover table-center mb-0" id="appointments">
                                <thead>
                                <tr>
                                    <th scope="col">Doctor</th>
                                    <th scope="col">Specialities</th>
                                    <th scope="col">Patient Name</th>
                                    <th scope="col">Appointment Date</th>
                                    <th scope="col">Appointment Time</th>
                                    <th scope="col">Appointment Status</th>
                                    <th scope="col">Appointment Action</th>
                                    <th scope="col">Xray Action</th>
                                    <th scope="col">Delete Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /Recent Orders -->

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script>
        $(function (){
            $('#clinic').select2({
                theme: "classic",
                width: "resolve"
            });
            $('#doctors').select2({
                theme: "classic",
                width: "resolve"
            });
            $('#status').select2({
                theme: "classic",
                width: "resolve"
            });
            todaysDate();
            fetch_data();
            function fetch_data(){
                let clinic = $('#clinic').val();
                let doctor = $('#doctors').val();
                $('#appointments').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: `appointments-data/${clinic}/app/${doctor}`,
                        type:"POST",
                        data:{
                            "_token": "{{ csrf_token() }}",
                            "status": $('#status').val(),
                            "appointment_date": $('#appointment-date').val(),
                        }
                    },

                    columns: [
                        {data: 'doctor', name: 'doctor'},
                        {data: 'specialities', name: 'specialities'},
                        {data: 'patient', name: 'patient'},
                        {data: 'appointment_date', name: 'appointment_date'},
                        {data: 'appointment_time', name: 'appointment_time'},
                        {data: 'appointment_status', name: 'appointment_status'},
                        {data: 'appointment', name: 'appointment'},
                        {data: 'xray', name: 'xray'},
                        {data: 'delete', name: 'delete'},

                    ],
                    'order':[],
                    'columnDefs': [{
                        "targets": [5,6,7,8],
                        "orderable": false
                    }]

                });
                $('#clinic').val(clinic)
                $('#doctor').val(doctor)
            }
            $('#filter-appointments').click(function(){

                $('#appointments').DataTable().destroy();
                fetch_data();
            })
            function todaysDate()
            {
                $('#appointment-date').val(new Date().toISOString().substring(0, 10));
            }
        });
    </script>
@endsection
