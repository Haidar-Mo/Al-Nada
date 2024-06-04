<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SponsershipType extends Model
{
    use HasFactory;

    protected $fillable = [
        'sponsership_id',
        'start_date',
        'end_date',
        'end_reasone',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function sponserships(): BelongsTo
    {
        return $this->belongsTo(Sponsership::class);
    }
    public function sponsershipable()
    {
        return $this->morphTo();
    }
}
