@extends('layouts.doctor')
@section('title')Mining Clinic - Doctor Appointments @endsection
@section('styles')
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
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
                            <li class="breadcrumb-item active" aria-current="page">Prescriptions</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">Appointment Prescriptions</h2>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">

                    <h4 class="card-title mb-0">Add Prescription</h4>


            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="biller-info">
                        <h4 class="d-block">{{$appointment->patient->full_name}}</h4>
                        <span class="d-block text-sm text-muted"><i class="fas fa-{{strtolower($appointment->patient->gender)}} mr-1"></i>{{$appointment->patient->gender}}</span>
                        <span><i class="fas fa-phone"></i>{{ $appointment->patient->cell_number }}</span>

                    </div>
                </div>
                <div class="col-sm-6 text-sm-right">
                    <div class="billing-info">
                        <h4 class="d-block">{{$appointment->appointment_date}}</h4>
                    </div>
                </div>
            </div>

            <!-- Add Item -->
            <div class="add-more-item text-right">
                <a  id="add-column"><i class="fas fa-plus-circle"></i> Add Item</a>
                <a href="{{route('doctor.new.appointments')}}" class="btn btn-primary text-white">Back</a>
            </div>
            <!-- /Add Item -->
            <div id="loader"></div>
            <form method="post" id="dynamic-form">
            <!-- Prescription Item -->
            <div class="card card-table">
                <div class="card-body">
                    <div class="table-responsive">
                        <span id="result"></span>
                        <input type="hidden" name="clinic" value="{{$appointment->clinic_id}}" id="clinic">

                            <input type="hidden" name="appointment" value="{{$appointment->id}}">
                            <table class="table table-hover table-center">
                                <thead>
                                <tr>
                                    <th style="min-width: 200px">Name</th>
                                    <th style="min-width: 100px">Quantity</th>
                                    <th style="min-width: 100px">Days</th>
                                    <th style="min-width: 100px;">Time</th>
                                    <th style="min-width: 80px;"></th>
                                </tr>
                                </thead>
                                <tbody id="dynamic-column">

                                </tbody>
                            </table>

                    </div>
                </div>
            </div>
            <!-- /Prescription Item -->

            <!-- Signature -->
            {{--<div class="row">
                <div class="col-md-12 text-right">
                    <div class="signature-wrap">
                        <div class="signature">
                            Click here to sign
                        </div>
                        <div class="sign-name">
                            <p class="mb-0">( Dr. Darren Elder )</p>
                            <span class="text-muted">Signature</span>
                        </div>
                    </div>
                </div>
            </div> --}}
            <!-- /Signature -->

            <!-- Submit Section -->
            <div class="row">
                <div class="col-md-12">
                    <div class="submit-section">
                       <div class="row">
                           <div class="col-lg-6">
                               <button type="submit" id="save" class="btn btn-primary ">Save</button>
                           </div>
                           <div class="col-lg-6">
                               <button type="reset" class="btn btn-secondary clear-btn">Clear</button>
                           </div>
                       </div>

                    </div>
                </div>
            </div>
            <!-- /Submit Section -->
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script>
        $(function () {
            $("#loader").hide();
            let count = 1;
            let clinic = $('#clinic').val()
            loadPrescription();

            $('#add-column').click(function (){
                loadPrescription();
            });
            $(document).on('click', '.remove', function(){
                $(this).closest("tr").remove();
            });
            $(document).on('click', '.clear-btn', function(){
                location.reload();
            });

            $('#dynamic-form').on('submit',function (e){
                e.preventDefault();
                $("#loader").show();
                $.ajax({
                    url:'/api/store-prescription',
                    method:'post',
                    data:$(this).serialize(),
                    dataType:'json',
                    beforeSend:function(){
                        $('#save').attr('disabled','disabled');
                    },
                    success:function(data)
                    {
                        if(data.error)
                        {
                            var error_html = '';
                            for(var count = 0; count < data.error.length; count++)
                            {
                                error_html += '<p>'+data.error[count]+'</p>';
                            }
                            $('#result').html('<div class="alert alert-danger">'+error_html+'</div>');
                        }
                        else
                        {

                            $('#result').html('<div class="alert alert-success">'+data.success+'</div>');
                        }

                    }
                })
                $("#loader").hide();
                $('#save').attr('disabled', true);
            });


            function loadPrescription(e) {
                axios.get(`/api/add-prescription/${clinic}/${count}`)
                .then((response)=> {

                    $('#dynamic-column').append(response.data);

                    $('#clinic-product-prescription_' + count).select2({
                        theme: "classic",
                        width: "resolve"
                    });
                    count++;
                })
            }
        });
    </script>
@endsection
