<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventoryOrder extends Model
{
    use HasFactory;

    protected $table = 'inventory_order';

    public $timestamps = false;

    public function getProcessing($wheres = [])
    {
        $query = $this::select(DB::raw('io.id io_id, vendor, company_name, 
            contact_detail, address, tax, shipping_fee, eta, date_delivered, SUM(io2p.price * io2p.quantity) io2p_total_price'))
            ->from('inventory_order as io')
            ->join('inventory_order2_product as io2p', 'io.id', '=', 'io2p.transaction_id')
            ->groupBy('io2p.transaction_id')
            ->where('date_delivered', null);
        foreach($wheres as $fields){
            $query->where($fields->column_name, $fields->operator, $fields->value);
        }
        return $query->get();
    }    
}
