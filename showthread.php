<?php
namespace App;
session_start();

require_once "vendor/autoload.php";
require_once "app/config.php";
require_once "app/capsule.php";
use Illuminate\Database\Capsule\Manager as Capsule;
use App\Controller\UserController;
use App\Controller\ThreadController;
$con = mysqli_connect($hostname, $dbusername, $dbpassword, $db);
$UserController = new UserController;
$ThreadController = new ThreadController;

$User = $UserController::User($con);

if (isset($_GET['logout'])) {
    if ($_GET['logout'] == true) {
        $UserController->logout();
    }
}

if (isset($_SESSION['username'], $_SESSION['id'])) {
    $loggedin = true;
}

if (isset($_GET['C'])) {
    $category_id = $_GET['C'];
    $threads = $ThreadController->show($category_id);
}
if (isset($_GET['T'])) {
    $thread_id = $_GET['T'];
    $posts = $ThreadController->showthread($thread_id);
}       
        if (isset($_GET['logout'])) {
    if ($_GET['logout'] == true) {
        $UserController->logout();
    }
}

if (isset($_SESSION['username'], $_SESSION['id'])) {
    $loggedin = true;
}
if (isset($_POST['submit'])) {
    $username = $con->real_escape_string($_POST['username']);
    $password = $con->real_escape_string($_POST['password']);
    if ($UserController->login($username, $password)) {
        header('Location:/index.php');
    } else {
        echo "Login Failed";
    }
}
if (isset($_POST['ca_submit'])) {
    $username = $con->real_escape_string($_POST['ca_username']);
    $email = $con->real_escape_string($_POST['ca_email']);
    $password = $con->real_escape_string($_POST['ca_password']);
    if ($UserController->create($username, $email, $password)) {
        echo "Account Created";
    }
}
?>
<html>
    <head>
        <title>Forum</title>
        <link rel="stylesheet" href="/public/bootstrap/bootstrap.css" />
        <link rel="stylesheet" href="/public/bootstrap/bootstrap-theme.css" />
        <link rel="stylesheet" href="/public/css/main.css"/>
        <script type="text/javascript" src="/public/js/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="/public/bootstrap/bootstrap.min.js"></script>
        <script type="text/javascript" src="/public/js/functions.js"></script>
        <script type="text/javascript" src="/public/ckeditor/ckeditor.js"></script>
    </head>
    <body>
        <div class="header">
        <?php
        if (!(isset($loggedin))) {
            echo '<div class="login_ca_forms">
            <a href="#" onclick="login_click();" class="show_login"><button role="button" class="btn btn-default">Login</button></a>
            <div class="login_panel" style="display:none">
                <form method="post" class="login" action="/index.php">
                    <input type="text" name="username" class="username form-control" placeholder="Username">
                    <input type="password" name="password" class="password form-control" placeholder="Password">
                    <input type="submit" name="submit" class="submit" value="Login">
                    <button class="close_login" onclick="login_x_click();">Close</button>
                </form>
            </div>
            <a href="#" onclick="ca_click();" class="show_ca"><button role="button" class="btn btn-default">Create Account</button></a>
            <div class="ca_panel" style="display:none">
                <form method="post" class="create" action="/index.php">
                    <input type="text" name="ca_username" class="ca_username form-control" placeholder="Username">
                    <input type="email" name="ca_email" class="ca_email form-control" placeholder="E-Mail Address">
                    <input type="password" name="ca_password" class="ca_password form-control" placeholder="Password">
                    <input type="password" name="ca_cpassword" class="ca_cpassword form-control" placeholder="Confirm Password">
                    <input type="submit" name="ca_submit">
                    <button class="close_create" onclick="ca_x_click();">Close</button>
                </form>
            </div>
        </div>
        <div class="login_now">
            <h1 id="login_now">Login or Create an Account to post</h1>
        </div>';
        } else {
            if ($User['admin'] == 1) {
                echo '<a href="admin/index.php" class="admin_link"><button role="button" class="btn btn-info">Admin Panel</button></a>';
            }
            echo '<a href="index.php?logout=true" class="logout"><button role="button" class="btn btn-danger">Logout</button></a>
            <div class="shoutbox">
                <div class="messages"></div>
                <div id="shoutbox_message">
                    <form method="post" class="shoutbox_message" action="/index.php">
                        <input type="text" name="message" size="80" class="message" placeholder="Enter your Message">
                        <input type="submit" name="submit">
                    </form>
                </div>
            </div>';
        }?>
        </div>
        <?php
            if (isset($_GET['C'])) {
                echo '<div class="threads">';
                foreach ($threads as $thread) {
                    foreach ($thread as $data) {
                        echo '<div id="thread">';
                        $thread_id = $data['id'];
                        $user_id = $data['user_id'];
                        $thread_starter = Capsule::table('users')->select('username')->where('id',$user_id)->first();
                        echo "<a href='/showthread.php?T=$thread_id'>".$data['title']."</a>";
                        echo "<p class='started_by'>Started By: ".$thread_starter['username']."</p>";
                        echo '</div>';
                    }
                }
                echo '</div>';
            }
            if (isset($_GET['T'])) {
                echo '<div id="posts">';
                foreach ($posts as $post) {
                    foreach ($post as $data) {
                        echo '<div class="post">';
                        echo '<div class="user">';
                        $user_id = $data['user_id'];
                        $poster = Capsule::table('users')->select('username')->where('id', $user_id)->first();
                        echo "<p class='poster' style='text-align: center; word-wrap: break-word;'>".$poster['username']."</p></div><div class='body'>";
                        echo "<p id='body'>".$data['body']."</p>";
                        echo '</div></div>';
                    }
                }
                echo '<div class="add_post"><form method="post" name="add" id="add">
                    <textarea name="add_post" id="add_post" ></textarea>
                    <script type="text/javascript">
                        CKEDITOR.replace("add_post");
                    </script>
                    <button class="btn btn-info" id="reply_submit" style="float: right;" type="submit">Post Reply</button>
                </form></div>';
                echo '</div>';
            }
            ?>
    </body>
</html>