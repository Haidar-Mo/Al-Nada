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
        Schema::create('orphan_families', function (Blueprint $table) {
            $table->id();
            $table->string('mother_first_name');
            $table->string('mother_last_name');
            $table->string('mother_birthplace');
            $table->date('mother_birthdate');
            $table->string('mother_id_serial_number')->unique();
            $table->string('mother_nationality');
            $table->string('phone_number');
            $table->string('mother_health_condition');
            $table->enum('mother_academic_level', ['غير محدد', 'ابتدائي', 'اعدادي', 'ثانوي', 'جامعي']);
            $table->string('family_register_book_number')->unique();
            $table->string('via_person');
            $table->string('father_first_name');
            $table->string('father_last_name');
            $table->string('father_nationality');
            $table->date('father_death_date');
            $table->string('cause_of_death');
            $table->string('address');
            $table->string('house_ownership_type');
            $table->integer('residents_number');
            $table->integer('sons_number');
            $table->integer('daughter_number');
            $table->decimal('value_rent', 8, 2)->nullable();
            $table->string('zip_code');
            $table->string('supervisor_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orphan_families');
    }
};
