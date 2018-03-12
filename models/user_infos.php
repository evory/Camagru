<?php

require_once("./models/Database.class.php");

$username = $_SESSION['login'];

/*--------------------------------------------------------*/

$login_db = Database::getInstance()->request('SELECT username
                                              FROM user',
                                              false, true);
$login_db = array_map('current', $login_db);

/*--------------------------------------------------------*/

$email_db = Database::getInstance()->request('SELECT email
                                              FROM user',
                                              false, true);
$email_db = array_map('current', $email_db);

/*--------------------------------------------------------*/

$hash_db = Database::getInstance()->request('SELECT hashh
                                             FROM user',
                                             false, true);
$hash_db = array_map('current', $hash_db);

/*--------------------------------------------------------*/

$user_db = Database::getInstance()->request('SELECT *
                                             FROM user',
                                             false, true);

if (isset($_SESSION['login'])) {
    $user_id = Database::getInstance()->request("SELECT id
                                                 FROM user
                                                 WHERE username = '$username';",
                                                 false, false);
    if (!empty($user_id)) {
        $user_id = current($user_id);
    }
}

/*--------------------------------------------------------*/

$user_email = Database::getInstance()->request("SELECT email
                                                FROM user
                                                WHERE username = '$username';",
                                                false, false);
if (!empty($user_email)) {
    $user_email = current($user_email);
}

/*--------------------------------------------------------*/

$htoken_db = Database::getInstance()->request('SELECT htoken
                                               FROM user;',
                                               false, true);
$htoken_db = array_map('current', $htoken_db);

/*--------------------------------------------------------*/

$confirm_token_db = Database::getInstance()->request('SELECT confirm_token
                                             FROM user;',
                                             false, true);
$confirm_token_db = array_map('current', $confirm_token_db);


$allPictures = Database::getInstance()->request('SELECT *
                                                 FROM pictures
                                                 ORDER BY id_pic DESC;',
                                                 false, true);