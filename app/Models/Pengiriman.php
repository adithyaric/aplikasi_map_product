<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    use HasFactory;

    protected $fillable = [
        'tgl_pengiriman',
        'customer_id',
        'driver_id',
        'project_id',
        'penjualan_id',
        'jml_product',
        'jam',
    ];

    protected $table = 'pengiriman';

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }
}
