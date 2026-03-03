<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'plate_number',
        'brand',
        'model',
        'year',
        'capacity',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'year' => 'integer',
        'capacity' => 'integer',
    ];
}
