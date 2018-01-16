<?php

require('./models/user.php');
/*-------------------LOGIN-------------------*/

if ($action == "login")
{
    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if ($username && $password) {
            // if (comparer %username a la base de donnee) {
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

/*-------------------LOGOUT-------------------*/

if ($action == "logout")
{
    session_destroy();
    // header("Location:/");
}

/*-------------------SIGNIN-------------------*/

if ($action == "signin")
{
    if (isset($_POST['submit'])) {
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = ($_POST['password']);
        if ($username && $password && $email) {
            // if (comparer %username et $email a la base de donnee, si existe deja, tej le mec) {
            // CREER USER DANS LA BASE DE DONNEE
            // ENVOYER EMAIL
            $_SESSION['email'] = $email;
            $_SESSION['login'] = $username;
            $req_prep = $db->prepare("INSERT INTO user(email, username, hash) VALUES (:email, :username, :hash)");
            $req_prep->bindParam(':username', $username);
            $req_prep->bindParam(':email', $email);
            $req_prep->bindParam(':hash', $password);
            $req_prep->execute();

            // $req_prep->execute();
            // $message "Bienvenue $username !";
            // }
        } else {
            $message = "Please fill all fields";
        }
    }
    // if(isset($_SESSION['login'])) {
    //     header("Location:/");
    // }
    include("./view/header.php");
    include("./view/signin.php");
    include("./view/footer.php");
}

if ($action == "account") {
    include("./view/account.php");
}

?>
