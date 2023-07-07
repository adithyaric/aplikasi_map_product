<?php

namespace App\Exports;

use App\Models\Category;
use App\Models\Pengiriman;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportDaily implements FromView
{
    protected $tanggal;

    public function __construct($tanggal)
    {
        $this->tanggal = $tanggal;
    }

    public function view(): View
    {
        return view('pengiriman.daily', [
            'pengirimans' => Pengiriman::where('tgl_pengiriman', $this->tanggal)->get(),
            'categories' => Category::get(),
        ]);
    }
}
