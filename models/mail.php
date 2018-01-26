<?php

    require("./controllers/user.php");
    $from = "contact@camagru.com";
    $to = "$email";
    $subject = "Vérification PHP mail";
    $message = "PHP mail marche";
    $headers = "From:" . $from;


    mail($to,$subject,$message, $headers);

    echo "L'email a été envoyé.";
