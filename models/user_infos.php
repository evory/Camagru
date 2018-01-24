<?php

require_once("./models/Database.class.php");

// $data = $db->query('SELECT posts.titre, user.username FROM posts LEFT JOIN likes ON posts.id = likes.post LEFT JOIN user ON likes.id_user = user.id');
// print_r($data->fetchAll(PDO::FETCH_ASSOC));

$login_db = Database::getInstance()->request('SELECT username FROM user');
print_r($login_db);
//
// $password_db = $db->query('SELECT hash FROM user');
// $password_array = $password_db->fetchAll(PDO::FETCH_ASSOC);
//
// $email_db = $db->query('SELECT email FROM user');
// $email_array = $email_db->fetchAll(PDO::FETCH_ASSOC);
//
// $user_info = $db->query('SELECT * FROM user');
// $user_array = $user_info->fetchAll(PDO::FETCH_ASSOC);
