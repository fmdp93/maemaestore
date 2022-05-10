<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Models\POSTransaction2ProductModel;

class SalesReportController extends Controller
{
    //
    public function index(Request $request)
    {
        $from = urldecode($request->input('from'));
        $to = urldecode($request->input('to'));
        $model = new POSTransaction2ProductModel();
        $data['heading'] = 'Sales Report';
        DB::enableQueryLog();
        $this->dateFilterSetFrom($from);
        $this->dateFilterSetTo($to);
        $data['transactions'] = $model->getSalesReport($from, $to);
        // dd(DB::getQueryLog());
        $total_items = $model->getSalesReportTotals($from, $to);

        $data['total_items'] = $total_items->total_items;
        $data['total_sales'] = $total_items->total_sales;
        $data['from'] = $from ? date("F j, Y", strtotime($from)) : 'start';
        $data['to'] = $to ? date("F j, Y", strtotime($to)) : 'end';

        return view('pages.admin.sales-report', $data);
    }

    private function dateFilterSetFrom(&$from)
    {
        $date_filter = request()->input('date_filter');

        switch ($date_filter) {
            case 'daily':
                $dt = new \DateTime();
                $from = $dt->format('Y-m-d') . " 00:00:00";
                break;
            case 'weekly':
                $dt = new \DateTime('monday this week');
                $from = $dt->format('Y-m-d') . " 00:00:00";
                break;
            case 'monthly':
                $dt = new \DateTime('first day of this month');
                $from = $dt->format('Y-m-d') . " 00:00:00";
                break;
            case 'yearly':
                $dt = new \DateTime('first day of January');
                $from = $dt->format('Y-m-d') . " 00:00:00";
                break;
        }
    }

    private function dateFilterSetTo(&$to)
    {
        $date_filter = request()->input('date_filter');
        $dt = new \DateTime();

        switch ($date_filter) {
            case 'daily':
                $dt = new \DateTime();
                $to = $dt->format('Y-m-d') . " 23:59:59";
                break;
            case 'weekly':
                $dt = new \DateTime('sunday this week');
                $to = $dt->format('Y-m-d') . " 23:59:59";
                break;
            case 'monthly':
                $dt = new \DateTime('last day of this month');
                $to = $dt->format('Y-m-d') . " 23:59:59";
                break;
            case 'yearly':
                $dt = new \DateTime('last day of December');
                $to = $dt->format('Y-m-d') . " 23:59:59";
                break;
        }
    }
}
