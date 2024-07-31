<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SponsershipCase extends Model
{
    use HasFactory;

    protected $fillable = [
        'sponsership_id',
        'status',
        'reject_reson',
        'start_date',
        'end_date',
        'end_reasone',
        'active'
    ];

    protected $casts = [
        'start_date' => 'date:Y/m/d',
        'end_date' => 'date:Y/m/d',
        'created_at' => 'date:Y/m/d',
        'updated_at' => 'date:Y/m/d',
    ];

    public function sponsership(): BelongsTo
    {
        return $this->belongsTo(sponsershipDocument::class);
    }
    public function sponsershipable(): MorphTo
    {
        return $this->morphTo();
    }
}
