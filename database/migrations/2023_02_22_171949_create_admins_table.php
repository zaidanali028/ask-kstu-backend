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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('admin_type')->nullable();
            // admin_type can be(dean,pro,class_rep-> can register students)
            $table->string('program_id')->nullable();
            $table->string('current_level')->nullable();
            // if admin is a class rep,then is a must to provide their program_id & current_level(So that we can only get their class memebers when they login)

            $table->string('password');
            $table->string('gender');
            $table->string('user_img', )->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};