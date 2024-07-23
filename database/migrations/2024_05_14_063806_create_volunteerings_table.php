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
        Schema::create('volunteerings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('father_name');
            $table->string('mother_name');
            $table->date('birth_date');
            $table->enum('social_situation', ['أعزب', 'متزوج', 'مطلق', 'أرمل']);
            $table->string('partner_name')->default('---');
            $table->string('phone_number');
            $table->string('fixed_phone_number')->default('---');
            $table->string('user_work');
            $table->string('father_work')->default('---');
            $table->string('mother_work')->default('---');
            $table->string('partner_work')->default('---');
            $table->string('number_of_sons');
            $table->json('birth_date_of_sons')->nullable();
            $table->string('number_of_daughters');
            $table->json('birth_date_of_daughters')->nullable();
            $table->foreignId('city_id')->constrained();
            $table->string('address');
            $table->string('languages');
            $table->text('assistance_can_be_provided');
            $table->enum('academic_level', ['غير محدد','ابتدائي','اعدادي','ثانوي','جامعي']);
            $table->enum('computer_useability_level', ['مبتدأ', 'متوسط', 'متقدم']);
            $table->text('old_experience')->default('---');
            $table->text('hopies')->default('---');
            $table->string('recognation_way');
            $table->string('joining_reason');
            $table->string('old_association')->default('---');
            $table->string('job_in_old_association')->default('---');
            $table->text('leave_reason')->default('---');
            $table->string('id_card_image');
            $table->string('personal_image');
            $table->enum('status', ['انتظار', 'مقبول', 'مرفوض',])->default('انتظار');
            $table->tinyText('rejecting_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteerings');
    }
};
