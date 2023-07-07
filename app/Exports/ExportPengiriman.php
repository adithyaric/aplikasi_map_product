<?php

namespace App\Exports;

use App\Models\Pengiriman;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportPengiriman implements FromQuery, WithHeadings, WithMapping
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
        return Pengiriman::query()->whereBetween('tgl_pengiriman', [$this->startDate, $this->endDate]);
    }

    public function headings(): array
    {
        return [
            'Tanggal : '.$this->startDate.' - '.$this->endDate,
            'No',
            'TGL',
            'No. POL',
            'Driver',
            'No. Order Penjualan',
            'Jarak Tempuh (KM)',
            'Total Solar Digunakan (L)',
            'Ket',
        ];
    }

    public function map($pengiriman): array
    {
        return [
            '',
            $pengiriman->id,
            $pengiriman->tgl_pengiriman,
            $pengiriman->driver->no_plat,
            $pengiriman->driver->name,
            $pengiriman->penjualan->no_invoice,
            $pengiriman->jarak,
            $pengiriman->solar,
            $pengiriman->penjualan->project->keterangan,
        ];
    }
}
