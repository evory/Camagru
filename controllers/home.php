<?php

require_once('./models/user_infos.php');
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
        echo "<div id='img_div'>";
            echo "<img src ='".$root."/view/images/".$image."'>";
            echo "<p>".$descritpion."</p>";
        echo "</div>";
    }
    include("./view/header.php");
    include("./view/upload_pic.php");
    include("./view/footer.php");
}

// if (empty($action)) {;
//
//     if (!empty($_POST['upload_snap'])) {
//         var_dump($_POST);
//     }
// }

if ($action == "gallery") {
    include("./view/header.php");
    include("./view/gallery.php");
    for ($i=0; $allPictures[$i]; $i++) {
        $pic_id = $allPictures[$i]['id_pic'];
        $pic_username = $allPictures[$i]['username'];
        $pic_name = $allPictures[$i]['pics'];
        $pic_time = $allPictures[$i]['date_time'];
        echo "posted by $pic_username the $pic_time";
        echo '
             <tr>
                  <td>
                       <img src="'.("http://localhost:8081/view/images/$pic_name").'" height="200" width="200" class="img-thumnail" />
                  </td>
                  <textarea name="description" rows="4" cols="40" placeholder="Comment"></textarea>
                  <input type="submit" name="sendComment" value="ok">
                  <a href="#">like</a>
             </tr>';
             echo "<br>";
    }
    include("./view/footer.php");
}
?>
