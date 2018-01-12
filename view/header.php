<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="view/css/style.css">
		<title>Camagru</title>
	</head>
	<body>
<div class="header_background">
</div>
<div class="header">
    <div class="header_accueil">
        <h1><a href="/">Camagru</a></h1>
    </div>
    <div class="header_menu">
        <li class="header_menu_btn"><a href="gallery.php">Gallery</a></li>
        <li class="header_menu_btn"><a href="/user/account">Account</a></li>
        <?php
        if (!$_SESSION['login'] || $_SESSION['login'] == '') {
            echo '<li class="header_menu_btn"><a href="/user/login">Log in</a></li>';
            echo '<li class="header_menu_btn"><a href="/user/signin">Sign in</a></li>';
        }
        else {
            echo '<li class="header_menu_btn"><a href="/user/logout">Log out</a></li>';
        }
        ?>
    </div>
</div>
