<!DOCTYPE html>
<link rel="stylesheet" href="../view/css/style.css">
        <title>login</title>
    <body>
        <form class="form" action="" method="post">
            <?=$message ?>
            <h1>Sign in</h1>
            Email : <input class="input_case" type="email" name="email"><br><br>
            Username : <input class="input_case" type="text" name="username"><br>
            Special characters not allowed (Only letter or numbers)<br><br>
            Password : <input pattern=".{6,}" required title="6 characters at least" class="input_case" type="password" name="password"><br><br>
            You password need to contain : <br>
            - 6 characters <br>
            - 1 lowercase character (a-z) ;<br>
            - 1 uppercase character (A-Z) ;<br>
            - 1 number (0-9) ;<br>
            - 1 special character (#, @, &...)<br><br>
            Confirm Password : <input class="input_case" type="password" name="confirm_password"><br><br>
            <input class="form_btn" type="submit" name="submit" value="ok">
        </form>
