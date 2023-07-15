<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    use HasFactory;

    protected $fillable = [
        'tgl_pengiriman',
        'driver_id',
        'truck_id',
        'penjualan_id',
        'jml_product',
        'jam',
        'solar',
        'status',
        'jarak',
        //Kolom" Tambahan dari Nota Pengiriman
        'untuk_pengecoran',
        'lokasi_pengecoran',
        'dry_automatic',
        'slump_permintaan',
        'waktu_tempuh',
        'rit',
    ];

    protected $table = 'pengiriman';

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }
}
