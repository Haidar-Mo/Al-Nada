<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SponsorshipCase extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'status',
        'reject_reason',
        'start_date',
        'end_date',
        'end_reason',
        'active'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date:Y/m/d',
        'end_date' => 'date:Y/m/d',
        'created_at' => 'date:Y/m/d',
        'updated_at' => 'date:Y/m/d',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function sponsorshipable(): MorphTo
    {
        return $this->morphTo();
    }

    public function payment()
    {
        return $this->hasMany(SponsorshipPaymentCase::class, 'case_id');
    }

    public function createPaidCase()
    {
        return $this->payment()->create([
            'case_id' => $this->id,
            'user_id' => $this->user_id,
            'amount' => $this->sponsorshipable->amount,
            'paid' => 0
        ]);
    }
}
