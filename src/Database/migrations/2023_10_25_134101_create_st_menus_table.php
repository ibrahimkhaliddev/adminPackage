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
        Schema::create('st_menus', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->string('icon')->nullable();
            $table->string('path')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->tinyInteger('level');
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('st_menus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('st_menus');
    }
};
