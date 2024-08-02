<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrphanFamilyChild extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'family_id',
        'name',
        'birth_date',
        'academic_level',
        'is_supported'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];


    public function orphanFamily(): BelongsTo
    {
        return $this->belongsTo(OrphanFamily::class, 'family_id');
    }
    
}
