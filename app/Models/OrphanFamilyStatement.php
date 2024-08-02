<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrphanFamilyStatement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'family_id',
        'statement_date',
        'income_source',
        'mony_saving',
        'poor_level',
        'other_association',
        'supply',
        'note',
        'committee',
        'committee_report',
        'remove_statement_number',
        'remove_date',
        'remove_reason',
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
