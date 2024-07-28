<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'balance'
    ];


    protected $appends = [];


    protected $casts = [
        'created_at' => 'date:Y/m/d',
        'updated_at' => 'date:Y/m/d',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function billingHistory(): HasMany
    {
        return $this->hasMany(BillingHistory::class);
    }

    public function getBillsAttribute()
    {
        return $this->billingHistory->map(function ($billHistory) {
            return [
                'id' => $billHistory->id,
                'amount' => $billHistory->amount,
                'date' => $billHistory->created_at,
                'type' => get_class($billHistory->billable),
                'details' => $billHistory->billable,
            ];
        });
    }

    public function charge(): HasMany
    {
        return $this->hasMany(WalletCharge::class);
    }
}
