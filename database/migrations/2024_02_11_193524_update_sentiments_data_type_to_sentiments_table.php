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
            $table->json('sentence')->change();
            $table->json('aspect')->change();
            $table->json('aspect_sentiment')->change();
            $table->json('aspect_num')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sentiments', function (Blueprint $table) {
            $table->string('sentence')->change();
            $table->string('aspect')->change();
            $table->string('aspect_sentiment')->change();
            $table->integer('aspect_num')->change();
        });
    }
};
