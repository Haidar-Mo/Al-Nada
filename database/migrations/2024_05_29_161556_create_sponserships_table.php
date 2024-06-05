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
        Schema::create('sponserships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('partner_name')->default('---');
            $table->string('fixed_phone_number')->default('---');
            $table->string('job')->default('---');
            $table->string('job_address')->default('---');
            $table->boolean('Communicate_by_phone');
            $table->boolean('Communicate_by_text_messages');
            $table->boolean('Communicate_by_email');
            $table->boolean('Communicate_with_the_sponsered_person');
            $table->boolean('Participate_in_activities');
            $table->text('notes')->default('---');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponserships');
    }
};
