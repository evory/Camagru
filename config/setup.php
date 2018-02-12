<?php
include_once("../models/Database.class.php");
include_once("db-config.php");

$init = file_get_contents("Camagru.sql");
if ((Database::getInstance()->request($init)) == false) {
    echo "Successfully connected to the database";
}
?>
<form action="/" method="get">
    <input type="submit" value="Homepage">
</form>
