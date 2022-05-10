<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class POSTransactionModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'amount_paid' => 1000000,
            'created_at' => $this->faker->dateTime(),
            'status_id' => 4,
        ];
    }
}
