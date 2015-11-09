<?php
session_start();
require_once "vendor/autoload.php";
require_once "app/config.php";
require_once "app/capsule.php";
use Illuminate\Database\Capsule\Manager as Capsule;
use App\Controller\UserController;
use App\Controller\CategoryController;
$con = mysqli_connect($hostname, $dbusername, $dbpassword, $db);
$UserController = new UserController;
$CatController = new CategoryController;

$User = UserController::User();

if (isset($_GET['logout'])) {
    if ($_GET['logout'] == true) {
        $UserController->logout();
    }
}

if (isset($_SESSION['username'], $_SESSION['id'])) {
    $loggedin = true;
} else {
    header("Location:/index.php");
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
if (isset($_POST['submit_settings'])) {
    $fname = $con->real_escape_string($_POST['fname']);
    $lname = $con->real_escape_string($_POST['lname']);
    if ($UserController->edit($fname, $lname, $User['id'])) {
        header("Location:/settings.php");
    }
}
if (isset($_POST['change_password_submit'])) {
    if ($_POST['change_password'] == $_POST['con_change_password']) {
        $edit_password = md5($_POST['change_password']);
        if ($UserController->editpassword($edit_password, $User['id'])) {
            header("Location:/settings.php");
        }
    } else {
        echo "Passwords do not match";
    }
}
?>
<html>
    <head>
        <title>Forum</title>
        <link rel="stylesheet" href="/public/bootstrap/bootstrap.css" />
        <link rel="stylesheet" href="/public/bootstrap/bootstrap-theme.css" />
        <link rel="stylesheet" href="/public/css/main.css"/>
        <script type="text/javascript" src="public/js/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="/public/bootstrap/bootstrap.min.js"></script>
        <script type="text/javascript" src="public/js/functions.js"></script>
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
            <!--<h1 id="login_now">Login or Create an Account to post</h1>-->
        </div>';
        } else {
            if ($User['admin'] == 1) {
                echo '<a href="admin/index.php" class="admin_link"><button role="button" class="btn btn-info">Admin Panel</button></a>';
            }
            echo '<a href="settings.php" class="settings_btn"><button role="button" class="btn btn-success">Settings</button></a>
            <a href="index.php?logout=true" class="logout"><button role="button" class="btn btn-danger">Logout</button></a>
            <!-- Future Project
            <div class="shoutbox">
                <div class="messages"></div>
                <div id="shoutbox_message">
                    <form method="post" class="shoutbox_message" action="/index.php">
                        <input type="text" name="message" size="80" class="message" placeholder="Enter your Message">
                        <input type="submit" name="submit">
                    </form>
                </div>
            </div>-->';
        }?>
        </div>
        
        <a href="/index.php" class="home"><button role="button" class="btn btn-success">Home</button></a>
        <div class="settings">
            <?php
            if (isset($_GET['edit_password'])) {
                echo '<form method="post" class="edit_password" name="edit_password">
                    <input type="password" name="change_password" placeholder="Password" class="change_password form-control">
                    <input type="password" name="con_change_password" placeholder="Confirm Password" class="con_change_password form-control">
                    <button type="submit" name="change_password_submit" class="btn btn-success" id="change_password_submit">Change Password</button>
                </form>
                <a href="settings.php" class="back_settings"><button role="button" class="btn btn-default">Back to Settings</button></a>';
            } else {
            echo '<form method="post" name="settings" id="settings">
                <input type="text" name="fname" class="fname form-control" value="'.$User['first_name'].'">
                <input type="text" name="lname" class="lname form-control" value="'.$User['last_name'].'">
                <button type="submit" class="btn btn-success" id="submit_settings" name="submit_settings">Edit Settings</button>
            </form>
            <a href="settings.php?edit_password=true" class="edit_pass_btn"><button role="button" class="btn btn-default">Edit Password</button></a>';} ?>
        </div>
        
        
    </body>
</html>