<?php
namespace App\Controller;
/*
User Controller class

Handles logins
*/


use Illuminate\Database\Capsule\Manager as Capsule;


class UserController
{
    
    public function login($username, $password)
    {
        $hashed_password = md5($password);
        $auth = Capsule::table('users')->where('username', $username)->first();
        $id = $auth['id'];
        if ($this->checkLocked($id)) {
            echo "Your account is Locked";
            return false;
        } else {
            if ($auth['password'] == $hashed_password) {
                $offset = (60 * 60) * 7;
                $now = time() - $offset;
                $time = date("Y/m/d H:i:s", $now);
                Capsule::table('users')->where('id', $id)->update(['last_login' =>  $time]);
                $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
                $_SESSION['username'] = $username;
                $id = preg_replace("/[^0-9]+/", "", $id);
                $_SESSION['id'] = $id;
                return true;
            } else {
                $now = time();
                Capsule::table('login_attempts')->insert(['id'  =>  $id, 'time' =>  $now]);
                return false;
            }
        }
        
    }
    public function checkLocked($user_id) {
        $now = time();
        $valid_attempts = $now - (15 * 60);
        $login_attempts = Capsule::table('login_attempts')->where('id', $user_id)->where('time', $now)->get();
        if (count($login_attempts) > 5) {
            return true;
        } else {
            return false;
        }
    }
    public function create($username, $email, $fname, $lname, $password)
    {
        $hashed_password = md5($password);
        $checkusername = Capsule::table('users')->where('username', $username)->first();
        $checkemail = Capsule::table('users')->where('email', $email)->first();
        if (empty($checkusername)) {
            if (empty($checkemail)) {
                Capsule::table('users')->insert(['username' =>  $username, 'email'  =>  $email, 'first_name'    =>  $fname, 'last_name' =>  $lname, 'password'  =>  $hashed_password]);
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
    static function User()
    {
        if (isset($_SESSION['id'])) {
            $id = $_SESSION['id'];
            $user = Capsule::table('users')->where('id', $id)->first();
            return $user;
        }
    }
    public function logout()
    {
        session_destroy();
        header('Location:/index.php');
    }
    public function edit($fname, $lname, $user_id)
    {
        Capsule::table('users')->where('id', $user_id)->update(['first_name'    =>  $fname, 'last_name' =>  $lname]);
        return true;
    }
    public function editpassword($edit_password, $user_id)
    {
        Capsule::table('users')->where('id', $user_id)->update(['password'  =>  $edit_password]);
        return true;
    }
}

?>
