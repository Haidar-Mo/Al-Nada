<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SponsorshipDocumentUpdate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'document_id',
        'fixed_phone_number',
        'address',
        'academic_level',
        'job',
        'job_address',
        'available',
        'communicate_by_phone',
        'communicate_by_text_messages',
        'communicate_by_email',
        'communicate_with_the_sponsered_person',
        'participate_in_activities',
        'recognizing_way',
        'status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function document():BelongsTo
    {
        return $this->belongsTo(SponsorshipDocument::class,'document_id');
    }
}
