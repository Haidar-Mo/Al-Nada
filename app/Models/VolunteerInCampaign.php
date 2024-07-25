<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class VolunteerInCampaign extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'request_id',
        'campaign_id',
        'first_name',
        'last_name',
        'phone_number',
        'academic_level',
        'city_id',
        'address',
        'active',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The accessors to append to the model's array form.
     * 
     * @var array<int, string>
     */
    protected $appends = [];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function request(): BelongsTo
    {
        return $this->belongsTo(VolunteeringInCampaignRequest::class, 'request_id');
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }
}
