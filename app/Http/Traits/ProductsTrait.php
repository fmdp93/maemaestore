<?php

namespace App\Http\Traits;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Picqer\Barcode\BarcodeGeneratorSVG;
use Picqer\Barcode\BarcodeGeneratorHTML;

trait ProductsTrait
{
    public function search(Request $request)
    {
        $search = $request->input('q');
        $category_id = $request->input('category_id');
        $data['action'] = $request->input('action');
        $data['action_print_barcode'] = $request->input('action_print_barcode');
        $ProductModel = new Product();
        $data['products'] = $ProductModel->getProducts($search, $category_id, self::$page_path);
        $rows = (string) view("components.products-list", $data);
        $table_empty = (string) view("layouts.empty-table", $data);
        $links = (string) $data['products']->links();
        $row_count = count($data['products']);
        $response = [
            'rows_html' => $rows,
            'links_html' => $links,
            'table_empty' => $table_empty,
            'row_count' => $row_count,
        ];
        $response = json_encode($response);
        return Response()->json($response);
    }

    public function getQualifiedDeletedAtColumn()
    {
        return 'p.deleted_at';
    }

    public function printBarcode(Request $request)
    {
        $item_code = $request->input('item_code');
        $generator = new BarcodeGeneratorPNG();
        
        $data['barcode_img'] = $generator->getBarcode($item_code, $generator::TYPE_CODE_128, 1, 50);
        $data['item_code'] = $item_code;
        
        $view = (string) view('pages.barcode', $data);
        // $base_receipt_height = 264;
        // $row_height = 16;
        // $paper_height = $base_receipt_height + $row_height * count($data['items']);
        // $customPaper = array(0,0,264, $paper_height);
        
        $options = new Options();
        $dompdf = new Dompdf();
        $publicPath = base_path('public/');
        $current_options = $dompdf->getOptions();
        $options->set('chroot', $publicPath);
        $options->set('fontDir', $publicPath);

        // $dompdf->setPaper($customPaper);        
        $dompdf->setOptions($options);
        $dompdf->setBasePath(base_path('public/'));
        
        $dompdf->loadHTML($view);
        $dompdf->render();
        $dompdf->stream($item_code);
        // return view('pages.barcode', $data);
    }    
}
