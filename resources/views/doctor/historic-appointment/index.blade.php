@extends('layouts.doctor')
@section('title')Mining Clinic - Doctor Appointments @endsection
@section('styles')
    <!-- Datatables CSS -->
    <link rel="stylesheet" href="{{asset('admin/assets/plugins/datatables/datatables.min.css')}}">
@endsection
@section('breadcrumb')
    <div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-12 col-12">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Appointments</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">All Appointments</h2>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="appointments">
        <div class="card">
            <div class="card-header">
                <div class="h4 card-title">Appointments Reports</div>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <table class="table table-hover table-center mb-0" id="appointments">
                        <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Patient</th>
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

    </div>
@endsection
@section('scripts')
    <!-- Datatables JS -->
    <script src="{{asset('admin/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('admin/assets/plugins/datatables/datatables.min.js')}}"></script>
    <script>
        $(function () {
            $('#appointments').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('doctor.historic.index') }}",
                },

                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'patient_name', name: 'patient_name'},
                    {data: 'appointment_date', name: 'appointment_date'},
                    {data: 'appointment_time', name: 'appointment_time'},
                    {data: 'appointment_status', name: 'appointment_status'},
                    {data: 'actions', name: 'actions'},
                ],
                'order':[],
                'columnDefs': [{
                    "targets": [0,5],
                    "orderable": false
                }]
            });
        });
    </script>
@endsection
