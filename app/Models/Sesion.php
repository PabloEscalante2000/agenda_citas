<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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

    public function scopeVisibleFor(Builder $query, User $user): Builder
    {
        if($user->isAdmin()) {
            return $query;
        } else {
            return $query->where('user_id', $user->id);
        }
    }

    public function scopeOverLapping(Builder $query, int $userId, $start, $end, ?int $ignoredId = null): Builder
    {
        return $query->where("user_id", $userId)
            ->where("start_time","<",$end)
            ->where("end_time",">",$start)
            ->when($ignoredId, fn ($q) => $q->whereKeyNot($ignoredId));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
