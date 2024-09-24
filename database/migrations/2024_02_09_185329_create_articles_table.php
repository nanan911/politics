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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('source_id')->constrained('sources'); // Foreign key constraint for sources table
            $table->string('title'); // Add address column
            $table->string('address'); // Add address column
            $table->string('author'); // Add author column
            $table->integer('popular'); // Add popular column
            $table->text('content'); // Existing column
            $table->date('date'); // Add date column
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
