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
        Schema::create('volunteers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_id')->nullable();
            $table->foreign('request_id')->references('id')->on('volunteering_requests')->onDelete('set null');

            $table->string('first_name');
            $table->string('last_name');
            $table->date('birth_date');
            $table->string('phone_number');
            $table->enum('academic_level', ['غير محدد', 'ابتدائي', 'اعدادي', 'ثانوي', 'جامعي']);
            $table->foreignId('city_id')->constrained();
            $table->string('address');
            $table->boolean('active')->default(1);
            $table->float('rate', 2, 1, true)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteers');
    }
};
