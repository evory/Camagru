<?php

require("./config/database.php");

// $data = $db->query('SELECT posts.titre, user.username FROM posts LEFT JOIN likes ON posts.id = likes.post LEFT JOIN user ON likes.id_user = user.id');
// print_r($data->fetchAll(PDO::FETCH_ASSOC));

$login_db = $db->query('SELECT username FROM user');
$login_array = $login_db->fetchAll(PDO::FETCH_ASSOC);

$password_db = $db->query('SELECT hash FROM user');
$password_array = $password_db->fetchAll(PDO::FETCH_ASSOC);

$email_db = $db->query('SELECT email FROM user');
$email_array = $email_db->fetchAll(PDO::FETCH_ASSOC);

$user_info = $db->query('SELECT * FROM user');
$user_array = $user_info->fetchAll(PDO::FETCH_ASSOC);
?>
