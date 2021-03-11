@extends('layouts.admindatatables')
@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title"> Historic Appointments</h3>
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
                                    <th scope="col">Actions</th>
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
    <script>
        $(function () {
            $('#appointments').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('historic.appointment.index') }}",
                },

                columns: [
                    {data: 'doctor', name: 'doctor'},
                    {data: 'specialities', name: 'specialities'},
                    {data: 'patient', name: 'patient'},
                    {data: 'appointment_date', name: 'appointment_date'},
                    {data: 'appointment_time', name: 'appointment_time'},
                    {data: 'appointment_status', name: 'appointment_status'},
                    {data: 'actions', name: 'actions'},
                ],
                'order':[],
                'columnDefs': [{
                    "targets": [6],
                    "orderable": false
                }]
            });
        });
    </script>
@endsection
