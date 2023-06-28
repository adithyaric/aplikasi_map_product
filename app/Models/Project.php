<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'durasi',
        'jml_product', // jumlah product
        'hari_toleransi',
        'keterangan',
        'target',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function targets()
    {
        return $this->hasMany(ProjectTarget::class);
    }
}
