<?php

namespace App\Controller;

use Illuminate\Database\Capsule\Manager as Capsule;

class ThreadController
{
    public function show($category_id)
    {
        $threads = Capsule::table('threads')->where('category_id', $category_id)->get();
        return ['threads'   =>  $threads];
    }
    public function showthread($thread_id)
    {
        $posts = Capsule::table('posts')->where('thread_id', $thread_id)->get();
        return ['posts' =>  $posts];
    }
}