<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LikeController extends Controller
{
    //

    public function store(Request $request, Post $post)
    {
        $post->likes()->create([
            'user_id'=>$request->user()->id
            
        ]);
        return back();
    }

    public function distroy(Request $request, Post $post)
    {
        $request->user()->likes()->where('post_id',$post->id)->delete();

        return back();
    }
}
