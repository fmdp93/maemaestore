<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{    
    public function index(){
        $data['heading'] = 'Add Category';
        $data['categories'] = Category::whereNull('deleted_at')
            ->orderBy('id', 'desc')
            ->paginate(Config::get('constant.per_page'));
        return view('pages.admin.add-category', $data);
    }

    public function store(Request $Request){
        $Request->validate([
            'name' => 'required',
        ]);

        Category::create([
            'name' => $Request->input('name')
        ]);

        $Request->session()->flash('msg_success', 'Category added');
        
        return redirect()->action([CategoryController::class,'index']);
    }

    public function delete(Request $Request){    
        $message = [
            'unique' => 'Category is being used. Delete request aborted.'
        ];    
        $rules = [
            'category_id' => 'unique:product,category_id'
        ];

        $validator = Validator::make($Request->input(), $rules, $message);

        if($validator->fails()){
            return redirect()->action([CategoryController::class,'index'])
                ->withErrors($validator);                
        }

        $category = Category::find($Request->input('category_id'));

        //not returning right value;
        $category->delete();
        $Request->session()->flash('msg_success', 'Category deleted');

        return redirect()->action([CategoryController::class,'index']);
    }
}
