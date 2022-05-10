<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\SalesReportController;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class POSTransaction2ProductModel extends Model
{
    use HasFactory;

    protected $table = "pos_transaction2product";

    public $timestamps = false;

    public function getSalesReport($from = "", $to = "", $paginated = true)
    {
        $time_start = "00:00:00";
        $time_end = "23:59:59";
        $model = POSTransaction2ProductModel::select(DB::raw("
            pt2p.pos_transaction_id t_id, 
            (pt2p.quantity - pt2p.refunded_quantity) pt2p_quantity,
            pt2p.price pt2p_price,
            pt.created_at t_date,
            p.name p_name, p.description
        "))
            ->from("pos_transaction2product as pt2p")
            ->join("pos_transaction as pt", "pt.id", "=", "pt2p.pos_transaction_id")
            ->join("product as p", "p.id", "=", "pt2p.product_id")
            ->where("status_id", 4) //completed
            ->having("pt2p_quantity", ">", 0);

        if ($from && $to) {
            $model = $model->where("pt.created_at", ">=", $from . " $time_start")
                ->where("pt.created_at", "<=", $to . " $time_end");
        }

        $model = $model->orderBy('pt.created_at');

        if ($paginated) {
            $model = $model->paginate(Config::get('constant.per_page'))
                ->withPath(action([SalesReportController::class, 'index']))
                ->appends(
                    [
                        'from' => $from,
                        'to' => $to,
                    ]
                )
                ->withQueryString();
        }

        return $model;
    }

    public function getSalesReportTotals($from = "", $to = "")
    {
        $time_start = "00:00:00";
        $time_end = "23:59:59";
        $model = POSTransaction2ProductModel::select(DB::raw("
            SUM(pt2p.quantity - pt2p.refunded_quantity) total_items, 
            SUM((pt2p.quantity - pt2p.refunded_quantity) * pt2p.price) total_sales
        "))
            ->from("pos_transaction2product as pt2p")
            ->join("pos_transaction as pt", "pt.id", "=", "pt2p.pos_transaction_id")
            ->join("product as p", "p.id", "=", "pt2p.product_id")
            ->where("status_id", 4); //completed
        if ($from && $to) {
            $model = $model->where("pt.created_at", ">=", $from . " $time_start")
                ->where("pt.created_at", "<=", $to . " $time_end");
        }

        return $model->first();
    }

    public function refundPosTransaction2Product($product, $refund_quantity){
        // set refund related columns in pos_order2products
        $a_product = POSTransaction2ProductModel::find($product->id);
        // checks and sets the max refundable quantity
        $refundable_quantity = $a_product->quantity - $a_product->refunded_quantity;
        $refund_qty = ($refundable_quantity - $refund_quantity) 
        >= 0 ? $refund_quantity : $refundable_quantity;
        $a_product->refunded_quantity += $refund_qty;
            
        $a_product->refunded_at = date("Y-m-d h:i:s");
        $a_product->save();
        
        return $refund_qty;
    }
}
