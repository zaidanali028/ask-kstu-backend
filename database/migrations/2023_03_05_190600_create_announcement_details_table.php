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
        Schema::create('announcement_details', function (Blueprint $table) {
            $table->id();
            $table->integer('announcement_id');
            $table->string('image_sub_title')->nullable();
            $table->string('image')->nullable();
            $table->mediumText('image_description');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcement_details');
    }
};