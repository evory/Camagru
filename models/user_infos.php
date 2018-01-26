<?php

require_once("./models/Database.class.php");

// $data = $db->query('SELECT posts.titre, user.username FROM posts LEFT JOIN likes ON posts.id = likes.post LEFT JOIN user ON likes.id_user = user.id');
// print_r($data->fetchAll(PDO::FETCH_ASSOC));

$login_db = Database::getInstance()->request('SELECT username FROM user', false, true);
$login_db = array_map('current', $login_db);

$email_db = Database::getInstance()->request('SELECT email FROM user', false, true);
$email_db = array_map('current', $email_db);

$hash_db = Database::getInstance()->request('SELECT hash FROM user', false, true);
$hash_db = array_map('current', $hash_db);

$user_db = Database::getInstance()->request('SELECT * FROM user', false, true);
$user_db = array_map('current', $user_db);
