<?php

namespace Database\Factories;

use App\Models\KeywordSet;
use Illuminate\Database\Eloquent\Factories\Factory;

class KeywordSetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = KeywordSet::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'word' => $this->faker->word,
            'set' => ['value1', 'value2'],
        ];
    }
}
