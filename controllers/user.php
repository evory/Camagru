<?php

require_once('./models/user_infos.php');
require_once('./models/Database.class.php');

/*----------------------------------LOGIN-------------------------------------*/

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
            $hash_user_db = Database::getInstance()->request("SELECT hash
                                                              FROM user
                                                              WHERE username = '$username';",
                                                              false, false);
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

/*-----------------------------------LOGOUT-----------------------------------*/

if ($action == "logout")
{
    session_destroy();
    header("Location:/");
}

/*-----------------------------------SIGNIN-----------------------------------*/

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
            Database::getInstance()->request("INSERT INTO `user` (`id`, `email`, `username`, `hash`)
                                              VALUES (NULL, '$email', '$username', '$hash');",
                                              false, false);
            $message = "Bienvenue $username !";
            // $email = new Email();
            // $email->welcomeEmail($user_email);
        }
    }
    include("./view/header.php");
    include("./view/signin.php");
    include("./view/footer.php");
}

/*---------------------------------ACCOUNT------------------------------------*/

if ($action == "account") {
/*-----------Username-----------*/
    if (isset($_POST['new_username'])) {
        if (empty($_POST['new_username'])) {
            include("./view/header.php");
            $message = "Username is empty";
            include("./view/account.php");
            include("./view/footer.php");
            exit();
        }
        if (Database::getInstance()->verify_duplicates($login_db, $_POST['new_username'])) {
            include("./view/header.php");
            $message = "Username already taken";
            include("./view/account.php");
            include("./view/footer.php");
            exit();
        }
        $new_username = $_POST['new_username'];
        Database::getInstance()->request("UPDATE `user`
                                          SET `username` = '$new_username'
                                          WHERE `user`.`id` = '$user_id';",
                                          false, false);
        $_SESSION['login'] = $new_username;
    }

/*------------Email------------*/
    if (isset($_POST['new_email'])) {
        if (empty($_POST['new_email'])) {
            include("./view/header.php");
            $message = "Email field is empty";
            include("./view/account.php");
            include("./view/footer.php");
            exit();
        }
        if (Database::getInstance()->verify_duplicates($email_db, $_POST['new_email'])) {
            include("./view/header.php");
            $message = "Email already exists";
            include("./view/account.php");
            include("./view/footer.php");
            exit();
        }
        $new_email = $_POST['new_email'];
        Database::getInstance()->request("UPDATE `user`
                                          SET `email` = '$new_email'
                                          WHERE `user`.`id` = '$user_id';",
                                          false, false);
    }

/*----------Password-----------*/


    if ($_POST['changePassword'] == "ok") {
        if (($_POST['new_password'] !== $_POST['confirm_new_password'])) {
            include("./view/header.php");
            $message = "Password don't match";
            include("./view/account.php");
            include("./view/footer.php");
            exit();
        }
        if (empty($_POST['old_password'])) {
            include("./view/header.php");
            $message = "Old password filed is empty";
            include("./view/account.php");
            include("./view/footer.php");
            exit();
        }

        $hash_user_db = Database::getInstance()->request("SELECT hash
                                                          FROM user
                                                          WHERE username = '$username';",
                                                          false, false);
        if ((password_verify($_POST['old_password'], $hash_user_db['hash'])) == FALSE) {
            include("./view/header.php");
            $message = "Old password dosen't match";
            include("./view/account.php");
            include("./view/footer.php");
            exit();
            }
        $new_hash = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        Database::getInstance()->request("UPDATE `user`
                                          SET `hash` = '$new_hash'
                                          WHERE `user`.`id` = '$user_id';",
                                          false, false);
        $message = "Password has been updated";
    }

    include("./view/header.php");
    include("./view/account.php");
    include("./view/footer.php");
}

/*---------------------------------MAIL-SIGNIN--------------------------------*/

/*-------------------------------FORGOT PASSWORD------------------------------*/






?>
