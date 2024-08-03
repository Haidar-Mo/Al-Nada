<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'cost',
        'is_donateable',
        'is_volunteerable',
        'number_of_Beneficiary',
        'min_limit_for_donation',
        'image',
        'start_date',
        'end_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'date:Y/m/d',
        'updated_at' => 'date:Y/m/d',
    ];


    protected $appends = [
        'total_donation'
    ];

    public function request(): HasMany
    {
        return $this->hasMany(VolunteeringInCampaignRequest::class);
    }

    public function volunteer(): HasMany
    {
        return $this->hasMany(VolunteerInCampaign::class, 'campaign_id');
    }

    public function donation(): HasMany
    {
        return $this->hasMany(DonationToCampaign::class);
    }

    public function favorite(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function alert(): HasMany
    {
        return $this->hasMany(DonationCampaignAlert::class);
    }


    /** Appends attribute  */
    public function getTotalDonationAttribute()
    {
        return $this->donation()->sum('amount');
    }
}
