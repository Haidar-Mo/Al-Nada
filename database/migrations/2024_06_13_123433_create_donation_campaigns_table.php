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
        Schema::create('donation_campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('campaign_id')->constrained();
            $table->enum('type', ['مالي','عيني']);
            $table->bigInteger('amount')->nullable();
            $table->text('description')->nullable();
            $table->enum('delivery_type', ['مندوب توصيل', 'يدوي', 'الكتروني']);
            $table->string('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_campaigns');
    }
};
