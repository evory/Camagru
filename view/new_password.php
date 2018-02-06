<link rel="stylesheet" href="../view/css/style.css">

<head>
    <meta charset="utf-8">
    <title>New Password</title>
</head>
<div class="account_page">
    <?=$message ?>
    <form class="form" action="" method="post">
        <h1>Enter your username and a new password</h1>
        New password : <input class="input_case" type="password" name="new_password"><br><br>
        Confirm Password : <input class="input_case" type="password" name="confirm_new_password"><br><br>
            <input type="submit" name="new_recovery_password" value="ok">
    </form>
</div>
