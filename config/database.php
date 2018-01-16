<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=Camagru', "root", "br200991");
} catch (PDOException $e) {
    try {
        $db = new PDO('mysql:host=localhost', "root", "br200991");
    } catch (PDOException $e) {
        $message = "Database unaviable, please try again later";
    }
}
?>
