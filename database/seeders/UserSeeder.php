<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'username' => 'admin',
                'password' => Hash::make('pass123'),
                'first_name' => 'Marilyn',
                'last_name' => 'Antiporda',
                'address' => 'San Jose City',
                'contact_num' => '09123456789',
                'age' => 18,
                'role_id' => 1,
            ],
            [
                'username' => 'cashier1',
                'password' => Hash::make('pass123'),
                'first_name' => 'John',
                'last_name' => 'Smith',
                'address' => 'San Jose City',
                'contact_num' => '09123456789',
                'age' => 18,
                'role_id' => 2,
            ]
        ]);
        
        $this->seedLocal();
    }

    private function seedLocal(){
        if(env('APP_ENV') == "local"){
            User::factory()->count(60)->create();
        }   
    }
}
