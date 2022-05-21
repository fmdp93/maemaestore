<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class SuppliersController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('q');

        $data['heading'] = "Supplier";
        $data['title'] = "Supplier";
        $data['search'] = $search;
        $data['delete_action'] = route('delete_supplier');
        $data['edit_action'] = route('edit_supplier');

        $Supplier = new Supplier();
        $data['suppliers'] = $Supplier->getSuppliers($search, '/inventory/suppliers');
        $data['d_none'] = count($data['suppliers']) ? 'd-none' : '';

        return view('pages.admin.supplier', $data);
    }

    public function searchSupplier(Request $request)
    {
        $search = $request->input('q');

        $Supplier = new Supplier();

        DB::enableQueryLog();
        $data['suppliers'] = $Supplier->getSuppliers($search, '/inventory/suppliers');
        $data['delete_action'] = $request->input('delete_action');
        $data['edit_action'] = $request->input('edit_action');
        $data['search'] = "$search";
        $rows = (string) view("components.admin.supplier-list", $data);

        $data['d_none'] = count($data['suppliers']) ? 'd-none' : '';
        $table_empty = (string) view("layouts.empty-table", $data);
        $links = (string) $data['suppliers']->links();
        $row_count = count($data['suppliers']);
        $response = [
            'rows_html' => $rows,
            'links_html' => $links,
            'table_empty' => $table_empty,
            'row_count' => $row_count,
            'last_query' => DB::getQueryLog(),
        ];
        $response = json_encode($response);
        return Response()->json($response);
    }

    /**
     * Search Supplier for purchase order page
     * Type: Async
     * 
     * @return JSON
     */
    public function searchVendor(Request $request){
        $search = $request->input('q');
        $response = [];
        $vendors = Supplier::getVendorDetails($search);        
        foreach($vendors as $vendor){
            $response["vendors"][] =[
                "id" =>  $vendor->id,
                "vendor" =>  $vendor->vendor,
                "company_name" =>  $vendor->company_name,
                "address" =>  $vendor->address,
                "contact_detail" =>  $vendor->contact_detail,
            ];
        }

        return Response()->json(json_encode($response));
    }

    public function add_supplier()
    {
        $data['heading'] = "Add Supplier";
        $data['title'] = "Add Supplier";

        return view('pages.admin.add-supplier', $data);
    }

    public function add_supplier_submit(Request $request)
    {
        $input = $request->input();
        $rules = [
            'vendor' => 'required',
            'company_name' => 'required',
            'address' => 'required',
            'contact_num' => 'required',
        ];
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $request->session()->flash('msg_success', 'Supplier added successfully!');

        $supplier = new Supplier();
        $supplier->vendor = $request->input('vendor');
        $supplier->company_name = $request->input('company_name');
        $supplier->address = $request->input('address');
        $supplier->contact_detail = $request->input('contact_num');
        $supplier->save();

        return back();
    }

    public function edit_supplier(Request $request)
    {
        $data['heading'] = "Edit Supplier";
        $data['title'] = "Edit Supplier";
        $supplier = Supplier::find($request->input('id'));
        $data['id'] = old('id') ?? $supplier->id;
        $data['vendor'] = old('vendor') ?? $supplier->vendor;        
        $data['company_name'] = old('company_name') ?? $supplier->company_name;
        $data['address'] = old('address') ?? $supplier->address;
        $data['contact_num'] = old('contact_num') ??  $supplier->contact_detail;

        return view('pages.admin.edit-supplier', $data);
    }

    public function edit_supplier_submit(Request $request)
    {
        $input = $request->input();
        $id = $request->input('id');
        $vendor = $request->input('vendor');
        $company_name = $request->input('company_name');
        $address = $request->input('address');
        $contact_detail = $request->input('contact_num');

        $rules = [
            'id' => 'required|numeric|min:1',
            'vendor' => 'required',
            'company_name' => 'required',
            'address' => 'required',
            'contact_num' => 'required',
        ];
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $request->session()->flash('msg_success', 'Supplier updated successfully!');

        $supplier = Supplier::where('id', $id)
        ->update([            
            'vendor' => $vendor,
            'company_name' => $company_name,
            'address' => $address,
            'contact_detail' => $contact_detail,
        ]);

        return back();
    }

    public function delete_supplier(Request $request)
    {
        $supplier_id = $request->input('supplier_id');

        // sets url params
        $params = [
            'q' => $request->input('search'),
            'page' => $request->input('page'),
        ];

        Supplier::where('id', $supplier_id)
            ->update(['deleted_at' => date("Y-m-d H:i:s")]);
        $request->session()->flash('msg_success', 'Supplier deleted succesfully!');
        $back = route('suppliers', $params);
        // dd($back);
        return redirect($back);
    }
}
