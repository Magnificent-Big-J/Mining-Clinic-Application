<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StockLevelMailNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $doctor;
    public $doctorProducts;

    public function __construct($doctor, $doctorProducts)
    {
        $this->doctor = $doctor;
        $this->doctorProducts = $doctorProducts;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.notifications.stock_level_notifications');
    }
}
