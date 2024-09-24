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
        Schema::create('temporary_articles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // 欄位定義
            $table->unsignedBigInteger('source_id')->nullable();
            $table->string('title')->nullable();
            $table->string('address')->nullable();
            $table->string('author')->nullable();
            $table->string('popular')->nullable();
            $table->unsignedBigInteger('sentiment_id')->nullable();
            $table->text('content')->nullable();
            $table->date('date')->nullable();
            $table->boolean('is_analyzed')->default(false); // 標記是否已完成情緒分析
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temporary_articles');
    }
};
