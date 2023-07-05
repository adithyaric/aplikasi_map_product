<?php

namespace App\Exports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportProject implements FromQuery, WithHeadings, WithMapping
{
    protected $startDate;

    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function query()
    {
        return Project::query()->whereBetween('created_at', [$this->startDate, $this->endDate]);
    }

    public function headings(): array
    {
        return [
            'Tanggal : '.$this->startDate.' - '.$this->endDate,
            'No',
            'Customer',
            'TGL',
            'Produk Diminta',
            'Produk Dibuat',
            'Harga Project',
            'Ket',
        ];
    }

    public function map($project): array
    {
        return [
            '',
            $project->id,
            $project->customer->name,
            $project->created_at,
            $project->jml_product,
            $project->entries->sum('capaian'),
            $project,
            $project->keterangan,
        ];
    }
}
