<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Product extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'maker_name',
        'description',
        'price',
        'is_available',
        'image',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The accessors to append to the model's array form.
     * 
     * @var array<int, string>
     */
    protected $appends = [];


    public function bill(): MorphMany
    {
        return $this->morphMany(BillingHistory::class, 'billable');
    }

    public function sellingHistory(): HasMany
    {
        return $this->hasMany(SellingHistory::class);
    }
}
