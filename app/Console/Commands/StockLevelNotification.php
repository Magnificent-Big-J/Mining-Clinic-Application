<?php

namespace App\Console\Commands;

use App\Mail\StockLevelMailNotification;
use App\Models\ClinicProduct;
use App\Models\Doctor;
use App\Models\DoctorProduct;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class StockLevelNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'level:notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notifications when stock is below thresholds';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $clinics = clinic::all();

        foreach ($clinics as $clinic) {
              $clinicProducts = ClinicProduct::where('clinic_id', '=', $clinic->id)
                ->where('threshold', '>', DB::raw('quantity'))->get();
              if ($clinicProducts->count()) {

                    //Mail::to($doctor->email)->send(new StockLevelMailNotification($doctor, $clinicProducts));
              }

        }

        return 0;
    }
}
