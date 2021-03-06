@extends('layouts.admindatatables')
@section('styles')
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
@endsection
@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Specialists</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Specialist</li>
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
                            <a href="{{route('admin.specialists.create')}}" class="mb-2 btn btn-success">Add New Specialist</a>
                            <table class="table table-hover table-center mb-0" id="specialist">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Specialists</th>
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
    @include('admin.specialist.modals.add_specialist')
@endsection
@section('scripts')
    <script>
        $(function () {
            $("#loader").hide();
            $('#specialist').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('specialist.index') }}",
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'specialist', name: 'specialist'},
                    {data: 'edit', name: 'edit'},
                    {data: 'delete', name: 'delete'},
                    ],
                'order':[],
                'columnDefs': [{
                    "targets": [0,2, 3],
                    "orderable": false
                }]
            });


            });
        </script>
@endsection
