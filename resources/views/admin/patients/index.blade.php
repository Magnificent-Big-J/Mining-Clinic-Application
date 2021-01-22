@extends('layouts.admindatatables')
@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Patients Management</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Patients Information</li>
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
                            <a href="{{route('admin.patients.create')}}" class="mb-2 btn btn-success">Add New Patient</a>
                            <table class="table table-hover table-center mb-0" id="patients">
                                <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">First Name</th>
                                    <th scope="col">Last Name</th>
                                    <th scope="col">Age</th>
                                    <th scope="col">CellPhone</th>
                                    <th scope="col">Medical Aid</th>
                                    <th scope="col">View</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Medical Records</th>
                                    <th scope="col">Appointments</th>
                                    <th scope="col">Delete</th>
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
            $('#patients').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('patient.index') }}",
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'first_name', name: 'first_name'},
                    {data: 'last_name', name: 'last_name'},
                    {data: 'age', name: 'age'},
                    {data: 'cell_number', name: 'cell_number'},
                    {data: 'medical', name: 'medical'},
                    {data: 'view', name: 'view', orderable: true, searchable: true},
                    {data: 'edit', name: 'edit', orderable: true, searchable: true},
                    {data: 'medical_record', name: 'medical_record', orderable: true, searchable: true},
                    {data: 'appointment', name: 'appointment', orderable: true, searchable: true},
                    {data: 'delete', name: 'delete', orderable: true, searchable: true},
                ]
            });
        });
    </script>
@endsection
