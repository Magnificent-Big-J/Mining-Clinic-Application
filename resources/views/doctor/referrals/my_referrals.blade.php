@extends('layouts.doctor')
@section('title')Mining Clinic - Doctor Referrals @endsection
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
                            <li class="breadcrumb-item active" aria-current="page">My Referrals</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">My Referrals</h2>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="appointments">
        <div class="card">
            <div class="card-header">
                <div class="h4 card-title">My Referrals</div>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <table class="table table-hover table-center mb-0" id="referrals">
                        <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Patient Name</th>
                            <th scope="col">Referred To</th>
                            <th scope="col">Referred Date</th>
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
            $('#referrals').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('doctor.referrals') }}",
                },

                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'patient_name', name: 'patient_name'},
                    {data: 'referred_to', name: 'referred_to'},
                    {data: 'referral_date', name: 'referral_date'},
                    {data: 'actions', name: 'actions', orderable: true, searchable: true},
                ]
            });
        });
    </script>
@endsection
