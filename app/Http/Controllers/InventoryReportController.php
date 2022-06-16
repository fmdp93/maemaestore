<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Http\Traits\SearchTrait;
use Illuminate\Support\Facades\DB;

class InventoryReportController extends Controller
{
    use SearchTrait;
    public function index(Request $request)
    {
        $from = urldecode($request->input('from'));
        $to = urldecode($request->input('to'));
        $model = new Inventory();
        $data['heading'] = 'Inventory Report';
        DB::enableQueryLog();
        $this->dateFilterSetFrom($from);
        $this->dateFilterSetTo($to);
        $data['products'] = $model->getInventoryReport(URI_INVENTORY_REPORT,$from, $to);
        // dd(DB::getQueryLog());

        $data['from'] = $from ? date("F j, Y", strtotime($from)) : 'start';
        $data['to'] = $to ? date("F j, Y", strtotime($to)) : 'end';

        return view('pages.admin.inventory-report', $data);
    }   

    public function details($id){
        $model = new Inventory();
        $data['heading'] = 'Inventory Report Details';
        $data['table_striped'] = 'table-striped';
        $data['products'] = $model->getReportFor($id);
        $data['transaction_id'] = $id;

        return view('pages.admin.inventory-report-details', $data);
    }

    public function print_details($id){
        $model = new Inventory();
        $data['title'] = 'Inventory Report Details';
        $data['table_striped'] = '';
        $data['heading'] = 'Inventory Report Details';
        $data['products'] = $model->getReportFor($id);
        $data['transaction_id'] = $id;

        $view = (string) view('pages.admin.print-inventory-report-details', $data);
        // return $view;
        $options = new Options();
        $dompdf = new Dompdf();
        $publicPath = base_path('public/');
        $current_options = $dompdf->getOptions();
        $options->set('chroot', $publicPath);
        $options->set('fontDir', $publicPath);

        $dompdf->setPaper('letter', 'landscape');
        $dompdf->setOptions($options);
        $dompdf->setBasePath(base_path('public/'));

        $dompdf->loadHTML($view);
        $dompdf->render();
        $dompdf->stream("$id-inventory-report-details");
    }

    public function print_inventory_report(Request $request){        
        $data['heading'] = "Inventory Report";        
        $data['title'] = 'Inventory Report ';
        $data['table_striped'] = '';

        $from = urldecode($request->input('from'));
        $to = urldecode($request->input('to'));
        $model = new Inventory();
        DB::enableQueryLog();
        $this->dateFilterSetFrom($from);
        $this->dateFilterSetTo($to);
        $data['products'] = $model->getInventoryReport(URI_INVENTORY_REPORT,$from, $to, false);
        $data['products'] = $data['products']->get();
        // dd(DB::getQueryLog());

        $data['from'] = $from ? date("F j, Y", strtotime($from)) : 'start';
        $data['to'] = $to ? date("F j, Y", strtotime($to)) : 'end';
        
        $model = new Inventory();

        $view = (string) view('pages.admin.print-inventory-report', $data);
        // return $view;
        $options = new Options();
        $dompdf = new Dompdf();
        $publicPath = base_path('public/');
        $current_options = $dompdf->getOptions();
        $options->set('chroot', $publicPath);
        $options->set('fontDir', $publicPath);

        $dompdf->setPaper('letter', 'landscape');
        $dompdf->setOptions($options);
        $dompdf->setBasePath(base_path('public/'));

        $dompdf->loadHTML($view);
        $dompdf->render();
        $date_range = $from && $to ? "$from-to-$to-" : "";
        $dompdf->stream("{$date_range}inventory-report");
    }    
}
