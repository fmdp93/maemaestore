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
        DB::enableQueryLog();
        $query = $this::select(DB::raw('io.id io_id, s.id supplier_id, s.vendor, s.company_name, 
            s.contact_detail, s.address, eta, date_delivered, SUM(io2p.price * io2p.quantity) io2p_total_price'))
            ->from('inventory_order as io')
            ->join('inventory_order2_product as io2p', 'io.id', '=', 'io2p.transaction_id')            
            ->join('product as p', 'p.id', '=', 'io2p.product_id')
            ->join('supplier as s', 's.id', '=', 'p.supplier_id')
            ->groupBy('io2p.transaction_id')
            ->groupBy('p.supplier_id')
            ->where('date_delivered', null)
            ->where('io2p.status_id', null);        
        // $query->get();
        // dd(DB::getQueryLog());
        foreach ($wheres as $fields) {
            $query->where($fields->column_name, $fields->operator, $fields->value);
        }
        return $query->get();
    }
}
