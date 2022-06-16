<?php

namespace Database\Seeders;

use App\Models\ConfigModel;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ConfigModel::truncate();
        ConfigModel::insert([
            [
                'id' => 1,
                'name' => 'pin',
                'value' => '123123'
            ],
            [
                'id' => 2,
                'name' => 'mark up price',
                'value' => '.12'
            ],
            [
                'id' => 3,
                'name' => 'senior discount',
                'value' => '.2'
            ],
            [
                'id' => 4,
                'name' => 'serial number',
                'value' => '1'
            ],
        ]);
    }
}
