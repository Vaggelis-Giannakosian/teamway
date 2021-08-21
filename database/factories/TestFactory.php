<?php

namespace Database\Factories;

use App\Models\Test;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Test::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->paragraph;

        return [
            'title' => $title,
            'excerpt' => $this->faker->paragraphs(1, $asText = true),
            'description' => $this->faker->paragraphs(3, $asText = true),
            'slug' => \Str::slug($title),
            'classification' => [],
            'image' => $this->faker->slug.'.jpg'
        ];
    }
}
