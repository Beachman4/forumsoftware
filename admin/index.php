<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/app/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/app/capsule.php';
use App\Controller\AdminController;
use App\Controller\UserController as User;
use Illuminate\Database\Capsule\Manager as Capsule;

$con = mysqli_connect($hostname, $dbusername, $dbpassword, $db);
$UserController = new User();
$AdminController = new AdminController();

$User = User::User();

$Users = $AdminController->getusers();

if ($User['admin'] == 0) {
    header('Location:/index.php');
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
        echo 'Login Failed';
    }
}
if (isset($_POST['ca_submit'])) {
    $username = $con->real_escape_string($_POST['ca_username']);
    $email = $con->real_escape_string($_POST['ca_email']);
    $fname = $con->real_escape_string($_POST['ca_fname']);
    $lname = $con->real_escape_string($_POST['ca_lname']);
    $password = $con->real_escape_string($_POST['ca_password']);
    if ($UserController->create($username, $email, $password)) {
        echo 'Account Created';
    }
}
if (isset($_GET['delete_user'])) {
    if ($User['admin'] == 1) {
        $user_id = $_GET['delete_user'];
        if ($AdminController->delete($user_id)) {
            header('Location:index.php');
        }
    } else {
        header('Location:/index.php');
    }
}
if (isset($_POST['submit_edit'])) {
    $user_id = $_GET['edit_user'];
    $username = $con->real_escape_string($_POST['username']);
    $email = $con->real_escape_string($_POST['email']);
    $fname = $con->real_escape_string($_POST['fname']);
    $lname = $con->real_escape_string($_POST['lname']);
    $admin = $_POST['edit_admin'];
    switch ($admin) {
        case 'Yes':
            $admin = 1;
            break;
        case 'No':
            $admin = 0;
            break;
    }
    $readonly = $_POST['edit_readonly'];
    switch ($readonly) {
        case 'Yes':
            $readonly = 1;
            break;
        case 'No':
            $readonly = 0;
            break;
    }
    if ($AdminController->edituser($user_id, $username, $email, $fname, $lname, $admin, $readonly)) {
        header("Location:index.php?user=$user_id");
    }
}

if (isset($_POST['create_user_submit'])) {
    $username = $con->real_escape_string($_POST['create_username']);
    $email = $con->real_escape_string($_POST['create_email']);
    $fname = $con->real_escape_string($_POST['create_fname']);
    $lname = $con->real_escape_string($_POST['create_lname']);
    $password = $con->real_escape_string($_POST['create_password']);
    $admin = $_POST['create_admin'];
    switch ($admin) {
        case 'Yes':
            $admin = 1;
            break;
        case 'No':
            $admin = 0;
            break;
    }
    $readonly = $_POST['create_readonly'];
    switch ($readonly) {
        case 'Yes':
            $readonly = 1;
            break;
        case 'No':
            $readonly = 0;
            break;
    }
    if ($AdminController->createuser($username, $fname, $lname, $email, $password, intval($admin), intval($readonly))) {
        header('Location:index.php');
    }
}
if (isset($_POST['admin_password_submit'])) {
    if ($_POST['admin_password'] == $_POST['con_admin_password']) {
        $edited_password = md5($con->real_escape_string($_POST['admin_password']));
        $user_id = $_GET['edit_user'];
        if ($AdminController->edituserpassword($user_id, $edited_password)) {
            header("Location:index.php?user=$user_id");
        }
    } else {
        echo 'Your passwords do not match';
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
                    <input type="text" name="ca_fname" class="ca_fname form-control" placeholder="First Name">
                    <input type="text" name="ca_lname" class="ca_lname form-control" placeholder="Last Name">
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
                echo '<a href="/admin/index.php" class="admin_link"><button role="button" class="btn btn-info">Admin Panel</button></a>';
            }
            echo '<a href="/settings.php" class="settings_btn"><button role="button" class="btn btn-success">Settings</button></a>
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
        <?php
            if (isset($_GET['create_user'])) {
                echo '<a href="index.php" class="back_user"><button role="button" class="btn btn-success">Back</button></a>';
                echo '<div class="create_user">';
                echo '<form method="post" name="create_user" id="create_user">
                Username: <input type="text" name="create_username" class="create_username form-control" placeholder="Username">
                E-Mail Address: <input type="text" name="create_email" class="create_email form-control" placeholder="E-Mail Address">
                First Name: <input type="text" name="create_fname" class="create_fname form-control" placeholder="First Name">
                Last Name: <input type="text" name="create_lname" class="create_lname form-control" placeholder="Last Name">
                Password: <input type="password" name="create_password" class="create_password form-control" placeholder="Password">
                Admin? <select name="create_admin" class="create_admin form-control">
                    <option>No</option>
                    <option>Yes</option>
                </select>
                Readonly? <select name="create_readonly" class="create_readonly form-control">
                    <option>No</option>
                    <option>Yes</option>
                </select>
                <button type="submit" class="btn btn-success" id="create_user_submit" name="create_user_submit">Create User</button>
            </form>
            </div>';
            } elseif (isset($_GET['edit_password'])) {
                $user_id = $_GET['edit_user'];
                $User = Capsule::table('users')->where('id', $user_id)->first();
                echo '<a href="index.php?user='.$_GET['edit_user'].'" class="back_user"><button role="button" class="btn btn-success">Back</button></a>';
                echo '<div class="edit_user">';
                echo '<form method="post" class="admin_edit_password" name="admin_edit_password">
                    Password: <input type="password" name="admin_password" placeholder="Password" class="admin_password form-control">
                    Confirm Password: <input type="password" name="con_admin_password" placeholder="Confirm Password" class="con_admin_password form-control">
                    <button type="submit" name="admin_password_submit" class="btn btn-success" id="admin_password_submit">Change Password</button>
                </form>';
            } elseif (isset($_GET['edit_user'])) {
                echo '<a href="index.php?user='.$_GET['edit_user'].'" class="back_user"><button role="button" class="btn btn-success">Back</button></a>';
                echo '<div class="edit_user">';
                $user_id = $_GET['edit_user'];
                $User = Capsule::table('users')->where('id', $user_id)->first();
                echo '<form method="post" name="edit_user" id="edit_user">
                Username: <input type="text" name="username" class="username form-control" value="'.$User['username'].'">
                E-Mail Address: <input type="text" name="email" class="email form-control" value="'.$User['email'].'">
                First Name: <input type="text" name="fname" class="fname form-control" value="'.$User['first_name'].'">
                Last Name: <input type="text" name="lname" class="lname form-control" value="'.$User['last_name'].'">
                Admin? <select name="edit_admin" class="edit_admin form-control">
                    <option>No</option>
                    <option>Yes</option>
                </select>
                Readonly? <select name="edit_readonly" class="edit_readonly form-control">
                    <option>No</option>
                    <option>Yes</option>
                </select>
                <button type="submit" class="btn btn-success" id="submit_edit" name="submit_edit">Edit Settings</button>
            </form>
            </div>';
            } elseif (isset($_GET['user'])) {
                $user_id = $_GET['user'];
                $edit_User = Capsule::table('users')->where('id', $user_id)->first();
                $valadmin = $edit_User['admin'];
                $valreadonly = $edit_User['readonly'];
                switch ($valadmin) {
                    case 0:
                        $valadmin = 'No';
                        break;
                    case 1:
                        $valadmin = 'Yes';
                        break;
                }
                switch ($valreadonly) {
                    case 0:
                        $valreadonly = 'No';
                        break;
                    case 1:
                        $valreadonly = 'Yes';
                        break;
                }
                echo '<a href="index.php" class="back_user"><button role="button" class="btn btn-success">Back</button></a>';
                echo '<div class="User_info">
                <a href="index.php?delete_user='.$_GET['user'].'" class="delete_user_btn"><button role="button" class="btn btn-danger">Delete User</button></a>
                <a href="index.php?edit_user='.$_GET['user'].'" class="edit_user_btn"><button role="button" class="btn btn-default">Edit User</button></a>
                <a href="index.php?edit_user='.$_GET['user'].'&edit_password=true" class="edit_password_btn"><button role="button" class="btn btn-default">Edit Password</button></a>
                <div id="user_info">
                <h3><strong>Username</strong></h3>
                <h4 class="username">'.$edit_User['username'].'</h4>
                <p><strong>First Name</strong></p>
                <p class="fname">'.$edit_User['first_name'].'</p>
                <p><strong>Last Name</strong></p>
                <p class="lname">'.$edit_User['last_name'].'</p>
                <p><strong>E-Mail Address</strong></p>
                <p class="email">'.$edit_User['email'].'</p>
                <p><strong>Admin?</strong></p>
                <p class="admin">'.$valadmin.'</p>
                <p><strong>Read Only?</strong></p>
                <p class="readonly">'.$valreadonly.'</p>';
            } else {
                echo '<a href="/index.php" class="home"><button type="button" class="btn btn-success">Home</button></a>';
                echo '<a href="categories.php" class="categories_btn"><button type="button" class="btn btn-default">Categories</button></a>';
                echo '<a href="index.php?create_user=true" class="add_user_btn"><button type="button" class="btn btn-default">Create User</button></a>';
                echo '<div class="Users">';
                foreach ($Users as $user) {
                    foreach ($user as $data) {
                        echo '<div class="user_admin">';
                        echo '<a href="index.php?user='.$data['id'].'" class="username">'.$data['username'].'</a>';
                        echo '</div>';
                    }
                }
            }

?>
        
        </div>
        <script type="text/javascript">
            var last = $('.Users').last();
        $('#paging').appendTo(last);
        </script>
    </body>
</html>