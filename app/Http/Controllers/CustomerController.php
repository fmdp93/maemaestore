<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('q');

        $data['heading'] = "Customer";
        $data['title'] = "Customer";
        $data['search'] = $search;
        $data['delete_action'] = route('delete_customer');
        $data['edit_action'] = route('edit_customer');

        $Customer = new Customer();
        $data['customers'] = $Customer->getCustomers($search, '/customer');
        $data['d_none'] = count($data['customers']) ? 'd-none' : '';

        return view('pages.cashier.customer', $data);       
    }

    public function searchForTable(Request $request)
    {
        $search = $request->input('q');

        $Customer = new Customer();

        DB::enableQueryLog();
        $data['customers'] = $Customer->getCustomers($search, '/customer');
        $data['delete_action'] = $request->input('delete_action');
        $data['edit_action'] = $request->input('edit_action');
        $data['search'] = "$search";
        $rows = (string) view("components.cashier.customer-list", $data);

        $data['d_none'] = count($data['customers']) ? 'd-none' : '';
        $table_empty = (string) view("layouts.empty-table", $data);
        $links = (string) $data['customers']->links();
        $row_count = count($data['customers']);
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
     * Display add customer form
     * 
     * @return View
     */
    public function add_customer(){
        $data['heading'] = "Add Customer";
        $data['title'] = "Add Customer";

        return view('pages.cashier.add-customer', $data);
    }
    /**
     * Submit add customer form
     * 
     * @return redirect
     */
    public function add_customer_submit(Request $request){
        $input = $request->input();
        $rules = [
            'name' => 'required',            
            'address' => 'required',
            'contact_num' => 'required',
        ];
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $request->session()->flash('msg_success', 'Customer added successfully!');

        $customer = new Customer();
        $customer->name = $request->input('name');
        $customer->address = $request->input('address');
        $customer->contact_detail = $request->input('contact_num');
        $customer->save();

        return back();
    }
    /**
     * Display edit customer form
     * 
     * @return view
     */
    public function edit_customer(Request $request){
        $data['heading'] = "Edit Customer";
        $data['title'] = "Edit Customer";
        $customer = Customer::find($request->input('id'));
        $data['id'] = old('id') ?? $customer->id;    
        $data['name'] = old('name') ?? $customer->name;
        $data['address'] = old('address') ?? $customer->address;
        $data['contact_num'] = old('contact_num') ??  $customer->contact_detail;

        return view('pages.cashier.edit-customer', $data);
    }
    /**
     * Submit edit customer form
     * 
     * @return redirect
     */
    public function edit_customer_submit(Request $request){
        $input = $request->input();
        $id = $request->input('id');
        $name = $request->input('name');
        $address = $request->input('address');
        $contact_detail = $request->input('contact_num');

        $rules = [
            'id' => 'required|numeric|min:1',
            'name' => 'required',
            'address' => 'required',
            'contact_num' => 'required',
        ];
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $request->session()->flash('msg_success', 'Customer updated successfully!');

        $customer = Customer::where('id', $id)
        ->update([            
            'name' => $name,
            'address' => $address,
            'contact_detail' => $contact_detail,
        ]);

        return back();
    }
    /**
     * Delete customer 
     * 
     * @return redirect
     */
    public function delete_customer(Request $request){
        $customer_id = $request->input('customer_id');

        // sets url params
        $params = [
            'q' => $request->input('search'),
            'page' => $request->input('page'),
        ];

        Customer::where('id', $customer_id)
            ->update(['deleted_at' => date("Y-m-d H:i:s")]);
        $request->session()->flash('msg_success', 'Customer deleted succesfully!');
        $back = route('customer', $params);
        // dd($back);
        return redirect($back);
    }

    /**
     * Async request for pos customer search
     * 
     * @return JSON
     */
    public function searchForPos(Request $request){
        $search = $request->input('q');
        $response = [];
        $customers = Customer::getCustomerDetails($search);        
        foreach($customers as $customer){
            $response["customers"][] =[
                "id" =>  $customer->id,
                "name" =>  $customer->name,
                "address" =>  $customer->address,
                "contact_detail" =>  $customer->contact_detail,
            ];
        }

        return Response()->json(json_encode($response));
    }
}
