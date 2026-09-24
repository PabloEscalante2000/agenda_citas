<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    /** @use HasFactory<\Database\Factories\PatientFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
    ];

    public function sesions()
    {
        return $this->hasMany(Sesion::class);
    }
}
