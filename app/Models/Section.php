<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use HasFactory , SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name'
    ];

    protected $casts =[
        'created_at'=>'date:Y/m/d',
        'updated_at'=>'date:Y/m/d',
    ];

    public function employee(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
