<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountLog extends Model
{
    use HasFactory;

    protected $table = "account_log";

    public $timestamps = false;

    public static function log($user_id, $action_id){
        $AccountLog = new AccountLog();
        $AccountLog->user_id = $user_id;
        $AccountLog->date_and_time = date('Y-m-d h:i:s');
        $AccountLog->action_id = $action_id;
        $AccountLog->save();
    }
}
