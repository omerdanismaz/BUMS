<?php

    // Refreshes the page when changes are made to the user information.
    function BUMS_refreshPageAfterUserUpdate($user)
    {
        $redirect = $_SERVER['PHP_SELF'] . "?search_user=" . $user;
        header("Location: $redirect");
    }

    // Creates event listener for pop up windows.
    function BUMS_generatePopupEventListeners($count)
    {
        $eventListeners = '';

        for ($i = 0; $i < $count; $i++)
        {
            $eventListeners .=
            '
                document.getElementById("open_popup_' . $i . '").addEventListener("click", function()
                {
                    document.getElementById("popup_overlay_' . $i . '").style.display = "block";
                });

                document.getElementById("close_popup_' . $i . '").addEventListener("click", function()
                {
                    document.getElementById("popup_overlay_' . $i . '").style.display = "none";
                });
            ';
        }

        return $eventListeners;
    }

    // Creates pop-up buttons.
    function BUMS_generatePopupButtons($count)
    {
        include 'bums_config.php';
        $buttons = '';
    
        for ($i = 0; $i < $count; $i++)
        {
            $buttons .=
            '
                <button class="popup_button_group" id="open_popup_' . $i . '">' . $cfg_pop_up_configs[$i]['button_name'] . '</button>
                <div id="popup_overlay_' . $i . '" class="popup_overlay">
                    <div class="popup_content">
                        <h2>' . $cfg_pop_up_configs[$i]['pop_up_title'] . '</h2>
                        <form method="POST">
                            <input type="hidden" name="csrf_token" value="' . $_SESSION["csrf_token"] . '">
                            <input type="text" name="new_' . $cfg_pop_up_configs[$i]['update']. '"></input><br>
                            <button type="submit">SEND DATA</button>
                        </form>
                        <button id="close_popup_' . $i . '">CANCEL</button>
                    </div>
                </div>
            ';
        }
    
        return $buttons;
    }
?>
