<?php
namespace App\Controller;
/*
User Controller class

Handles logins
*/

namespace App\Controller;

use Illuminate\Database\Capsule\Manager as Capsule;


class UserController
{
    
    public function login($username, $password, $con)
    {
        $auth = Capsule::table('users')->where('username', $username)->first();
        $id = $auth['id'];
        if ($this->checkLocked($id)) {
            echo "Your account is Locked";
            return false;
        } else {
            if ($auth['password'] == $password) {
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
    public function create($username, $email, $password)
    {
        Capsule::table('users')->insert(['username' =>  $username, 'email'  =>  $email, 'password'  =>  $password]);
        return true;
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
}

?>
