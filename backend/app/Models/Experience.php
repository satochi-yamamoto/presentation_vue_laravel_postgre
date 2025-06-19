<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'company',
        'position',
        'description',
        'start_date',
        'end_date',
        'is_current',
        'responsibilities',
        'display_order'
    ];

    protected $casts = [
        'is_current' => 'boolean',
        'responsibilities' => 'array',
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d'
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order')->orderBy('start_date', 'desc');
    }
}