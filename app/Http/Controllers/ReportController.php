<?php

namespace App\Http\Controllers;

use App\Exports\ExportData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        return view('report.index', []);
    }

    public function export(Request $request)
    {
        $tanggal = $request->query('tanggal');
        if ($tanggal) {
            [$startDate, $endDate] = explode(' - ', $tanggal);
            $startDate = Carbon::parse($startDate);
            $endDate = Carbon::parse($endDate);
        } else {
            $startDate = Carbon::minValue();
            $endDate = Carbon::maxValue();
        }

        return Excel::download(new ExportData($startDate, $endDate), 'product_distribution_report.xlsx');
    }
}
