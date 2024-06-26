<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'date:Y/m/d',
        'updated_at' => 'date:Y/m/d',
    ];

    /**
     * The accessors to append to the model's array form.
     * 
     * @var array<int, string>
     */
    protected $appends = ['section', 'city'];


    public function getSectionAttribute()
    {
        return $this->section()->first();
    }

    public function getCityAttribute()
    {
        return $this->city()->first();
    }

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
    public function evaluation(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }
}
