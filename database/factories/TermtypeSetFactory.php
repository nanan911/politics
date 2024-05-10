<?php

namespace Database\Factories;

use App\Models\TermtypeSet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TermtypeSet>
 */
class TermtypeSetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TermtypeSet::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'termType' => $this->faker->word,
            'termType_set' => ['value1', 'value2'],
        ];
    }
}
