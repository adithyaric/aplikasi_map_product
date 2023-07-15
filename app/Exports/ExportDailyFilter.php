<?php

namespace App\Exports;

use App\Models\Category;
use App\Models\Pengiriman;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportDailyFilter implements FromView, WithEvents
{
    protected $customer_id;

    protected $tanggal;

    public function __construct($tanggal, $customer_id)
    {
        $this->tanggal = $tanggal;
        $this->customer_id = $customer_id;
    }

    public function view(): View
    {
        return view('pengiriman.daily', [
            'pengirimans' => Pengiriman::where('tgl_pengiriman', $this->tanggal)->whereHas('penjualan.customer', function ($query) {
                $query->where('id', $this->customer_id);
            })->get(),
            'pengirimansGroupedByTruck' => Pengiriman::query()
                ->where('tgl_pengiriman', $this->tanggal)
                ->whereHas('penjualan.customer', function ($query) {
                    $query->where('id', $this->customer_id);
                })
                ->get()
                ->groupBy(['truck.no_plat', 'driver.name']),

            'categories' => Category::get(),
            'tanggal' => Carbon::parse($this->tanggal)->format('d-m-Y'),
        ]);
    }

    public function registerEvents(): array
    {
        $sheetRanges = [
            'A1:K8', //Center
            'A2:K2', //Bold
            'A6:K6', //Bold
            'A9:K10', //Fill blue
        ];

        return [
            AfterSheet::class => function (AfterSheet $event) use ($sheetRanges) {
                $lastRow = $event->sheet->getHighestRow();
                $event->sheet->getStyle("A8:K{$lastRow}")
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
                        'font' => [
                            'bold' => true,
                            'size' => 18,
                        ],
                    ]);

                $event->sheet->getStyle($sheetRanges[2])
                    ->applyFromArray([
                        'font' => [
                            'bold' => true,
                            'size' => 18,
                        ],
                    ]);

                $event->sheet->getStyle($sheetRanges[3])
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
