<?php


$destinataire = 'adresse@fai.com';
// Pour les champs $expediteur / $copie / $destinataire, séparer par une virgule s'il y a plusieurs adresses
$expediteur = 'adresse@fai.com';
$copie = 'adresse@fai.com';
$copie_cachee = 'adresse@fai.com';
$objet = 'Test'; // Objet du message
$headers  = 'MIME-Version: 1.0' . "\n"; // Version MIME
$headers .= 'Reply-To: '.$expediteur."\n"; // Mail de reponse
$headers .= 'From: "Nom_de_expediteur"<'.$expediteur.'>'."\n"; // Expediteur
$headers .= 'Delivered-to: '.$destinataire."\n"; // Destinataire
$message = 'Hello World!';
if (mail($destinataire, $objet, $message, $headers)) // Envoi du message
{
    echo 'Votre message a bien été envoyé ';
}
else
{
    echo "Votre message n'a pas pu être envoyé";
}
?>
