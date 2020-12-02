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
                                <h4 class="card-title">Doctor Personal Information</h4>
                            </div>
                            <div class="card-body">
                                <h4>Booking for patient <span class="text-primary">{{$patient->first_name}} {{$patient->last_name}}</span></h4>
                                <form action="{{route('admin.store.booking')}}" method="post" >
                                    @csrf
                                    <input type="hidden" name="patient" value="{{$patient->id}}">
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Appointment Date:</label>
                                        <div class="col-lg-9">
                                            <input type="date" name="appointment_date" value="{{ old('appointment_date') }}" class="form-control" required>
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

                                            <select class="js-example-basic-single form-control" name="doctor" required>
                                                @foreach($doctors as $doctor)
                                                    <option value="{{$doctor->id}}">{{$doctor->entity_name}}</option>
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
                                        <label class="col-lg-3 col-form-label">Slots :</label>
                                        <div class="col-lg-9">
                                           <div class="row">
                                               @foreach($timeSlots as $slot)
                                                   <div class="col-md-3">
                                                       <label>
                                                           <input type="radio" name="timeSlot" id="time-slot" value="{{$slot}}" required>
                                                           <img src="&text={{$slot}}">
                                                       </label>
                                                   </div>
                                               @endforeach
                                           </div>
                                        </div>
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
                let timeSlot = $('#time-slot').val();
                if (timeSlot == '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please Select A Time Slot'
                    })
                }
            }
        });
    </script>
@endsection
