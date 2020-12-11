@extends('layouts.admindatatables')
@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Consultation Categories</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Consultation Categories</li>
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
                            <a class="btn btn-secondary mb-4" data-toggle="modal" href="#consultation_category_modal"><i class="fa fa-plus-circle"></i> Add Category</a>
                            <table class="table table-hover table-center mb-0" id="consultation_category">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Consultation Category</th>
                                    <!--th>Actions</th-->
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
    @include('admin.consultation.modals.category')
@endsection
@section('scripts')
    <script>
        $(function () {
            $('#consultation_category').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('consultation.category.index') }}",
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                   // {data: 'actions', name: 'actions'},
                ]
            });

        });
    </script>
@endsection
