<?php

namespace App\Controller;

use Illuminate\Database\Capsule\Manager as Capsule;

class AdminController
{
    public function getusers()
    {
        $limit = 20;
        $page = 1;
        $total = count(Capsule::table('users')->get());
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
        
        if (isset($_GET['user'])) {
            return true;
        } elseif (isset($_GET['edit_user'])) {
            return true;
        } elseif (isset($_GET['create_user'])) {
            return true;
        } else {
            echo '<div id="paging"><p>', $prevlink, $nextlink, ' </p></div>';
        }
        
        $users = Capsule::table('Users')->skip($offset)->take($limit)->get();
        return ['users' =>  $users];
    }
    public function createuser($username, $fname, $lname, $email, $password, $admin, $readonly)
    {
        $password = md5($password);
        $checkusername = Capsule::table('users')->where('username', $username)->first();
        $checkemail = Capsule::table('users')->where('email', $email)->first();
        if (empty($checkusername)) {
            if (empty($checkemail)) {
                Capsule::table('users')->insert(['username' =>  $username, 'email'  =>  $email, 'first_name'    =>  $fname, 'last_name' =>  $lname, 'password'   =>  $password, 'admin' =>  $admin, 'readonly'  =>  $readonly]);
                return true;
            } else {
                echo "That email already exists";
                return false;
            }
        } else {
            echo "That username already exists";
            return false;
        }
    }
    public function edituser($user_id, $username, $email, $fname, $lname, $admin, $readonly)
    {
        Capsule::table('users')->where('id', $user_id)->update(['username'  =>  $username, 'email'  =>  $email, 'first_name'    =>  $fname, 'last_name' =>  $lname, 'admin' =>  $admin, 'readonly'  =>  $readonly]);
        return true;
    }
    public function edituserpassword($user_id, $edited_password)
    {
        Capsule::table('users')->where('id', $user_id)->update(['password'  =>  $edit_password]);
        return true;
    }
    public function delete($user_id)
    {
        Capsule::table('users')->where('id', $user_id)->delete();
        return true;
    }
}