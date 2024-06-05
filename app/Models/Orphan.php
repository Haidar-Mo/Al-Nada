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

    protected $casts =[
        'created_at'=>'date:Y/m/d',
        'updated_at'=>'date:Y/m/d',
    ];

    public function parents(): BelongsTo
    {
        return $this->belongsTo(OrphanParent::class);
    }
}
