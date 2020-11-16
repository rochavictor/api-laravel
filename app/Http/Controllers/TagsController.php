<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tags;

class TagsController extends Controller
{
    public function registerTag($tags, $post_id)
    {
        foreach ($tags as $value) {
            $data = array(
                'tag' => $value,
                'posts_id' => $post_id
            );
            $tag = Tags::create($data);
        }

        if ($tag) {
            return response()->json($tag->id, 201);
        } else {
            return response()->json([
                'type' => 'tags',
                'message' => 'Fail'
            ], 400);
        }
    }
}