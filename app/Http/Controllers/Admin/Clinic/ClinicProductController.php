<?php

namespace App\Http\Controllers\Admin\Clinic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClinicProductController extends Controller
{
    public function index()
    {
        return view('admin.clinic-stock.index');
    }
}
