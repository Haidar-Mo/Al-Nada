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
        Schema::create('orphan_family_statements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_id')->constrained('orphan_families')->onDelete('cascade');
            $table->date('statement_date');
            $table->string('income_source');
            $table->decimal('mony_saving', 10, 0)->nullable();
            $table->string('poor_level');
            $table->string('other_association')->nullable();
            $table->text('supply')->nullable();
            $table->text('note')->nullable();
            $table->string('committee');
            $table->text('committee_report')->nullable();
            $table->string('remove_statement_number')->nullable();
            $table->date('remove_date')->nullable();
            $table->string('remove_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orphan_family_statements');
    }
};
