<?php

namespace Database\Seeders;

use App\Models\LoginLog;
use Illuminate\Database\Seeder;

class LoginLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LoginLog::factory()->count(500)->create();
    }
}
