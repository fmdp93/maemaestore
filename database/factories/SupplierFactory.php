<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{

    protected $model = \App\Models\Supplier::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'vendor' => $this->faker->name(),
            'company_name' => $this->faker->name(),
            'contact_detail' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
        ];
    }
}
