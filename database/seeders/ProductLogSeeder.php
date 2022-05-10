<?php

namespace Database\Seeders;

use App\Models\ProductLog;
use Illuminate\Database\Seeder;

class ProductLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductLog::factory()->count(500)->create();
    }
}
