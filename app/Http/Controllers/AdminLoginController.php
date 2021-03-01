<?php

namespace App\Http\Controllers;

use App\Models\AdminLogin;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminLoginController extends Controller
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
        AdminLogin::create([
            'user_id'=> auth()->user()->id,
            'clinic_id'=> $request->clinic,
            'log_on_date' => Carbon::now()
        ]);

        return response()->json([
            'success'  => 'Thank you. Please proceed with your work',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AdminLogin  $adminLogin
     * @return \Illuminate\Http\Response
     */
    public function show(AdminLogin $adminLogin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AdminLogin  $adminLogin
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminLogin $adminLogin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AdminLogin  $adminLogin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdminLogin $adminLogin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AdminLogin  $adminLogin
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdminLogin $adminLogin)
    {
        //
    }
}
