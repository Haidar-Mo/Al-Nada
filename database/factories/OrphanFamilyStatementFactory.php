<?php

namespace Database\Factories;

use App\Models\OrphanFamily;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrphanFamilyStatment>
 */
class OrphanFamilyStatementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $families_IDs = OrphanFamily::all()->pluck('id')->toArray();
        return [
            'family_id' => fake()->randomElement($families_IDs),
            'statement_first_date' => $this->faker->date('Y-m-d', 'now'),
            'income_source' => $this->faker->randomElement(['راتب', 'عمل حر', 'معاش', 'بدون']),
            'mony_saving' => $this->faker->optional()->randomFloat(2, 0, 100000),
            'poor_level' => $this->faker->randomElement(['منخفض', 'متوسط', 'شديد']),
            'other_association' => $this->faker->optional()->company,
            'supply' => $this->faker->optional()->word,
            'note' => $this->faker->optional()->text(200),
            'committee' => $this->faker->company,
            'committee_report' => $this->faker->optional()->text(500),
            'remove_statement_number' => $this->faker->optional()->numerify('RSN#####'),
            'remove_date' => $this->faker->optional()->date('Y-m-d', 'now'),
            'remove_reson' => $this->faker->optional()->sentence,
        ];
    }
}
