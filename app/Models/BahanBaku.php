<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'harga',
        'stock',
        'category_id',
        'satuan_id',
    ];

    public function product()
    {
        return $this->belongsToMany(Product::class)->withPivot('total');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class);
    }
}
