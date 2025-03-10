<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'type', // ['provinsi', 'kabupaten', 'kecamatan', 'desa', 'dusun']
        'parent_id', // To establish hierarchy
        'coordinates', // Polygon coordinates
    ];

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
            ->withPivot(['user_id', 'date', 'quantity', 'location_dusun_id', 'location_desa_id', 'location_kecamatan_id', 'location_kabupaten_id', 'location_provinsi_id'])
            ->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'location_user')->withTimestamps();
    }
}
