@extends('layouts.admindatatables')
@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Doctors Management</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Doctors Information</li>
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
                            <a href="{{route('admin.doctors.create')}}" class="mb-2 btn btn-success">Add New Doctor</a>
                            <table class="table table-hover table-center mb-0" id="doctors">
                                <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Last Name</th>
                                    <th scope="col">Specialist</th>
                                    <th scope="col">Vat Number</th>
                                    <th scope="col">Practice Number</th>
                                    <th scope="col">View</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Consultation</th>
                                    <th scope="col">Product Stock</th>
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
            $('#doctors').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('doctor.index') }}",
                },

                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'title', name: 'title'},
                    {data: 'first_name', name: 'first_name'},
                    {data: 'last_name', name: 'last_name'},
                    {data: 'specialist', name: 'specialist'},
                    {data: 'vat_number', name: 'vat_number'},
                    {data: 'practice_number', name: 'practice_number'},
                    {data: 'view', name: 'view', orderable: true, searchable: true},
                    {data: 'edit', name: 'edit', orderable: true, searchable: true},
                    {data: 'consultation', name: 'consultation', orderable: true, searchable: true},
                    {data: 'stock', name: 'stock', orderable: true, searchable: true},

                ]
            });
        });
    </script>
@endsection
