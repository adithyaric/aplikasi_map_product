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

        // Format dates for the filename
        $startDateFormatted = $startDate->format('Ymd');
        $endDateFormatted = $endDate->format('Ymd');

        // Build the filename
        $filename = "product_distribution_report_{$startDateFormatted}_to_{$endDateFormatted}.xlsx";

        return Excel::download(new ExportData($startDate, $endDate), $filename);
    }
}
