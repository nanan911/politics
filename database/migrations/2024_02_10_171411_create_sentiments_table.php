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
        Schema::table('sentiments', function (Blueprint $table) {
            $table->unsignedBigInteger('article_id')->after('id'); // 添加 article_id 列
            $table->foreign('article_id')->references('id')->on('articles'); // 添加外鍵約束
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sentiments', function (Blueprint $table) {
            $table->dropForeign(['article_id']); // 刪除外鍵約束
            $table->dropColumn('article_id'); // 刪除 article_id 列
        });
    }
};
