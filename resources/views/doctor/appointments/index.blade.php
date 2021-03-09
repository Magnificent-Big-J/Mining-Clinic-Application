@extends('layouts.doctor')
@section('title')Mining Clinic - Doctor Appointments @endsection
@section('styles')

    <link rel="stylesheet" href="{{asset('css/main.css')}}">
@endsection
@section('breadcrumb')
    <div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-12 col-12">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Appointments</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">Appointments</h2>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="appointments">

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Appointments</h4>
            </div>
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-lg-3">
                            <input type="hidden" name="doctor" id="doctor" value="{{$user->doctor->id}}">
                            <select name="clinic" id="clinic" class="form-control">
                                @foreach($clinics as $clinic)
                                    <option value="{{$clinic->id}}">{{$clinic->mininig_name}} {{$clinic->clinic_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-3">

                            <select name="status" id="status" class="form-control">
                                @foreach($statuses as $key=> $status)
                                    <option value="{{$key}}">{{$status}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3">

                            <input type="date" name="date" id="appointment-date" class="form-control">

                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary" id="filter">Filter</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="filter-appointments">
                    <div id="loader"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(function (){
            todayDate();
            getAppointments();
            $('#filter').click(function (){
                $('#loader').show();
                getAppointments();
            })
            $(document).on('click', '.accept-appointment', function (){
                let appointment = $(this).attr('id');
                let status = "{{\App\Models\Appointment::ACCEPTED_STATUS}}";
                sendStatus(appointment, status);
            });
            $(document).on('click', '.decline-appointment', function (){
                let appointment = $(this).attr('id');
                let status = "{{\App\Models\Appointment::DECLINED_STATUS}}";
                sendStatus(appointment, status);
            });
            $(document).on('click', '.complete-appointment', function (){
                let appointment = $(this).attr('id');
                let status = "{{\App\Models\Appointment::DONE_STATUS}}";
                sendStatus(appointment, status);
            });
            function getAppointments()
            {
                let doctor = $('#doctor').val();
                axios.post(`api/filtered-appointments/${doctor}`,{'date': $('#appointment-date').val(), 'clinic': $('#clinic').val(), 'status': $('#status').val()})
                .then((response)=>{
                    $('.filter-appointments').html(response.data)
                })
            }
            function todayDate()
            {
                $('#appointment-date').val(new Date().toISOString().substring(0, 10));
            }
            function sendStatus(appointment, status)
            {
                axios.post(`api/appointment/${appointment}/update`, {status})
                    .then((response)=> {
                        Swal.fire({
                            icon: 'success',
                            title: 'OK',
                            text: response.data.success
                        }).then(function () {
                            if (response.data.shouldReload) {
                                location.reload();
                            }
                        });
                    });
            }
        });
    </script>
@endsection
