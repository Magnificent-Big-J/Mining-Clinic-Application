<?php

namespace App\Jobs;

use App\Mail\MedicalAidInvoince;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendInvoiceToMedicalAid implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $medicalAid;
    public $appointment;
    public $medical_email_address;

    public function __construct($appointment, $medicalAid)
    {
        $this->appointment = $appointment;
        $this->medicalAid = $medicalAid;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->medical_email_address)->send(new MedicalAidInvoince($this->appointment, $this->appointment->patient->medicalAid));
    }
}
