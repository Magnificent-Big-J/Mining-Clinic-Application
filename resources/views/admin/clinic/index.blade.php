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
                    <h3 class="page-title">Mining Clinic Management</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Mining Clinic Information</li>
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
                            <a class="btn btn-secondary mb-4" data-toggle="modal" href="#mining-clinic-modal"><i class="fa fa-plus-circle"></i> Add Mining Clinic</a>
                            <table class="table table-hover table-center mb-0" id="clinics">
                                <thead>
                                <tr>
                                    <th scope="col">Mining Name</th>
                                    <th scope="col">Clinic Name</th>
                                    <th scope="col">Edit</th>
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
    @include('admin.clinic.modals.add-clinic')
    @include('admin.clinic.modals.edit-clinic')
@endsection
@section('scripts')
    <script>
        $(function () {
            $("#loader").hide();
            $('#clinics').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('clinic.index.data') }}",
                },
                columns: [
                    {data: 'mining_name', name: 'mining_name'},
                    {data: 'clinic_name', name: 'clinic_name'},
                    {data: 'edit', name: 'edit'},
                    {data: 'delete', name: 'delete'},
                ],
                'order':[],
                'columnDefs': [{
                    "targets": [2,3],
                    "orderable": false
                }]
            });
            $(document).on('click', '.edit-mining-clinic-record', function (){
                $("#loader").hide();
                let clinic =  $(this).attr('id');
                $('#clinic').val(clinic);

                axios.get(`../../api/mining-clinic-form/${clinic}`)
                    .then((response)=>{

                        $('#mining-name').val(response.data.mining_name);
                        $('#clinic-name').val(response.data.clinic_name);
                    });

            });
            $('#mining-clinic-form').on('submit',function (e){
                e.preventDefault();
                $("#loader").show();
                let formData = new FormData(this);

                axios.post('../../api/mining-clinic-form', formData)
                    .then((response)=>{
                        $("#loader").hide();
                        Swal.fire({
                            icon: 'success',
                            text: response.data.success
                        })
                        window.setTimeout(function () {
                            window.location = response.data.url;
                        }, 1000);
                    })
                    .catch((error)=>{
                        $("#loader").hide();
                        let errors = error.response.data.errors;
                        //
                        if (errors.mining_name) {
                            $('#mining-name-error').html(errors.mining_name[0]);
                        }
                        if (errors.clinic_name) {
                            $('#clinic-name-error').html(errors.clinic[0]);
                        }

                    })
            });
            $('#edit-mining-clinic-form').on('submit',function (e){
                e.preventDefault();
                $("#loader").show();

                let clinic = $('#clinic').val();

                axios.post(`../../api/mining-clinic-form/${clinic}/update`, {
                    'mining_name': $('#mining-name').val(),
                    'clinic_name': $('#clinic-name').val(),
                })
                 .then((response)=>{
                        $("#loader").hide();
                        Swal.fire({
                            icon: 'success',
                            text: response.data.success
                        })
                        window.setTimeout(function () {
                            window.location = response.data.url;
                        }, 1000);
                    })
                    .catch((error)=>{
                        $("#loader").hide();
                        let errors = error.response.data.errors;
                        //
                        if (errors.mining_name) {
                            $('#error-mining-name').html(errors.mining_name[0]);
                        }
                        if (errors.clinic_name) {
                            $('#error-clinic-name').html(errors.clinic_name[0]);
                        }

                    })
            });
        });
    </script>
@endsection
