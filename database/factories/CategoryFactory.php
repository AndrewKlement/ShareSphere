<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;
    

    public function definition(): array
    {
        return [
            'name' => $this->faker->word()
        ];
    }

    public function withName($name){
        return $this->state(fn (array $attributes) => [
            'name' => $name,
        ]);
    }
}
