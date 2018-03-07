<?php


/*
* Gestion des emails
*/

class Email {
    function __construct() {

    }

    public function welcomeEmail($to, $confirm_token, $new_user) {
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $welcome_email = "welcome on camagru ! <a href=\"http://localhost:8080/user/confirm_account?confirm_token=$confirm_token&new_user=$new_user&new_user_email=$to\">Confirm your account</a>";
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
                Please click this link to </br><a href=\"http://localhost:8080/user/new_password?htoken=$htoken\">recover your password</a>
            </div>";
        if(mail($to, 'Camagru recover password', $forgotPasswordEmail, $headers)) {
            $message = "Email envoyé avec succès.";
            return ($message);
        } else {
            $message = "Email non envoyé";
            return ($message);
        }
    }

    public function newCommentEmail($to, $from) {
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $newCommentNotif = "$from commented your picture";
        mail($to, 'New comment', $newCommentNotif, $headers);
    }
}
