<?php

require_once "vendor/autoload.php";



?>
<html>
    <head>
        <title>Login</title>
        <script type="text/javascript" src="public/js/jquery-2.1.4.min.js"></script>
        <script type="text/javascript">
            var login_click = function() {
                $('.show_login').hide();
                $('.show_ca').hide();
                $('.login').show();
            }
            var login_x_click = function() {
                $('.login').hide();
                $('.show_ca').show();
                $('.show_login').show();
            }
            var ca_click = function() {
                $('.show_login').hide();
                $('.show_ca').hide();
                $('.create').show();
                
            }
            var ca_x_click = function() {
                $('.create').hide();
                $('.show_login').show();
                $('.show_ca').show();
            }
        </script>
    </head>
    <body>
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
    </body>
</html>