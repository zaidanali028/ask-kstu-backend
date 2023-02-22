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
        Schema::create('users', function (Blueprint $table) {
            // students table
            $table->id();
            



            $table->string('name');
            $table->string('email')->unique();
           
            // admin_type can be(dean,pro,student,admin-admin can register students)
            $table->string('password');
            $table->string('gender');
            $table->string('user_img', )->nullable();
            $table->bigInteger('index_no')->nullable();

            $table->integer('faculty_id');
            $table->integer('dept_id');
            $table->integer('program_id');
            $table->integer('status');
            $table->string('yr_of_admission');
            $table->string('yr_of_completion');
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