<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    use HasFactory;

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
