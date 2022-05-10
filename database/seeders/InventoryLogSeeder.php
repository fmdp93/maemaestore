<?php

namespace Database\Seeders;

use App\Models\InventoryLog;
use Illuminate\Database\Seeder;

class InventoryLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InventoryLog::factory()->count(500)->create();
    }
}
