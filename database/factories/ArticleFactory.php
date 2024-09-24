<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition()
    {
        return [
            'source_id' => 1,  // 假設這裡為固定的測試數據
            'title' => $this->faker->sentence,
            'address' => $this->faker->url,
            'author_id' => 1,  // 假設這裡為固定的測試數據
            'popular' => $this->faker->numberBetween(0, 100),  // 人氣隨機值
            'sentimen_id' => 1,  // 假設這裡為固定的測試數據
            'content' => $this->faker->paragraph,
            'date' => $this->faker->date(),
        ];
    }
}
