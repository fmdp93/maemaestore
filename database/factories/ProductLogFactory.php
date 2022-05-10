<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => rand(1,100),
            'date_and_time' => $this->faker->dateTime(),
            'action_id' => rand(5, 7)
        ];
    }
}
