<?php

if(!defined("DB_HOST"))
    define("DB_HOST", "localhost");

if(!defined("DB_DATABASE"))
    define("DB_DATABASE", "Camagru");

if(!defined("DB_USER"))
    define("DB_USER", "root");

if(!defined("DB_PASSWORD"))
    define("DB_PASSWORD", "br200991");

include_once("./models/Database.class.php");

$init = file_get_contents("./config/Camagru.sql");
if ((Database::getInstance()->request($init)) == false) {
    echo "Successfully connect to the database";
}
