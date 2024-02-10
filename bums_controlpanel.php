<?php

    session_start();

    include($_SERVER['DOCUMENT_ROOT'].'/BAS/bas_connection.php');

    include 'bums_style.php';
    include 'bums_functions.php';

    // User authorization is checked.
    $authorized = (@$_SESSION['user_username'] == "bums_admin" && @$_SESSION['user_email'] == "bums_admin@mail.com" && @$_SESSION['user_authoritylevel'] == "999");

    // The page does not load if there is no user authorization.
    if (!$authorized)
    {
        echo '<center><h1>You are not authorized to view this page.</h1></center>';
        exit();
    }

    // Search User button.
    if (isset($_GET['search_user']))
    {
        $keyword = $_GET['search_user'];

        $query = "SELECT * FROM bas_users WHERE user_username = :keyword";
        $statement_search = $conn->prepare($query);
        $statement_search->execute(array(':keyword' => $keyword));
        $results = $statement_search->fetchAll(PDO::FETCH_ASSOC);
    }

    // Checking CSRF Token.
    if (isset($_SESSION["csrf_token"]) && isset($_POST["csrf_token"]) && $_SESSION["csrf_token"] == $_POST["csrf_token"])
    {
        // Logout button.
        if (isset($_POST['logout']))
        {
            include($_SERVER['DOCUMENT_ROOT'].'/BAS/bas_logout_include.php');
        }

        // Change Administrator Password button.
        if (isset($_POST['new_password']))
        {
            $username = "bums_admin";
            $new_password = $_POST['new_password'];
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            $sql = "UPDATE bas_users SET user_password = :hashed_password WHERE user_username = :username";

            $statement_new_pass = $conn->prepare($sql);
            $statement_new_pass->execute(array(':hashed_password' => $hashed_password, ':username' => $username));

            include($_SERVER['DOCUMENT_ROOT'].'/BAS/bas_logout_include.php');
        }

        // Pop-Up Button Group
        $update_fields = array('firstname', 'lastname', 'username', 'email', 'authoritylevel', 'mutestatus', 'banstatus');

        // Pop-Up Button Group SQL Commands
        foreach ($update_fields as $field)
        {
            if (isset($_POST['new_'.$field]))
            {
                $searched_user = $_GET['search_user'];
                $new_value = $_POST['new_'.$field];

                // The administrator user's information cannot be changed.
                if ($searched_user == "bums_admin")
                {
                    if ($field == 'firstname')
                    {
                        $new_value = "BUMS";
                    }

                    if ($field == 'lastname')
                    {
                        $new_value = "ADMIN";
                    }

                    if ($field == 'username')
                    {
                        $new_value = "bums_admin";
                    }

                    if ($field == 'email')
                    {
                        $new_value = "bums_admin@mail.com";
                    }

                    if ($field == 'authoritylevel')
                    {
                        $new_value = 999;
                    }

                    if ($field == 'mutestatus' || $field == 'banstatus')
                    {
                        $new_value = 0;
                    }
                }

                // Availability check on username or email change.
                if ($field == 'email' || $field == 'username')
                {
                    $checkQuery = "SELECT COUNT(*) FROM bas_users WHERE user_".$field." = :new_value";
                    $checkStatement = $conn->prepare($checkQuery);
                    $checkStatement->execute(array(':new_value' => $new_value));
                    $count = $checkStatement->fetchColumn();

                    if ($count > 0)
                    {
                        continue;
                    }
                }

                // The changes are being applied to the database.
                $sql = "UPDATE bas_users SET user_".$field." = :new_value WHERE user_username = :searched_user";
                $statement_update_info = $conn->prepare($sql);
                $statement_update_info->execute(array(':new_value' => $new_value, ':searched_user' => $searched_user));

                if($field == "username")
                {
                    BUMS_refreshPageAfterUserUpdate($new_value);
                }
                else
                {
                    BUMS_refreshPageAfterUserUpdate($searched_user);
                }
            }
        }
    }

?>

<html>
    <head>
        <title>BUMS - Control Panel</title>
    </head>
    
    <body>
        <center>
            <hr>

                <h1>BUMS</h1>
                <h2>CONTROL PANEL</h2>
                <form method="POST">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION["csrf_token"]; ?>">
                    <button type="submit" name="logout">LOGOUT</button>
                </form>
            
                <button id="open_popup">CHANGE PASS.</button>
                <div id="popup_overlay" class="popup_overlay">
                    <div class="popup_content">
                        <h2>CHANGE ADMIN PASSWORD</h2>
                        <form method="POST">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION["csrf_token"]; ?>">
                            <input type="password" name="new_password"></input><br>
                            <button type="submit">CHANGE PASS.</button>
                        </form>
                        <button id="close_popup">CANCEL</button>
                        <h3>(This action will log you out.)</h3>
                    </div>
                </div>

                <script>
                    document.getElementById("open_popup").addEventListener("click", function()
                    {
                        document.getElementById("popup_overlay").style.display = "block";
                    });

                    document.getElementById("close_popup").addEventListener("click", function()
                    {
                        document.getElementById("popup_overlay").style.display = "none";
                    });
                </script>

            <hr>

                <h2>SEARCH</h2>
                <form method="GET" action="">
                    <input type="text" name="search_user" placeholder="Username"><br>
                    <button type="submit">SEARCH</button>
                </form>

            <hr>

                <?php

                    if(isset($statement_search))
                    {
                        if ($statement_search->rowCount() > 0)
                        {
                            foreach ($results as $row)
                            {
                                echo "<h2>SEARCH RESULTS</h2>";
                                echo "<h3>User ID ---> " . $row['user_id'] . "</h3>";
                                echo "<h3>First Name ---> " . $row['user_firstname'] . "</h3>";
                                echo "<h3>Last Name ---> " . $row['user_lastname'] . "</h3>";
                                echo "<h3>Username ---> " . $row['user_username'] . "</h3>";
                                echo "<h3>Email ---> " . $row['user_email'] . "</h3>";
                                echo "<h3>Authority Level ---> " . $row['user_authoritylevel'] . "</h3>";
                                echo "<h3>Mute Status ---> " . $row['user_mutestatus'] . "</h3>";
                                echo "<h3>Ban Status ---> " . $row['user_banstatus'] . "</h3>";
                                echo "<h3>Register Date ---> " . $row['user_registerdate'] . "</h3>";
                                echo "<h3>Last Login ---> " . $row['user_lastlogin'] . "</h3>";
                            }

                            echo'<hr class="hr2">';

                            echo BUMS_generatePopupButtons(7);
                            echo '<script>'.BUMS_generatePopupEventListeners(7).'</script>';

                            echo'<hr class="hr2">';
                        }
                    }

                ?>
        </center>
    </body>
</html>
