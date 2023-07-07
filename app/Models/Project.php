<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'customer_id',
        'durasi',
        'jml_product', // jumlah product
        'hari_toleransi',
        'keterangan',
        'target',
        'status',
        'harga',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function targets()
    {
        return $this->hasMany(ProjectTarget::class);
    }

    public function entries()
    {
        return $this->hasMany(ProjectEntry::class);
    }

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class);
    }
}
