<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
<<<<<<< HEAD
use Spatie\Permission\Traits\HasRoles;

return new class extends Migration
{
    use HasRoles;
=======

return new class extends Migration
{
>>>>>>> temp3
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
<<<<<<< HEAD
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
=======
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number')->unique();
            $table->string('id_serial_number')->unique();
            $table->string('email')->unique();
            $table->string('verification_code')->nullable();
            $table->timestamp('email_verified_at')->nullable()->default(null);
            $table->string('password');
            $table->date('birth_date')->nullable();
           $table->string('image')->nullable();
            $table->string('deviceToken')->unique();
            $table->boolean('is_volunteer')->default(0);
>>>>>>> temp3
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
