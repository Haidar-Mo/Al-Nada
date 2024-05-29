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
        Schema::create('sponsership_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsership_id')->constrained();
            $table->morphs('sponsershipable');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('end_reasone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsership_types');
    }
};
