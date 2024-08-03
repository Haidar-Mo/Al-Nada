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
        Schema::create('donation_to_campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('campaign_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['مالي', 'عيني']);
            $table->enum('delivery_type', ['مندوب توصيل', 'الكتروني']);
            $table->bigInteger('amount')->nullable();
            $table->text('description')->nullable();
            $table->string('phone_number');
            $table->string('address')->nullable();
            $table->enum('status', ['جديد', 'تم الاستلام', 'قيد المعالجة', 'ملغي'])->default('جديد');
            $table->string('reject_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_to_campaigns');
    }
};
