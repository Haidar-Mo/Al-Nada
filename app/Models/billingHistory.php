<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BillingHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'transiction_type',
        'amount',
    ];

    protected $casts =[
        'created_at'=>'date:Y/m/d',
        'updated_at'=>'date:Y/m/d',
    ];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }
}
