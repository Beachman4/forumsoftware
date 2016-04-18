<?php
require_once 'vendor/autoload.php';
require_once 'app/config.php';
require_once 'app/capsule.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$paginate = new Paginate();
$paginate->getdata();
?>
<html>
    <head>
        <link rel="stylesheet" href="/public/bootstrap/bootstrap.css" />
        <link rel="stylesheet" href="/public/bootstrap/bootstrap-theme.css" />
        <script type="text/javascript" src="public/js/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="/public/bootstrap/bootstrap.min.js"></script>
        <script type="text/javascript" src="public/js/functions.js"></script>
        <script type="text/javascript" src="/public/ckeditor/ckeditor.js"></script>
    </head>
    <body>
        
    </body>
</html>