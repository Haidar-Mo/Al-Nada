<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class OrphanFamilyChild extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'family_id',
        'name',
        'birth_date',
        'academic_level',
        'is_supported',
        'visible',
        'min_sponsorship_payment',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];


    /**
     * The accessors to append to the model's array form.
     * 
     * @var array<int, string>
     */
    protected $appends = [
        'age',
    ];

    public function family(): BelongsTo
    {
        return $this->belongsTo(OrphanFamily::class, 'family_id');
    }

    public function case(): MorphMany
    {
        return $this->morphMany(SponsorshipCase::class, 'sponsorshipable');
    }

    public function statusUpdate(): MorphMany
    {
        return $this->morphMany(StatusUpdate::class, 'statusable');
    }

    /** Appends Attributes */

    public function getAgeAttribute()
    {
        return Carbon::parse($this->birth_date)->diffInYears();
    }
}
