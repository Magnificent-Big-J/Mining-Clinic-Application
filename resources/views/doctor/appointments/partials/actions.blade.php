
<table class="table">
    <tr>
        <td>
            <a href="{{route('doctor.appointment.details', $appointment->id)}}" class="btn btn-sm bg-info-light">
                <i class="far fa-eye"></i> View
            </a>
        </td>
        <td>
            <a href="{{route('doctor.refer.patient', $appointment->id)}}" class="btn btn-sm bg-warning-light">
                <i class="far fa-eye"></i> Refer
            </a>
        </td>
        @if ($appointment->appointmentAssessment->count() === 0)
            <td>
                <a data-toggle="modal" href="#doctor-consultation-modal" id="{{$appointment->id}}" class="btn btn-sm bg-info-light capture-doctor-consultation">
                    <i class="far fa-eye"></i> Select Consultations
                </a>
            </td>
        @endif
        @if($appointment->status === \App\Models\Appointment::PENDING_STATUS)
            <td>
                <button type="button" class="btn btn-sm bg-success-light mx-1 accept-appointment" id="{{$appointment->id}}">
                   <i class="fa fa-check"></i> Accept
                </button>
            </td>
            <td>
                <button type="button" class="btn btn-sm bg-danger-light mx-1 decline-appointment" id="{{$appointment->id}}">
                   <i class="fa fa-times"></i> Decline
                </button>
            </td>
        @elseif ($appointment->status === \App\Models\Appointment::ACCEPTED_STATUS)
            <td>
               <button type="button" class="btn btn-sm bg-success-light mx-1 complete-appointment" id="{{$appointment->id}}">
                 <i class="fa fa-check"></i> Mark as Done
               </button>
            </td>
            @if ($appointment->prescriptions->count())
                <td>
                    <a href="{{route('doctor.patient.prescription', $appointment->id)}}" class="btn btn-sm bg-primary">
                        <i class="far fa-asterisk"></i> View Prescriptions
                    </a>
                </td>
                <td>
                    <form action="{{route('doctor.patient.prescription.delete', $appointment->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm bg-danger mx-1">
                            <i class="fa fa-check"></i> Delete All Prescriptions
                        </button>
                    </form>
                </td>
            @else
                @if (!$appointment->isPrescription())
                    <td>
                        <a href="{{route('doctor.prescriptions.appointment.index', $appointment->id)}}" class="btn btn-sm bg-primary-light">
                            <i class="far fa-asterisk"></i> Capture Prescriptions
                        </a>
                    </td>
                @else
                    <td>{{$appointment->isPrescription()}}</td>
                @endif
            @endif

            @if ($appointment->isXray())
                <td>
                    <a href="{{route('doctor.patient.show.document', $appointment->id)}}" class="btn btn-sm bg-info-light">
                        <i class="far fa-eye"></i> View X-Ray
                    </a>
                </td>
            @endif

            @if (!$appointment->isPrescription() && !$appointment->prescriptions->count())
               <td>
                   <a href="{{route('doctor.patient.prescription.upload', $appointment->id)}}" class="btn btn-sm bg-info-light">
                       <i class="far fa-asterisk"></i> Upload Prescription
                   </a>
               </td>
            @endif
            @if (!$appointment->isXray())
                <td>
                    <a href="{{route('doctor.patient.xray.create', $appointment->id)}}" class="btn btn-sm bg-primary-light">
                        <i class="far fa-asterisk"></i> Upload Xray(s)
                    </a>
                </td>
            @endif
        @endif
    </tr>
</table>






