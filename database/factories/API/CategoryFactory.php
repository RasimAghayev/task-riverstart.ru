<?php

namespace Database\Factories\API;

use App\Models\API\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\API\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text,
            'description' => $this->faker->regexify('[A-Za-z0-9]{' . mt_rand(4, 20) . '}'),
            'parent_id' => Category::all()->random()->id,
            'user_id' => User::all()->random()->id,
        ];
    }
}
