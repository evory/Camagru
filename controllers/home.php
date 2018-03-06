<?php

require_once('./models/user_infos.php');
require_once('./models/Database.class.php');
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

/*------------------------------SIDE-BAR-CANVAS-------------------------------*/
$username_log = $_SESSION['login'];
$recent_pics = Database::getInstance()->request("SELECT pics
                                                         FROM pictures
                                                         WHERE username = '$username_log';",
                                                         false, true);

for ($i=0; $recent_pics[$i] ; $i++) {
    $last_pic = $recent_pics[$i]['pics'];
    $canvas .= '<img class="sidebar_img" src ="http://localhost:8083/view/images/'.$last_pic.'" width="100px" height="80px">';
}


/*--------------------------------UPLOAD-PICS---------------------------------*/

if ($action == "upload_pic") {
    include("./view/header.php");
    if (isset($_POST['upload_pic'])) {
        if (!isset($_SESSION['login'])) {
            $message = "Please login if you want to upload pictures";
            include("./view/home.php");
            include("./view/footer.php");
            exit();
        }
        $target = "view/images/".basename($_FILES['image']['name']);

/*------------check-if-image-------------*/

        function isimage(){
            $type = $_FILES['image']['type'];
            $extensions = array('image/jpg','image/jpe','image/jpeg','image/jfif','image/png','image/bmp','image/dib','image/gif');
            if(in_array($type, $extensions)){
                return true;
            }
            else {
                return false;
            }
        }
    if (isimage()){
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
/*----------move-image-to-dir----------*/
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $message = "Image uploaded";
            Database::getInstance()->request("INSERT INTO pictures (username, pics, description, date_time)
            VALUES ('$username_post', '$image', '$description', '$date_time');",
            false, false);
        } else {
            $message = "Problem uploading image";
        }
        echo "<div id='img_div'>";
            echo "<img src ='http://localhost:8083/view/images/".$image."'>";
            echo "<a href='http://localhost:8083/home/modify_picture/$token_modify'>retoucher la photo</a>";
        echo "</div>";
    } else {
        $message = "file is not an image";
        include("./view/upload_pic.php");
        include("./view/footer.php");
        exit();
    }
    }
    include("./view/upload_pic.php");
    include("./view/footer.php");



}

/*------------------------------DISPLAY-PICTURES------------------------------*/
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
               <img src="'.("http://localhost:8083/view/images/$pic_name").'" height="300" width="400" class="img-thumnail" />
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
    $total_likes_pic = Database::getInstance()->request("SELECT id_like
                                                             FROM likes
                                                             WHERE id_pic = $pic_id;",
                                                             false, true);
    $total_likes_pic = count($total_likes_pic);
    if ($pic_username == $_SESSION['login']) {
        echo "<a href='http://localhost:8083/home/delete_pic?pic_id=$pic_id'>supprimer</a>";
    }
            echo '
                  <form class="" method="post">
                      <textarea name="commentPost" rows="3" cols="40" placeholder="Comment"></textarea>
                      <input type="hidden" name="pic_id" value='."$pic_id".'>
                      <input type="submit" name="sendComment" value="post">
                  </form>
                  <a href="gallery?type=like&id_pic=' . $pic_id . '"><img src="http://localhost:8083/view/ressources/thumb_like.png" width="23"></a> (' . $total_likes_pic . ')
                  <br>
                  <br>
                  <br>';
    }
/*-----------save-comment-----------*/
    if (isset($_POST['sendComment']) && !empty($_POST['commentPost'])) {
        if (emtpy($_SESSION['login'])) {
            $message = "Please log in to comments";
            exit();
        }
        $commentPost = $_POST['commentPost'];
        $current_pic_id = $_POST['pic_id'];
        $username = $_SESSION['login'];
        $date_time = date("F j, Y, g:i a");
        Database::getInstance()->request("INSERT INTO comments (id_comment, id_pic, username, comment, date_time)
                                          VALUES (NULL, '$current_pic_id', '$username', '$commentPost', '$date_time');",
                                          false, false);
    }
    if (isset($_GET['type'], $_GET['id_pic'])) {
        if (!is_numeric($_GET['id_pic'])) {
            $message = "wrong URL";
            exit();
        }
        $id_pic = $_GET['id_pic'];

        if ($_GET['type'] == "like") {
            if (empty($_SESSION['login'])) {
                $message = "<h3>Please log in to like photo</h3>";

            }
            $check_like = Database::getInstance()->request("SELECT id_like
                                                                     FROM likes
                                                                     WHERE id_pic = '$id_pic' AND username = '$username';",
                                                                     false, true);
            if (count($check_like) == 1) {
                Database::getInstance()->request("DELETE FROM likes
                                                  WHERE id_pic = '$id_pic' AND username = '$username';",
                                                  false, false);
            } else {
        Database::getInstance()->request("INSERT INTO likes (id_like, id_pic, username)
                                          VALUES (NULL, '$id_pic', '$username');",
                                          false, false);
            }
        }
    }
    include("./view/footer.php");
}


/*-----------delete-pics-----------*/

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

/*-----------------------------your-pictures----------------------------------*/

if($action == "your_pictures") {
    include("./view/header.php");
    include("./view/your_pictures.php");
    $username_log = $_SESSION['login'];
    $user_pictures = Database::getInstance()->request("SELECT *
                                                       FROM pictures
                                                       WHERE username = '$username_log';",
                                                       false, true);
    for ($i=0; $user_pictures[$i]; $i++) {
        $pic_id = $user_pictures[$i]['id_pic'];
        $pic_username = $user_pictures[$i]['username'];
        $pic_name = $user_pictures[$i]['pics'];
        $pic_time = $user_pictures[$i]['date_time'];
        echo "posted by <strong>$pic_username</strong> the $pic_time <br>";
        echo '
               <img src="'.("http://localhost:8083/view/images/$pic_name").'" height="300" width="400" class="img-thumnail" />
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
    $total_likes_pic = Database::getInstance()->request("SELECT id_like
                                                             FROM likes
                                                             WHERE id_pic = $pic_id;",
                                                             false, true);
    $total_likes_pic = count($total_likes_pic);
    if ($pic_username == $_SESSION['login']) {
        echo "<a href='http://localhost:8083/home/delete_pic?pic_id=$pic_id'>supprimer</a>";
    }
            echo '
                  <form class="" method="post">
                      <textarea name="commentPost" rows="3" cols="40" placeholder="Comment"></textarea>
                      <input type="hidden" name="pic_id" value='."$pic_id".'>
                      <input type="submit" name="sendComment" value="post">
                  </form>
                  <a href="your_pictures?type=like&id_pic=' . $pic_id . '"><img src="http://localhost:8083/view/ressources/thumb_like.png" width="23"></a> (' . $total_likes_pic . ')
                  <br>
                  <br>
                  <br>';
    }
    if (isset($_POST['sendComment']) && !empty($_POST['commentPost'])) {
        $commentPost = $_POST['commentPost'];
        $current_pic_id = $_POST['pic_id'];
        $username = $_SESSION['login'];
        $date_time = date("F j, Y, g:i a");
        Database::getInstance()->request("INSERT INTO comments (id_comment, id_pic, username, comment, date_time)
                                          VALUES (NULL, '$current_pic_id', '$username', '$commentPost', '$date_time');",
                                          false, false);
    }
    if (isset($_GET['type'], $_GET['id_pic'])) {
        if (!is_numeric($_GET['id_pic'])) {
            $message = "wrong URL";
            exit();
        }
        $id_pic = $_GET['id_pic'];
        if ($_GET['type'] == "like") {
            $check_like = Database::getInstance()->request("SELECT id_like
                                                                     FROM likes
                                                                     WHERE id_pic = '$id_pic' AND username = '$username';",
                                                                     false, true);
            if (count($check_like) == 1) {
                Database::getInstance()->request("DELETE FROM likes
                                                  WHERE id_pic = '$id_pic' AND username = '$username';",
                                                  false, false);
            } else {
                Database::getInstance()->request("INSERT INTO likes (id_like, id_pic, username)
                                          VALUES (NULL, '$id_pic', '$username');",
                                          false, false);
            }
        }
    }
    include("./view/footer.php");
}

/*------------------------------DELETE-MODIFYING-PICTURE----------------------*/
// if (empty($controllers) && empty($action)) {
//     if ($_GET['delete_pic']) {
//         $delete_pic = $_GET['delete_pic'];
//         if (@unlink(''.$root.'/view/images/'.$delete_pic.'')) { PROBLEME SECU - TOUT LE MONDE PEU DELETE EN CHANGEANT L'URL
//             $message = "picture deleted";
//         } else {
//             $message = "can't find your picture";
//         }
//     }
// }


/*------------------------------MODIFY-PICTURE------------------------------*/

if ($action == "modify_picture") {
    include("./view/header.php");
    $pic_data_64 = $_POST['modify_hidden'];
    $pic_data_64 = str_replace(' ', '+', $pic_data_64);
    $pic_data_64 = str_replace('data:image/png;base64,', '', $pic_data_64);
    $decoded_pic = base64_decode($pic_data_64);
    $timestamp = mktime();
    $current_picture = 'view/images/'.$username.'_'.$timestamp.'.png';
    if (!empty($decoded_pic)) {
        file_put_contents($current_picture, $decoded_pic);
    }
    echo'
        <img src="http://localhost:8083/view/images/' . $username . '_' . $timestamp . '.png" height="600" width="800" class="img-thumnail" />
        <br>
        <form method="post" action="index.php">
            <input type="hidden" name="publishPicture" value="'.$finalPics.'">
            <input type="submit" name="sendComment" value="publish">
        </form>
        <a class="delete_btn" href="http://localhost:8083?delete_pic=' . $username . '_' . $timestamp . '.png">delete</a>
        <br>
        ';
        if (isset($_GET['sticker'])) {
            $sticker = $_GET['sticker'];
            $dessous = imagecreatefrompng($current_picture_path); //on ouvre l'image de fond
            $dessus = imagecreatefrompng($sticker_path); //on ouvre l'image a incruster
            $infosize_dessous = getimagesize($current_picture_path); // on recupere la taille de l'image de fond dans un array
            $infosize_dessus = getimagesize($sticker_path);
            $src_w = $infosize_dessus[0];
            $src_h = $infosize_dessus[1];
            $dst_w = $infosize_dessous[0];
            $dst_h = $infosize_dessous[1];
            $result = imagecopyresampled ($dessous, $dessus, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
            imagepng($dessous, $current_picture); // on ecrit l'image traitee vers le fichier $filename
        }
    include("./view/modify_picture.php");
    include("./view/footer.php");
}

?>
