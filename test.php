<?php
require_once "vendor/autoload.php";
require_once "app/config.php";
require_once "app/capsule.php";

use Illuminate\Database\Capsule\Manager as Capsule;

class Paginate
{
    public function getdata($limit = 10, $page = 1)
    {
        
        
        
        
        
    }
}
$test = Capsule::table('posts')->get();
$echo = count($test);
echo $echo;

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
        <div class="testing">
        <div class="test">
            <p class="body">This is a test</p>
        </div>
        </div>
        <span id="test"><a href="#" id="test" onclick="test();">Testing</a></span>
        <script type="text/javascript">
            function test() {
                var divHtml = $('.body').html(); // notice "this" instead of a specific #myDiv
                var editableText = $("<textarea />");
                editableText.val(divHtml);
                $('.test').closest('div').find('.body').replaceWith(editableText);
                editableText.focus();
            }
        </script>
        <div class="testing">
            <div class="test">
            <p class="body">This is a test</p>
        </div>
        </div>
        <div class="testing">
            <div class="test">
            <p class="body">This is a test</p>
        </div>
        </div>
        <div class="testing">
            <div class="test">
            <p class="body">This is a test</p>
        </div>
        </div>
        <!--<script type="text/javascript">
            var textarea = $("<form method='post' id='edit_post' name='edit_post'><textarea name='edit_post' id='edit_post'></textarea><button class='btn btn-info' name='edit_submit' id='edit_submit' style='float: right;' type='submit'>Edit Post</button></form>");
            $('#test a').click(function() {
                $(this)
                    .closest('div')
                    .find('.body')
                    .replaceWith(textarea);
            }
            CKEDITOR.replace('edit_post');
        </script> -->
        <script type="text/javascript">
            function clicked() {
                var divHtml = $('.body').html(); // notice "this" instead of a specific #myDiv
                var editableText = $("<textarea />");
                editableText.val(divHtml);
                $('.body').replaceWith(editableText);
                editableText.focus();
            }
        </script>
    </body>
</html>