<?php

require_once('./models/Database.class.php');

if (isset($_POST['upload'])) {
    $target = "view/images/".basename($_FILES['image']['name']);
    $username_post = "insert_username";
    $image = $_FILES['image']['name'];
    $description = $_POST['description'];
    $date_time = time();
    // print_r($username_post);
    // echo "<br>";
    // print_r($image);
    // echo "<br>";
    // print_r($description);
    // echo "<br>";
    // print_r($date_time);
    // echo "<br>";
    Database::getInstance()->request("INSERT INTO pictures (username, pics, description, date_time)
                                      VALUES ('$username_post', '$image', '$description', '$date_time');",
                                      false, false);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $message = "Image uploaded";
    } else {
        $message = "Problem uploading image";
    }
}
