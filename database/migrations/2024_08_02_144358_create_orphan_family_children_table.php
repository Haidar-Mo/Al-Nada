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
        Schema::create('orphan_family_children', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_id')->constrained('orphan_families')->onDelete('cascade');
            $table->string('name');
            $table->date('birth_date');
            $table->enum('academic_level', ['غير محدد', 'ابتدائي', 'اعدادي', 'ثانوي', 'جامعي']);
            $table->boolean('is_supported');
            $table->unique(['family_id', 'name'], 'unique_name_familyId');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orphan_family_children');
    }
};
