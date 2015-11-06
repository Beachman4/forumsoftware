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
$categories = $CatController->show();

$User = $UserController::User();

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
        <title>Login</title>
        <script type="text/javascript" src="public/js/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="public/js/functions.js"></script>
    </head>
    <body>
        <?php
        if (!(isset($loggedin))) {
            echo '<div class="login_ca_forms">
            <a href="#" onclick="login_click();" class="show_login">Login</a>
            <form method="post" class="login" action="/index.php" style="display:none">
                <input type="text" name="username" class="username" placeholder="Username">
                <input type="password" name="password" class="password" placeholder="Password">
                <input type="submit" name="submit">
                <a href="#" class="X" onclick="login_x_click();">X</a>
            </form>
            <a href="#" onclick="ca_click();" class="show_ca">Create Account</a>
            <form method="post" class="create" action="/index.php" style="display:none">
                <input type="text" name="ca_username" class="ca_username" placeholder="Username">
                <input type="email" name="ca_email" class="ca_email" placeholder="E-Mail Address">
                <input type="password" name="ca_password" class="ca_password" placeholder="Password">
                <input type="password" name="ca_cpassword" class="ca_cpassword" placeholder="Confirm Password">
                <input type="submit" name="ca_submit">
                <a href="#" class="ca_X" onclick=ca_x_click();>X</a>
            </form>
        </div>';
        } else {
            echo '<a href="index.php?logout=true">Logout</a>';
        } ?>
        <?php
            foreach ($categories as $category) {
                foreach ($category as $data) {
                    $id = $data['id'];
                    echo "<a href='/showthread.php?C=$id'>".$data['title']."</a>";
                    echo "<p class='body'>".$data['description']."</p>";
                }
            }
        ?>
    </body>
</html>