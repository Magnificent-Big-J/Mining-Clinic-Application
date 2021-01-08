<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MedicalAidInvoince extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $medicalAid;
    public $appointment;

    public function __construct($appointment, $medicalAid)
    {
        $this->appointment = $appointment;
        $this->medicalAid = $medicalAid;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.medicalaid.notification');
    }
}
