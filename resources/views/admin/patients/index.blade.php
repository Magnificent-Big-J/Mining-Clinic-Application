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
                                    <th scope="col">Patient</th>
                                    <th scope="col">Age</th>
                                    <th scope="col">Cell Phone</th>
                                    <th scope="col">Medical Aid</th>
                                    <th scope="col">View</th>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Medical Records</th>
                                    <th scope="col">Appointments</th>
                                    <th scope="col">Book Appointment</th>
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
    @include('admin.patients.modals.has_nedical_aid')
    @include('admin.patients.modals.update_has_medical_aid')
@endsection
@section('scripts')
    <script>
        $(function () {
            $("#loader").hide();
            $('#patients').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('patient.index') }}",
                },
                columns: [
                    {data: 'patient', name: 'patient'},
                    {data: 'age', name: 'age'},
                    {data: 'cell_number', name: 'cell_number'},
                    {data: 'medical', name: 'medical'},
                    {data: 'view', name: 'view'},
                    {data: 'edit', name: 'edit'},
                    {data: 'medical_record', name: 'medical_record', },
                    {data: 'appointment', name: 'appointment'},
                    {data: 'book_appointment', name: 'book_appointment'},
                    {data: 'delete', name: 'delete'},
                ],
                'order':[],
                'columnDefs': [{
                    "targets": [4,5,6,7,8,9],
                    "orderable": false
                }]
            });
            $(document).on('click', '.add-medical-aid', function (){
                $('#patient').val($(this).attr('id'))
            });
            $(document).on('click', '.edit-medical-aid', function (){
                $("#loader").hide();
               let medical =  $(this).attr('id');
                $('#medical').val(medical);

                axios.get(`../../api/patient-medical-aid/${medical}`)
                .then((response)=>{

                    $('#medical-aid-name').val(response.data.medical_name);
                    $('#medical-aid-number').val(response.data.medical_aid_number);
                    $('#medical-aid-email').val(response.data.medical_email_address);
                    $('#medical-aid-plan').val(response.data.plan);
                    $('#medical-aid-status').val(response.data.medical_aid_status);
                });

            });
            $('#medical-aid-form').on('submit',function (e){
                e.preventDefault();
                $("#loader").show();
                let formData = new FormData(this);

                axios.post('../../api/patient-medical-aid-form', formData)
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
                        if (errors.medical_name) {
                            $('#medical-aid-error').html(errors.medical_name[0]);
                        }
                        if (errors.medical_aid_number) {
                            $('#medical-aid-number-error').html(errors.medical_aid_number[0]);
                        }
                        if (errors.medical_email_address) {
                            $('#medical-aid-email-error').html(errors.medical_email_address[0]);
                        }

                    })
            });
            $('#edit-medical-aid-form').on('submit',function (e){
                e.preventDefault();
                $("#loader").show();

                let medicalAid = $('#medical').val();

                axios.post(`../../api/patient-medical-aid/${medicalAid}/update`, {
                    'medical_name': $('#medical-aid-name').val(),
                    'medical_aid_number': $('#medical-aid-number').val(),
                    'plan': $('#medical-aid-plan').val(),
                    'medical_email_address': $('#medical-aid-email').val(),
                    'status': $('#medical-aid-status').val(),
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
                        if (errors.medical_name) {
                            $('#medical-aid-error2').html(errors.medical_name[0]);
                        }
                        if (errors.medical_aid_number) {
                            $('#medical-aid-number-error2').html(errors.medical_aid_number[0]);
                        }
                        if (errors.medical_email_address) {
                            $('#medical-aid-email-error2').html(errors.medical_email_address[0]);
                        }

                    })
            });
        });
    </script>
@endsection
