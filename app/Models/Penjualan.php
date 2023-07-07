<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_invoice',
        'tgl_penjualan',
        'customer_id',
        'project_id',
        'total_barang',
        'harga',
        'diskon',
        'total',
        'metode_pembayaran',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function pengiriman()
    {
        return $this->hasMany(Pengiriman::class);
    }
}
