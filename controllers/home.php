<?php

require_once('./models/Database.class.php');
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

/*--------------------------------UPLOAD-PICS---------------------------------*/
if ($action == "upload_pic") {
    if (isset($_POST['upload_pic'])) {
        if (!isset($_SESSION['login'])) {
            include("./view/header.php");
            $message = "Plase login if you want to upload pictures";
            include("./view/home.php");
            include("./view/footer.php");
            exit();
        }
        $target = "view/images/".basename($_FILES['image']['name']);
        $username_post = $_SESSION['login'];
        $image = $_FILES['image']['name'];
        $description = $_POST['description' ];
        $date_time = date("F j, Y, g:i a");
        if (empty($image)) {
            include("./view/header.php");
            $message = "No picture uploaded, please select a file";
            include("./view/upload_pic.php");
            include("./view/footer.php");
            exit();
        }
        // print_r($_SESSION['login']);
        // echo "<br>";
        // print_r($image);
        // echo "<br>";
        // print_r($description);
        // echo "<br>";
        // print_r($date_time);
        // echo "<br>";
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $message = "Image uploaded";
            Database::getInstance()->request("INSERT INTO pictures (username, pics, description, date_time)
            VALUES ('$username_post', '$image', '$description', '$date_time');",
            false, false);
        } else {
            $message = "Problem uploading image";
        }


        $tab = Database::getInstance()->request("SELECT * FROM pictures;",
        false, true);
        $tab = current($tab);
        print_r($description);
        echo "<div id='img_div'>";
            echo "<img src ='".$root."/view/images/".$image."'>";
            echo "<p>".$descritpion."</p>";
        echo "</div>";
    }
    include("./view/header.php");
    include("./view/upload_pic.php");
    include("./view/footer.php");
}
?>
