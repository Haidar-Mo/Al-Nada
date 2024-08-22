<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class OldPeople extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'father_name',
        'mother_name',
        'birth_date',
        'nationality',
        'address',
        'birth_place',
        'personal_card_image',
        'mobile_number',
        'landline_number',
        'marital_status',
        'health_status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'birth_date' => 'date'
    ];



    public function case(): MorphMany
    {
        return $this->morphMany(SponsorshipCase::class, 'sponsorshipable');
    }

    public function statusUpdate(): MorphMany
    {
        return $this->morphMany(StatusUpdate::class, 'statusable');
    }

}
