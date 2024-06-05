<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VolunteeringInCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'first_name',
        'last_name',
        'Reason_for_volunteering',
        'academic_level',
        'city_id',
        'address',
        'Status',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'created_at' => 'date:Y/m/d',
        'updated_at' => 'date:Y/m/d',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }
}
