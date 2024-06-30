<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Volunteering extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'father_name',
        'mother_name',
        'birth_date',
        'social_situation',
        'partner_name',
        'email',
        'phone_number',
        'fixed_phone_number',
        'user_work',
        'father_work',
        'mother_work',
        'partner_work',
        'number_of_sons',
        'birth_date_of_sons',
        'number_of_daughters',
        'birth_date_of_daughters',
        'city_id',
        'address',
        'languages',
        'assistance_can_be_provided',
        'copmuter_useability_level',
        'old_experience',
        'hopies',
        'recognation_way',
        'joining_reason',
        'old_association',
        'job_in_old_association',
        'leave_reason',
        'id_card_image',
        'personal_image',
        'status',
        'rejecting_reason'
    ];

    //protected $appends = [];

    protected $casts = [
        'created_at' => 'date:Y/m/d',
        'updated_at' => 'date:Y/m/d',
        'birth_date' => 'date:Y/m/d',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
