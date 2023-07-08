<?php

namespace App\Exports;

use App\Models\BahanBaku;
use App\Models\Category;
use App\Models\Pengiriman;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportStockInOut implements FromView
{
    public function view(): View
    {
        // dd(Pengiriman::get()->groupBy('tgl_pengiriman')->toArray());
        return view('stock.export', [
            'pengirimans' => Pengiriman::get(),
            'categories' => Category::get(),
            'bahanbakus' => BahanBaku::get(),
        ]);
    }
}
