<?php
namespace App;

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

?>
<html>
    <head>
        <title>Threads</title>
    </head>
    <body>
    
        <?php
            if (isset($_GET['C'])) {
                foreach ($threads as $thread) {
                    foreach ($thread as $data) {
                        $thread_id = $data['id'];
                        echo "<a href='/showthread.php?T=$thread_id'>".$data['title']."</a>";
                    }
                }
            }
            if (isset($_GET['T'])) {
                foreach ($posts as $post) {
                    foreach ($post as $data) {
                        echo $data['body'];
                    }
                }
            }
            ?>
        
    </body>
</html>