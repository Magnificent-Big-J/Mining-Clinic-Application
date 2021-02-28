@extends('layouts.admindatatables')
@section('styles')
    <link href="{{asset('admin/assets/css/select2.min.css')}}" rel="stylesheet" />
    <link href="{{asset('css/main.css')}}" rel="stylesheet" />
    <link href="{{asset('css/timeslot.css')}}" rel="stylesheet" />

@endsection
@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Booking Appointment</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Make A Booking</li>
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
                                <h4>Booking for patient <span class="text-primary">{{$patient->first_name}} {{$patient->last_name}}</span></h4>
                                <form action="{{route('admin.store.booking')}}" method="post" >
                                    @csrf
                                    <input type="hidden" name="patient" value="{{$patient->id}}">
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Appointment Date:<strong class="text-danger">*</strong></label>
                                        <div class="col-lg-9">
                                            <input type="date" name="appointment_date" id="appointment_date" value="{{ old('appointment_date') }}" class="form-control" required>
                                            @error('appointment_date')
                                            <span class="text-danger" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Doctor :<strong class="text-danger">*</strong></label>
                                        <div class="col-lg-9">

                                            <select class="js-example-basic-single form-control" name="doctor" id="doctor" required>
                                                <option value="">Select A Doctor</option>

                                                @foreach($doctors as $doctor)

                                                    <option value="{{$doctor->id}}">{{$doctor->user->full_names}}</option>
                                                @endforeach
                                            </select>
                                            @error('doctor')
                                            <span class="text-danger" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Mining Clinic :<strong class="text-danger">*</strong></label>
                                        <div class="col-lg-9">

                                            <select class="js-example-basic-single form-control" name="clinic" id="clinic" required>
                                                <option value="">Select A Mining Clinic</option>

                                                @foreach($clinics as $clinic)
                                                    <option value="{{$clinic->id}}">{{$clinic->mininig_name}} {{$clinic->clinic_name}}</option>
                                                @endforeach
                                            </select>
                                            @error('clinic')
                                            <span class="text-danger" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row" id="time-slot">

                                    </div>
                                    <input type="submit" value="Book Appointment" class="btn btn-primary booking">
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $(function (){

            $('.js-example-basic-single').select2();

            $('.booking').click(function (){
                notifySlotNotClicked();
            });
            function notifySlotNotClicked()
            {
                let timeSlot = $("input[type='radio'].time-slot:checked").val();

                if (timeSlot == '' || timeSlot == undefined) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please Select A Time Slot'
                    })
                }
            }
            $('#doctor').change(function (){

                let doctor = $(this).val()
                let appointment_date = $('#appointment_date').val()
                getSlots(doctor, appointment_date)
            });
            $('#appointment_date').change(function (){

                let doctor = $('#doctor').val()
                let appointment_date = $(this).val()
                getSlots(doctor, appointment_date)
            });
            function getSlots(doctor, appointment_date)
            {
                if (doctor.length > 0 && appointment_date.length > 0) {
                    $("#time-slot").html('<img src="{{ asset('Images/805.gif') }}" alt=""/>')
                    axios.get("{{route('admin.doctor.unbooked.slots')}}", {params : {doctor, appointment_date}})
                        .then((response)=>{

                            $('#time-slot').html(response.data);
                        })
                        .catch((error)=>{
                            console.log(error);
                            $("#time-slot").html('');
                        })
                }
            }
        });
    </script>
@endsection
