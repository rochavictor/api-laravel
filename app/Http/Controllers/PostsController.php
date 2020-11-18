<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use Illuminate\Support\filter;
use Illuminate\Http\Request;
use App\Models\Posts;
use App\Models\Tags;

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
            return response()->json(
                [
                    'title' => $posts->title,
                    'author' => $posts->author,
                    'content' => $posts->content,
                    'tags' => $tags,
                    'id' => $posts->id
                ],
                201
            );
        } else {
            return response()->json([
                'type' => 'posts',
                'message' => 'Fail'
            ], 400);
        }
    }

    public function showbyid($id)
    {
        $posts = Posts::all()->map(function ($postTag) {
            $postTag['tags'] = $postTag->tags()->get()->pluck('tag')->all();
            return $postTag;
        })->all();

        $arrayPostsById = [];
        foreach($posts as $value){
            if($value['id'] == $id){
                $arrayPostsById[] = array(
                    'id'=>$value->id,
                    'title'=>$value->title,
                    'content'=>$value->content,
                    'tags'=>$value->tags
                );
                

            }
        }
        return $arrayPostsById;
    }




    public function showbytag($tag_name)
    {
        $tagsFilter = Tags::where('tag', $tag_name)->get();
        
        $postsFilter = [];
        foreach ($tagsFilter as $value){
            $postsFilter[] = app('App\Http\Controllers\PostsController')->showbyid($value->posts_id);
        }
        return response()->json($postsFilter, 200);
    }
}
