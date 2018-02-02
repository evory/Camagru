<?php


/*
* Gestion des emails
*/

class Email {
    function __construct() {

    }

    public function welcomeEmail($to) {
        $welcome_email = "Bienvenue sur mon super site !";
        if(mail($to, 'Welcome to Camagru !', $welcome_email)){
            echo "Email envoyé avec succès.";
        } else {
            echo "Email non envoyé";
        }
    }

    public function forgotPasswordEmail($to) {
        $forgotPasswordEmail = "<a>"
        if(mail($to, 'test', 'test')){
            echo "Email envoyé avec succès.";
            return (1);
        } else {
            echo "Email non envoyé";
            return (0);
        }
    }
}
