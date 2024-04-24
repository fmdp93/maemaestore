<?php

namespace Database\Seeders;

use App\Models\Inventory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

class InventorySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Inventory = Inventory::factory()
            ->count(SEED_COUNT)
            ->state(new Sequence(
                ['stock' => '20'],
                ['stock' => '40'],
                ['stock' => '60'],
            ))
            ->create();
    }
}
