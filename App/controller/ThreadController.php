<?php

namespace App\Controller;

use Illuminate\Database\Capsule\Manager as Capsule;
use App\Controller\UserController as User;

class ThreadController
{
    public function show($category_id)
    {
        $limit = 10;
        $page = 1;
        $total = count(Capsule::table('threads')->where('category_id', $category_id)->get());
        $pages = ceil($total/$limit);
        $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
            'options' => array(
                'default'   => 1,
                'min_range' => 1,
            ),
        )));
        $offset = ($page - 1) * $limit;
        $start = $offset + 1;
        $end = min(($offset + $limit), $total);
        $prevlink = ($page > 1) ? '<a href="?T='.$category_id.'&page=1" title="First page">&laquo;</a> <a href="?T='.$category_id.'&page=' . ($page - 1) . '" title="Previous page">&lsaquo;</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';

    // The "forward" link
    $nextlink = ($page < $pages) ? '<a href="?T='.$category_id.'&page=' . ($page + 1) . '" title="Next page">&rsaquo;</a> <a href="?T='.$category_id.'&page=' . $pages . '" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';

    // Display the paging information
    if (isset($_GET['add_thread'])) {
        return true;
    } else {
        echo '<div id="paging"><p>', $prevlink, $nextlink, ' </p></div>';
    }
        
        $threads = Capsule::table('threads')->where('category_id', $category_id)->orderBy('time', 'asc')->skip($offset)->take($limit)->get();
        return ['threads'   =>  $threads];
    }
    public function showthread($thread_id)
    {
        $limit = 10;
        $page = 1;
        $total = count(Capsule::table('posts')->where('thread_id', $thread_id)->get());
        $pages = ceil($total/$limit);
        $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
            'options' => array(
                'default'   => 1,
                'min_range' => 1,
            ),
        )));
        $offset = ($page - 1) * $limit;
        $start = $offset + 1;
        $end = min(($offset + $limit), $total);
        $prevlink = ($page > 1) ? '<a href="?T='.$thread_id.'&page=1" title="First page">&laquo;</a> <a href="?T='.$thread_id.'&page=' . ($page - 1) . '" title="Previous page">&lsaquo;</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';

    // The "forward" link
    $nextlink = ($page < $pages) ? '<a href="?T='.$thread_id.'&page=' . ($page + 1) . '" title="Next page">&rsaquo;</a> <a href="?T='.$thread_id.'&page=' . $pages . '" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';

    // Display the paging information
    echo '<div id="paging"><p>', $prevlink, $nextlink, ' </p></div>';
        
        $posts = Capsule::table('posts')->where('thread_id', $thread_id)->orderBy('time', 'asc')->skip($offset)->take($limit)->get();
        return ['posts' =>  $posts];
    }
    public function delete($thread_id)
    {
        Capsule::table('threads')->where('id', $thread_id)->delete();
        Capsule::table('posts')->where('thread_id', $thread_id)->delete();
        return true;
    }
    public function create($category_id, $title, $body, $user_id)
    {
        $offset = (60 * 60) * 5;
        $now = time() + $offset;
        $time = date("Y/m/d H:i:s", $now);
        $thread = Capsule::table('threads')->insert(['title' =>  $title, 'category_id'    =>  $category_id, 'user_id' =>  $user_id, 'time'  =>  $time]);
        $get_thread = Capsule::table('threads')->orderBy('time', 'desc')->first();
        $thread_id = $get_thread['id'];
        $post = Capsule::table('posts')->insert(['body' =>  $body, user_id  =>  $user_id, 'thread_id'   =>  $thread_id, 'primary_post'  =>  '1', 'time' =>  $time]);
        return true;
        
    }
    public function edit()
    {
        
    }
    public function addpost($thread_id, $user_id, $body)
    {
        $offset = (60 * 60) * 5;
        $now = time() + $offset;
        $time = date("Y/m/d H:i:s", $now);
        Capsule::table('posts')->insert(['body' =>  $body, 'user_id'    =>  $user_id, 'thread_id'   =>  $thread_id, 'primary_post'  =>  '0', 'time'  =>  $time]);
        return true;
    }
    public function editpost($post_id, $edited_body)
    {
        Capsule::table('posts')->where('id',$post_id)->update(['body'    =>  $edited_body]);
        return true;
    }
    public function deletepost($post_id)
    {
        Capsule::table('posts')->where('id', $post_id)->delete();
        return true;
    }
}