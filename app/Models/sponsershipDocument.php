<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class sponsershipDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'fixed_phone_number',
        'address',
        'academic_level',
        'job',
        'job_address',
        'available',
        'communicate_by_phone',
        'communicate_by_text_messages',
        'communicate_by_email',
        'communicate_with_the_sponsered_person',
        'participate_in_activities',
        'recognizing_way',
        'active',
        'document_status'
    ];

    protected $casts = [
        'created_at' => 'date:Y/m/d',
        'updated_at' => 'date:Y/m/d',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function target(): HasMany
    {
        return $this->hasMany(SponsershipCase::class, 'sponsership_id');
    }
}
