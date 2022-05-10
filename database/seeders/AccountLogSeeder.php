<?php

namespace Database\Seeders;

use App\Models\AccountLog;
use Illuminate\Database\Seeder;

class AccountLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AccountLog::factory()->count(500)->create();
    }
}
