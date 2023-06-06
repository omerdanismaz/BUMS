<?php

    include($_SERVER['DOCUMENT_ROOT'].'/BAS/bas_login_include.php');
    
    include 'bums_style.php';

?>

<html>
    <head>
        <title>BUMS - Control Panel</title>
    </head>

    <body>
        <center>
            <div class="login_container">
                <h1>BUMS</h1>
                <h2>Administrator Login</h2>

                <form method="POST">
                    <label for="email_or_username"><h3>Email or Username</h3></label>
                    <input type="text" name="email_or_username" required>
                    <label for="password"><h3>Password</h3></label>
                    <input type="password" name="password" required>
                    <br>
                    <button type="submit">LOGIN</button>
                </form>

                <h2>(Check the "create_admin_user.sql" file for the default email, username and the password information.)</h2>
            </div>
        </center>
    </body>
</html>
