<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posts;

class PostsController extends Controller
{
    public function show()
    {
        $posts = Posts::all()->map(function ($postTag) {
            $postTag['tags'] = $postTag->tags()->get()->pluck('tag')->all();
            return $postTag;
        })->all();
        return response()->json($posts, 200);
    }

    public function register(Request $request)
    {
        $title = $request->input('title');
        $author = $request->input('author');
        $content = $request->input('content');
        $tags = $request->input('tags');

        $data = array(
            'title' => $title,
            'author' => $author,
            'content' => $content,
        );

        $posts = Posts::create($data);
        if ($posts) {
            app('App\Http\Controllers\TagsController')->registerTag($tags, $posts->id);
            return response()->json([
                'title'=>$posts->title, 
                'author'=>$posts->author,
                'content'=>$posts->content,
                'tags' => $tags,
                'id'=>$posts->id],
                201);

        } else {
            return response()->json([
                'type' => 'posts',
                'message' => 'Fail'
            ], 400);
        }
    }
}
