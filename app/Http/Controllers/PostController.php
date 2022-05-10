<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PostController extends Controller
{
    //
    public function index()
    {
        $id = 5;
        // can pass params/named params like PDO
        // $posts = DB::select('SELECT * FROM posts WHERE id = :id', ['id' => 5]);

        // using chaining Query builder
        $posts = DB::table('posts')
            ->where('id', $id)
            ->get();

        dd($posts);
        return view('test.post');
    }
}
