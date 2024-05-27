<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Orphan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [];

    public function guarantee() :MorphMany
    {
        return $this->morphMany(Guarantee::class, 'guaranteeable');
    }

    public function parents(): BelongsTo
    {
        return $this->belongsTo(OrphanParent::class);
    }
}
