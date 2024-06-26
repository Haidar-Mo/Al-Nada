<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class DonationCampaign extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'campaign_id',
        'type',
        'amount',
        'description',
        'deliver_type',
        'address',
        'created_at',
        'updated_at',
    ];


    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function bill(): MorphMany
    {
        return  $this->morphMany(BillingHistory::class, 'billable');
    }
}
