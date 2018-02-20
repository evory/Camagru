<link rel="stylesheet" href="../view/css/style.css">

<head>
    <meta charset="utf-8">
    <title>Account</title>
</head>
<div class="account_page">
    <?=$message ?>
    <h1>Manage your account <?=$log_username ?></h1>
    <form class="form" action="" method="post">
        <h2>change your username</h2>
        Username : <input type="text" name="new_username"><br><br>
        <input type="submit" name="changeUsername" value="ok">
    </form>
    <form class="form" action="" method="post">
        <h2>change your email address</h2>
        New Email : <input type="text" name="new_email"><br><br>
        <input type="submit" name="changeEmail" value="ok">
    </form>
    <form class="form" action="" method="post">
        <h2>change your password</h2>
        Password : <input type="text" name="old_password"><br><br>
        New password : <input type="text" name="new_password"><br><br>
        confirm new password : <input type="text" name="confirm_new_password"><br><br>
        <input type="submit" name="changePassword" value="ok">
    </form>
</div>
