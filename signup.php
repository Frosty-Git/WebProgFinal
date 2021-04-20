<?php
// Start the session
session_start();

// Yoink imports
require_once('./scripts/constants.php');
?>

<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml' lang='en'>
<head>
    <title>Sign Up</title>
    <meta charset='utf-8' />
    <meta name='Author' content='Joseph Frost, Katie Lee, Marc Colin, Jacelynn Duranceau' />
    <meta name='generator' content='VS Code' />
    <link rel='shortcut icon' href='' />
</head>
<body>
    <form enctype="multipart/form-data" action='./processSignup.php' method='post'>
        <fieldset>
        <legend>Sign Up</legend>
        <table>
            <tr>
                <td>Username:</td>
                <td> <input name='username' type='text' /> </td>
            </tr>
            <tr>
                <td>Password:</td>
                <td> <input name='password' type='password' /> </td>
            </tr>
            <!-- <tr>
                <td>Picture:</td>
                <td> <input name="picture" type="file"> </td>
            </tr> -->
        </table>
        </fieldset>
        <p>
            <input type='submit' />
        </p>
    </form>

    <?php
    if ($_SESSION["user_id"] == FAILED) {
        echo "<p style='color: red;'>Username taken... 
            Please try again.</p>";
    }
    ?>

</body>
</html>