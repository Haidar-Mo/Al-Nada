<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class OrphanFamily extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mother_first_name',
        'mother_last_name',
        'mother_birthplace',
        'mother_birthdate',
        'mother_id_serial_number',
        'mother_nationality',
        'phone_number',
        'mother_health_condition',
        'mother_academic_level',
        'family_register_book_number',
        'side_from',
        'father_first_name',
        'father_last_name',
        'father_nationality',
        'father_death_date',
        'cause_of_death',
        'address',
        'house_ownership_type',
        'residents_number',
        'sons_number',
        'daughter_number',
        'value_rent',
        'zip_code',
        'supervisor_name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];


    public function case(): MorphMany
    {
        return $this->morphMany(SponsershipCase::class, 'sponsershipable');
    }

    public function orphans(): HasMany
    {
        return $this->hasMany(Orphan::class, 'family_id');
    }

    public function statement(): HasMany
    {
        return $this->hasMany(OrphanFamilyStatement::class, 'family_id');
    }
}
