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
        'start_date' => 'date:Y/m/d',
        'end_date' => 'date:Y/m/d',
        'created_at'=>'date:Y/m/d',
        'updated_at'=>'date:Y/m/d',
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
