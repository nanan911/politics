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
       
        Schema::create('article_sentiment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('article_id');
            $table->unsignedBigInteger('sentiment_id');
            $table->timestamps();
            $table->integer('sentiment_num'); 
        
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->foreign('sentiment_id')->references('id')->on('sentiments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the pivot table
        Schema::dropIfExists('article_sentiment');
    }
};
