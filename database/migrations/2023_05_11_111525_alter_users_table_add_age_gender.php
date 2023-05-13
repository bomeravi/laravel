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
        Schema::table('users', function (Blueprint $table) {
            //
            $table->integer('age')->default(0);
            $table->enum('user_role',['user','admin'])->default('user'); // user admin
            $table->string('image')->default('user.png');
            $table->string('user_type')->nullable(); //'freemium','premium'
            $table->string('otp_code')->default('111111')->nullable();
            $table->string('gender')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
