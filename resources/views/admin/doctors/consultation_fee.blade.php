@extends('layouts.admindatatables')
@section('styles')
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
@endsection
@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Consultation Fee</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Consultations</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class="row">
            <div class="col-md-12">

                <!-- Recent Orders -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Consultations and consultation fees for {{$doctor->user->full_names}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <a class="btn btn-secondary mb-4" data-toggle="modal" href="#consultation_fee_modal"><i class="fa fa-plus-circle"></i> Add Consultation Fee</a>
                            <table class="table table-hover table-center mb-0" id="consultations">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Consultation</th>
                                    <th>Consultation Category</th>
                                    <th>Consultation Fee</th>
                                    <th>Actions</th>
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
    @include('admin.doctors.modals.consultation_fee')
@endsection
@section('scripts')
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script>
        $(function () {
            $('#consultation-fee').select2({
                theme: "classic",
                width: "resolve"
            });
            $('#consultations').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('consultation.fee.index', $doctor->id) }}",
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'consultation_name', name: 'consultation_name'},
                    {data: 'category_name', name: 'category_name'},
                    {data: 'consultation_fee_price', name: 'consultation_fee_price'},
                    {data: 'actions', name: 'actions'},
                ],
                'order':[],
                'columnDefs': [{
                    "targets": [0, 4],
                    "orderable": false
                }]
            });

        });
    </script>
@endsection
