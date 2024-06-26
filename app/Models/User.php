<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'id_serial_number',
        'email',
        'password',
        'birth_date',
        'image',
        'verification_code',
        'deviceToken',
        'is_volunteer',
    ];

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
        'deviceToken',
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

    public function sposership(): HasOne
    {
        return $this->hasOne(Sponsership::class);
    }

    public function donationAlert(): HasMany
    {
        return $this->hasMany(DonationAlert::class);
    }
    public function donationCampaignAlert(): HasMany
    {
        return $this->hasMany(DonationCampaignAlert::class);
    }

    public function TotalPrivateDonations()
    {
        return $this->donation()->sum('amount');
    }

    public function TotalCampaignDonations()
    {
        return $this->donationCampaign()->sum('amount');
    }
    
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function volunteering(): HasMany
    {
        return $this->hasMany(Volunteering::class);
    }

    public function volunteeringInCampaign(): HasMany
    {
        return $this->hasMany(VolunteeringInCampaign::class);
    }

    public function favorite(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }
}
