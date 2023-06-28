<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTarget extends Model
{
    use HasFactory;

    protected $fillable = [
        'day',
        'target',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
