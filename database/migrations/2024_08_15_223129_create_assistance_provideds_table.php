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
        Schema::create('assistance_provideds', function (Blueprint $table) {
            $table->id();
            $table->morphs('assistable');
            $table->enum('type',[1,2]); // 1 for Mony - 2 for in-kind
            $table->text('description')->nullable();
            $table->integer('amount')->nullable();
            $table->date('recive_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assistance_provideds');
    }
};
