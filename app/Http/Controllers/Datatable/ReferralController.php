<?php

namespace App\Http\Controllers\Datatable;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Doctor;
use App\Models\Referral;
use Illuminate\Http\Request;
use DataTables;

class ReferralController extends Controller
{
    public function referrals()
    {
        $referrals = Referral::where('doctor_id', '=', auth()->user()->doctor->id)->get();
        return DataTables::of($referrals)
            ->addIndexColumn()
            ->addColumn('patient_name', function ($row){
                return $row->patient->full_name;
            })
            ->addColumn('referral_date', function ($row){
                return $row->referred_date;
            })
            ->addColumn('referred_by', function ($row){

                return $row->refer_by_who;
            })
            ->addColumn('actions', function ($row){
                return view('doctor.referrals.partials.actions', compact('row'));
            })
            ->rawColumns(['patient_name', 'referred_by', 'referral_date', 'actions'])
            ->make(true);
        return $this->dataTables($referrals, 1);
    }
    public function myReferred()
    {
        $referrals = Referral::where('referred_by', '=', auth()->user()->doctor->id)->get();
        return DataTables::of($referrals)
            ->addIndexColumn()
            ->addColumn('patient_name', function ($row){
                return $row->patient->full_name;
            })
            ->addColumn('referral_date', function ($row){
                return $row->referred_date;
            })
            ->addColumn('referred_to', function ($row){

                return $row->doctor->entity_name;
            })
            ->addColumn('actions', function ($row){
                return view('doctor.referrals.partials.actions', compact('row'));
            })
            ->rawColumns(['patient_name', 'referred_by', 'referral_date', 'actions'])
            ->make(true);
        return $this->dataTables($referrals, 2);
    }

    private function dataTables($referrals, $type)
    {

    }
}
