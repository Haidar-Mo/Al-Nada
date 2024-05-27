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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('phone_number')->unique();
            $table->string('nationality');
            $table->string('id_serial_number')->unique();
            $table->date('birth_date');
            $table->foreignId('city_id')->constrained();
            $table->string('address');
            $table->enum('academic_level', ['الاعدادية', 'الثانوية', 'الجامعة', 'ماجستير']);
            $table->string('academic_specialization')->default(' ');
            $table->enum('social_situation', ['أعزب', 'متزوج', 'مطلق', 'ارمل']);
            $table->foreignId('section_id')->constrained();
            $table->date('date_start_working')->nullable()->default(null);
            $table->date('date_end_working')->nullable()->default(null);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
