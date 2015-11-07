<?php

namespace App\Controller;

use Illuminate\Database\Capsule\Manager as Capsule;

class CategoryController
{
    public function show()
    {
        $categories = Capsule::table('categories')->get();
        return ['categories'    =>  $categories];
    }
    public function create($title, $description)
    {
        $category = Capsule::table('categories')->insert(['title'   =>  $title, 'description'   =>  $description]);
        return true;
    }
    public function edit($category_id, $title, $description)
    {
        $category = Capsule::table('categories')->where('id', $category_id)->first();
        $update_category = Capsule::table('categories')->where('id', $category_id)->update(['title' =>  $title, 'description'   =>  $description]);
        return true;
        
    }
    public function delete($category_id, $move_id=false)
    {
        $category = Capsule::table('categories')->where('id', $category_id)->first();
        $threads = Capsule::table('threads')->where('category_id', $category_id)->get();
        if ($move_id != false) {
            foreach ($threads as $thread) {
                $update_threads = Capsule::table('threads')->where('category_id',$category_id)->update(['category_id'   =>  $move_id]);
            }
        } else {
            foreach ($threads as $thread) {
                $thread_id = $thread['id'];
                $posts = Capsule::table('posts')->where('thread_id', $thread_id)->delete();
                $delete_thread = Capsule::table('threads')->where('id', $thread_id)->delete();
            }
        }
        return true;
    }
    
}

?>