@extends('layouts.admindatatables')

@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Users</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Users</li>
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
                            <div>
                                <a class="btn btn-secondary mb-4"  href="{{route('admin.users.create.admins')}}"><i class="fa fa-plus-circle"></i> Create Admin User</a>
                               {{-- <a class="btn btn-secondary mb-4"  href="{{route('admin.doctor.users.create.admins')}}"><i class="fa fa-plus-circle"></i> Create Doctor Admin User</a>--}}
                            </div>
                            <table class="table table-hover table-center mb-0" id="users">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Title</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
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

            $('#users').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('users.index') }}",
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'title', name: 'title'},
                    {data: 'full_name', name: 'full_name'},
                    {data: 'email', name: 'email'},
                    {data: 'edit', name: 'edit'},
                    {data: 'delete', name: 'delete'},

                ],
                'order':[],
                'columnDefs': [{
                    "targets": [0,4,5],
                    "orderable": false
                }]
            });
        });
    </script>
@endsection
