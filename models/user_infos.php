<?php

require("./config/database.php");

// $data = $db->query('SELECT posts.titre, user.username FROM posts LEFT JOIN likes ON posts.id = likes.post LEFT JOIN user ON likes.id_user = user.id');
// print_r($data->fetchAll(PDO::FETCH_ASSOC));

/*-------------------------VAR---------------------------*/
$i = 0;

$login_db = $db->query('SELECT username FROM user');
$login_db = $login_db->fetchAll(PDO::FETCH_ASSOC);

$password_db = $db->query('SELECT hash FROM user');
$password_db = $password_db->fetchAll(PDO::FETCH_ASSOC);

$email_db = $db->query('SELECT email FROM user');
$email_db = $email_db->fetchAll(PDO::FETCH_ASSOC);

$user_info = $db->query('SELECT * FROM user');
$user_info = $user_info->fetchAll(PDO::FETCH_ASSOC);

?>
