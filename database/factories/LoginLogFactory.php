<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LoginLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => rand(1, 50),
            'date_and_time' => $this->faker->dateTime(),
            'action_id' => rand(14, 15)
        ];
    }
}
