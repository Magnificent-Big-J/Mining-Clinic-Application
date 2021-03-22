<?php

namespace App\Jobs;

use App\Mail\StockLevelMailNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ClinicStockLevelNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $clinicProducts;
    public $user;
    public $clinic;

    public function __construct($clinicProducts, $user, $clinic)
    {
        $this->clinicProducts = $clinicProducts;
        $this->user = $user;
        $this->clinic = $clinic;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->user)->send(new StockLevelMailNotification($this->clinicProducts, $this->user, $this->clinic));
    }
}
