<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'harga',
        'category_id',
    ];

    public function bahanbaku()
    {
        return $this->belongsToMany(BahanBaku::class)->withPivot('total');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
