<?php

require_once('./models/user_infos.php');
require_once('./models/Database.class.php');

/*-------------------------LOGIN-------------------------*/

if ($action == "login") {
    if (isset($_POST['submit'])) {
        if (empty($_POST['username'])) {
            include("./view/header.php");
            $message = "Username is empty";
            include("./view/login.php");
            include("./view/footer.php");
            exit();
        } else if (Database::getInstance()->verify_duplicates($login_db, $_POST['username'])) {
            $username = $_POST['username'];
        } else {
            include("./view/header.php");
            $message = "Wrong username";
            include("./view/login.php");
            include("./view/footer.php");
            exit();
        }
        if (empty($_POST['password'])) {
            include("./view/header.php");
            $message = "Password field is empty";
            include("./view/login.php");
            include("./view/footer.php");
            exit();
        } else {
            $hash_user_db = Database::getInstance()->request("SELECT hash FROM user WHERE username = '$username';", false, false);
        }
        if ($username && password_verify($_POST['password'], $hash_user_db['hash'])) {
            if (Database::getInstance()->verify_duplicates($login_db, $username) == 0) {
                include("./view/header.php");
                $message = "Wrong username";
                include("./view/login.php");
                include("./view/footer.php");
                exit();
            } else if ($hash_dup) {
                include("./view/header.php");
                $message = "Wrong password";
                include("./view/login.php");
                include("./view/footer.php");
                exit();
            } else {
                $_SESSION['login'] = $username;
            }
        }
        else {
            $message = "Wrong ID";
        }
    }
    include("./view/header.php");
    include("./view/login.php");
    include("./view/footer.php");
}

/*-------------------------LOGOUT-------------------------*/

if ($action == "logout")
{
    session_destroy();
    header("Location:/");
}

/*-------------------------SIGNIN-------------------------*/

if ($action == "signin")
{
    if (isset($_POST['submit'])) {
        if (empty($_POST['email'])) {
            include("./view/header.php");
            $message = "Email is empty";
            include("./view/signin.php");
            include("./view/footer.php");
            exit();
        }
        if (Database::getInstance()->verify_duplicates($email_db, $_POST['email'])) {
            include("./view/header.php");
            $message = "Email already exists";
            include("./view/signin.php");
            include("./view/footer.php");
            exit();
        }
        if (empty($_POST['username'])) {
            include("./view/header.php");
            $message = "Username is empty";
            include("./view/signin.php");
            include("./view/footer.php");
            exit();
        }
        if (Database::getInstance()->verify_duplicates($login_db, $_POST['username'])) {
            include("./view/header.php");
            $message = "Username already taken";
            include("./view/signin.php");
            include("./view/footer.php");
            exit();
        }
        if (empty($_POST['password'])) {
            include("./view/header.php");
            $message = "Password field is empty";
            include("./view/signin.php");
            include("./view/footer.php");
            exit();
        }
        if (($_POST['password'] !== $_POST['confirm_password'])) {
            include("./view/header.php");
            $message = "Password don't match";
            include("./view/signin.php");
            include("./view/footer.php");
            exit();
        }
        $username = $_POST['username'];
        $email = $_POST['email'];
        $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        if ($username && $hash && $email) {
            $_SESSION['email'] = $email;
            $_SESSION['login'] = $username;
            Database::getInstance()->request("INSERT INTO `user` (`id`, `email`, `username`, `hash`) VALUES (NULL, '$email', '$username', '$hash');", false, false);
            $message = "Bienvenue $username !";
            // ENVOYER EMAIL
        }
    }
    include("./view/header.php");
    include("./view/signin.php");
    include("./view/footer.php");
}

/*------------------------ACCOUNT--------------------------*/

if ($action == "account") {
    $username = $_SESSION['login'];
    $user_id = Database::getInstance()->request("SELECT id FROM user WHERE username = '$username';", false, false);
    if (isset($_POST['changeUsername'])) {
        $new_username = $_POST['changeUsername'];
        Database::getInstance()->request("UPDATE user SET $new_username WHERE id = $id_user;", false, false);
    }
    if (isset($_POST['changeEmail'])) {

    }
    if (isset($_POST['changePassword'])) {

    }
    include("./view/account.php");
}

?>
