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
        ConfigModel::insert([
            [
                'name' => 'pin',
                'value' => '123123'
            ],
            [
                'name' => 'mark up price',
                'value' => '.12'
            ],
        ]);
    }
}
