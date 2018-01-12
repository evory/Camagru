<?
session_start();
if(!isset($_SESSION['login'])) {
  echo '<h1>Vous n\'êtes pas connecté, accés interdit !</h1> <meta content="0; URL=index.php"> ';
}

// http-equiv="refresh"
?>
