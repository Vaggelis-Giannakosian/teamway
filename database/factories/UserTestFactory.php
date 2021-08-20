<?php

namespace Database\Factories;

use App\Models\Test;
use App\Models\UserTest;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserTestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserTest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'session_id' => \Str::uuid(),
            'test_id' => function () {
                return Test::factory()->create();
            },
            'user_id' => null
        ];
    }
}
