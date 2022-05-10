<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'inventory_id' => rand(1,100),
            'previous_quantity' => rand(1,100),
            'updated_quantity' => rand(1,100),
            'date_and_time' => $this->faker->dateTime(),
            'action_id' => rand(8, 9)
        ];
    }
}
