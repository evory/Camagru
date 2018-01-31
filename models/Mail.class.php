<?php

/**
 * Gestion des emails
 */
class Email
{
public $expeditor = "";
    // function __construct(argument)
    // {
    // }

    public function welcomeEmail($to) {

        $welcome_subject = "Welcome to Camagru";
        $welcome_message = "test!";

        $headers  = 'MIME-Version: 1.0' . "\n";
        $headers .= 'From: "Camagru"<'.$expediteur.'>'."\n"; // Expediteur
        $headers .= 'Reply-To: '.$expediteur."\n"; // Mail de reponse
        $headers .= 'Delivered-to: '.$to."\n"; // Destinataire
        $headers .= "Content-Type: text/html; charset=\"ISO-8859-1"."\n";

        echo $headers;
        if(mail($to, $welcome_subject, $welcome_message, $headers)){
            echo "Email envoyé avec succès.";
        } else {
            echo "Email non envoyé";
        }
    }
}
