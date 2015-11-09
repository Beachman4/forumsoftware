<?php

namespace App;

use Illuminate\Database\Capsule\Manager as Capsule;

class Paginate
{
    public function getdata($thread_id, $limit = 10, $page = 1)
    {
        
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
        $prevlink = ($page > 1) ? '<a href="?page=1" title="First page">&laquo;</a> <a href="?page=' . ($page - 1) . '" title="Previous page">&lsaquo;</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';

    // The "forward" link
    $nextlink = ($page < $pages) ? '<a href="?page=' . ($page + 1) . '" title="Next page">&rsaquo;</a> <a href="?page=' . $pages . '" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';

    // Display the paging information
    echo '<div id="paging"><p>', $prevlink, $nextlink, ' </p></div>';
        
        $posts = Capsule::table('posts')->where('thread_id', $thread_id)->orderBy('time', 'asc')->skip($offset)->take($limit)->get();
        foreach ($get as $data) {
            echo $data['body'];
        }
    }
}