<?php

session_start();

$url = explode("/", $_GET['url']);
$controller = $url[1];
$action = $url[2];

if ($controller) {
    require("./controllers/".$controller.".php");
}
else {
    require("./controllers/home.php");
    include("./view/header.php");
    include("./view/home.php");
    include("./view/footer.php");
}

?>
