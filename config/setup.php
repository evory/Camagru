<?php

require("./database.php");
$init = file_get_contents("./Camagru.sql");
// $data = $db->quote($init);
// var_dump($init);
$db->exec($init);
