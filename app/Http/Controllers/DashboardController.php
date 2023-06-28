<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $startDate = '2023-06-01';
        $endDate = '2023-06-30';
        $sundays = [];

        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);

        for ($i = $startDate; $i <= $endDate; $i = strtotime('+1 day', $i)) {
            if (date('w', $i) == 0) {
                $sundays[] = date('Y-m-d', $i);
            }
        }

        return view('dashboard.index');
    }
}
