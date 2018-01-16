<?php

session_start();

// require_once('./config/setup.php');

$array_route = explode("/", $_GET['route']);
$controller = $array_route[1];
$action = $array_route[2];

if ($controller) {
    require("./controllers/".$controller.".php");
} else {
    include("./view/header.php");
    include("./view/home.php");
    include("./view/footer.php");
}

?>
