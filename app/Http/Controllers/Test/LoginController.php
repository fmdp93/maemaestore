<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function index(){
        $username = "user";
        // $name = "francis";
        $fruits = [
            "a" => "apple",
            "b" => "banana",
        ];
        $data['uname'] = $username;
        $data['data'] = $fruits;
        // return view('login', compact('name'));
        // return view('login')->with('uname', $username)->with('data', $data);
        return view('test.test-user', $data);
    }

    public function about(){
        return 'Welcome to about page';
    }

    public function user($id){
        $users = [
            1 => "Francis",
            2 => "Dominic",
        ];

        return view('test.test-user', [
            'data' => $users[$id] ?? "User $id not found",
        ]);
    }
}
