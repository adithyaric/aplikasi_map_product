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
        return Pengiriman::query()
            ->with(['penjualan.project.product', 'penjualan.project'])
            ->whereBetween('tgl_pengiriman', [$this->startDate, $this->endDate]);
    }

    public function headings(): array
    {
        return [
            'Tanggal : '.$this->startDate.' - '.$this->endDate,
            'No',
            'TGL',
            'Produk',
            'Jumlah',
            'Satuan',
            'Harga',
            'Total',
            'Ket',
        ];
    }

    public function map($pengiriman): array
    {
        $satuan = $pengiriman->penjualan->project->product->bahanbaku->map(function ($bahanbaku) {
            return $bahanbaku->name.' ('.$bahanbaku->satuan->name.')';
        })->join(', ');

        return [
            '',
            $pengiriman->id,
            $pengiriman->tgl_pengiriman,
            $pengiriman->penjualan->project->product->name,
            $pengiriman->jml_product,
            $satuan,
            $pengiriman->penjualan->harga,
            $pengiriman->penjualan->total,
            $pengiriman->penjualan->project->keterangan,
        ];
    }
}
