<?php

require_once('./models/user_infos.php');
require_once('./models/Database.class.php');
require_once('./models/Mail.class.php');

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
            $field = ['username' => $username];
            $check_conf_token = Database::getInstance()->request("SELECT confirm_token
                                                                  FROM user
                                                                  WHERE username = :username;",
                                                                  $field, false);
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
            $field = ['username' => $username];
            $hash_user_db = Database::getInstance()->request("SELECT hashh
                                                              FROM user
                                                              WHERE username = :username;",
                                                              $field, false);
        }
        if ($username && password_verify($_POST['password'], $hash_user_db['hashh'])) {
            if (Database::getInstance()->verify_duplicates($login_db, $username) == 0) {
                include("./view/header.php");
                $message = "Wrong username";
                include("./view/login.php");
                include("./view/footer.php");
                exit();
            }
            // else if (!empty($check_conf_token['confirm_token'])) {
            //     include("./view/header.php");
            //     $message = "Please verify your email";      verif email         A DECOMMENTER
            //     include("./view/login.php");
            //     include("./view/footer.php");
            //     exit();
            // }
            else {
                $_SESSION['login'] = $username;
            }
        }
        else {
            $message = "Password or username is wrong !";
        }
    }
    include("./view/header.php");
    include("./view/login.php");
    include("./view/footer.php");
}

/*-----------------------------------LOGOUT-----------------------------------*/

if ($action == "logout") {
    session_destroy();
    header("Location:/");
}

/*-----------------------------------SIGNIN-----------------------------------*/

if ($action == "signin") {
    if (isset($_POST['submit'])) {      
/*-------check-if-empty-email-------*/
        if (empty($_POST['email'])) {
            include("./view/header.php");
            $message = "Email is empty";
            include("./view/signin.php");
            include("./view/footer.php");
            exit();
        }
/*-------check-if-email-exist-------*/
        if (Database::getInstance()->verify_duplicates($email_db, $_POST['email'])) {
            include("./view/header.php");
            $message = "Email already exists";
            include("./view/signin.php");
            include("./view/footer.php");
            exit();
        }
/*------check-if-empty-username-------*/
        if (empty($_POST['username'])) {
            include("./view/header.php");
            $message = "Username is empty";
            include("./view/signin.php");
            include("./view/footer.php");
            exit();
        }
/*-------check-if-username-exist-------*/
        if (Database::getInstance()->verify_duplicates($login_db, $username)) {
            include("./view/header.php");
            $message = "Username already taken";
            include("./view/signin.php");
            include("./view/footer.php");
            exit();
        }
/*-------check-special-char-username-------*/    
        if (preg_match('#^(?=.*\W)#', $_POST['username'])) {
            include("./view/header.php");
            $message = "Special characters not allowed";
            include("./view/signin.php");
            include("./view/footer.php");
            exit();
        }
/*---------check-if-empty-pass---------*/
        if (empty($_POST['password'])) {
            include("./view/header.php");
            $message = "Password field is empty";
            include("./view/signin.php");
            include("./view/footer.php");
            exit();
        }
        if (!preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)#', $_POST['password'])) {
            include("./view/header.php");
            $message = "Wrong password syntax";
            include("./view/signin.php");
            include("./view/footer.php");
            exit();
        }
/*-----------check-pass-match----------*/
        if (($_POST['password'] !== $_POST['confirm_password'])) {
            include("./view/header.php");
            $message = "Password don't match";
            include("./view/signin.php");
            include("./view/footer.php");
            exit();
        }
        $email = $_POST['email'];
        $hashh = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $confirm_token = hash("md5", time());
        $username = $_POST['username']; 
        $send_email = new Email();
        $send_email->welcomeEmail($_POST['email'], $confirm_token, $username);
        
        $field = ['email' => $email, 'username' =>$username, 'hashh' => $hashh, 'confirm_token' => $confirm_token];
        
        Database::getInstance()->request("INSERT INTO `user` (`id`, `email`, `username`, `hashh`, `htoken`, `confirm_token`)
                                          VALUES (NULL, :email, :username, :hashh, NULL, :confirm_token);",
                                          $field, false);

        $message = "An email as been send to your your email address, please confirm your address to continue";
    }
    include("./view/header.php");
    include("./view/signin.php");
    include("./view/footer.php");
}

/*---------------------------CONFIRM-ACCOUNT----------------------------------*/

if ($action == "confirm_account") {
    if ((Database::getInstance()->verify_duplicates($confirm_token_db, $_GET['confirm_token'])) == 1) {
/*---------select-id-token---------*/
    $confirm_token = $_GET['confirm_token'];
    $confirm_token_user_id = current(Database::getInstance()->request("SELECT `id`
                                                               FROM `user`
                                                               WHERE `user`.`confirm_token` = '$confirm_token';",
                                                               false, false));
/*---------delete-token---------*/
    Database::getInstance()->request("UPDATE `user`
                                      SET `confirm_token` = NULL
                                      WHERE `user`.`id` = '$confirm_token_user_id'",
                                      false, false);
    }
    include("./view/header.php");
    include("./view/confirm_account.php");
    include("./view/footer.php");
}

/*---------------------------------ACCOUNT------------------------------------*/

if ($action == "account") {
    $log_username = $_SESSION['login'];
/*----------change-username---------*/
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
        $old_username = $_SESSION['login'];
        $new_username = $_POST['new_username'];
        $field = ['new_username' => $new_username];
        Database::getInstance()->request("UPDATE `user`
                                          SET `username` = :new_username
                                          WHERE `user`.`id` = '$user_id';",
                                          $field, false);
/*----change-username-in-all-db----*/
        Database::getInstance()->request("UPDATE `pictures`
                                          SET `username` = :new_username
                                          WHERE `pictures`.`username` = '$old_username';",
                                          $field, false);
        Database::getInstance()->request("UPDATE `likes`
                                          SET `username` = :new_username
                                          WHERE `likes`.`username` = '$old_username';",
                                          $field, false);
        Database::getInstance()->request("UPDATE `comments`
                                          SET `username` = :new_username
                                          WHERE `comments`.`username` = '$old_username';",
                                          $field, false);
        $_SESSION['login'] = $new_username;
    }

/*------------change-email------------*/
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
        $field = ['new_email' => $new_email];
        Database::getInstance()->request("UPDATE `user`
                                          SET `email` = :new_email
                                          WHERE `user`.`id` = '$user_id';",
                                          $field, false);
    }

/*--------change-Password--------*/
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

        $hash_user_db = Database::getInstance()->request("SELECT hashh
                                                          FROM user
                                                          WHERE username = '$username';",
                                                          false, false);
        if ((password_verify($_POST['old_password'], $hash_user_db['hashh'])) == false) {
            include("./view/header.php");
            $message = "Old password dosen't match";
            include("./view/account.php");
            include("./view/footer.php");
            exit();
            }
        $new_hashh = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        $field = ['new_hashh' => $new_hashh];
        Database::getInstance()->request("UPDATE `user`
                                          SET `hashh` = :new_hashh
                                          WHERE `user`.`id` = '$user_id';",
                                          false, false);
        $message = "Password has been updated";
    }
    include("./view/header.php");
    include("./view/account.php");
    include("./view/footer.php");
}

/*-----comment-email-option-------*/
    if ($_POST['emailNotif'] == ok) {
        if ($_POST['yes'] == 1) {
            Database::getInstance()->request("UPDATE `user`
                                              SET `commentemail` = 1
                                              WHERE `user`.`id` = '$user_id';",
                                              false, false);
        }
        if ($_POST['no'] == 1) {
            Database::getInstance()->request("UPDATE `user`
                                              SET `commentemail` = 0
                                              WHERE `user`.`id` = '$user_id';",
                                              false, false);
        }
    }

/*-------------------------------FORGOT-PASSWORD------------------------------*/
if ($action == "forgot_password") {
    if ($_POST['forgotPasswordEmail'] == "ok") {
        if (empty($_POST['forgot_password_email'])) {
            include("./view/header.php");
            $message = "Email filed is empty";
            include("./view/forgot_password.php");
            include("./view/footer.php");
            exit();
        }
        if ((Database::getInstance()->verify_duplicates($email_db, $_POST['forgot_password_email'])) == 0) {
            include("./view/header.php");
            $message = "Email dosen't exists";
            include("./view/forgot_password.php");
            include("./view/footer.php");
            exit();
        } else {
            $htoken = hash("md5", time());
            $user_email_forgot_pass = $_POST['forgot_password_email'];
            $send_email = new Email();
            $send_email->forgotPasswordEmail($_POST['forgot_password_email'], $htoken);
            Database::getInstance()->request("UPDATE `user`
                                              SET `htoken` = '$htoken'
                                              WHERE `user`.`email` = '$user_email_forgot_pass';",
                                              false, false);
        }
    }
    include("./view/header.php");
    include("./view/forgot_password.php");
    include("./view/footer.php");
}

/*-------------------------------NEW-PASSWORD------------------------------*/

if ($action == "new_password") {
    if ((Database::getInstance()->verify_duplicates($htoken_db, $_GET['htoken'])) == 1) {
        if ($_POST['new_recovery_password'] == "ok") {
            if (empty($_POST['new_password'])) {
                include("./view/header.php");
                $message = "new password is empty";
                include("./view/new_password.php");
                include("./view/footer.php");
                exit();
            }
/*---------check-syntax-pass---------*/
            if (!preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)#', $_POST['new_password'])) {
                include("./view/header.php");
                $message = "Wrong password syntax";
                include("./view/new_password.php");
                include("./view/footer.php");
                exit();
            }
/*---------check-pass-match---------*/
            if (($_POST['new_password'] !== $_POST['confirm_new_password'])) {
                include("./view/header.php");
                $message = "Passwords don't match";
                include("./view/new_password.php");
                include("./view/footer.php");
                exit();
            }
/*---------select-id-token---------*/
            $htoken = $_GET['htoken'];
            $field = ['htoken' => $htoken];
            $change_pass_id = current(Database::getInstance()->request("SELECT `id`
                                                               FROM `user`
                                                               WHERE `user`.`htoken` = :htoken;",
                                                               $field, false));
            $message = "Password has beed updated";
/*---------set-new-pass---------*/
            $new_hashh = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
            $field = ['new_hashh' => $new_hashh];
            Database::getInstance()->request("UPDATE `user`
                                              SET `hashh` = :new_hashh
                                              WHERE `user`.`htoken` = '$htoken';",
                                              $field, false);

/*---------delete-token---------*/
            Database::getInstance()->request("UPDATE `user`
                                              SET `htoken` = NULL
                                              WHERE `user`.`id` = '$change_pass_id';",
                                              false, false);
        }
    } else {
        echo "invalid token";
    }
    include("./view/header.php");
    include("./view/new_password.php");
    include("./view/footer.php");
}

if (empty($action)) {
    $_SESSION['$timestamp'] = "";
    header("Location: http://localhost:8080");
}
