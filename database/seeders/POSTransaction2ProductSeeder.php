<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\POSTransaction2ProductModel;

class POSTransaction2ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        POSTransaction2ProductModel::factory()->count(5)->create();
    }
}
