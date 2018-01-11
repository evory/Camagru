<?php
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
        header("Location:/");
    }
    include("./view/header.php");
    include("./view/login.php");
    include("./view/footer.php");
}

if ($action == "logout")
{
    session_destroy();
    header("Location:/");
}


if ($action == "signin")
{

    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        if ($username && $password && $email) {
            // if (comparer %username a la base de donnee, si existe deja, tej le mec) {
            // CREER USER DANS LA BASE DE DONNEE
            // ENVOYER EMAIL
            $_SESSION['login'] = $username;
            // echo "Bienvenue $username !";
            // }
        }
        else {
            $message = "Please fill all fields";
        }

    }
    if(isset($_SESSION['login']))
    {
        header("Location:/");
    }
    include("./view/header.php");
    include("./view/signin.php");
    include("./view/footer.php");
}





?>
