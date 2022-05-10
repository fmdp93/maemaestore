<?php

namespace Database\Seeders;

use App\Models\POSTransactionModel;
use Illuminate\Database\Seeder;

class POSTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        POSTransactionModel::factory()->count(200)->create();
    }
}
