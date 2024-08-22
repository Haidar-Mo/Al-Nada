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
        Schema::create('old_people', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('father_name');
            $table->string('mother_name');
            $table->date('birth_date');
            $table->string('birth_place');
            $table->string('nationality');
            $table->string('address');
            $table->string('mobile_number')->unique();
            $table->string('landline_number')->nullable();
            $table->enum('social_status', ['أعزب', 'متزوج', 'أرمل', 'مطلق']);
            $table->text('health_status');
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
        Schema::dropIfExists('old_people');
    }
};
