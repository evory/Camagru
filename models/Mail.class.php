<?php


/*
* Gestion des emails
*/

class Email {
    function __construct() {

    }

    public function welcomeEmail($to) {
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $welcome_email = "welcome on camagru ! <a href=\"http://localhost:8081\">Return to the website</a>";
        if(mail($to, 'Welcome on Camagru !', $welcome_email, $headers)){
            $message = "Email envoyé avec succès.";
        } else {
            $message = "Email non envoyé";
        }
    }

    public function forgotPasswordEmail($to, $htoken) {
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $forgotPasswordEmail = "
            <div style='
                    height: 55px;
                    line-height: 52px;
                    width: 100%;
                    text-align: center;
                    padding-top: 10px;'>
            <h1 style='font-family: Verdana'>Camagru</h1>
            </div>
            <div style='
                text-align: center;
                width: 100%;
                padding-top: 20px;'>
                Please click this link to </br><a href=\"http://localhost:8081/user/new_password?htoken=$htoken\">recover your password</a>
            </div>";
        if(mail($to, 'Camagru recover password', $forgotPasswordEmail, $headers)) {
            $message = "Email envoyé avec succès.";
            return ($message);
        } else {
            $message = "Email non envoyé";
            return ($message);
        }
    }
}
