<?php

require_once('./models/user_infos.php');
require_once('./models/Database.class.php');
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

/*--------------------------------UPLOAD-PICS---------------------------------*/
include("./view/header.php");
$canvas = '	<canvas class="sidebar_canvas">';
          ' </canvas>';
include("./view/home.php");
include("./view/footer.php");

if ($action == "upload_pic") {
    include("./view/header.php");
    if (isset($_POST['upload_pic'])) {
        if (!isset($_SESSION['login'])) {
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
        echo "<div id='img_div'>";
            echo "<img src ='http://localhost:8081/view/images/".$image."'>";
            echo "<p>".$descritpion."</p>";
            echo "<a href='http://localhost:8081/home/modify_picture/$token_modify'>retoucher la photo</a>";
        echo "</div>";
    }
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
    if (empty($_SESSION['login'])) {
        echo "Please log in to comment <br>";
    }
/*--------display pictures--------*/
    for ($i=0; $allPictures[$i]; $i++) {
        $pic_id = $allPictures[$i]['id_pic'];
        $pic_username = $allPictures[$i]['username'];
        $pic_name = $allPictures[$i]['pics'];
        $pic_time = $allPictures[$i]['date_time'];
        echo "posted by <strong>$pic_username</strong> the $pic_time <br>";
        echo '
               <img src="'.("http://localhost:8081/view/images/$pic_name").'" height="300" width="400" class="img-thumnail" />
               <br>';
/*-------display-comments-----------*/
    $current_pic_comment = Database::getInstance()->request("SELECT comment
                                                             FROM comments
                                                             WHERE id_pic = $pic_id;",
                                                             false, true);

        for ($j=0; $current_pic_comment[$j]; $j++) {
            $username_comment = Database::getInstance()->request("SELECT username
                                                                  FROM comments
                                                                  WHERE id_pic = $pic_id;",
                                                                  false, true);
            if (is_array($current_pic_comment[$j])) {
                $lastcomment =  current($current_pic_comment[$j]);
            }
            if (is_array($username_comment)) {
                $username_comment = current($username_comment[$j]);
            }
            echo "$username_comment : $lastcomment";
            echo "<br>";
         }
/*-----------comment-box------------*/
if ($pic_username == $_SESSION['login']) {
    echo "<a href='http://localhost:8081/home/delete_pic?pic_id=$pic_id'>supprimer</a>";
}
        echo '
                  <form class="" method="post">
                      <textarea name="commentPost" rows="4" cols="40" placeholder="Comment"></textarea>
                      <input type="hidden" name="pic_id" value='."$pic_id".'>
                      <input type="submit" name="sendComment" value="post">
                  </form>
                  <a href="#"><img src="http://localhost:8081/view/ressources/thumb_like.png" width="23"></a>
                  <br>
                  <br>
                  <br>';
    }
/*-----------save-comment-----------*/
    if (isset($_POST['sendComment']) && !empty($_POST['commentPost'])) {
        $commentPost = $_POST['commentPost'];
        $current_pic_id = $_POST['pic_id'];
        $username = $_SESSION['login'];
        $date_time = date("F j, Y, g:i a");
        Database::getInstance()->request("INSERT INTO comments (id_comment, id_pic, username, comment, date_time)
                                          VALUES (NULL, '$current_pic_id', '$username', '$commentPost', '$date_time');",
                                          false, false);
    }
    include("./view/footer.php");
}

if ($action == "modify_picture") {
    include("./view/header.php");
    include("./view/modify_picture.php");
    include("./view/footer.php");
}
/*----------delete-user---------*/

if ($action == "delete_pic") {
    include("./view/header.php");
    $delete_pic = $_GET['pic_id'];
    $username_pic_check = Database::getInstance()->request("SELECT username
                                                     FROM pictures
                                                     WHERE id_pic = $delete_pic;",
                                                     false, false);
    $check_if_exist = Database::getInstance()->request("SELECT id_pic
                                                     FROM pictures
                                                     WHERE id_pic = $delete_pic;",
                                                     false, false);
    if ($check_if_exist == false) {
        include("./view/delete_pic.php");
        include("./view/footer.php");
        exit();
    }
    if ($_SESSION['login'] == current($username_pic_check)) {
            Database::getInstance()->request("DELETE FROM `pictures`
            WHERE id_pic = '$delete_pic';", false, false);
            //delete comms likes etc
    }

        include("./view/delete_pic.php");
        include("./view/footer.php");
}

?>
