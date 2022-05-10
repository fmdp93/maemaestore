<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    protected $table = "action";

    public $timestamps = false;

    public static function getEditAccountActionId($role_id){
        $action_id = 0;
        if($role_id == 1){
            $action_id = 13; // 13 for admin
        }else if($role_id == 2){
            $action_id = 11; // 11 for cashier
        }

        return $action_id;
    }
}
