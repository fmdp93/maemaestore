<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POSTransactionModel extends Model
{
    use HasFactory;

    protected $table = "pos_transaction";

    public $timestamps = false;
}
