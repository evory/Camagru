<?php

session_start();

$array_route = explode("/", $_GET['route']);
$controller = $array_route[1];
$action = $array_route[2];
print_r($controller);
if ($controller) {
    require("./controllers/".$controller.".php");
} else {
    // echo "controllers = " . print_r($controllers, $return = true);
    // echo "<br>";
    // echo "action = " . print_r($action, $return = true);
    // echo "<br>";
    include("./view/header.php");
    include("./view/home.php");
    include("./view/footer.php");
}

?>
