<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Family extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'card_name',
        'father_name',
        'father_id_serial_number',
        'father_birth_date',
        'father_nationality',
        'father_health_situation',
        'father_academic_level',
        'father_job',
        'father_monthly_income',
        'mother_name',
        'mother_id_serial_number',
        'mother_birth_date',
        'mother_nationality',
        'mother_health_situation',
        'mother_academic_level',
        'mother_job',
        'mother_monthly_income',
        'phone_number_1',
        'phone_number_2',
        'children_count',
        'city_id',
        'address',
        'home_type',
        'home_rent',
        'other_income',
        'supplies',
        'is_stopped',
    ];




    public function member():HasMany
    {
        return $this->hasMany(FamilyMember::class);
    }
}
