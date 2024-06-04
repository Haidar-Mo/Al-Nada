<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sponsership extends Model
{
    use HasFactory;

    protected $fillable = [
        'partner_name',
        'fixed_phone_number',
        'job',
        'job_address',
        'Communicate_by_phone',
        'Communicate_by_text_messages',
        'Communicate_by_email',
        'Communicate_with_the_sponsered_person',
        'Participate_in_activities',
        'notes',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function type(): HasMany
    {
        return $this->hasMany(SponsershipType::class);
    }
}
