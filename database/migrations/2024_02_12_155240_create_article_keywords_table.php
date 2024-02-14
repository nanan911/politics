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
        Schema::create('article_keywords', function (Blueprint $table) {

            $table->primary(['keyword_set_id','article_id' ]);
            $table->timestamps();

            $table->foreignId('article_id')->constrained();  
            $table->foreignId('keyword_set_id')->constrained('keyword_sets');  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_keywords');
    }
};
