<?php

require('./models/user_infos.php');
require('./models/check_database.class.php');

/*-------------------------LOGIN-------------------------*/

if ($action == "login")
{
    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        if ($username && $password) {
            $check_database = new CheckDatabase;


            //
            // $login_dup = $check_database->verify_duplicates($login_array, $_POST['username'], "username");
            // if ($login_dup == 0)
            // {
            //     include("./view/header.php");
            //     $message =  "Username or password incorrect";
            //     include("./view/signin.php");
            //     include("./view/footer.php");
            //     die();
            // }



            if (password_verify($_POST['password'], $hash)) {
                echo 'Le mot de passe est valide !';
            } else {
                echo 'Le mot de passe est invalide.';
            }






            $_SESSION['login'] = $username;
            // echo "Bienvenue $username !";
            // }
        }
        else {
            $message = "Wrong ID";
        }
    }
    if(isset($_SESSION['login']))
    {
        // header("Location:/");
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

// print_r($login_db);
if ($action == "signin")
{
    if (isset($_POST['submit'])) {
        if ($_POST['password'] == $_POST['confirm_password']) {
            $check_database = new CheckDatabase;
            $login_dup = $check_database->verify_duplicates($login_array, $_POST['username'], "username");
            if ($login_dup == 1)
            {
                include("./view/header.php");
                $message =  "Username already taken ";
                include("./view/signin.php");
                include("./view/footer.php");
                die();
            }

            $email_dup = $check_database->verify_duplicates($email_array, $_POST['email'], "email");
            if ($email_dup == 1)
            {
                include("./view/header.php");
                $message = "Email already exists";
                include("./view/signin.php");
                include("./view/footer.php");
                die();
            }

            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            if ($username && $password && $email) {
                $_SESSION['email'] = $email;
                $_SESSION['login'] = $username;
                $req_prep = $db->prepare("INSERT INTO user (email, username, hash) VALUES (:email, :username, :hash)");
                $req_prep->bindParam(':username', $username);
                $req_prep->bindParam(':email', $email);
                $req_prep->bindParam(':hash', $password);
                $req_prep->execute();
                $message = "Bienvenue $username !";
                // ENVOYER EMAIL
            }
        }
    }
    include("./view/header.php");
    include("./view/signin.php");
    include("./view/footer.php");
}
    // if(isset($_SESSION['login'])) {
    //     header("Location:/");
    // }

/*------------------------ACCOUNT--------------------------*/

if ($action == "account") {
    include("./view/account.php");
}

?>
