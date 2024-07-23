<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->integer('teamwork');
            $table->integer('technical_skills');
            $table->integer('commitment');
            $table->integer('personal_development');
            $table->integer('achieving_goals');
            $table->integer('adhering_standards');
            $table->integer('quantity_of_work');
            $table->integer('positivity');
            $table->integer('loyalty_stability');
            $table->integer('communication');
            $table->integer('productivity');
            $table->integer('adherence_to_instructions');
            $table->integer('honesty');
            $table->integer('work_ethics');
            $table->integer('responsibility');
            $table->integer('supervisor_opinion');
            $table->integer('task_quality');
            $table->integer('initiative');
            $table->integer('logic_analysis');
            $table->integer('creativity');
            $table->integer('accuracy');
            $table->integer('development');
            $table->integer('timely_task_completion');
            $table->integer('follow_up');
            $table->integer('research_ability');
            $table->integer('clarity_of_expression');
            $table->integer('training_ability');
            $table->integer('handling_exceptions');
            $table->integer('leadership_style');
            $table->integer('influence_on_subordinates');
            $table->integer('clarification_of_direction');
            $table->integer('decision_making');
            $table->integer('knowledge_sharing');
            $table->integer('total_score');
            $table->float('attendance_percentage');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
