<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class POSTransactionModel extends Model
{
    use HasFactory;

    protected $table = "pos_transaction";

    public $timestamps = false;

    public function getPosTransactions($search, $page_path, $where = "")
    {
        DB::enableQueryLog();
        $model = POSTransaction2ProductModel::select(DB::raw("
            pt2p.pos_transaction_id t_id,             
            pt2p.quantity pt2p_quantity, 
            pt2p.refunded_quantity,
            SUM(pt2p.quantity - pt2p.refunded_quantity) pt2p_quantities,
            SUM(pt2p.price * (pt2p.quantity - pt2p.refunded_quantity)) pt2p_price_total,
            pt.created_at t_date, pt.amount_paid,
            p.name p_name, p.description
        "))
            ->from("pos_transaction2product as pt2p")
            ->join("pos_transaction as pt", "pt.id", "=", "pt2p.pos_transaction_id")
            ->join("product as p", "p.id", "=", "pt2p.product_id")
            ->orWhere(function ($query) use ($search) {
                $query->where('pt.id', $search)
                    ->orWhere('p.name', 'LIKE', "%$search%");
            })
            ->when($where, function ($query) use ($where) {
                $query->where('mode_of_payment', $where)
                    ->whereRaw('pt.amount_paid < (
                                (pt2p.quantity - pt2p.refunded_quantity) * pt2p.price
                            )');
            })
            ->where("status_id", 4) //completed
            ->groupBy("pt.id")
            ->having(DB::raw("pt2p_quantity - refunded_quantity"), ">", 0)
            ->orderBy('pt.created_at', 'desc')
            ->paginate(Config::get('constant.per_page'))
            ->withPath($page_path)
            ->appends(
                [
                    'q' => $search,
                ]
            );

        return $model;
    }
}
