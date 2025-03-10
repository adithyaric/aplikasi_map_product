<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'day',
        'capaian',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
