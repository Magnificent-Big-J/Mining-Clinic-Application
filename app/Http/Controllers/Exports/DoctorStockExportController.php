<?php

namespace App\Http\Controllers\Exports;

use App\Exports\DoctorStockExport;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DoctorStockExportController extends Controller
{
    public function exportStocks(Request $request)
    {
        if (!empty($request->from_date) && !empty($request->to_date)) {
            $range = [
                Carbon::parse($request->from_date), Carbon::parse($request->to_date)
            ];
        } else {
            $range = [
                Carbon::now()->firstOfMonth(), Carbon::now()->lastOfMonth()
            ];
        }

      return  Excel::download(new DoctorStockExport($range, $request->doctor), 'Stock Report.xlsx');
    }
}
