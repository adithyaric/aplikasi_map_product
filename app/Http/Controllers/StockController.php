<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;

class StockController extends Controller
{
    public function index()
    {
        return view('stock.index', [
            'bahanbakus' => BahanBaku::get(),
        ]);
    }
}
