@extends('emails.base')
@section('content')
    <div class="card">

        <div class="card-body">
            Dear {{$appointment->patient->full_name}},<br><br>

            Here is your invoice.<br>


            <h4>Appointment Screening Information: </h4>

            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Screening Type</th>
                    <th>Screening Question</th>
                    <th>Screening Answer</th>
                </tr>
                </thead>
                <tbody>
                @foreach($appointment->screening as $screening)
                    <tr>
                        <td>{{$screening->screeningQuestionnaire->screeningType->name}}</td>
                        <td>{{$screening->screeningQuestionnaire->name}}</td>
                        <td>{{$screening->screening_answer}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <h4>Appointment information:</h4>

            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Appointment Date</th>
                    <th>Appointment Time</th>
                    <th>Consultation Fee</th>
                    <th>Consultation</th>
                    <th>Consultation Category</th>
                </tr>
                </thead>
                <tbody>
                <div style="display: none">
                    {{ $consultationTotal = 0 }}
                </div>
                @foreach($appointment->appointmentAssessment as $assessment)
                    <tr>
                        <td>{{$assessment->appointment->appointment_date}}</td>
                        <td>{{$assessment->appointment->appointment_time}}</td>
                        <td class="text-right">R {{$assessment->consultationFee->consultation_fee}}</td>
                        <td>{{$assessment->consultationFee->consultation->name}}</td>
                        <td>{{$assessment->consultationFee->consultation->consultationCategory->name}}</td>
                        <div
                            style="display: none">{{$consultationTotal += $assessment->consultationFee->consultation_fee}}</div>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4">Total</td>

                    <td class="text-right">R {{number_format($consultationTotal, 2, '.', '')}}</td>
                </tr>
                </tbody>
            </table>
            <h4>Medication</h4>

            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Medicine</th>
                    <th>Days</th>
                    <th>Quantity</th>
                    <th>Period</th>
                    <th>Price</th>

                </tr>
                </thead>
                <tbody>
                <div style="display: none">
                    {{ $total = 0 }}
                </div>
                @foreach($appointment->prescriptions as $prescription)
                    <tr>
                        <td>{{$prescription->doctorProduct->product->product_name}}</td>
                        <td>{{$prescription->days}}</td>
                        <td class="text-right">{{$prescription->quantity}}</td>
                        <td>{{$prescription->usage}}</td>
                        <td class="text-right">R {{$prescription->doctorProduct->price}}</td>

                        <div style="display: none">{{$total += $prescription->doctorProduct->price}}</div>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4">Total</td>

                    <td class="text-right">R {{number_format($total, 2, '.', '')}}</td>
                </tr>
                </tbody>
            </table>

            <p> Appointment Total Cost: R {{number_format($total + $consultationTotal, 2, '.', '')}}</p><br>

            Thanks,<br>
            {{ config('app.name') }}
        </div>
    </div>
@endsection
