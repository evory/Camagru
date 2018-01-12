<?php

require("./config/connexion.php");

$data = $db->query('SELECT * FROM users');
// print_r($data->fetch(PDO::FETCH_ASSOC));
?>
