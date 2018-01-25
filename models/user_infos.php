<?php

require_once("./models/Database.class.php");

// $data = $db->query('SELECT posts.titre, user.username FROM posts LEFT JOIN likes ON posts.id = likes.post LEFT JOIN user ON likes.id_user = user.id');
// print_r($data->fetchAll(PDO::FETCH_ASSOC));

$login_db = Database::getInstance()->request('SELECT username FROM user', false, true);
print_r($login_db);
echo "<br>";
$email_db = Database::getInstance()->request('SELECT email FROM user', false, true);
$hash_db = Database::getInstance()->request('SELECT hash FROM user', false, true);
$user_db = Database::getInstance()->request('SELECT * FROM user', false, true);
