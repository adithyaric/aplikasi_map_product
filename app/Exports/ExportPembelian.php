<?php

namespace App\Exports;

use App\Models\Pembelian;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportPembelian implements FromQuery, WithHeadings, WithMapping
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
        return Pembelian::query()
            ->with(['bahanbaku', 'category'])
            ->whereBetween('tgl_dibuat', [$this->startDate, $this->endDate]);
    }

    public function headings(): array
    {
        return [
            'Tanggal : '.$this->startDate.' - '.$this->endDate,
            'No',
            'TGL',
            'Nama Bahan Baku',
            'Jumlah',
            'Satuan',
            'Harga',
            'Total',
            'Ket',
        ];
    }

    public function map($Pembelian): array
    {
        // dd($Pembelian->bahanbaku->product->toArray());
        return [
            '',
            $Pembelian->id,
            $Pembelian->tgl_dibuat,
            $Pembelian->bahanbaku->name,
            $Pembelian->jumlah,
            $Pembelian->bahanbaku->satuan->name,
            $Pembelian->harga,
            $Pembelian->harga * $Pembelian->jumlah,
            $Pembelian->keterangan,
        ];
    }
}
