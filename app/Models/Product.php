<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        // 'harga',
    ];

    public function locations()
    {
        return $this->belongsToMany(Location::class, 'location_product')
            ->withPivot(['user_id', 'date', 'quantity'])
            ->withTimestamps();
    }
}
