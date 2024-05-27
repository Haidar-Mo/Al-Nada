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
        Schema::create('volunteering_in_campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('campaign_id')->constrained();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('reason_for_volunteering');
            $table->enum('academic_level', ['الاعدادية', 'الثانوية', 'الجامعة', 'ماجستير']);
            $table->foreignId('city_id')->constrained();
            $table->string('address');
            $table->enum('status', ['انتظار', 'مقبول', 'مرفوض', 'منتهى'])->default('انتظار');
            $table->date('start_date')->nullable()->default(null);
            $table->date('end_date')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteering_in_campaigns');
    }
};
