<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campaign extends Model
{
    use HasFactory;

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
        'image',
        'end_date',
        'start_date',
    ];

    protected $casts =[
        'created_at'=>'date:Y/m/d',
        'updated_at'=>'date:Y/m/d',
    ];

    public function volinteeringInCampaign(): HasMany
    {
        return $this->hasMany(volunteeringInCampaign::class);
    }

    public function favorite(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function donation(): HasMany
    {
        return $this->hasMany(DonationCampaign::class);
    }

    public function alert(): HasMany
    {
        return $this->hasMany(DonationCampaignAlert::class);
    }

}
