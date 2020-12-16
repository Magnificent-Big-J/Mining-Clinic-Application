<?php

namespace App\Http\Controllers;

use App\Models\DoctorProduct;
use App\Models\Doctor;
use App\Models\Product;
use Illuminate\Http\Request;

class DoctorProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Doctor $doctor)
    {
        $productIds = DoctorProduct::where('doctor_id', '=', $doctor->id)->pluck('product_id')->toArray();

        $products = Product::whereNotIn('id', $productIds)->get();

        return view('admin.doctors.doctor_product', compact('doctor', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DoctorProduct  $doctorProduct
     * @return \Illuminate\Http\Response
     */
    public function show(DoctorProduct $doctorProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DoctorProduct  $doctorProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(DoctorProduct $doctorProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DoctorProduct  $doctorProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DoctorProduct $doctorProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DoctorProduct  $doctorProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(DoctorProduct $doctorProduct)
    {
        //
    }
}
