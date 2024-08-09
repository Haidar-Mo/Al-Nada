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
        Schema::create('sponsorship_cases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->morphs('sponsorshipable');
            $table->enum('status', ['انتظار', 'مقبول', 'مرفوض'])->default('انتظار');
            $table->string('reject_reason')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('end_reason')->nullable();
            $table->boolean('active')->default(0);
            $table->unique(['user_id', 'sponsorshipable_id', 'sponsorshipable_type'], 'unique-case');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsorship_cases');
    }
};
