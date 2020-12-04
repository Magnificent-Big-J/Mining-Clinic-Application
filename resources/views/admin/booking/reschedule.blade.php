@extends('layouts.admindatatables')
@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{asset('css/main.css')}}" rel="stylesheet" />
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
                                <h4 class="card-title">Reschedule Booking appointment for patient <span class="text-primary">{{$appointment->patient->first_name}} {{$appointment->patient->last_name}}</span></h4>
                            </div>
                            <div class="card-body">

                                <form action="{{route('admin.reschedule.update', $appointment->id)}}" method="post" >
                                    @method('PUT')
                                    @csrf

                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Appointment Date:</label>
                                        <div class="col-lg-9">
                                            <input type="date" name="appointment_date" id="appointment_date" value="{{ $appointment->appointment_date }}" class="form-control" required>
                                            @error('appointment_date')
                                            <span class="text-danger" role="alert">
                                                         <strong>{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Doctor :</label>
                                        <div class="col-lg-9">
                                          <p>{{$appointment->doctor->entity_name}}</p>
                                            <input type="hidden" name="doctor" id="doctor" value="{{$appointment->doctor->id}}">
                                        </div>
                                    </div>
                                    <div class="form-group row" id="time-slot">

                                    </div>


                                    <input type="submit" value="Reschedule Booking Appointment" class="btn btn-primary booking">
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

            getSlots();
            $('#appointment_date').change(function (){

                getSlots();
            });
            function getSlots()
            {

                    $("#time-slot").html('<img src="{{ asset('Images/805.gif') }}" alt=""/>')
                    axios.get("{{route('admin.doctor.unbooked.slots')}}", {params : {doctor:$('#doctor').val(), appointment_date:$('#appointment_date').val()}})
                        .then((response)=>{
                            $('#time-slot').html(response.data);
                        })
                        .catch((error)=>{

                            $("#time-slot").html('');
                        })

            }
        });
    </script>
@endsection

