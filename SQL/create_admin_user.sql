/*

    // DO NOT CHANGE ANY INFORMATION EXCEPT THE ADMINISTRATOR PASSWORD.
    // CHANGE THE ADMINISTRATOR PASSWORD ONLY THROUGH THE CONTROL PANEL.
    // IF YOU FORGET YOUR PASSWORD, DELETE THE AUTHORIZED USER FROM THE DATABASE AND RE-REGISTER USING THIS SQL COMMAND.

    Admin Username = bums_admin
    Admin Email = bums_admin@mail.com
    Default Admin Password = adminpass

*/

INSERT INTO bas_users (user_firstname, user_lastname, user_username, user_email, user_password, user_authoritylevel, user_mutestatus, user_banstatus, user_registerdate, user_lastlogin)
VALUES ('BUMS', 'ADMIN', 'bums_admin', 'bums_admin@mail.com', '$2y$10$IYkzMmrGNBrB8UmD9ctewuzEmdxaNJD/xL.yrdKBzGI2lc6MYuc26', 999, 0, 0, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
