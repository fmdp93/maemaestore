<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\POSTransactionSeeder;
use Database\Seeders\POSTransaction2ProductSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $seeders = [];
        if (env('APP_ENV') == "local") {
            $seeders[] = ProductCategorySeeder::class;
            $seeders[] = ProductSeeder::class;            
            $seeders[] = InventorySeed::class;
            // $seeders[] = ProductLogSeeder::class;
            // $seeders[] = InventoryLogSeeder::class;
            // $seeders[] = AccountLogSeeder::class;
            // $seeders[] = LoginLogSeeder::class;
            // $seeders[] = POSTransactionSeeder::class;
            // $seeders[] = POSTransaction2ProductSeeder::class;
            // $seeders[] = POSTransaction2ProductColumnBasePriceSeeder::class;            
            $seeders[] = SupplierSeeder::class;
            $seeders[] = CustomerSeeder::class;
        } 

        $seeders[] = UserSeeder::class;
        $seeders[] = RoleSeeder::class;
        $seeders[] = ActionSeeder::class;
        $seeders[] = ConfigSeeder::class;
        $this->call($seeders);
    }
}
