<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
    /** @use HasFactory<\Database\Factories\SesionFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'patient_id',
        'start_time',
        'end_time',
        'status',
    ];
}
