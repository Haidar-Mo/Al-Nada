<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'father_name',
        'mother_name',
        'birth_date',
        'nationality',
        'place_of_residence',
        'birth_place',
        'university',
        'faculty',
        'specialization',
        'study_start_year',
        'expected_graduation_year',
        'actual_graduation_year',
        'mobile_number',
        'landline_number',
        'personal_card_image',
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
