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

    protected $casts = [
        'created_at' => 'date:Y/m/d',
        'updated_at' => 'date:Y/m/d',
    ];

    public function request(): HasMany
    {
        return $this->hasMany(VolunteeringInCampaignRequest::class);
    }

    public function donation(): HasMany
    {
        return $this->hasMany(DonationCampaign::class);
    }

    public function favorite(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function alert(): HasMany
    {
        return $this->hasMany(DonationCampaignAlert::class);
    }
}
