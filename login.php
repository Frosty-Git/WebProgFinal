<?php
// Start the session
session_start();

require_once('./scripts/constants.php');
?>
<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml' lang='en'>
<head>
    <title> Games! </title>
    <meta charset='utf-8' />
    <meta name='Author' content='Joseph Frost, Katie Lee, Marc Colin, Jacelynn Duranceau' />
    <meta name='generator' content='VS Code' />
    <link rel='shortcut icon' href='' />
</head>
<body>
    <form action='./processLogin.php' method='post'>
        <fieldset>
        <legend>Login</legend>
        <table>
            <tr>
                <td> Type in your username: </td>
                <td> <input name='username' type='text' /> </td>
            </tr>
            <tr>
                <td> Type in your password: </td>
                <td> <input name='password' type='password' /> </td>
            </tr>
        </table>
        </fieldset>
        <p>
            <input type='submit' />
        </p>
    </form>

    <?php
    if ($_SESSION["user_id"] == FAILED_LOGIN) {
        echo "<p style='color: red;'>Incorrect Username or Password. 
            Please try again.</p>";
    }
    ?>
</body>
</html>