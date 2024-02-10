<?php

    echo
    '
        <style>
            *
            {
                margin: 0;
                font-family: Consolas;
            }
            
            hr
            {
                margin-top: 1vh;
                margin-bottom: 1vh;
                width: 50vh;
            }
            
            .hr2
            {
                width: 160vh;
            }
            
            h1
            {
                font-size: 5vh;
            }
            
            h2
            {
                font-size: 2.5vh;
                margin-bottom: 1vh;
            }
            
            h3
            {
                font-size: 2vh;
                margin-bottom: 1vh;
            }
            
            input
            {   
                font-size: 2.5vh;
                text-align: center;
                border: none;
                padding: 0.5vh 1vh;
                box-shadow: 0 0 0.5vh rgba(0, 0, 0, 0.3);
                border-radius: 2.5vh;
                margin-bottom: 1vh;
            }
            
            input:focus
            {
                outline: none;
            }
            
            button
            {
                width: 20vh;
                height: 5vh;
                font-size: 2.5vh;
                cursor: pointer;
                border-radius: 2.5vh;
                box-shadow: 0 0 0.5vh rgba(0, 0, 0, 0.3);
                border: none;
                margin-top: 1vh;
                margin-bottom: 1vh;
            }
            
            .login_container
            {
                margin-top: 15%;
            }
            
            .popup_overlay
            {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                display: none;
            }
            
            .popup_content
            {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background-color: #FFFFFF;
                padding: 2vh;
                border-radius: 2.5vh;
            }
            
            .popup_button_group
            {
                margin-right: 1vh;
            }
        </style>
    ';

?>
