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
            $table->string('first_name');
            $table->string('last_name');
            $table->string('nationality');
            $table->string('id_serial_number')->unique();
            $table->date('birth_date');
            $table->string('phone_number', 10);
            $table->enum('academic_level', ['غير محدد', 'ابتدائي', 'اعدادي', 'ثانوي', 'جامعي']);
            $table->string('academic_specialization');
            $table->enum('status', ['نشط', 'غير نشط']);
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
