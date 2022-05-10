<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function product($name, $brand_id){
        $data['name'] = $name;
        $data['brand_id'] = $brand_id;
        return view('test.product', $data);
    }
}
