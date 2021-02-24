@extends('layouts.admindatatables')
@section('styles')
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
@endsection
@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Doctors Management</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Add New Doctor</li>
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
                        <div class="card flex-fill">
                            <div class="card-header">
                                <h4 class="card-title">Doctor Personal Information</h4>
                            </div>
                            <div class="card-body">
                                <form  method="post" id="doctor-form" enctype="multipart/form-data" action="javascript:void(0)">
                                    <div id="loader"></div>
                                    @csrf
                                    @include('admin.doctors.partials.personal')
                                    <hr>
                                    <div class="entity">
                                        <h4 class="card-title">Entity Information</h4>
                                        @include('admin.doctors.partials.entity')
                                    </div>

                                    <h4 class="card-title">Address Information</h4>
                                    @include('admin.doctors.partials.address')
                                    <input type="submit" value="Submit" class="btn btn-primary ">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Recent Orders -->

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script>
        $(function (){
            $("#loader").hide();
            $('#specialist_name').select2({
                theme: "classic",
                width: "resolve"
            });
            $('.entity').hide();
            $('#has-entity').click(function (){
                let has_entity = $(this).prop('checked');
               if (has_entity === true) {
                   $('.entity').show();
               } else {
                   $('.entity').hide();
               }
            });
            $('#doctor-form').on('submit',function (e){
                e.preventDefault();
                $("#loader").show();
                let formData = new FormData(this);

                axios.post('../../api/ajax-doctor-form', formData)
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
                    if (errors.first_name) {
                        $('#first-name-error').html(errors.first_name[0]);
                    }
                    if (errors.title) {
                        $('#title-name-error').html(errors.title[0]);
                    }
                    if (errors.practice_number) {
                        $('#practice-number-error').html(errors.practice_number[0]);
                    }
                    if (errors.reg_number) {
                        $('#reg-number-error').html(errors.reg_number[0]);
                    }
                    if (errors.last_name) {
                        $('#last-name-error').html(errors.last_name[0]);
                    }
                    if (errors.email) {
                        $('#email-error').html(errors.email[0]);
                    }
                    if (errors.specialist_name) {
                        $('#specialist-name-error').html(errors.specialist_name[0]);
                    }
                    if (errors.entity_name) {
                        $('#entity-name-error').html(errors.entity_name[0]);
                    }
                    if (errors.entity_status) {
                        $('#entity-status-error').html(errors.entity_status[0]);
                    }
                    if (errors.complex) {
                        $('#complex-error').html(errors.complex[0]);
                    }
                    if (errors.suburb) {
                        $('#suburb-error').html(errors.suburb[0]);
                    }
                    if (errors.city) {
                        $('#city-error').html(errors.city[0]);
                    }
                    if (errors.postal_code) {
                        $('#postal-code-error').html(errors.postal_code[0]);
                    }
                })
            });
        });
    </script>
@endsection
