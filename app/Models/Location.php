<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'type', 'parent_id', 'coordinates'];

    public function parent()
    {
        return $this->belongsTo(Location::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Location::class, 'parent_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'location_product')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
