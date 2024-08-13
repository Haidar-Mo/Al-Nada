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
        Schema::create('sponsorship_payment_cases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('case_id')->constrained('sponsorship_cases')->cascadeOnDelete();
            $table->date('payment_month');
            $table->enum('paid', ['0', '1', '2'])->default('0');
            $table->date('payment_date')->nullable();
            $table->integer('amount',false,true)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsorship_payment_cases');
    }
};
