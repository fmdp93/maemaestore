<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigModel extends Model
{
    use HasFactory;

    protected $table = 'config';

    public $timestamps = false;

    public static function increment_serial_number()
    {
        $serial_number = (int) ConfigModel::find(CONFIG_SERIAL_NUMBER)->value;
        ConfigModel::where('id', CONFIG_SERIAL_NUMBER)
            ->update(
                ['value' => ++$serial_number,]
            );
    }
}
