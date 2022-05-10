<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'username' => $this->faker->unique()->word(),
            'password' => bcrypt('pass123'),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),            
            'address' => $this->faker->address(),            
            'contact_num' => $this->faker->phoneNumber(),  
            'age' => rand(18, 40),          
            'role_id' => 2,  
        ];
    }
}
