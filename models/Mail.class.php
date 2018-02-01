<?php


/**
 * Gestion des emails
 */
class Email {


    function __construct() {
        print_r(file_get_contents("welcome_mail.php"));
    }

    public function welcomeEmail($to) {
        if(mail($to, 'Welcome to Camagru !', file_get_contents("welcome_mail.php"))){
            echo "Email envoyé avec succès.";
            return (1);
        } else {
            echo "Email non envoyé";
            return (0);
        }
    }
    public function forgotPasswordEmail($to) {
        if(mail($to, 'test', 'test')){
            echo "Email envoyé avec succès.";
            return (1);
        } else {
            echo "Email non envoyé";
            return (0);
        }
    }
}
