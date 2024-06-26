<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Evaluation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_id',
        'teamwork',
        'technical_skills',
        'commitment',
        'personal_development',
        'achieving_goals',
        'adhering_standards',
        'quantity_of_work',
        'positivity',
        'loyalty_stability',
        'communication',
        'productivity',
        'adherence_to_instructions',
        'honesty',
        'work_ethics',
        'responsibility',
        'supervisor_opinion',
        'task_quality',
        'initiative',
        'logic_analysis',
        'creativity',
        'accuracy',
        'development',
        'timely_task_completion',
        'follow_up',
        'research_ability',
        'clarity_of_expression',
        'training_ability',
        'handling_exceptions',
        'leadership_style',
        'influence_on_subordinates',
        'clarification_of_direction',
        'decision_making',
        'knowledge_sharing',
        'total_score',
        'attendance_percentage',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
