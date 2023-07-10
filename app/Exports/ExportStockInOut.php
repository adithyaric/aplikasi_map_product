<?php

namespace App\Exports;

use App\Models\BahanBaku;
use App\Models\Category;
use App\Models\Pengiriman;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportStockInOut implements FromView, WithEvents
{
    public function view(): View
    {
        // dd(Pengiriman::get()->groupBy('tgl_pengiriman')->toArray());
        return view('stock.export', [
            'pengirimans' => Pengiriman::get()->sortBy('tgl_pengiriman'),
            'categories' => Category::get(),
            'bahanbakus' => BahanBaku::get(),
        ]);
    }

    public function registerEvents(): array
    {
        $sheetRanges = [
            'A1:Y2', //Center
            'A1:Y2', //Fill blue
        ];

        return [
            AfterSheet::class => function (AfterSheet $event) use ($sheetRanges) {
                $lastRow = $event->sheet->getHighestRow();
                $event->sheet->getStyle("A1:Y{$lastRow}")
                    ->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ],
                    ]);

                $event->sheet->getStyle($sheetRanges[0])
                    ->applyFromArray([
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        ],
                    ]);

                $event->sheet->getStyle($sheetRanges[1])
                    ->applyFromArray([
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'color' => [
                                'argb' => '9dc3e6',
                            ],
                        ],
                    ]);
            },
        ];
    }
}
