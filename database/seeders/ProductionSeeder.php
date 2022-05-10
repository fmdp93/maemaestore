<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeders = [];

        $seeders[] = RoleSeeder::class;
        $seeders[] = ActionSeeder::class;
        $seeders[] = ConfigSeeder::class;

        $this->call($seeders);
    }
}
