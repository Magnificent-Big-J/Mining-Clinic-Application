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
                    <h3 class="page-title">Dispense Patient Medication</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">View Patient Medication</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class="row">
           <div class="col-lg-12">
               <div class="card">
                   <div class="card-body">
                       <div class="col-sm-8">
                           <div class="biller-info">
                               <h4 class="d-block">{{$appointment->patient->full_name}}</h4>
                               <span class="d-block text-sm text-muted"><i class="fas fa-{{strtolower($appointment->patient->gender)}} mr-1"></i>{{$appointment->patient->gender}}</span>
                               <span class="d-block text-sm text-muted">
                            <h5 class="mb-0">
                            @if((boolean)$appointment->patient->has_medical_aid)
                                    <i class="fas fa-credit-card"></i>Medical Aid
                                @else
                                    <i class="fas fa-money-bill-alt"></i>Cash Payment
                                @endif
                        </h5>
                        </span>
                           </div>
                       </div>
                       <div class="col-sm-4 text-sm-right">
                           <div class="billing-info">
                               <h4 class="d-block">{{$appointment->appointment_date}}</h4>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-title">Appointment Prescription</h4>
                    </div>
                    <div class="card-body">
                        @if ($isPdf)
                            <embed src="{{ asset($document_path)}}" width="100%" height="800" alt="pdf" />
                        @else
                            <img src="{{ asset($document_path)}}" class="img-fluid img-thumbnail">

                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Select Medication to dispense</h4>
                    </div>
                    <div class="card-body">
                        <!-- Add Item -->
                        <div class="add-more-item text-right">
                            <button type="button" id="add-column" class="btn btn-primary btn-sm mb-1"><i class="fas fa-plus-circle"></i> Add Item</button>
                        </div>
                        <!-- /Add Item -->
                        <div id="loader"></div>
                        <form method="post" id="dynamic-form">
                            <!-- Prescription Item -->
                            <div class="card card-table">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <span id="result"></span>
                                        <input type="hidden" name="doctor" value="{{$appointment->doctor->id}}" id="doctor">

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
                                        <button type="submit" id="save" class="btn btn-primary submit-btn">Save</button>
                                        <button type="reset" class="btn btn-secondary clear-btn">Clear</button>
                                    </div>
                                </div>
                            </div>
                            <!-- /Submit Section -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script>
        $(function (){
            $('#loader').hide();
            let count = 1;
            let doctor = $('#doctor').val()
            loadPrescription();

            $('#add-column').click(function (){
                loadPrescription();
            });
            $(document).on('click', '.remove', function(){
                $(this).closest("tr").remove();
            });
            $(document).on('click', '.clear-btn', function(){
                location.reload();
            })
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
                            window.setTimeout(function(){


                                window.location.href = "{{route('admin.dispense.medicine', $appointment->id)}}";

                            }, 5000);
                        }

                    }
                })
                $("#loader").hide();
                $('#save').attr('disabled', false);
            });

            function loadPrescription(e) {
                axios.get(`/api/add-prescription/${doctor}/${count}`)
                    .then((response)=> {

                        $('#dynamic-column').append(response.data);

                        $('#doctor-product-prescription_' + count).select2({
                            theme: "classic",
                            width: "resolve"
                        });
                        count++;
                    })
            }
        });
    </script>
@endsection
