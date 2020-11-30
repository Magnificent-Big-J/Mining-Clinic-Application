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
                                    <th>No</th>
                                    <th>First Name</th>
                                    <th>Second Name</th>
                                    <th>Last Name</th>
                                    <th>Age</th>
                                    <th>CellPhone</th>
                                    <th>Medical Aid</th>
                                    <th width="100px">Actions</th>
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
                    {data: 'second_name', name: 'second_name'},
                    {data: 'last_name', name: 'last_name'},
                    {data: 'age', name: 'age'},
                    {data: 'cell_number', name: 'cell_number'},
                    {data: 'medical', name: 'medical'},
                    {data: 'actions', name: 'actions', orderable: true, searchable: true},
                ]
            });
        });
    </script>
@endsection
