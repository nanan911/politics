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
        Schema::create('chart_times', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('timestamp');
            $table->integer('data');
            $table->string('board');
            $table->string('semtiment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chart_times');
    }
};