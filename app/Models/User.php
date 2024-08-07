<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'password',
        'birth_date',
        'image',
        'deviceToken',
        'is_volunteer',
        'is_sponser',
        'is_active'
    ];

    /**
     * The accessors to append to the model's array form.
     * 
     * @var array<int, string>
     */
    protected $appends = [];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_code',
        'email_verified_at',
        'deviceToken',
        'is_active'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
        'email_verified_at' => 'datetime',
        'birth_date' => 'date:Y/m/d',
        'created_at' => 'date:Y/m/d',
        'updated_at' => 'date:Y/m/d',
    ];

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    public function donation(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    public function donationCampaign(): HasMany
    {
        return $this->hasMany(DonationToCampaign::class);
    }

    public function sponsershipDocument(): HasOne
    {
        return $this->hasOne(sponsershipDocument::class);
    }

    public function sponserships(): HasMany
    {
        return $this->hasMany(SponsershipCase::class);
    }

    public function donationAlert(): HasMany
    {
        return $this->hasMany(DonationAlert::class);
    }
    public function donationCampaignAlert(): HasMany
    {
        return $this->hasMany(DonationCampaignAlert::class);
    }

    public function volunteeringRequest(): HasMany
    {
        return $this->hasMany(VolunteeringRequest::class);
    }

    public function volunteeringInCampaignRequest(): HasMany
    {
        return $this->hasMany(VolunteeringInCampaignRequest::class);
    }

    public function favorite(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function order(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /***    ***/
    public function isActive()
    {
        return $this->is_active;
    }

    public function isVolunteer()
    {
        return $this->is_volunteer;
    }

    public function isSponser()
    {
        return $this->is_sponser;
    }
}
