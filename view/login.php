<!DOCTYPE html>
<link rel="stylesheet" href="../view/css/style.css">
<html>
    <head>
        <meta charset="utf-8">
        <title>login</title>
    </head>
    <body>
        <form class="form" action="" method="post">
            <?= ($message)?$message:''; ?>
            <h1>Login</h1>
            Username : <input type="text" name="username"><br><br>
            Password : <input type="password" name="password"><br><br>
            <input type="submit" name="submit" value="ok">
        </form>
    </body>
</html>
