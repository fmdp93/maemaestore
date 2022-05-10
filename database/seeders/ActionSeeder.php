<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('action')->truncate();
        DB::table('action')->insert([
            [
                'id' => 1,
                'name' => 'Order Processing'
            ],
            [
                'id' => 2,
                'name' => 'Order Received'
            ],
            [
                'id' => 3,
                'name' => 'Returned/Refunded'
            ],
            [
                'id' => 4,
                'name' => 'Completed'
            ],
            [
                'id' => 5,
                'name' => 'Product Added'
            ],
            [
                'id' => 6,
                'name' => 'Product Edited'
            ],
            [
                'id' => 7,
                'name' => 'Product Deleted'
            ],
            [
                'id' => 8,
                'name' => 'Stock Added'
            ],
            [
                'id' => 9,
                'name' => 'Stock Deducted'
            ],
            [
                'id' => 10,
                'name' => 'Cashier Account Added'
            ],
            [
                'id' => 11,
                'name' => 'Cashier Account Edited'
            ],
            [
                'id' => 12,
                'name' => 'Cashier Account Deleted'
            ],
            [
                'id' => 13,
                'name' => 'Admin Account Edited'
            ],
            [
                'id' => 14,
                'name' => 'Log in'
            ],
            [
                'id' => 15,
                'name' => 'Log out'
            ],
            [
                'id' => 16,
                'name' => 'Inventory product archived'
            ],
        ]);
    }
}
