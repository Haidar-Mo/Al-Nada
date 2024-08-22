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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('father_name');
            $table->string('mother_name');
            $table->date('birth_date');
            $table->string('birth_place');
            $table->string('nationality');
            $table->string('adress');
            $table->string('university');
            $table->string('faculty');
            $table->string('specialization');
            $table->year('study_start_year');
            $table->year('expected_graduation_year');
            $table->year('actual_graduation_year')->nullable();
            $table->string('mobile_number')->unique();
            $table->string('landline_number')->nullable();
            $table->string('personal_card_image');
            $table->text('description')->nullable();
            $table->boolean('is_supported');
            $table->boolean('visible')->default(0);
            $table->integer('min_sponsorship_payment', false, true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
