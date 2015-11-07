<?php

namespace App\Controller;

use Illuminate\Database\Capsule\Manager as Capsule;
use App\Controller\UserController as User;

class ThreadController
{
    public function show($category_id)
    {
        $threads = Capsule::table('threads')->where('category_id', $category_id)->get();
        return ['threads'   =>  $threads];
    }
    public function showthread($thread_id)
    {
        $posts = Capsule::table('posts')->where('thread_id', $thread_id)->orderBy('time', 'desc')->get();
        return ['posts' =>  $posts];
    }
    public function delete()
    {
        
    }
    public function create($category_id, $title, $body)
    {
        $user_id = User::User('id');
        $thread = Capsule::table('thread')->insert(['title' =>  $title, 'body'  =>  $body, 'category_id'    =>  $category_id, 'user_id' =>  $user_id]);
        return true;
        
    }
    public function edit()
    {
        
    }
}