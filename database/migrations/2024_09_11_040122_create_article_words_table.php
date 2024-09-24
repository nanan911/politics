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
        Schema::create('article_words', function (Blueprint $table) {
            $table->bigIncrements('id');  // 自動遞增的主鍵 ID
            $table->unsignedBigInteger('article_id');  // 外鍵，對應 articles 表中的 id
            $table->string('word', 255);  // 分析出的詞彙，最多 255 個字元
            $table->float('tf_idf');  // 儲存 TF-IDF 值
            $table->timestamps();  // 包含 created_at 和 updated_at 欄位

            // 設置外鍵約束，當對應的文章被刪除時，連同詞彙數據一併刪除
            $table->foreign('article_id')
                  ->references('id')
                  ->on('articles')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_words');
    }
};
