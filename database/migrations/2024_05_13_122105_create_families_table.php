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
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->string('card_name');
            $table->string('father_name');
            $table->string('father_id_serial_number');
            $table->date('father_birh_date');
            $table->string('father_nationality');
            $table->string('father_health_situation');
            $table->enum('father_acadimic_level',['غير محدد','ابتدائي','اعدادي','ثانوي','جامعي']);
            $table->string('father_job');
            $table->string('father_monthly_income');
            $table->string('mother_name');
            $table->string('mother_id_serial_number');
            $table->date('mother_birh_date');
            $table->string('mother_nationality');
            $table->string('mother_health_situation');
            $table->enum('mother_acadimic_level',['غير محدد','ابتدائي','اعدادي','ثانوي','جامعي']);
            $table->string('mother_job');
            $table->string('moher_monthly_income');
            $table->string('phone_number_1')->unique();
            $table->string('phone_number_2')->nullable()->unique();
            $table->integer('children_count');
            $table->foreignId('city_id')->constrained(); //connect it in ERD
            $table->string('address');
            $table->string('home_type');
            $table->string('home_rent')->nullable();
            $table->string('other_income')->nullable();
            $table->string('supplies')->nullable();
            $table->boolean('is_stopped')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('families');
    }
};
