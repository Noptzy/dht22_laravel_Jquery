<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorData extends Model
{
    use HasFactory;

    // Menambahkan kolom yang boleh diisi secara massal
    protected $fillable = [
        'temperature', 'humidity'
    ];
}
