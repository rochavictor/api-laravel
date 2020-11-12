<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posts;
use App\Models\Tags;


class PostsController extends Controller
{
    public function show()
    {
        $posts = Posts::all();
        return response()->json([
            'data' => $posts
        ], 200);
    }
}
