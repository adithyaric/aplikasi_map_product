<?php

namespace App\Exports;

use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportProject implements FromView, WithEvents
{
    protected $startDate;

    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function view(): View
    {
        return view('projects.export', [
            'projects' => Project::query()
                ->whereBetween('created_at', [$this->startDate, $this->endDate])
                ->get(),
            'startDate' => Carbon::parse($this->startDate)->format('d-m-Y'),
            'endDate' => Carbon::parse($this->endDate)->format('d-m-Y'),
        ]);
    }

    public function registerEvents(): array
    {
        $sheetRanges = [
            'A1:G9', //Center
            'A2:G2', //Bold
            'A6:G6', //Bold
            'A9:G9', //Fill blue
        ];

        return [
            AfterSheet::class => function (AfterSheet $event) use ($sheetRanges) {
                $lastRow = $event->sheet->getHighestRow();
                $event->sheet->getStyle("A8:G{$lastRow}")
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
