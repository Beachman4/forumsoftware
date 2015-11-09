<?php
namespace App;
session_start();
if (!(isset($_GET['T'], $_GET['editpost']))) {
    header('Location:/index.php');
}
require_once "vendor/autoload.php";
require_once "app/config.php";
require_once "app/capsule.php";
use Illuminate\Database\Capsule\Manager as Capsule;
use App\Controller\UserController as User;
use App\Controller\ThreadController;
$con = mysqli_connect($hostname, $dbusername, $dbpassword, $db);
$UserController = new User;
$ThreadController = new ThreadController;

$User = User::User();

if (isset($_GET['logout'])) {
    if ($_GET['logout'] == true) {
        $UserController->logout();
    }
}

if (isset($_SESSION['username'], $_SESSION['id'])) {
    $loggedin = true;
}
      
if (isset($_GET['logout'])) {
    if ($_GET['logout'] == true) {
        $UserController->logout();
        header('Location:/index.php');
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
    if ($_POST['ca_password'] != $_POST['ca_cpassword']) {
        echo "Your password does not match";
    } else {
        $username = $con->real_escape_string($_POST['ca_username']);
        $email = $con->real_escape_string($_POST['ca_email']);
        $password = $con->real_escape_string($_POST['ca_password']);
        if ($UserController->create($username, $email, $password)) {
            echo "Account Created";
        }
    }
}
if (isset($_POST['edit_submit'])) {
    $edited_body = $_POST['edit_post'];
    $thread_id = $_GET['T'];
    $post_id = $_GET['editpost'];
    if ($ThreadController->editpost($post_id, $edited_body)) {
        header('Location:/showthread.php?T='.$thread_id);
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
            <!-- Future Project
            <div class="shoutbox">
                <div class="messages"></div>
                <div id="shoutbox_message">
                    <form method="post" class="shoutbox_message" action="/index.php">
                        <input type="text" name="message" size="80" class="message" placeholder="Enter your Message">
                        <input type="submit" name="submit">
                    </form>
                </div> -->
            </div>';
        }?>

        </div>
        
        <?php
        
        $thread_id = $_GET['T'];
        $post_id = $_GET['editpost'];
        $post = Capsule::table('posts')->select('body', 'user_id')->where('id',$post_id)->first();
        $body = $post['body'];
        if ($User['admin']==1) {
            echo '<div class="post_edit">';
            echo '<div class="edit_post"><form method="post" name="edit" id="edit">
                <textarea name="edit_post" id="edit_post" >'.$body.'</textarea>
                <script type="text/javascript">
                    CKEDITOR.replace("edit_post");
                </script>
                <button class="btn btn-info" name="edit_submit" id="edit_submit" style="float: right;" type="submit">Edit Post</button>
            </form></div>';
        echo '</div>';
        } elseif ($post['user_id'] == $User['id']) {
            echo '<div class="posts">';
        if ($User['readonly'] == 1) {
            header('Location: /index.php');
        } elseif (isset($loggedin)) {
            echo '<div class="edit_post"><form method="post" name="edit" id="edit">
                <textarea name="edit_post" id="edit_post" >'.$body.'</textarea>
                <script type="text/javascript">
                    CKEDITOR.replace("edit_post");
                </script>
                <button class="btn btn-info" name="edit_submit" id="edit_submit" style="float: right;" type="submit">Edit Post</button>
            </form></div>';}
        echo '</div>';
        } else {
            header("Location: /index.php");
        }
        ?>
    </body>
</html>