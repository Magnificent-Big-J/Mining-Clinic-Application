<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorProduct;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Validator;

class PrescriptionController extends Controller
{
    public function addPrescription(Doctor $doctor, $count)
    {
        $doctorProducts = DoctorProduct::where('doctor_id', '=', $doctor->id)->get();

        return view('doctor.prescriptions.partials.prescription', compact('doctorProducts', 'count'));
    }
    public function store(Request $request)
    {
        $rules = array(
            'doctor_products.*'  => 'required',
            'quantity.*'  => 'required',
            'days.*'  => 'required',
        );
        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json([
                'error'  => $error->errors()->all()
            ]);
        }

        $doctor_products = $request->doctor_products;
        for($i = 0, $iMax = count($doctor_products); $i < $iMax; $i++)
        {
            $data = array(
                'doctor_product_id' => $doctor_products[$i],
                'appointment_id'  => $request->appointment,
                'days'  => $request->days[$i],
                'quantity'  => $request->quantity[$i],
            );
            if ($request->has('morning_time')) {
               $data['morning_time'] = 1;
            }
            if ($request->has('afternoon_time')) {
                $data['afternoon_time'] = 1;
            }
            if ($request->has('evening_time')) {
               $data['evening_time'] = 1;
            }
            if ($request->has('night_time')) {
                $data['night_time'] = 1;
            }

            $insert_data[] = $data;
        }

        Prescription::insert($insert_data);
        return response()->json([
            'success'  => 'Prescriptions successfully Added.'
        ]);

    }
}
