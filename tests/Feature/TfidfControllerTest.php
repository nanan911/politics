<?php

namespace Tests\Feature;
use App\Models\Article;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TfidfControllerTest extends TestCase
{
    use RefreshDatabase;


    public function testCalculateTfidf()
    {
        // 創建 10 篇測試文章
        Article::factory()->count(10)->create();
    
        $response = $this->get('/calculate-tfidf');
    
        $response->assertStatus(200);
        $response->assertViewIs('tfidf_results');
        $response->assertViewHas('packedbubble_data');
    }
    
}
