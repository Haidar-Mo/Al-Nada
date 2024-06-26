<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class EvaluationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'teamwork' => 'required|integer|min:1|max:10',
            'technical_skills' => 'required|integer|min:1|max:10',
            'commitment' => 'required|integer|min:1|max:10',
            'personal_development' => 'required|integer|min:1|max:10',
            'achieving_goals' => 'required|integer|min:1|max:10',
            'adhering_standards' => 'required|integer|min:1|max:10',
            'quantity_of_work' => 'required|integer|min:1|max:10',
            'positivity' => 'required|integer|min:1|max:10',
            'loyalty_stability' => 'required|integer|min:1|max:10',
            'communication' => 'required|integer|min:1|max:10',
            'productivity' => 'required|integer|min:1|max:10',
            'adherence_to_instructions' => 'required|integer|min:1|max:10',
            'honesty' => 'required|integer|min:1|max:10',
            'work_ethics' => 'required|integer|min:1|max:10',
            'responsibility' => 'required|integer|min:1|max:10',
            'supervisor_opinion' => 'required|integer|min:1|max:10',
            'task_quality' => 'required|integer|min:1|max:10',
            'initiative' => 'required|integer|min:1|max:10',
            'logic_analysis' => 'required|integer|min:1|max:10',
            'creativity' => 'required|integer|min:1|max:10',
            'accuracy' => 'required|integer|min:1|max:10',
            'development' => 'required|integer|min:1|max:10',
            'timely_task_completion' => 'required|integer|min:1|max:10',
            'follow_up' => 'required|integer|min:1|max:10',
            'research_ability' => 'required|integer|min:1|max:10',
            'clarity_of_expression' => 'required|integer|min:1|max:10',
            'training_ability' => 'required|integer|min:1|max:10',
            'handling_exceptions' => 'required|integer|min:1|max:10',
            'leadership_style' => 'required|integer|min:1|max:10',
            'influence_on_subordinates' => 'required|integer|min:1|max:10',
            'clarification_of_direction' => 'required|integer|min:1|max:10',
            'decision_making' => 'required|integer|min:1|max:10',
            'knowledge_sharing' => 'required|integer|min:1|max:10',
            'total_score' => 'required|integer|min:0|max:100',
            'attendance_percentage' => 'required|numeric|min:0|max:100',
        ];
    }
}
