<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Employee extends Model
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
        'phone_number',
        'id_serial_number',
        'nationality',
        'birth_date',
        'city_id',
        'address',
        'academic_specialization',
        'academic_level',
        'social_situation',
        'date_start_working',
        'date_end_working',
        'section_id',
        'image'
    ];

    protected $casts =[
        'created_at'=>'date:Y/m/d',
        'updated_at'=>'date:Y/m/d',
    ];
    
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
    public function account(): HasOne
    {
        return $this->hasOne(Administration::class, 'employee_id', 'id');
    }
}
