<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Volunteer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'request_id',
        'first_name',
        'last_name',
        'birth_date',
        'phone_number',
        'academic_level',
        'city_id',
        'address',
        'active',
        'rate',
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
        return $this->belongsTo(Volunteering::class);
    }

    public function workPeriod(): HasMany
    {
        return $this->hasMany(VolunteerWorkPeriod::class, 'volunteer_id');
    }
}
