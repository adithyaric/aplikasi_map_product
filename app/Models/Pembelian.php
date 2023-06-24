<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $fillable = [
        'bahan_baku_id',
        'category_id',
        'harga',
        'jumlah',
        'keterangan',
    ];

    public function bahanbaku()
    {
        return $this->belongsTo(BahanBaku::class, 'bahan_baku_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
