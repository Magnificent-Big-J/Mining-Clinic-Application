<?php

namespace App\Http\Controllers;


use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Service\AppointmentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        if(auth()->user()->isSuperAdmin()) {
            $stats = AppointmentService::stats();
            $doctors = Doctor::limit(5)->get();
            $patients = Patient::limit(5)->get();
            $appointments = Appointment::where('appointment_date', '>=', Carbon::now())->limit(5)->get();

            return  view('admin.dashboard.dashboard', compact('stats', 'doctors', 'patients', 'appointments'));
        }
        return view('home');
    }
}
