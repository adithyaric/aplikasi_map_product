<?php

namespace App\Exports;

use App\Models\Pembelian;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportPembelianFilterSupplier implements FromView, WithEvents
{
    protected $supplier_id;

    protected $startDate;

    protected $endDate;

    public function __construct($startDate, $endDate, $supplier_id)
    {
        $this->supplier_id = $supplier_id;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function view(): View
    {
        return view('pembelians.export', [
            'pembelians' => Pembelian::query()
                ->with(['bahanbaku', 'category'])
                ->whereBetween('tgl_dibuat', [$this->startDate, $this->endDate])
                ->where('supplier_id', $this->supplier_id)
                ->get(),
            'startDate' => Carbon::parse($this->startDate)->format('d-m-Y'),
            'endDate' => Carbon::parse($this->endDate)->format('d-m-Y'),
        ]);
    }

    public function registerEvents(): array
    {
        $sheetRanges = [
            'A1:J9', //Center
            'A2:J2', //Bold
            'A6:J6', //Bold
            'A9:J9', //Fill blue
        ];

        return [
            AfterSheet::class => function (AfterSheet $event) use ($sheetRanges) {
                $lastRow = $event->sheet->getHighestRow();
                $total = $event->sheet->getHighestRow() - 3;
                $event->sheet->getStyle("A8:J{$lastRow}")
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

                $event->sheet->getStyle("A{$total}:F{$lastRow}")
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
