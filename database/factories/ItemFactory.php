<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Item;
use App\Models\User;
use App\Models\Condition;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Item::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->word(),
            'image' => 'items/sample.jpg',
            'brand' => $this->faker->company(),
            'condition_id' => Condition::factory(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(500, 50000),
            'status' => 0,
        ];
    }
}
