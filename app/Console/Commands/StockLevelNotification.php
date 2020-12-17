<?php

namespace App\Console\Commands;

use App\Mail\StockLevelMailNotification;
use App\Models\Doctor;
use App\Models\DoctorProduct;
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
        $doctors = Doctor::all();

        foreach ($doctors as $doctor) {
              $doctorProducts = DoctorProduct::where('doctor_id', '=', $doctor->id)
                ->where('threshold', '>', DB::raw('quantity'))->get();
              if ($doctorProducts->count()) {
                    Mail::to($doctor->email)->send(new StockLevelMailNotification($doctor, $doctorProducts));
              }

        }

        return 0;
    }
}
