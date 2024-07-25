<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class VolunteeringInCampaignRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'first_name',
        'last_name',
        'phone_number',
        'reason_for_volunteering',
        'academic_level',
        'city_id',
        'address',
        'status',
    ];

    protected $casts = [
        'created_at' => 'date:Y/m/d',
        'updated_at' => 'date:Y/m/d',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function volunteer(): HasOne
    {
        return $this->hasOne(VolunteerInCampaign::class,'request_id');
    }
}
