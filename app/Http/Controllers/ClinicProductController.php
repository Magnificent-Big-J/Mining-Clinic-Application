<?php

namespace App\Http\Controllers;

use App\ClinicProduct;
use App\Exports\ClinicProductStockExport;
use App\Models\Clinic;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ClinicProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\ClinicProduct  $clinicProduct
     * @return \Illuminate\Http\Response
     */
    public function show(ClinicProduct $clinicProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClinicProduct  $clinicProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(ClinicProduct $clinicProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ClinicProduct  $clinicProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClinicProduct $clinicProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClinicProduct  $clinicProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClinicProduct $clinicProduct)
    {
        //
    }
    public function exportMiningProducts(Request $request)
    {
        $clinic = Clinic::find($request->clinic_id);
        return  Excel::download(new ClinicProductStockExport($clinic), "{$clinic->clinic_name}.xlsx");
    }
}
