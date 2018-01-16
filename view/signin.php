<!DOCTYPE html>
<link rel="stylesheet" href="../view/css/style.css">
        <title>login</title>
    <body>
        <form class="form" action="" method="post">
            <?=$message ?>
            <h1>Sign in</h1>
            Email : <input class="input_case" type="email" name="email"><br><br>
            Username : <input class="input_case" type="text" name="username"><br><br>
            Password : <input class="input_case" type="password" name="password"><br><br>
            Confirm Password : <input class="input_case" type="password" name="confirm_password"><br><br>
            <input class="form_btn" type="submit" name="submit" value="ok">
        </form>
