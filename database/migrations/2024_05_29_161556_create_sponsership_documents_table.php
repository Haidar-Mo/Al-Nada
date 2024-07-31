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
        Schema::create('sponsership_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('fixed_phone_number')->unique()->nullable();
            $table->string('address');
            $table->enum('academic_level', ['غير محدد', 'ابتدائي', 'اعدادي', 'ثانوي', 'جامعي']);
            $table->string('job');
            $table->string('job_address')->nullable();
            $table->boolean('available');
            $table->boolean('communicate_by_phone');
            $table->boolean('communicate_by_text_messages');
            $table->boolean('communicate_by_email');
            $table->boolean('communicate_with_the_sponsered_person');
            $table->boolean('participate_in_activities');
            $table->text('recognizing_way')->nullable();
            $table->boolean('active')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsership_documents');
    }
};
