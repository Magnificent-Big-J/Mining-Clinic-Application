@extends('layouts.doctor')
@section('title')Mining Clinic - Doctor Patients @endsection
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
                            <li class="breadcrumb-item active" aria-current="page">Doctor Patients</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">Doctor Patients</h2>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="appointments">
        <div class="card">
            <div class="card-header">
                <div class="h4 card-title">Doctor Patients</div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-center mb-0" id="patients">
                        <thead>
                        <tr>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Age</th>
                            <th scope="col">CellPhone</th>
                            <th scope="col">Medical Aid</th>
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
            $('#patients').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('doctor.patients.index') }}",
                },
                columns: [
                    {data: 'first_name', name: 'first_name'},
                    {data: 'last_name', name: 'last_name'},
                    {data: 'age', name: 'age'},
                    {data: 'cell_number', name: 'cell_number'},
                    {data: 'medical', name: 'medical'},
                    {data: 'actions', name: 'actions'},
                ],
                'order':[],
                'columnDefs': [{
                    "targets": [5],
                    "orderable": false
                }]
            });
        });
    </script>
@endsection
