<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evaluation>
 */
class EvaluationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_id' => Employee::factory(),
            'teamwork' => $this->faker->numberBetween(1, 10),
            'technical_skills' => $this->faker->numberBetween(1, 10),
            'commitment' => $this->faker->numberBetween(1, 10),
            'personal_development' => $this->faker->numberBetween(1, 10),
            'achieving_goals' => $this->faker->numberBetween(1, 10),
            'adhering_standards' => $this->faker->numberBetween(1, 10),
            'quantity_of_work' => $this->faker->numberBetween(1, 10),
            'positivity' => $this->faker->numberBetween(1, 10),
            'loyalty_stability' => $this->faker->numberBetween(1, 10),
            'communication' => $this->faker->numberBetween(1, 10),
            'productivity' => $this->faker->numberBetween(1, 10),
            'adherence_to_instructions' => $this->faker->numberBetween(1, 10),
            'honesty' => $this->faker->numberBetween(1, 10),
            'work_ethics' => $this->faker->numberBetween(1, 10),
            'responsibility' => $this->faker->numberBetween(1, 10),
            'supervisor_opinion' => $this->faker->numberBetween(1, 10),
            'task_quality' => $this->faker->numberBetween(1, 10),
            'initiative' => $this->faker->numberBetween(1, 10),
            'logic_analysis' => $this->faker->numberBetween(1, 10),
            'creativity' => $this->faker->numberBetween(1, 10),
            'accuracy' => $this->faker->numberBetween(1, 10),
            'development' => $this->faker->numberBetween(1, 10),
            'timely_task_completion' => $this->faker->numberBetween(1, 10),
            'follow_up' => $this->faker->numberBetween(1, 10),
            'research_ability' => $this->faker->numberBetween(1, 10),
            'clarity_of_expression' => $this->faker->numberBetween(1, 10),
            'training_ability' => $this->faker->numberBetween(1, 10),
            'handling_exceptions' => $this->faker->numberBetween(1, 10),
            'leadership_style' => $this->faker->numberBetween(1, 10),
            'influence_on_subordinates' => $this->faker->numberBetween(1, 10),
            'clarification_of_direction' => $this->faker->numberBetween(1, 10),
            'decision_making' => $this->faker->numberBetween(1, 10),
            'knowledge_sharing' => $this->faker->numberBetween(1, 10),
            'total_score' => $this->faker->numberBetween(0, 100),
            'attendance_percentage' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
